@extends('adminlte::page')

@section('title', 'سحب من رصيد رأس المال')

@section('content_header')
    <h1> سحب من رصيد رأس المال </h1>
@stop

@section('content')
  <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
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
	                <h3 class="card-title">سحب من رصيد رأس المال</h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
	              <form action="{{ url('withdraws') }}" role="form" method="POST">
	                {{ csrf_field() }}
	                <div class="card-body">
		               <!-- merchant name  -->
	                   <div class="form-group col-md-12 col-xs-12">
		                  <label for="exampleInputEmail1">اسم الشريك</label>
		                  <select name="partner_id" class="form-control select2" style="width: 100%;" required>

			                   @if(!empty($all_partners))
			                       @foreach($all_partners as $partner)
			                           <option value="{{ $partner->id }}"> {{ $partner->partner_name }} </option>
			                       @endforeach
			                   @endif
		                  </select>
		                </div>
	                  <!-- order value  -->
	                  <div class="form-group col-md-12 col-xs-12">
	                    <label for="exampleInputPassword1">المبلغ المطلوب سحبه</label>
	                    <input name="withdraw_value" type="text" class="form-control" id="exampleInputPassword1" placeholder="المبلغ المطلوب سحبه" required>
	                  </div>
	                </div>
	                <!-- /.card-body -->

	                <div class="card-footer">
	                  <button type="submit" class="btn btn-primary"> سحب من رأس المال </button>
	                </div>
	              </form>
	            </div>
			    <!-- /.card -->
	        </div>
      	  <div class="col-12">
             <form id="form_delete_select" action="{{ url('delete-select-withdraw') }}"  method="POST">
	             {{ csrf_field() }}

      		          <div class="card">
      		            <div class="card-header">
      		              <h3 class="card-title">سحب من الرصيد</h3>
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
                                  <button id="" type="submit" class="dropdown-item delete" data-toggle="modal" data-target="#modal-default" > <i class="far fa-trash-alt"></i> حذف المحدد</button>
        		                      <div class="dropdown-divider"></div>
        		                      <a class="dropdown-item delete_all" href="{{ url('delete-withdraw') }}"  data-toggle="modal" data-target="#modal-default" > <i class="far fa-trash-alt"></i> حذف الكل</a>

                                </div>
        		                </div>
      			            </div>
      			            <!-- /.card-header -->
      			            <div id="merchantsContainer" class="card-body">
                            <h2 id="heading_print" style="display:none" > جدول المرتجع </h2>
      			                <table id="merchants" class="table table-bordered table-hover">
      				                <thead>
      					                <tr>
      					                  <th></th>
      					                  <th>اسم الشريك</th>
                                  <th>المبلغ المسحوب</th>
                                  <th>المتبقي من المبلغ الاصلي</th>
                                  <th>نوع السحب</th>
                                  <th>تاريخ السحب</th>
                                  <th>اجراءات</th>
                                  <th>عرض</th>
      					                </tr>
      				                </thead>
      			                </table>
      			            </div>
      				    </div>
                </form>
      		</div>
        </div>
        <!-- /.row -->
      </div>
    </section>

      <div class="modal fade show" id="modal-default"  aria-modal="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">تأكيد حذف الطلب</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <p>تأكيد حذف المحدد من جدول الطلب</p>
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
     <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/plugins/select2/css/select2.min.css') }}">
     <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <!-- Bootstrap 4 RTL -->
     <link rel="stylesheet" href="{{  asset('vendor/adminlte/dist/css/bootstrap-rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/custom.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <style type="text/css">
      @media print {
        table th:nth-child(4) , table th:nth-child(5)
        {
          display:  table-cell;
        }
        table td:nth-child(4) , table td:nth-child(5)
        {
          display:  table-cell;
        }

       table th:nth-child(6) , table th:nth-child(7)
        {
          display: none;
        }
       table td:nth-child(6) , table th:nth-child(7)
        {
          display: none;
        }
      }
    </style>
@stop

@section('js')
	<!-- DataTables -->
	  <!-- Bootstrap 4 RTL -->
     <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/plugins/select2/css/select2.min.css') }}">
     <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

	<script src="{{ asset('vendor/adminlte/plugins/plugins/datatables/jquery.dataTables.js') }}"></script>
	<script src="{{ asset('vendor/adminlte/plugins/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
    <script> console.log('Hi!'); </script>
    <script>
	 jQuery(document).ready( function () {
	        jQuery('#merchants').DataTable({
	           processing: true,
	           serverSide: true,
	           ajax: "{{ url('datatable-withdraws') }}",
	           columns: [
	                    {data:  'select',name:'select' },
	                    { data: 'partner_name', name: 'partner_name' },
                      { data: 'withdraw_value', name: 'withdraw_value' },
                      { data: 'original_value', name: 'original_value' },
                      { data: 'withdraw_type', name: 'withdraw_type' },
                      { data: 'created_at', name: 'created_at' },
	                    { data: 'process', name: 'process' },
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
        jQuery('.printDiv').click(function(event){

            event.preventDefault();

            var printContents = document.getElementById("merchantsContainer").innerHTML;

             var originalContents = document.body.innerHTML;

             document.body.innerHTML = printContents;

             window.print();

             document.body.innerHTML = originalContents;
             window.location.reload();
        });


    </script>

    <script src="{{ asset('vendor/adminlte/plugins/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
      $(function () {
        //Initialize Select2 Elements
        $('.select2').select2({
          theme: 'bootstrap4'
        });
    });
    </script>
@stop
