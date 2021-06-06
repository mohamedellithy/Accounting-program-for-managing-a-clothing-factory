@extends('adminlte::page')


@section('content_header')
    <h1>المخزن</h1>
@stop



@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <h5 class="mt-4 mb-2">تفاصيل المخزن</h5>
       <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ ($all_product?$all_product:'0') }}</h3>

                <p>المنتجات</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{ url('inventory/products/all') }}" class="small-box-footer">تفاصيل <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ ($finished_product?$finished_product:'0') }}</h3>

                <p>المنتجات المنتهية</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{ url('inventory/products/finished') }}" class="small-box-footer">تفاصيل <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ ($least_product?$least_product:0) }}</h3>

                <p>المنتجات اقل من 20 قطعة</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{ url('inventory/products/least') }}" class="small-box-footer">تفاصيل <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

           <!-- ./col -->
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ ($product_not_sale?($all_product-$product_not_sale):0) }}</h3>

                <p>المنتجات لم يسحب منها</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{ url('inventory/products/no-sale') }}" class="small-box-footer">تفاصيل <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- ./col -->

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ ($all_orderClothes?$all_orderClothes:0) }}</h3>

                <p>طلبات القماش</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{ url('inventory/order-clothes/all') }}" class="small-box-footer">تفاصيل <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- ./col -->

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ ($finished_orderClothes?$finished_orderClothes:0) }}</h3>

                <p>طلبات القماش المنتهية</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{ url('inventory/order-clothes/finished') }}" class="small-box-footer">تفاصيل <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- ./col -->

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ ($cache_orderClothes?$cache_orderClothes:'0') }}</h3>

                <p>طلبات القماش النقدى</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{ url('inventory/order-clothes/cache') }}" class="small-box-footer">تفاصيل <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- ./col -->

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ ($check_orderClothes?$check_orderClothes:0)  }}</h3>

                <p>طلبات القماش بشيك</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{ url('inventory/order-clothes/check') }}" class="small-box-footer">تفاصيل <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- ./col -->
          <div class="col-lg-3 col-6 inventory_sect">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ ($all_ClothStyles?$all_ClothStyles:0) }}</h3>

                <p>قصات القماش</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{ url('inventory/clothesStyles/all') }}" class="small-box-footer">تفاصيل <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- ./col -->
          <div class="col-lg-3 col-6 inventory_sect">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3>{{ ($all_category?$all_category:0) }}</h3>

                <p>الاصناف</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{ url('inventory/category/all') }}"  class="small-box-footer">تفاصيل <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
         

          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ ($all_reactionist?$all_reactionist:0) }}</h3>

                <p>المرتجع</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{ url('inventory/reactionist/all') }}" class="small-box-footer">تفاصيل<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

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
    <script> console.log('Hi!'); </script>
    <script>
   jQuery(document).ready( function () {
          jQuery('#merchants').DataTable({
             processing: true,
             serverSide: true,
             ajax: "{{ url('datatable-piecies') }}",
             columns: [
                      {data:  'select',name:'select' },
                      { data: 'name_piecies', name: 'name_piecies' },
                      { data: 'category', name: 'category' },
                      { data: 'count_piecies_handle', name: 'count_piecies_handle' },
                      { data: 'full_price_handle', name: 'full_price_handle' },
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
@stop