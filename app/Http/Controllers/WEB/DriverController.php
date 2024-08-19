<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Http\Requests\UpdateTruckRequest;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::all();
        return view('drivers.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('drivers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDriverRequest $request)
    {

        $driver = Driver::create($request->all());

        return redirect()->route('drivers.index')->with('success', 'Driver created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        return view('drivers.show', compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        return view('drivers.edit', compact('driver'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDriverRequest $request, Driver $driver)
    {

        $driver->update($request->all());
        return redirect()->route('drivers.index')->with('success', 'Driver updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        $driver->delete();

        return redirect()->route('drivers.index')->with('success', 'Driver deleted successfully.');
    }

}
