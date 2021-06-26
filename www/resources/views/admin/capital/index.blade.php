@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> تفاصيل الشركاء </h1>
@stop


@section('content')
    <!-- Main content -->
    <section class="content">
	    <div class="container-fluid">
	        <!-- start row -->
	        <div class="row">
                <div class="col-md-12">
                    @if($message = Session::get('success'))
                        <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> تمت</h5>
                        {{ $message }}
                        </div>
                    @endif
                    <div class="card card-default">
                        <div class="card-body">
                            <!-- general form elements -->
                            <form method="post" action="{{ url('start-Fiscal-year') }}">
                                {{ csrf_field() }}

                                <br/>
                            </form>
                            السنة المالية الحالية بتاريخ : {{ Fiscal_Year() }}
                        </div>
                    </div>
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">رصيد رأس المال</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ url('create-capital') }}" role="form" method="POST">
                            {{ csrf_field() }}
                            <div class="card-body">
                            <div class="form-group col-6 col-xs-12" style="float:right">
                                <label for="exampleInputPassword1">مبلغ رأس المال</label>
                                <input name="capital_value" value="{{ $Capital->value }}" type="text" class="form-control" id="exampleInputPassword1" placeholder="مبلغ رأس المال" required>
                            </div>
                            <button type="submit" class="btn btn-success" style="float:right;margin-top: 34px;"> تعديل رأس المال </button>
                            </div>
                            <!-- /.card-body -->
                        </form>
                    </div>
                    <!-- /.card -->

                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">سحب من رصيد رأس المال</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ url('create-withdraw-capital') }}" role="form" method="POST">
                            {{ csrf_field() }}
                            <div class="card-body">
                            <div class="form-group col-6 col-xs-12" style="float:right">
                                <label for="exampleInputPassword1">المبلغ المطلوب سحبه</label>
                                <input name="withdraw_value" type="text" class="form-control" id="exampleInputPassword1" placeholder="المبلغ المطلوب سحبه" required>
                            </div>
                            <button type="submit" class="btn btn-success" style="float:right;margin-top: 34px;"> سحب من رأس المال </button>
                            </div>
                            <!-- /.card-body -->
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
	            <div class="side-by-side col-md-12">
	            	<!-- ./col -->
	            	<div class="col-lg-12 col-xs-12">
                        <span class="alert " style="width: 100%;float: right;"> تفاصيل ارباح المصنع  لعام {{ date('Y') }} </span>
	            	</div>
		            <div class="col-lg-3 col-12" style="float:right">
			            <!-- small box -->
			            <div class="small-box bg-warning">
			              <div class="inner">
			                <h3 style="font-size: 22px;"> {{  $Capital->value }} جنيه</h3>

			                <p> رأس مال المصنع</p>
			              </div>
			              <div class="icon">
			                <i class="ion ion-bag"></i>
			              </div>
			              <a href="#" class="small-box-footer"> أخر تحديث بتاريخ {{ date('Y-m-d') }} <i class="fas fa-arrow-circle-right"></i></a>
			            </div>
		            </div>
		            <div class="col-lg-3 col-12" style="float:right">
			            <!-- small box -->
			            <div class="small-box bg-warning">
			              <div class="inner">
			                <h3 style="font-size: 22px;"> {{ $all_partners->sum('capital') +  $Capital->value }} جنيه </h3>

			                <p> رأس مال المصنع بالاضافة لمبالغ الشركاء</p>
			              </div>
			              <div class="icon">
			                <i class="ion ion-bag"></i>
			              </div>
			              <a href="#" class="small-box-footer"> أخر تحديث بتاريخ {{ date('Y-m-d') }} <i class="fas fa-arrow-circle-right"></i></a>
			            </div>
		            </div>
		            <div class="col-lg-3 col-12" style="float:right">
			            <!-- small box -->
			            <div class="small-box bg-warning">
			              <div class="inner">
			                <h3 style="font-size: 22px;"> {{ $out_goings }} جنيه</h3>

			                <p> مشتريات المصنع</p>
			              </div>
			              <div class="icon">
			                <i class="ion ion-bag"></i>
			              </div>
			              <a href="#" class="small-box-footer"> أخر تحديث بتاريخ {{ date('Y-m-d') }} <i class="fas fa-arrow-circle-right"></i></a>
			            </div>
		            </div>
		            <div class="col-lg-3 col-12" style="float:right">
			            <!-- small box -->
			            <div class="small-box bg-warning">
			              <div class="inner">
			                <h3 style="font-size: 22px;"> {{ Net_profit() }} </h3>

			                <p> أرباح المصنع هذا العام</p>
			              </div>
			              <div class="icon">
			                <i class="ion ion-bag"></i>
			              </div>
			              <a href="#" class="small-box-footer"> أخر تحديث بتاريخ {{ date('Y-m-d') }} <i class="fas fa-arrow-circle-right"></i></a>
			            </div>
		            </div>
		            <div class="clearfix"></div>
		             <div class="col-lg-3 col-12" style="float:right">
			            <!-- small box -->
			            <div class="small-box bg-warning">
			              <div class="inner">
			                <h3 style="font-size: 22px;"> {{ Calculate_Profit_After_Withdraw() }} </h3>

			                <p> أرباح المصنع  بعد السحب</p>
			              </div>
			              <div class="icon">
			                <i class="ion ion-bag"></i>
			              </div>
			              <a href="#" class="small-box-footer"> أخر تحديث بتاريخ {{ date('Y-m-d') }} <i class="fas fa-arrow-circle-right"></i></a>
			            </div>
		            </div>
		            <div class="col-lg-12 col-xs-12">
                        <span class="alert" style="width: 100%;float: right;"> تفاصيل ارباح المصنع و الشركاء  لعام {{ date('Y') }} </span>
	            	</div>
            	    <div class="table-responsive" style="max-height: 400px;background-color:white">
	                  <table class="table m-0">
	                    <thead>
                           <tr>
	                    	   <th> الشريك </th>
	                    	   <th> المبلغ المدفوع </th>
	                    	   <th> نسبة الشريك فى الربح </th>
	                    	   <th> قيمة الربح </th>
	                    	   <th> حالة الربح </th>
                           </tr>
	                    </thead>
	                    <tbody>
	                        <tr>
	                    	   <td> راس مال المصنع </td>
	                    	   <td> {{ FactoryCapital() }} جنيه </td>
	                    	   <td> {{ $Factory_percent }} %</td>
	                    	   <td> {{ $Last_Profit_Capital + $Factory_Profit." + مبلغ مسحوب : ".factory_prodfit_withdraw() }} جنيه </td>
	                    	   <td> مستمر </td>
                            </tr>
                            @if(!empty($all_partners))
	                            @foreach ($all_partners as $partner)
		                        <tr {{ $partner->partner_status == 1 ? 'style=background-color:lightgray' : '' }} >
		                    	   <td> {{ $partner->partner_name }} </td>
		                    	   <td> {{ $partner->capital }} جنية </td>
		                    	   <td> {{ $partner->percent }} %    </td>
		                    	   <td>
		                    	    	@if($partner->partner_cache_profits):
		                    	   	       {{  ($partner->partner_status == 1 ? 0 : $partner->partner_cache_profits)." + مبلغ مسحوب : ".$partner->withdraw()->sum('value') }} جنيه
		                    	   	    @else
		                    	   	       {{  $partner->last_profits + $partner->withdraw->sum('value') }}
		                    	   	    @endif
		                    	   	</td>
		                    	    <td> {{ $partner->partner_status == 1 ? 'منهية' : 'مستمرة'  }} </td>
	                            </tr>
	                            @endforeach
	                        @endif
	                    </tbody>
	                  </table>
	                </div>
	            </div>
	            <!-- start orders clothes -->
			 </div>
			 <!-- end row -->
		</div>
    </section>
    <div class="modal fade show" id="modal-default"  aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">تأكيد حذف تاجر</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>تأكيد حذف المحدد من جدول التجار</p>
            </div>
            <div class="modal-footer justify-content-between">

                <a type="button" href="#" class="btn btn-primary " id="confirm_delete" >تأكيد الحذف</a>
            </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>



@stop

@section('css')
    <!-- Bootstrap 4 RTL -->
     <link rel="stylesheet" href="{{  asset('vendor/adminlte/dist/css/bootstrap-rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/custom.css') }}">
@stop

@section('js')
  <script type="text/javascript">
      var typeAlert = "";
      $('body').on('click','.delete_all',function(event){
          typeAlert = jQuery(this).attr('href');
          event.preventDefault();
      });
      $('#confirm_delete').click(function(){
        if(!typeAlert){
          $('form#form_delete_select').submit();
        }
        else
        {
          window.location.href=typeAlert;
        }
      });
  </script>
@stop
