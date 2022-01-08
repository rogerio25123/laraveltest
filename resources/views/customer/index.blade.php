@extends('layouts.app')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Customers</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Customer</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="container-fluid">
    <div class="row">
        @if( Session::has('success') )
        <div class="alert alert-success hide-msg" style="float: left; width: 100%; margin: 10px 0px;">
            {!! Session::get('success') !!}
        </div>
        @endif
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{route('customers.create')}}" class="btn btn-success btn-sm">
                        <i class="fa fa-file" aria-hidden="true"></i>
                        New Customer
                    </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>User</th>
                                <th>Name</th>
                                <th>Document</th>
                                <th>Status</th>
                                <th style="width: 40px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                            <tr id="line_{{$customer->id}}">
                                <td>{{$customer->id}}</td>
                                <td>{{$customer->user->name}}</td>
                                <td>{{$customer->name}}</td>
                                <td>{{$customer->document}}</td>
                                <td>{{$customer->status}}</td>
                                <td width="10%">

                                    <a href="{{route('customers.edit', $customer->id)}}" class="btn btn-success btn-xs">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @can('owner', $customer)
                                    <a onclick="excluir('{{$customer->id}}')" class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{route('customer.numbers', $customer->id)}}" class="btn btn-primary btn-xs">
                                        <i class="fas fa-phone-square-alt"></i>
                                    </a>
                                    @else

                                    <a onclick="#" class="btn btn-danger btn-xs disabled">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                    <a onclick="#" class="btn btn-primary btn-xs disabled">
                                        <i class="fas fa-phone-square-alt"></i>
                                    </a>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <p>Nenhuma item</p>
                            @endforelse
                        </tbody>
                    </table>
                </div>


                @if (isset($customers) && $customers->lastPage() > 1)
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                        <?php
                        $interval = isset($interval) ? abs(intval($interval)) : 3;
                        $from = $customers->currentPage() - $interval;
                        if ($from < 1) {
                            $from = 1;
                        }

                        $to = $customers->currentPage() + $interval;
                        if ($to > $customers->lastPage()) {
                            $to = $customers->lastPage();
                        }
                        ?>

                        <!-- first/previous -->
                        @if($customers->currentPage() > 1)
                        <li class="page-item"><a class="page-link" href="{{ $customers->url(1) }}">«</a></li>
                        <li class="page-item"><a class="page-link" href="{{ $customers->url($customers->currentPage() - 1) }}">‹</a></li>
                        @endif
                        <!-- links -->
                        @for($i = $from; $i <= $to; $i++) <?php
                                                            $isCurrentPage = $customers->currentPage() == $i;
                                                            ?> <li class="page-link {{ $isCurrentPage ? 'active' : '' }}">
                            <a href="{{ !$isCurrentPage ? $customers->url($i) : '#' }}">
                                {{ $i }}
                            </a>
                            </li>
                            @endfor

                            <!-- next/last -->
                            @if($customers->currentPage() < $customers->lastPage())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $customers->url($customers->currentPage() + 1) }}" aria-label="Next">
                                        <span aria-hidden="true">›</span>
                                    </a>
                                </li>

                                <li class="page-item">
                                    <a class="page-link" href="{{ $customers->url($customers->lastpage()) }}" aria-label="Last">
                                        <span aria-hidden="true">»</span>
                                    </a>
                                </li>
                                @endif
                    </ul>
                </div>

                @endif
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->
    <!-- /.row -->
</div><!-- /.container-fluid -->
<!-- /.col -->

<div id="modal_numbers" class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Numbers</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Add New Number for <b id="customer_name"></b></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            {!! Form::open(['id' => 'form_new_number' ]) !!}
                            <input type="hidden" id="id_customer" name="customer_id">
                            <div class="row">
                                <div class="col-sm-5">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Number</label>
                                        {!! Form::text('number', null, ['class' => 'form-control input-sm']) !!}
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label>Status</label>
                                        {!! Form::select('status', $status, null, ['class' => 'form-control input-sm']) !!}
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label></label>
                                        <button style="margin-top: 30px;" type="submit" class="btn btn-primary">Add</button>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>

                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-sm-12" id="mask_list_numbers"></div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection
@push('page_scripts')
<script>


    function excluir(id) {
        Swal.fire({
            title: 'Do you want to delete?',
            text: "You cannot reverse this!!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {

            if (result.value) {

                var dados = {
                    "id": id,
                    "_token": "{{ csrf_token() }}"
                };

                var rota = "{{ route('customers.destroy', ':id') }}";
                // isso vai compilar o blade com o id sendo uma string ":id" e, no javascript, atribuir ela a uma variável .
                rota = rota.replace(":id", id);

                $.ajax({
                    type: 'DELETE',
                    dataType: 'html',
                    url: rota,
                    beforeSend: function() {
                        //$('#mascara_cliente').html('<center><img src={{url("img/loading.gif")}} ><br>Enviando solicitação, aguarde...</center>');
                    },
                    async: true,
                    data: dados,
                    success: function(response) {
                        $("#line_" + id).remove();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Record deleted successfully',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                });
                return false;
            }
        })
    }



</script>
@endpush