@extends('client.layouts.index')

@section('content')
	<section id="cart_items ">
		<div class="container left col-sm-12">
			<div class="breadcrumbs">
				<ul class="breadcrumb" style="margin-bottom: 0">
				  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				  <li class="active">Giỏ hàng</li>
				</ul>
			</div>
			<div class="alert">
				{!!
					(session()->has('message')) ?
						"<div class='alert-success' >
							".session()->get('message')."
						</div>":
						"<div class='alert-danger'>
							".session()->get('error')."
						</div>"
				!!}
			</div>
			<div class="table-responsive cart_info ">
				<form action="{{url('/update-cart')}}" method="POST">
					@csrf
				<div class="table-responsive-sm table-responsive-lg">
					@if (Session::get('cart'))
					<table class="table table-condensed ">
						<thead class="thead-light">
							<tr class="cart_menu">
								<td  scope="col" class="text-center image">Hình ảnh</td>
								<td  scope="col" class="text-center description">Tên sản phẩm</td>
								<td  scope="col" class="text-center price">Giá</td>
								<td  scope="col" class="text-center quantity">Số lượng</td>
								<td  scope="col" class="text-center total">Tổng</td>
								<td></td>
							</tr>
						</thead>
						<tbody class="card-td ">
							@if(Session::get('cart'))
								@php
									$total = 0;
								@endphp
								@foreach(Session::get('cart') as $key => $cart)
									@php
										$subtotal = $cart['product_price']*$cart['product_qty'];
										$total+=$subtotal;
									@endphp
									<tr class="">
										<td class="cart_product">
											<a href="{{URL::to('/chi-tiet/'.$cart['product_id'])}}">
												<img src="{{asset('public/uploads/product/'.$cart['product_image'])}}" width="100px" height="50%" alt="{{$cart['product_name']}}" />
											</a>
										</td>
										<td class="cart_description col-sm-4">
											<p>{{$cart['product_name']}}</p>
										</td>
										<td class="cart_price">
											<p>{{number_format($cart['product_price'],0,',','.')}}đ</p>
										</td>
										<td class="cart_quantity">
											<div class="cart_quantity_button align-middle">
												<input style="width: 50%" class="cart_quantity" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}"  >
											</div>
										</td>
										<td class="cart_total">
											<p class="cart_total_price">
												<p>{{number_format($subtotal,0,',','.')}}đ</p>
											</p>
										</td>
										<td class="cart_delete text-center">
											<a class="cart_quantity_delete" href="{{url('/del-product/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
										</td>
									</tr>
								@endforeach
								<tr>
									<td>  <input type="submit" value="Cập nhật giỏ hàng" name="update_qty" class="check_out btn btn-default btn-sm"></td>
									<td>  <a class="btn btn-default check_out" href="{{url('/del-all-product')}}">Xóa tất cả</a></td>
									<td colspan="3">
										<li style="width: 250px;">
											Tổng Tiền <span>{{number_format($total,0,',','.')}}đ</span>
											@if(Session::get('coupon'))
												@foreach(Session::get('coupon') as $key => $cou)
													@if($cou['coupon_condition']==1)
														<li>Mã giảm : {{$cou['coupon_number']}} %</li>
														<p>
															@php
																$total_coupon = ($total*$cou['coupon_number'])/100;
																echo '<p><li>Tổng giảm:'.number_format($total_coupon,0,',','.').'đ</li></p>';
															@endphp
														</p>
														<p><li>Tổng đã giảm :{{number_format($total-$total_coupon,0,',','.')}}đ</li></p>
													@else
														<li>Mã giảm : {{number_format($cou['coupon_number'],0,',','.')}} đ</li>
														<p>
															@php
																$total_coupon = $total - $cou['coupon_number'];
															@endphp
														</p>
														<p><li>Tổng đã giảm :{{number_format($total_coupon,0,',','.')}}đ</li></p>
													@endif
												@endforeach
											@endif
										</li>
									</td>
									<td>
										@if(Session::get('customer_id'))
											<a class="btn btn-default check_out" href="{{url('/checkout')}}">Đặt hàng</a>
										@else
											<a class="btn btn-default check_out" href="{{url('/login-checkout')}}">Đặt hàng</a>
										@endif
									</td>
								</tr>
							@endif
						</tbody>
					</table>
					@else
						<h1 class="text-center">Thêm sản phẩm vô bạn nhé</h1>
					@endif
					
				</div>
				</form>
			</div>
		</div>
	</section> <!--/#cart_items-->


@endsection


