@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> تفاصيل المصنع </h1>
@stop


@section('content')
    <!-- Main content -->
    
    <section class="content">
	    <div class="container-fluid">
	        <!-- start row -->
	        <div class="row">
	            <!-- start row orders clothes -->
	            <div class="side-by-side col-md-9"> 
				   <div class="card">
		              <div class="card-header border-transparent">
		                <h3 class="card-title">طلبات القماش الخاصة بالمصنع</h3>
		              </div>
		              <!-- /.card-header -->
		              <div class="card-body p-0">
		                <div class="table-responsive" style="max-height: 300px;">
		                  <table class="table m-0">
		                    <thead>
		                    <tr>
		                      <th>رقم الطلب</th>
		                      <th>الطلبية</th>
		                     
		                      <th>تاريخ </th>
		                      <th>عدد القطع</th>
		                      <th>سعر القطعة</th>
		                      <th>اجمالى التكلفة</th>
		                      
		                      <th>تفاصيل </th>
		                    </tr>
		                    </thead>
		                    <tbody>
		                    	@php $total_value = 0 @endphp
		                    	@if(!empty($order_clothes_info))
				              	    @foreach($order_clothes_info as $clothes_styles)
					                    <tr>
					                      <td><a href="pages/examples/invoice.html"> {{ $clothes_styles->id }} </a></td>
					                      <td>{{$clothes_styles->order_clothes->category_name->category }}</td>
					                    
                                            <td> {{ $clothes_styles->created_at }} </td>
                                            <td> {{ $clothes_styles->count_piecies }} </td>
                                            <td> {{ $clothes_styles->additional_taxs }} جنيه </td>
                                            <td> {{ $clothes_styles->additional_taxs * $clothes_styles->count_piecies  }} جنيه </td>
                                            <td >
					                      	  <a href="{{ url('single-piecies/'.$clothes_styles->id ) }}" class="btn btn-sm btn-primary float-left">تفاصيل</a>
					                      </td>
					                      @php $total_value = $total_value + ($clothes_styles->additional_taxs * $clothes_styles->count_piecies) @endphp
					                    </tr>
					                @endforeach
					                @php define('total_value',$total_value) @endphp
					                @php define('any_postponeds',$total_value- $sum_pospondes_suppliers ) @endphp
					               
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
		              	  <label> المبلغ المدفوع : </label> {{ $total_value }} جنيه    <label> المبلغ المتبقى  : </label> {{ any_postponeds }} جنيه 
		              <!--   <a href="{{ url('delete-merchant-orders/'.$supplier_id) }}"  class="btn btn-sm btn-info delete_all float-left" data-toggle="modal" data-target="#modal-default"  > <i class="far fa-trash-alt"></i> حذف الطلبات</a> -->
		                
		                <a href="#" class="btn btn-sm btn-info float-left">طباعة</a>                 
		              </div>
		              <!-- /.card-footer -->
		            </div>
                  
		           
	           

	             <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            
		            <div class="card">
		              <div class="card-header border-transparent">
		                <h3 class="card-title">الدفعات الخاصة يالمصنع</h3>
		              </div>
		              <!-- /.card-header -->
		              <div class="card-body p-0">
		                <div class="table-responsive" style="max-height: 400px;">
		                  <table class="table m-0">
		                    <thead>
		                    <tr>
		                      <th>رقم الدفعة</th>
		                      <th>قيمة الدفعة</th>
		                      <th>تاريخ تسديد الدفعة</th>
		                     
		                    </tr>
		                    </thead>
		                    <tbody>
		                    	
                	           @if(!empty(get_pospondes_supplier($supplier_id)))
                	               @foreach(get_pospondes_supplier($supplier_id) as $postponed_data)
	          						    <tr>
						                      <td><a href="#"> {{ $postponed_data->id }} </a></td>
						                      <td> {{$postponed_data->posponed_value }} جنيه </td>
						                      <td><span class="badge badge-info"> {{ $postponed_data->created_at }} </span></td>
						                     
						                     
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
		                <a href="#" class="btn btn-sm btn-info float-left">طباعة</a>
		                
		              </div>
		              <!-- /.card-footer -->
		            </div>

		              <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            <!-- --------------------------------------------------------------- -->
		            
		            <div class="card">
		              <div class="card-header border-transparent">
		                <h3 class="card-title">تسديد دفعة</h3>
		              </div>
		              <form method="POST" action="{{ url('supplier/add-postponed/'.$supplier_id) }}">
		              	  {{ csrf_field() }}
			              <!-- /.card-header -->
			              <div class="card-body p-0">
			                <div class="table-responsive" style="max-height: 400px;">
		                    	
      						   <div class="form-group col-12">
			                      <!-- text input -->
			                      <div class="form-group">
			                        <label>تسديد دفعة من المبلغ</label>
                                    @if(any_postponeds != 0):
                                       المبلغ المتبقى للمصنع : {{ any_postponeds }} جنيه
			                           <input name="postponed_value" type="text" class="form-control" placeholder="المبلغ المطلوب تسديدة ..." required="">
			                           <input value="{{ any_postponeds }}" name="rest_value" type="text" class="form-control" placeholder="المبلغ المطلوب تسديدة ..." required="" hidden>
			                           
			                        @endif
			                      </div>
		                        </div>
							                
							           
			                </div>
			                <!-- /.table-responsive -->
			              </div>
			              <!-- /.card-body -->
			              <div class="card-footer clearfix">
			                <button  class="btn btn-sm btn-primary float-left">تسديد دفعة</button>
			                
			              </div>
			              <!-- /.card-footer -->
		              </form>
		            </div>
	            <!-- start orders clothes -->
                  </div>
	            <!-- start row orders clothes -->
	            <div class="side-by-side col-md-3"> 
		            <!-- general form elements -->
				    <div class="card">
		              <div class="card-header" style="background-color:rgb(253 233 62);">
		                <h3 class="card-title">تفاضيل المصنع</h3>
		              </div>
		              @if(!empty($supplier_data))
		              	 @foreach($supplier_data as $supplier_info)
			              <!-- /.card-header -->
			              <div class="card-body p-0">
			                <ul class="products-list product-list-in-card pl-2 pr-2">
			              
				                  <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">اسم المصنع </a>
				                      <span class="product-description">
				                        {{ $supplier_info->supplier_name }}
				                      </span>
				                    </div>
				                  </li>

				                  <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">رقم الجوال</a>
				                      <span class="product-description">
				                         {{ $supplier_info->supplier_phone }}
				                      </span>
				                    </div>
				                  </li>

				                  <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">عدد الطلبات</a>
				                      <span class="product-description">
				                         {{ $supplier_info->clothes_styles->count() }}
				                      </span>
				                    </div>
				                  </li>


				                   <!-- /.item -->
				                  <li class="item">
				                    <div class="product-info">
				                      <a href="javascript:void(0)" class="product-title">عدد القطع المقصوصة</a>
				                      <span class="product-description">
				                         {{ $supplier_info->clothes_styles->sum('count_piecies') }}
				                      </span>
				                    </div>
				                  </li>

				               
			                </ul>
			              </div>
			              <!-- /.card-body -->
			              <div class="card-footer text-center">
				               <a href="tel: {{ $supplier_info->supplier_phone }}">  <i class="fab fa-whatsapp-square fa-2x" style="color:#3fad3f"></i></a>
	                           <a href="tel: {{ $supplier_info->supplier_phone }}"> <i class="fas fa-lg fa-phone fa-2x" style="color:#007bff"></i></a>
			              </div>
			              <!-- /.card-footer -->
			            @endforeach
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