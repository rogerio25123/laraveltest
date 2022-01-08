<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Gate;


class CustomerController extends Controller
{
    protected $totalPage = 5;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
        $this->status_customer = ['new'=>'new','active'=>'active','suspended'=>'suspended','cancelled'=>'cancelled'];
        $this->status = [ 'active'=>'active','inactive'=>'inactive','cancelled'=>'cancelled'];

    }

    public function index()
    {
        $customers = $this->customer->with('user')->orderBy('id', 'desc')->paginate($this->totalPage);
       
        return view("customer.index",[
            'title'     => 'Customers',
            'customers' => $customers,
            'status'    => $this->status

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (Gate::denies('create_customer'))
        //     abort(403);      
         
        return view("customer.create-edit",[
            'title' => 'Create Customer',
            'status'=> $this->status_customer
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        // if (Gate::denies('store_customer'))
        //     abort(403);
        $dataForm = $request->all();
        $insert = $this->customer->create($dataForm);

        if ($insert)
            return redirect()
                ->route("customers.index")
                ->with(['success' => 'Registration performed successfully!']);
        else
            return redirect()
                ->route("customers.create")
                ->withErrors(['errors' => 'Falha ao cadastrar!'])
                ->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {      

        $customer = $this->customer->find($id);
        if (Gate::denies('owner',$customer))
            abort(403);
        return view("customer.create-edit", [
            'title' => 'Edit Customer',
            'status'=> $this->status_customer,
            'customer'=> $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCustomerRequest $request, $id)
    {
        $dataForm = $request->all();
        $data = $this->customer->find($id);
        $update = $data->update($dataForm);

        if ($update)
            return redirect()
                ->route("customers.index")
                ->with(['success' => 'Record updated successfully!']);
        else
            return redirect()
                ->route("customers.edit", ['id' => $id])
                ->withErrors(['errors' => 'Falha ao editar'])
                ->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->customer->find($id);

        $delete = $data->delete();

        if ($delete)
            return true;
    }
}
