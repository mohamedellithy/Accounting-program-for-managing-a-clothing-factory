@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> اضافة فواتير قماش </h1>
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
		                <h3 class="card-title">اضافة فواتير قماش</h3>
		              </div>
		              <!-- /.card-header -->
		              <!-- form start -->
		              <form action="{{ url('orders-clothes') }}" role="form" method="POST">
                        {{ csrf_field() }}
		                <div class="card-body cardbody">
		                  <!-- merchant name  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                  <label for="exampleInputEmail1">اسم التاجر</label>
			                  <select name="merchant_id" class="form-control select2" style="width: 100%;" required>
			                   @if(!empty($all_merchants))
			                       @foreach($all_merchants as $merchant)
			                           <option value="{{ $merchant->id }}"> {{ $merchant->merchant_name }} </option>
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
			                           <option value="{{ $category->id }}"> {{ $category->category }} </option>
			                       @endforeach
			                   @endif

			                  </select>
			                </div>

		                  <!-- order mensuration  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                   <label for="exampleInputPassword1">نوع الطلبية</label>
			                  <select name="order_size_type" class="form-control select2" style="width: 100%;" required>
			                        <option value="كجم"> كجم </option>
			                        <option value="متر"> متر </option>

			                  </select>
			                </div>


		                  <!-- order value  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">كمية الطلبية</label>
		                    <input data-order="1" name="order_size" type="text" class="form-control order_size order_size1" id="exampleInputPassword1" placeholder="كمية الطلبية" required>
		                  </div>

		                  <!-- order price  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">سعر المتر / كجم بالجنيه</label>
		                    <input data-order="1" name="price_one_piecies" type="text" class="form-control price_one_piecies price_one_piecies1" id="exampleInputPassword1" placeholder="سعر المتر / كجم بالجنيه" required>
		                  </div>

		                  <!-- order discount  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">تخفيض على الطلبية بالجنيه</label>
		                    <input data-order="1" name="order_discount" type="text" class="form-control order_discount order_discount1" id="exampleInputPassword1" placeholder="تخفيض على الطلبية بالجنية">
		                  </div>

		                  <!-- order price  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">سعر الطلبية</label>
		                    <input data-order="1" name="order_price" type="text" class="form-control order_price order_price1" id="exampleInputPassword1" placeholder="سعر الطلبية بالجنية" required>
		                  </div><br/>

		                    <div class="form-group col-xs-12 new-forms" style="float:right;width:100%"></div>
			                <div class="form-group" style="float:right;width:100%">
			                    <button type="button" class="btn btn-info add_new_form">اضافة منتج اخرى فى الفاتورة</button>
			                  <!--   <button type="button" class="btn btn-primary calaulate-bill">حساب التكلفة الكلية : <span class="all-coast">0</span> </button> -->
			                </div>

		                  <!-- order type payment  -->
		                  <div class="form-group col-6 col-xs-12">
		                    <label for="exampleInputPassword1">نوع الدفع</label>
			                  <select name="payment_type" class="form-control payment_type select2" style="width: 100%;" required>
			                        <option value="نقدى"> نقدى </option>
			                        <option value="شيك"> شيك </option>
			                        <option value="دفعات"> دفعات </option>

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
		                        <label>قيمة الشيك  <span class="label_check_value"></span> </label>
		                        <input  name="check_value[]" type="text" class="form-control check_value" placeholder="قيمة الشيك ..." >
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
			                  <select name="other_category_id[]" class="form-control " style="width: 100%;" required>

			                   @if(!empty($get_all_categories))
			                       @foreach($get_all_categories as $category)
			                           <option value="{{ $category->id }}"> {{ $category->category }} </option>
			                       @endforeach
			                   @endif

			                  </select>
			                </div>

		                  <!-- order mensuration  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                   <label for="exampleInputPassword1">نوع الطلبية</label>
			                  <select name="other_order_size_type[]" class="form-control" style="width: 100%;" required>
			                        <option value="كجم"> كجم </option>
			                        <option value="متر"> متر </option>

			                  </select>
			                </div>


		                  <!-- order value  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">كمية الطلبية</label>
		                    <input name="other_order_size[]" type="text" class="form-control order_size order0" id="exampleInputPassword1" placeholder="كمية الطلبية" required>
		                  </div>

		                  <!-- order price  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">سعر المتر / كجم بالجنيه</label>
		                    <input name="other_price_one_piecies[]" type="text" class="form-control price_one_piecies order0" id="exampleInputPassword1" placeholder="سعر المتر / كجم بالجنيه" required>
		                  </div>

		                  <!-- order discount  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">تخفيض على الطلبية بالجنيه</label>
		                    <input name="other_order_discount[]" type="text" class="form-control order_discount order0" id="exampleInputPassword1" placeholder="تخفيض على الطلبية بالجنية">
		                  </div>

		                  <!-- order price  -->
		                  <div class="form-group col-md-12 col-xs-12">
		                    <label for="exampleInputPassword1">سعر الطلبية</label>
		                    <input name="other_order_price[]" type="text" class="form-control order_price order0" id="exampleInputPassword1" placeholder="سعر الطلبية بالجنية" required>
		                  </div><br/>
	                </div>

		            {{--  here show table of added last  --}}
				    <div class="card">
				      <div class="card-header">
				        <h3 class="card-title">أخر ما تم اضافته من فواتير قماش</h3>
				      </div>
				      <!-- /.card-header -->
				      <div class="card-body">
				        <table class="table table-bordered">
				          <thead>
				            <tr>
				              <th>#</th>
				              <th>أسم التاجر</th>
				              <th>الصنف</th>
				              <th>الكمية</th>
				              <th>سعر الطلبية</th>
				              <th>خصم على الطلبية</th>
				              <th>نوع الدفع</th>
				              <th>تاريخ الطلب</th>

				            </tr>
				          </thead>
				          <tbody>
                              @if(!empty($last_order))
                                    <tr>
                                      <td>1#</td>
                                      <td> {{ $last_order->merchant_name->merchant_name }} </td>
                                      <td> {{ $last_order->category_name->category }} </td>
                                      <td> {{ $last_order->order_size .' '.$last_order->order_size_type  }} </td>
                                      <td> {{ $last_order->order_price }} جنية </td>
                                      <td> {{ ($last_order->order_discount?$last_order->order_discount:'0') }} جنيه </td>
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
		    // Initialize Select2 Elements
		    $('.select2').select2({
		      theme: 'bootstrap4'
		    });
		  	var order = 3;

		  	 jQuery('body').on('click','.add_new_form',function(){
		  	 	 var last = order;
		  	 	 order+=1;
		  	 	 // var select=order;
		  	 	// select+=1;
		  	 /*	 jQuery('.container-orders-form select').removeClass('select3');

		  	 	 jQuery('.container-orders-form select').attr('data-order',order);*/

		  	 	/* jQuery('.container-orders-form select.product_id').addClass('select'+order);
		  	 	 jQuery('.container-orders-form select.product_id').removeClass('select'+last);*/
		  	 	 /*jQuery('.container-orders-form select.category_id').removeClass('select'+order);
		  	 	  jQuery('.container-orders-form select.product_id').removeClass('select'+last);
		  	 	 jQuery('.container-orders-form select.category_id').addClass('select'+select);
              */

		  	 	 jQuery('.container-orders-form input.order_size').removeClass('order0');
		  	 	 jQuery('.container-orders-form input.price_one_piecies').removeClass('order0');
		  	 	 jQuery('.container-orders-form input.order_discount').removeClass('order0');
		  	 	 jQuery('.container-orders-form input.order_price').removeClass('order0');


		  	 	 jQuery('.container-orders-form input.order_size').addClass('order_size'+order);
		  	 	 jQuery('.container-orders-form input.price_one_piecies').addClass('price_one_piecies'+order);
		  	 	 jQuery('.container-orders-form input.order_discount').addClass('order_discount'+order);
		  	 	 jQuery('.container-orders-form input.order_price').addClass('order_price'+order);

		  	 	 jQuery('.order_size'+order).removeClass('order_size'+last);
		  	 	 jQuery('.price_one_piecies'+order).removeClass('price_one_piecies'+last);
		  	 	 jQuery('.order_discount'+order).removeClass('order_discount'+last);
		  	 	 jQuery('.order_price'+order).removeClass('order_price'+last);







		  	 	 jQuery('.container-orders-form input.order_size').attr('data-order',order);
		  	 	 jQuery('.container-orders-form input.price_one_piecies').attr('data-order',order);
		  	 	 jQuery('.container-orders-form input.order_discount').attr('data-order',order);
		  	 	 jQuery('.container-orders-form input.order_price').attr('data-order',order);



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
		});
        jQuery('body').on('keyup','.order_size , .price_one_piecies , .order_discount',function(){
        	var order = jQuery(this).attr('data-order');
        	console.log(order);
        	var count_piecies = Number(jQuery('.order_size'+order).val() ) * Number( jQuery('.price_one_piecies'+order).val() );
        	var order_discount_persntage = count_piecies - ( Number(jQuery('.order_discount'+order).val()) * count_piecies )/100;
            jQuery('.order_price'+order).val(order_discount_persntage);
            jQuery('.check_value'+order).val(order_discount_persntage);

        });
        jQuery('body').on('keyup','.check_value',function(){
           var count_piecies = ( Number(jQuery('.order_price'+order).val()) - Number(jQuery('.check_value'+order).val() ) );
           jQuery('.label_check_value').text(' متبقى من المبلغ الاصلي  '+count_piecies);
        });
    </script>
@stop
