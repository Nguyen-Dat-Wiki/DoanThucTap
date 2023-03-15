    <header class="">
        <div class="header-middle">
            <!--header-middle-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="logo pull-left">
                            <a href="{{ url('/') }}"><img width="120"
                                    src="{{ asset('public/frontend/images/logo1.jpeg') }}" alt="" /></a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="shop-menu pull-right">
                            <ul class="nav navbar-nav">
                                {!! Session::get('customer_id') != null
                                    ? ' <li><a href=' .URL::to('/gio-hang') .'><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li> 
                                        <li><a href=' .URL::to('/logout-checkout') .'><i class="fa fa-lock"></i> Đăng xuất</a></li> 
                                        <li><a href=' .URL::to('/history') .'><i class="fa fa-bell"></i> Lịch sử đơn hàng</a></li> '
                                    : '
                                        <li><a href=' .URL::to('/gio-hang') .'><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li> 
                                        <li><a href=' .URL::to('/login-checkout') .'><i class="fa fa-lock"></i> Đăng nhập & Đăng kí</a></li> 
                                    ' 
                                !!}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/header-middle-->

        <div class="header-bottom">
            <!--header-bottom-->
            <div class="container ">
                <div class="row">
                    <div class="col-sm-7">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="mainmenu pull-left">
                            <ul class="nav navbar-nav collapse navbar-collapse">
                                <li><a href="{{ URL::to('/trang-chu') }}" class="active">Trang chủ</a></li>
                                <li class="dropdown"><a href="#">Sản phẩm<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        @foreach ($category as $key => $danhmuc)
                                            <li>
                                                <a href="{{ URL::to('/danh-muc/' . $danhmuc->category_id) }}">{{ $danhmuc->category_name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                <li><a href="{{ url('lien-he') }}">Liên hệ</a></li>
                                <li><a href="{{ url('chinh-sach') }}">Chính sách</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <form action="{{ URL::to('/tim-kiem') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="search_box pull-right">
                                <input type="text" name="keywords_submit" placeholder="Tìm kiếm" />
                                <input type="submit" style="margin-top: 0;color: #000" name="search_items"
                                    class="btn btn-primary btn-sm" value="Tìm kiếm">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/header-bottom-->
    </header>