@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> اضافة مرتجع نقدى </h1>
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
		                <h3 class="card-title">اضافة مرتجع نقدى</h3>
		              </div>
		              <!-- /.card-header -->
		              <!-- form start -->
		              <form action="{{ url('create-reactionist/'.$order_id) }}" role="form" method="POST">
                        {{ csrf_field() }}
			             <div class="card-body">
			                @if(!empty($get_order_info))
			                    @foreach($get_order_info as $order_info)
			                        <!-- order Nimber  -->
				                  <div class="form-group col-md-12 col-xs-12">
				                    <label for="exampleInputPassword1">رقم الطلب</label>
				                    <input name="order_id" value="{{ $order_info->id }}" type="text" class="form-control" id="exampleInputPassword1" placeholder="سعر القطعة" required hidden>
				                    <input name="" value="{{ ($order_info->order_follow?$order_info->order_follow:$order_info->id) }}" type="text" class="form-control" id="exampleInputPassword1" placeholder="سعر القطعة" required readonly>
				                  </div>

		                           <!-- order Category  -->
				                   <div class="form-group col-md-12 col-xs-12">
					                   <label for="exampleInputPassword1">الصنف</label>
					                   <input name="category_id" value="{{ $order_info->product_name->category_name->id }}" hidden>
					                  <select name="category" class="form-control select2" style="width: 100%;" required disabled>
					                   <option > بدون تحديد </option>
					                   @if(!empty($get_all_categories))
					                       @foreach($get_all_categories as $category)
					                           <option value="{{ $category->id }}" {{ (($order_info->product_name->category_name->id==$category->id)?'selected':'') }} > {{ $category->category }} </option>
					                       @endforeach
					                   @endif
					                 
					                  </select>
					                </div>

					              <!-- product name  -->		                    
				                   <div class="form-group col-md-12 col-xs-12">
					                  <label for="exampleInputEmail1">اسم المنتج</label>
					                  <input name="product_id" value="{{ $order_info->product_name->id }}" hidden>
					                  <select name="product" class="form-control select2" style="width: 100%;" required disabled>
					                   @if(!empty($all_products))
					                       @foreach($all_products as $product)
					                           <option value="{{ $product->id }}" {{ (($order_info->product_name->id==$product->id)?'selected':'') }} > {{ $product->name_product }} </option>
					                       @endforeach
					                   @endif
					                  </select>
					                </div>

					               

					                <!-- merchant name  -->		                    
				                   <div class="form-group col-md-12 col-xs-12">
					                  <label for="exampleInputEmail1">اسم الزبون</label>
					                  <input name="client_id" value="{{ $order_info->client_id }}" hidden>
					                  <select name="client" class="form-control select2" style="width: 100%;" disabled>
					                     <option value=""> بدون تحديد </option>
					                   @if(!empty($all_clients))
					                       @foreach($all_clients as $client)
					                           <option value="{{ $client->id }}" {{ ( ( !empty($order_info->client_id) ) && ($order_info->client_name->id==$client->id)?'selected':'') }}> {{ $client->client_name }} </option>
					                       @endforeach
					                   @endif
					                  </select>
					                </div>

				                 
				                  
				                  <!-- order value  -->
				                  <div class="form-group col-md-12 col-xs-12">
				                    <label for="exampleInputPassword1">كمية الطلبية</label>
				                    <label for="exampleInputPassword1" style="font-size: 12px;float: left;">الكمية المتوفرة : 0</label>
				                    <input name="order_count" type="text" class="form-control" id="exampleInputPassword1" placeholder="كمية الطلبية" required>
				                  </div>

				                  <!-- order price  -->
				                  <div class="form-group col-md-12 col-xs-12">
				                    <label for="exampleInputPassword1">سعر القطعة</label>
				                    <input name="reactionist_price" value="{{ round( ($order_info->final_cost)/$order_info->order_count,2) }}" type="text" class="form-control" id="exampleInputPassword1" placeholder="سعر القطعة" required>
				                  </div>

				                

				               
				                  <!-- order type payment  -->
				                  <div class="form-group col-md-12 col-xs-12">
				                    <label for="exampleInputPassword1">نوع الدفع</label>
				                       <input name="payment_type" value="{{ $order_info->payment_type }}" hidden>
					                  <select name="payment" class="form-control select2" style="width: 100%;" required disabled>
					                        <option value="نقدى"  {{ (($order_info->payment_type=='نقدى')?'selected':'') }} > نقدى </option>
					                        <option value="شيك"  {{ (($order_info->payment_type=='شيك')?'selected':'') }}> شيك </option>
					                        <option value="أجل"   {{  (($order_info->payment_type=='أجل')?'selected':'') }}> أجل </option>
					                 
					                  </select>
					              </div>
					            @endforeach
					        @endif
		                  
		                </div>
		                <!-- /.card-body -->

		                <div class="card-footer">
		                  <button type="submit" class="btn btn-primary"> اضافة مرتجع نقدى </button>
		                </div>
		              </form>
		            </div>
		            <!-- /.card -->

		            {{--  here show table of added last  --}}
				    <div class="card">
				      <div class="card-header">
				        <h3 class="card-title">أخر مرتجع نقدى</h3>
				      </div>
				      <!-- /.card-header -->
				      <div class="card-body">
				        <table class="table table-bordered">
				          <thead>                  
				            <tr>
				              <th>#</th>
				              <th>أسم المنتج</th>
				              <th>الصنف</th>
				              <th>الكمية</th>
				              <th>سعر القطعة</th>
				              <th>اسم الزبون </th>
				              <th>نوع الدفع</th>
				              <th>تاريخ مرتجع</th>
				              
				            </tr>
				          </thead>
				          <tbody>
                              @if(!empty($last_order))
                                    <tr>
                                      <td>1#</td>
                                      <td> {{ $last_order->product_name->name_product }} </td>
                                      <td> {{ $last_order->product_name->category_name->category }} </td>
                                      <td> {{ $last_order->order_count  }} </td>
                                      <td> {{ $last_order->order_price }} جنية </td>                                    
                                      <td> {{ ($last_order->client_name?$last_order->client_name->client_name:'بدون') }} </td>
                                      <td> {{ $last_order->payment_type }} </td>
                                      <td> {{ $last_order->created_at }} </td>
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
     <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/plugins/select2/css/select2.min.css') }}">
     <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{  asset('vendor/adminlte/dist/css/bootstrap-rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/custom.css') }}">
    

@stop
<!-- Select2 -->
@section('js')
	<script src="{{ asset('vendor/adminlte/plugins/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
		  $(function () {
		    //Initialize Select2 Elements
		    $('.select2').select2({
		      theme: 'bootstrap4',
		    });
		});
    </script>
@stop