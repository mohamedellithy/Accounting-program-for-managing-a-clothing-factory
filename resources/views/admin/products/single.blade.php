@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> تفاصيل المنتج 
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
		                <h3 class="card-title">تفاصيل المنتج</h3>
		              </div>
		              <!-- /.card-header -->
		              <div class="card-body p-0">
		                <div class="table-responsive" style="max-height: 400px;">
		                  <table class="table m-0">
		                   <!--  <thead>

		                    </thead> -->
		                    <tbody>
		                    	@if(!empty($product_data))
				              	    @foreach($product_data as $product_data_info)
					                    <tr>
		                                    <th>رقم المنتج</th>
		                                     <td><a href="#"> # {{ $product_data_info->id }} </a></td>
					                    </tr>
					                    <tr>
		                                    <th>اسم المنتج</th>
		                                     <td><a href="#">  {{ $product_data_info->name_product }} </a></td>
					                    </tr>
					                    <tr>
		                                    <th>الصنف</th>
		                                     <td><a href="#"> {{ $product_data_info->category_name->category }} </a></td>
					                    </tr>
					                    <tr>
		                                    <th>كمية</th>
		                                     <td><a href="#"> {{ $product_data_info->count_piecies }} قطعة </a></td>
					                    </tr>
					                    <tr>
		                                    <th>سعر القطعة</th>
		                                     <td><a href="#"> {{ $product_data_info->price_piecies .' جنيه ' }} </a></td>
					                    </tr>
					                    <tr>
		                                    <th>مصاريف اضافية</th>
		                                    <td>{{ $product_data_info->additional_taxs.' جنيه ' }}</td>
					                    </tr>
					                    <tr>
		                                    <th>السعر الكلى</th>
		                                    <td>{{ $product_data_info->full_price.' جنيه ' }}</td>
					                    </tr>
					                     
					                    <tr>
		                                    <th>تاريخ الاضافة</th>
		                                    <td><span class="badge badge-primary">{{ $product_data_info->created_at }}  </span></td>
					                    </tr>
					                    
					                @endforeach
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
		       

	            </div>
	            <!-- start orders clothes -->

	            <!-- start row orders clothes -->
	            <div class="side-by-side col-md-4"> 
		            <!-- general form elements -->
				    <div class="card">
		              <div class="card-header" style="background-color:rgb(253 233 62);">
		                <h3 class="card-title">تفاضيل فاتورة  القماش</h3>
		              </div>
		             
		              @if( (count($clothes_style) != 0 ))
		              	 @foreach($clothes_style as $clothes_style_info)
			              <!-- /.card-header -->
			              <div class="card-body p-0">
			                <ul class="products-list product-list-in-card pl-2 pr-2">
			              
				                  <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">اسم التاجر </a>
				                      <span class="product-description">
				                        {{ $clothes_style_info->order_clothes->merchant_name->merchant_name }}
				                      </span>
				                    </div>
				                  </li>

				                  <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">كمية </a>
				                      <span class="product-description">
				                         {{ $clothes_style_info->order_clothes->order_size }} {{ $clothes_style_info->order_clothes->order_size_type }}
				                      </span>
				                    </div>
				                  </li>

				                  <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">سعر الطلبية</a>
				                      <span class="product-description">
				                         {{ $clothes_style_info->order_clothes->order_price }} جنيه
				                      </span>
				                    </div>
				                  </li>

				                   <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">خصم علي الطلبية</a>
				                      <span class="product-description">
				                         {{ $clothes_style_info->order_clothes->order_discount }} جنيه
				                      </span>
				                    </div>
				                  </li>

				                    <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">طريقة الدفع</a>
				                      <span class="product-description">
				                         {{ $clothes_style_info->order_clothes->payment_type }}
				                      </span>
				                    </div>
				                  </li>
				                  

				                
			                </ul>
			              </div>
			              <!-- /.card-body -->
			        
			              <!-- /.card-footer -->
			            @endforeach
			        @else
			            <div class="card-body p-0">
			                <ul class="products-list product-list-in-card pl-2 pr-2">
					             <li class="item">
				                    <div class="product-info">
				                    
				                      <span class="product-description">
				                         غير صادر عن طلبية قماش
				                      </span>
				                    </div>
				                  </li>
				            </ul>
				        </div>
			        @endif
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