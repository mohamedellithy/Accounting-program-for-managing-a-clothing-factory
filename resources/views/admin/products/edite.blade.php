@extends('adminlte::page')

@section('title', ' تعديل المنتج')

@section('content_header')
    <h1> تعديل المنتج </h1>
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
		                 <a href="{{ url('products') }}" class="btn btn-info"> الرجوع </a>
		            </div>
		            <!-- general form elements -->
		            @if(!empty($product_info) )
		                @foreach($product_info as $product)
				            <div class="card card-primary">
				              <div class="card-header">
				                <h3 class="card-title"> تعديل المنتج</h3>
				              </div>
				              <!-- /.card-header -->
				              <!-- form start -->
				              <form action="{{ url('products/'.$product->id) }}" role="form" method="POST">
		                        @method('PUT')
                                {{ csrf_field() }}
				                <div class="card-body">

				                   <!-- merchant name  -->
				                   <div class="form-group col-md-12 col-xs-12">
					                  <label for="exampleInputEmail1">اسم المنتج</label>
		                              <input name="name_product" value="{{ (!empty($product) ? $product->name_product :'') }}" type="text" class="form-control" id="exampleInputPassword1" placeholder="اسم قصة القماش" required>
					                </div>

							        <!-- order Category  -->
				                   <div class="form-group col-md-12 col-xs-12">
					                   <label for="exampleInputPassword1">الصنف</label>
					                  <select name="category_id" class="form-control select2" style="width: 100%;" required>

					                   @if(!empty($get_all_categories))
					                       @foreach($get_all_categories as $category)
					                           <option value="{{ $category->id }}" {{ (($product->category_id==$category->id)?'selected':'') }} > {{ $category->category }} </option>
					                       @endforeach
					                   @endif

					                  </select>
					                </div>

					               <!-- order Category  -->
				                   <div class="form-group col-md-12 col-xs-12">
					                   <label for="exampleInputPassword1">عدد القطع</label>
					                   <input name="count_piecies" value="{{ (!empty($product) ? $product->count_piecies :'') }}" type="text" class="form-control count_piecies" id="exampleInputPassword1" placeholder="عدد القطع" required>

					                </div>

					                <!-- order Category  -->
				                   <div class="form-group col-md-12 col-xs-12">
					                   <label for="exampleInputPassword1">سعر القطعة الواحدة</label>
					                   <input name="price_piecies" value="{{ (!empty($product) ? $product->price_piecies :'') }}" type="text" class="form-control price_piecies" id="exampleInputPassword1" placeholder="سعر القطعة الواحدة" required>

					                </div>

					               <!-- order Category  -->
				                   <div class="form-group col-md-12 col-xs-12">
					                   <label for="exampleInputPassword1">مصاريف اضافية</label>
					                   <input name="additional_taxs" value="{{ (!empty($product) ? $product->additional_taxs :'') }}" type="text" class="form-control additional_taxs" id="exampleInputPassword1" placeholder="مصاريف اضافية" required>

					                </div>

					               <!-- order Category  -->
				                   <div class="form-group col-md-12 col-xs-12">
					                   <label for="exampleInputPassword1">السعر الاجمالى</label>
					                   <input name="full_price" value="{{ (!empty($product) ? $product->full_price :'') }}" type="text" class="form-control full_price" id="exampleInputPassword1" placeholder="السعر الاجمالى" required>

					                </div>

				                </div>
				                <!-- /.card-body -->
				            @endforeach
				         @endif

		                <div class="card-footer">
		                  <button type="submit" class="btn btn-primary"> تعديل المنتج </button>
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
        	var count_piecies = Number(jQuery('.count_piecies').val() ) * Number( jQuery('.price_piecies').val() ) + Number(jQuery('.additional_taxs').val() )   ;
            jQuery('.full_price').val(count_piecies);
        });
    </script>
@stop
