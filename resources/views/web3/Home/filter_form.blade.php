<div class="container">
                <div class="row">
                    <div class="col-xl-3">
                        <div class="canvas-sidebar sidebar-filter canvas-filter left">
                            <div class="canvas-wrapper">
                                <div class="canvas-header d-flex d-xl-none">
                                    <span class="title">Filter</span>
                                    <span class="icon-close icon-close-popup close-filter"></span>
                                </div>
                                <div class="canvas-body">
                                    <div class="widget-facet">
                                        <div class="facet-title text-xl fw-medium" data-bs-target="#collections"
                                            data-bs-toggle="collapse" aria-expanded="true" aria-controls="collections">
                                            <span>Danh mục</span>
                                            <span class="icon icon-arrow-up"></span>
                                        </div>
                                        <div id="collections" class="collapse show">
                                            <ul class="collapse-body list-categories current-scrollbar">
                                                <li class="cate-item">
                                                    <a class="text-sm link" href="shop-default.html">
                                                        <span>Nước hoa nam</span>
                                                        <!-- <span class="count">(20)</span> -->
                                                    </a>
                                                </li>
                                                <li class="cate-item">
                                                    <a class="text-sm link" href="shop-default.html">
                                                        <span>Nước hoa nữ</span>
                                                        <!-- <span class="count">(20)</span> -->
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>

                                    <div class="widget-facet">
                                        <div class="facet-title text-xl fw-medium" data-bs-target="#price" role="button"
                                            data-bs-toggle="collapse" aria-expanded="true" aria-controls="price">
                                            <span>Giá</span>
                                            <span class="icon icon-arrow-up"></span>
                                        </div>
                                        <div id="price" class="collapse show">
                                            <div class="collapse-body widget-price filter-price">
                                                <span class="reset-price">Đặt lại</span>
                                                <div class="price-val-range" id="price-value-range" data-min="0"
                                                    data-max="500"></div>
                                                <div class="box-value-price">
                                                    <span class="text-sm">Giá:</span>
                                                    <div class="price-box">
                                                        <div class="price-val" id="price-min-value" data-currency="$">
                                                        </div>
                                                        <span>-</span>
                                                        <div class="price-val" id="price-max-value" data-currency="$">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="widget-facet">
                                        <div class="facet-title text-xl fw-medium" data-bs-target="#size" role="button"
                                            data-bs-toggle="collapse" aria-expanded="true" aria-controls="size">
                                            <span>ML</span>
                                            <span class="icon icon-arrow-up"></span>
                                        </div>
                                        <div id="size" class="collapse show">
                                            <div class="collapse-body filter-size-box flat-check-list">
                                                <div class="check-item size-item size-check"><span
                                                        <!-- class="size">5ml</span>&nbsp;<span class="count">(10)</span> -->
                                                </div>
                                                <div class="check-item size-item size-check"><span
                                                        <!-- class="size">10ml</span>&nbsp;<span class="count">(8)</span> -->
                                                </div>
                                                <div class="check-item size-item size-check"><span
                                                        <!-- class="size">20ml</span>&nbsp;<span class="count">(20)</span> -->
                                                </div>
                                                <div class="check-item size-item size-check"><span
                                                        <!-- class="size">30ml</span>&nbsp;<span class="count">(10)</span> -->
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-facet">
                                        <div class="facet-title text-xl fw-medium" data-bs-target="#brand" role="button"
                                            data-bs-toggle="collapse" aria-expanded="true" aria-controls="brand">
                                            <span>Thương hiệu</span>
                                            <span class="icon icon-arrow-up"></span>
                                        </div>
                                        <div id="brand" class="collapse show">
                                            <ul class="collapse-body filter-group-check current-scrollbar">
                                                <li class="list-item">
                                                    <input type="radio" name="brand" class="tf-check" id="Vineta">
                                                    <label for="Vineta" class="label"><span>Vineta</span>&nbsp;<span
                                                            <!-- class="count">(11)</span></label> -->
                                                </li>
                                                <li class="list-item">
                                                    <input type="radio" name="brand" class="tf-check" id="Zotac">
                                                    <label for="Zotac" class="label"><span>Zotac</span>&nbsp;<span
                                                            <!-- class="count">(20)</span></label> -->
                                                </li>
                                            </ul>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <div class="tf-shop-control">
                            <div class="tf-group-filter">
                                <button id="filterShop" class="tf-btn-filter d-flex d-xl-none">
                                    <span class="icon icon-filter"></span><span class="text">Filter</span>
                                </button>
                                <div class="tf-dropdown-sort" data-bs-toggle="dropdown">
                                    <div class="btn-select">
                                        <span class="text-sort-value">Bán chạy nhất</span>
                                        <span class="icon icon-arr-down"></span>
                                    </div>
                                    <div class="dropdown-menu">
                                        <div class="select-item active" data-sort-value="best-selling">
                                            <span class="text-value-item">Bán chạy nhất</span>
                                        </div>
                                        <div class="select-item" data-sort-value="a-z">
                                            <span class="text-value-item">A-Z</span>
                                        </div>
                                        <div class="select-item" data-sort-value="z-a">
                                            <span class="text-value-item">Z-A</span>
                                        </div>
                                        <div class="select-item" data-sort-value="price-low-high">
                                            <span class="text-value-item">Giá thấp đến cao</span>
                                        </div>
                                        <div class="select-item" data-sort-value="price-high-low">
                                            <span class="text-value-item">Giá cao xuống thấp</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="tf-control-layout">



                                <li class="tf-view-layout-switch sw-layout-4" data-value-layout="tf-col-4">
                                    <div class="item icon-grid-4">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <div class="wrapper-control-shop">
                            <div class="meta-filter-shop">
                                <div id="product-count-grid" class="count-text"></div>
                                <div id="product-count-list" class="count-text"></div>
                                <div id="applied-filters"></div>
                                <button id="remove-all" class="remove-all-filters" style="display: none;"><i
                                        class="icon icon-close"></i> Xóa tất cả bộ lọc</button>
                            </div>