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
                               <button  type="submit" class="btn btn-info"> بدء سنة مالية جديدة </button>
                               <br/>
        	            </form>
        	            السنة المالية الحالية بتاريخ : {{ Fiscal_Year }}
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
	                    <input name="capital_value" value="{{ get_original_capital_factory() }}" type="text" class="form-control" id="exampleInputPassword1" placeholder="مبلغ رأس المال" required>
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
			                <h3 style="font-size: 22px;"> {{ get_original_capital_factory() }} جنيه</h3>

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
			                <h3 style="font-size: 22px;"> {{ get_all_capital_after_withdraw() }} جنيه </h3>

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
			                <h3 style="font-size: 22px;"> {{ get_outgoings() }} جنيه</h3>

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
			                <h3 style="font-size: 22px;"> {{ net_profit() }} </h3>

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
			                <h3 style="font-size: 22px;"> {{ net_profit_after_withdraw() }} </h3>

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
	                    	   <td> {{ get_original_capital_factory() }} جنيه </td>
	                    	   <td> {{ calculate_factory_percentage() }} %</td>
	                    	   <td> {{ get_net_profit_for_factory()." + مبلغ مسحوب : ".factory_prodfit_withdraw() }} جنيه </td>
	                    	   <td> مستمر </td>
                            </tr>	 
                            @if(!empty($all_partners))
	                            @foreach ($all_partners as $partner)
		                        <tr>
		                    	   <td> {{ $partner->partner_name }} </td>
		                    	   <td>
		                    	        @if(get_capital_partner_after_withdraw($partner->id)):
		                    	   	       {{ get_capital_partner_after_withdraw($partner->id) }} جنيه
		                    	   	    @endif 
		                    	      
		                    	   </td>
		                    	   <td> {{ calculate_partner_percentage($partner->id) }} %</td>
		                    	    <td> 
		                    	    	@if(net_profit_partner($partner->id)):
		                    	   	       {{ net_profit_partner($partner->id)." + مبلغ مسحوب : ".partner_prodfit_withdraw($partner->id) }} جنيه
		                    	   	    @else
		                    	   	       {{ partner_prodfit_withdraw($partner->id) }}
		                    	   	       <?php // (!empty(App\withdraw::where('created_at','>=',Carbon\Carbon::now()->firstOfYear()->toDateTimeString())->where(['partner_id'=>$partner->id])->pluck('profit_value')[0])?App\withdraw::where('created_at','>=',Carbon\Carbon::now()->firstOfYear()->toDateTimeString())->where(['partner_id'=>$partner->id])->pluck('profit_value')[0]:'0') }} ?> جنيه
		                    	   	    @endif 
		                    	   	</td>
		                    	   <td> {{ ($partner->partner_status?'منتهية':'مستمرة') }} </td>
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