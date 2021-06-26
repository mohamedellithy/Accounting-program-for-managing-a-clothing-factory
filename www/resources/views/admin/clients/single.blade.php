@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> تفاصيل بالزبون
         <a href="#" onclick="printDiv('container-print-frame')" class="btn btn-sm btn-info" style="float: left;margin-left: 15px;">طباعة</a>

    </h1>
@stop


@section('content')
    <!-- Main content -->

    <section class="content" id="container-print-frame">
	    <div class="container-fluid">
	        <!-- start row -->
	        <div class="row">
	            <!-- start row orders clothes -->
	            <div class="side-by-side col-md-8">
				   <div class="card" id="card_print_1">
		              <div class="card-header border-transparent">
		                <h3 class="card-title">طلبات الشراء الخاصة بالزبون <label> \ {{ $client_info->client_name }} </label> </h3>
		              </div>
		              <!-- /.card-header -->
		              <div class="card-body p-0">
		                <div class="table-responsive" style="max-height: 300px;">
		                  <table class="table m-0">
		                    <thead>
		                    <tr>
		                      <th>رقم الطلب</th>
		                      <th>المنتج</th>
		                      <th>الصنف</th>
		                      <th>الدفع</th>
		                      <th>تاريخ </th>
		                       <th>قيمة الطلبية</th>
		                      <th>تفاصيل </th>
		                    </tr>
		                    </thead>
		                    <tbody>
                                @forelse($order_data_info as $order_info)
                                    <tr>
                                        <td><a href="pages/examples/invoice.html"> {{ $order_info->id }} </a></td>
                                        <td>
                                           {{$order_info->product->name_product }}
                                        </td>
                                        <td>
                                           {{$order_info->product->category->category }}
                                        </td>
                                        <td>
                                           <span class="badge {{ ( ($order_info->payment_type=='نقدى')?'badge-success':'badge-info') }} ">{{ $order_info->payment_type }}  </span>
                                        </td>
                                        <td>
                                           {{$order_info->created_at }}
                                        </td>
                                        <td>
                                            {{ $order_info->final_cost }}
                                        </td>

                                        <td >
                                            <a href="{{ url('single-order/'.($order_info->order_follow?$order_info->order_follow:$order_info->id) ) }}" class="btn btn-sm btn-primary float-left">تفاصيل</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align:center"> لايوجد اى طلبات </td>
                                    </tr>
                                @endforelse
		                    </tbody>
		                  </table>
		                </div>
		                <!-- /.table-responsive -->
		              </div>
		              <!-- /.card-body -->
		              <div class="card-footer clearfix">

                            <table style="width:100%">
                           	   <tr>
                           	      <td style="padding: 12px;background-color: white;border: 1px solid gray;">
                                     التكلفة الاجمالى للطلبات : {{ $total_invoices }} جنيه
                                  </td>



                                  <td style="padding: 12px;background-color: white;border: 1px solid gray;">
                                       المبلغ المدفوع للطلبات:  {{ $Paid + $total_cache   }} جنيه
                                  </td>

                           	      <td style="padding: 12px;background-color: white;border: 1px solid gray;">
                                      المبلغ المتبقى : {{ ($total_not_cache > $Paid ) ? ($total_not_cache - $Paid ) : 0 }} جنيه
                                  </td>


                                </tr>
                                <tr>
                                    <td colspan="4" style="padding: 10px;background-color: wheat;">
                                      تم ادانه المصنع بمبلغ قيمته   {{ $rest_debit }} جنيه
                                    </td>
                                </tr>

                           	</table>
		                  <a href="#" onclick="printDiv('card_print_1')" class="btn btn-sm btn-info float-left">طباعة</a>

		              </div>
		              <!-- /.card-footer -->
		            </div>
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <div class="card" id="card_print_2">
		              <div class="card-header border-transparent">
		                <h3 class="card-title">شيكات مطلوب تسديدها <label> \ {{ $client_info->client_name }} </label> </h3>
		              </div>
		              <!-- /.card-header -->
			              <div class="card-body p-0">
			                <div class="table-responsive" style="max-height: 400px;">
			                  <table class="table m-0">
			                    <thead>
			                    <tr>
			                      <th>رقم الشيك</th>
			                      <th>شيك باسم</th>
			                      <th>تاريخ تسديد الشيك</th>
			                      <th>قيمة الشيك </th>
			                      <th>حالة الشيك </th>
			                      <th>مبالغ اضافية </th>
			                      <th>تفاصيل </th>
			                      <th>تسديد الشيك </th>
			                    </tr>
			                    </thead>
			                    <tbody>

		              	        @if(!empty($client_bankCheck))
			              	        @foreach($client_bankCheck as $bank_check)
			              	           @if(($bank_check->payed_check==null) && ($bank_check->bank_checkable_type=='client') )
						                    <tr>
							                      <td><a href="#"> {{ $bank_check->id }} </a></td>
							                      <td> {{$bank_check->check_owner }} </td>
							                      <td><span class="badge badge-info "> {{$bank_check->check_date }} </span></td>
							                      <td>
							                        <div class="sparkbar" data-color="#00a85a" data-height="20"> {{ $bank_check->check_value }} جنيه </div>
							                      </td>
							                      <td>
						                            <div class="sparkbar" data-color="#00a65a" data-height="20"><span class="badge badge-{{ ( ($bank_check->check_date > date('Y-m-d') )?'warning':'danger') }}"> {{ ( ($bank_check->check_date > date('Y-m-d') )?'منتظر':'منأخر') }} </span></div>
						                          </td>
							                      <td >
							                        	{{ ($bank_check->increase_value?$bank_check->increase_value:'0') }} جنيه
							                      </td>
							                      <td >
							                      	  <a href="#" class="btn btn-sm btn-primary float-left">تفاصيل</a>
							                      </td>
							                      <td>
						                      	    @if($bank_check->payed_check==null)
									                    <a href=" {{ url('approve-cheque/'.$bank_check->id) }}" class="btn btn-success btn-sm"> تسديد </a>
									                @else
									                    تم التسديد
									                @endif
						                          </td>
						                    </tr>
					                    @endif
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
		                 <a href="#" onclick="printDiv('card_print_2')" class="btn btn-sm btn-info float-left">طباعة</a>

		              </div>
		              <!-- /.card-footer -->
		            </div>
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <div class="card" id="card_print_3">
		              <div class="card-header border-transparent" style="background-color:#CDDC39;" >
		                <h3 class="card-title">شيكات تم تسديدها <label> \ {{ $client_info->client_name }} </label> </h3>
		              </div>
		              <!-- /.card-header -->
			              <div class="card-body p-0">
			                <div class="table-responsive" style="max-height: 400px;">
			                  <table class="table m-0">
			                    <thead>
			                    <tr>
			                      <th>رقم الشيك</th>
			                      <th>شيك باسم</th>
			                      <th>تاريخ تسديد الشيك</th>
			                      <th>قيمة الشيك </th>
			                      <th>حالة الشيك </th>
			                      <th>مبالغ اضافية </th>
			                      <th>تفاصيل </th>
			                    </tr>
			                    </thead>
			                    <tbody>
			              	        @if(!empty($client_bankCheck))
				              	        @foreach($client_bankCheck as $bank_check)
				              	           @if(($bank_check->payed_check!=null) && ($bank_check->bank_checkable_type=='client') )
							                    <tr>
								                      <td><a href="#"> {{ $bank_check->id }} </a></td>
								                      <td> {{$bank_check->check_owner }} </td>
								                      <td><span class="badge badge-info "> {{$bank_check->check_date }} </span></td>
								                      <td>
								                        <div class="sparkbar" data-color="#00a85a" data-height="20"> {{ $bank_check->check_value }} جنيه </div>
								                      </td>
								                      <td>
								                        <div class="sparkbar" data-color="#00a65a" data-height="20"><span class="badge badge-success "> تم تسديد </span></div>
								                      </td>
								                      <td >
								                        	{{ ($bank_check->increase_value?$bank_check->increase_value:'0') }} جنيه
								                      </td>
								                      <td >
								                      	  <a href="#" class="btn btn-sm btn-primary float-left">تفاصيل</a>
								                      </td>
							                    </tr>
						                    @endif
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
		                  <a href="#" onclick="printDiv('card_print_3')" class="btn btn-sm btn-info float-left">طباعة</a>

		              </div>
		              <!-- /.card-footer -->
		            </div>

		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->

		            <div class="card" id="card_print_4">
		              <div class="card-header border-transparent">
		                <h3 class="card-title">الدفعات الخاصة بالتاجر <label> \ {{ $client_info->client_name }} </label> </h3>
		              </div>
		              <!-- /.card-header -->
		              <div class="card-body p-0">
		                <div class="table-responsive" style="max-height: 400px;">
		                  <table class="table m-0">
		                    <thead>
		                    <tr>
		                      <th>رقم الدفعة</th>
		                      <th>قيمة الدفعة</th>
		                      <th>تاريخ تسديد الدفعة</th>

		                    </tr>
		                    </thead>
		                    <tbody>
		                    	@if($client_postponed)
		                    	    @foreach($client_postponed as $postponed_data)
		                    	        <tr>
					                      <td><a href="#"> {{ $postponed_data->id }} </a></td>
					                      <td> {{$postponed_data->value }} جنيه </td>
					                      <td><span class="badge badge-info"> {{ $postponed_data->created_at }} </span></td>

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
		                  <a href="#" onclick="printDiv('card_print_4')" class="btn btn-sm btn-info float-left">طباعة</a>

		              </div>
		              <!-- /.card-footer -->
		            </div>


		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->

		             @if( ( $total_not_cache - $Paid ) != 0):
                        <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">تسديد دفعة</h3>
                        </div>
                        <form method="POST" action="{{ url('client/add-payments/'.$client_id) }}">
                            {{ csrf_field() }}
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="table-responsive" style="max-height: 400px;">

                                <div class="form-group col-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>تسديد دفعة من المبلغ</label>

                                        المبلغ المتبقى على العميل : {{ $total_not_cache - $Paid }} جنيه
                                        <input name="postponed_value" type="text" class="form-control" placeholder="المبلغ المطلوب تسديدة ..." required="">

                                    </div>
                                    </div>

                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <button  class="btn btn-sm btn-primary float-left">تسديد دفعة</button>

                            </div>
                            <!-- /.card-footer -->
                        </form>
                        </div>
                     @endif

		                   <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->

		           <!-- here put check -->
                    <form method="post" action="{{ url('add-cheque-for-client/'.$client_id) }}">
                       {{ csrf_field() }}

		              <!--  here put form check of Banck -->
		                  <div class="checkform col-12" style="display:block">
		                  	<div class="col-xs-12">
		                  	     <h4 class="badge bg-danger" style="font-size:14px;color:black"> اضافة شيك </h4>

		                  	</div>
                            <div class="form-group col-md-12">
		                      <!-- text input -->
		                      <div class="form-group">
		                        <label>شيك باسم</label>
		                        <input name="check_owner" value="{{ $client_info->client_name }}" type="text" class="form-control" placeholder="شيك باسم ..." >
		                      </div>
		                    </div>
		                    <div class="form-group col-md-12">
		                      <!-- text input -->
		                      <div class="form-group">
		                        <label>تاريخ تسديد الشيك</label>
		                        <input name="check_date" type="date" class="form-control" placeholder="Enter ..." >
		                      </div>
		                    </div>
		                    <div class="form-group col-md-12">
		                      <!-- text input -->
		                      <div class="form-group">
		                        <label>قيمة الشيك</label>
		                        <input name="check_value" type="text" class="form-control" placeholder="قيمة الشيك ..." >
		                          <input name="order_price" value="{{ $total_invoices - $Paid }}" type="text" class="form-control" placeholder="المبلغ المطلوب تسديدة ..." required="" hidden>

		                      </div>
		                    </div>
		                    <div class="form-group col-md-12">
		                      <!-- text input -->
		                      <div class="form-group">
		                        <label>اضافة علي قيمة الشيك</label>
		                        <input name="increase_value" type="text" class="form-control" placeholder="قيمة اضافية ..." >
		                      </div>
		                    </div>
		                     <button  class="btn btn-sm btn-primary float-left">اضافة شيك</button>

		                  </div>
                          <!--  here put end of form check of Banck -->
                       </form>




	            </div>
	            <!-- start orders clothes -->

	            <!-- start row orders clothes -->
	            <div class="side-by-side col-md-4">
		            <!-- general form elements -->
				    <div class="card">
		              <div class="card-header" style="background-color:rgb(253 233 62);">
		                <h3 class="card-title">تفاضيل العميل</h3>
		              </div>

			              <!-- /.card-header -->
			              <div class="card-body p-0">
			                <ul class="products-list product-list-in-card pl-2 pr-2">

				                  <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">اسم العميل </a>
				                      <span class="product-description">
				                        {{ $client_info->client_name }}
				                      </span>
				                    </div>
				                  </li>

				                  <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">رقم الجوال</a>
				                      <span class="product-description">
				                         {{ $client_info->client_phone }}
				                      </span>
				                    </div>
				                  </li>

				                  <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">عدد الطلبات</a>
				                      <span class="product-description">
				                         {{ $client_info->order_products->count() }}
				                      </span>
				                    </div>
				                  </li>


			                </ul>
			              </div>
			              <!-- /.card-body -->
			              <div class="card-footer text-center">
				               <a href="tel: {{ $client_info->client_phone }}">  <i class="fab fa-whatsapp-square fa-2x" style="color:#3fad3f"></i></a>
	                           <a href="tel: {{ $client_info->client_phone }}"> <i class="fas fa-lg fa-phone fa-2x" style="color:#007bff"></i></a>
			              </div>
			              <!-- /.card-footer -->

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
