@extends('layouts.app')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Customer</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('customers.index')}}" class="active">Customers</a></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>



<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @if( isset($errors) && count($errors) > 0 )
            <div class="col-md-12">
                <div class="alert alert-warning hide-msg">
                    @foreach($errors->all() as $error)
                    <p>{{$error}}</p>
                    @endforeach
                </div>
            </div>
            @endif
            <div class="card">



                <div class="card-header">
                    {{$title}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- general form elements disabled -->
                    <div class="box box-primary">
                        @if( isset($customer) )
                        {!! Form::model($customer, ['route' => ['customers.update', $customer->id], 'class' => 'form form-search form-ds', 'files' => true, 'method' => 'PUT']) !!}
                        @else
                        {!! Form::open(['route' => 'customers.store', 'class' => 'form form-search form-ds', 'files' => true]) !!}
                        @endif
                        <div class="box-body">
                            <div class="form-group">
                                <label>Name:</label>
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Document:</label>
                                {!! Form::text('document', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Status:</label>
                                {!! Form::select('status', $status, null, ['class' => 'form-control input-sm']) !!}
                            </div>
                        </div>


                        <div class="box-footer">
                            <div class="form-group">
                                {!! Form::submit('Enviar', ['class' => 'btn btn-success btn-sm']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Content Dinâmico-->

@endsection
@push('scripts')
<!-- include('painel.romaneio.expaded-menu') -->
@endpush