@extends('client.layouts.index')

@section('content')

      <!--features_items-->

    <div class="features_items">
        @foreach($category_name as $key => $name)
            <h2 class="title text-center">{{$name->category_name}}</h2>
        @endforeach
        <div class="row">
            @foreach($category_by_id as $key => $product)
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <form>
                                    <a href="{{URL::to('/chi-tiet/'.$product->product_id)}}">
                                        <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                                        <h2>{{number_format($product->product_price).' '.'đ'}}</h2>
                                        <p>{{($product->product_name)}}</p>
                                    </a>
                                    <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                                    <input type="hidden" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                                    <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                                    <input type="hidden" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                                    <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">
                                    @csrf
                                    <button type="button" class="btn btn-default add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">Thêm giỏ hàng </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>                       
    </div>
    <div class="d-flex justify-content-center" >
        <nav aria-label="Page navigation example">
            {{$category_by_id->appends(request()->query())->onEachSide(1)->links()}}
        </nav>
    </div>
@endsection