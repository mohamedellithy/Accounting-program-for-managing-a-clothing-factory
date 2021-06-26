@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> اضافة شريك </h1>
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
		                <h3 class="card-title">اضافة شريك جديد</h3>
		              </div>
		              <!-- /.card-header -->
		              <!-- form start -->
		              <form action="{{ url('partners') }}" role="form" method="POST">
                        {{ csrf_field() }}
		                <div class="card-body">
		                  <div class="form-group">
		                    <label for="exampleInputEmail1">اسم الشريك</label>
		                    <input name="partner_name" type="name" class="form-control" id="exampleInputEmail1" placeholder="اسم الشريك">
		                  </div>
		                  <div class="form-group">
		                    <label for="exampleInputPassword1">رقم التليفون</label>
		                    <input name="partner_phone" type="phone" class="form-control" id="exampleInputPassword1" placeholder="رقم التليفون">
		                  </div>
		                  <div class="form-group">
		                    <label for="exampleInputPassword1">مبلغ الشراكة بالجنيه</label>
		                    <input name="capital" type="phone" class="form-control " id="exampleInputPassword1" placeholder="نسبة الشراكة">
		                  </div>
		                  <br/>
		                 <!--  <h4 style="font-size:15px;padding: 10px;background-color: #eee;color: blue;"> النسبة المتفق عليها </h4><br/>
		                  <div class="form-group col-md-12">
		                    <label for="exampleInputPassword1">فى حالة ربح مبلغ</label>
		                    <input name="" type="phone" class="form-control original_value" id="exampleInputPassword1 " placeholder="فى حالة ربح مبلغ">
		                  </div>
		                  <div class="form-group col-md-12">
		                    <label for="exampleInputPassword1">مكسب الشريك</label>
		                    <input name="" type="phone" class="form-control profit_value" id="exampleInputPassword1 " placeholder="مكسب الشريك">
		                  </div>
		                  <div class="form-group col-md-12">
		                    <label for="exampleInputPassword1">ناتج نسبة الشريك (%) </label>
		                    <input name="partner_percent" type="phone" class="form-control result" id="exampleInputPassword1 " placeholder="ناتج نسبة الشريك" readonly>
		                  </div>
		               -->
		                </div>
		                <!-- /.card-body -->

		                <div class="card-footer">
		                  <button type="submit" class="btn btn-primary"> اضافة الشريك </button>
		                </div>
		              </form>
		            </div>
		            <!-- /.card -->

		            {{--  here show table of added last  --}}
				    <div class="card">
				      <div class="card-header">
				        <h3 class="card-title">أخر ما تم اضافته من الشركاء</h3>
				      </div>
				      <!-- /.card-header -->
				      <div class="card-body">
				        <table class="table table-bordered">
				          <thead>
				            <tr>
				              <th>#</th>
				              <th>أسم التاجر</th>
				              <th>رقم التليفون</th>
				              <th>تواصل</th>
				              <th>مبلغ الشريك</th>
				              <th>نسبة الشريك الحالية</th>
				              <th>تاريخ الاضافة</th>
				            </tr>
				          </thead>
				          <tbody>
				          	@if($last = (Session::get('last_partner')?Session::get('last_partner'):$last_partner) )
					              <tr>
						              <td>1.</td>
						              <td> {{ $last->partner_name }} </td>
						              <td>
						                  {{ $last->partner_phone }}
						              </td>
						              <td>
						                 <a href="tel:{{ $last->partner_phone }}">  <i class="fab fa-whatsapp-square fa-2x" style="color:#3fad3f" ></i></a>
						                 <a href="tel:{{ $last->partner_phone }}"> <i class="fas fa-lg fa-phone fa-2x" style="color:#007bff"></i></a>

						              </td>
						              <td>
						                  {{ $last->capital }} جنيه
						              </td>
						               <td>
						                  % {{ $last->percent }}
						              </td>
						              <td>
						                  {{ $last->created_at }}
						              </td>

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
     <link rel="stylesheet" href="{{  asset('vendor/adminlte/dist/css/bootstrap-rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/custom.css') }}">
@stop

@section('js')
  <script>
     $('body').on('keyup','.original_value , .profit_value',function(){
        var original_value = $('.original_value').val();
        var profit_value   = $('.profit_value').val();
        var result         = (Number(profit_value)/Number(original_value))*100;
        $('.result').val(result);
     });
  </script>
@stop
