@extends('adminlte::page')

@section('title', 'عرض الدائنين')

@section('content_header')
    <h1> عرض الدائنين </h1>
@stop

@section('content')
  <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">عدد الدائنين</span>
                <span class="info-box-number">
                  {{ ($check_count?$check_count:'0') }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">اجمالى مبلغ الدائنين</span>
                <span class="info-box-number">
                 {{ ($total_debit?$total_debit:'0') }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->


          <!-- /.col -->
          <div class="col-12">
             <form id="form_delete_select" action="{{ url('delete-select-debit') }}"  method="POST">
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
                        <h3 class="card-title">عرض الدائنين</h3>
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
                                  <a class="dropdown-item delete_all" href="{{ url('delete-debits/دائن') }}"  data-toggle="modal" data-target="#modal-default" > <i class="far fa-trash-alt"></i> حذف الكل</a>

                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div id="merchantsContainer" class="card-body">
                            <h2 id="heading_print" style="display:none" > جدول العملاء / الزبائن </h2>
                            <table id="merchants" class="table table-bordered table-hover">
                              <thead>
                                <tr>
                                  <th></th>
                                  <th>اسم الدائن</th>
                                  <th>قيمة المبلغ</th>
                                  <th>متبقى من المبلغ</th>
                                  <th>قسم</th>
                                  <th>نوع الدين </th>
                                   <th>طريقة الدفع</th>
                                  <th>تسديد المبلغ</th>
                                  <th>اجراءات</th>

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
              <h4 class="modal-title">تأكيد حذف عميل / زبون</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <p>تأكيد حذف المحدد من جدول العملاء / الزبائن</p>
            </div>
            <div class="modal-footer justify-content-between">

              <a type="button" href="#" class="btn btn-primary " id="confirm_delete" >تأكيد الحذف</a>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>


       <div class="modal fade show" id="modal-default23"  aria-modal="true">
        <div class="modal-dialog">
          <div class="modal-content">
             <form method="POST" action="{{ url('pay-debit') }}">
                   {{ csrf_field() }}
                  <div class="modal-header">
                    <h4 class="modal-title">تسديد مبلغ </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <div class="modal-body">

                      <div class="form-group">
                        <label for="exampleInputPassword1">قيمة المبلغ</label>
                        <input name="debit_value" type="debit_value" class="form-control" id="debit_value" placeholder="قيمة المبلغ" required>
                        <input name="debit_id" type="debit_value" class="form-control" id="debit_id" placeholder="قيمة المبلغ" hidden>

                      </div>


                  </div>
                  <div class="modal-footer justify-content-between">

                    <button type="submit" href="#" class="btn btn-primary " id="confirm_delete" >تأكيد التسديد</button>
                  </div>
              </form>
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
             ajax: "{{ url('datatable-credit') }}",
             columns: [
                      {data:  'select',name:'select' },
                      { data: 'credit_name', name: 'credit_name' },
                      { data: 'credit_value', name: 'credit_value' },
                      { data: 'rest_value', name: 'rest_value' },

                      { data: 'section', name: 'section' },
                      { data: 'credit_type', name: 'credit_type' },
                      { data: 'type_payment', name: 'type_payment' },

                      { data: 'credit_pay', name: 'credit_pay' },
                      { data: 'process', name: 'process' },


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
            /* window.location.reload();*/
        });

      jQuery('body').on('click','.pay_money',function(event){

         var value_payed = jQuery(this).attr('debit-cost');
         var pay_id      = jQuery(this).attr('debit-id');
         jQuery('#debit_value').val(value_payed);
         jQuery('#debit_id').val(pay_id);
      });
         console.log('hi');
    </script>
@stop
