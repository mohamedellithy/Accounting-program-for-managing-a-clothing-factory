@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> اضافة قصات قماش </h1>
@stop


@section('content')
    <!-- Main content -->

    <section class="content">
	    <div class="container-fluid">
	        <div class="row">
			  <!-- /.col -->
	      	  <div class="col-12">
	             <form id="form_delete_select" action="{{ url('delete-select-order-clothes') }}"  method="POST">
	             {{ csrf_field() }}
	        	    @if($message = Session::get('success'))
		            	<div class="alert alert-warning alert-dismissible">
		                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                  <h5><i class="icon fas fa-check"></i> تمت</h5>
		                  {{ $message }}
		                </div>
		            @endif
      		          <div class="card">
      		            <div class="card-header">
      		              <h3 class="card-title">عرض فواتير القماش</h3>
      		            </div>
      		              <div class="operations-buttons">
        			            <div class="btn-group ">
        		                    <button type="button" class="btn btn-danger">اجراء على الكل</button>
        		                    <button type="button" class="btn btn-danger dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
        		                      <span class="sr-only">Toggle Dropdown</span>
        		                    </button>
        		                    <div class="dropdown-menu" role="menu">
                                   <button class="dropdown-item printDiv" type="button"> <i class="fas fa-print"></i> طباعة  الجدول</button>
        		                      <div class="dropdown-divider"></div>

                                </div>
        		                </div>
      			            </div>
      			            <!-- /.card-header -->
      			            <div id="merchantsContainer" class="card-body">
                            <h2 id="heading_print" style="display:none" > جدول طلبات القماش </h2>
      			                <table id="merchants" class="table table-bordered table-hover">
      				                <thead>
      					                <tr>

      					                  <th>تابعة لفاتورة رقم</th>
                                          <th>اسم العميل</th>
      					                  <th>الصنف</th>
      					                  <th>الكمية </th>
      					                  <th>السعر</th>
      					                  <th>الخصم</th>
                                          <th>نوع الدفع</th>
                                          <th>اضافة</th>
      					                </tr>
      				                </thead>
      			                </table>
      			            </div>
      				    </div>
	                </form>
	      		</div>
	        </div>
	    </div>
    </section>
@stop



@section('css')
    <!-- Bootstrap 4 RTL -->
     <link rel="stylesheet" href="{{  asset('vendor/adminlte/dist/css/bootstrap-rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/custom.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
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
      }
    </style>
@stop

@section('js')
	<!-- DataTables -->
	<script src="{{ asset('vendor/adminlte/plugins/plugins/datatables/jquery.dataTables.js') }}"></script>
	<script src="{{ asset('vendor/adminlte/plugins/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
    <script> console.log('Hi!'); </script>
    <script>
	 jQuery(document).ready( function () {
	        jQuery('#merchants').DataTable({
	           processing: true,
	           serverSide: true,
	           ajax: "{{ url('datatable-order-clothes-styles') }}",
	           columns: [
	                    { data:'invoice_no',name:'invoice_no'},
	                    { data: 'merchant_name', name: 'merchant_name' },
	                    { data: 'category_name', name: 'category_name' },
	                    { data: 'Quantity', name: 'Quantity' },
                        { data: 'order_price', name: 'order_price' },
                        { data: 'order_discount', name: 'order_discount' },
                        { data: 'payment_type', name: 'payment_type' },

	                    { data: 'show', name: 'show' }
	                 ]
	        });
     });
    </script>
    <script>
      var typeAlert = "";
      $('.delete').click(function(event){
          typeAlert = null;
          event.preventDefault();

      });
      $('body').on('click','.delete_single',function(event){
        typeAlert = jQuery(this).attr('href');
        event.preventDefault();
      });
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
        jQuery('body').on('click','.printDiv',function(event){

            event.preventDefault();

            var printContents = document.getElementById("merchantsContainer").innerHTML;

             var originalContents = document.body.innerHTML;

             document.body.innerHTML = printContents;

             window.print();

             document.body.innerHTML = originalContents;
             //window.location.reload();
        });


    </script>
@stop
