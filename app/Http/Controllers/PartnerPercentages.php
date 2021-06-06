<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\partners;
use App\withdraw;
use DB;
class PartnerPercentages extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
          $partners_all  = partners::all();
          return view('admin.PartnerPercentages.index')->with('partners_all',$partners_all);

    }


    /**
     * Display a all partners in datatable
     *
     * @return \Illuminate\Http\Response
     */
    public function datatablePartners(Request $request){
        $partners = DB::table('partners')->get();
         return datatables()->of($partners)
        ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox"> #'.$row->id;


            })
        ->addColumn('partner_status', function($row) {
                if($row->partner_status!=0){
                    return ' شراكة منتهية ';
                }
                else{
                    return ' شراكة مستمرة ';
                }
            })
         ->addColumn('partner_percentage', function($row) {
              return partner_capital($row->id).' جنيه';
            })
           ->addColumn('partner_percent', function($row) {
              return calculate_partner_percentage($row->id).' % ';
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
            })->rawColumns(['select','process','show'])->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
         $last_partner_added = partners::orderby('created_at','desc')->first();
         //var_dump($last_partner_added);
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
        $last_insert = partners::create($request->all());
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

        $partner_data_info = partners::where('id',$id)->get();
        $withdraw_info     = withdraw::where('partner_id',$id)->get();
        return view('admin.PartnerPercentages.single')->with(['client_id'=>$id,'partner_data'=>$partner_data_info,'withdraw_info'=>$withdraw_info]);

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
        $partner_data_info = partners::where('id',$id)->get();
        return view('admin.PartnerPercentages.edite')->with('partner_data',$partner_data_info);

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
        $last_insert = partners::where('id',$id)->update($request->only(['partner_name','partner_phone','partner_percentage','partner_status']));
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
        partners::where('id',$id)->delete();
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
        partners::whereIn('id',$request->input('select'))->delete();
        return back()->with(['success'=>'تم حذف الشريك بنجاح']);
    }

    public function truncated(){
        partners::truncate();
        return back()->with(['success'=>'تم حذف الشريك بنجاح']);
    }
}
