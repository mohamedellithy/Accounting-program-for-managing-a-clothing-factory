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
	            	@if($message = Session::get('success'))
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

		              @foreach($order_clothes_info as $order_clothes )

		              <!-- form start -->
		              <form action="{{ url('orders-clothes/'.$order_clothes->id) }}" role="form" method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
		                <div class="card-body cardbody">
		                  <!-- merchant name  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                  <label for="exampleInputEmail1">اسم التاجر</label>
			                  <select name="merchant_id" class="form-control select2" style="width: 100%;" required>
			                   @if(!empty($all_merchants))
			                       @foreach($all_merchants as $merchant)
			                           <option value="{{ $merchant->id }}" {{ (($order_clothes->merchant_id==$merchant->id)?'selected':'') }} > {{ $merchant->merchant_name }} </option>
			                       @endforeach
			                   @endif
			                  </select>
			                </div>

			               <!-- order Category  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                   <label for="exampleInputPassword1">الصنف</label>
			                  <select name="category_id" class="form-control select2" style="width: 100%;" required>

			                   @if(!empty($get_all_categories))
			                       @foreach($get_all_categories as $category)
			                           <option value="{{ $category->id }}" {{ (($order_clothes->category_id==$category->id)?'selected':'') }} > {{ $category->category }} </option>
			                       @endforeach
			                   @endif

			                  </select>
			                </div>

		                  <!-- order mensuration  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                   <label for="exampleInputPassword1">نوع الطلبية</label>
			                  <select name="order_size_type" class="form-control select2" style="width: 100%;" required>
			                        <option value="كجم" {{ (($order_clothes->order_size_type=='كجم')?'selected':'') }} > كجم </option>
			                        <option value="متر" {{ (($order_clothes->order_size_type=='متر')?'selected':'') }} > متر </option>

			                  </select>
			                </div>


		                  <!-- order value  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">كمية الطلبية</label>
		                    <input name="order_size" value=" {{ $order_clothes->order_size }} " type="text" class="form-control order_size" id="exampleInputPassword1" placeholder="كمية الطلبية" required>
		                  </div>


		                  <!-- order price  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">سعر المتر / كجم بالجنيه</label>
		                    <input name="price_one_piecies" value="{{ $order_clothes->price_one_piecies  }}" type="text" class="form-control price_one_piecies" id="exampleInputPassword1" placeholder="سعر المتر / كجم بالجنيه" required>
		                  </div>




		                  <!-- order price  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">سعر الطلبية</label>
		                    <input name="order_price" value=" {{ $order_clothes->order_price }} " type="text" class="form-control order_price" id="exampleInputPassword1" placeholder="سعر الطلبية بالجنية" required>
		                  </div>

		                  <!-- order discount  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">تخفيض على الطلبية</label>
		                    <input name="order_discount" value="{{ $order_clothes->order_discount }}" type="text" class="form-control order_discount" id="exampleInputPassword1" placeholder="تخفيض على الطلبية بالنسبة او بالجنية">
		                  </div>
		                  <!-- order type payment  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">نوع الدفع</label>
			                <input name="payment_type" value="{{ $order_clothes->payment_type }}" type="text" class="form-control order_discount" id="exampleInputPassword1" placeholder="تخفيض على الطلبية بالنسبة او بالجنية" readonly>
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
        	var count_piecies = Number(jQuery('.order_size').val() ) * Number( jQuery('.price_one_piecies').val() ) - Number(jQuery('.order_discount').val() )   ;
            jQuery('.order_price').val(count_piecies);
        });
    </script>
@stop
