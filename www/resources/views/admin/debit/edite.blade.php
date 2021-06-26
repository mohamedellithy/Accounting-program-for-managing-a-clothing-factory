@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1> تعديل دائن و مدين </h1>
@stop


@section('content')
    <!-- Main content -->

    <section class="content">
      <div class="container-fluid">
          <div class="row">
            @if(!empty($debit))
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
                    <h3 class="card-title">تعديل دائن و مدين</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{ url('update-debit/'.$debit->id) }}" role="form" method="POST">
                        {{ csrf_field() }}
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">القسم</label>
                        <input name="debitable_type"  value="{{ $debit->debit_for }}" class="form-control"  placeholder="القسم" readonly>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">نوع المديونية</label>
                         <input name="debit_type"  class="form-control " value="{{ $debit->debit_type }}"  placeholder="القسم" required readonly>
                      </div>

                       <div class="form-group">
                        <label for="exampleInputEmail1">نوع دفع المديونية</label>
                         <input name="type_payment"  class="form-control " value="{{ $debit->type_payment }}"  placeholder="القسم" required readonly>
                      </div>

                      <div class="form-group" id="merchant_name"  {{ ($debit->debitable_type!='merchant'?"style=display:none":'') }} >
                        <label for="exampleInputEmail1">اسم التجار</label>
                        <select name="debitable_id"   class="form-control select2"  placeholder="القسم" style="display:none" >
                          <option value="{{ $debit->debitable->id }}"  > {{ $debit->debitable->merchant_name }} </option>
                        </select>
                      </div>

                      <div class="form-group" id="client_name" {{ ($debit->debitable_type!='client'?'style=display:none':'') }} >
                        <label for="exampleInputEmail1">اسم العميل</label>
                        <select name="debitable_id"   class="form-control select2"  placeholder="القسم" style="display:none" >
                            <option value="{{ $debit->debitable->id }}"  > {{ $debit->debitable->client_name }} </option>
                        </select>
                      </div>

                       <div class="form-group" id="supplier_name" {{ ($debit->debitable_type!='suppliers'?'style=display:none':'') }}>
                        <label for="exampleInputEmail1">اسم المصنع</label>
                        <select name="debitable_id"  class="form-control select2"  placeholder="القسم"  >
                            <option value="{{ $debit->debitable->id }}"  > {{ $debit->debitable->supplier_name }} </option>
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
                        <input name="debit_paid" type="debit_value" class="form-control" value="{{ ($debit->debit_paid?$debit->debit_paid:'') }}" id="exampleInputPassword1" placeholder="قيمة المبلغ" >
                      </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary"> تعديل دائن و مدين </button>
                    </div>
                  </form>
                </div>
                <!-- /.card -->


              </div>
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
