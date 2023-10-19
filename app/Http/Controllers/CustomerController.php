<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return CustomerResource::collection($customers);
    }

    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    public function store(StoreCustomerRequest $request)
    {
        $validated = $request->validated();
        $customer = new Customer($validated);
        $customer->save();
        return new CustomerResource($customer);
    }
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $validated = $request->validated();
        $customer->update($validated);
        return new CustomerResource($customer);
    }


    public function destroy(Customer $customer)
    {
        $result = $customer->delete();
        if(!$result) {
            return response()->json(['message' => 'customer not found.'], 404);
        }
        return response()->json("", 204);
    }
}
