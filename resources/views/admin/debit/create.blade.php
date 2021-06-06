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
                  <form action="{{ url('create-debit') }}" role="form" method="POST">
                        {{ csrf_field() }}
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">القسم</label>
                        <select name="debitable_type" id="section-type" class="form-control select2"  placeholder="القسم" >
                             <option value="">أخر</option>
                             <option value="merchant">تجار</option>
                             <option value="client">عملاء</option>
                             <option value="suppliers">مصنع</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">نوع المديونية</label>
                         <select name="debit_type"  class="form-control select2"  placeholder="القسم" required>
                             <option value="دائن">دائن</option>
                             <option value="مدين">مدين</option>
                             
                        </select>
                      </div>

                       <div class="form-group">
                        <label for="exampleInputEmail1">نوع دفع المديونية</label>
                         <select name="type_payment"  class="form-control select2"  placeholder="القسم" required>
                             <option value="نقدى">نقدى</option>
                             <option value="دفعات">دفعات</option>
                             <option value="شيكات">شيكات</option>
                        </select>
                      </div>

                      <div class="form-group" id="merchant_name" style="display:none">
                        <label for="exampleInputEmail1">اسم التجار</label>
                        <select name="debitable_id"   class="form-control select2"  placeholder="القسم" style="" disabled>
                           
                          @if(!empty($all_merchants))
                               @foreach($all_merchants as $merchant)
                                   <option value="{{ $merchant->id }}"> {{ $merchant->merchant_name }} </option>
                               @endforeach
                           @endif
                        </select>
                      </div>

                      <div class="form-group" id="client_name" style="display:none">
                        <label for="exampleInputEmail1">اسم العميل</label>
                        <select name="debitable_id"   class="form-control select2"  placeholder="القسم" style="display:none" disabled>
                            
                        @if(!empty($all_clients))
                             @foreach($all_clients as $client)
                                 <option value="{{ $client->id }}"> {{ $client->client_name }} </option>
                             @endforeach
                         @endif
                        </select>
                      </div>

                       <div class="form-group" id="supplier_name" style="display:none">
                        <label for="exampleInputEmail1">اسم المصنع</label>
                        <select name="debitable_id"  class="form-control select2"  placeholder="القسم"  disabled>
                          
                         @if(!empty($all_suppliers))
                             @foreach($all_suppliers as $suppliers)
                                 <option value="{{ $suppliers->id }}"> {{ $suppliers->supplier_name }} </option>
                             @endforeach
                         @endif
                        </select>
                      </div>

                      <div class="form-group" id="debit_name">
                        <label for="exampleInputPassword1">اسم الدائن / المدين</label>
                        <input name="debit_name"  type="phone" class="form-control" id="exampleInputPassword1" placeholder="اسم الدائن / المدين" >
                      </div>

                      <div class="form-group">
                        <label for="exampleInputPassword1">قيمة المبلغ</label>
                        <input name="debit_value" type="debit_value" class="form-control" id="exampleInputPassword1" placeholder="قيمة المبلغ" required>
                      </div>
                  
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary"> اضافة دائن و مدين </button>
                    </div>
                  </form>
                </div>
                <!-- /.card -->

                {{--  here show table of added last  --}}
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">أخر ما تم اضافته من التجار</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th>#</th>
                      <th>أسم الدائن / المدين</th>
                      <th>نوع الدين</th>
                      <th>قيمة المبلغ</th>
                      <th>تاريخ الانشاء</th>                      
                    </tr>
                  </thead>
                  <tbody>
                    @if($last = (Session::get('last_debit')?Session::get('last_debit'):$last_debit) ) 
                        <tr>
                          <td>1.</td>
                          <td>
                           @if(($last->debitable_type!=null)&&($last->debitable_id!=null))
                             {{ get_debit_name($last->debitable_type,$last->debitable_id) }} 
                           @else
                               {{ $last->debit_name }}
                           @endif 

                           </td>
                          <td>
                              {{ $last->debit_type }}
                          </td>
                          <td>
                              {{ $last->debit_value }} جنيه
                          </td>
                          
                          <td>
                              {{ $last->created_at }}
                          </td>
                         
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
        jQuery('#merchant_name').show(function(){
            jQuery('#merchant_name select').attr('disabled',false);
        });
        jQuery('#supplier_name').hide(function(){
            jQuery('#supplier_name select').attr('disabled',true);
        });
        jQuery('#client_name').hide(function(){
            jQuery('#client_name select').attr('disabled',true);
        });
        jQuery('#debit_name').hide();
     }
     else if(type_section=='client'){
        jQuery('#merchant_name').hide(function(){
              jQuery('#merchant_name select').attr('disabled',true);
        });
        jQuery('#supplier_name').hide(function(){
              jQuery('#supplier_name select').attr('disabled',true);
        });
        jQuery('#client_name').show(function(){
              jQuery('#client_name select').attr('disabled',false);
        });
        jQuery('#debit_name').hide();
     }
     else if(type_section==''){
        jQuery('#merchant_name').hide(function(){
             jQuery('#merchant_name select').attr('disabled',true);
        });
        jQuery('#supplier_name').hide(function(){
             jQuery('#supplier_name select').attr('disabled',true);
        });
        jQuery('#client_name').hide(function(){
             jQuery('#client_name select').attr('disabled',true);
        });
        jQuery('#debit_name').show();
     }
     else if(type_section=='suppliers'){
        jQuery('#merchant_name').hide(function(){
             jQuery('#merchant_name select').attr('disabled',true);
        });
        jQuery('#supplier_name').show(function(){
             jQuery('#supplier_name select').attr('disabled',false);
        });
        jQuery('#client_name').hide(function(){
             jQuery('#client_name select').attr('disabled',true);
        });
        jQuery('#debit_name').hide();  
     }
  });
  </script>
@stop