<?php

namespace App\Http\Controllers;

use App\Models\Laptop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaptopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laptops = Laptop::latest()->paginate(10);
        return view('laptops.index', compact('laptops'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('laptops.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'serial_number' => 'required',
            'status' => 'required',
        ]);

        Laptop::create($request->all());

        return redirect()->route('laptops.index')->with('success', 'Laptop created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $laptop = Laptop::findOrFail($id);
        return view('laptops.show', compact('laptop'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $laptop = Laptop::findOrFail($id);
        return view('laptops.edit', compact('laptop'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $laptop = Laptop::findOrFail($id);
        $laptop->update($request->all());
        return redirect()->route('laptops.index')->with('success', 'Laptop updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $laptop = Laptop::findOrFail($id);
        $laptop->delete();
        return redirect()->route('laptops.index')->with('success', 'Laptop deleted successfully.');
    }
}
