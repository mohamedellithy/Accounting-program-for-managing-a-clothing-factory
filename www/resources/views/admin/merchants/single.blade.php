@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> تفاصيل التاجر
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
		                <h3 class="card-title">طلبات القماش الخاصة بالتاجر <label > \ {{ $merchant_data->merchant_name }}</label> </h3>
		              </div>
		              <!-- /.card-header -->
		              <div class="card-body p-0">
		                <div class="table-responsive" style="max-height: 300px;">
		                  <table class="table m-0">
		                    <thead>
		                    <tr>
		                      <th>رقم الطلب</th>
		                      <th>الطلبية</th>
		                      <th>الدفع</th>
		                      <th>تاريخ </th>
		                      <th>قيمة الطلبية</th>
		                      <th>تفاصيل </th>
		                    </tr>
		                    </thead>
		                    <tbody>

                                @forelse($order_clothes_info as $order_clothes)
                                    <tr>
                                        <td><a href="pages/examples/invoice.html"> {{ $order_clothes->id }} </a></td>
                                        <td>{{$order_clothes->category_name->category }}</td>
                                        <td>
                                            <span class="badge {{ ( ($order_clothes->payment_type=='نقدى')?'badge-success':'badge-info') }} ">{{ $order_clothes->payment_type }}  </span>
                                        </td>
                                        <td>
                                        <div class="sparkbar" data-color="#00a65a" data-height="20"> {{$order_clothes->created_at }} </div>
                                        </td>
                                        <td> {{ $order_clothes->total_invoice }} جنيه </td>
                                        <td >
                                            <a href="{{ url('orders-clothes/'.($order_clothes->order_follow?$order_clothes->order_follow:$order_clothes->id) ) }}" class="btn btn-sm btn-primary float-left">تفاصيل</a>
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
                                      المبلغ الاجمالى : {{ $total }} جنيه
                                  </td>

                                  <td style="padding: 12px;background-color: white;border: 1px solid gray;">
                                       المبلغ المدفوع للطلبات:  {{ $paid + $total_cache   }} جنيه
                                  </td>

                           	      <td style="padding: 12px;background-color: white;border: 1px solid gray;">
                                      المبلغ المتبقى : {{ ($total_not_cache < $paid ) ?'0 ':($total_not_cache - $paid ) }} جنيه
                                  </td>


                                </tr>
                                <tr>
                                    <td colspan="4" style="padding: 10px;background-color: wheat;">
                                       ادانة التاجر بمبلغ قيمته  {{ $debits_not_payed }} جنيه
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

		            <div class="card" id="card_print_2">
		              <div class="card-header border-transparent">
		                <h3 class="card-title">شيكات مطلوب تسديدها <label > \ {{ $merchant_data->merchant_name }}</label> </h3>
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
                                @forelse($merchant_bankCheck as $bank_check)
                                    @if(($bank_check->payed_check==null) && ($bank_check->bank_checkable_type=='merchant') )
                                        <tr>
                                            <td><a href="#"> {{ $bank_check->id }} </a></td>
                                            <td> {{$bank_check->check_owner }} </td>
                                            <td><span class="badge {{ ( ($order_clothes->payment_type=='نقدى')?'badge-success':'badge-info') }} "> {{$bank_check->check_date }} </span></td>
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
		                <a href="#" onclick="printDiv('card_print_2')"  class="btn btn-sm btn-info float-left">طباعة</a>

		              </div>
		              <!-- /.card-footer -->
		            </div>
		             <!-- --------------------------------------------------------------- -->
		             <!-- --------------------------------------------------------------- -->
		             <!-- --------------------------------------------------------------- -->
		             <!-- --------------------------------------------------------------- -->
		             <!-- --------------------------------------------------------------- -->

		            <div class="card" id="card_print_3">
		              <div class="card-header border-transparent" style="background-color:#CDDC39;" >
		                <h3 class="card-title">شيكات تم تسديدها  <label > \ {{ $merchant_data->merchant_name }}</label> </h3>
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
                                    @forelse($merchant_bankCheck as $bank_check)
                                        @if(($bank_check->payed_check!=null) && ($bank_check->bank_checkable_type=='merchant') )
                                            <tr>
                                                <td>
                                                   <a href="#"> {{ $bank_check->id }} </a>
                                                </td>
                                                <td>
                                                   {{$bank_check->check_owner }}
                                                </td>
                                                <td>
                                                    <span class="badge {{ ( ($order_clothes->payment_type=='نقدى')?'badge-success':'badge-info') }} "> {{$bank_check->check_date }} </span>
                                                </td>
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
		                <h3 class="card-title">الدفعات الخاصة بالتاجر <label > \ {{ $merchant_data->merchant_name }}</label> </h3>
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
		                    	@forelse($merchant_postponed as $postponed_data)
                                    <tr>
                                        <td><a href="#"> {{ $postponed_data->id }} </a></td>
                                        <td> {{$postponed_data->value }} جنيه </td>
                                        <td><span class="badge badge-info"> {{ $postponed_data->created_at }} </span></td>
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
		                <a href="#" onclick="printDiv('card_print_4')"  class="btn btn-sm btn-info float-left">طباعة</a>

		              </div>
		              <!-- /.card-footer -->
		            </div>

		              <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->

		            <div class="card" id="postponed-frame">
		              <div class="card-header border-transparent">
		                <h3 class="card-title">تسديد دفعة</h3>
		              </div>
		              <form method="POST" action="{{ url('merchant/add-postponed/'.$merchant_data->id) }}">
		              	  {{ csrf_field() }}
			              <!-- /.card-header -->
			              <div class="card-body p-0">
			                <div class="table-responsive" style="max-height: 400px;">

      						   <div class="form-group col-12">
			                      <!-- text input -->
			                      <div class="form-group">
			                        <label>تسديد دفعة من المبلغ</label>
                                    @if( ( $total_not_cache - $paid ) > 0):
                                       المبلغ المتبقى للتاجر : {{ $total_not_cache - $paid }} جنيه
			                           <input name="postponed_value" type="text" class="form-control" placeholder="المبلغ المطلوب تسديدة ..." required="">

			                        @endif
			                      </div>
		                        </div>

			                </div>
			                <!-- /.table-responsive -->
			              </div>
			              <!-- /.card-body -->
			              <div class="card-footer clearfix">
                                @if( ( $total_not_cache - $paid ) > 0):
                                    <button  class="btn btn-sm btn-primary float-left">تسديد دفعة</button>
                                @endif
			              </div>
			              <!-- /.card-footer -->
		              </form>
		            </div>

		                <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->

		           <!-- here put check -->
                    <form method="post" action="{{ url('add-check-for-merchant/'.$merchant_data->id) }}">
                       {{ csrf_field() }}
                           @if( ( $total_not_cache - $paid ) > 0):
			                  <!--  here put form check of Banck -->
			                  <div class="checkform col-12" style="display:block">
			                  	<div class="col-xs-12">
			                  	     <h4 class="badge bg-danger" style="font-size:14px;color:black"> اضافة شيك </h4>

			                  	</div>
	                            <div class="form-group col-md-12">
			                      <!-- text input -->
			                      <div class="form-group">
			                        <label>شيك باسم</label>
			                        <input name="check_owner" value="{{ $merchant_data->merchant_name }}" type="text" class="form-control" placeholder="شيك باسم ..." >
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
			                          <input name="order_price" value="{{ $total - $paid }}" type="text" class="form-control" placeholder="المبلغ المطلوب تسديدة ..." required="" hidden>

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
	                        @endif
	                   </form>
	            </div>
	            <!-- start orders clothes -->

	            <!-- start row orders clothes -->
	            <div class="side-by-side col-md-4">
		            <!-- general form elements -->
				    <div class="card">
                        <div class="card-header" style="background-color:rgb(253 233 62);">
                            <h3 class="card-title">تفاضيل التاجر</h3>
                        </div>
			            <!-- /.card-header -->
			            <div class="card-body p-0">
			                <ul class="products-list product-list-in-card pl-2 pr-2">
                                <!-- /.item -->
                                <li class="item">
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">اسم التاجر </a>
                                        <span class="product-description">
                                        {{ $merchant_data->merchant_name }}
                                        </span>
                                    </div>
                                </li>
                                <!-- /.item -->
                                <li class="item">
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">رقم الجوال</a>
                                        <span class="product-description">
                                            {{ $merchant_data->merchant_phone }}
                                        </span>
                                    </div>
                                </li>
                                <!-- /.item -->
                                <li class="item">
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">عدد الطلبات</a>
                                        <span class="product-description">
                                            {{ $merchant_data->order_clothes->count() }}
                                        </span>
                                    </div>
                                </li>
			                </ul>
			            </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-center">
                            <a href="tel: {{ $merchant_data->merchant_phone }}">  <i class="fab fa-whatsapp-square fa-2x" style="color:#3fad3f"></i></a>
                            <a href="tel: {{ $merchant_data->merchant_phone }}"> <i class="fas fa-lg fa-phone fa-2x" style="color:#007bff"></i></a>
                        </div>
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
