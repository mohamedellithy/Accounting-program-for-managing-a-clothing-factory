@extends('adminlte::page')

@section('title', 'خزنة المصنع')

@section('content_header')
    <h1> خزنة المصنع </h1>
@stop


@section('content')
    <!-- Main content -->
    <section class="content">
	    <div class="container-fluid">
	        <div class="row">
	            <div class="side-by-side col-md-12">

		            <div class="col-lg-12 col-xs-12">
                        <span class="alert" style="width: 100%;float: right;background-color: #00BCD4;color:white"> تفاصيل رأس مال خزنة المصنع للسنة المالية {{ date('Y-m-d',strtotime(Fiscal_Year())) }}</span>
	            	</div>
            	    <div class="table-responsive" style="max-height: 400px;background-color:white">
	                  @php $total = $get_capital_factory_before_withdraw  @endphp
	                  <table class="table m-0">
	                    <thead>
                           <tr>
	                    	   <th> الرقم </th>
	                    	   <th> قسم الوارد </th>
	                    	   <th> المبلغ المدفوع </th>
	                    	   <th> المتوفر فى الخزنة </th>
                           </tr>
	                    </thead>
	                    <tbody>
	                        <tr>

	                    	   <td>#1</td>
	                    	   <td>رأس مال المصنع قبل عمليات السحب</td>
	                    	   <td> {{ $get_capital_factory_before_withdraw }} جنيه </td>
	                    	   <td> - </td>

                            </tr>
                              <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>المسحوب من رأس مال المصنع </td>
	                    	   <td> {{ ( $get_capital_factory_before_withdraw - FactoryCapital()) }} جنيه </td>
	                    	   <td> {{  $total = $total - ( $get_capital_factory_before_withdraw -  FactoryCapital() ) }} جنيه  </td>

                            </tr>
                            <tr>

	                    	   <td>#1</td>
	                    	   <td>رأس مال الشركاء قبل عمليات السحب</td>
	                    	   <td> {{ PartnersCapital() }} جنيه </td>
	                    	   <td> -  </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>المسحوب من رأس مال الشركاء</td>
	                    	   <td> {{ PartnersCapital() - partner_withdraw_profit_all() }} جنيه </td>
	                    	   <td> {{  $total += $partners_capitals_after_withdraw }} جنيه  </td>

                            </tr>
                            <tr>
                            	 <td colspan="4" style="text-align:center">  المبلغ الاجمالى  : {{ $total }} جنيه </td>
                            </tr>
	                    </tbody>
	                  </table>
	                </div>
	            </div>
	            <!-- start orders clothes -->

	            <div class="side-by-side col-md-12">

		            <div class="col-lg-12 col-xs-12">
                        <span class="alert" style="width: 100%;float: right;background-color: #00BCD4;color:white;margin-top:30px"> تفاصيل صادر خزنة المصنع للسنة المالية {{ date('Y-m-d',strtotime(Fiscal_Year())) }}</span>
	            	</div>
            	    <div class="table-responsive" style="background-color:white">

	                  <table class="table m-0">
	                    <thead>
                           <tr>
	                    	   <th> الرقم </th>
	                    	   <th> قسم الصادر </th>
	                    	   <th> المبلغ المدفوع </th>
	                    	   <th> المتوفر فى الخزنة </th>
                           </tr>
	                    </thead>
	                    <tbody>
	                        <tr>

	                    	   <td>#1</td>
	                    	   <td>مشتريات المصنع من القماش</td>
	                    	   <td> {{ $get_outgoings }} جنيه </td>
	                    	   <td>  -  </td>

                            </tr>
                            <tr>

	                    	   <td>#1</td>
	                    	   <td>مشتريات المصنع من القماش غير مدفوعة نقدا للتجار</td>
	                    	   <td> {{ $get_outgoings - $get_outgoings_payed }} جنيه </td>
	                    	   <td> -  </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>مشتريات المصنع من القماش مدفوعة نقدا للتجار</td>
	                    	   <td> {{ $get_outgoings_payed }} جنيه </td>
	                    	   <td> {{ $total=$total - $get_outgoings_payed }} جنيه  </td>

                            </tr>

                             <tr >

	                    	   <td>#1</td>
	                    	   <td>مصروفات قصات القماش داخل المصنع </td>
	                    	   <td> {{ $get_ClothStyles_in_factory   }} جنيه </td>
	                    	   <td>  - </td>

                            </tr>
                             <tr>

	                    	   <td>#1</td>
	                    	   <td>مصروفات قصات القماش خارج المصنع </td>
	                    	   <td> {{ $get_ClothStyles_for_suppliers }} جنيه </td>
	                    	   <td>  - </td>

                            </tr>
                              <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>مصروفات قصات القماش خارج المصنع مدفوعة للمصانع</td>
	                    	   <td> {{ $get_ClothStyles_for_suppliers_payed }} جنيه </td>
	                    	   <td>  {{ $total=$total - $get_ClothStyles_for_suppliers_payed }} جنيه </td>

                            </tr>

                             <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>مشتريات المصنع من المنتجات الجاهزة</td>
	                    	   <td> {{ $get_product_purchased }} جنيه </td>
	                    	   <td> {{ $total=$total - $get_product_purchased }} جنيه  </td>

                            </tr>


                            <tr>
                            	 <td colspan="4" style="text-align:center">  المبلغ الاجمالى  : {{ $total }} جنيه </td>
                            </tr>
	                    </tbody>
	                  </table>
	                </div>
	            </div>
	            <!-- start orders clothes -->

	             <div class="side-by-side col-md-12">

		            <div class="col-lg-12 col-xs-12">
                        <span class="alert" style="width: 100%;float: right;background-color: #00BCD4;color:white;margin-top:30px"> تفاصيل مديونات خزنة المصنع للسنة المالية {{ date('Y-m-d',strtotime(Fiscal_Year())) }}</span>
	            	</div>
            	    <div class="table-responsive" style="background-color:white">

	                  <table class="table m-0">
	                    <thead>
                           <tr>
	                    	   <th> الرقم </th>
	                    	   <th> قسم الصادر </th>
	                    	   <th> المبلغ المدفوع </th>
	                    	   <th> المتوفر فى الخزنة </th>
                           </tr>
	                    </thead>
	                    <tbody>

                            <tr>

	                    	   <td>#1</td>
	                    	   <td>ديون على التجار ( الغير مدفوعة )  </td>
	                    	   <td> {{ $get_debit_on_merchant }} جنيه </td>
	                    	   <td> -  </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>ديون على التجار ( مدفوعة )  </td>
	                    	   <td> {{ $get_debit_on_merchant_paid }} جنيه </td>
	                    	   <td>  {{ $total=$total - $get_debit_on_merchant_paid  }} جنيه </td>

                            </tr>

                            <tr>

	                    	   <td>#1</td>
	                    	   <td>ديون على مصانع قصات القماش ( الغير مدفوعة ) </td>
	                    	   <td> {{ $get_debit_on_supplier }} جنيه </td>
	                    	   <td> - </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>ديون على مصانع قصات القماش (مدفوعة )</td>
	                    	   <td> {{ $get_debit_on_supplier_paid }} جنيه </td>
	                    	   <td>  {{ $total=$total - $get_debit_on_supplier_paid }} جنيه </td>

                            </tr>

                              <tr>

	                    	   <td>#1</td>
	                    	   <td>ديون على العملاء ( الغير مدفوعة) </td>
	                    	   <td> {{ $get_debit_on_client }} جنيه </td>
	                    	   <td> - </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>ديون على العملاء (مدفوعة)</td>
	                    	   <td> {{ $get_debit_on_client_paid }} جنيه </td>
	                    	   <td>  {{ $total=$total  - $get_debit_on_client_paid }} جنيه </td>

                            </tr>



                            <tr>
                            	 <td colspan="4" style="text-align:center">  المبلغ الاجمالى  : {{ $total }} جنيه </td>
                            </tr>
	                    </tbody>
	                  </table>
	                </div>
	            </div>
	            <!-- start orders clothes -->

	               <div class="side-by-side col-md-12">

		            <div class="col-lg-12 col-xs-12">
                        <span class="alert" style="width: 100%;float: right;background-color: #00BCD4;color:white;margin-top:30px"> تفاصيل مديونات خزنة المصنع للسنة المالية {{ date('Y-m-d',strtotime(Fiscal_Year())) }}</span>
	            	</div>
            	    <div class="table-responsive" style="background-color:white">

	                  <table class="table m-0">
	                    <thead>
                           <tr>
	                    	   <th> الرقم </th>
	                    	   <th> قسم الصادر </th>
	                    	   <th> المبلغ المدفوع </th>
	                    	   <th> المتوفر فى الخزنة </th>
                           </tr>
	                    </thead>
	                    <tbody>

                            <tr>

	                    	   <td>#1</td>
	                    	   <td>ديون على المصنع للتجار ( الغير مدفوعة )  </td>
	                    	   <td> {{ $get_debit_for_merchant }} جنيه </td>
	                    	   <td> -  </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>ديون على المصنع للتجار ( مدفوعة )  </td>
	                    	   <td> {{ $get_debit_for_merchant_paid }} جنيه </td>
	                    	   <td>  {{ $total=$total + $get_debit_for_merchant_paid  }} جنيه </td>

                            </tr>

                            <tr>

	                    	   <td>#1</td>
	                    	   <td>ديون على المصنع للمصانع قصات القماش ( الغير مدفوعة ) </td>
	                    	   <td> {{ $get_debit_for_supplier }} جنيه </td>
	                    	   <td> - </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>ديون على المصنع لمصانع قصات القماش (مدفوعة )</td>
	                    	   <td> {{ $get_debit_for_supplier_paid }} جنيه </td>
	                    	   <td>  {{ $total=$total + $get_debit_for_supplier_paid  }} جنيه </td>

                            </tr>

                              <tr>

	                    	   <td>#1</td>
	                    	   <td>ديون على المصنع للعملاء ( الغير مدفوعة) </td>
	                    	   <td> {{ $get_debit_for_client }} جنيه </td>
	                    	   <td> - </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>ديون على المصنع للعملاء (مدفوعة)</td>
	                    	   <td> {{ $get_debit_for_client }} جنيه </td>
	                    	   <td>  {{ $total=$total  + $get_debit_for_client }} جنيه </td>

                            </tr>

                            <tr>
                            	 <td colspan="4" style="text-align:center">  المبلغ الاجمالى  : {{ $total }} جنيه </td>
                            </tr>
	                    </tbody>
	                  </table>
	                </div>
	            </div>
	            <!-- start orders clothes -->

	               <div class="side-by-side col-md-12">

		            <div class="col-lg-12 col-xs-12">
                        <span class="alert" style="width: 100%;float: right;background-color: #00BCD4;color:white;margin-top:30px"> تفاصيل المبيعات لخزنة المصنع للسنة المالية {{ date('Y-m-d',strtotime(Fiscal_Year())) }}</span>
	            	</div>
            	    <div class="table-responsive" style="background-color:white">

	                  <table class="table m-0">
	                    <thead>
                           <tr>
	                    	   <th> الرقم </th>
	                    	   <th> قسم الصادر </th>
	                    	   <th> المبلغ المدفوع </th>
	                    	   <th> المتوفر فى الخزنة </th>
                           </tr>
	                    </thead>
	                    <tbody>

                            <tr>

	                    	   <td>#1</td>
	                    	   <td>مبيعات المصنع   </td>
	                    	   <td> {{ $all_saling }} جنيه </td>
	                    	   <td> -  </td>

                            </tr>


                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td> مبيعات المصنع  الغير مدفوعة نقدا من العملاء </td>
	                    	   <td> {{ $all_saling - $get_sales_payed  }} جنيه </td>
	                    	   <td> {{ $total=$total -  ($all_saling  - $get_sales_payed) }} جنيه </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td> مبيعات المصنع المدفوعة نقدا من العملاء </td>
	                    	   <td> {{ $get_sales_payed }} جنيه </td>
	                    	   <td>  {{ $total=$total + $get_sales_payed   }} جنيه </td>

                            </tr>

                            <tr>

	                    	   <td>#1</td>
	                    	   <td>المرتجع   </td>
	                    	   <td> {{ $all_reactionist }} جنيه </td>
	                    	   <td> {{ $total = $total -  $all_reactionist }} جنيه </td>

                            </tr>


                            <tr>

	                    	   <td>#1</td>
	                    	   <td> أرباح المصنع </td>
	                    	   <td> {{ net_profit()  }} جنيه </td>
	                    	   <td>  - </td>

                            </tr>
                            <tr>

	                    	   <td>#1</td>
	                    	   <td> المسحوب من ارباح المصنع </td>
	                    	   <td> {{ factory_prodfit_withdraw()  }} جنيه </td>
	                    	   <td>  - </td>

                            </tr>
                             <tr>

	                    	   <td>#1</td>
	                    	   <td> المسحوب من ارباح الشركاء </td>
	                    	   <td> {{ $partner_withdraw_profit_all  }} جنيه </td>
	                    	   <td>  - </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td> المسحوب من الارباح </td>
	                    	   <td> {{  $profit_all_withdraws }} جنيه </td>
	                    	   <td>  {{ $total=$total - $profit_all_withdraws }} جنيه </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td> مصروفات المصنع </td>
	                    	   <td> {{  $get_all_expances }} جنيه </td>
	                    	   <td>  {{ $total=$total - $get_all_expances }} جنيه </td>

                            </tr>

                            <tr>
                            	 <td colspan="4" style="text-align:center">  المبلغ الاجمالى  : {{ $total }} جنيه </td>
                            </tr>
	                    </tbody>
	                  </table>
	                </div>
	            </div>
	            <!-- start orders clothes -->
			 </div>
			 <!-- end row -->
		</div>
    </section>
@stop

@section('css')
    <!-- Bootstrap 4 RTL -->
     <link rel="stylesheet" href="{{  asset('vendor/adminlte/dist/css/bootstrap-rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/custom.css') }}">
@stop

@section('js')
@stop
