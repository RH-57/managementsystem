<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::orderBy('id', 'desc')->get();
        return view('admin.units.index', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:units,name',
            'symbol' => 'required|unique:units,symbol',
        ]);

        Unit::create($request->only(['name', 'symbol']));

        return redirect()->back()->with('success', 'Unit created successfully!');
    }

    public function update(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:units,name,' . $unit->id,
            'symbol' => 'required|unique:units,symbol,' . $unit->id,
        ]);

        $unit->update($request->only(['name', 'symbol']));

        return redirect()->back()->with('success', 'Unit updated successfully!');
    }

    public function destroy($id)
    {
        Unit::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Unit deleted successfully!');
    }
}
