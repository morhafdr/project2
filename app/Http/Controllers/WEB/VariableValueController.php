<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\VariableValue;
use Illuminate\Http\Request;

class VariableValueController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $variableValues = VariableValue::where('weight','!=','null')->get();
        return view('keyValue.index', compact('variableValues'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('keyValue.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|string|max:255',
            'weight' => 'required|string|max:255',
        ]);

        VariableValue::create([
            'key' => 'PricePerKm',
            'value' => $request->value,
            'weight' => $request->weight,
        ]);
        return redirect()->route('variable-values.index')->with('success', 'Variable value created successfully.');
    }

    // Display the specified resource.
    public function show(VariableValue $variableValue)
    {
        return view('keyValue.show', compact('variableValue'));
    }

    // Show the form for editing the specified resource.
    public function edit(VariableValue $variableValue)
    {
        return view('keyValue.edit', compact('variableValue'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, VariableValue $variableValue)
    {
        $request->validate([
            'value' => 'required|string|max:255',
            'weight' => 'nullable|string|max:255',
        ]);

        $variableValue->update($request->all());
        return redirect()->route('variable-values.index')->with('success', 'Variable value updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy(VariableValue $variableValue)
    {
        $variableValue->delete();
        return redirect()->route('variable-values.index')->with('success', 'Variable value deleted successfully.');
    }
}
