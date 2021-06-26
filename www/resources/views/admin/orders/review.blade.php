@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> مراجعة فاتورة البيع </h1>
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
		                <h3 class="card-title">مراجعة فاتورة البيع</h3>
		              </div>
		              <div class="col-12">
		                 <br/>
		                  <a class="btn btn-warning printDiv" style="width: 18%;"> طباعة الفاتورة </a>
		                  <a href="{{ url('orders') }}" class="btn btn-info" style="width: 18%;color:white"> الرجوع الى الطلبات </a>
		              </div>
		                <div class="card-body cardbody merchantsContainer" id="merchantsContainer">
		                    <div class="col-xs-12">
		                    	<div class="col-xs-12 text-right" style="padding:10px;text-align: right !important;font-size:20px;font-weight:600">
                                   <span> تحرير فى : {{ date('Y').'/'.date('m').'/'.date('d') }}</span>
		                    	</div>
		                    	<div class="col-xs-12 text-right" style="padding:10px;text-align: right !important;font-size:20px;font-weight:200">
                                   <span> مطلوب من السيد :
                                   	    @if(!empty($order_invoices))
                                               {{ $order_invoices->client->client_name ?? 'لم يحدد' }}
                                        @endif

                                   </span>
		                    	</div>
		                    	<table class="table table-bordered">
		                    		<thead>
			                    		<tr style="border-top: 3px solid black;">
			                    			<th colspan="2">اجمالى السعر</th>
			                    			<th colspan="2" style="border-right: 3px solid black;">سعر الوحدة</th>
			                    			<th rowspan="2" style="border-right: 3px solid black;">العدد</th>
			                    			<th rowspan="2">تخفيض</th>
			                    			<th style="border-right: 3px solid black;">الصنف</th>
			                    		</tr>
			                    		<tr>
			                    			<th>قرش</th>
			                    			<th>جنيه</th>
			                    			<th style="border-right: 3px solid black;">قرش</th>
			                    			<th>جنيه</th>
			                    			<th style="border-right: 3px solid black;"></th>
			                    		</tr>
			                    	</thead>
			                    	<tbody>

                                       @if(!empty($order_invoices))
                                           @foreach($order_invoices->invoices_items as $order)
                                              <tr>
                                              	  <td >{{ round($order->final_cost - intval($order->final_cost),2) }}</td>
                                              	  <td>{{ intval($order->final_cost) }}</td>
                                              	  <td style="border-right: 3px solid black;">{{ round((($order->order_price / $order->order_count) + $order->order_taxs) - floor(($order->order_price / $order->order_count) + $order->order_taxs),2) }}</td>
                                              	  <td>{{ floor(($order->order_price / $order->order_count) + $order->order_taxs) }}</td>
                                              	  <td style="border-right: 3px solid black;">{{ intval($order->order_count) }}</td>
                                              	  <td>{{ intval($order->order_discount) }}</td>
                                              	  <td style="border-right: 3px solid black;">{{ $order->product->category->category }}</td>
                                              </tr>
                                           @endforeach
                                           <tr>
                                           	  <td colspan="7" style="font-weight: bold;font-size: 18px;"> التكلفة الكلية : {{ $order_invoices->total_invoices }} جنيه </td>
                                           </tr>
                                           <tr>
                                               <td colspan="7">
                                                     <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($order_invoices->invoice_no, 'C39')}}" alt="barcode" />
                                               <td>
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
	    </div>
    </section>
@stop

@section('css')
    <!-- Bootstrap 4 RTL -->
     <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/plugins/select2/css/select2.min.css') }}">
     <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{  asset('vendor/adminlte/dist/css/bootstrap-rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/custom.css') }}">
     <style type="text/css">
      @media print {
        table th , table td
        {
          display:  table-cell !important;
        }
      }
    </style>

@stop
<!-- Select2 -->
@section('js')
	<script src="{{ asset('vendor/adminlte/plugins/plugins/select2/js/select2.full.min.js') }}"></script>

      <script >
        jQuery('body').on('click','.printDiv',function(event){

            event.preventDefault();

            var printContents = document.getElementById("merchantsContainer").innerHTML;

             var originalContents = document.body.innerHTML;

             document.body.innerHTML = printContents;

             window.print();

             document.body.innerHTML = originalContents;
            // window.location.reload();
        });


    </script>
@stop
