<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Partner;
use App\withdraw;
use DB;
class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
          $partners_all  = Partner::all();
          return view('admin.PartnerPercentages.index')->with('partners_all',$partners_all);

    }


    /**
     * Display a all partners in datatable
     *
     * @return \Illuminate\Http\Response
     */
    public function datatablePartners(Request $request){
        $partners = Partner::all();
         return datatables()->of($partners)
            ->addColumn('select', function($row) {
                    return '<input name="select[]" value="'.$row->id.'" type="checkbox"> #'.$row->id;
                })
            ->addColumn('partner_status', function($row) {
                    if($row->partner_status!=0)
                        return ' شراكة منتهية ';

                    return ' شراكة مستمرة ';
                })
            ->addColumn('partner_percentage', function($row) {
              return $row->capital.' جنيه';
            })
            ->addColumn('partner_percent', function($row) {
              return $row->percent.'%';
            })
            ->addColumn('partner_profit', function($row) {
              return $row->last_profits + $row->profit_from_percent.' جنية ';
            })
            ->addColumn('created_at', function($row) {
              return $row->profit()->first()->created_at ??  $row->created_at;
            })
            ->addColumn('process', function($row) {

                return '<div class="btn-group">
                            <button type="button" class="btn btn-warning">اجراء</button>
                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                              <a class="dropdown-item delete_single" href="'.url('partner-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item " href="'.url('partners/'.$row->id.'/edit').'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>
                            </div>
                        </div>';

            })->addColumn('show', function($row) {
                   return '<a href='.url('partners/'.$row->id).' class="btn btn-success btn-sm">عرض </a>';
            })->rawColumns(['select','partner_status','partner_profit','partner_percentage','partner_percent','process','show'])->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
         $last_partner_added = Partner::orderby('created_at','desc')->first();
         return view('admin.PartnerPercentages.create')->with(['last_partner'=>$last_partner_added]);
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
        $this->validate($request,[
             'partner_name' => 'required',
             'partner_phone' => 'required'
        ]);
        ProfitController::Transaction_Profit_Partners();
        ProfitController::Transaction_Profit_Capital();
        $last_insert = Partner::create($request->all());

        return back()->with(['success'=>'تم اضافة التاجر بنجاح','last_partner'=>$last_insert]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $partner_data_info = Partner::find($id);
        $Context = [
            'partner'=>$partner_data_info
        ];
        return view('admin.PartnerPercentages.single')->with($Context);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $partner_data_info = Partner::find($id);
        $Context = [
            'partner' => $partner_data_info,
        ];
        return view('admin.PartnerPercentages.edite')->with($Context);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request,[
             'partner_name' => 'required',
             'partner_phone' => 'required'
        ]);
        $last_insert = Partner::where('id',$id)->update($request->only(['partner_name','partner_phone','capital','partner_status']));
        return back()->with(['success'=>'تم تعديل الشريك بنجاح']);

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
        Partner::destroy($id);
        return back()->with(['success'=>'تم حذف الشريك بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteSelected(Request $request){
        if(!$request->input('select')){
          return back();
        }
        Partner::destroy($request->input('select'));
        return back()->with(['success'=>'تم حذف الشريك بنجاح']);
    }

    public function truncated(){
        Partner::truncate();
        return back()->with(['success'=>'تم حذف الشريك بنجاح']);
    }
}
