@extends('adminlte::page')

@section('title', ' تعديل قصات قماش جديدة')

@section('content_header')
    <h1> تعديل قصات قماش جديدة </h1>
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
		            <div class="" style="text-align: left !important;">
		                 <a href="{{ url('piecies') }}" class="btn btn-info"> الرجوع </a>
		            </div>
		            <!-- general form elements -->
		            @if($clothes->exists )
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"> تعديل قصات قماش جديدة</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ url('piecies/'.$clothes->id) }}" role="form" method="POST">
                                @method('PUT')
                                {{ csrf_field() }}
                                <div class="card-body">

                                    <!-- order_clothes_id hidden ID   -->
                                    <input name="order_clothes_id" type="text" class="form-control" value="{{ ($clothes->exists ? $clothes->order_clothes_id :'') }}" id="exampleInputPassword1" placeholder="اسم قصة القماش" hidden>
                                    <!-- merchant name  -->

                                    <!-- order Category  -->
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label for="exampleInputPassword1">الصنف</label>
                                        <input value="{{ $clothes->orders->category_name->category }}"  name="category" type="text" class="form-control" id="exampleInputPassword1" placeholder="" required readonly>
                                    </div>

                                        <div class="form-group col-md-12 col-xs-12">
                                            <label for="exampleInputPassword1">المصنع</label>
                                            <select name="supplier_id" class="form-control select2" style="width: 100%;" >
                                            <option value=""> القص فى المصنع </option>
                                            @if(!empty($get_all_suppliers))
                                                @foreach($get_all_suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}" {{ ( ($supplier->id==$clothes->supplier_id)?'selected':'') }} > {{ $supplier->supplier_name }} </option>
                                                @endforeach
                                            @endif

                                            </select>
                                        </div>

                                    <!-- order Category  -->
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label for="exampleInputPassword1">سعر القطعة من الفاتورة</label>
                                        <input value="{{ $clothes->orders->price_one_piecies }}"  name="category" type="text" class="form-control" id="exampleInputPassword1" placeholder="" required readonly>
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label for="exampleInputEmail1">اسم قصات القماش</label>
                                        <input name="name_piecies" value="{{ ($clothes->exists ? $clothes->name_piecies :'') }}" type="text" class="form-control" id="exampleInputPassword1" placeholder="اسم قصة القماش" required>
                                    </div>

                                    <!-- order Category  -->
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label for="exampleInputPassword1">عدد القطع</label>
                                        <input name="count_piecies" value="{{ ($clothes->exists ? $clothes->count_piecies :'') }}" type="text" class="form-control count_piecies" id="exampleInputPassword1" placeholder="عدد القطع" required>

                                    </div>

                                    <!-- order Category  -->
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label for="exampleInputPassword1">سعر القطعة الواحدة</label>
                                        <input name="price_piecies" value="{{ ($clothes->exists ? $clothes->price_piecies :'') }}" type="text" class="form-control price_piecies" id="exampleInputPassword1" placeholder="سعر القطعة الواحدة" required>

                                    </div>

                                    <!-- order Category  -->
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label for="exampleInputPassword1">مصاريف اضافية</label>
                                        <input name="additional_taxs" value="{{ ($clothes->exists ? $clothes->additional_taxs :'') }}" type="text" class="form-control additional_taxs" id="exampleInputPassword1" placeholder="مصاريف اضافية" required>

                                    </div>

                                    <!-- order Category  -->
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label for="exampleInputPassword1">السعر الاجمالى</label>
                                        <input name="full_price" value="{{ ($clothes->exists ? $clothes->full_price :'') }}" type="text" class="form-control full_price" id="exampleInputPassword1" placeholder="السعر الاجمالى" required>

                                    </div>

                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary"> تعديل قصات القماش </button>
                                </div>
                            </form>
                        </div>
                    @endif

                <!-- /.card -->
	            </div>

	            <div class="col-md-4">
		            <!-- general form elements -->
		            <div class="card card-primary">
		              <div class="card-header">
		                <h3 class="card-title">بيانات طلبية القماش </h3>
		              </div>
		              <div class="card-body">
		              	@if($clothes->orders->exists)
			                  <!-- merchant name  -->
			                    <div class="form-group col-12 col-xs-12">
				                  <label for="exampleInputEmail1">تابعة لفاتورة لرقم</label>
				                  <label style="color:black;font-size:14px;">{{ $clothes->orders->invoice_no }}</label>
				                </div>
				                <hr/>
                               <div class="form-group col-12 col-xs-12">
				                  <label for="exampleInputEmail1">اسم التاجر</label>
				                  <label style="color:black;font-size:14px;">{{ $clothes->orders->merchant->merchant_name }}</label>
				                </div>
				                <hr/>
				                 <!-- merchant name  -->
			                   <div class="form-group col-12 col-xs-12">
				                  <label for="exampleInputEmail1">الصنف</label>
				                  <label style="color:black;font-size:14px;">{{ $clothes->orders->category_name->category }}</label>
				                </div>
				                <hr/>
				                 <!-- merchant name  -->
			                   <div class="form-group col-12 col-xs-12">
				                  <label for="exampleInputEmail1">كمية الطلبية</label>
				                  <label style="color:black;font-size:14px;">{{ $clothes->orders->order_size.' '.$clothes->orders->order_size_type }}</label>
				                </div>
				                <hr/>
				                 <!-- merchant name  -->
			                   <div class="form-group col-12 col-xs-12">
				                  <label for="exampleInputEmail1">سعر الطلبية</label>
				                  <label style="color:black;font-size:14px;">{{ $clothes->orders->order_price.' جنيه ' }}</label>
				                </div>
				                <hr/>
				                 <!-- merchant name  -->
			                   <div class="form-group col-12 col-xs-12">
				                  <label for="exampleInputEmail1">خصم على الطلبية </label>
				                  <label style="color:black;font-size:14px;"> {{ $clothes->orders->order_discount }} </label>
				                </div>
				                <hr/>
				                 <!-- merchant name  -->
			                   <div class="form-group col-12 col-xs-12">
				                  <label for="exampleInputEmail1">طريقة الدفع</label>
				                  <label style="color:black;font-size:14px;">{{ $clothes->orders->payment_type }} </label>
				                </div>
				                <hr/>
				               <!-- merchant name  -->
			                   <div class="form-group col-12 col-xs-12">
				                  <label for="exampleInputEmail1">تاريخ الطلبية </label>
				                  <label style="color:black;font-size:14px;"> {{ $clothes->orders->created_at }} </label>
				                </div>
				        @endif
		                </div>
		                <!-- /.card-body -->
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
		});
    </script>
    <script type="text/javascript">
     /*   var count_piecies = 0;
        var price_piecies = 0;
        var additional_taxs = 0;
        var full_price = 0;*/
        jQuery('.price_piecies , .count_piecies , .additional_taxs ').keyup(function(){
        	var count_piecies = Number(jQuery('.count_piecies').val() ) * ( Number( jQuery('.price_piecies').val() ) + Number(jQuery('.additional_taxs').val() ) );    ;
            jQuery('.full_price').val(count_piecies);
        });
    </script>
@stop
