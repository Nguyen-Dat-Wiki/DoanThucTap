@extends('client.layouts.index')
@section('content')
    <style type="text/css">
        ul.contact {
    list-style: none;
    margin: 0;
    padding: 0;
    font-size: 20px;
}
p{
    font-size: 20px;
    color: red;
    text-transform: uppercase;
}
}
    </style>
      <!--features_items-->
                    <div class="features_items">
                        <h2 class="title text-center">Shop bán bán Giày Eva Store222</h2>
                        <p> Mọi thông tin chi tiết khách hàng có thể liên hệ thông tin bên dưới</p>
                        <ul class="contact">
                            <li>Số điện thoại : 0334613820 </li>
                            <li>Facebook : <a href="https://www.facebook.com/"><img width="32" height="32" src="{{asset('public/frontend/images/fb_icon.png')}}"></a></li>
                            <li>Zalo : <a href="https://chat.zalo.me/"><img width="32" height="32" src="{{asset('public/frontend/images/zalo_icon.jpg')}}"></a></li>
                        </ul>                 
                    </div>



@endsection