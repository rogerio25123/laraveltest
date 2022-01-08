<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNumberRequest;
use App\Models\Customer;
use App\Models\Number;
use App\Models\NumberPreference;
use Illuminate\Http\Request;
use Gate;

class NumberController extends Controller
{
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
        $this->status = ['active' => 'active', 'inactive' => 'inactive', 'cancelled' => 'cancelled'];
    }

    public function numbers($customer_id)
    {


        $customer = $this->customer->with('numbers.number_preferences')->find($customer_id);

        if (Gate::denies('owner', $customer))
            abort(403);

        return view("number.index", [
            'status'   => $this->status,
            'customer' => $customer
        ]);
    }

    public function listNumbers($customer_id)
    {

        $customer = $this->customer->with('numbers.number_preferences')->find($customer_id);
        //dd($customer);             
        return view("number.includes.list-numbers", [
            'status'   => $this->status,
            'customer' => $customer
        ]);
    }

    public function store(Request $request)
    {

        $dataForm = $request->all();

        $number = Number::where('number', $request->number)
            ->where('customer_id', $request->customer_id)->get();

        if ($number->count() > 0) {
            session()->flash('message', 'This number is registered!');
            return $this->listNumbers($request->customer_id);
        } {
            session()->forget('message');
            $insert   =  Number::create($dataForm);
            $preferece['number_id'] = $insert->id;
            $preferece['name']      = 'auto_attendant';
            $preferece['value']     = 1;
            NumberPreference::create($preferece);
            $preferece1['number_id'] = $insert->id;
            $preferece1['name']      = 'voicemail_enabled';
            $preferece1['value']     = 1;
            NumberPreference::create($preferece1);
            if ($insert)
                return $this->listNumbers($request->customer_id);
        }
    }


    public function update(Request $request, $id)
    {
        $dataForm = $request->all();
        $data = Number::find($id);
            $update = $data->update($dataForm);
            if ($update)
                return redirect()
                    ->route("customer.numbers", ['id' => $request->customer_id])
                    ->with(['success' => 'Record updated successfully!']);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Number  $number
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Number::find($id);

        $delete = $data->delete();

        if ($delete)
            return true;
    }
}
