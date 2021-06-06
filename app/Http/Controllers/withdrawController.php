<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\partners;
use App\withdraw;
use DB;
use Storage;
use App\withdrawCapital;
class withdrawController extends Controller
{
    //

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $get_all_partners = partners::select('partner_name','id')->get();
         return view('admin.withdraw.index')->with(['all_partners'=>$get_all_partners]);
    }


     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

      /*  $this->validate($request,[
            'partner_id'=>'required',
            'withdraw_value'=>'required',
        ]);
        $data = $request->all();
        $old_value_percentage = net_profit_partner($request->input('partner_id'));
        partners::where('id', $request->input('partner_id') )->decrement('partner_percentage',$request->input('withdraw_value'));
        $new_value_percentage = net_profit_partner($request->input('partner_id'));
        // calculate if partner have profit or not
        $request['profit_value'] = ($old_value_percentage?($old_value_percentage - $new_value_percentage):null);
        $last_insert = withdraw::create($request->all());
        return back()->with(['success'=>'تم سحب من رأس المال بنجاح بنجاح','last_order'=>$last_insert]);
    */
        $this->validate($request,[
            'partner_id'=>'required',
            'withdraw_value'=>'required',
        ]);
       $old_value_percentage =net_profit_partner($request->input('partner_id')); //2220

       $get_percent = round((($request->withdraw_value/partner_capital($request->input('partner_id')))*100),2);
       $withdraw_profit = round(($get_percent*net_profit_partner($request->input('partner_id'))/100),2);
       // partners::where('id', $request->input('partner_id') )->decrement('partner_percentage',$request->input('withdraw_value'));
       $create_withdraw = new withdraw();
       $create_withdraw->partner_id  =$request->input('partner_id');
       $create_withdraw->withdraw_value = $request->withdraw_value;
       $create_withdraw->profit_value     = $withdraw_profit;
       $create_withdraw->save();
       return back()->with(['success'=>'تم سحب من رأس المال بنجاح بنجاح']);
    }

    function CreateWithdrawProfite(Request $request,$partner_id){
        $this->validate($request,[
            'profit_value'=>'required',
        ]);
        $data = $request->all();
        $request['type_withdraw']='1';
        $request['withdraw_value']='0';
        $request['partner_id']=$partner_id;

        // partners::where('id', $request->input('partner_id') )->decrement('partner_percentage',$request->input('withdraw_value'));
        if(net_profit_partner($partner_id)>=$request->profit_value):
           $last_insert = withdraw::create($request->all());
           return back()->with(['success'=>'تم سحب من ارباح الشريك بنجاح','last_order'=>$last_insert]);
        else:
            return back()->with(['success'=>'فشل سحب من ارباح الشريك ']);
        endif;

    }


    public function withdrawprofitandendpartner(Request $request ,$id){
         // partners::where('id', $id )->decrement('partner_percentage',$request->input('capital_value'));
          $insert_withdrow = new withdraw();
          $insert_withdrow->partner_id     = $id;
          $insert_withdrow->withdraw_value = $request->capital_value;
          $insert_withdrow->profit_value   = $request->net_profit_value;
          $insert_withdrow->type_withdraw  = 2;
          $insert_withdrow->save();
          partners::where('id', $id )->update(['partner_status'=>1]);
          return back()->with(['success'=>'تم سحب الارباح و انهاء الشراكة بنجاح']);

    }




    function datatableWithdraws(){
        $withdraw = DB::table('withdraws')->get();
         return datatables()->of($withdraw)
        ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox">';

            })
        ->addColumn('partner_name', function($row) {
                if(!empty($row->partner_id)){
                     return DB::table('partners')->where('id',$row->partner_id)->pluck('partner_name')[0];
                }

            })

           ->addColumn('withdraw_value', function($row) {
                return $row->withdraw_value.' جنيه ';
            })
        ->addColumn('original_value', function($row) {
                if(!empty($row->partner_id)){
                     return partner_capital($row->partner_id).'  جنيه';
                }

            })
          ->addColumn('withdraw_type', function($row) {
                if(!empty($row->profit_value)){
                    return 'سحب ارباح مبلغ :'.$row->profit_value;
                }
                return 'سحب من راس المال';
            })
        ->addColumn('process', function($row) {
                 return '<div class="btn-group">
                            <button type="button" class="btn btn-warning">اجراء</button>
                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                              <a class="dropdown-item delete_single" href="'.url('withdraw-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                              <div class="dropdown-divider"></div>

                            </div>
                        </div>';

            })->addColumn('show', function($row) {
                   return '<a href='.url('partners/'.$row->partner_id).' class="btn btn-success btn-sm">عرض </a>';
            })->rawColumns(['select','withdraw_value','withdraw_type','partner_name','original_value','process','show'])->make(true);

    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteWithdrawPartner($id)
    {
        withdraw::where('partner_id',$id)->delete();
        return back()->with(['success'=>'تم حذف السحب بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $partner_id     = withdraw::where('id',$id)->pluck('partner_id')[0];
        $withdraw_value = withdraw::where('id',$id)->pluck('withdraw_value')[0];
        partners::where('id',$partner_id)->increment('partner_percentage',$withdraw_value);
        withdraw::where('id',$id)->delete();
        return back()->with(['success'=>'تم حذف السحب بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteSelected(Request $request){
        if(! $request->input('select') ){
          return back();
        }
        $partner_id     = withdraw::where('id',$request->input('select'))->pluck('partner_id')->toArray();
        $withdraw_value = withdraw::where('id',$request->input('select'))->pluck('withdraw_value')->toArray();

        if(!empty($withdraw_value) &&  !empty($partner_id) ):
             foreach ($withdraw_value as $key => $value) :
                partners::where('id',$partner_id[$key])->increment('partner_percentage',$value);
             endforeach;
        endif;
        /*product::where('id',$product_id)->decrement('count_piecies',$count_order);*/
        withdraw::whereIn('id',$request->input('select'))->delete();
        return back()->with(['success'=>'تم حذف سحب  بنجاح']);
    }

    /**
     * Remove All resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function truncated(){
        $all_count = withdraw::all();
        if(!empty($all_count)):
             foreach ($all_count as $key => $value):
                  partners::where('id',$value->partner_id)->increment('partner_percentage',$value->withdraw_value);

             endforeach;
        endif;
        withdraw::truncate();
        return back()->with(['success'=>'تم حذف المرتجع بنجاح']);
    }


    function factoryCapital(){
        $get_all_partners = partners::all();
        return view('admin.capital.index')->with(['all_partners'=>$get_all_partners]);
    }

    function CreateCapital(Request $request){
        $capital = ['capital'=>$request->capital_value];
        file_put_contents('capital.json',$capital);
        return back();
    }

    function CreateWithdrawCapital(Request $request){
     /*  $old_value_percentage = get_net_profit_for_factory();
       $rest_value= get_original_capital_factory() - $request->withdraw_value;
       $capital = ['capital'=>$rest_value];
       file_put_contents('capital.json',$capital);
       $new_value_percentage = get_net_profit_for_factory();
       $withdraw_profit = $old_value_percentage - $new_value_percentage ;
       $create_withdraw = new withdrawCapital();
       $create_withdraw->withdraw_capital = $request->withdraw_value;
       $create_withdraw->withdraw_profit  = $withdraw_profit;
       $create_withdraw->save();
       return back();*/
       $old_value_percentage = get_net_profit_for_factory(); //2220


       $get_percent = round((($request->withdraw_value/get_original_capital_factory())*100),2);
       $withdraw_profit = round(($get_percent*get_net_profit_for_factory()/100),2);
       $rest_value= get_original_capital_factory() - $request->withdraw_value;
       $capital = ['capital'=>$rest_value];
       file_put_contents('capital.json',$capital);
       $create_withdraw = new withdrawCapital();
       $create_withdraw->withdraw_capital = $request->withdraw_value;
       $create_withdraw->withdraw_profit  = $withdraw_profit;
       $create_withdraw->save();
       return back();
       //var_dump($withdraw_profit);
    }


    function startFiscalyear(Request $request){
       $year = ['year'=>date('Y-m-d h:i:s')];
       file_put_contents('year.json',$year);
       return back();
    }

}
