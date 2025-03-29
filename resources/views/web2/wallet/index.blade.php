@extends('web2.layout.master')

@section('content')
<div class="container-fluid">
    <div class="row border-top px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                <h6 class="m-0">Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light"
                id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link" data-toggle="dropdown">Dresses <i
                                class="fa fa-angle-down float-right mt-1"></i></a>
                        <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
                            <a href="" class="dropdown-item">Men's Dresses</a>
                            <a href="" class="dropdown-item">Women's Dresses</a>
                            <a href="" class="dropdown-item">Baby's Dresses</a>
                        </div>
                    </div>
                    <a href="" class="nav-item nav-link">Shirts</a>
                    <a href="" class="nav-item nav-link">Jeans</a>
                    <a href="" class="nav-item nav-link">Swimwear</a>
                    <a href="" class="nav-item nav-link">Sleepwear</a>
                    <a href="" class="nav-item nav-link">Sportswear</a>
                    <a href="" class="nav-item nav-link">Jumpsuits</a>
                    <a href="" class="nav-item nav-link">Blazers</a>
                    <a href="" class="nav-item nav-link">Jackets</a>
                    <a href="" class="nav-item nav-link">Shoes</a>
                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span
                            class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    @include('web2.layout.menu')


                    <div class="navbar-nav ml-auto py-0">


                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->
<div class="container mt-4">
    <div class="card  p-4">
        <h2 class="mb-3 ">💰 Ví điện tử</h2>
        <p class="fs-5"><strong>Số dư:</strong> <span class=" fs-5">{{ number_format($wallet->balance ?? 0, 2) }} VND</span></p>
          <a href="{{route('wallet.croen')}}">Rút tiền</a>

        <div class="d-flex gap-3 mt-3">
            <a href="{{ route('wallet.history') }}" class="btn btn-primary btn-custom">
                📜 Xem lịch sử giao dịch
            </a>
            <a href="{{ route('wallet.vnpay') }}" class="btn btn-success btn-custom">
                💰 Nạp tiền
            </a>
        </div>
        
    </div>
</div>

<style>
    .btn-custom {
    padding: 12px 20px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 8px;
    transition: all 0.3s ease-in-out;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    width: 50%;
}

/* Hover Effect */
.btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: 2px 4px 15px rgba(0, 0, 0, 0.2);
}

</style>
@endsection
