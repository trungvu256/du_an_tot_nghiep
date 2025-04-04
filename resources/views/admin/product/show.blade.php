@extends('admin.layouts.main')
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="col-auto">
                <a href="{{ route('admin.product') }}" class="btn btn-primary"><i class="bi bi-arrow-return-left"></i>
                    Quay lại</a>
            </div>
            <div class="d-flex align-items-center justify-content-center flex-grow-1">
                <h4 style="color: #0ab39c">{{ $product->name }}</h4>
            </div>
        </div>

        <div class="card-body">
            <div class="row gx-lg-5">
                <div class="col-xl-4 col-md-8 mx-auto">
                    <div class="product-img-slider sticky-side-div">
                        <div class="swiper product-thumbnail-slider p-2 rounded bg-light">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt=""
                                        class="img-fluid d-block" />
                                </div>
                                @foreach ($description_images as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('storage/' . $image->image) }}" alt=""
                                            class="img-fluid d-block" />
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                        <!-- end swiper thumbnail slide -->
                        <div class="swiper product-nav-slider mt-2">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="nav-slide-item">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt=""
                                            class="img-fluid d-block" />
                                    </div>
                                </div>
                                @foreach ($description_images as $image)
                                    <div class="swiper-slide">
                                        <div class="nav-slide-item">
                                            <img src="{{ asset('storage/' . $image->image) }}" alt=""
                                                class="img-fluid d-block" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- end swiper nav slide -->
                    </div>
                </div>
                <!-- end col -->

                <div class="col-xl-8">
                    <div class="mt-xl-0 mt-5">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                {{-- <h4>{{ $product->name }}</h4> --}}
                                <div class="hstack gap-3 flex-wrap">
                                    <div class="vr"></div>
                                    <div class="text-muted">Thể loại : <span
                                            class="text-body fw-medium">{{ $product->catalogue->name }}</span></div>
                                    <div class="vr"></div>
                                    <div class="text-muted">Ngày đăng : <span
                                            class="text-body fw-medium">{{ $product->created_at->format('d-m-Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div>
                                    <a href="{{ route('admin.edit.product', $product->id) }}" class="btn btn-light"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Chỉnh sửa"><i
                                            class="ri-pencil-fill align-bottom"></i></a>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
                        <div class="text-muted fs-16">
                            <span class="mdi mdi-star text-warning"></span>
                            <span class="mdi mdi-star text-warning"></span>
                            <span class="mdi mdi-star text-warning"></span>
                            <span class="mdi mdi-star text-warning"></span>
                            <span class="mdi mdi-star text-warning"></span>
                        </div>
                        <div class="text-muted">( 5.50k Customer Review )</div>
                    </div> --}}

                    <div class="row mt-3">
                        @foreach ($product->variants as $variant)
                            <div class="col-md-4">
                                <div class="card border shadow-sm">
                                    <div class="card-body">
                                        {{-- Giá bán --}}
                                        <p style="font-size: 1rem">
                                            <i class="ri-money-dollar-circle-fill"></i> Giá bán:
                                            <strong>
                                                <br><del style="color: red">
                                                    {{ number_format($variant->price > 0 ? $variant->price : 0, 0, ',', '.') }} VNĐ
                                                </del>
                                                <br><span style="color: #0ab39c">
                                                    {{ number_format($variant->price_sale > 0 ? $variant->price_sale : $variant->price, 0, ',', '.') }} VNĐ
                                                </span>
                                            </strong>
                                        </p>
                    
                                        {{-- Danh sách thuộc tính --}}
                                        @if ($variant->product_variant_attributes && count($variant->product_variant_attributes) > 0)
                                            @foreach ($variant->product_variant_attributes as $attr)
                                                <br>
                                                <span style="font-size: 1rem">{{ $attr->attribute->name ?? 'Thuộc tính' }}</span>:
                                                <strong>{{ $attr->attributeValue->value ?? 'Không có giá trị' }}</strong>
                                            @endforeach
                                        @else
                                            <p class="text-muted">Không có thuộc tính.</p>
                                        @endif
                    
                                        {{-- Số lượng --}}
                                        <p style="font-size: 1rem">
                                            Số lượng:
                                            <strong>{{ $variant->stock_quantity }}</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                        <!-- end row -->


                        {{-- <div class="row">
                        <div class="col-sm-6">
                            <div class="mt-3">
                                <h5 class="fs-14">Features :</h5>
                                <ul class="list-unstyled">
                                    <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Full Sleeve</li>
                                    <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Cotton</li>
                                    <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> All Sizes available</li>
                                    <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> 4 Different Color</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mt-3">
                                <h5 class="fs-14">Services :</h5>
                                <ul class="list-unstyled product-desc-list">
                                    <li class="py-1">10 Days Replacement</li>
                                    <li class="py-1">Cash on Delivery available</li>
                                </ul>
                            </div>
                        </div>
                    </div> --}}


                        <div class="product-content mt-5">
                            {{-- <h5 class="fs-14 mb-3">Thông tin sản phẩm :</h5> --}}
                            <nav>
                                <ul class="nav nav-tabs nav-tabs-custom nav-success" id="nav-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="nav-speci-tab" data-bs-toggle="tab" href="#nav-speci"
                                            role="tab" aria-controls="nav-speci" aria-selected="true">Thông số sản
                                            phẩm</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab" href="#nav-detail"
                                            role="tab" aria-controls="nav-detail" aria-selected="false">Thông tin chi
                                            tiết</a>
                                    </li>
                                </ul>
                            </nav>
                            <div class="tab-content border border-top-0 p-4" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-speci" role="tabpanel"
                                    aria-labelledby="nav-speci-tab">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <tbody>
                                                <tr>
                                                    <th scope="row" style="width: 200px;">Giới tính</th>
                                                    <td>{{ $product->gender }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Thương hiệu</th>
                                                    <td>{{ $product->brand->name ?? 'Không có thương hiệu' }}</td>
                                                </tr>
                                                {{-- <tr>
                                                <th scope="row">Longevity</th>
                                                <td>{{$product->longevity}}</td>
                                            </tr> --}}
                                                <tr>
                                                    <th scope="row">Nồng độ</th>
                                                    <td>{{ $product->concentration }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Xuất xứ</th>
                                                    <td>{{ $product->origin }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Phong cách</th>
                                                    <td>{{ $product->style }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Nhóm hương</th>
                                                    <td>{{ $product->fragrance_group }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Số lượng</th>
                                                    <td>{{ $product->stock_quantity }}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-detail" role="tabpanel" aria-labelledby="nav-detail-tab">
                                    <div>
                                        <p>{!! $product->description !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- product-content -->

                        <div class="mt-5">
                            <div>
                                <h5 class="fs-14 mb-3">Bình luận & đánh giá</h5>
                            </div>
                            <div class="row gy-4 gx-0">
                                <div class="col-lg-4">
                                  
                                </div>
                                <!-- end col -->

                                <div class="col-lg-12">
                                    <div class="ps-lg-4">
                                        <div class="d-flex flex-wrap align-items-start gap-3">
                                            <h5 class="fs-14">Bình luận: </h5>
                                        </div>

                                        <div class="list-group">
                                            @forelse($product->comments as $comment)
                                                <div class="list-group-item">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6>{{ $comment->user->name ?? 'Ẩn danh' }} -
                                                            <small>{{ optional($comment->created_at)->format('d M, Y') }}</small>
                                                        </h6>
                                                        <span class="badge bg-success"><i class="mdi mdi-star"></i>
                                                            {{ $comment->rating }}</span>
                                                    </div>
                                                    <p class="mb-1">{{ $comment->content }}</p>
                                                </div>
                                            @empty
                                                <p class="text-muted">Chưa có bình luận nào.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end Ratings & Reviews -->
                        </div>
                        <!-- end card body -->
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end card body -->
    </div>
@endsection
