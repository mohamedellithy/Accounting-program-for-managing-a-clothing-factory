@extends('adminlte::page')

@section('title', 'تعديل العميل / الزبون')

@section('content_header')
    <h1> تعديل العميل / الزبون </h1>
@stop


@section('content')
    <!-- Main content -->

    <section class="content">
	    <div class="container-fluid">
	        <div class="row">
	            <!-- left column -->
	            <div class="col-md-12">
	            	@if($message = Session::get('success'))
		            	<div class="alert alert-warning alert-dismissible">
		                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                  <h5><i class="icon fas fa-check"></i> تمت</h5>
		                  {{ $message }}
		                </div>
		            @endif
		            <div class="" style="text-align: left !important;">
		                 <a href="{{ url('clients') }}" class="btn btn-info"> الرجوع </a>
		            </div>
		            <!-- general form elements -->
		            <div class="card card-primary">
		              <div class="card-header">
		                <h3 class="card-title">تعديل العملاء / الزبائن</h3>
		              </div>
		              <!-- /.card-header -->
		              <!-- form start -->


		              <form action="{{ url('clients/'.$client->id) }}" role="form" method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
		                <div class="card-body">
		                  <div class="form-group">
		                    <label for="exampleInputEmail1">اسم العميل / الزبون</label>
		                    <input name="client_name" value="{{ $client->client_name }}" type="name" class="form-control" id="exampleInputEmail1" placeholder="اسم العميل / الزبون">
		                  </div>
		                  <div class="form-group">
		                    <label for="exampleInputPassword1">رقم التليفون</label>
		                    <input name="client_phone" value="{{ $client->client_phone }}" type="phone" class="form-control" id="exampleInputPassword1" placeholder="رقم التليفون">
		                  </div>

		                </div>
		                <!-- /.card-body -->

		                <div class="card-footer">
		                  <button type="submit" class="btn btn-primary"> تعديل العميل / الزبون </button>
		                </div>
		              </form>

		            </div>
		            <!-- /.card -->

	            </div>
	        </div>
	    </div>
    </section>
@stop

@section('css')
    <!-- Bootstrap 4 RTL -->
     <link rel="stylesheet" href="{{  asset('vendor/adminlte/dist/css/bootstrap-rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/custom.css') }}">
@stop

@section('js')

@stop
