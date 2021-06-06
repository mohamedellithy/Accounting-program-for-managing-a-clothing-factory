@extends('adminlte::page')


@section('content_header')
    <h1>المبيعات</h1>
@stop



@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <h5 class="mt-4 mb-2">مبيعات السنة المالية </h5>
        <div class="row">

          <div class="card-body" style="background-color:white;norder:1px solid gray;">
            <form action="{{ url('get-report-sales') }}" method="GET">
              
              <div class="row">
                <div class="col-sm-4">
                  <!-- text input -->
                  <div class="form-group">
                    <label>التاريخ من</label>
                    <input name="to" value="{{ (!empty($_GET['to'])?$_GET['to']:'') }}" type="date" class="form-control" placeholder="Enter ..." required>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label> التاريخ الى</label>
                    <input name="from" value="{{ (!empty($_GET['from'])?$_GET['from']:'') }}" type="date" class="form-control" placeholder="Enter ..." required>
                  </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                      <label>الصنف</label>
                      <select name="category_id" class="form-control select2" style="width: 100%;" >
                       <option value=""> بدون تحديد </option>
                       @if(!empty($get_all_category))
                           @foreach($get_all_category as $category)
                               <option value="{{ $category->id }}" {{ ( (!empty($_GET['category_id']) && ($_GET['category_id']==$category->id) ) ?'selected':'') }} > {{ $category->category }} </option>
                           @endforeach
                       @endif
                      </select>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                      <label>نوع التقرير</label>
                      <select name="type_filter" class="form-control select2" style="width: 100%;" >
                       <option value="1" {{ ( ( !empty($_GET['type_filter']) && ($_GET['type_filter']=='1') ) ?'selected':'') }} > تقرير يومى </option>
                       <option value="2" {{ ( ( !empty($_GET['type_filter']) && ($_GET['type_filter']=='2') ) ?'selected':'') }} > تقرير شهرى </option>
                       <option value="3" {{ ( ( !empty($_GET['type_filter']) && ($_GET['type_filter']=='3') ) ?'selected':'') }} > تقرير سنوى </option>
                      </select>
                    </div>
                </div>

               
                 <div class="col-sm-12">
                    <div class="form-group">
                       <button type="submit" class="btn  bg-gradient-warning" style="float:left">البحث</button>
                    </div>
                </div>
              </div>
            </form>
          <div id="merchantsContainer" class="card-body">
              <h2 id="heading_print" style="display:none" > جدول قصات القماش </h2>
              <table id="merchants" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    
                    <th>السنة / الشهر / اليوم </th>
                    <th>عدد الطلبات</th>
                    <th>اجمالى المبيعات </th>
                    <th>أرباح</th>
                  </tr>
                </thead>
                <body>
                  @if(!empty($report_data))
                    @foreach($report_data as $key => $report)
                      <tr>
                        
                        <td> {{ $key }} </td>
                        <td> {{ $report['orders'] }}  </td>
                        <td> {{ $report['sale'] }} جنيه </td>
                        <td> {{ $report['profit'] }} جنيه </td>
                        
                      </tr>
                    @endforeach
                  @endif
                </body>
              </table>
          </div>
          </div>
           <!-- /.card-header -->

        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@stop


@section('css')
    <!-- Bootstrap 4 RTL -->
       <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/plugins/select2/css/select2.min.css') }}">
     <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
   
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

        table th:nth-child(7) , table th:nth-child(8)  
        {
          display: none;
        }
        table td:nth-child(7) , table td:nth-child(8) 
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
  <script src="{{ asset('vendor/adminlte/plugins/plugins/select2/js/select2.full.min.js') }}"></script> 
    <script> console.log('Hi!'); </script>
    <script>
   jQuery(document).ready( function () {
          jQuery('#merchants').DataTable();

         
     });
    </script>
    <script>
     $('.select2').select2({
          theme: 'bootstrap4'
        });
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