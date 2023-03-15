<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Slider;

use App\Models\Product;


use App\Http\Requests;
use Illuminate\support\Facades\Redirect;
session_start();

class CategoryProduct extends Controller
{
     public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_category_product(){
        $this->AuthLogin(); 

    	return view('admin.add_category_product');

    }
    public function all_category_product(){
        $this->AuthLogin(); 

        $all_category_product = DB::table('tbl_category_product')->get();
        $manager_category_product = view('admin.all_category_product')->with('all_category_product',$all_category_product);
    	return view('adminlayout')->with('admin.all_category_product',$manager_category_product);


    }
    public function save_category_product(Request $request){
        $this->AuthLogin(); 

    	$data = array();
    	$data['category_name'] = $request->category_product_name;
    	$data['category_desc'] = $request->category_product_desc;
    	$data['category_status'] = $request->category_product_status;

    	DB::table('tbl_category_product')->insert($data);
        Session::put('message','Thêm Thành Công');
       return Redirect::to('add-category-product');


    }
    public function unactive_category_product($category_product_id){ 
        $this->AuthLogin(); 

        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>1]);
        Session::put('message','KHÔNG KÍCH HOẠT');
        return Redirect::to('all-category-product');


    }
    public function active_category_product($category_product_id){
        $this->AuthLogin(); 

          DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>0]);
        Session::put('message',' KÍCH HOẠT');
        return Redirect::to('all-category-product');
        

    }
    public function edit_category_product($category_product_id){
        $this->AuthLogin(); 

          $edit_category_product = DB::table('tbl_category_product')->where('category_id',$category_product_id)->get();

        $manager_category_product  = view('admin.edit_category_product')->with('edit_category_product',$edit_category_product);

        return view('adminlayout')->with('admin.edit_category_product', $manager_category_product);

    }
    public function update_category_product(Request $request,$category_product_id){
        $this->AuthLogin(); 

        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_desc'] = $request->category_product_desc;
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update($data);
        Session::put('message','Cập nhật danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
   
   }
 public function delete_category_product($category_product_id){
        $this->AuthLogin(); 
    
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->delete();
        Session::put('message','Xóa danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }

    public function show_category_home($category_id){
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
        $category_by_id = DB::table('tbl_product')->join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')->where('tbl_product.category_id',$category_id)->paginate(6);
        $category_name = DB::table('tbl_category_product')->where('category_id',$category_id)->get();


        return view('client.pages.category.show_category',[
            'category'=>$cate_product,
            'brand'=>$brand_product,
            'category_by_id'=>$category_by_id,
            'category_name'=> $category_name,
        ]);
    }

}