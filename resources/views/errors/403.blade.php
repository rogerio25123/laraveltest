@extends('layouts.app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <center>
            <h1><i style="color: #f95555" class="fa fa-ban red" aria-hidden="true"></i></h1>
          </center>
          <center>
            <h1>Access denied</h1>
          </center><br>
          <center>
            <p>Contact administrator.</p>
          </center>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <!-- general form elements disabled -->
          <div class="box box-primary">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')


@endpush