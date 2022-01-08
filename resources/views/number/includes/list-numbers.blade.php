<div class="row">
    <div class="col-sm-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">List Numbers</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if( Session::has('message') )
                <div class="col-sm-12 hide-msg">
                    <div class="alert alert-warning" style="float: left; width: 100%; margin: 10px 0px;">
                        {{ session()->get('message') }}
                    </div>
                </div>
                @endif
                <div class="row">
                    @foreach($customer->numbers as $number)
                    <div id="card_line_{{$number->id}}" class="col-md-6">
                        <div class="card {{$number->status=='inactive'?'card-danger': 'card-primary'}} collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">{{$number->number}} - {{$number->status}}</h3>

                                <div class="card-tools">
                                    <button onclick="excluirNumber('{{$number->id}}')" type="button" class="btn btn-tool">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="display: none;">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="card-body">
                                            @if( isset($number) )
                                            {!! Form::model($number, ['route' => ['numbers.update', $number->id], 'class' => 'form form-search form-ds', 'files' => true, 'method' => 'PUT']) !!}
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
                                                        <button style="margin-top: 30px;" type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                            @endif
                                        </div>
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Value</th>
                                                    <th style="width: 40px">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($number->number_preferences as $pref)
                                                <tr>
                                                    <td>{{$pref->name}}</td>
                                                    <td>{{$pref->value}}</td>
                                                    <td></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            setTimeout("$('.hide-msg').fadeOut();", 3000)
        });
    </script>