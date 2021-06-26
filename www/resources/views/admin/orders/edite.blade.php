@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> تعديل طلب الشراء </h1>
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
		                <h3 class="card-title">تعديل طلب الشراء</h3>
		              </div>
		              <!-- /.card-header -->

		              <!-- form start -->
		              <form action="{{ url('orders/'.$order_info->id) }}" role="form" method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
                        @foreach($order_info->invoices_items as $order)

                            <div class="card-body  col-md-5" style="display:inline-block;border-left: 2px dashed black;">

                                <h5> المنتج رقم # {{ $loop->index + 1}} </h5>
                                <!-- merchant name  -->
                                <input class="invoices_items_ID_{{ $order->id }}" value="{{ $order->id }}" type="hidden" value="{{ $order->id }} ">

                                <div class="form-group col-md-12 col-xs-12">
                                    <label for="exampleInputEmail1">اسم المنتج</label>
                                    <select name="product_id[]" class="product_id form-control select2 product_id_{{ $order->id }}" style="width: 100%;" required>
                                        @if(!empty($get_all_products))
                                            @foreach($get_all_products as $product)
                                                <option value="{{ $product->id }}" additional-taxs="{{ $product->additional_taxs }}" data-price="{{ $product->price_piecies }}" {{ (($order->product_id==$product->id)?'selected':'') }} > {{ $product->name_product }} </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>



                                <!-- order Category  -->
                                <div class="form-group col-md-12 col-xs-12">
                                    <label for="exampleInputPassword1">الصنف</label>
                                    <select name="category_id[]" class="form-control select2" style="width: 100%;">

                                    @if(!empty($get_all_categories))
                                        @foreach($get_all_categories as $category)
                                            <option value="{{ $category->id }}" {{ (($order->product->category_id==$category->id)?'selected':'') }} > {{ $category->category }} </option>
                                        @endforeach
                                    @endif

                                    </select>
                                </div>


                                <!-- order value  -->
                                <div class="form-group col-md-12 col-xs-12">
                                    <label for="exampleInputPassword1">كمية الطلبية</label>
                                    <input name="order_count[]" value="{{ $order->order_count }}" type="text" item-id="{{ $order->id }}" class="order_count form-control order_count_{{ $order->id }}" id="exampleInputPassword1" placeholder="كمية الطلبية" required>
                                </div>

                                <!-- order price  -->
                                <div class="form-group col-md-12 col-xs-12">
                                    <label for="exampleInputPassword1">سعر الطلبية</label>
                                    <input name="order_price[]" value="{{ round($order->order_price,2) }}" type="text" class="form-control order_price_{{ $order->id }}" id="exampleInputPassword1" placeholder="سعر الطلبية بالجنية" required>
                                </div>

                                <!-- order discount  -->
                                <div class="form-group col-md-12 col-xs-12">
                                    <label for="exampleInputPassword1">تخفيض على الطلبية</label>
                                    <input name="order_discount[]" value="{{ $order->order_discount }}" type="text" class=" order_discount_{{ $order->id }} form-control" id="exampleInputPassword1" placeholder="تخفيض على الطلبية بالنسبة او بالجنية">
                                </div>

                                <!-- order discount  -->
                                <div class="form-group col-md-12 col-xs-12">
                                    <label for="exampleInputPassword1">مصروفات زائدة</label>
                                    <input name="order_taxs[]" value="{{ $order->order_taxs }}" type="text" item-id="{{ $order->id }}" class="order_taxs order_taxs_{{  $order->id }} form-control" id="exampleInputPassword1" placeholder="مصروفات زائدة على الطلبية">
                                </div>



                            </div>
		                    <!-- /.card-body -->
                        @endforeach
                        <div class="card-body  col-md-10" style="display:inline-block;">

                            <!-- merchant name  -->
                            <div class="form-group col-md-12 col-xs-12">
                                <label for="exampleInputEmail1">اسم العميل </label>
                                <select name="client_id" class="form-control select2" style="width: 100%;" >
                                    <option value="">بدون</option>
                                    @if(!empty($all_clients))
                                        @foreach($all_clients as $client)
                                            <option value="{{ $client->id }}" {{ (($order_info->client_id==$client->id)?'selected':'') }} > {{ $client->client_name }} </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <!-- order type payment  -->
                            <div class="form-group col-md-12 col-xs-12">
                                <label for="exampleInputPassword1">نوع الدفع</label>
                                <input type="text" name="payment_type" value="{{ $order_info->payment_type }}" class="form-control" id="exampleInputPassword1" readonly>
                            </div>
                        </div>

		                <div class="card-footer">
		                  <button type="submit" class="btn btn-primary"> تعديل الطلبية </button>
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
		    // Initialize Select2 Elements
		    $('.select2').select2({
		      theme: 'bootstrap4'
		    });



		});
    </script>
    <script type="text/javascript">


        jQuery('body').on('keyup','.order_count , .order_taxs ',function(){
            var ID                   =   jQuery(this).attr('item-id');
            var order_count          =   Number(jQuery('.order_count_'+ID).val());
            var order_price          =   Number(jQuery('.order_price_'+ID).val());
            var one_price            =   Number(jQuery('.product_id_'+ID+' option:selected').attr('data-price'));
            var additional_taxs      =   Number(jQuery('.product_id_'+ID+' option:selected').attr('additional-taxs'));

            jQuery('.order_price_'+ID).val( ( Number(order_count) * Number(additional_taxs) ) + ( Number(order_count) * Number(one_price) ) );
        });
    </script>
@stop
