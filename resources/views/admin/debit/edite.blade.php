@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> اضافة دائن و مدين </h1>
@stop


@section('content')
    <!-- Main content -->
    
    <section class="content">
      <div class="container-fluid">
          <div class="row">
            @if(!empty($single_debit))
              @foreach($single_debit as $debit)
              <!-- left column -->
              <div class="col-md-12"> 
                @if($message = Session::get('success'))
                  <div class="alert alert-warning alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <h5><i class="icon fas fa-check"></i> تمت</h5>
                      {{ $message }}
                    </div>
                @endif
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">اضافة دائن و مدين</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{ url('update-debit/'.$debit->id) }}" role="form" method="POST">
                        {{ csrf_field() }}
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">القسم</label>
                        <select name="debitable_type" id="section-type" class="form-control select2"  placeholder="القسم" >
                             <option value="" {{ ($debit->debitable_type?'':'selected') }} >أخر</option>
                             <option value="merchant" {{ ($debit->debitable_type=='merchant'?'selected':'') }} >تجار</option>
                             <option value="client" {{ ($debit->debitable_type=='client'?'selected':'') }} >عملاء</option>
                             <option value="suppliers" {{ ($debit->debitable_type=='suppliers'?'selected':'') }} >مصنع</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">نوع المديونية</label>
                         <select name="debit_type"  class="form-control select2"  placeholder="القسم" required>
                             <option value="دائن" {{ ($debit->debit_type=='دائن'?'selected':'') }}>دائن</option>
                             <option value="مدين" {{ ($debit->debit_type=='مدين'?'selected':'') }}>مدين</option>
                             
                        </select>
                      </div>

                       <div class="form-group">
                        <label for="exampleInputEmail1">نوع دفع المديونية</label>
                         <select name="type_payment"  class="form-control select2"  placeholder="القسم" required>
                             <option value="نقدى" {{ ($debit->type_payment=='نقدى'?'selected':'') }}>نقدى</option>
                             <option value="دفعات" {{ ($debit->type_payment=='دفعات'?'selected':'') }}>دفعات</option>
                             <option value="شيكات" {{ ($debit->type_payment=='شيكات'?'selected':'') }}>شيكات</option>
                        </select>
                      </div>

                      <div class="form-group" id="merchant_name"  {{ ($debit->debitable_type!='merchant'?"style=display:none":'') }} >
                        <label for="exampleInputEmail1">اسم التجار</label>
                        <select name="debitable_id"   class="form-control select2"  placeholder="القسم" style="display:none" >
                          @if(!empty($all_merchants))
                               @foreach($all_merchants as $merchant)
                                   <option value="{{ $merchant->id }}" {{ ($debit->debitable_id==$merchant->id?'selected':'') }} > {{ $merchant->merchant_name }} </option>
                               @endforeach
                           @endif
                        </select>
                      </div>

                      <div class="form-group" id="client_name" {{ ($debit->debitable_type!='client'?'style=display:none':'') }} >
                        <label for="exampleInputEmail1">اسم العميل</label>
                        <select name="debitable_id"   class="form-control select2"  placeholder="القسم" style="display:none" >
                        @if(!empty($all_clients))
                             @foreach($all_clients as $client)
                                 <option value="{{ $client->id }}" {{ ($debit->debitable_id==$client->id?'selected':'') }}> {{ $client->client_name }} </option>
                             @endforeach
                         @endif
                        </select>
                      </div>
                     
                       <div class="form-group" id="supplier_name" {{ ($debit->debitable_type!='suppliers'?'style=display:none':'') }}>
                        <label for="exampleInputEmail1">اسم المصنع</label>
                        <select name="debitable_id"  class="form-control select2"  placeholder="القسم"  >
                         @if(!empty($all_suppliers))
                             @foreach($all_suppliers as $suppliers)
                                 <option value="{{ $suppliers->id }}" {{ ($debit->debitable_id==$suppliers->id?'selected':'') }} > {{ $suppliers->supplier_name }} </option>
                             @endforeach
                         @endif
                        </select>
                      </div>

                      <div class="form-group" id="debit_name" {{ ($debit->debitable_type!=null?'style=display:none':'') }}>
                        <label for="exampleInputPassword1">اسم الدائن / المدين</label>
                        <input name="debit_name"  type="phone" class="form-control" value="{{ ($debit->debit_name?$debit->debit_name:'') }}" id="exampleInputPassword1" placeholder="اسم الدائن / المدين" >
                      </div>

                      <div class="form-group">
                        <label for="exampleInputPassword1">قيمة المبلغ الصلي</label>
                        <input name="debit_value" type="debit_value" class="form-control" value="{{ ($debit->debit_value?$debit->debit_value:'') }}" id="exampleInputPassword1" placeholder="قيمة المبلغ" required>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputPassword1">قيمة المبلغ المدفوع</label>
                        <input name="payed_check" type="debit_value" class="form-control" value="{{ ($debit->payed_check?$debit->payed_check:'') }}" id="exampleInputPassword1" placeholder="قيمة المبلغ" >
                      </div>
                  
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary"> اضافة دائن و مدين </button>
                    </div>
                  </form>
                </div>
                <!-- /.card -->

            
              </div>
                @endforeach
              @endif
          </div>
      </div>
    </section>
@stop

@section('css')
     <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/plugins/select2/css/select2.min.css') }}">
     <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <!-- Bootstrap 4 RTL -->
     <link rel="stylesheet" href="{{  asset('vendor/adminlte/dist/css/bootstrap-rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/custom.css') }}">
@stop

@section('js')
  <script src="{{ asset('vendor/adminlte/plugins/plugins/select2/js/select2.full.min.js') }}"></script>
  <script type="text/javascript">
         $('.select2').select2({
          theme: 'bootstrap4'
        });

         $('.select3').select2({
          theme: 'bootstrap4'
        });
  </script>
  <script type="text/javascript">
  jQuery('#section-type').change(function(){
     var type_section = jQuery(this).val();
     console.log(type_section);
     if(type_section=="merchant"){
        jQuery('#merchant_name').show();
        jQuery('#supplier_name').hide();
        jQuery('#client_name').hide();
        jQuery('#debit_name').hide();
     }
     else if(type_section=='client'){
        jQuery('#merchant_name').hide();
        jQuery('#supplier_name').hide();
        jQuery('#client_name').show();
        jQuery('#debit_name').hide();
     }
     else if(type_section==''){
        jQuery('#merchant_name').hide();
        jQuery('#supplier_name').hide();
        jQuery('#client_name').hide();
        jQuery('#debit_name').show();
     }
     else if(type_section=='suppliers'){
        jQuery('#merchant_name').hide();
        jQuery('#supplier_name').show();
        jQuery('#client_name').hide();
        jQuery('#debit_name').hide();  
     }
  });
  </script>
@stop