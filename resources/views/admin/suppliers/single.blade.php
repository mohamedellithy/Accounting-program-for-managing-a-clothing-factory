@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> تفاصيل المصنع </h1>
@stop


@section('content')
    <!-- Main content -->

    <section class="content">
	    <div class="container-fluid">
	        <!-- start row -->
	        <div class="row">
	            <!-- start row orders clothes -->
	            <div class="side-by-side col-md-9">
				   <div class="card" id="card_print_1">
		              <div class="card-header border-transparent">
		                <h3 class="card-title">طلبات القماش الخاصة بالمصنع</h3>
		              </div>
		              <!-- /.card-header -->
		              <div class="card-body p-0">
		                <div class="table-responsive" style="max-height: 300px;">
		                  <table class="table m-0">
		                    <thead>
		                    <tr>
		                      <th>رقم الطلب</th>
		                      <th>الطلبية</th>

		                      <th>تاريخ </th>
		                      <th>عدد القطع</th>
		                      <th>سعر القطعة</th>
		                      <th>اجمالى التكلفة</th>

		                      <th>تفاصيل </th>
		                    </tr>
		                    </thead>
		                    <tbody>
                                @forelse($supplier->clothes_styles as $clothes_styles)
                                    <tr>
                                        <td><a href="pages/examples/invoice.html"> {{ $clothes_styles->id }} </a></td>
                                        <td>{{$clothes_styles->orders->category_name->category }}</td>

                                        <td> {{ $clothes_styles->created_at }} </td>
                                        <td> {{ $clothes_styles->count_piecies }} </td>
                                        <td> {{ $clothes_styles->additional_taxs }} جنيه </td>
                                        <td> {{ $clothes_styles->additional_taxs *  $clothes_styles->count_piecies }} جنيه </td>
                                        <td >
                                            <a href="{{ url('single-piecies/'.$clothes_styles->id ) }}" class="btn btn-sm btn-primary float-left">تفاصيل</a>
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
                                    تكلفة طلبات القص : {{ $supplier->total_cost }} جنيه
                                  </td>

                                  <td style="padding: 12px;background-color: white;border: 1px solid gray;">
                                       المخصوم من مستحقات الطلبات:  {{ ($supplier->total_supplier_paid >= $supplier->total_cost ? $supplier->total_cost :($supplier->total_cost - $supplier->total_supplier_paid)) }} جنيه
                                  </td>

                           	      <td style="padding: 12px;background-color: white;border: 1px solid gray;">
                                       المبلغ المتبقى على المصنع: {{ ($supplier->total_cost < $supplier->total_supplier_paid ) ?'0':($supplier->total_supplier_not_paid ) }} جنيه
                                  </td>


                                </tr>
                                <tr>
                                    <td colspan="4" style="padding: 10px;background-color: wheat;">
                                      تم ادانة المصنع بمبلغ قيمته  {{ $supplier->debit()->sum(DB::raw('debit_value - debit_paid')) ?? 0  }} جنيه
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
		            <!-- --------------------------------------------------------------- -->

		            <div class="card">
		              <div class="card-header border-transparent">
		                <h3 class="card-title">الدفعات الخاصة يالمصنع</h3>
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
                                @forelse($supplier->payments as $payment)
                                    <tr>
                                        <td><a href="#"> {{ $payment->id }} </a></td>
                                        <td> {{$payment->value }} جنيه </td>
                                        <td><span class="badge badge-info"> {{ $payment->created_at }} </span></td>
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
		                <a href="#" class="btn btn-sm btn-info float-left">طباعة</a>

		              </div>
		              <!-- /.card-footer -->
		            </div>

		              <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
                    @if($supplier->total_supplier_not_paid > 0):
                        <div class="card">
                            <div class="card-header border-transparent">
                                <h3 class="card-title">تسديد دفعة</h3>
                            </div>
                            <form method="POST" action="{{ url('supplier/add-postponed/'.$supplier->id) }}">
                                {{ csrf_field() }}
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="table-responsive" style="max-height: 400px;">
                                    <div class="form-group col-12">
                                            <!-- text input -->
                                            <div class="form-group">
                                            <label>تسديد دفعة من المبلغ</label>
                                            المبلغ المتبقى للمصنع : {{ $supplier->total_supplier_not_paid }} جنيه
                                            <input name="postponed_value" type="text" class="form-control" placeholder="المبلغ المطلوب تسديدة ..." required="">
                                            <input value="{{ $supplier->total_supplier_not_paid }}" name="rest_value" type="text" class="form-control" placeholder="المبلغ المطلوب تسديدة ..." required="" hidden>
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
	            <!-- start orders clothes -->
                  </div>
	            <!-- start row orders clothes -->
	            <div class="side-by-side col-md-3">
		            <!-- general form elements -->
				    <div class="card">
		              <div class="card-header" style="background-color:rgb(253 233 62);">
		                <h3 class="card-title">تفاضيل المصنع</h3>
		              </div>
			              <!-- /.card-header -->
			              <div class="card-body p-0">
			                <ul class="products-list product-list-in-card pl-2 pr-2">

				                  <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">اسم المصنع </a>
				                      <span class="product-description">
				                        {{ $supplier->supplier_name }}
				                      </span>
				                    </div>
				                  </li>

				                  <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">رقم الجوال</a>
				                      <span class="product-description">
				                         {{ $supplier->supplier_phone }}
				                      </span>
				                    </div>
				                  </li>

				                  <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">عدد الطلبات</a>
				                      <span class="product-description">
				                         {{ $supplier->clothes_styles->count() }}
				                      </span>
				                    </div>
				                  </li>


				                   <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">عدد القطع المقصوصة</a>
				                      <span class="product-description">
				                         {{ $supplier->clothes_styles->sum('count_piecies') }}
				                      </span>
				                    </div>
				                  </li>
			                </ul>
			              </div>
			              <!-- /.card-body -->
			              <div class="card-footer text-center">
				               <a href="tel: {{ $supplier->supplier_phone }}">  <i class="fab fa-whatsapp-square fa-2x" style="color:#3fad3f"></i></a>
	                           <a href="tel: {{ $supplier->supplier_phone }}"> <i class="fas fa-lg fa-phone fa-2x" style="color:#007bff"></i></a>
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
@stop

@section('js')
<style type="text/css">
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
             // window.location.reload();
        }


    </script>
@stop
