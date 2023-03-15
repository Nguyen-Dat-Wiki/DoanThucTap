@extends('client.layouts.index')
@section('content')

      <!--features_items-->
      <h2 class="title text-center">Kết quả tìm kiếm</h2>
                    <div class="features_items cards">
                        @foreach($search_product as $key => $product)
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
                                        <button type="button" class=" btn btn-default add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">Thêm giỏ hàng </button>
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

@endsection