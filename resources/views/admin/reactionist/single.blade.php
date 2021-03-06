@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> تفاصيل المرتجع </h1>
@stop


@section('content')
    <!-- Main content -->

    <section class="content">
	    <div class="container-fluid">
	        <!-- start row -->
	        <div class="row">
	            <!-- start row orders clothes -->
	            <div class="side-by-side col-md-8">
				   <div class="card">
		              <div class="card-header border-transparent">
		                <h3 class="card-title">تفاصيل المرتجع</h3>
		              </div>
		              <!-- /.card-header -->
		              <div class="card-body p-0">
		                <div class="table-responsive" style="max-height: 400px;">
		                  <table class="table m-0">
		                   <!--  <thead>

		                    </thead> -->
		                    <tbody>
		                    	@if(!empty($reactionist_data))
                                    <tr>
                                        <th>رقم المرتجع</th>
                                            <td><a href="#"> # {{ $reactionist_data->id }} </a></td>
                                    </tr>
                                    <tr>
                                        <th>اسم المنتج</th>
                                            <td><a href="#">  {{ $reactionist_data->order->product->name_product }} </a></td>
                                    </tr>
                                    <tr>
                                        <th>الصنف</th>
                                            <td><a href="#"> {{ $reactionist_data->order->product->category->category }} </a></td>
                                    </tr>
                                    <tr>
                                        <th>كمية</th>
                                            <td><a href="#"> {{ $reactionist_data->order_count }} قطعة </a></td>
                                    </tr>
                                    <tr>
                                        <th>سعر القطعة</th>
                                            <td><a href="#"> {{ $reactionist_data->one_item_price .' جنيه ' }} </a></td>
                                    </tr>

                                    <tr>
                                        <th>السعر الكلى</th>
                                        <td>{{ ($reactionist_data->final_cost ).' جنيه ' }}</td>
                                    </tr>

                                    <tr>
                                        <th>تاريخ الاضافة</th>
                                        <td><span class="badge badge-primary">{{ $reactionist_data->created_at }}  </span></td>
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

		              <!-- /.card-footer -->
		            </div>


	            </div>
	            <!-- start orders clothes -->

	            <!-- start row orders clothes -->
	            <div class="side-by-side col-md-4">
		            <!-- general form elements -->
				    <div class="card">
		              <div class="card-header" style="background-color:rgb(253 233 62);">
		                <h3 class="card-title">تفاضيل الطلبية </h3>
		              </div>

		              @if( !empty($reactionist_data->order) )
			              <!-- /.card-header -->
			              <div class="card-body p-0">
			                <ul class="products-list product-list-in-card pl-2 pr-2">

				                  <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">اسم الزبون </a>
				                      <span class="product-description">
				                        {{ $reactionist_data->order->client->client_name }}
				                      </span>
				                    </div>
				                  </li>

				                  <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">كمية </a>
				                      <span class="product-description">
				                         {{ $reactionist_data->order->order_count }} قطعة
				                      </span>
				                    </div>
				                  </li>

				                  <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">سعر الطلبية</a>
				                      <span class="product-description">
				                         {{ $reactionist_data->order->order_price }} جنيه
				                      </span>
				                    </div>
				                  </li>

				                   <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">خصم علي الطلبية</a>
				                      <span class="product-description">
				                         {{ $reactionist_data->order->order_discount }} جنيه
				                      </span>
				                    </div>
				                  </li>

				                  <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">مصاريف اضافية</a>
				                      <span class="product-description">
				                         {{ $reactionist_data->order->order_taxs }} جنيه
				                      </span>
				                    </div>
				                  </li>

				                    <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">طريقة الدفع</a>
				                      <span class="product-description">
				                         {{ $reactionist_data->order->payment_type }}
				                      </span>
				                    </div>
				                  </li>



			                </ul>
			              </div>
			              <!-- /.card-body -->
			        @else
			            <div class="card-body p-0">
			                <ul class="products-list product-list-in-card pl-2 pr-2">
					             <li class="item">
				                    <div class="product-info">

				                      <span class="product-description">
				                         غير صادر عن طلبية
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
@stop
