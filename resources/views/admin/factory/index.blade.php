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
                        <span class="alert" style="width: 100%;float: right;background-color: #00BCD4;color:white"> تفاصيل رأس مال خزنة المصنع للسنة المالية {{ date('Y-m-d',strtotime(Fiscal_Year)) }}</span>
	            	</div>
            	    <div class="table-responsive" style="max-height: 400px;background-color:white">
	                  @php $total = get_capital_factory_before_withdraw()  @endphp
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
	                    	   <td> {{ get_capital_factory_before_withdraw() }} جنيه </td>
	                    	   <td> - </td>

                            </tr>
                              <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>المسحوب من رأس مال المصنع </td>
	                    	   <td> {{ ( get_capital_factory_before_withdraw() - get_original_capital_factory()) }} جنيه </td>
	                    	   <td> {{  $total = $total - ( get_capital_factory_before_withdraw() -  get_original_capital_factory() ) }} جنيه  </td>

                            </tr>
                            <tr>

	                    	   <td>#1</td>
	                    	   <td>رأس مال الشركاء قبل عمليات السحب</td>
	                    	   <td> {{ get_partners_full_capital_value() }} جنيه </td>
	                    	   <td> -  </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>المسحوب من رأس مال الشركاء</td>
	                    	   <td> {{ get_partners_full_capital_value() - partners_capitals_after_withdraw() }} جنيه </td>
	                    	   <td> {{  $total +=partners_capitals_after_withdraw() }} جنيه  </td>

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
                        <span class="alert" style="width: 100%;float: right;background-color: #00BCD4;color:white;margin-top:30px"> تفاصيل صادر خزنة المصنع للسنة المالية {{ date('Y-m-d',strtotime(Fiscal_Year)) }}</span>
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
	                    	   <td> {{ get_outgoings() }} جنيه </td>
	                    	   <td>  -  </td>

                            </tr>
                            <tr>

	                    	   <td>#1</td>
	                    	   <td>مشتريات المصنع من القماش غير مدفوعة نقدا للتجار</td>
	                    	   <td> {{ get_outgoings() - get_outgoings_payed() }} جنيه </td>
	                    	   <td> -  </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>مشتريات المصنع من القماش مدفوعة نقدا للتجار</td>
	                    	   <td> {{ get_outgoings_payed() }} جنيه </td>
	                    	   <td> {{ $total=$total - get_outgoings_payed() }} جنيه  </td>

                            </tr>

                             <tr >

	                    	   <td>#1</td>
	                    	   <td>مصروفات قصات القماش داخل المصنع </td>
	                    	   <td> {{ get_payments_for_suppliers(1,1) }} جنيه </td>
	                    	   <td>  - </td>

                            </tr>
                             <tr>

	                    	   <td>#1</td>
	                    	   <td>مصروفات قصات القماش خارج المصنع </td>
	                    	   <td> {{ get_payments_for_suppliers(1) }} جنيه </td>
	                    	   <td>  - </td>

                            </tr>
                              <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>مصروفات قصات القماش خارج المصنع مدفوعة للمصانع</td>
	                    	   <td> {{ get_payments_for_suppliers() }} جنيه </td>
	                    	   <td>  {{ $total=$total - get_payments_for_suppliers() }} جنيه </td>

                            </tr>

                             <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>مشتريات المصنع من المنتجات الجاهزة</td>
	                    	   <td> {{ get_product_purchased() }} جنيه </td>
	                    	   <td> {{ $total=$total - get_product_purchased() }} جنيه  </td>

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
                        <span class="alert" style="width: 100%;float: right;background-color: #00BCD4;color:white;margin-top:30px"> تفاصيل مديونات خزنة المصنع للسنة المالية {{ date('Y-m-d',strtotime(Fiscal_Year)) }}</span>
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
	                    	   <td> {{ get_debit_for_merchant(null,'merchant') }} جنيه </td>
	                    	   <td> -  </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>ديون على التجار ( مدفوعة )  </td>
	                    	   <td> {{ get_debit_for_merchant(1,'merchant') }} جنيه </td>
	                    	   <td>  {{ $total=$total - get_debit_for_merchant(null,'merchant')  }} جنيه </td>

                            </tr>

                            <tr>

	                    	   <td>#1</td>
	                    	   <td>ديون على مصانع قصات القماش ( الغير مدفوعة ) </td>
	                    	   <td> {{ get_debit_for_merchant(null,'suppliers') }} جنيه </td>
	                    	   <td> - </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>ديون على مصانع قصات القماش (مدفوعة )</td>
	                    	   <td> {{ get_debit_for_merchant(1,'suppliers') }} جنيه </td>
	                    	   <td>  {{ $total=$total - get_debit_for_merchant(null,'suppliers') }} جنيه </td>

                            </tr>

                              <tr>

	                    	   <td>#1</td>
	                    	   <td>ديون على العملاء ( الغير مدفوعة) </td>
	                    	   <td> {{ get_debit_for_merchant(null,'client') }} جنيه </td>
	                    	   <td> - </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>ديون على العملاء (مدفوعة)</td>
	                    	   <td> {{ get_debit_for_merchant(1,'client') }} جنيه </td>
	                    	   <td>  {{ $total=$total  - get_debit_for_merchant(null,'client') }} جنيه </td>

                            </tr>

                            <tr>

	                    	   <td>#1</td>
	                    	   <td>ديون أخرى ( الغير مدفوعة)</td>
	                    	   <td> {{ get_debit_for_merchant(null) }} جنيه </td>
	                    	   <td> - </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>ديون أخرى ( مدفوعة)</td>
	                    	   <td> {{ get_debit_for_merchant(1) }} جنيه </td>
	                    	   <td>  {{ $total=$total - get_debit_for_merchant(null)  }} جنيه </td>

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
                        <span class="alert" style="width: 100%;float: right;background-color: #00BCD4;color:white;margin-top:30px"> تفاصيل مديونات خزنة المصنع للسنة المالية {{ date('Y-m-d',strtotime(Fiscal_Year)) }}</span>
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
	                    	   <td> {{ get_debit_for_merchant(null,'merchant','مدين') }} جنيه </td>
	                    	   <td> -  </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>ديون على المصنع للتجار ( مدفوعة )  </td>
	                    	   <td> {{ get_debit_for_merchant(1,'merchant','مدين') }} جنيه </td>
	                    	   <td>  {{ $total=$total + get_debit_for_merchant(null,'merchant','مدين')  }} جنيه </td>

                            </tr>

                            <tr>

	                    	   <td>#1</td>
	                    	   <td>ديون على المصنع للمصانع قصات القماش ( الغير مدفوعة ) </td>
	                    	   <td> {{ get_debit_for_merchant(null,'suppliers','مدين') }} جنيه </td>
	                    	   <td> - </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>ديون على المصنع لمصانع قصات القماش (مدفوعة )</td>
	                    	   <td> {{ get_debit_for_merchant(1,'suppliers','مدين') }} جنيه </td>
	                    	   <td>  {{ $total=$total + get_debit_for_merchant(null,'suppliers','مدين') }} جنيه </td>

                            </tr>

                              <tr>

	                    	   <td>#1</td>
	                    	   <td>ديون على المصنع للعملاء ( الغير مدفوعة) </td>
	                    	   <td> {{ get_debit_for_merchant(null,'client','مدين') }} جنيه </td>
	                    	   <td> - </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>ديون على المصنع للعملاء (مدفوعة)</td>
	                    	   <td> {{ get_debit_for_merchant(1,'client','مدين') }} جنيه </td>
	                    	   <td>  {{ $total=$total  + get_debit_for_merchant(null,'client','مدين') }} جنيه </td>

                            </tr>

                            <tr>

	                    	   <td>#1</td>
	                    	   <td>ديون أخرى على المصنع ( الغير مدفوعة)</td>
	                    	   <td> {{ get_debit_for_merchant(null,null,'مدين') }} جنيه </td>
	                    	   <td> - </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td>ديون أخرى على المصنع ( مدفوعة)</td>
	                    	   <td> {{ get_debit_for_merchant(1,null,'مدين') }} جنيه </td>
	                    	   <td>  {{ $total=$total + get_debit_for_merchant(null,null,'مدين')  }} جنيه </td>

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
                        <span class="alert" style="width: 100%;float: right;background-color: #00BCD4;color:white;margin-top:30px"> تفاصيل المبيعات لخزنة المصنع للسنة المالية {{ date('Y-m-d',strtotime(Fiscal_Year)) }}</span>
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
	                    	   <td> {{ get_all_saleing_income() }} جنيه </td>
	                    	   <td> -  </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td> مبيعات المصنع  الغير مدفوعة نقدا من العملاء </td>
	                    	   <td> {{ get_all_saleing_income() - get_sales_payed()  }} جنيه </td>
	                    	   <td> {{ $total=$total -  (get_all_saleing_income()  - get_sales_payed()) }} جنيه </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td> مبيعات المصنع المدفوعة نقدا من العملاء </td>
	                    	   <td> {{ get_sales_payed() }} جنيه </td>
	                    	   <td>  {{ $total=$total + get_sales_payed()   }} جنيه </td>

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
	                    	   <td> {{ partner_withdraw_profit_all()  }} جنيه </td>
	                    	   <td>  - </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td> المسحوب من الارباح </td>
	                    	   <td> {{  net_profit() - net_profit_after_withdraw() }} جنيه </td>
	                    	   <td>  {{ $total=$total - (net_profit() - net_profit_after_withdraw()) }} جنيه </td>

                            </tr>
                            <tr style="background-color: #FFEB3B;">

	                    	   <td>#1</td>
	                    	   <td> مصروفات المصنع </td>
	                    	   <td> {{  get_all_expances() }} جنيه </td>
	                    	   <td>  {{ $total=$total - get_all_expances() }} جنيه </td>

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
