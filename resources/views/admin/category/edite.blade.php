@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> تعديل تاجر </h1>
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
		                 <a href="{{ url('categories') }}" class="btn btn-info"> الرجوع </a>
		            </div>
		            <!-- general form elements -->
		            <div class="card card-primary">
		              <div class="card-header">
		                <h3 class="card-title">تعديل الصنف</h3>
		              </div>
		              <!-- /.card-header -->
		              <!-- form start -->

		              @foreach($category_data as $category_info)
		              <form action="{{ url('categories/'.$category_info->id) }}" role="form" method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
		                <div class="card-body">
		                  <div class="form-group">
		                    <label for="exampleInputEmail1">اسم الصنف</label>
		                    <input name="category" value="{{ $category_info->category }}" type="name" class="form-control" id="exampleInputEmail1" placeholder="اسم الصنف">
		                  </div>

		                </div>
		                <!-- /.card-body -->

		                <div class="card-footer">
		                  <button type="submit" class="btn btn-primary"> تعديل الصنف </button>
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
    <!-- Bootstrap 4 RTL -->
     <link rel="stylesheet" href="{{  asset('vendor/adminlte/dist/css/bootstrap-rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/custom.css') }}">
@stop

@section('js')


</script>
@stop
