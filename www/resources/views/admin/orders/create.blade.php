@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> اضافة طلبيات شراء </h1>
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
		                <h3 class="card-title">اضافة طلبات شراء</h3>
		              </div>
		              <!-- /.card-header -->
		              <!-- form start -->
		              <form action="{{ url('orders') }}" role="form" method="POST">
                        {{ csrf_field() }}
		                <div class="card-body cardbody" id="order0">
			                <!-- merchant name  -->
		                   <div class="form-group col-12 col-xs-12">
			                  <label for="exampleInputEmail1">اسم الزبون</label>
			                  <select name="client_id" class="form-control select2" style="width: 100%;" >
			                     <option value=""> بدون تحديد </option>
			                   @if(!empty($all_clients))
			                       @foreach($all_clients as $client)
			                           <option value="{{ $client->id }}"> {{ $client->client_name }} </option>
			                       @endforeach
			                   @endif
			                  </select>
			                </div>

		                    <div class="col-xs-12">

	                           <!-- order Category  -->
			                   <div class="form-group col-md-12 col-xs-12">
				                   <label for="exampleInputPassword1">الصنف</label>
				                  <select name="category_id" class="form-control select2" style="width: 100%;" >
				                   <option > بدون تحديد </option>
				                   @if(!empty($get_all_categories))
				                       @foreach($get_all_categories as $category)
				                           <option value="{{ $category->id }}"> {{ $category->category }} </option>
				                       @endforeach
				                   @endif

				                  </select>
				                </div>

				              <!-- product name  -->
			                   <div class="form-group col-md-12 col-xs-12">
				                  <label for="exampleInputEmail1">اسم المنتج</label>
				                  <select data-order="0" name="product_id" class="form-control select2 product_id" style="width: 100%;" required>
				                   <option count-pieceis="0" additional-taxs="0" data-price="0" value="">اسم المنتج</option>
				                   @if(!empty($all_products))
				                       @foreach($all_products as $product)
				                           <option count-pieceis="{{ $product->count_piecies }}" additional-taxs="{{ $product->additional_taxs }}" data-price="{{ round($product->price_piecies,2) }}" value="{{ $product->id }}"> {{ $product->name_product }} </option>
				                       @endforeach
				                   @endif
				                  </select>
				                </div>

			                  <!-- order value  -->
			                  <div class="form-group col-md-12 col-xs-12">
			                    <label for="exampleInputPassword1">كمية الطلبية</label>
			                    <label for="exampleInputPassword1" style="font-size: 12px;float: left;">الكمية المتوفرة : <span class="available_order0"> 0 </span> </label>
			                    <input name="order_count" data-order="0" value="0" type="text" class="form-control order_count order_count0" id="exampleInputPassword1" placeholder="كمية الطلبية" required>
			                  </div>

			                  <!-- order price  -->
			                  <div class="form-group col-md-12 col-xs-12">
			                    <label for="exampleInputPassword1">سعر الطلبية</label>
			                    <input name="order_price" type="text" class="form-control order_price order0" id="exampleInputPassword1" placeholder="سعر الطلبية بالجنية" required>
			                  </div>
			                   <!-- order discount  -->
			                  <div class="form-group col-md-12 col-xs-12">
			                    <label for="exampleInputPassword1">تخفيض على الطلبية</label>
			                    <input name="order_discount" type="text" class="form-control" id="exampleInputPassword1" placeholder="تخفيض على الطلبية بالنسبة او بالجنية">
			                  </div>

			                  <!-- order discount  -->
			                  <div class="form-group col-md-12 col-xs-12">
			                    <label for="exampleInputPassword1">مصاريف زائدة</label>
			                    <input name="order_taxs" type="text" class="form-control" id="exampleInputPassword1" placeholder="تخفيض على الطلبية بالنسبة او بالجنية">
			                  </div>
			                </div>



			                <div class="form-group col-xs-12 new-forms" ></div>
			                <div class="form-group">
			                    <button type="button" class="btn btn-info add_new_form">اضافة منتج اخرى فى الفاتورة</button>
			                  <!--   <button type="button" class="btn btn-primary calaulate-bill">حساب التكلفة الكلية : <span class="all-coast">0</span> </button> -->
			                </div>



		                  <!-- order type payment  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">نوع الدفع</label>
			                  <select name="payment_type" class="form-control payment_type select2" style="width: 100%;" required>
			                        <option value="نقدى"> نقدى </option>
			                        <option value="شيك"> شيك </option>
			                        <option value="دفعات">  دفعات </option>
			                  </select>
			              </div>

			              <!--  here put form check of Banck -->
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
                          <!--  here put end of form check of Banck -->

                           <!--  here put form postponed values -->
		                  <div class="postponedform col-12">
		                  	<div class="col-xs-12">
		                  	     <h4 class="badge bg-success" style="font-size:14px;color:black">تسديد دفعات</h4>

		                  	     <i class="far fa-trash-alt" aria-hidden="true"></i>
		                  	</div>
                            <div class="form-group col-12">
		                      <!-- text input -->
		                      <div class="form-group">
		                        <label>تسديد دفعة من المبلغ</label>
		                        <input name="postponed_value" type="text" class="form-control" placeholder="المبلغ المطلوب تسديدة ..." >
		                      </div>
		                    </div>

		                  </div>
                          <!--  here put end of form check of Banck -->


		                </div>
		                <!-- /.card-body -->
		                <div class="card-footer">
		                  <button type="submit" class="btn btn-primary"> اضافة الطلبية </button>
		                </div>
		              </form>
		            </div>
		            <!-- /.card -->

                 <div class="col-xs-12 container-orders-form" style="display:none">

                       <!-- order Category  -->
	                   <div class="form-group col-md-12 col-xs-12">
		                   <label for="exampleInputPassword1">الصنف</label>
		                  <select name="other_category_id[]" class="form-control category_id" style="width: 100%;" >
		                   <option > بدون تحديد </option>
		                   @if(!empty($get_all_categories))
		                       @foreach($get_all_categories as $category)
		                           <option value="{{ $category->id }}"> {{ $category->category }} </option>
		                       @endforeach
		                   @endif

		                  </select>
		                </div>

		              <!-- product name  -->
	                   <div class="form-group col-md-12 col-xs-12">
		                  <label for="exampleInputEmail1">اسم المنتج</label>
		                  <select data-order="0" name="other_product_id[]" class="form-control product_id" style="width: 100%;">
		                   <option count-pieceis="0" additional-taxs="0" data-price="0" value="">اسم المنتج</option>
		                   @if(!empty($all_products))
		                       @foreach($all_products as $product)
		                           <option count-pieceis="{{ $product->count_piecies }}" additional-taxs="{{ $product->additional_taxs }}" data-price="{{ $product->price_piecies }}" value="{{ $product->id }}"> {{ $product->name_product }} </option>
		                       @endforeach
		                   @endif
		                  </select>
		                </div>

	                  <!-- order value  -->
	                  <div class="form-group col-md-12 col-xs-12">
	                    <label for="exampleInputPassword1">كمية الطلبية</label>
	                    <label for="exampleInputPassword1" style="font-size: 12px;float: left;">الكمية المتوفرة : <span class="available_order0"> 0 </span> </label>
	                    <input name="other_order_count[]" data-order="0" value="0" type="text" class="form-control order_count order_count0" id="exampleInputPassword1" placeholder="كمية الطلبية" >
	                  </div>

	                  <!-- order price  -->
	                  <div class="form-group col-md-12 col-xs-12">
	                    <label for="exampleInputPassword1">سعر الطلبية</label>
	                    <input name="other_order_price[]" type="text" class="form-control order_price order0" id="exampleInputPassword1" placeholder="سعر الطلبية بالجنية" >
	                  </div>

	                   <!-- order discount  -->
	                  <div class="form-group col-md-12 col-xs-12">
	                    <label for="exampleInputPassword1">تخفيض على الطلبية</label>
	                    <input name="other_order_discount[]" type="text" class="form-control" id="exampleInputPassword1" placeholder="تخفيض على الطلبية بالنسبة او بالجنية">
	                  </div>

	                  <!-- order discount  -->
	                  <div class="form-group col-md-12 col-xs-12">
	                    <label for="exampleInputPassword1">مصاريف زائدة</label>
	                    <input name="other_order_taxs[]" type="text" class="form-control" id="exampleInputPassword1" placeholder="تخفيض على الطلبية بالنسبة او بالجنية">
	                  </div>

	                </div>

		            {{--  here show table of added last  --}}
				    <div class="card">
				      <div class="card-header">
				        <h3 class="card-title">أخر طلبات الشراء</h3>
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
				              <th>سعر الطلبية</th>
				              <th>خصم </th>
				              <th>مصروفات زائدة </th>
				              <th>اسم الزبون </th>
				              <th>نوع الدفع</th>
				              <th>تاريخ الطلب</th>

				            </tr>
				          </thead>
				          <tbody>
                              @if(!empty($last_order))
                                    <tr>
                                      <td>1#</td>
                                      <td> {{ $last_order->product->name_product }} </td>
                                      <td> {{ $last_order->product->category->category }} </td>
                                      <td> {{ $last_order->order_count  }} </td>
                                      <td> {{ $last_order->order_price }} جنية </td>
                                      <td> {{ ($last_order->order_discount?$last_order->order_discount:'بدون') }} </td>
                                      <td> {{ ($last_order->order_taxs?$last_order->order_taxs:'بدون') }} </td>
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
		      theme: 'bootstrap4'
		    });
		  	var order = 3;

		  	 jQuery('body').on('click','.add_new_form',function(){
		  	 	 var last = order;
		  	 	 order+=1;
		  	 	 //var select=order;
		  	 	// select+=1;
		  	 	 jQuery('.container-orders-form select').removeClass('select3');

		  	 	 jQuery('.container-orders-form select').attr('data-order',order);

		  	 	/* jQuery('.container-orders-form select.product_id').addClass('select'+order);
		  	 	 jQuery('.container-orders-form select.product_id').removeClass('select'+last);*/
		  	 	 /*jQuery('.container-orders-form select.category_id').removeClass('select'+order);
		  	 	  jQuery('.container-orders-form select.product_id').removeClass('select'+last);
		  	 	 jQuery('.container-orders-form select.category_id').addClass('select'+select);
              */


		  	 	 jQuery('.container-orders-form input.order_price').removeClass('order0');
		  	 	 jQuery('.container-orders-form input.order_count').removeClass('order_count0');

		  	 	 jQuery('.container-orders-form input.order_price').addClass('order'+order);
		  	 	 jQuery('.container-orders-form input.order_count').addClass('order_count'+order);

		  	 	 jQuery('.container-orders-form input').attr('data-order',order);

		  	 	 jQuery('.container-orders-form available_order0').addClass('available_order'+order);

		  	 	 jQuery('.container-orders-form available_order0').removeClass('available_order0');



                 var content_form = jQuery('.container-orders-form').html();
                 jQuery('.new-forms').append(content_form);
                 console.log('hi');
	              /*  $('.select'+order).select2({
		               theme: 'bootstrap4'
	    		    });*/

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
		    var element;
            var one_price;
            var count_pieceis;
            var order_number;
            var order_count;
            var total = [];
            jQuery('body').on('change','.product_id',function(){

	              element         = $(this).find('option:selected');
	              one_price      = element.attr('data-price');
	              additional_taxs   = element.attr('additional-taxs');
                  order_number    = jQuery(this).attr('data-order');
                  order_count     = jQuery('.order_count'+order_number).val();
                  count_pieceis     = element.attr('count-pieceis');
	              jQuery('.order'+order_number).val((Number(one_price)+Number(additional_taxs))*order_count );
	              jQuery('.available_order'+order_number).text(count_pieceis);
	              if(count_pieceis==0){
	              	jQuery('.order_count'+order_number).attr('disabled',true);
	              }else{
	              	 	jQuery('.order_count'+order_number).attr('disabled',false);
	              }
	              console.log(element);
	              console.log(one_price);
	              console.log(count_pieceis);
	              console.log(order_number);
	              console.log(order_count);
	        });


	    	jQuery('body').on('keyup','.order_count',function(){
        	    order_number    = jQuery(this).attr('data-order');
        	    order_count     = jQuery(this).val();
                jQuery('.order'+order_number).val((Number(one_price)+Number(additional_taxs))*order_count );
        	    total[order_number]= (Number(one_price)+Number(additional_taxs))*order_count;

        	    /*var count_piecies = Number(jQuery('.count_piecies').val() ) * ( Number( jQuery('.price_piecies').val() ) + Number(jQuery('.additional_taxs').val()) )   ;
                jQuery('.full_price').val(count_piecies);*/
            });

            jQuery('.calaulate-bill').click(function(){
               console.log(total);
               var all;
               $.each(total,function(x,y){
               	   all= Number(all)+Number(y);

               });
               jQuery('.all-coast').text(all);

            });

		});
    </script>
@stop
