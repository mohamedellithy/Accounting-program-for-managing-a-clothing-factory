<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\product;
use App\ClothStyles;
use App\orderClothes;
use App\reactionist;
use App\order;
use App\category;
use DB;
class inventory extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $all_product = product::count();
        $finished_product = product::where('count_piecies',0)->count();
        $least_product = product::whereBetween('count_piecies',array(0,20))->count();
        $product_ids   = product::pluck('id')->toArray();
        $count_product_not_sale = order::whereIn('product_id',$product_ids)->distinct()->pluck('product_id')->toArray();
        $all_orderClothes = orderClothes::count();
        $finished_orderClothes = orderClothes::where('order_finished',1)->count();
        $cache_orderClothes    = orderClothes::where('payment_type','نقدى')->count();
        $check_orderClothes    = orderClothes::where('payment_type','شيك')->count();
        $all_ClothStyles       = ClothStyles::count();
        $all_category          = category::count();
        $all_reactionist       = reactionist::count();
        return view('admin.inventory.index')->with(['all_reactionist'=>$all_reactionist,'all_category'=>$all_category,'all_ClothStyles'=>$all_ClothStyles,'check_orderClothes'=>$check_orderClothes,'cache_orderClothes'=>$cache_orderClothes,'finished_orderClothes'=>$finished_orderClothes,'all_orderClothes'=>$all_orderClothes,'product_not_sale'=>count($count_product_not_sale),'least_product'=>$least_product,'all_product'=>$all_product,'finished_product'=>$finished_product]);
    }

    public function product($product_type){
           $title = ' المنتجات';
           if($product_type=='all'){
               $title = " مخزن المنتجات ";
           }
           if($product_type=='finished'){
               $title = " مخزن المنتجات المنتهية ";
           }
           if($product_type=='least'){
               $title = " مخزن المنتجات الاقل ";
           }
           if($product_type=='no-sale'){
               $title = " مخزن المنتجات لم يسحب منها ";
           }
           
           return view('admin.inventory.products')->with(['product_type'=>$product_type,'title'=>$title]);
    }

  


    

    public function datatableProducts(Request $request,$product_type){
        $clothStyles = DB::table('products')->get();
        if($product_type=='finished'){
           $clothStyles = DB::table('products')->where('count_piecies',0)->get();
        }
        if($product_type=='least'){
             $clothStyles = DB::table('products')->whereBetween('count_piecies',array(0,20))->get();
        }
        if($product_type=='no-sale'){
            $get_all_product_ids = order::distinct()->pluck('product_id')->toArray();
            $clothStyles = DB::table('products')->whereNotIn('id',$get_all_product_ids)->get();
        }
         return datatables()->of($clothStyles)
        ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox">';

            })
         ->addColumn('category', function($row) {
                if(!empty($row->category_id)){
                     return DB::table('categories')->where('id',$row->category_id)->pluck('category')[0];
                } 
                 return ' - ';
            })

         ->addColumn('full_price_handle',function($row){
               return $row->full_price.' جنيه '; 
         })
          ->addColumn('count_order',function($row){
               return order::where('product_id',$row->id)->count();
         })
         ->addColumn('count_piecies_handle',function($row){
               if($row->count_piecies==0){
                  return '<span class="badge badge-danger">منتهي</span>';
               }
               elseif($row->count_piecies<=20){
                  return '<span class="badge badge-warning">'.$row->count_piecies.' قطعة '.'</span>'; 
               }
                 return '<span class="badge badge-success">'.$row->count_piecies.' قطعة '.'</span>'; 
         })
        ->addColumn('process', function($row) {
                 return '<div class="btn-group">
                            <button type="button" class="btn btn-warning">اجراء</button>
                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                              <a class="dropdown-item delete_single" href="'.url('product-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item " href="'.url('product-edite/'.$row->id).'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>      
                            </div>  
                        </div>';

            })->addColumn('show', function($row) {
                   return '<a href='.url('single-product/'.$row->id).' class="btn btn-success btn-sm">عرض </a>';                
            })->rawColumns(['select','count_order','category','full_price_handle','count_piecies_handle','process','show'])->make(true);

    }



      public function orderClothes($order_type){
           $title = ' المنتجات';
           if($order_type=='all'){
               $title = " مخزن طلبات القماش ";
           }
           if($order_type=='finished'){
               $title = " مخزن طلبات القماش المنتهية ";
           }
           if($order_type=='cache'){
               $title = " مخزن طلبات القماش النقدى ";
           }
           if($order_type=='check'){
               $title = " مخزن طلبات القماش بالشيك ";
           }
           
           return view('admin.inventory.orders')->with(['order_type'=>$order_type,'title'=>$title]);
    }


     /**
     * Display a all merchants in datatable
     *
     * @return \Illuminate\Http\Response
     */
    public function datatableorderClothes(Request $request,$order_type){
        $orderClothes = DB::table('order_clothes')->get();
       if($order_type=='finished'){
           $orderClothes = DB::table('order_clothes')->where('order_finished',1)->get();
       }
       if($order_type=='cache'){
           $orderClothes    = DB::table('order_clothes')->where('payment_type','نقدى')->get();
       }
       if($order_type=='check'){
           $orderClothes    = DB::table('order_clothes')->where('payment_type','شيك')->get();
       }
         return datatables()->of($orderClothes)
        ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox">';
            })
        ->addColumn('merchant_name', function($row) {
                 return DB::table('merchants')->where('id',$row->merchant_id)->pluck('merchant_name')[0];
            })
        ->addColumn('category_name', function($row) {
                 return DB::table('categories')->where('id',$row->category_id)->pluck('category')[0];
            })
        ->addColumn('order_price', function($row) {
                 return $row->order_price.' جنية';
            })
        ->addColumn('Quantity', function($row) {
                 return $row->order_size.' '.$row->order_size_type;
            })
        ->addColumn('process', function($row) {
                 return '<div class="btn-group">
                            <button type="button" class="btn btn-warning">اجراء</button>
                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                              <a class="dropdown-item delete_single" href="'.url('order-clothes-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item " href="'.url('order-clothes-edite/'.$row->id).'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>      
                            </div>  
                        </div>';

            })->addColumn('show', function($row) {
                   return '<a href='.url('single-order-clothes/'.$row->id).' class="btn btn-success btn-sm">عرض </a>';                
            })->rawColumns(['select','process','show'])->make(true);

    }



    public function clothesStyles($cloth_type){
           $title = ' المنتجات';
           if($cloth_type=='all'){
               $title = " مخزن قصات القماش ";
           }
           return view('admin.inventory.styles')->with(['cloth_type'=>$cloth_type,'title'=>$title]);
    }


       /**
     * Display a all clothes in datatable
     *
     * @return \Illuminate\Http\Response
     */

     public function datatablePiecies(Request $request){
          $clothStyles = DB::table('cloth_styles')->leftJoin('order_clothes','cloth_styles.order_clothes_id','=','order_clothes.id')->select('cloth_styles.id as id','cloth_styles.created_at','cloth_styles.order_clothes_id','cloth_styles.full_price','cloth_styles.count_piecies','order_clothes.category_id','cloth_styles.name_piecies')->get();
         return datatables()->of($clothStyles)
        ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox">';

            })
         ->addColumn('category', function($row) {
                if(!empty($row->category_id)){
                     return DB::table('categories')->where('id',$row->category_id)->pluck('category')[0];
                } 
                 return ' - ';
            })

         ->addColumn('full_price_handle',function($row){
               return $row->full_price.' جنيه '; 
         })
         ->addColumn('count_piecies_handle',function($row){
               return $row->count_piecies.' قطعة '; 
         })
        ->addColumn('process', function($row) {
                 return '<div class="btn-group">
                            <button type="button" class="btn btn-warning">اجراء</button>
                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                              <a class="dropdown-item delete_single" href="'.url('piecies-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item " href="'.url('piecies-edite/'.$row->id.'/'.$row->order_clothes_id).'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>      
                            </div>  
                        </div>';

            })->addColumn('show', function($row) {
                   return '<a href='.url('single-piecies/'.$row->id).' class="btn btn-success btn-sm">عرض </a>';                
            })->rawColumns(['select','full_price_handle','count_piecies_handle','process','show'])->make(true);

    }

      public function category($category_type){
           $title = ' المنتجات';
           if($category_type=='all'){
               $title = " مخزن الاصناف";
           }
           return view('admin.inventory.category')->with(['category_type'=>$category_type,'title'=>$title]);
    }


    /**
     * Display a all Categories in datatable
     *
     * @return \Illuminate\Http\Response
     */
    public function datatableCategories(Request $request){
        $categories = DB::table('categories')->get();
         return datatables()->of($categories)
        ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox"> '.$row->id.'#';


            })
            ->addColumn('count_orders', function($row) {
                $count_order = orderClothes::where('category_id',$row->id)->count();
                $type = "طلب";
                if(empty($count_order)){
                    $count_order = product::where('category_id',$row->id)->count();
                    $type = "منتج";
                }

                return ($count_order?$count_order.' '.$type:' فارغ ');
            })
            ->addColumn('process', function($row) {
                 return '<div class="btn-group">
                            <button type="button" class="btn btn-warning">اجراء</button>
                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                              <a class="dropdown-item delete_single" href="'.url('category-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item " href="'.url('category-edite/'.$row->id).'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>      
                            </div>  
                        </div>';

            })->rawColumns(['select','count_orders','process'])->make(true);

    }


    public function reactionist($reactionist_type){
           $title = ' المنتجات';
           if($reactionist_type=='all'){
               $title = " مخزن المرتجع";
           }
           return view('admin.inventory.reactionist')->with(['reactionist_type'=>$reactionist_type,'title'=>$title]);
    }


      function datatableReactionist(Request $request){
        $orderClothes = DB::table('reactionists')->get();
         return datatables()->of($orderClothes)
        ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox">';
            })
        ->addColumn('order_number', function($row) {
                 return '#'.$row->order_id;
            })
        ->addColumn('product_name', function($row) {
                 if($row->product_id):
                     return DB::table('products')->where('id',$row->product_id)->pluck('name_product')[0];
                 else:
                     return 'بدون';
                 endif;
            })
        ->addColumn('client_name', function($row) {
                 if($row->client_id):
                     return DB::table('clients')->where('id',$row->client_id)->pluck('client_name')[0];
                 else:
                     return 'بدون';
                 endif;
            })
        ->addColumn('category_name', function($row) {
                 //return 'ok';
                 $category_id = DB::table('products')->where('id',$row->product_id)->pluck('category_id')[0];
                 if($category_id):
                     return DB::table('categories')->where('id',$category_id)->pluck('category')[0];
                 else:
                     return 'بدون';
                 endif;
            })
        ->addColumn('reactionist_price', function($row) {
                 return $row->reactionist_price.' جنية';
            })
        ->addColumn('Quantity', function($row) {
                 return $row->order_count.' قطعة';
            })
        ->addColumn('process', function($row) {
                 return '<div class="btn-group">
                            <button type="button" class="btn btn-warning">اجراء</button>
                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                              <a class="dropdown-item delete_single" href="'.url('reactionist-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item " href="'.url('reactionist-edite/'.$row->id).'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>      
                            </div>  
                        </div>';

            })
        ->addColumn('show', function($row) {
                   return '<a href='.url('single-reactionist/'.$row->id).' class="btn btn-success btn-sm">عرض </a>';                
            })
        ->rawColumns(['select','Quantity','order_number','reactionist_price','process','show'])->make(true);
    }

}
