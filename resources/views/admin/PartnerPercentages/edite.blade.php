@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> تعديل الشريك </h1>
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
		                 <a href="{{ url('show-partners') }}" class="btn btn-info"> الرجوع </a>
		            </div>
		            <!-- general form elements -->
		            <div class="card card-primary">
		              <div class="card-header">
		                <h3 class="card-title">تعديل الشريك</h3>
		              </div>
		              <!-- /.card-header -->
		              <!-- form start -->
		              
		              @foreach($partner_data as $partner_info)
		              <form action="{{ url('update-partner/'.$partner_info->id) }}" role="form" method="POST">
                        {{ csrf_field() }}
		                <div class="card-body">
		                  <div class="form-group">
		                    <label for="exampleInputEmail1">اسم الشريك</label>
		                    <input name="partner_name" value="{{ $partner_info->partner_name }}" type="name" class="form-control" id="exampleInputEmail1" placeholder="اسم الشريك">
		                  </div>
		                  <div class="form-group">
		                    <label for="exampleInputPassword1">رقم التليفون</label>
		                    <input name="partner_phone" value="{{ $partner_info->partner_phone }}" type="phone" class="form-control" id="exampleInputPassword1" placeholder="رقم التليفون">
		                  </div>

		                  <div class="form-group">
		                    <label for="exampleInputPassword1">نسبة الشركة</label>
		                    <input name="partner_percentage" value="{{ $partner_info->partner_percentage }}" type="phone" class="form-control" id="exampleInputPassword1" placeholder="نسبة الشراكة">
		                  </div>

		                   <!-- merchant name  -->		                    
		                   <div class="form-group ">
			                  <label for="exampleInputEmail1">حالة الشراكة</label>
			                  <select name="partner_status" class="form-control select2" style="width: 100%;" required>
			                    <option value="0" {{ (($partner_info->partner_status==0)?'selected':'') }} > شراكة مستمرة </option>
			                    <option value="1" {{ (($partner_info->partner_status==1)?'selected':'') }} >شراكة منتهية  </option>
			                  </select>
			                </div>
	                         
		              
		                </div>
		                <!-- /.card-body -->

		                <div class="card-footer">
		                  <button type="submit" class="btn btn-primary"> تعديل الشريك </button>
		                </div>
		              </form>
		              @endforeach
		            </div>
		            <!-- /.card -->

	            </div>
	        </div>
	    </div>
    </section>
@stop

@section('css')
    <!-- Bootstrap 4 RTL -->
     <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/plugins/select2/css/select2.min.css') }}">
     <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  
     <link rel="stylesheet" href="{{  asset('vendor/adminlte/dist/css/bootstrap-rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/custom.css') }}">
@stop


@section('js')
    <script src="{{ asset('vendor/adminlte/plugins/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
		  $(function () {
		    //Initialize Select2 Elements
		    $('.select2').select2({
		      theme: 'bootstrap4'
		    });
		});

	$('body').on('keyup','.original_value , .profit_value',function(){
        var original_value = $('.original_value').val();
        var profit_value   = $('.profit_value').val(); 
        var result         = (Number(profit_value)/Number(original_value))*100; 
        $('.result').val(result);
     });
    </script>
@stop
