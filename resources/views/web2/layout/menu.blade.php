<div class="navbar-nav mr-auto py-0">
    <a href="{{route('web.home')}}" class="nav-item nav-link active">Home</a>
    <a href="{{route('web.shop')}}" class="nav-item nav-link">Shop</a>
    <a href="{{route('web.shop-detail')}}" class="nav-item nav-link">Shop Detail</a>

    <div class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
        <div class="dropdown-menu rounded-0 m-0">
            <a href="{{route('user.cart')}}" class="dropdown-item">Shopping Cart</a>
            <a href="{{route('user.checkout')}}" class="dropdown-item">Checkout</a>
        </div>

    </div>
    <a href="{{route('user.contact')}}" class="nav-item nav-link">Contact</a>
</div>