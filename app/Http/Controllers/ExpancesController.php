<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\order;
use Carbon\Carbon;
use App\expances;
use App\category;
use App\product;
use DB;
class ExpancesController extends Controller
{

    function index(){
        return view('admin.sales.expances');
    }


    function datatableExpances(Request $request){
         $merchants = DB::table('expances')->get();
         return datatables()->of($merchants)
        ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox"> #'.$row->id;
            })
        ->addColumn('expances_value', function($row) {
                 return $row->expances_value.' جنيه ';
            })->addColumn('expances_description', function($row) {
                 return $row->expances_description;
            })->addColumn('delete', function($row) {
                   return '<a href='.url('delete-expances/'.$row->id).' class="btn btn-danger btn-sm">حذف </a>';
            })->rawColumns(['select','expances_value','expances_description','delete'])->make(true);

    }


    function store(Request $request){

         $this->validate($request,[
             'expances_value' => 'required',
             'expances_description' => 'required'
        ]);

        expances::create($request->all());
        return back()->with(['success'=>'تم اضافة المصروف بنجاح']);

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
        expances::where('id',$id)->delete();
        return back()->with(['success'=>'تم حذف المصروف بنجاح']);
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
        expances::whereIn('id',$request->input('select'))->delete();
        return back()->with(['success'=>'تم حذف المصروفات بنجاح']);
    }


     public function truncated(){
        expances::truncate();
        return back()->with(['success'=>'تم حذف المصروفات بنجاح']);
    }

    function moneysafe(){
          return view('admin.sales.money-safe');
    }


}
