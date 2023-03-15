<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cart;
use Carbon\Carbon;
use Session;
use App\Http\Requests;
use Illuminate\support\Facades\Redirect;
use App\City;
use App\Province;

use App\Product;
use App\Customer;
use App\Wards;
use App\Feeship;
use App\Comment;

use App\Slider;

use App\Shipping;

use App\Order;
use App\Coupon;
use App\OrderDetails;
session_start();


class CheckoutController extends Controller
{   
     public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function huy_don_hang(Request $request){
    $data = $request->all();
      $order = Order::where('order_code',$data['order_code'])->first();

      $order->order_destroy = $data['lydo'];
      $order->order_status = 3;
      $order->save();

    }
    public function history(Request $request){
    if(!Session::get('customer_id')){
      return redirect('dang-nhap')->with('error','Vui lòng đăng nhập để xem lịch sử mua hàng');
    }else{

          //seo 
          $meta_desc = "Lịch sử đơn hàng"; 
          $meta_keywords = "Lịch sử đơn hàng";
          $meta_title = "Lịch sử đơn hàng";
          $url_canonical = $request->url();
          //--seo

        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
          
       $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();

          $getorder = Order::where('customer_id',Session::get('customer_id'))->orderby('order_id','DESC')->paginate(10);

        return view('client.pages.history.history')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('getorder',$getorder)->with('slider',$slider); //1
    }
  }
  public function view_history_order(Request $request,$order_code){
    if(!Session::get('customer_id')){
      return redirect('dang-nhap')->with('error','Vui lòng đăng nhập để xem lịch sử mua hàng');
    }else{

     

        
          //seo 
          $meta_desc = "Lịch sử đơn hàng"; 
          $meta_keywords = "Lịch sử đơn hàng";
          $meta_title = "Lịch sử đơn hàng";
          $url_canonical = $request->url();
          //--seo
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
          
     $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
          
          //xem lich sử
          $order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
      $getorder = Order::where('order_code',$order_code)->first();
      
      $customer_id = $getorder->customer_id;
      $shipping_id = $getorder->shipping_id;
      $order_status = $getorder->order_status;
      
      $customer = Customer::where('customer_id',$customer_id)->first();
      $shipping = Shipping::where('shipping_id',$shipping_id)->first();

      $order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();

      foreach($order_details_product as $key => $order_d){

        $product_coupon = $order_d->product_coupon;
      }
      if($product_coupon != 'no'){
        $coupon = Coupon::where('coupon_code',$product_coupon)->first();
        $coupon_condition = $coupon->coupon_condition;
        $coupon_number = $coupon->coupon_number;
      }else{
        $coupon_condition = 2;
        $coupon_number = 0;
      }

        return view('client.pages.history.view_history_order')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('order_details',$order_details)->with('customer',$customer)->with('shipping',$shipping)->with('coupon_condition',$coupon_condition)->with('coupon_number',$coupon_number)->with('getorder',$getorder)->with('order_status',$order_status)->with('order_code',$order_code)->with('slider',$slider); //1
    }
  }
    public function print_order($checkout_code){
    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($this->print_order_convert($checkout_code));
    
    return $pdf->stream();
  }
  public function print_order_convert($checkout_code){
    $order_details = OrderDetails::where('order_code',$checkout_code)->get();
    $order = Order::where('order_code',$checkout_code)->get();
    foreach($order as $key => $ord){
      $customer_id = $ord->customer_id;
      $shipping_id = $ord->shipping_id;
    }
    $customer = Customer::where('customer_id',$customer_id)->first();
    $shipping = Shipping::where('shipping_id',$shipping_id)->first();

    $order_details_product = OrderDetails::with('product')->where('order_code', $checkout_code)->get();

    foreach($order_details_product as $key => $order_d){

      $product_coupon = $order_d->product_coupon;
    }
    if($product_coupon != 'no'){
      $coupon = Coupon::where('coupon_code',$product_coupon)->first();

      $coupon_condition = $coupon->coupon_condition;
      $coupon_number = $coupon->coupon_number;

      if($coupon_condition==1){
        $coupon_echo = $coupon_number.'%';
      }elseif($coupon_condition==2){
        $coupon_echo = number_format($coupon_number,0,',','.').'đ';
      }
    }else{
      $coupon_condition = 2;
      $coupon_number = 0;

      $coupon_echo = '0';

    }

    $output = '';

    $output.='<style>body{
      font-family: DejaVu Sans;
    }
    .table-styling{
      border:1px solid #000;
    }
    .table-styling tbody tr td{
      border:1px solid #000;
    }
    </style>
    <h1><centerCông ty TNHH một thành viên ABCD</center></h1>
    <h4><center>Độc lập - Tự do - Hạnh phúc</center></h4>
    <p>Người đặt hàng</p>
    <table class="table-styling">
    <thead>
    <tr>
    <th>Tên khách đặt</th>
    <th>Số điện thoại</th>
    <th>Email</th>
    </tr>
    </thead>
    <tbody>';

    $output.='    
    <tr>
    <td>'.$customer->customer_name.'</td>
    <td>'.$customer->customer_phone.'</td>
    <td>'.$customer->customer_email.'</td>

    </tr>';


    $output.='        
    </tbody>

    </table>

    <p>Ship hàng tới</p>
    <table class="table-styling">
    <thead>
    <tr>
    <th>Tên người nhận</th>
    <th>Địa chỉ</th>
    <th>Sdt</th>
    <th>Email</th>
    <th>Ghi chú</th>
    </tr>
    </thead>
    <tbody>';

    $output.='    
    <tr>
    <td>'.$shipping->shipping_name.'</td>
    <td>'.$shipping->shipping_address.'</td>
    <td>'.$shipping->shipping_phone.'</td>
    <td>'.$shipping->shipping_email.'</td>
    <td>'.$shipping->shipping_notes.'</td>

    </tr>';


    $output.='        
    </tbody>

    </table>

    <p>Đơn hàng đặt</p>
    <table class="table-styling">
    <thead>
    <tr>
    <th>Tên sản phẩm</th>
    <th>Mã giảm giá</th>
    <th>Phí ship</th>
    <th>Số lượng</th>
    <th>Giá sản phẩm</th>
    <th>Thành tiền</th>
    </tr>
    </thead>
    <tbody>';

    $total = 0;

    foreach($order_details_product as $key => $product){

      $subtotal = $product->product_price*$product->product_sales_quantity;
      $total+=$subtotal;

      if($product->product_coupon!='no'){
        $product_coupon = $product->product_coupon;
      }else{
        $product_coupon = 'không mã';
      }   

      $output.='    
      <tr>
      <td>'.$product->product_name.'</td>
      <td>'.$product_coupon.'</td>
      <td>'.number_format($product->product_feeship,0,',','.').'đ'.'</td>
      <td>'.$product->product_sales_quantity.'</td>
      <td>'.number_format($product->product_price,0,',','.').'đ'.'</td>
      <td>'.number_format($subtotal,0,',','.').'đ'.'</td>

      </tr>';
    }

    if($coupon_condition==1){
      $total_after_coupon = ($total*$coupon_number)/100;
      $total_coupon = $total - $total_after_coupon;
    }else{
      $total_coupon = $total - $coupon_number;
    }

    $output.= '<tr>
    <td colspan="2">
    <p>Tổng giảm: '.$coupon_echo.'</p>
    <p>Phí ship: '.number_format($product->product_feeship,0,',','.').'đ'.'</p>
    <p>Thanh toán : '.number_format($total_coupon + $product->product_feeship,0,',','.').'đ'.'</p>
    </td>
    </tr>';
    $output.='        
    </tbody>

    </table>

    <p>Ký tên</p>
    <table>
    <thead>
    <tr>
    <th width="200px">Người lập phiếu</th>
    <th width="800px">Người nhận</th>

    </tr>
    </thead>
    <tbody>';

    $output.='        
    </tbody>

    </table>

    ';


    return $output;

  }
    public function update_qty(Request $request){
      $data = $request->all();
      $order_details = OrderDetails::where('product_id',$data['order_product_id'])->where('order_code',$data['order_code'])->first();
      $order_details->product_sales_quantity = $data['order_qty'];
      $order_details->save();
    }
    public function update_order_qty(Request $request){
    //update order
    $data = $request->all();
    $order = Order::find($data['order_id']);
    $order->order_status = $data['order_status'];
    $order->save();
    //send mail confirm
    $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
    $title_mail = "Đơn hàng đã đặt được xác nhận".' '.$now;
    $customer = Customer::where('customer_id',$order->customer_id)->first();
    $data['email'][] = $customer->customer_email;

    
      //lay san pham
      
    foreach($data['order_product_id'] as $key => $product){
        $product_mail = Product::find($product);
        foreach($data['quantity'] as $key2 => $qty){

          if($key==$key2){

          $cart_array[] = array(
            'product_name' => $product_mail['product_name'],
            'product_price' => $product_mail['product_price'],
            'product_qty' => $qty
          );

        }
      }
    }

    
      //lay shipping
      $details = OrderDetails::where('order_code',$order->order_code)->first();

    $fee_ship = $details->product_feeship;
    $coupon_mail = $details->product_coupon;

      $shipping = Shipping::where('shipping_id',$order->shipping_id)->first();
      
    $shipping_array = array(
      'fee_ship' =>  $fee_ship,
      'customer_name' => $customer->customer_name,
      'shipping_name' => $shipping->shipping_name,
      'shipping_email' => $shipping->shipping_email,
      'shipping_phone' => $shipping->shipping_phone,
      'shipping_address' => $shipping->shipping_address,
      'shipping_notes' => $shipping->shipping_notes,
      'shipping_method' => $shipping->shipping_method

    );
 


  }
    public function login_checkout(){
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

    	
    	$cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
    	return view('client.pages.checkout.login_checkout')->with('category',$cate_product)->with('brand',$brand_product)->with('slider',$slider);

    }
    public function add_customer(Request $request){
    	$data = array();
    	$data['customer_name'] =$request->customer_name;
    	$data['customer_phone'] =$request->customer_phone;
    	$data['customer_email'] =$request->customer_email;
    	$data['customer_password'] =md5($request->customer_password);

    	$customer_id = DB::table('tbl_customers')->insertGetId($data);

    	Session::put('customer_id',$customer_id);
    	Session::put('customer_name',$request->customer_name);
    	return Redirect('/checkout');


    }
    public function calculate_fee(Request $request){
          $data = $request->all();
          if($data['matp']){
            $feeship = Feeship::where('fee_matp',$data['matp'])->where('fee_maqh',$data['maqh'])->where('fee_xaid',$data['xaid'])->get();
            if($feeship){
              $count_feeship = $feeship->count();
              if($count_feeship>0){
               foreach($feeship as $key => $fee){
                Session::put('fee',$fee->fee_feeship);
                Session::save();
              }
            }else{ 
              Session::put('fee',25000);
              Session::save();
            }
          }

        }
        }
    public function checkout(){
         $city = City::orderby('matp','ASC')->get();
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

    	$cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
    	return view('client.pages.checkout.show_checkout')->with('category',$cate_product)->with('brand',$brand_product)->with('city',$city)->with('slider',$slider);

    }
    public function save_checkout_customer(Request $request){
    	$data = array();
    	$data['shipping_name'] =$request->shipping_name;
    	$data['shipping_phone'] =$request->shipping_phone;
    	$data['shipping_email'] =$request->shipping_email;
    	$data['shipping_notes'] =$request->shipping_notes;
    	$data['shipping_address'] =$request->shipping_address;


    	$shipping_id = DB::table('tbl_shipping')->insertGetId($data);

    	Session::put('shipping_id',$shipping_id);
    	return Redirect('/payment');


    }
    public function payment(){

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
        return view('client.pages.checkout.payment')->with('category',$cate_product)->with('brand',$brand_product);


    }
    public function order_place(Request $request){
        //get payment method
        $data = array();
        $data['payment_method'] =$request->payment_option;
        $data['payment_status'] ='Đang chờ sử lí';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);
        //insert order
        $order_data = array();
        $order_data['customer_id'] =Session::get('customer_id');
        $order_data['shipping_id'] =Session::get('shipping_id');
        $order_data['payment_id'] =$payment_id;
        $order_data['order_total'] =Cart::subtotal();
        $order_data['order_status'] ='Đang chờ sử lí';
        $order_id = DB::table('tbl_order')->insertGetId($order_data);
         //insert order
         $content = Cart::content();
        foreach ($content as $v_content) {
        $order_d_data['order_id'] =$order_id;
        $order_d_data['product_id'] =$v_content->id;
        $order_d_data['product_name'] =$v_content->name;
        $order_d_data['product_price'] =$v_content->price;
        $order_d_data['product_sales_quantity'] =$v_content->qty;

         DB::table('tbl_order_details')->insert($order_d_data);
        }
        if($data['payment_method']==1){

            echo 'Thanh toán ATM';

        }elseif ($data['payment_method']==2) {

        Cart::destroy();
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
        return view('client.pages.checkout.handcash')->with('category',$cate_product)->with('brand',$brand_product);

        }else{
            echo 'Thẻ ghi nợ';
        }


        // return Redirect('/payment');

    }
    public function logout_checkout(){
    	Session::flush();
    	return Redirect('/login-checkout');
    }
    public function login_customer(Request $request){
    	$email = $request->email_account;
    	$password = md5($request->password_account);
    	$result = DB::table('tbl_customers')->where('customer_email',$email)->where('customer_password',$password)->first();
    	if($result){
    		Session::put('customer_id',$result->customer_id);
    		return Redirect('/checkout');
    	}else{
    	return Redirect('/login-checkout');
}

    }

    public function manage_order(){
    $getorder = Order::orderby('order_id','DESC')->paginate(5);
    return view('admin.manage_order')->with(compact('getorder'));
    }
    public function view_order($order_code){
         $this->AuthLogin(); 

        $order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
        $getorder = Order::where('order_code',$order_code)->get();
        foreach($getorder as $key => $ord){
          $customer_id = $ord->customer_id;
          $shipping_id = $ord->shipping_id;
          $order_status = $ord->order_status;
        }
        $customer = Customer::where('customer_id',$customer_id)->first();
        $shipping = Shipping::where('shipping_id',$shipping_id)->first();

        $order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();

        foreach($order_details_product as $key => $order_d){

          $product_coupon = $order_d->product_coupon;
        }
        if($product_coupon != 'no'){
          $coupon = Coupon::where('coupon_code',$product_coupon)->first();
          $coupon_condition = $coupon->coupon_condition;
          $coupon_number = $coupon->coupon_number;
        }else{
          $coupon_condition = 2;
          $coupon_number = 0;
        }
        
        return view('admin.view_order')->with(compact('order_details','customer','shipping','coupon_condition','coupon_number','getorder','order_status'));


    }
    public function confirm_order(Request $request){
   $data = $request->all();
    //get coupon
    if($data['order_coupon']!='no'){
     $coupon = Coupon::where('coupon_code',$data['order_coupon'])->first();
     $coupon->coupon_used = $coupon->coupon_used.','.Session::get('customer_id');
     $coupon->coupon_time = $coupon->coupon_time - 1;
     $coupon_mail = $coupon->coupon_code;
     $coupon->save();
    }else{
      $coupon_mail = 'không có sử dụng';
    }
   //get van chuyen
   $shipping = new Shipping();
   $shipping->shipping_name = $data['shipping_name'];
   $shipping->shipping_email = $data['shipping_email'];
   $shipping->shipping_phone = $data['shipping_phone'];
   $shipping->shipping_address = $data['shipping_address'];
   $shipping->shipping_notes = $data['shipping_notes'];
   $shipping->shipping_method = $data['shipping_method'];
   $shipping->save();
   $shipping_id = $shipping->shipping_id;

   $checkout_code = substr(md5(microtime()),rand(0,26),5);

    //get order
   $order = new Order;
   $order->customer_id = Session::get('customer_id');
   $order->shipping_id = $shipping_id;
   $order->order_status = 1;
   $order->order_code = $checkout_code;

   date_default_timezone_set('Asia/Ho_Chi_Minh');
         
   $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
   
   $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');;
   $order->created_at = $today;
   $order->order_date = $order_date;
   $order->save();
   

   if(Session::get('cart')==true){
    foreach(Session::get('cart') as $key => $cart){
      $order_details = new OrderDetails;
      $order_details->order_code = $checkout_code;
      $order_details->product_id = $cart['product_id'];
      $order_details->product_name = $cart['product_name'];
      $order_details->product_price = $cart['product_price'];
      $order_details->product_sales_quantity = $cart['product_qty'];
      $order_details->product_coupon =  $data['order_coupon'];
      $order_details->product_feeship = $data['order_fee'];
      $order_details->save();
    }
  }



  //send mail confirm
  $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');

  $title_mail = "Đơn hàng xác nhận ngày".' '.$now;

  $customer = Customer::find(Session::get('customer_id'));
      
  $data['email'][] = $customer->customer_email;
  //lay gio hang
  if(Session::get('cart')==true){

    foreach(Session::get('cart') as $key => $cart_mail){

      $cart_array[] = array(
        'product_name' => $cart_mail['product_name'],
        'product_price' => $cart_mail['product_price'],
        'product_qty' => $cart_mail['product_qty']
      );

    }

  }
  //lay shipping
  if(Session::get('fee')==true){
    $fee = Session::get('fee').'k';
  }else{
    $fee = '25k';
  }
  
  // $shipping_array = array(
  //   'fee' =>  $fee,
  //   'customer_name' => $customer->customer_name,
  //   'shipping_name' => $data['shipping_name'],
  //   'shipping_email' => $data['shipping_email'],
  //   'shipping_phone' => $data['shipping_phone'],
  //   'shipping_address' => $data['shipping_address'],
  //   'shipping_notes' => $data['shipping_notes'],
  //   'shipping_method' => $data['shipping_method']

  // );
  //lay ma giam gia, lay coupon code
  // $ordercode_mail = array(
  //   'coupon_code' => $coupon_mail,
  //   'order_code' => $checkout_code,
  // );

  // Mail::send('client.pages.mail.mail_order',  ['cart_array'=>$cart_array, 'shipping_array'=>$shipping_array ,'code'=>$ordercode_mail] , function($message) use ($title_mail,$data){
  //     $message->to($data['email'])->subject($title_mail);//send this mail with subject
  //     $message->from($data['email'],$title_mail);//send from this mail
  // });
  
  Session::forget('coupon');
  Session::forget('fee');
  Session::forget('cart');
}
public function delete_order($order_code){
  Order::where('order_code',$order_code)->delete();
  return redirect()->back();
}
public function delete_comment($id){
  Comment::find($id)->delete();
   return redirect()->back();
}
}