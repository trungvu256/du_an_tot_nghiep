@extends('admin.layouts.main')

@section('title', 'Danh Sách Đánh Giá Sản Phẩm')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-header mb-5">
                                <div class="card-title">Danh sách đánh giá sản phẩm</div>
                            </div>

                        </div>

                        <div class="card-body">
                            <form method="GET" action="{{ route('product-reviews.index') }}" class="mb-3">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" id="search" name="search"
                                            class="form-control form-control-sm" placeholder="Tìm kiếm đánh giá"
                                            value="{{ request()->search }}">
                                    </div>
                                    <div class="col-auto">
                                        <select class="form-select form-select-sm" name="response_status">
                                            <option value="">-- Trạng thái phản hồi --</option>
                                            <option value="replied" {{ $responseStatus == 'replied' ? 'selected' : '' }}>Đã phản hồi</option>
                                            <option value="not_replied" {{ $responseStatus == 'not_replied' ? 'selected' : '' }}>Chưa phản hồi</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                                    </div>
                                    <div class="col-auto">
                                        <a href="{{ route('product-reviews.index') }}" class="btn btn-sm btn-warning">Xóa lọc</a>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table v-middle m-0">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Người dùng</th>
                                            <th>Sản phẩm</th>
                                            <th>Biến thể</th>
                                            <th>Xếp hạng</th>
                                            <th>Đánh giá</th>
                                            
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productReviews as $index => $review)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $review->user->name ?? 'N/A' }}</td>
                                                <td>{{ $review->product->name ?? 'N/A' }}</td>
                                                <td>

                                                        @if ($review->variant)
                                                        <span class="badge bg-light text-dark">
                                                         <span style="font-size: larger; font-style: italic;">
                                                            @php
                                                                $attributes = $review->variant->product_variant_attributes ?? [];
                                                            @endphp
                                                            @if (count($attributes) > 0)
                                                                @foreach ($attributes as $attribute)
                                                                    <p class="text-muted mb-0">
                                                                        <strong>{{ $attribute->attribute->name }}:</strong>
                                                                        {{ $attribute->attributeValue->value }}
                                                                    </p>
                                                                @endforeach
                                                            @else
                                                                <p class="text-muted mb-0">Không có biến thể</p>
                                                            @endif
                                                        @else
                                                            <p class="text-muted mb-0">Không có biến thể</p>

                                                    </span>
                                                        </span>
                                                        @endif
                                                </td>
                                                <td>
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <i class="mdi mdi-star text-warning"></i>
                                                        @else
                                                            <i class="mdi mdi-star-outline text-muted"></i>
                                                        @endif
                                                    @endfor
                                                </td>
                                                <td>{{ $review->review }}</td>
                                                

                                                <td>
                                                    <a href="{{ route('product-reviews.show', $review->id) }}" class="btn btn-info btn-sm">Xem chi tiết</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Modal Sửa Phản Hồi -->
                            <div class="modal fade" id="editResponseModal" tabindex="-1" role="dialog"
                                aria-labelledby="editResponseModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content rounded-lg shadow-lg">
                                        <div class="modal-header border-b-2 p-4">
                                            <h5 class="modal-title" id="editResponseModalLabel">Sửa Phản Hồi</h5>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form id="editResponseForm" action="" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" id="editReplyId" name="reply_id">
                                                <div class="form-group">
                                                    <label for="editReply" class="font-medium">Nội dung phản hồi:</label>
                                                    <textarea class="form-control" id="editReply" name="response" rows="3" required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-4">Cập nhật</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Phản hồi-->
                            <div class="modal fade" id="responseModal" tabindex="-1" role="dialog"
                                aria-labelledby="responseModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content rounded-lg shadow-lg">
                                        <div class="modal-header border-b-2 p-4">
                                            <h5 class="modal-title text-lg font-semibold" id="responseModalLabel">Phản hồi
                                                đánh giá
                                            </h5>
                                            <button type="button" class="close rounded hover:bg-gray-200"
                                                data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form id="responseForm" action="" method="POST">
                                                @csrf
                                                <input type="hidden" id="reviewId" name="product_review_id">
                                                <div class="flex flex-col space-y-4">
                                                    <div class="form-group flex items-center">
                                                        <label for="user" class="mr-2 font-medium">Người dùng:</label>
                                                        <input type="text"
                                                            class="form-control flex-1 border-gray-300 rounded"
                                                            id="user" disabled>
                                                    </div>
                                                    <div class="form-group flex items-center">
                                                        <label for="content" class="mr-2 font-medium">Nội dung đánh giá:</label>
                                                        <input type="text"
                                                            class="form-control flex-1 border-gray-300 rounded"
                                                            id="content" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group mt-4">
                                                    <label for="response" class="font-medium">Phản hồi:</label>
                                                    <textarea class="form-control border-gray-300 rounded" id="response" name="response" rows="3"></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-4">Gửi phản hồi</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.all.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            $('#filterRemove').click(function() {
                $('#search').val('');
                $('select[name="response_status"]').val('');
                $(this).closest('form').submit();
            });
        });
        $(document).on('click', '.edit-response', function() {
            var responseId = $(this).data('id');
            var responseContent = $(this).data('response');
            $('#editReplyId').val(responseId);
            $('#editReply').val(responseContent);
            $('#editResponseForm').attr('action', 'product-reviews/' + responseId + '/update-response');
            $('#editResponseModal').modal('show');
        });
        $(document).on('click', '.btnModalResponse', function() {
            var reviewId = $(this).data('id');
            var userName = $(this).data('user');
            var content = $(this).data('content');
            $('#user').val(userName);
            $('#content').val(content);
            $('#reviewId').val(reviewId);
            $('#responseForm').attr('action', 'product-reviews/respond/' + reviewId);
        });
    </script>
    @include('alert')
@endsection
