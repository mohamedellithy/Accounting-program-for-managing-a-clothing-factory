@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> تعديل الطلبات القماش </h1>
@stop


@section('content')
      <!-- Main content -->

    <section class="content">
	    <div class="container-fluid">
	        <div class="row">
	            <!-- left column -->
	            <div class="col-md-12">
                    @if($errors->any())
                    	<div class="alert alert-danger alert-dismissible">
		                  @foreach($errors->all() as $error)
		                       {{ $error }}
                          @endforeach
		                </div>
	            	@elseif($message = Session::get('success'))
		            	<div class="alert alert-warning alert-dismissible">
		                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                  <h5><i class="icon fas fa-check"></i> تمت</h5>
		                  {{ $message }}
		                </div>
		            @endif
		             <div class="" style="text-align: left !important;">
		                 <a href="{{ url('orders-clothes') }}" class="btn btn-info"> الرجوع </a>
		            </div>
		            <!-- general form elements -->
		            <div class="card card-primary">
		              <div class="card-header">
		                <h3 class="card-title">تعديل طلبيه قماش</h3>
		              </div>
		              <!-- /.card-header -->
		              <!-- form start -->
		              <form action="{{ url('orders-clothes/'.$order_clothes->id) }}" role="form" method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
		                <div class="card-body cardbody">
		                   <!-- merchant name  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                  <label for="exampleInputEmail1">اسم التاجر</label>
			                  <select name="merchant_id" class="form-control select2" style="width: 100%;" required>
			                   @if(!empty($merchants))
			                       @foreach($merchants as $merchant)
			                           <option value="{{ $merchant->id }}" {{ (($order_clothes->merchant_id==$merchant->id)?'selected':'') }} > {{ $merchant->merchant_name }} </option>
			                       @endforeach
			                   @endif
			                  </select>
			                </div>

                           <!-- merchant name  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                  <label for="exampleInputEmail1">رقم الفاتورة</label>
			                  <input name="invoice_no" value=" {{ $order_clothes->invoice_no }} " type="text" class="form-control" id="exampleInputPassword1" placeholder="رقم الفاتورة" required>
			                </div>

                            <!-- order type payment  -->
                            <div class="form-group col-md-12 col-xs-12">
                                <label for="exampleInputPassword1">نوع الدفع</label>
                                <input name="payment_type" value="{{ $order_clothes->payment_type }}" type="text" class="form-control" id="exampleInputPassword1" placeholder="تخفيض على الطلبية بالنسبة او بالجنية" readonly>
                            </div>
                            @if(!empty($order_clothes->orders_in_invoices))
                                @foreach($order_clothes->orders_in_invoices as $attached)
                                    <div class="col-sm-12 col-md-5" style="border-left:3px dashed black;display:inline-block">

                                        <!-- order Category  -->
                                        <div class="form-group col-md-12 col-xs-12">
                                            <label for="exampleInputPassword1">الصنف</label>
                                            <select name="category_id[]" class="form-control select2" style="width: 100%;" required>

                                            @if(!empty($categories))
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ (($attached->category_id==$category->id)?'selected':'') }} > {{ $category->category }} </option>
                                                @endforeach
                                            @endif

                                            </select>
                                        </div>

                                        <!-- order mensuration  -->
                                        <div class="form-group col-md-12 col-xs-12">
                                            <label for="exampleInputPassword1">نوع الطلبية</label>
                                            <select name="order_size_type[]" class="form-control select2" style="width: 100%;" required>
                                                    <option value="كجم" {{ (($attached->order_size_type=='كجم')?'selected':'') }} > كجم </option>
                                                    <option value="متر" {{ (($attached->order_size_type=='متر')?'selected':'') }} > متر </option>

                                            </select>
                                            </div>


                                        <!-- order value  -->
                                        <div class="form-group col-md-12 col-xs-12">
                                            <label for="exampleInputPassword1">كمية الطلبية</label>
                                            <input name="order_size[]" value=" {{ $attached->order_size }} " type="text" class="form-control order_size order_size{{ $attached->id }} " order-id="{{ $attached->id }}" id="exampleInputPassword1" placeholder="كمية الطلبية" required>
                                        </div>


                                        <!-- order price  -->
                                        <div class="form-group col-md-12 col-xs-12">
                                            <label for="exampleInputPassword1">سعر المتر / كجم بالجنيه</label>
                                            <input name="price_one_piecies[]" value="{{ $attached->price_one_piecies  }}" type="text" class="form-control price_one_piecies price_one_piecies{{$attached->id}}" order-id="{{ $attached->id }}" id="exampleInputPassword1" placeholder="سعر المتر / كجم بالجنيه" required>
                                        </div>

                                        <!-- order price  -->
                                        <div class="form-group col-md-12 col-xs-12">
                                            <label for="exampleInputPassword1">سعر الطلبية</label>
                                            <input name="order_price[]" value=" {{ $attached->order_price }} " type="text" class="form-control order_price order_price{{$attached->id}}" id="exampleInputPassword1" order-id="{{ $attached->id }}" placeholder="سعر الطلبية بالجنية" required>
                                        </div>

                                        <!-- order discount  -->
                                        <div class="form-group col-md-12 col-xs-12">
                                            <label for="exampleInputPassword1">تخفيض على الطلبية</label>
                                            <input name="order_discount[]" value="{{ $attached->order_discount }}" type="text" class="form-control order_discount order_discount{{$attached->id}}" id="exampleInputPassword1" order-id="{{ $attached->id }}" placeholder="تخفيض على الطلبية بالنسبة او بالجنية">
                                        </div>

                                    </div>
                                @endforeach
                            @endif

		                </div>
		                <!-- /.card-body -->

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


		      $('select.payment_type').change(function(){
		    	if($(this).val() == 'شيك'){
		    	   $('.checkform').fadeIn();
		    	   $('.postponedform').fadeOut();
		    	}
		    	else if($(this).val() == 'دفعات'){
		    	   $('.postponedform').fadeIn();
		    	   $('.checkform').fadeOut();
		    	}
		    	else{
		    	   $('.checkform').fadeOut();
		    	   $('.postponedform').fadeOut();
		    	}
		    });
		    // here js for form BanckCheck
		    $('body').on('click','.checkform .fa-plus-square',function(){
                var html_inputs = $('.checkform').html();
                var creatContainer = document.createElement('div');
                $(creatContainer).addClass('checkform col-12');
                creatContainer.innerHTML = html_inputs;
                $('.cardbody').append(creatContainer);
                $(creatContainer).fadeIn();
		    });
		    $('body').on('click','.checkform .fa-trash-alt',function(){

                $(this).parents('.checkform').hide();
		    });
            // here js for form postponed data
		     $('body').on('click','.postponedform .fa-plus-square',function(){
                var html_inputs = $('.postponedform').html();
                var creatContainer = document.createElement('div');
                $(creatContainer).addClass('postponedform col-12');
                creatContainer.innerHTML = html_inputs;
                $('.cardbody').append(creatContainer);
                $(creatContainer).fadeIn();
		    });
		    $('body').on('click','.postponedform .fa-trash-alt',function(){

                $(this).parents('.postponedform').hide();
		    });
		});
    </script>
    <script type="text/javascript">
         $('body').on('click','.checkform .fa-trash-alt.form-delete',function(){
              $(this).parents('.checkform').remove();
              var check_id = $(this).parents('.checkform').attr('check_id');
              var Banckcheck_id =   $('.input_ids'+check_id).val();
              if(Banckcheck_id!==undefined){
                 $.ajaxSetup({
	                  headers: {
	                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	                  }
                 });
                 jQuery.ajax({
	                  url: "{{ url('/ajax-delete-Bankcheck') }}",
	                  method: 'get',

	                  data: {
	                     Banckcheck_id:Banckcheck_id,
	                  },
	                  success: function(result){
	                     console.log(result.status);
	                  }
                });
              }
         });

        jQuery('.order_size , .price_one_piecies , .order_discount ').keyup(function(){
            let Order_ID =  jQuery(this).attr('order-id');
        	var count_piecies = Number(jQuery('.order_size'+Order_ID).val() ) * Number( jQuery('.price_one_piecies'+Order_ID).val() );
            var after_discount = count_piecies - ( (count_piecies * Number(jQuery('.order_discount'+Order_ID).val()) ) /100);
            jQuery('.order_price'+Order_ID).val(after_discount);
        });
    </script>
@stop
