@extends('adminlte::page')

@section('title', 'العميل / الزبون')

@section('content_header')
    <h1> اضافة العميل / الزبون </h1>
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
		            <!-- general form elements -->
		            <div class="card card-primary">
		              <div class="card-header">
		                <h3 class="card-title">اضافة عميل / زبون جديد</h3>
		              </div>
		              <!-- /.card-header -->
		              <!-- form start -->
		              <form action="{{ url('create-client') }}" role="form" method="POST">
                        {{ csrf_field() }}
		                <div class="card-body">
		                  <div class="form-group">
		                    <label for="exampleInputEmail1">اسم عميل / زبون </label>
		                    <input name="client_name" type="name" class="form-control" id="exampleInputEmail1" placeholder="اسم عميل / زبون">
		                  </div>
		                  <div class="form-group">
		                    <label for="exampleInputPassword1">رقم التليفون</label>
		                    <input name="client_phone" type="phone" class="form-control" id="exampleInputPassword1" placeholder="رقم التليفون">
		                  </div>
		              
		                </div>
		                <!-- /.card-body -->

		                <div class="card-footer">
		                  <button type="submit" class="btn btn-primary"> اضافة عميل / زبون </button>
		                </div>
		              </form>
		            </div>
		            <!-- /.card -->

		            {{--  here show table of added last  --}}
				    <div class="card">
				      <div class="card-header">
				        <h3 class="card-title">أخر ما تم اضافته من العملاء / الزبائن</h3>
				      </div>
				      <!-- /.card-header -->
				      <div class="card-body">
				        <table class="table table-bordered">
				          <thead>                  
				            <tr>
				              <th>#</th>
				              <th>أسم عميل / زبون</th>
				              <th>رقم التليفون</th>
				              <th>تواصل</th>
				              <th>تاريخ الاضافة</th>
				            </tr>
				          </thead>
				          <tbody>
				          	@if($last = (Session::get('last_client')?Session::get('last_client'):$last_client) ) 
					              <tr>
						              <td>1.</td>
						              <td> {{ $last->client_name }} </td>
						              <td>
						                  {{ $last->client_phone }}
						              </td>
						              <td>
						                 <a href="tel:{{ $last->client_phone }}">  <i class="fab fa-whatsapp-square fa-2x" style="color:#3fad3f" ></i></a>
						                 <a href="tel:{{ $last->client_phone }}"> <i class="fas fa-lg fa-phone fa-2x" style="color:#007bff"></i></a>

						              </td>
						              <td>
						                  {{ $last->created_at }}
						              </td>
						             
					               </tr>
					        @endif
				         
				          </tbody>
				        </table>
				      </div>
				    
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