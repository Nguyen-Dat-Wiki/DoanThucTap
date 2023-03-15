@extends('client.layouts.index')
@section('content')

      <!--features_items-->
                    <div class="features_items">
                          @foreach($brand_name as $key => $name)
                        <h2 class="title text-center">{{$name->brand_name}}</h2>
                        @endforeach
                       
                        @foreach($brand_by_id as $key => $product)
                        <a href="{{URL::to('/chi-tiet/'.$product->product_id)}}">
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                      <div class="productinfo text-center">
                                            <form>
                                                 @csrf
                                            <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                                            <input type="hidden" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                                            <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                                            <input type="hidden" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                                            <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">
                                                <a href="{{URL::to('/chi-tiet/'.$product->product_id)}}">                           
                                                <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                                                <h2>{{number_format($product->product_price).' '.'đ'}}</h2>
                                                <p>{{($product->product_name)}}</p>
                                                {{-- <a href="" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm</a> --}}
                                               </a>                        
                                            <button type="button" class="btn btn-default add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">Thêm giỏ hàng </button>
                                            </form>
                                            
                                      </div>
                                       
                                </div>
                               
                            </div>
                        </div>
                    </a>
                        @endforeach                        
                    </div>

@endsection