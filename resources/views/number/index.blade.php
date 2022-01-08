@extends('layouts.app')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Customer Add Number</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('customers.index')}}">Customers</a></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>


<div class="col-sm-12">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Add New Number for <b>{{$customer->id}} - {{strtoupper($customer->name)}}</b></h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            {!! Form::open(['id' => 'form_new_number' ]) !!}
            <input type="hidden" name="customer_id" value="{{$customer->id}}">
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

@if( Session::has('success') )
<div class="col-sm-12 hide-msg">
    <div class="alert alert-success" style="float: left; width: 100%; margin: 10px 0px;">
        {!! Session::get('success') !!}
    </div>
</div>
@endif

<div class="col-sm-12" id="mask_list_numbers"></div>
@endsection
@push('page_scripts')
<script>
    $(document).ready(function() {

        numbers("{{$customer->id}}")

    });

    function numbers(customer_id) {
        $('#modal_numbers').modal('show');

        var dados = {
            "customer_id": customer_id,
            "_token": "{{ csrf_token() }}"
        };

        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: "{{route('list.numbers',$customer->id)}}",

            beforeSend: function() {
                $('#mask_list_numbers').html('<center><img src={{url("img/loading.gif")}} ><br>Listando solicitações, aguarde...</center>');
            },

            async: true,
            data: dados,
            success: function(response) {

                $('#mask_list_numbers').html(response);

            }

        });

        return false;
    }

    $('#form_new_number').submit(function() {
        var dados = $('#form_new_number').serialize();
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: "{{route('numbers.store')}}",
            beforeSend: function() {
                $('#mask_list_numbers').html('<center><img src={{url("img/loading.gif")}} ><br>Listando solicitações, aguarde...</center>');
            },
            async: true,
            data: dados,
            success: function(response) {
                $('#mask_list_numbers').html(response);
            }
        });
        return false;
    });

    function excluirNumber(id) {
        Swal.fire({
            title: 'Do you want to delete?',
            text: "You cannot reverse this!",
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

                var rota = "{{ route('numbers.destroy', ':id') }}";
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
                        $("#card_line_" + id).remove();
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

@endpush('page_scripts')