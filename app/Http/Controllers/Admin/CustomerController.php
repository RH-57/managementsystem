<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
     public function index()
    {
        $customers = Customer::orderBy('id', 'desc')->get();

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Store a newly created customer.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email'   => 'nullable|email|max:255|unique:customers,email',
            'phone'   => 'nullable|string|max:30|unique:customers,phone',
            'address' => 'nullable|string',
        ]);

        Customer::create($request->all());

        return redirect()->back()->with('success', 'Customer created successfully!');
    }

    /**
     * Update the specified customer.
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name'    => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email'   => 'nullable|email|max:255|unique:customers,email,' . $customer->id,
            'phone'   => 'nullable|string|max:30|unique:customers,phone,' . $customer->id,
            'address' => 'nullable|string',
        ]);

        $customer->update($request->all());

        return redirect()->back()->with('success', 'Customer updated successfully!');
    }

    /**
     * Remove the specified customer.
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->back()->with('success', 'Customer deleted successfully!');
    }
}
