<?php
namespace App\Http\Controllers\WEB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfficeRequest;
use App\Models\Governorate;
use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get the authenticated user
        $user = auth()->user();

        // Retrieve the offices with filtering
        $offices = Office::query()
            ->byGovernorate($request->governorate)
            ->byCity($request->city)
            ->orderBy('created_at', 'desc')
            ->get();

        // Map through each office and add the 'is_favorite' attribute
        $offices = $offices->map(function ($office) use ($user) {
            $office->is_favorite = $user ? $user->favourites()->where('office_id', $office->id)->exists() : false;
            return $office;
        });

        // Get governorates and cities for the filter dropdowns
        $governorates = Governorate::pluck('name', 'id');
        $cities = Office::select('city')->distinct()->pluck('city');

        // Return JSON if requested
        if ($request->wantsJson()) {
            return response()->json([
                'offices' => $offices,
            ]);
        } else {
            // Otherwise, return the web view
            return view('offices.index', compact('offices', 'governorates', 'cities'));
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('offices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfficeRequest  $request)
    {

        $office = Office::create($request->all());
        return redirect()->route('offices.show', $office)->with('success', 'Office created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office)
    {
        $averageRating = $office->rates()->avg('rate');
        $employees=$office->employees()->get();
        return view('offices.show', compact('office','averageRating','employees'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office)
    {
        return view('offices.edit', compact('office'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOfficeRequest $request, Office $office)
    {
        $office->update($request->all());
        return redirect()->route('offices.show', $office)->with('success', 'Office updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        $office->delete();
        return redirect()->route('offices.index')->with('success', 'Office deleted successfully.');
    }

    public function OfficeLocation($id)
    {
        // Retrieve the latitude and longitude for the office with the given ID
        $office = Office::where('id', $id)->select('latitude', 'longitude')->first();
        if (!$office) {
            return response()->json([
                'success' => false,
                'message' => 'Office not found.',
            ], 404);
        }
        return $office;
    }
}
