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
		              @foreach($order_product_info as $order_info )
		              <!-- form start -->
		              <form action="{{ url('update-order/'.$order_info->id) }}" role="form" method="POST">
                        {{ csrf_field() }}
		                <div class="card-body cardbody">
		                 
                            <!-- merchant name  -->		                    
		                   <div class="form-group col-md-12 col-xs-12">
			                  <label for="exampleInputEmail1">اسم المنتج</label>
			                  <select name="product_id" class="product_id form-control select2" style="width: 100%;" required>
			                   @if(!empty($get_all_products))
			                       @foreach($get_all_products as $product)
			                           <option value="{{ $product->id }}" data-price="{{ $product->price_piecies }}" {{ (($order_info->product_id==$product->id)?'selected':'') }} > {{ $order_info->product_name->name_product }} </option>
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
			                           <option value="{{ $client->id }}" {{ (($order_info->client_id==$client->id)?'selected':'') }} > {{ $client->client_name }} </option>
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
		                    <input name="order_count" value=" {{ $order_info->order_count }} " type="text" class="form-control order_count" id="exampleInputPassword1" placeholder="كمية الطلبية" required>
		                  </div>

		                  <!-- order price  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">سعر الطلبية</label>
		                    <input name="order_price" value=" {{ round($order_info->order_price,2) }} " type="text" class="form-control order_price" id="exampleInputPassword1" placeholder="سعر الطلبية بالجنية" required>
		                  </div>

		                  <!-- order discount  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">تخفيض على الطلبية</label>
		                    <input name="order_discount" value="{{ $order_info->order_discount }}" type="text" class="order_discount form-control" id="exampleInputPassword1" placeholder="تخفيض على الطلبية بالنسبة او بالجنية">
		                  </div>

		                  <!-- order discount  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">مصروفات زائدة</label>
		                    <input name="order_taxs" value="{{ $order_info->order_taxs }}" type="text" class="order_taxs form-control" id="exampleInputPassword1" placeholder="مصروفات زائدة على الطلبية">
		                  </div>

		                  <!-- order type payment  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">نوع الدفع</label>
			                  <select name="payment_type" class="form-control payment_type select2" style="width: 100%;" required>
			                        <option value="نقدى" {{ (($order_info->payment_type=='نقدى')?'selected':'') }} > نقدى </option>
			                        <option value="شيك" {{ (($order_info->payment_type=='شيك')?'selected':'') }} > شيك </option>
			                        <option value="دفعات" {{ (($order_info->payment_type=='دفعات')?'selected':'') }} > دفعات </option>
			                 
			                  </select>
			              </div>
                          
			                @if( ($order_info->bank_check==null) || (count($order_info->bank_check)!=0) )
                                @foreach($order_info->bank_check as $check_details)
                                    <input name="check_id[]" value="{{ ($check_details->id?$check_details->id:'') }}" type="text" class="form-control input_ids{{ ($check_details->id?$check_details->id:'') }}" placeholder="شيك باسم ..." hidden>
					                <div class="checkform col-12" check_id="{{ ($check_details->id?$check_details->id:'') }}" style="display:block">
					                  	<div class="col-xs-12">
					                  	     <h4 class="badge bg-danger" style="font-size:14px;color:black"> اضافة شيك </h4>
					                  	     <i class="fa fa-plus-square" aria-hidden="true"></i>
					                  	     <i class="far fa-trash-alt form-delete" aria-hidden="true"></i>
					                  	</div>
			                            <div class="form-group col-md-12">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>شيك باسم</label>

					                        <input name="check_owner[]" value="{{ ($check_details->check_owner?$check_details->check_owner:'') }}" type="text" class="form-control" placeholder="شيك باسم ..." >
					                      </div>
					                    </div>
					                    <div class="form-group col-md-12">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>تاريخ تسديد الشيك</label>
					                        <input name="check_date[]" value="{{ ($check_details->check_date?$check_details->check_date:'') }}" type="date" class="form-control" placeholder="Enter ..." >
					                      </div>
					                    </div>
					                    <div class="form-group col-md-12">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>قيمة الشيك</label>
					                        <input name="check_value[]" value="{{ ($check_details->check_value?$check_details->check_value:'') }}" type="text" class="form-control" placeholder="قيمة الشيك ..." >
					                      </div>
					                    </div>
					                    <div class="form-group col-md-12">
					                      <!-- text input -->
					                      <div class="form-group">
					                        <label>اضافة علي قيمة الشيك</label>
					                        <input name="increase_value[]" value="{{ ($check_details->increase_value?$check_details->increase_value:'') }}" type="text" class="form-control" placeholder="قيمة اضافية ..." >
					                      </div>
				                        </div>
				                    </div>
				                @endforeach
				            @elseif(count($order_info->postponeds_money)!=0)
				                @foreach($order_info->postponeds_money as $postponeds_money)
				                  <input name="order_id" value="{{ ($postponeds_money->id?$postponeds_money->id:'') }}" type="text" class="form-control input_ids{{ ($postponeds_money->id?$postponeds_money->id:'') }}" placeholder="شيك باسم ..." hidden>
				                  <!--  here put form postponed values -->
				                  <div class="postponedform col-12" order_id="{{ ($postponeds_money->id?$postponeds_money->id:'') }}" style="display:block">
				                  	<div class="col-xs-12">
				                  	     <h4 class="badge bg-success" style="font-size:14px;color:black"> اضافة دفعات</h4>
				                  	     <i class="fa fa-plus-square" aria-hidden="true"></i>
				                  	    
				                  	</div>
		                            <div class="form-group col-12">
				                      <!-- text input -->
				                      <div class="form-group">
				                        <label>قيمة  الدفعات</label>
				                        <input name="postponed_value" value="{{ ($postponeds_money->posponed_value?$postponeds_money->posponed_value:'') }}" type="text" class="form-control" placeholder="المبلغ المطلوب تسديدة ..." >
				                      </div>
				                    </div>
				                    
				                   
				                  
				                  </div>
                                  <!--  here put end of form check of Banck -->
				                @endforeach
				            @else

					            <div class="checkform col-12">
				                  	<div class="col-xs-12">
				                  	     <h4 class="badge bg-danger" style="font-size:14px;color:black"> اضافة شيك </h4>
				                  	     <i class="fa fa-plus-square" aria-hidden="true"></i>
				                  	     <i class="far fa-trash-alt" aria-hidden="true"></i>
				                  	</div>
		                            <div class="form-group col-md-12">
				                      <!-- text input -->
				                      <div class="form-group">
				                        <label>شيك باسم</label>
				                        <input name="check_owner[]" type="text" class="form-control" placeholder="شيك باسم ..." >
				                      </div>
				                    </div>
				                    <div class="form-group col-md-12">
				                      <!-- text input -->
				                      <div class="form-group">
				                        <label>تاريخ تسديد الشيك</label>
				                        <input name="check_date[]" type="date" class="form-control" placeholder="Enter ..." >
				                      </div>
				                    </div>
				                    <div class="form-group col-md-12">
				                      <!-- text input -->
				                      <div class="form-group">
				                        <label>قيمة الشيك</label>
				                        <input name="check_value[]" type="text" class="form-control" placeholder="قيمة الشيك ..." >
				                      </div>
				                    </div>
				                    <div class="form-group col-md-12">
				                      <!-- text input -->
				                      <div class="form-group">
				                        <label>اضافة علي قيمة الشيك</label>
				                        <input name="increase_value[]" type="text" class="form-control" placeholder="قيمة اضافية ..." >
				                      </div>
				                    </div>

			                     </div>
			                      <!--  here put form postponed values -->
				                  <div class="postponedform col-12">
				                  	<div class="col-xs-12">
				                  	     <h4 class="badge bg-success" style="font-size:14px;color:black"> اضافة دفعات</h4>
				                  	    
				                  	</div>
		                            <div class="form-group col-12">
				                      <!-- text input -->
				                      <div class="form-group">
				                        <label>قيمة  الدفعات</label>
				                        <input name="postponed_value[]" type="text" class="form-control" placeholder="المبلغ المطلوب تسديدة ..." >
				                      </div>
				                    </div>
				                  
				              
				                  
				                  </div>
                                  <!--  here put end of form check of Banck -->

                            @endif
		                  
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
		    	   console.log('hi');		    		
		    	}
		    	else if($(this).val() == 'دفعات'){
		    	   $('.postponedform').fadeIn();
		    	   $('.checkform').fadeOut();		
		    	   console.log('hi');    		
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

         // remove or delete postponed
         $('body').on('click','.postponedform .fa-trash-alt.postponed-delete',function(){
              $(this).parents('.postponedform').remove();
              var order_id = $(this).parents('.postponedform').attr('order_id');
              var postponed_id = $('.input_ids'+order_id).val();
              console.log(postponed_id);
              if(postponed_id!==undefined){
                 $.ajaxSetup({
	                  headers: {
	                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	                  }
                 });
                 jQuery.ajax({
	                  url: "{{ url('/ajax-delete-postponed') }}",
	                  method: 'get',

	                  data: {
	                     postponed_id:postponed_id,
	                  },
	                  success: function(result){
	                     console.log(result.status);
	                     console.log(postponed_id);
	                  }
                });
              }
         });
         
         	jQuery('body').on('keyup','.order_count , .order_taxs ',function(){
        
        	    var order_count     =   Number(jQuery('.order_count').val());
        	    var order_price     =   Number(jQuery('.order_price').val());
        	    var one_price       =   Number(jQuery('.product_id option:selected').attr('data-price'));
        	    var additional_taxs      = Number(jQuery('.order_taxs ').val());
                jQuery('.order_price').val((Number(one_price)+Number(additional_taxs))*Number(order_count) ); 
            });
    </script>
@stop