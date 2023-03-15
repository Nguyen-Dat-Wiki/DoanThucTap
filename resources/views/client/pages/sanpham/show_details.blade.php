@extends('client.layouts.index')
@section('content')
@foreach($product_details as $key =>$value)
<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								<img src="{{URL::to('/public/uploads/product/'.$value->product_image)}}" alt="" />
								{{-- <h3>ZOOM</h3> --}}
							</div>
							<div id="similar-product" class="carousel slide" data-ride="carousel">
								
								  <!-- Wrapper for slides -->
								    <div class="carousel-inner">
										<div class="item active">
										  <a href=""><img src="" alt=""></a>
										  <a href=""><img src="" alt=""></a>
										  <a href=""><img src="" alt=""></a>
										</div>
									</div>

								  <!-- Controls -->
								  <a class="left item-control" href="#similar-product" data-slide="prev">
									
								  </a>
								  <a class="right item-control" href="#similar-product" data-slide="next">
									
								  </a>
							</div>

						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
								<img src="images/product-details/new.jpg" class="newarrival" alt="" />
								 
								<h2>{{$value->product_name}}</h2>
								<p> ID:{{$value->product_id}}</p>
								<img src="images/product-details/rating.png" alt="" />

								<form>
									 <input type="hidden" value="{{$value->product_id}}" class="cart_product_id_{{$value->product_id}}">
                                            <input type="hidden" value="{{$value->product_name}}" class="cart_product_name_{{$value->product_id}}">
                                            <input type="hidden" value="{{$value->product_image}}" class="cart_product_image_{{$value->product_id}}">
                                            <input type="hidden" value="{{$value->product_price}}" class="cart_product_price_{{$value->product_id}}">
                                            <input type="hidden" value="1" class="cart_product_qty_{{$value->product_id}}">

									{{csrf_field()}}
								<span>
									<span>{{number_format($value->product_price).'đ'}}</span>
									<label>Số lượng:</label>
									<input name="qty" type="number" min="1" value="1" />
									<input name="productid_hidden" type="hidden"  value="{{$value->product_id}}" />

									  <button type="button" class="btn btn-default add-to-cart" data-id_product="{{$value->product_id}}" name="add-to-cart">Thêm giỏ hàng </button>
								</span>

								</form>

								<p><b>Tình trạng:</b> còn hàng</p>
								<p><b>Điều kiện:</b> mới</p>
								<p><b>Thương hiệu:</b>{{$value->brand_name}} </p>
								<p><b>Danh mục:</b>{{$value->category_name}} </p>

								<a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->



						<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li  class="active"><a href="#details" data-toggle="tab">Mô tả</a></li>
								<li><a href="#companyprofile" data-toggle="tab">Chi tiết sản phẩm</a></li>
							
								<li class=""><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane active" id="details" >
								<p>{!!$value->product_desc!!}</p>
								
							</div>
							
							<div class="tab-pane fade" id="companyprofile" >
								<p>{!!$value->product_content!!}</p>
								
						
							</div>
							
							<div class="tab-pane fade  in" id="reviews" >
								<div class="col-sm-12">
									<ul>
										<li><a href=""><i class="fa fa-user"></i>Admin</a></li>
										<li><a href=""><i class="fa fa-clock-o"></i></a></li>
										<li><a href=""><i class="fa fa-calendar-o"></i></a></li>
									</ul>
									<style type="text/css">
										.style_comment {
										    border: 1px solid #ddd;
										    border-radius: 10px;
										    background: #F0F0E9;
										}
									</style>
									<form>
										 @csrf
										<input type="hidden" name="comment_product_id" class="comment_product_id" value="{{$value->product_id}}">
										 <div id="comment_show"></div>
									
									</form>
									
									<p><b>Viết đánh giá của bạn</b></p>

									 <!------Rating here---------->
										<ul class="list-inline rating"  title="Average Rating">
											@for($count=1; $count<=5; $count++)
												@php
													if($count<=$rating){
														$color = 'color:#ffcc00;';
													}
													else {
														$color = 'color:#ccc;';
													}
												
												@endphp
											
											<li title="star_rating" id="{{$value->product_id}}-{{$count}}" data-index="{{$count}}"  data-product_id="{{$value->product_id}}" data-rating="{{$rating}}" class="rating" style="cursor:pointer; {{$color}} font-size:30px;">&#9733;</li>
											@endfor

										</ul>
									<form action="#">
										<span>
											<input style="width:100%;margin-left: 0" type="text" class="comment_name" placeholder="Tên bình luận"/>
												
										</span>
										<textarea name="comment" class="comment_content" placeholder="Nội dung bình luận"></textarea>
										<div id="notify_comment"></div>
										
										<button type="button" class="btn btn-default pull-right send-comment">
											Gửi bình luận
										</button>

									</form>
								</div>
							</div>
							
						</div>
					</div><!--/category-tab-->
					@endforeach

{{-- 
										<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">recommended items</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<div class="item active">	
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img src="images/home/recommend1.jpg" alt="" />
													<h2>$56</h2>
													<p>Easy Polo Black Edition</p>
													<button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
												</div>
											</div>
										</div>
									</div>
									</div>
								
							
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items--> --}}
@endsection
					