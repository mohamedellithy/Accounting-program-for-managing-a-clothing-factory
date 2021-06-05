@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> تعديل المرتجع </h1>
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
		                 <a href="{{ url('show-orders') }}" class="btn btn-info"> الرجوع </a>
		            </div>
		            <!-- general form elements -->
		            <div class="card card-primary">
		              <div class="card-header">
		                <h3 class="card-title">تعديل المرتجع</h3>
		              </div>
		              <!-- /.card-header -->
		              @foreach($order_product_info as $order_info )
		              <!-- form start -->
		              <form action="{{ url('update-reactionist/'.$order_info->id.'/'.$order_info->order_id) }}" role="form" method="POST">
                        {{ csrf_field() }}
		                <div class="card-body">
		                 
                            <!-- merchant name  -->		                    
		                   <div class="form-group col-md-12 col-xs-12">
			                  <label for="exampleInputEmail1">اسم المنتج</label>
			                  <select name="product_id" class="form-control select2" style="width: 100%;" required>
			                   @if(!empty($get_all_products))
			                       @foreach($get_all_products as $product)
			                           <option value="{{ $product->id }}" {{ (($order_info->product_id==$product->id)?'selected':'') }} > {{ $order_info->product_name->name_product }} </option>
			                       @endforeach
			                   @endif
			                  </select>
			                </div>

		                  <!-- merchant name  -->		                    
		                   <div class="form-group col-md-12 col-xs-12">
			                  <label for="exampleInputEmail1">اسم العميل </label>
			                  <select name="client_id" class="form-control select2" style="width: 100%;" >
			                    <option value="">بدون</option>
			                   @if(!empty($all_clients))
			                       @foreach($all_clients as $client)
			                           <option value="{{ $client->id }}" {{ (($order_info->client_id==$client->id)?'selected':'') }} > {{ ($order_info->client_id?$order_info->client_name->client_name:'') }} </option>
			                       @endforeach
			                   @endif
			                  </select>
			                </div>

			               <!-- order Category  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                   <label for="exampleInputPassword1">الصنف</label>
			                  <select name="category_id" class="form-control select2" style="width: 100%;">
			                   
			                   @if(!empty($get_all_categories))
			                       @foreach($get_all_categories as $category)
			                           <option value="{{ $category->id }}" {{ (($order_info->product_name->category_id==$category->id)?'selected':'') }} > {{ $order_info->product_name->category_name->category }} </option>
			                       @endforeach
			                   @endif
			                 
			                  </select>
			                </div>
		                  
		                  <!-- order value  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">كمية الطلبية</label>
		                    <input name="order_count" value=" {{ $order_info->order_count }} " type="text" class="form-control" id="exampleInputPassword1" placeholder="كمية الطلبية" required>
		                      <input name="old_order_count" value=" {{ $order_info->order_count }} " type="text" class="form-control" id="exampleInputPassword1" placeholder="كمية الطلبية" hidden>
		                  </div>

		                  <!-- order price  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">سعر القطعة الواحدة</label>
		                    <input name="reactionist_price" value=" {{ $order_info->reactionist_price }} " type="text" class="form-control" id="exampleInputPassword1" placeholder="سعر الطلبية بالجنية" required>
		                  </div>

		                  <!-- order type payment  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">نوع الدفع</label>
			                  <select name="payment_type" class="form-control select2" style="width: 100%;" required>
			                        <option value="نقدى" {{ (($order_info->payment_type=='نقدى')?'selected':'') }} > نقدى </option>
			                        <option value="شيك" {{ (($order_info->payment_type=='شيك')?'selected':'') }} > شيك </option>
			                 
			                  </select>
			              </div>
		                  
		                </div>
		                <!-- /.card-body -->

		                <div class="card-footer">
		                  <button type="submit" class="btn btn-primary"> تعديل الطلبية </button>
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
     <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/plugins/select2/css/select2.min.css') }}">
     <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <!-- Bootstrap 4 RTL -->
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
    </script>
@stop