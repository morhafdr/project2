<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTruckRequest;
use App\Http\Requests\UpdateTruckRequest;
use App\Models\Truck;

class TruckController extends Controller
{
    public function index()
    {
        $trucks = Truck::all();
        return view('trucks.index', compact('trucks'));
    }

    /**
     * Show the form for creating a new truck.
     */
    public function create()
    {
        return view('trucks.create');
    }

    /**
     * Store a newly created truck in storage.
     */
    public function store(StoreTruckRequest $request)
    {

        Truck::create($request->all());
        return redirect()->route('trucks.index')->with('success', 'Truck created successfully.');
    }

    /**
     * Display the specified truck.
     */
    public function show($id)
    {
        $truck = Truck::findOrFail($id);
        return view('trucks.show', compact('truck'));
    }

    /**
     * Show the form for editing the specified truck.
     */
    public function edit($id)
    {
        $truck = Truck::findOrFail($id);
        return view('trucks.edit', compact('truck'));
    }

    /**
     * Update the specified truck in storage.
     */
    public function update(UpdateTruckRequest $request, $id)
    {
        $truck = Truck::findOrFail($id);
        $truck->update($request->all());
        return redirect()->route('trucks.index')->with('success', 'Truck updated successfully.');
    }

    /**
     * Remove the specified truck from storage.
     */
    public function destroy($id)
    {
        $truck = Truck::findOrFail($id);
        $truck->delete();
        return redirect()->route('trucks.index')->with('success', 'Truck deleted successfully.');
    }
}
