<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Cargo_manifest;
use App\Models\Incoming_good;
use App\Models\Order_detail;
use App\Models\Outdoing_good;
use App\Models\Trips;
use App\Services\TwilioService;
use Illuminate\Http\Request;

class TripsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }


public function index()
{
    // Check if the user is a superadmin
    if (auth()->user()->hasRole('superAdmin')) {
        // If the user is superadmin, show all trips
        $trips = Trips::all();
    } else {

        // If the user is an employee, show trips related to their office
        $officeId = auth()->user()->employee->office_id; // Assuming there is a relationship to get the employee
        $trips = Trips::where('from_office_id', $officeId)
            ->orWhere('to_office_id', $officeId)
            ->get();

    }

    // Return a view with the list of trips
    return view('trips.index', compact('trips'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return a view with a form to create a new trip
        return view('trips.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'truck_id' => 'required|exists:trucks,id',
            'from_office_id' => 'required|exists:offices,id',
            'to_office_id' => 'required|exists:offices,id',
            'status' => 'required|string|max:255',
            'distancePerKm'=>'required'
        ]);

        // Create a new trip in the database
        Trips::create($validated);

        // Redirect to the trips index with a success message
        return redirect()->route('trips.index')->with('success', 'تم الانشاء بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Trips $trip)
    {
        $cargo=$trip->cargoManifests()->get();
        // Return a view with the details of the specified trip
        return view('trips.show', compact('trip','cargo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trips $trip)
    {
        // Return a view with a form to edit the specified trip
        return view('trips.edit', compact('trip'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trips $trip)
    {
        // Validate the request data
        $validated = $request->validate([
            'truck_id' => 'required|exists:trucks,id',
            'from_office_id' => 'required|exists:offices,id',
            'to_office_id' => 'required|exists:offices,id',
            'status' => 'required|string|max:255',
            'distancePerKm'=>'required'
        ]);

        // Update the trip in the database
        $trip->update($validated);

        // Redirect to the trips index with a success message
        return redirect()->route('trips.index')->with('success', 'تم التحديث بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trips $trip)
    {
        // Delete the trip from the database
        $trip->delete();

        // Redirect to the trips index with a success message
        return redirect()->route('trips.index')->with('success', 'Trip deleted successfully.');
    }

    public function updateStatus(Request $request, Trips $trip)
    {


        // Validate the request data
        $validated = $request->validate([
            'status' => 'required|string|max:255',
        ]);
        // If the status is "جاهز", simply update the status without additional actions
        if ($validated['status'] === 'جاهز') {
            $trip->update(['status' => $validated['status']]);
            return redirect()->route('trips.index')->with('success', 'تم تحديث حالة الرحلة إلى "جاهز" بنجاح.');
        }
        $user = auth()->user();
        $role = $user->getRoleNames()->first();
        // Check if the status is "مرسل" and if the employee's office matches the trip's from_office

        if ( $role != 'superAdmin' && $validated['status'] === 'مرسل' && auth()->user()->employee->office_id == $trip->from_office_id) {
            // Check if the Cargo_manifest is empty
            $cargoManifests = Cargo_manifest::where('trip_id', $trip->id)->get();
            if ($cargoManifests->isEmpty()) {
                return redirect()->route('trips.index')->with('error', 'لا يمكنك تغيير الحالة إلى "مرسل" لأن قائمة الشحن فارغة.');
            }

            // Update the trip's status
            $trip->update(['status' => $validated['status']]);

            // Loop through the incoming goods and create entries in the outdoing_goods table
            foreach ($cargoManifests as $cargoManifest) {
                // Check if an entry with the same incoming_good_id does not exist in the outdoing_goods table
                $exists = Outdoing_good::where('incoming_good_id', $cargoManifest->incoming_good_id)->exists();
                // If it doesn't exist, create a new entry
                if (!$exists) {
                    Outdoing_good::create([
                        'incoming_good_id' => $cargoManifest->incoming_good_id,
                    ]);
                }
            }

            return redirect()->route('trips.index')->with('success', 'تم تحديث حالة الرحلة إلى "مرسل" بنجاح.');
        }

        // Check if the status is "مستلم" and if the employee's office matches the trip's to_office
        if ($role != 'superAdmin'&&$validated['status'] === 'مستلم' && auth()->user()->employee->office_id == $trip->to_office_id) {
            // Update the trip's status
            $trip->update(['status' => $validated['status']]);


            // Get all incoming goods associated with the trip
            $incomingGoods = Cargo_manifest::where('trip_id', $trip->id)->get();

            // Loop through the incoming goods and create new records with the updated warehouse_id
            foreach ($incomingGoods as $cargoManifest) {
                $incomingGood = Incoming_good::find($cargoManifest->incoming_good_id);
                if ($incomingGood) {
                    // Create a new Incoming_good with the updated warehouse_id (to_office_id)
                    Incoming_good::create([
                        'warehouse_id' => $trip->toOffice->wareHouse->id,
                        'price' => $incomingGood->price,
                        'order_id' => $incomingGood->order_id,
                        'good_name' => $incomingGood->good_name,
                        'quantity' => $incomingGood->quantity,
                        'weight' => $incomingGood->weight,
                        'status' => $incomingGood->status,
                    ]);

                    $order = $incomingGood->order;

                    $order->update([
                        'status' => 'مكتمل',
                    ]);
                    $phone = Order_detail::where('order_id',$order->id)->pluck('R_phone_number');
                    $office = $order->toOffice->city;
                  //  $this->twilioService->sendSMS('+963997448521' , "Office: شركة المحيط تبلغكم بوصول شحنة جديدة في المكتب $office");
                }
            }
            // Swap the from_office_id and to_office_id
            $from_id = $trip->from_office_id;
            $trip->update([
                'from_office_id' => $trip->to_office_id,
                'to_office_id' => $from_id
            ]);

            // Empty the Cargo_manifest table for this trip
            Cargo_manifest::where('trip_id', $trip->id)->delete();

            // Update the trip's status to "جاهز" after processing
            $trip->update(['status' => 'جاهز']);

            return redirect()->route('trips.index')->with('success', 'تم تحديث حالة الرحلة إلى "مستلم". تم نقل البضائع إلى المستودع الجديد، وتفريغ جدول Cargo_manifest، ووضع علامة على الرحلة كـ "جاهز".');
        }

        // If the office does not match or if the status is not "جاهز", "مرسل", or "مستلم", do not update the status
        return redirect()->route('trips.index')->with('error', 'أنت غير مصرح لك بتغيير حالة هذه الرحلة.');
    }


}
