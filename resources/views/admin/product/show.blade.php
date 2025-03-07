@extends('admin.main')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row gx-lg-5">
            <div class="col-xl-4 col-md-8 mx-auto">
                <div class="product-img-slider sticky-side-div">
                    <div class="swiper product-thumbnail-slider p-2 rounded bg-light">
                        <div class="swiper-wrapper">
                            @foreach ($description_images as $image)   
                            <div class="swiper-slide">
                                <img src="{{asset('storage/'.$image->image)}}" alt="" class="img-fluid d-block" />
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                    <!-- end swiper thumbnail slide -->
                    <div class="swiper product-nav-slider mt-2">
                        <div class="swiper-wrapper">
                            @foreach ($description_images as $image)
                                
                            <div class="swiper-slide">
                                <div class="nav-slide-item">
                                    <img src="{{asset('storage/'.$image->image)}}" alt="" class="img-fluid d-block" />
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
                            <h4>{{$product->name}}</h4>
                            <div class="hstack gap-3 flex-wrap">
                                <div class="vr"></div>
                                <div class="text-muted">Thể loại : <span class="text-body fw-medium">{{ $product->category->name }}</span></div>
                                <div class="vr"></div>
                                <div class="text-muted">Ngày đăng : <span class="text-body fw-medium">{{ $product->created_at }}</span></div>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <div>
                                <a href="apps-ecommerce-add-product.html" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="ri-pencil-fill align-bottom"></i></a>
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

                    <div class="row mt-4">
                        <div class="col-lg-3 col-sm-6">
                            <div class="p-2 border border-dashed rounded">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title rounded bg-transparent text-success fs-24">
                                            <i class="ri-money-dollar-circle-fill"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-1">Giá :</p>
                                        <h5 class="mb-0">{{$product->price}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="mt-4">
                                <h5 class="fs-14">Sizes :</h5>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($variants as $variant)
                                    <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock">
                                        <input type="radio" class="btn-check" name="productsize-radio" id="productsize-radio1" disabled>
                                        <label class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center" for="productsize-radio1">{{$variant->name}}</label>
                                    </div>    
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- end col -->

                        
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="mt-4 text-muted">
                        <h5 class="fs-14">Description :</h5>
                        <p>{{$product->description}}</p>
                    </div>

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
                        <h5 class="fs-14 mb-3">Product Specifications :</h5>
                        <nav>
                            <ul class="nav nav-tabs nav-tabs-custom nav-success" id="nav-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="nav-speci-tab" data-bs-toggle="tab" href="#nav-speci" role="tab" aria-controls="nav-speci" aria-selected="true">Specification</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab" href="#nav-detail" role="tab" aria-controls="nav-detail" aria-selected="false">Details</a>
                                </li>
                            </ul>
                        </nav>
                        <div class="tab-content border border-top-0 p-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-speci" role="tabpanel" aria-labelledby="nav-speci-tab">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row" style="width: 200px;">Gender</th>
                                                <td>{{$product->gender}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Brand</th>
                                                <td>{{$product->brand}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Longevity</th>
                                                <td>{{$product->longevity}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Concentration</th>
                                                <td>{{$product->concentration}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Origin</th>
                                                <td>{{$product->origin}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Style</th>
                                                <td>{{$product->style}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Frangrance group</th>
                                                <td>{{$product->fragrance_group}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Stock quantity</th>
                                                <td>{{$product->stock_quantity}}</td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-detail" role="tabpanel" aria-labelledby="nav-detail-tab">
                                <div>
                                    <h5 class="font-size-16 mb-3">Tommy Hilfiger Sweatshirt for Men (Pink)</h5>
                                    <p>Tommy Hilfiger men striped pink sweatshirt. Crafted with cotton. Material composition is 100% organic cotton. This is one of the world’s leading designer lifestyle brands and is internationally recognized for celebrating the essence of classic American cool style, featuring preppy with a twist designs.</p>
                                    <div>
                                        <p class="mb-2"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Machine Wash</p>
                                        <p class="mb-2"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Fit Type: Regular</p>
                                        <p class="mb-2"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> 100% Cotton</p>
                                        <p class="mb-0"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Long sleeve</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product-content -->

                    <div class="mt-5">
                        <div>
                            <h5 class="fs-14 mb-3">Ratings & Reviews</h5>
                        </div>
                        <div class="row gy-4 gx-0">
                            <div class="col-lg-4">
                                {{-- <div>
                                    <div class="pb-3">
                                        <div class="bg-light px-3 py-2 rounded-2 mb-2">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <div class="fs-16 align-middle text-warning">
                                                        <i class="ri-star-fill"></i>
                                                        <i class="ri-star-fill"></i>
                                                        <i class="ri-star-fill"></i>
                                                        <i class="ri-star-fill"></i>
                                                        <i class="ri-star-half-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <h6 class="mb-0">4.5 out of 5</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-muted">Total <span class="fw-medium">5.50k</span> reviews
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <div class="row align-items-center g-2">
                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0">5 star</h6>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-2">
                                                    <div class="progress animated-progress progress-sm">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 50.16%" aria-valuenow="50.16" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0 text-muted">2758</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->

                                        <div class="row align-items-center g-2">
                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0">4 star</h6>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-2">
                                                    <div class="progress animated-progress progress-sm">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 19.32%" aria-valuenow="19.32" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0 text-muted">1063</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->

                                        <div class="row align-items-center g-2">
                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0">3 star</h6>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-2">
                                                    <div class="progress animated-progress progress-sm">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 18.12%" aria-valuenow="18.12" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0 text-muted">997</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->

                                        <div class="row align-items-center g-2">
                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0">2 star</h6>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-2">
                                                    <div class="progress animated-progress progress-sm">
                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 7.42%" aria-valuenow="7.42" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0 text-muted">408</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->

                                        <div class="row align-items-center g-2">
                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0">1 star</h6>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-2">
                                                    <div class="progress animated-progress progress-sm">
                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 4.98%" aria-valuenow="4.98" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="p-2">
                                                    <h6 class="mb-0 text-muted">274</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->
                                    </div>
                                </div> --}}
                            </div>
                            <!-- end col -->

                            <div class="col-lg-12">
                                <div class="ps-lg-4">
                                    <div class="d-flex flex-wrap align-items-start gap-3">
                                        <h5 class="fs-14">Reviews: </h5>
                                    </div>

                                    <div class="me-lg-n3 pe-lg-4" data-simplebar style="max-height: 225px;">
                                        <ul class="list-unstyled mb-0">
                                            <li class="py-2">
                                                <div class="border border-dashed rounded p-3">
                                                    <div class="d-flex align-items-start mb-3">
                                                        <div class="hstack gap-3">
                                                            <div class="badge rounded-pill bg-success mb-0">
                                                                <i class="mdi mdi-star"></i> 4.2
                                                            </div>
                                                            <div class="vr"></div>
                                                            <div class="flex-grow-1">
                                                                <p class="text-muted mb-0"> Superb sweatshirt. I loved it. It is for winter.</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-grow-1 gap-2 mb-3">
                                                        <a href="#" class="d-block">
                                                            <img src="assets/images/small/img-12.jpg" alt="" class="avatar-sm rounded object-fit-cover">
                                                        </a>
                                                        <a href="#" class="d-block">
                                                            <img src="assets/images/small/img-11.jpg" alt="" class="avatar-sm rounded object-fit-cover">
                                                        </a>
                                                        <a href="#" class="d-block">
                                                            <img src="assets/images/small/img-10.jpg" alt="" class="avatar-sm rounded object-fit-cover">
                                                        </a>
                                                    </div>

                                                    <div class="d-flex align-items-end">
                                                        <div class="flex-grow-1">
                                                            <h5 class="fs-14 mb-0">Henry</h5>
                                                        </div>

                                                        <div class="flex-shrink-0">
                                                            <p class="text-muted fs-13 mb-0">12 Jul, 21</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="py-2">
                                                <div class="border border-dashed rounded p-3">
                                                    <div class="d-flex align-items-start mb-3">
                                                        <div class="hstack gap-3">
                                                            <div class="badge rounded-pill bg-success mb-0">
                                                                <i class="mdi mdi-star"></i> 4.0
                                                            </div>
                                                            <div class="vr"></div>
                                                            <div class="flex-grow-1">
                                                                <p class="text-muted mb-0"> Great at this price, Product quality and look is awesome.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end">
                                                        <div class="flex-grow-1">
                                                            <h5 class="fs-14 mb-0">Nancy</h5>
                                                        </div>

                                                        <div class="flex-shrink-0">
                                                            <p class="text-muted fs-13 mb-0">06 Jul, 21</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="py-2">
                                                <div class="border border-dashed rounded p-3">
                                                    <div class="d-flex align-items-start mb-3">
                                                        <div class="hstack gap-3">
                                                            <div class="badge rounded-pill bg-success mb-0">
                                                                <i class="mdi mdi-star"></i> 4.2
                                                            </div>
                                                            <div class="vr"></div>
                                                            <div class="flex-grow-1">
                                                                <p class="text-muted mb-0">Good product. I am so happy.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end">
                                                        <div class="flex-grow-1">
                                                            <h5 class="fs-14 mb-0">Joseph</h5>
                                                        </div>

                                                        <div class="flex-shrink-0">
                                                            <p class="text-muted fs-13 mb-0">06 Jul, 21</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="py-2">
                                                <div class="border border-dashed rounded p-3">
                                                    <div class="d-flex align-items-start mb-3">
                                                        <div class="hstack gap-3">
                                                            <div class="badge rounded-pill bg-success mb-0">
                                                                <i class="mdi mdi-star"></i> 4.1
                                                            </div>
                                                            <div class="vr"></div>
                                                            <div class="flex-grow-1">
                                                                <p class="text-muted mb-0">Nice Product, Good Quality.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end">
                                                        <div class="flex-grow-1">
                                                            <h5 class="fs-14 mb-0">Jimmy</h5>
                                                        </div>

                                                        <div class="flex-shrink-0">
                                                            <p class="text-muted fs-13 mb-0">24 Jun, 21</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                        </ul>
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
