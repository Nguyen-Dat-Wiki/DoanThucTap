<script src="{{ asset('public/frontend/js/jquery.js') }}"></script>
<script src="{{ asset('public/frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/frontend/js/main.js') }}"></script>
<script src="{{ asset('public/frontend/js/jquery.scrollUp.min.js') }}"></script>
<script src="{{ asset('public/frontend/js/price-range.js') }}"></script>
<script src="{{ asset('public/frontend/js/jquery.prettyPhoto.js') }}"></script>
<script src="{{ asset('public/frontend/js/sweetalert.min.js') }}"></script>



<script type="text/javascript">

    $(document).ready(function() {

        $('.add-to-cart').click(function() {

            var id = $(this).data('id_product');
            // alert(id);
            var cart_product_id = $('.cart_product_id_' + id).val();
            var cart_product_name = $('.cart_product_name_' + id).val();
            var cart_product_image = $('.cart_product_image_' + id).val();
            var cart_product_price = $('.cart_product_price_' + id).val();
            var cart_product_qty = $('.cart_product_qty_' + id).val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: '{{ url('/add-cart-ajax') }}',
                method: 'POST',
                data: {
                    cart_product_id: cart_product_id,
                    cart_product_name: cart_product_name,
                    cart_product_image: cart_product_image,
                    cart_product_price: cart_product_price,
                    cart_product_qty: cart_product_qty,
                    _token: _token
                },
                success: function() {

                    swal({
                            title: "Đã thêm sản phẩm vào giỏ hàng",
                            text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                            showCancelButton: true,
                            cancelButtonText: "Xem tiếp",
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "Đi đến giỏ hàng",
                            closeOnConfirm: false
                        },
                        function() {
                            window.location.href = "{{ url('/gio-hang') }}";
                        });

                }

            });



        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.calculate_delivery').click(function() {
            var matp = $('.city').val();
            var maqh = $('.province').val();
            var xaid = $('.wards').val();
            var _token = $('input[name="_token"]').val();
            if (matp == '' && maqh == '' && xaid == '') {
                alert('Làm ơn chọn để tính phí vận chuyển');
            } else {
                $.ajax({
                    url: '{{ url('/calculate-fee') }}',
                    method: 'POST',
                    data: {
                        matp: matp,
                        maqh: maqh,
                        xaid: xaid,
                        _token: _token
                    },
                    success: function() {
                        location.reload();
                    }
                });
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.choose').on('change', function() {
            var action = $(this).attr('id');
            var ma_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';

            if (action == 'city') {
                result = 'province';
            } else {
                result = 'wards';
            }
            $.ajax({
                url: '{{ url('/select-delivery-home') }}',
                method: 'POST',
                data: {
                    action: action,
                    ma_id: ma_id,
                    _token: _token
                },
                success: function(data) {
                    $('#' + result).html(data);
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.send_order').click(function() {
            var total_after = $('.total_after').val();
            swal({
                    title: "Xác nhận đơn hàng",
                    text: "Đơn hàng sẽ không được hoàn trả khi đặt,bạn có muốn đặt không?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Cảm ơn, Mua hàng",

                    cancelButtonText: "Đóng,chưa mua",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        var shipping_email = $('.shipping_email').val();
                        var shipping_name = $('.shipping_name').val();
                        var shipping_address = $('.shipping_address').val();
                        var shipping_phone = $('.shipping_phone').val();
                        var shipping_method = $('.payment_select').val();
                        var order_fee = $('.order_fee').val();
                        var order_coupon = $('.order_coupon').val();
                        var shipping_notes = $('.shipping_notes').val();
                        var _token = $('input[name="_token"]').val();

                        var arr_order = [];
                        if (shipping_notes == '') {
                            shipping_notes = 'Không có ghi chú'
                        }
                        var i = 0;
                        arr_order.push(shipping_email, shipping_name, shipping_address,
                            shipping_phone, shipping_method);
                        for (let index = 0; index < arr_order.length; index++) {
                            if (arr_order[index] == '') {
                                swal("Đơn hàng", "Đơn hàng của bạn bị thiếu thông tin");
                                window.setTimeout(function() {
                                    window.location.href = "{{ url('/checkout') }}";
                                }, 3000);
                                break;
                            }
                        }
                        $.ajax({
                            url: '{{ url('/confirm-order') }}',
                            method: 'POST',
                            data: {
                                shipping_email: shipping_email,
                                shipping_name: shipping_name,
                                shipping_address: shipping_address,
                                shipping_phone: shipping_phone,
                                shipping_notes: shipping_notes,
                                _token: _token,
                                order_fee: order_fee,
                                order_coupon: order_coupon,
                                shipping_method: shipping_method
                            },
                            success: function() {
                                swal("Đơn hàng",
                                    "Đơn hàng của bạn đã được gửi thành công",
                                    "success");
                            }
                        });
                        window.setTimeout(function() {
                            window.location.href = "{{ url('/history') }}";
                        }, 3000);

                    }
                });
        });
    });
</script>
<script type="text/javascript">
    function remove_background(product_id) {
        for (var count = 1; count <= 5; count++) {
            $('#' + product_id + '-' + count).css('color', '#ccc');
        }
    }
    //hover chuột đánh giá sao
    $(document).on('mouseenter', '.rating', function() {
        var index = $(this).data("index");
        var product_id = $(this).data('product_id');
        // alert(index);
        // alert(product_id);
        remove_background(product_id);
        for (var count = 1; count <= index; count++) {
            $('#' + product_id + '-' + count).css('color', '#ffcc00');
        }
    });


    //nhả chuột ko đánh giá
    $(document).on('mouseleave', '.rating', function() {
        var index = $(this).data("index");
        var product_id = $(this).data('product_id');
        var rating = $(this).data("rating");
        remove_background(product_id);
        //alert(rating);
        for (var count = 1; count <= rating; count++) {
            $('#' + product_id + '-' + count).css('color', '#ffcc00');
        }
    });

    //click đánh giá sao
    $(document).on('click', '.rating', function() {
        var index = $(this).data("index");
        var product_id = $(this).data('product_id');
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ url('insert-rating') }}",
            method: "POST",
            data: {
                index: index,
                product_id: product_id,
                _token: _token
            },
            success: function(data) {
                if (data == 'done') {
                    alert("Bạn đã đánh giá " + index + " trên 5");
                } else {
                    alert("Lỗi đánh giá");
                }
            }
        });

    });
</script>
<script type="text/javascript">
    $(document).ready(function() {

        load_comment();

        function load_comment() {
            var product_id = $('.comment_product_id').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ url('/load-comment') }}",
                method: "POST",
                data: {
                    product_id: product_id,
                    _token: _token
                },
                success: function(data) {

                    $('#comment_show').html(data);
                }
            });
        }
        $('.send-comment').click(function() {
            var product_id = $('.comment_product_id').val();
            var comment_name = $('.comment_name').val();
            var comment_content = $('.comment_content').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ url('/send-comment') }}",
                method: "POST",
                data: {
                    product_id: product_id,
                    comment_name: comment_name,
                    comment_content: comment_content,
                    _token: _token
                },
                success: function(data) {

                    $('#notify_comment').html(
                        '<span class="text text-success">Thêm bình luận thành công, bình luận đang chờ duyệt</span>'
                    );
                    load_comment();
                    $('#notify_comment').fadeOut(9000);
                    $('.comment_name').val('');
                    $('.comment_content').val('');
                }
            });
        });
    });
</script>
<script type="text/javascript">
    function Huydonhang(id) {
        var order_code = id;
        var lydo = $('.lydohuydon').val();

        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: '{{ url('/huy-don-hang') }}',
            method: "POST",

            data: {
                order_code: order_code,
                lydo: lydo,
                _token: _token
            },
            success: function(data) {
                alert('Hủy đơn hàng thành công');
                location.reload();
            }

        });
    }
</script>