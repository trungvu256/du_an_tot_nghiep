<div class="header">
    <div class="container">
        <div class="header-grid">
            <div class="header-grid-left animated wow slideInLeft" data-wow-delay=".5s">

                <ul>
                    <li><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i><a href="">BestStore@gmail.com</a>
                    </li>
                    <li><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i>0326966504</li>
                    <li><i class="glyphicon glyphicon-log-in" aria-hidden="true"></i><a href="/login">Login</a></li>
                    <li><i class="glyphicon glyphicon-book" aria-hidden="true"></i><a href="/register">Register</a></li>
                </ul>

            </div>

            <div class="header-grid-right animated wow slideInRight" data-wow-delay=".5s">

                <ul class="social-icons">

                    <li><i class="fas fa-user">
                            @if (Auth::check())
                                {{ Auth::user()->name }}
                                <a href="/logout" class="btn btn-danger">Logout</a>
                            @else

                            @endif
                        </i></li>
                    <li><a href="#" class="facebook"></a></li>
                    <li><a href="#" class="twitter"></a></li>
                    <li><a href="#" class="g"></a></li>
                    <li><a href="#" class="instagram"></a></li>
                </ul>
            </div>
            <div class="clearfix"> </div>
        </div>
        <div class="logo-nav">
            <div class="logo-nav-left animated wow zoomIn" data-wow-delay=".5s">
                <h1><a href="/">Best Store <span>Shop anywhere</span></a></h1>
            </div>
            <div class="logo-nav-left1">
                <nav class="navbar navbar-default">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header nav_2">
                        <button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse"
                            data-target="#bs-megadropdown-tabs">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="/" class="act">Home</a></li>
                            <!-- Mega Menu -->
                            @foreach ($categories as $item)
                                <li class="dropdown">
                                    <a href="{{ route('web.category', $item->slug) }}" class="dropdown-toggle"
                                        data-toggle="dropdown">{{ $item->name }} <b class="caret"></b></a>
                                    <ul class="dropdown-menu multi-column columns-3">
                                        <div class="row">
                                            @foreach ($categories_2 as $item2)
                                                @if ($item2->parent_id == $item->id)
                                                    <div class="col-sm-4">
                                                        <ul class="multi-column-dropdown">
                                                            <h6><a
                                                                    href="{{ route('web.category', $item2->slug) }}">{{ $item2->name }}</a>
                                                            </h6>
                                                            @foreach ($categories_3 as $item3)
                                                                @if ($item3->parent_id == $item2->id)
                                                                    <li><a
                                                                            href="{{ route('web.category', $item3->slug) }}">{{ $item3->name }}</a>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            @endforeach

                                            <div class="clearfix"></div>
                                        </div>
                                    </ul>
                                </li>
                            @endforeach
                            @if (Auth::check())
                                <li><a href="/order">Order</a></li>
                            @endif

                            <li><a href="/blogWeb">Blogs</a></li>
                            <li><a href="/contact">Contact Us</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="logo-nav-right">
                <div class="search-box">
                    <div id="sb-search" class="sb-search">
                        <form>
                            <input class="sb-search-input" id="search" placeholder="Enter your search term..."
                                type="search" id="search">
                            <input class="sb-search-submit" type="submit" value="">
                            <span class="sb-icon-search"> </span>
                        </form>
                    </div>
                </div>
                <script>
                    $('#search').on('keyup', function() {
                        var key = $('#search').val();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "POST",
                            url: "search",
                            data: {
                                key: key
                            },
                            success: function(data) {
                                $("#load").html(data);
                            }
                        });
                    })

                </script>
                <!-- search-scripts -->
                <script src="template/web/js/classie.js"></script>
                <script src="template/web/js/uisearch.js"></script>
                <script>
                    new UISearch(document.getElementById('sb-search'));
                </script>
                <!-- //search-scripts -->
            </div>
            <div class="header-right">
                <div class="cart box_1">
                    <a href="{{ route('show_Cart') }}">
                        <h3>
                            <div class="total">
                                <span class=""></span> (<span id=""
                                    class=""></span>Cart)
                            </div>
                            <img src="template/web/images/bag.png" alt="" />
                        </h3>
                    </a>

                    <div class="clearfix"> </div>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
</div>
