@extends('web.layouts.master')
@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <ol class="breadcrumb breadcrumb1 animated wow slideInLeft">
                <li><a href="index.html"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
                <li class="active">Cart Page</li>
            </ol>
        </div>
    </div>
    <div class="checkout" id="show">
        <div class="container" id="show2">

            <div class="checkout-right animated wow slideInUp" >
                <table class="timetable_sub">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Product</th>
                            <th>Product Name</th>
                            <th>Quality</th>
                            <th>Price</th>
                            <th>Amount Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    @php
                        $total = 0;
                        $stt=0;
                    @endphp
                   
                        @if (isset($carts))
                        @foreach ($carts as $id => $cart)
                        @php
                            $total += $cart['quantity'] * $cart['price'];
                            $stt++
                        @endphp
                        <tr class="rem1">
                            <td class="invert">{{ $stt }}</td>
                            <td class="invert"><img src="cover/{{ $cart['image'] }}" width="40px" alt=""></td>
                            <td class="invert">{{ $cart['name'] }}</td>
                            <td class="invert">
                                <div class="quantity">
                                    <input type="number" id="quantity_{{ $id }}"
                                        onclick="cartQTY({{ $id }})" value="{{ $cart['quantity'] }}">
                                </div>
                            </td>
                            <td class="invert">{{ number_format($cart['price']) }}</td>
                            <td class="invert">{{ number_format($cart['quantity'] * $cart['price']) }}</td>
                            <td class="invert"><a href="javascript:void(0)"
                            onclick="deleteCart({{ $id }})" class="btn btn-danger">X</a></td>

                        </tr>
                    @endforeach
                        @endif
                </table>
            </div>
            <div class="checkout-left">
                <div class="checkout-left-basket animated wow slideInLeft" data-wow-delay=".5s">
                    <a href="/checkout"><h4>Go To Checkout</h4></a>
                     <h3>Total <i>:</i> <span>{{ number_format($total) }} VND</span></h3>
                </div>
                <div class="checkout-right-basket animated wow slideInRight" data-wow-delay=".5s">
                    <a href="/"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Continue
                        Shopping</a>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
    <script>
        function deleteCart(id) {
            swal({
                    title: "Are you sure?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{ route('delete_cart') }}",
                            type: "GET",
                            data: {
                                id: id,
                            },
                            success: function(data) {
                                $("#show").load("showCart #show2");
                                swal(" Your product  has been deleted!", {
                                    icon: "success",
                                });
                            }
                        })
                    } else {
                        swal("Your product file is safe!");
                    }
                });
        }
    </script>
    <script>
        function cartQTY(id) {
            var num = $('#quantity_' + id).val();
            $.ajax({
                type:"GET",
                url: "{{ route('update_cart') }}",
                data:{id:id,num:num},
                success:function(data){
                    $("#show").load("showCart #show2");
                }
            });
        }
    </script>
@endsection
