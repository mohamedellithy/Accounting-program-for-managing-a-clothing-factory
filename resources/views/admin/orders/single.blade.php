@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> تفاصيل الطلب
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
		                <h3 class="card-title">طلبات مبيعات الخاصة بالعميل</h3>
		              </div>
		              <!-- /.card-header -->
		              <div class="card-body p-0">
		                <div class="table-responsive" style="max-height: 400px;">
		                  <table class="table m-0">
		                   <!--  <thead>

		                    </thead> -->
		                    <tbody>
                                @if($order_data->exists)
                                    <tr>
                                       <td colspan="2">
                                          <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($order_data->invoice_no, 'C39')}}" alt="barcode" />
                                       </td>
                                    </tr>
                                    <tr>
                                        <th>الزبون</th>
                                        <td> {{ ($order_data->client_name?$order_data->client_name->client_name:'غير معروف') }} </td>
                                    </tr>
                                    <tr>
                                        <th>رقم الفاتورة</th>
                                        <td>  {{ $order_data->invoice_no }} </td>
                                    </tr>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <td> # {{ $order_data->id }} </td>
                                    </tr>
                                    <!-- here put other orders include in this order -->
                                    <tr style="background-color: #f4f6f9;">
                                        <th>المنتج</th>
                                        <td> {{ $order_data->product->name_product }} </td>
                                    </tr>
                                    <tr style="background-color: #f4f6f9;">
                                        <th>الصنف</th>
                                        <td>{{ $order_data->product->category->category }} </td>
                                    </tr>
                                    <tr style="background-color: #f4f6f9;">
                                        <th>كمية</th>
                                        <td>{{ $order_data->order_count }} قطعة </td>
                                    </tr>
                                    <tr style="background-color: #f4f6f9;">
                                        <th>سعر الكمية</th>
                                        <td>{{ $order_data->order_price .' جنيه ' }} </td>
                                    </tr>
                                    @php $total = $order_data->final_cost @endphp
                                    <tr style="background-color: #f4f6f9;">
                                        <th>خصم على الطلبية</th>
                                        <td>{{ ($order_data->order_discount?$order_data->order_discount:'0').' جنيه ' }}</td>
                                    </tr>
                                    <tr style="background-color: #f4f6f9;">
                                        <th>مصاريف اضافية</th>
                                        <td>{{ ($order_data->order_taxs?$order_data->order_taxs:'0').' جنيه ' }}</td>
                                    </tr>
                                    <tr style="background-color: #f4f6f9;">
                                        <th>التكلفة النهائية</th>
                                        <td>{{ ($order_data->final_cost?$order_data->final_cost:'0').' جنيه ' }}</td>
                                    </tr>
                                    @if(!empty($order_data->attached_orders))
                                        @forelse($order_data->attached_orders as $attached_order)
                                            <tr style="border-top: 3px #3b3b3b solid;">
                                               <td style="background-color: wheat;text-align: center;" colspan="2"> طلبات اخرى داخل الفاتورة </td>
                                            </tr>
                                            <tr style="background-color: #f4f6f9;">
                                                <th>المنتج</th>
                                                <td><a href="#"> {{ $attached_order->product->name_product }} </a></td>
                                            </tr>
                                            <tr style="background-color:#f4f6f9 ;">
                                                <th>الصنف</th>
                                                <td><a href="#"> {{ $attached_order->product->category->category }} </a></td>
                                            </tr>
                                            <tr style="background-color: #f4f6f9;">
                                                <th>كمية</th>
                                                <td><a href="#"> {{ $attached_order->order_count }} قطعة </a></td>
                                            </tr>
                                            <tr style="background-color: #f4f6f9;">
                                                <th>سعر الكمية</th>
                                                <td><a href="#"> {{ $attached_order->order_price .' جنيه ' }} </a></td>
                                            </tr>
                                            <tr style="background-color: #f4f6f9;">
                                                <th>خصم على الطلبية</th>
                                                <td>{{ ($attached_order->order_discount?$attached_order->order_discount:'0').' جنيه ' }}</td>
                                            </tr>
                                            <tr style="background-color: #f4f6f9;">
                                                <th>مصاريف اضافية</th>
                                                <td>{{ ($attached_order->order_taxs?$attached_order->order_taxs:'0').' جنيه ' }}</td>
                                            </tr>
                                            <tr style="background-color: #f4f6f9;">
                                                <th>التكلفة النهائية</th>
                                                <td>{{ ($attached_order->final_cost?$attached_order->final_cost:'0').' جنيه ' }}</td>
                                            </tr>

                                        @endforeach
                                    @endif
                                   <tr style="background-color: #ffc107;border-top: 5px #3b3b3b solid;">
                                        <th>التكلفة الكلى</th>
                                        <td>{{ ($order_data->total_invoices?$order_data->total_invoices:'0') }} جنيه </td>
                                    </tr>
                                        <!-- here put other orders include in this order -->
                                    <tr style="background-color: #ffc107;">
                                        <th>نوع الدفع</th>
                                        <td><span class="badge {{ ( ($order_data->payment_type=='نقدى')?'badge-success':'badge-info') }} ">{{ $order_data->payment_type }}</span></td>
                                    </tr>
                                    <tr style="background-color: #ffc107;">
                                        <th>تاريخ الطلبية</th>
                                        <td><span class="badge badge-primary">{{ $order_data->created_at }}  </span></td>
                                    </tr>
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


		                 <a href="#" onclick="printDiv('card_print_1')" class="btn btn-sm btn-info float-left">طباعة</a>

		              </div>
		              <!-- /.card-footer -->
		            </div>
		            <!-- --------------------------------------------------------------- -->


	            </div>
	            <!-- start orders clothes -->

	            <!-- start row orders clothes -->
	            <div class="side-by-side col-md-4">
		            <!-- general form elements -->
				    <div class="card">
		              <div class="card-header" style="background-color:rgb(253 233 62);">
		                <h3 class="card-title">تفاضيل الزبون</h3>
		              </div>

                        <!-- /.card-header -->
                       <div class="card-body p-0">
                            <ul class="products-list product-list-in-card pl-2 pr-2">

                                <!-- /.item -->
                                <li class="item">
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">اسم العميل </a>
                                        <span class="product-description">
                                        {{ $order_data->client->client_name ?? 'لم يحدد' }}
                                        </span>
                                    </div>
                                </li>

                                <!-- /.item -->
                                <li class="item">
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">رقم الجوال</a>
                                        <span class="product-description">
                                            {{ $order_data->client->client_phone ?? '' }}
                                        </span>
                                    </div>
                                </li>

                                <!-- /.item -->
                                <li class="item">
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">عدد الطلبات</a>
                                        <span class="product-description">
                                            {{ ($order_data->client?$order_data->client->order_products->count():'0') }}
                                        </span>
                                    </div>
                                </li>


                            </ul>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-center">
                            <a href="tel: {{ $order_data->client->client_phone ?? '' }}">  <i class="fab fa-whatsapp-square fa-2x" style="color:#3fad3f"></i></a>
                            <a href="tel: {{ $order_data->client->client_phone ?? '' }} "> <i class="fas fa-lg fa-phone fa-2x" style="color:#007bff"></i></a>
                        </div>
                        <!-- /.card-footer -->

		            </div>
		             <!-- general form elements -->

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
