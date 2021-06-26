<div class="merchant-orders side-by-side col-md-8">
    <div class="card" id="card_print_1">
        <div class="card-header border-transparent">
            <h3 class="card-title">طلبات القماش الخاصة بالتاجر <label > \ {{ $merchant_data->merchant_name }}</label> </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
        <div class="table-responsive" style="max-height: 300px;">
            <table class="table m-0">
            <thead>
            <tr>
                <th>رقم الطلب</th>
                <th>الطلبية</th>
                <th>الدفع</th>
                <th>تاريخ </th>
                <th>قيمة الطلبية</th>
                <th>تفاصيل </th>
            </tr>
            </thead>
            <tbody>

                @forelse($order_clothes_info as $order_clothes)
                    <tr>
                        <td><a href="pages/examples/invoice.html"> {{ $order_clothes->id }} </a></td>
                        <td>{{$order_clothes->category_name->category }}</td>
                        <td>
                            <span class="badge {{ ( ($order_clothes->payment_type=='نقدى')?'badge-success':'badge-info') }} ">{{ $order_clothes->payment_type }}  </span>
                        </td>
                        <td>
                        <div class="sparkbar" data-color="#00a65a" data-height="20"> {{$order_clothes->created_at }} </div>
                        </td>
                        <td> {{ get_orderClothes_price($order_clothes->id) }} جنيه </td>
                        <td >
                            <a href="{{ url('orders-clothes/'.($order_clothes->order_follow?$order_clothes->order_follow:$order_clothes->id) ) }}" class="btn btn-sm btn-primary float-left">تفاصيل</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                            <td colspan="5" style="text-align:center"> لايوجد اى طلبات </td>
                    </tr>
                @endforelse

            </tbody>
            </table>
        </div>
        <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
        <!--   <a href="{{ url('delete-merchant-orders/'.$merchant_data->id) }}"  class="btn btn-sm btn-info delete_all float-left" data-toggle="modal" data-target="#modal-default"  > <i class="far fa-trash-alt"></i> حذف الطلبات</a> -->
            <table style="width:100%">
                <tr>
                    <td style="padding: 12px;background-color: white;border: 1px solid gray;">
                        المبلغ الاجمالى : {{ $total }} جنيه
                    </td>

                    <td style="padding: 12px;background-color: white;border: 1px solid gray;">
                        المبلغ المدفوع للتاجر :  {{ $paid + $total_cache + $debits_payed + $debits_not_payed  }} جنيه
                    </td>

                    <td style="padding: 12px;background-color: white;border: 1px solid gray;">
                        المبلغ المدفوع للطلبات:  {{ $paid + $total_cache + $debits_payed  }} جنيه
                    </td>

                    <td style="padding: 12px;background-color: white;border: 1px solid gray;">
                        المبلغ المتبقى : {{ ($total_not_cache < $paid ) ?'0 مديونية:'.($debits_not_payed  ):($total_not_cache - $paid ) }} جنيه
                    </td>


                </tr>
                <tr>
                    <td colspan="4" style="padding: 10px;background-color: wheat;">
                        تم ادانة التاجر بمبلغ قيمته  {{ $debits_not_payed }} جنيه
                    </td>
                </tr>

            </table>

        <a href="#" onclick="printDiv('card_print_1')" class="btn btn-sm btn-info float-left">طباعة</a>

        </div>
        <!-- /.card-footer -->
    </div>
</div>
