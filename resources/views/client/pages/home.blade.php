@extends('client.layouts.index')

{{-- slider --}}
@section('slibar')
    <section id="slider">
        <!--slider-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#slider-carousel" data-slide-to="1"></li>
                            <li data-target="#slider-carousel" data-slide-to="2"></li>
                        </ol>

                        <style type="text/css">
                            img.img.img-responsive.img-slider {
                                height: 350px;
                            }
                        </style>
                        <div class="carousel-inner">
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($slider as $key => $slide)
                                @php
                                    $i++;
                                @endphp
                                <div class="item {{ $i == 1 ? 'active' : '' }}">

                                    <div class="col-sm-12">
                                        <img alt="{{ $slide->slider_desc }}"
                                            src="{{ asset('public/uploads/slider/' . $slide->slider_image) }}"
                                            height="200" width="100%" class="img img-responsive img-slider">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection


{{-- content --}}
@section('content')
      <!--features_items-->
    <div class="features_items">
        <h2 class="title text-center">Sản phẩm mới</h2>
        <div class="cards">
            @foreach($all_product as $key => $product)
                <div class="card ">
                    <form class="form_addcart" method="post"  >
                        @csrf
                        <div class="card-body">
                            <div class="card-img">
                                <a href="{{URL::to('/chi-tiet/'.$product->product_id)}}" ><img class="img-product" src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="..."></a>
                            </div>
                            <p class="card-user">
                                <span class="moneysale h2">{{number_format($product->product_price).' '.'đ'}}</span>
                            </p>
                            <p class="product_content">{{($product->product_name)}}</p>
                            <div class="button-submit d-flex justify-content-center">
                                <button type="button" class="btn btn-default add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">Thêm giỏ hàng </button>
                            </div>
                        </div>
                        <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                        <input type="hidden" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                        <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                        <input type="hidden" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                        <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">
                    </form>
                </div>
            @endforeach
        </div>                     
    </div>

@endsection