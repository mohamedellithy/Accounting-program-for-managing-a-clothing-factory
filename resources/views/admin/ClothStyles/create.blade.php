@extends('adminlte::page')

@section('title', ' اضافة قصات قماش جديدة')

@section('content_header')
    <h1> اضافة قصات قماش جديدة </h1>
@stop


@section('content')
    <!-- Main content -->

    <section class="content">
	    <div class="container-fluid">
	        <div class="row">
	            <!-- left column -->
	            <div class="col-md-8">
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
		                <h3 class="card-title"> اضافة قصات قماش جديدة</h3>
		              </div>
		              <!-- /.card-header -->
		              <!-- form start -->
		              <form action="{{ url('piecies') }}" role="form" method="POST">
                        {{ csrf_field() }}
		                <div class="card-body">
		                    <!-- order_clothes_id hidden ID   -->
                            <input name="order_clothes_id" type="text" class="form-control" value="{{ (!empty($order_clothes_info) ? $order_clothes_info[0]->id :'') }}" id="exampleInputPassword1" placeholder="اسم قصة القماش" hidden>

	                       <!-- order Category  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                   <label for="exampleInputPassword1">الصنف</label>
			                    @if(!empty($order_clothes_info))
		              	            @foreach($order_clothes_info as $order_clothes)
			                           <input value="{{ $order_clothes->category_name->category }}"  name="category" type="text" class="form-control" id="exampleInputPassword1" placeholder="" required readonly>
                                    @endforeach
                                @endif
			                </div>

			                 <div class="form-group col-md-12 col-xs-12">
				                  <label for="exampleInputPassword1">المصنع</label>
				                  <select name="supplier_id" class="form-control supplier_id select2" style="width: 100%;" >
				                   <option value=""> القص فى المصنع </option>
				                   @if(!empty($get_all_suppliers))
				                       @foreach($get_all_suppliers as $supplier)
				                           <option value="{{ $supplier->id }}"> {{ $supplier->supplier_name }} </option>
				                       @endforeach
				                   @endif

				                  </select>
			                 </div>

			                  <div class="form-group col-md-12 col-xs-12 factory_money" style="display:none">
				                  <label for="exampleInputPassword1">مستحقات المصنع</label>
				                  <select name="factory_money" class="form-control  select2" style="width: 100%;" >
				                   <option value="1"> تسديد </option>
				                   <option value="2"> لم يسدد </option>

				                  </select>
			                 </div>

	                       <!-- order Category  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                   <label for="exampleInputPassword1">سعر {{ $order_clothes->order_size_type }} من الفاتورة</label>
			                    @if(!empty($order_clothes_info))
		              	            @foreach($order_clothes_info as $order_clothes)
			                           <input value="{{ $order_clothes->price_one_piecies }}"  name="category" type="text" class="form-control" id="exampleInputPassword1" placeholder="" required readonly>
                                    @endforeach
                                @endif
			                </div>


	                       <!-- merchant name  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                  <label for="exampleInputEmail1">اسم قصات القماش</label>

		                      	@if(!empty($order_clothes_info))
		              	            @foreach($order_clothes_info as $order_clothes)
                                      <input value="{{ $order_clothes->category_name->id }}" name="category_id" type="text" class="form-control" id="exampleInputPassword1" placeholder="اسم قصة القماش" hidden>
                                    @endforeach
                                @endif
                              <input name="name_piecies" type="text" class="form-control" id="exampleInputPassword1" placeholder="اسم قصة القماش" required>
			                </div>

			               <!-- order Category  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                   <label for="exampleInputPassword1">عدد القطع</label>
			                   <input name="count_piecies" type="text" class="form-control count_piecies" order-cost="{{ $order_clothes->order_price }}" id="exampleInputPassword1" placeholder="عدد القطع" required>

			                </div>

			                <!-- order Category  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                   <label for="exampleInputPassword1">سعر القطعة الواحدة</label>
			                     @if(!empty($order_clothes_info))
		              	            @foreach($order_clothes_info as $order_clothes)
			                           <input value="{{ $order_clothes->price_one_piecies }}" name="price_piecies" type="text" class="form-control price_piecies" id="exampleInputPassword1" placeholder="سعر القطعة الواحدة" required>
                                    @endforeach
                                 @endif
			                </div>

			               <!-- order Category  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                   <label for="exampleInputPassword1">مصاريف اضافية علي كل قطعة</label>
			                   <input name="additional_taxs" type="text" class="form-control additional_taxs" id="exampleInputPassword1" placeholder="مصاريف اضافية" required>

			                </div>

			               <!-- order Category  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                   <label for="exampleInputPassword1">السعر الاجمالى</label>
			                   <input name="full_price" type="text" class="form-control full_price" id="exampleInputPassword1" placeholder="السعر الاجمالى" required>

			                </div>

		                </div>
		                <!-- /.card-body -->

		                <div class="card-footer">
		                  <button type="submit" class="btn btn-primary"> اضافة الطلبية </button>
		                </div>
		              </form>
		            </div>
		            <!-- /.card -->
	            </div>

	            <div class="col-md-4">
		            <!-- general form elements -->
		            <div class="card card-primary">
		              <div class="card-header">
		                <h3 class="card-title">بيانات فاتورة القماش </h3>
		              </div>
		              <div class="card-body">
		              	@if(!empty($order_clothes_info))
		              	    @foreach($order_clothes_info as $order_clothes)
			                  <!-- merchant name  -->
			                   <div class="form-group col-12 col-xs-12">
				                  <label for="exampleInputEmail1">اسم التاجر</label>
				                  <label style="color:black;font-size:14px;">{{ $order_clothes->merchant_name->merchant_name }}</label>
				                </div>
				                <hr/>
				                 <!-- merchant name  -->
			                   <div class="form-group col-12 col-xs-12">
				                  <label for="exampleInputEmail1">الصنف</label>
				                  <label style="color:black;font-size:14px;">{{ $order_clothes->category_name->category }}</label>
				                </div>
				                <hr/>
				                 <!-- merchant name  -->
			                   <div class="form-group col-12 col-xs-12">
				                  <label for="exampleInputEmail1">كمية الطلبية</label>
				                  <label style="color:black;font-size:14px;">{{ $order_clothes->order_size.' '.$order_clothes->order_size_type }}</label>
				                </div>
				                <hr/>
                                 <!-- merchant name  -->
			                    <div class="form-group col-12 col-xs-12">
				                  <label for="exampleInputEmail1">سعر القطعة</label>
				                  <label style="color:black;font-size:14px;">{{ $order_clothes->price_one_piecies }} جنيه </label>
				                </div>
				                <hr/>
				                 <!-- merchant name  -->
			                   <div class="form-group col-12 col-xs-12">
				                  <label for="exampleInputEmail1">خصم على الطلبية </label>
				                  <label style="color:black;font-size:14px;"> {{ $order_clothes->order_discount }} جنيه</label>
				                </div>
				                <hr/>
				                 <!-- merchant name  -->
			                   <div class="form-group col-12 col-xs-12">
				                  <label for="exampleInputEmail1">سعر الطلبية</label>
				                  <label style="color:black;font-size:14px;">{{ $order_clothes->order_price.' جنيه ' }}</label>
				                </div>
				                <hr/>
				                 <!-- merchant name  -->
			                   <div class="form-group col-12 col-xs-12">
				                  <label for="exampleInputEmail1">طريقة الدفع</label>
				                  <label style="color:black;font-size:14px;">{{ $order_clothes->payment_type }} </label>
				                </div>
				                <hr/>
				               <!-- merchant name  -->
			                   <div class="form-group col-12 col-xs-12">
				                  <label for="exampleInputEmail1">تاريخ الطلبية </label>
				                  <label style="color:black;font-size:14px;"> {{ $order_clothes->created_at }} </label>
				                </div>

				            @endforeach
				        @endif



		                </div>
		                <!-- /.card-body -->
		            </div>
		            <!-- /.card -->

	            </div>

	        </div>
	        <div class="row">
	        	<div class="col-md-12">
	                {{--  here show table of added last  --}}
				    <div class="card">
				      <div class="card-header">
				        <h3 class="card-title">أخر ما تم اضافته من قصات القماش</h3>
				      </div>
				      <!-- /.card-header -->
				      <div class="card-body">
				        <table class="table table-bordered">
				          <thead>
				            <tr>
				              <th>#</th>
				              <th>أسم قصة القماش</th>
				              <th>الصنف</th>
				              <th>عدد القطع</th>
				              <th>سعر القطعة الواحدة</th>
				              <th>مصاريف اضافية</th>
				              <th>السعر الاجمالى</th>
				              <th>تاريخ الاضافة</th>

				            </tr>
				          </thead>
				          <tbody>
	                          @if(!empty($last_ClothSyles))
	                                <tr>
	                                  <td>1#</td>
	                                  <td> {{ $last_ClothSyles->name_piecies }} </td>
	                                  <td> {{ $last_ClothSyles->order_clothes->category_name->category }} </td>
	                                  <td> {{ $last_ClothSyles->count_piecies}} قطعة </td>
	                                  <td> {{ $last_ClothSyles->price_piecies }} جنية </td>
	                                  <td> {{ $last_ClothSyles->additional_taxs }} جنية </td>
	                                  <td> {{ $last_ClothSyles->full_price }} جنية </td>
	                                  <td> {{ $last_ClothSyles->created_at }} </td>
	                                </tr>
	                          @endif


				          </tbody>
				        </table>
				      </div>
			        </div>
			    </div>
			    <!-- /.card -->
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
		});
    </script>
    <script type="text/javascript">
     /*   var count_piecies = 0;
        var price_piecies = 0;
        var additional_taxs = 0;
        var full_price = 0;*/
        jQuery('.count_piecies').keyup(function(){
             var finalcost = Number(jQuery('.count_piecies').attr('order-cost') ) / Number(jQuery('.count_piecies').val() );
             jQuery('.price_piecies').val(finalcost.toFixed(2));
        });
        jQuery('.price_piecies , .count_piecies , .additional_taxs ').keyup(function(){
        	var count_piecies = Number(jQuery('.count_piecies').val() ) * ( Number( jQuery('.price_piecies').val() ) + Number(jQuery('.additional_taxs').val()) )   ;
            jQuery('.full_price').val(count_piecies.toFixed(2));
        });
    </script>
    <script type="text/javascript">
     jQuery('.supplier_id').change(function(){
           var value_of_supplier  = jQuery(this).val();
           if(value_of_supplier==''){
              jQuery('.factory_money').hide();
           }
           else {
              jQuery('.factory_money').show();
           }
     });
    </script>
@stop
