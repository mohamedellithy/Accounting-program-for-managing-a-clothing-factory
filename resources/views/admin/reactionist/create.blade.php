@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> اضافة مرتجع نقدى </h1>
@stop


@section('content')
    <!-- Main content -->

    <section class="content">
	    <div class="container-fluid">
	        <div class="row">
	            <!-- left column -->
	            <div class="col-md-12">

                   @if($errors->any())
                        <div class="alert alert-danger">
                            <ul style="list-style:none">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
		            @elseif($message = Session::get('success'))
		            	<div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> تمت</h5>
                            {{ $message }}
                        </div>
		            @endif

		            <!-- general form elements -->
		            <div class="card card-primary">
		              <div class="card-header">
		                <h3 class="card-title">اضافة مرتجع نقدى</h3>
		              </div>
		              <!-- /.card-header -->
		              <!-- form start -->
		              <form action="{{ url('orders/'.$order->id.'/reactionists') }}" role="form" method="POST">
                        {{ csrf_field() }}
			             <div class="card-body">


					              <!-- product name  -->
				                   <div class="form-group col-md-12 col-xs-12">
					                  <label for="exampleInputEmail1"> الطلبيات داخل الفاتورة </label>
					                  <select name="order_id" class="form-control select2 item" style="width: 100%;" required>
					                    @if(!empty($order->invoices_items))
					                        @foreach($order->invoices_items as $item)
					                           <option one-item="{{ $item->final_cost > 0 ? ($item->final_cost / $item->order_count) : 0 }}" value="{{ $item->id }}"  > # {{  $item->product->name_product  }}  - رقم الطلب ( # {{   $item->id  }} ) - الصنف ( {{ $item->product->category->category }} )  - عدد القطع ( {{ $item->order_count  }} ) - التكلفة الكلية ( {{ $item->final_cost  }} جنيه) </option>
					                        @endforeach
					                    @endif
					                  </select>
					                </div>

				                  <!-- order value  -->
				                  <div class="form-group col-md-12 col-xs-12">
				                    <label for="exampleInputPassword1">عدد القطع المرتجعة </label>
				                    <input name="order_count" type="text" class="form-control order_count" id="exampleInputPassword1" placeholder="عدد القطع المرتجعة " required>
				                  </div>

				                  <!-- order price  -->
				                  <div class="form-group col-md-12 col-xs-12">
				                    <label for="exampleInputPassword1">سعر القطعة</label>
				                    <input name="one_item_price" value="{{ $order->final_cost != 0 ? round( ($order->final_cost)/$order->order_count,2) : 0 }}" type="text" class="form-control reactionist_price" id="exampleInputPassword1" placeholder="سعر القطعة" required readonly>
				                  </div>

                                  <!-- order price  -->
				                  <div class="form-group col-md-12 col-xs-12">
				                    <label for="exampleInputPassword1">سعر الاجمالى</label>
				                    <input name="final_cost"  type="text" class="form-control final_cost" id="exampleInputPassword1" placeholder="سعر القطعة" required readonly>
				                  </div>

				                  <!-- order type payment  -->
				                  <div class="form-group col-md-12 col-xs-12">
				                    <label for="exampleInputPassword1">نوع الدفع</label>
				                       <input name="payment_type" value="{{ $order->payment_type }}" hidden>
					                  <select name="payment" class="form-control select2" style="width: 100%;" required disabled>
					                        <option value="نقدى"  {{ (($order->payment_type=='نقدى')  ?'selected':'') }} > نقدى </option>
					                        <option value="شيك"   {{ (($order->payment_type=='شيك')   ?'selected':'') }}> شيك </option>
					                        <option value="أجل"   {{ (($order->payment_type=='دفعات') ?'selected':'') }}> دفعات </option>

					                  </select>
					              </div>


		                </div>
		                <!-- /.card-body -->

		                <div class="card-footer">
		                  <button type="submit" class="btn btn-primary"> اضافة مرتجع نقدى </button>
		                </div>
		              </form>
		            </div>
		            <!-- /.card -->

		            {{--  here show table of added last  --}}
				    <div class="card">
				      <div class="card-header">
				        <h3 class="card-title">أخر مرتجع نقدى</h3>
				      </div>
				      <!-- /.card-header -->
				      <div class="card-body">
				        <table class="table table-bordered">
				          <thead>
				            <tr>
				              <th>#</th>
				              <th>أسم المنتج</th>
				              <th>الصنف</th>
				              <th>الكمية</th>
				              <th>سعر القطعة</th>
				              <th>اسم الزبون </th>
				              <th>نوع الدفع</th>
                              <th>التكلفة الاجمالية</th>
				              <th>تاريخ مرتجع</th>

				            </tr>
				          </thead>
				          <tbody>
                              @if(!empty($last_order))
                                    <tr>
                                      <td>1#</td>
                                      <td> {{ $last_order->order->product->name_product }} </td>
                                      <td> {{ $last_order->order->product->category->category }} </td>
                                      <td> {{ $last_order->order_count  }}  قطعة </td>
                                      <td> {{ $last_order->one_item_price }} جنية </td>
                                      <td> {{ ($last_order->order->client?$last_order->order->client->client_name:'بدون') }} </td>
                                      <td> {{ $last_order->payment_type }} </td>
                                      <td> {{ $last_order->final_cost }} جنية </td>
                                      <td> {{ $last_order->created_at }} </td>
                                    </tr>
                              @endif


				          </tbody>
				        </table>
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


@stop
<!-- Select2 -->
@section('js')
	<script src="{{ asset('vendor/adminlte/plugins/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
		  $(function () {
		    // Initialize Select2 Elements
		    $('.select2').select2({
		      theme: 'bootstrap4',
		    });
            jQuery('.item').change(function(){
                let one_item_cost        = jQuery('.item option:selected').attr('one-item');
                let order_count          = jQuery('.order_count').val();
                jQuery('.reactionist_price').val( one_item_cost);
                jQuery('.final_cost').val( order_count * one_item_cost);
            });
            jQuery('.order_count , .reactionist_price').keyup(function(){
                let one_item_cost        = jQuery('.reactionist_price').val();
                let order_count          = jQuery('.order_count').val();
                jQuery('.final_cost').val( order_count * one_item_cost);

            });
		});
    </script>
@stop
