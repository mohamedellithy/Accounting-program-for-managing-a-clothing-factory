@extends('adminlte::page')

@section('title', 'عرض المنتجات')

@section('content_header')
    <h1> {{($title?$title:'المنتجات') }} </h1>
@stop

@section('content')
  <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
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
                        <h3 class="card-title">عرض طلبات القماش</h3>
                      </div>
                        
                        <!-- /.card-header -->
                        <div id="merchantsContainer" class="card-body">
                            <h2 id="heading_print" style="display:none" > جدول طلبات القماش </h2>
                            <table id="merchants" class="table table-bordered table-hover">
                              <thead>
                                <tr>
                                  <th></th>
                                  <th>اسم العميل</th>
                                  <th>الصنف</th>
                                  <th>الكمية </th>
                                  <th>السعر</th>
                                  <th>الخصم</th>
                                  <th>نوع الدفع</th>
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
              <h4 class="modal-title">تأكيد حذف المنتجات</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <p>تأكيد حذف المحدد من جدول المنتجات</p>
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
             ajax: "{{ url('datatable-order-clothes/'.$order_type) }}",
             columns: [
                      {data:  'select',name:'select' },
                      { data: 'merchant_name', name: 'merchant_name' },
                      { data: 'category_name', name: 'category_name' },
                      { data: 'Quantity', name: 'Quantity' },
                      { data: 'order_price', name: 'order_price' },
                      { data: 'order_discount', name: 'order_discount' },                      
                      { data: 'payment_type', name: 'payment_type' },
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
@stop