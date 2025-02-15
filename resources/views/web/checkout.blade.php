@extends('web.layouts.master')
@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
                <li><a href="/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
                <li class="active">Checkout Page</li>
            </ol>
        </div>
    </div>
    @if (Auth::check())
        <div class="checkout" id="show">
            <form action="javascript:void(0)" id="form_check">
           
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <h3>Information of Customer</h3>

                            <div class="form-group">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name"
                                    required>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="id_user" id="id_user" value="{{ Auth::user()->id }}">
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email"
                                    required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="address" id="address" class="form-control"
                                    placeholder="Enter Address" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter Phone"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="checkout-right animated wow slideInUp" data-wow-delay=".5s">
                        <table class="timetable_sub">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Product</th>
                                    <th>Product Name</th>
                                    <th>Quality</th>
                                    <th>Price</th>
                                    <th>Amount Total</th>
                                </tr>
                            </thead>
                            @php
                                $total = 0;
                            @endphp

                            @if (isset($carts))
                                @foreach ($carts as $id => $cart)
                                    @php
                                        $total += $cart['quantity'] * $cart['price'];
                                    @endphp
                                    <tr class="rem1">
                                        <td class="invert">{{ $id }}</td>
                                        <td class="invert"><img src="cover/{{ $cart['image'] }}" width="40px"
                                                alt=""></td>
                                        <td class="invert">{{ $cart['name'] }}</td>
                                        <td class="invert">
                                            <div class="quantity">
                                                <input type="number" id="quantity_{{ $id }}"
                                                    onclick="cartQTY({{ $id }})"
                                                    value="{{ $cart['quantity'] }}">
                                            </div>
                                        </td>
                                        <td class="invert">{{ number_format($cart['price']) }}</td>
                                        <td class="invert">{{ number_format($cart['quantity'] * $cart['price']) }}
                                        </td>

                                    </tr>
                                @endforeach
                            @endif
                        </table>
                    </div>
                    <div class="checkout-left">
                        <div class="checkout-left-basket animated wow slideInLeft" data-wow-delay=".5s">

                            <h3>Total <i>:</i> <span>{{ number_format($total) }} VND</span></h3>
                            <div class="col-md-12">
                                <div id="paypal-button"></div>
                                
                            </div>
                            <br><br>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">Check Out</button>
                            </div>
                            
                        </div>
                       
                        <div class="clearfix"> </div>
                    </div>
                </div>
            </form>
        </div>
        <script>
            $(document).ready(function() {
                $('#form_check').submit(function(e) {
                    e.preventDefault();
                    var name = $("#name").val();
                    var email = $("#email").val();
                    var address = $("#address").val();
                    var id_user = $("#id_user").val();
                    var phone = $("#phone").val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ route('web.checkout.post') }}",
                        data: {
                            name: name,
                            email: email,
                            address: address,
                            id_user:id_user,
                            phone:phone
                        },
                        success: function(data) {
                            swal("Checkout Successfully !", "You clicked the button!", "success");
                            $('#form_check')[0].reset();
                        }
                    });
                });
            });
        </script>
    @else
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-body" style="text-align: center">
                        <h3>Please <a href="{{ route('web.login') }}?checkout=lolo">Login</a> to Checkout your products. Thank You !</h3>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
