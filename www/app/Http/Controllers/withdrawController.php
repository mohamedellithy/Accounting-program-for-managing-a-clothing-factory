<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Partner;
use App\withdraw;
use App\order;
use DB;
use Storage;
use App\withdrawCapital;
use App\setting;
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
         $get_all_partners = Partner::select('partner_name','id')->get();
         $Context = [
             'all_partners' => $get_all_partners
         ];
         return view('admin.withdraw.index')->with( $Context );
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
        $partner = Partner::find($request->partner_id);
        $this->validate($request,[
            'partner_id'    =>'required',
            'value'         =>'required|gt:0|lte:'.$partner->partner_cache_profits,
        ]);
        $withdraw = withdraw::create($request->all());
         $Context = [
            'success'=>'تم سحب من رأس المال بنجاح بنجاح'
         ];
         return back()->with(  $Context );
    }

    function CreateWithdrawProfite(Request $request,$partner_id){
        $partner = Partner::find($partner_id);
        $request['partner_id'] = $partner_id;
        $this->validate($request,[
            'partner_id'    =>'required',
            'value'         =>'required|gt:0|lte:'.$partner->partner_cache_profits,
        ]);
        $withdraw = withdraw::create($request->all());
        $Context = [
            'success'=>'تم سحب من رأس المال بنجاح بنجاح'
        ];
        return back()->with(  $Context );

    }


    public function endPercentPartner(Request $request ,$id){
          $partner = Partner::find($id);
          ProfitController::Transaction_Profit_Partners();
          ProfitController::Transaction_Profit_Capital();
          # withdraw profit
          if($partner->partner_cache_profits!=0):
                withdraw::create([
                    'partner_id' => $id,
                    'value'      => $partner->partner_cache_profits,
                ]);
          endif;
          #withdraw capital and end partner
          withdraw::create([
              'partner_id' => $id,
              'value'      => $partner->capital,
              'type'       => 1,
          ]);
          $partner->partner_status   = 1;
          $partner->partner_ended_at = date('Y-m-d h:i:s');
          $partner->save();
          return back()->with(['success'=>'تم سحب الارباح و انهاء الشراكة بنجاح']);

    }

    function datatableWithdraws(Request $request){
        $withdraw = withdraw::all();
        return datatables()->of($withdraw)
            ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox">';
            })
            ->addColumn('partner_name', function($row) {
                 if( $row->partner_id == 0 ) return 'المصنع';
                 return $row->partner->partner_name;
            })
           ->addColumn('withdraw_value', function($row) {
                return $row->value.' جنيه ';
            })
            ->addColumn('withdraw_type', function($row) {
                return $row->type_of_withdraw;
            })
            ->addColumn('created_at', function($row) {
                return $row->created_at;
            })
            ->addColumn('process', function($row) {
                 if($row->partner_id == 0) return 'لا يمكن الحذف';
                 if($row->partner->partner_status == 1) return 'لا يمكن الحذف';
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

            })
            ->addColumn('show', function($row) {
                   return '<a href='.url('partners/'.$row->partner_id).' class="btn btn-success btn-sm">عرض </a>';
            })
            ->rawColumns(['select','created_at','withdraw_value','withdraw_type','partner_name','process','show'])->make(true);

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
        withdraw::destroy('id',$id);
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

        withdraw::destroy($request->input('select'));
        return back()->with(['success'=>'تم حذف سحب  بنجاح']);
    }

    function CreateWithdrawCapital(Request $request){
        ProfitController::Transaction_Profit_Partners();
        ProfitController::Transaction_Profit_Capital();

        #withdraw capital and end partner
        withdraw::create([
            'partner_id' => 0,
            'value'      => $request->withdraw_value,
            'type'       => 1,
        ]);

        # decrement value of capital with value withdraw
        setting::where('setting','Capital')->decrement('value',$request->withdraw_value);

        return back();
    }

}
