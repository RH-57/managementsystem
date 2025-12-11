<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Component;
use App\Models\Unit;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    public function index()
    {
        $components = Component::with('unit')->orderBy('id', 'desc')->get();
        $units = Unit::orderBy('name')->get();

        return view('admin.components.index', compact('components', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'price' => 'required|numeric|min:0',
        ]);

        Component::create([
            'name' => $request->name,
            'unit_id' => $request->unit_id,
            'price' => $request->price,
        ]);

        return redirect()->back()->with('success', 'Component created successfully!');
    }

    public function update(Request $request, $id)
    {
        $component = Component::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'price' => 'required|numeric|min:0',
        ]);

        $component->update([
            'name' => $request->name,
            'unit_id' => $request->unit_id,
            'price' => $request->price,
        ]);

        return redirect()->back()->with('success', 'Component updated successfully!');
    }

    public function destroy($id)
    {
        Component::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Component deleted successfully!');
    }
}
