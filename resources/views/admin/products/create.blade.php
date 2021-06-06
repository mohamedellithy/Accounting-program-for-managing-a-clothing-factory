@extends('adminlte::page')

@section('title', ' اضافة منتجات جديدة')

@section('content_header')
    <h1> اضافة منتجات جديدة </h1>
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
		                <h3 class="card-title"> اضافة منتجات جديدة</h3>
		              </div>
		              <!-- /.card-header -->
		              <!-- form start -->
		              <form action="{{ url('products') }}" role="form" method="POST">
                        {{ csrf_field() }}
		                <div class="card-body">

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

	                        <!-- merchant name  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                  <label for="exampleInputEmail1">اسم المنتج</label>
                              <input name="name_product" type="text" class="form-control" id="exampleInputPassword1" placeholder="اسم المنتج" required>
			                </div>


			               <!-- order Category  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                   <label for="exampleInputPassword1">عدد القطع</label>
			                   <input name="count_piecies" type="text" class="form-control count_piecies" id="exampleInputPassword1" placeholder="عدد القطع" required>

			                </div>

			                <!-- order Category  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                   <label for="exampleInputPassword1">سعر القطعة الواحدة</label>
			                   <input name="price_piecies" type="text" class="form-control price_piecies" id="exampleInputPassword1" placeholder="سعر القطعة الواحدة" required>

			                </div>

			               <!-- order Category  -->
		                   <div class="form-group col-md-12 col-xs-12">
			                   <label for="exampleInputPassword1">مصاريف اضافية على كل قطعة</label>
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
		                  <button type="submit" class="btn btn-primary"> اضافة المنتج </button>
		                </div>
		              </form>
		            </div>
		            <!-- /.card -->
	            </div>



	        </div>
	        <div class="row">
	        	<div class="col-md-12">
	                {{--  here show table of added last  --}}
				    <div class="card">
				      <div class="card-header">
				        <h3 class="card-title">أخر ما تم اضافته من المنتجات</h3>
				      </div>
				      <!-- /.card-header -->
				      <div class="card-body">
				        <table class="table table-bordered">
				          <thead>
				            <tr>
				              <th>#</th>
				              <th>أسم المنتج</th>
				              <th>الصنف</th>
				              <th>عدد القطع</th>
				              <th>سعر القطعة الواحدة</th>
				              <th>مصاريف اضافية على القطعة</th>
				              <th>السعر الاجمالى</th>
				              <th>تاريخ الاضافة</th>

				            </tr>
				          </thead>
				          <tbody>
	                          @if(!empty($last_products))
	                                <tr>
	                                  <td>1#</td>
	                                  <td> {{ $last_products->name_product }} </td>
	                                  <td> {{ $last_products->category_name->category }} </td>
	                                  <td> {{ $last_products->count_piecies}} قطعة </td>
	                                  <td> {{ $last_products->price_piecies }} جنية </td>
	                                  <td> {{ $last_products->additional_taxs }} جنية </td>
	                                  <td> {{ $last_products->full_price }} جنية </td>
	                                  <td> {{ $last_products->created_at }} </td>
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
        jQuery('.price_piecies , .count_piecies , .additional_taxs ').keyup(function(){
        	var count_piecies = Number(jQuery('.count_piecies').val() ) * ( Number( jQuery('.price_piecies').val() ) + Number(jQuery('.additional_taxs').val() ) )   ;
            jQuery('.full_price').val(count_piecies);
        });
    </script>
@stop
