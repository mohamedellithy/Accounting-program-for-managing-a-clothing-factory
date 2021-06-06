@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> تفاصيل الشركاء
          <a href="#" onclick="printDiv('container-print-frame')" class="btn btn-sm btn-info" style="float: left;margin-left: 15px;">طباعة</a> 
    
    </h1>
@stop


@section('content')
    <!-- Main content -->
    <section class="content" id="container-print-frame">
	    <div class="container-fluid">
	        <!-- start row -->
	        <div class="row">

	            <div class="side-by-side col-md-8"> 
	            	<!-- ./col -->
	            	<div class="col-lg-12 col-xs-12">
                        <span class="alert alert-success" style="width: 100%;float: right;"> تفاصيل ارباح الشريك  من تاريخ  {{ partner_date_start($client_id) }}  الى {{ (partner_date_end($client_id)?partner_date_end($client_id):date('Y-m-d')) }} </span>
	            	</div>
		            <div class="col-lg-6 col-6" style="float:right">
			            <!-- small box -->
			            <div class="small-box bg-info">
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

		           <!-- ./col -->
		           <div class="col-lg-6 col-6" style="float:right">
			            <!-- small box -->
			            <div class="small-box bg-info">
			              <div class="inner">
			                <h3 style="font-size: 22px;"> {{ net_profit_partner($client_id) }} جنيه</h3>

			                <p> أرباح الشريك</p>
			              
			              </div>
			              <div class="icon">
			                <i class="ion ion-bag"></i>
			              </div>
			               <a href="#" class="small-box-footer"> أخر تحديث بتاريخ {{ date('Y-m-d') }} <i class="fas fa-arrow-circle-right"></i></a>
			            </div>
		           </div>

		            <!-- ./col -->
		           <div class="col-lg-12 col-12" style="float:right">
			            <!-- small box -->
			            <div class="small-box bg-info">
			              <div class="inner">
			                <h3 style="font-size: 22px;"> {{ partner_capital($client_id) }} + {{ net_profit_partner($client_id) }} = {{ partner_capital($client_id)+net_profit_partner($client_id) }}  جنيه</h3>

			                <p> اجمالى المبلغ الخاص بالشريك ( ماتم دفعه + الربح )</p>
			                @if(check_if_partner_withdraw_profit($client_id) == 0 )
				                <form action="{{ url('withdraw-profit-and-end-partner/'.$client_id) }}" method="post">
				                	{{ csrf_field() }}
				                	<input name="capital_value" value="{{ partner_capital($client_id) }}" hidden>
				                	<input name="net_profit_value" value="{{ net_profit_partner($client_id) }}" hidden>
				                    <button type="submit" class="btn btn-warning"> سحب الارباح و انهاء الشراكة </button>
				                </form>
				            @endif
			              </div>
			              <div class="icon">
			                <i class="ion ion-bag"></i>
			              </div>
			               <a href="#" class="small-box-footer"> أخر تحديث بتاريخ {{ date('Y-m-d') }} <i class="fas fa-arrow-circle-right"></i></a>
			            </div>
		           </div>
		           
		           
                    <div class="card form-posponed-profit" >
		              <div class="card-header border-transparent">
		                <h3 class="card-title">سحب جزء من الارباح</h3>
		              </div>
		                <form method="post" action="{{ url('withdraw-profit-only/'.$client_id) }}">
		                	{{ csrf_field() }}
			               <!-- /.card-header -->
			              <div class="card-body p-0">
			                   <div class="form-group col-12">
			                      <!-- text input -->
			                       @if(check_if_partner_withdraw_profit($client_id) == 0 )
				                      <div class="form-group">
				                        <label>سحب جزء من الارباح</label>
				                        <input name="profit_value" type="text" class="form-control" placeholder="سحب جزء من الارباح ..." required>
				                      </div>
                                   @else
                                      <div class="form-group">
				                        <label>لا توجد ارباح لسحبها</label>
				                      </div>
                                   @endif
			                    </div>
		                  </div>
                          <!--  here put end of form check of Banck -->
                          <!-- /.card-body -->
			                <div class="card-footer">
			                     @if(check_if_partner_withdraw_profit($client_id) == 0 )
			                       <button type="submit" class="btn btn-primary"> سحب جزء من الارباح </button>
			                     @endif
			                </div>
				        </form>
		            </div>

		         
	            <!-- start row orders clothes -->
				   <div class="card" style="float: right;width: 100%;">
		              <div class="card-header border-transparent">
		                <h3 class="card-title">عمليات السحب على الرصيد</h3>
		              </div>
		              <!-- /.card-header -->
		              <div class="card-body p-0">
		                <div class="table-responsive">
		                  <table class="table m-0">
		                    <thead>
		                    <tr>
		                      <th>رقم السحب</th>
		                      <th>قيمة السحب من رأس المال</th>
		                      <th>حالة الشراكة </th>
		                      <th>سحب الارباح</th>
		                      <th>تاريخ السحب</th>
		                      <th>اجمالى المطلوب دفعه</th>
		                    </tr>
		                    </thead>
		                    <tbody>
		                    	
		                    	@if(count($withdraw_info)!=0)
				              	    @foreach($withdraw_info as $get_withdraw_info)
					                    <tr>
					                      <td><a href="pages/examples/invoice.html"> {{ $get_withdraw_info->id }} </a></td>
					                    
					                      <td>{{$get_withdraw_info->withdraw_value }} جنيه</td>
					                      <td>
					                        @if($get_withdraw_info->partners->partner_status!=0)
							                    شراكة منتهية
							                @else
							                    شراكة مستمرة
							                @endif
					                      </td>
					                      <td >
					                      	@if($get_withdraw_info->profit_value==null)
							                    لم يتم السحب الارباح
							                @else
							                    {{ $get_withdraw_info->profit_value }} جنيه
							                @endif
					                      </td>
					                      <td>
					                        {{$get_withdraw_info->created_at }} 
					                      </td>
					                       <td>
					                        {{ $get_withdraw_info->profit_value+$get_withdraw_info->withdraw_value }} جنيه
					                      </td>
					                    </tr>
					                @endforeach
					            @else
					                <tr>
					                	 <td colspan="5" style="text-align:center"> لايوجد اى طلبات </td>
					                </tr>
					            @endif		                   
		                    </tbody>
		                  </table>
		                </div>
		                <!-- /.table-responsive -->
		              </div>
		              <!-- /.card-body -->
		              <div class="card-footer clearfix">
		                <a href="{{ url('withdraw-client-delete/'.$client_id) }}"  class="btn btn-sm btn-info delete_all float-left" data-toggle="modal" data-target="#modal-default"  > <i class="far fa-trash-alt"></i> حذف الطلبات</a>
		                              
		              </div>
		              <!-- /.card-footer -->
		            </div>



	            </div>
	            <!-- start orders clothes -->

	            <!-- start row orders clothes -->
	            <div class="side-by-side col-md-4"> 
		            <!-- general form elements -->
				    <div class="card">
		              <div class="card-header" style="background-color:rgb(253 233 62);">
		                <h3 class="card-title">تفاصيل الشريك</h3>
		              </div>
		              @if(!empty($partner_data))
		              	 @foreach($partner_data as $partner_info)
			              <!-- /.card-header -->
			              <div class="card-body p-0">
			                <ul class="products-list product-list-in-card pl-2 pr-2">
			              
				                  <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">اسم الشريك </a>
				                      <span class="product-description">
				                        {{ $partner_info->partner_name }}
				                      </span>
				                    </div>
				                  </li>

				                  <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">رقم الجوال</a>
				                      <span class="product-description">
				                         {{ $partner_info->partner_phone }}
				                      </span>
				                    </div>
				                  </li>

				                  <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">مبلغ المدفوع من الشريك</a>
				                      <span class="product-description">
				                         {{ partner_capital($partner_info->id) }}
				                      </span>
				                    </div>
				                  </li>

				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">نسبة الشريك</a>
				                      <span class="product-description">
				                         {{ calculate_partner_percentage($partner_info->id) }} %
				                      </span>
				                    </div>
				                  </li>

				                 
			                </ul>
			              </div>
			              <!-- /.card-body -->
			              <div class="card-footer text-center">
				               <a href="tel: {{ $partner_info->partner_phone }}">  <i class="fab fa-whatsapp-square fa-2x" style="color:#3fad3f"></i></a>
	                           <a href="tel: {{ $partner_info->partner_phone }}"> <i class="fas fa-lg fa-phone fa-2x" style="color:#007bff"></i></a>
			              </div>
			              <!-- /.card-footer -->
			            @endforeach
			        @endif
		            </div>
			    </div>
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
       <style type="text/css">
      .card-title label 
      {
      	display: none;
      }
      @media print {  
        table th:nth-child(4) , table th:nth-child(5) , table th:nth-child(6) 
        {
          display:  table-cell;
        }
        table td:nth-child(4) , table td:nth-child(5) , table td:nth-child(6) 
        {
          display:  table-cell;
        }

        table th:nth-child(8) , table th:nth-child(9)  
        {
          display: none;
        }
        table td:nth-child(8) , table td:nth-child(9) 
        {
          display: none;
        }

        table th:nth-child(7) , table th:nth-child(7)  
        {
          display: none !important;
        }
        table td:nth-child(7) , table td:nth-child(7) 
        {
          display: none !important;
        }
	    .btn-info , #postponed-frame
	    {
	      display: none;
	    }
	    .card-title label 
        {
      	  display: block;
        }
        .table-responsive
        {
        	max-height: 100% !important;
        }
        button , .form-posponed-profit
        {
        	display: none !important;
        }
      }
    </style>
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

    <script >
        function printDiv(id_div_container){

            event.preventDefault();

            var printContents = document.getElementById(id_div_container).innerHTML;
                              
             var originalContents = document.body.innerHTML;
             
             document.body.innerHTML = printContents;
             
             window.print();
             
             document.body.innerHTML = originalContents;
             //window.location.reload();
        }
            
        
    </script>
@stop