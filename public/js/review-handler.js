/**
 * Review Handler - Xử lý chức năng đánh giá sản phẩm
 * Được thiết kế để tối ưu hiệu suất và giảm số lượng request API
 */

document.addEventListener('DOMContentLoaded', function() {
    const submittingForms = new Set();
    let swalInstance = null; // Biến để theo dõi instance của Swal
    // Cache để lưu trữ dữ liệu đánh giá
    const reviewCache = {};

    // Kiểm tra xem đã có review trong cache chưa
    function getCachedReview(productId, variantId, orderId) {
        const cacheKey = `${productId}_${variantId}_${orderId}`;
        return reviewCache[cacheKey];
    }

    // Lưu review vào cache
    function cacheReview(productId, variantId, orderId, review) {
        const cacheKey = `${productId}_${variantId}_${orderId}`;
        reviewCache[cacheKey] = review;
    }

    // Hàm debounce để hạn chế số lần gọi hàm
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Lấy dữ liệu đánh giá từ API, có cache
    async function fetchReview(productId, variantId, orderId) {
        const cachedReview = getCachedReview(productId, variantId, orderId);
        if (cachedReview) {
            return cachedReview;
        }

        try {
            const response = await fetch(`/products/${productId}/get-review?variant_id=${variantId}&order_id=${orderId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            if (!response.ok) {
                throw new Error('Không thể lấy thông tin đánh giá');
            }
            
            const data = await response.json();
            if (data.review) {
                cacheReview(productId, variantId, orderId, data.review);
                return data.review;
            }
            return null;
        } catch (error) {
            console.error('Error fetching review:', error);
            return null;
        }
    }

    // Kiểm tra trạng thái đánh giá khi trang load - chỉ kiểm tra các form hiện đang hiển thị
    async function checkReviewStatus() {
        // Lấy tất cả các nút "Xem đánh giá" đã visible trên trang
        const viewButtons = Array.from(document.querySelectorAll('button[data-bs-target^="#viewOrderReviewModal"]')).filter(
            btn => btn.offsetParent !== null // Chỉ lấy các button đang hiển thị
        );
        
        // Nếu có quá nhiều nút, chỉ xử lý những nút đầu tiên hiển thị trong viewport
        const visibleButtons = viewButtons.slice(0, 3);
        
        // Xử lý tuần tự thay vì đồng thời
        for (const button of visibleButtons) {
            const orderId = button.getAttribute('data-bs-target').replace('#viewOrderReviewModal', '');
            await updateReviewButtonStatus(orderId);
        }
    }

    // Hàm cập nhật trạng thái nút đánh giá
    async function updateReviewButtonStatus(orderId) {
        // Kiểm tra review chỉ cho đơn hàng và sản phẩm hiện tại
        const reviewButton = document.querySelector(`button[data-bs-target="#reviewOrderModal${orderId}"]`);
        const viewReviewButton = document.querySelector(`button[data-bs-target="#viewOrderReviewModal${orderId}"]`);
        
        // Nếu không có nút đánh giá hoặc đã có nút xem đánh giá, không cần kiểm tra
        if (!reviewButton && viewReviewButton) return;
        
        const reviewModal = document.getElementById(`reviewOrderModal${orderId}`);
        if (!reviewModal) return;
        
        const productIdInput = reviewModal.querySelector('input[name="product_id"]');
        const variantIdInput = reviewModal.querySelector('input[name="variant_id"]');
        
        if (!productIdInput || !variantIdInput) return;
        
        const productId = productIdInput.value;
        const variantId = variantIdInput.value;
        
        // Kiểm tra đã có đánh giá hay chưa
        try {
            const review = await fetchReview(productId, variantId, orderId);
            if (review && review.id) {
                updateReviewButton(orderId, review);
            }
        } catch (error) {
            console.error('Error checking review status:', error);
        }
    }

    // Hàm cập nhật UI sau khi đánh giá (tránh reload trang)
    async function updateReviewUI(productId, variantId, orderId) {
        try {
            const review = await fetchReview(productId, variantId, orderId);
            if (review && review.id) {
                updateReviewButton(orderId, review);
            }
        } catch (error) {
            console.error('Error updating review UI:', error);
        }
    }

    // Xử lý submit form đánh giá
    document.querySelectorAll('.order-review-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formId = this.closest('.modal').id;
            if (submittingForms.has(formId)) {
                return;
            }

            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submittingForms.add(formId);

            try {
                const formData = new FormData(this);
                const productId = formData.get('product_id');
                const variantId = formData.get('variant_id');
                const orderId = this.closest('.modal').id.replace('reviewOrderModal', '');
                formData.append('order_id', orderId);

                if (!formData.get('rating')) {
                    await showErrorMessage('Vui lòng chọn số sao đánh giá');
                    submitButton.disabled = false;
                    submittingForms.delete(formId);
                    return;
                }

                if (!formData.get('review')) {
                    await showErrorMessage('Vui lòng nhập nội dung đánh giá');
                    submitButton.disabled = false;
                    submittingForms.delete(formId);
                    return;
                }

                const response = await fetch(`/products/${productId}/reviews`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Có lỗi xảy ra khi thêm đánh giá');
                }

                // Đóng modal đánh giá
                const modal = bootstrap.Modal.getInstance(document.getElementById(`reviewOrderModal${orderId}`));
                if (modal) {
                    modal.hide();
                }

                // Cập nhật UI và hiển thị thông báo thành công
                await updateReviewUI(productId, variantId, orderId);
                
                // Đảm bảo chỉ hiển thị một thông báo tại một thời điểm
                if (swalInstance) {
                    swalInstance.close();
                }
                
                // Hiển thị thông báo thành công và sau đó reload trang
                swalInstance = await Swal.fire({
                    title: 'Thành công!',
                    text: 'Cảm ơn bạn đã đánh giá sản phẩm',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#0d6efd',
                    allowOutsideClick: false
                });
                
                // Reload trang sau khi thông báo được đóng
                window.location.reload();

            } catch (error) {
                console.error('Error:', error);
                if (swalInstance) {
                    swalInstance.close();
                }
                swalInstance = await showErrorMessage(error.message || 'Có lỗi xảy ra khi thêm đánh giá');
                submitButton.disabled = false;
                submittingForms.delete(formId);
            }
        });
    });

    // Thêm event listener cho nút xem đánh giá, tải dữ liệu theo yêu cầu (lazy loading)
    document.querySelectorAll('button[data-bs-target^="#viewOrderReviewModal"]').forEach(button => {
        button.addEventListener('click', async function() {
            const orderId = this.getAttribute('data-bs-target').replace('#viewOrderReviewModal', '');
            const modal = document.querySelector(`#viewOrderReviewModal${orderId}`);
            
            if (modal) {
                const productItems = modal.querySelectorAll('.product-item');
                if (productItems.length > 0) {
                    const productId = productItems[0].querySelector('input[name="product_id"]')?.value;
                    const variantId = productItems[0].querySelector('input[name="variant_id"]')?.value;
                    
                    if (productId && variantId) {
                        try {
                            // Hiển thị loading spinner trong modal
                            const reviewContent = modal.querySelector('.review-content');
                            if (reviewContent) {
                                reviewContent.innerHTML = '<div class="d-flex justify-content-center p-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Đang tải...</span></div></div>';
                            }
                            
                            const review = await fetchReview(productId, variantId, orderId);
                            if (review) {
                                updateViewReviewModal(orderId, review);
                            } else {
                                if (reviewContent) {
                                    reviewContent.innerHTML = '<div class="alert alert-info my-3">Không tìm thấy đánh giá cho sản phẩm này</div>';
                                }
                            }
                        } catch (error) {
                            console.error('Error loading review:', error);
                            const reviewContent = modal.querySelector('.review-content');
                            if (reviewContent) {
                                reviewContent.innerHTML = '<div class="alert alert-danger my-3">Có lỗi xảy ra khi tải đánh giá</div>';
                            }
                        }
                    }
                }
            }
        });
    });

    // Hàm cập nhật nút đánh giá
    function updateReviewButton(orderId, reviewData) {
        const reviewButton = document.querySelector(`button[data-bs-target="#reviewOrderModal${orderId}"]`);
        if (reviewButton) {
            const viewReviewButton = document.createElement('button');
            viewReviewButton.type = 'button';
            viewReviewButton.className = 'btn btn-success rounded-pill px-3 me-2';
            viewReviewButton.setAttribute('data-bs-toggle', 'modal');
            viewReviewButton.setAttribute('data-bs-target', `#viewOrderReviewModal${orderId}`);
            viewReviewButton.textContent = 'Xem đánh giá';
            reviewButton.parentNode.replaceChild(viewReviewButton, reviewButton);
        }
    }

    // Hàm cập nhật modal xem đánh giá
    function updateViewReviewModal(orderId, reviewData) {
        const viewModal = document.querySelector(`#viewOrderReviewModal${orderId}`);
        if (!viewModal) return;
        
        const reviewContent = viewModal.querySelector('.review-content');
        if (!reviewContent) return;
        
        // Hiển thị thông tin sản phẩm
        const productItems = viewModal.querySelectorAll('.product-item');
        let productName = '';
        let productVariant = '';
        
        if (productItems.length > 0) {
            const productItem = productItems[0];
            productName = productItem.querySelector('h6')?.textContent || '';
            productVariant = productItem.querySelector('.text-muted')?.textContent || '';
        }

        let starsHtml = '';
        for (let i = 1; i <= 5; i++) {
            starsHtml += `<span class="star ${i <= reviewData.rating ? 'filled' : ''}">${i <= reviewData.rating ? '★' : '☆'}</span>`;
        }

        let mediaHtml = '';
        if (reviewData.images && (typeof reviewData.images === 'object' || typeof reviewData.images === 'string')) {
            let images = reviewData.images;
            
            // Xử lý images nếu là string
            if (typeof reviewData.images === 'string') {
                try {
                    images = JSON.parse(reviewData.images);
                } catch (e) {
                    console.error('Error parsing images JSON:', e);
                    images = [];
                }
            }
            
            // Đảm bảo images là array
            if (!Array.isArray(images)) {
                images = images ? [images] : [];
            }
            
            if (images.length > 0) {
                mediaHtml += '<div class="mt-4"><h6 class="fw-bold text-dark mb-3">Hình ảnh đánh giá</h6>';
                mediaHtml += '<div class="images-container d-flex flex-wrap gap-3">';
                images.forEach(image => {
                    if (image) {
                        mediaHtml += `
                            <div class="review-image-container" style="width: 120px; height: 120px;">
                                <img src="${image}" alt="Review image" class="review-image img-fluid" 
                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                            </div>`;
                    }
                });
                mediaHtml += '</div></div>';
            }
        }

        if (reviewData.video) {
            mediaHtml += `
                <div class="mt-4">
                    <h6 class="fw-bold text-dark mb-3">Video đánh giá</h6>
                    <div class="video-container">
                        <video controls class="w-100" style="border-radius: 8px; max-height: 350px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                            <source src="${reviewData.video}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            `;
        }

        reviewContent.innerHTML = `
            <div class="review-details p-4 bg-light rounded-3 mb-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    
                    <div class="text-start">
                        <h6 class="fw-bold text-dark mb-2">Đánh giá</h6>
                        <div class="stars readonly mb-1" style="font-size: 26px; color: #ffd700;">${starsHtml}</div>
                        <div class="rating-date text-muted small">
                            Đánh giá vào: ${new Date(reviewData.created_at).toLocaleDateString('vi-VN')}
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h6 class="fw-bold text-dark mb-3">Nội dung đánh giá</h6>
                    <div class="comment-display p-4 bg-white rounded shadow-sm mb-3">
                        <p class="mb-0 fs-5">${reviewData.review}</p>
                    </div>
                </div>
                
                ${mediaHtml}
            </div>
        `;
    }

    // Hàm hiển thị thông báo thành công
    async function showSuccessMessage() {
        return Swal.fire({
            title: 'Thành công!',
            text: 'Cảm ơn bạn đã đánh giá sản phẩm',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#0d6efd',
            allowOutsideClick: false
        });
    }

    // Hàm hiển thị thông báo lỗi
    async function showErrorMessage(message) {
        return Swal.fire({
            title: 'Lỗi!',
            text: message || 'Có lỗi xảy ra, vui lòng thử lại',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#dc3545',
            allowOutsideClick: false
        });
    }

    // Sử dụng IntersectionObserver để lazy-load reviews khi phần tử đến viewport
    if ('IntersectionObserver' in window) {
        const reviewObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const viewButton = entry.target;
                    const orderId = viewButton.getAttribute('data-bs-target')?.replace('#viewOrderReviewModal', '');
                    if (orderId) {
                        updateReviewButtonStatus(orderId);
                        observer.unobserve(viewButton);
                    }
                }
            });
        }, {
            rootMargin: '0px 0px 200px 0px',
            threshold: 0.1
        });

        // Observe các nút "Xem đánh giá" 
        document.querySelectorAll('button[data-bs-target^="#viewOrderReviewModal"]').forEach(button => {
            reviewObserver.observe(button);
        });
    } else {
        // Nếu không hỗ trợ IntersectionObserver, thì gọi checkReviewStatus có debounce
        const debouncedCheckReviewStatus = debounce(checkReviewStatus, 300);
        window.addEventListener('scroll', debouncedCheckReviewStatus);
        debouncedCheckReviewStatus();
    }

    // Xuất các hàm xử lý preview ra global scope
    window.previewImages = function(input, orderId) {
        const previewDiv = document.getElementById(`imagePreview${orderId}`);
        const files = input.files;

        if (files) {
            // Xóa preview cũ nếu có
            previewDiv.innerHTML = '';
            
            for (let i = 0; i < files.length; i++) {
                if (previewDiv.children.length >= 5) {
                    alert('Bạn chỉ có thể tải lên tối đa 5 ảnh');
                    break;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'preview-item position-relative d-inline-block m-2';
                    previewItem.innerHTML = `
                        <div style="width: 100px; height: 100px; overflow: hidden; border-radius: 8px;">
                            <img src="${e.target.result}" alt="Preview" 
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <button type="button" class="remove-preview btn btn-sm btn-danger position-absolute" 
                            style="top: -10px; right: -10px; border-radius: 50%; padding: 0.2rem 0.5rem;"
                            onclick="window.removePreview(this, ${orderId})">×</button>
                    `;
                    previewDiv.appendChild(previewItem);
                }
                reader.readAsDataURL(files[i]);
            }
        }
    };

    window.previewVideo = function(input, orderId) {
        const previewDiv = document.getElementById(`videoPreview${orderId}`);
        const file = input.files[0];

        if (file) {
            // Xóa preview cũ nếu có
            previewDiv.innerHTML = '';
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item position-relative mt-3';
                previewItem.innerHTML = `
                    <div style="max-width: 300px; border-radius: 8px; overflow: hidden;">
                        <video controls style="width: 100%; border-radius: 8px;">
                            <source src="${e.target.result}" type="${file.type}">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <button type="button" class="remove-preview btn btn-sm btn-danger position-absolute" 
                        style="top: -10px; right: -10px; border-radius: 50%; padding: 0.2rem 0.5rem;"
                        onclick="window.removePreview(this, ${orderId})">×</button>
                `;
                previewDiv.appendChild(previewItem);
            }
            reader.readAsDataURL(file);
        }
    };

    window.removePreview = function(element, orderId) {
        const previewItem = element.closest('.preview-item');
        const isVideo = previewItem.querySelector('video') !== null;

        // Reset input file tương ứng
        if (isVideo) {
            const videoInput = document.getElementById(`videoUpload${orderId}`);
            if (videoInput) {
                videoInput.value = '';
            }
        } else {
            const imageInput = document.getElementById(`imageUpload${orderId}`);
            if (imageInput) {
                // Tạo một input file mới để reset
                const newImageInput = document.createElement('input');
                newImageInput.type = 'file';
                newImageInput.id = `imageUpload${orderId}`;
                newImageInput.name = 'images[]';
                newImageInput.multiple = true;
                newImageInput.accept = 'image/*';
                newImageInput.className = 'd-none';
                newImageInput.setAttribute('onchange', `window.previewImages(this, ${orderId})`);
                imageInput.parentNode.replaceChild(newImageInput, imageInput);
            }
        }

        // Xóa preview item
        previewItem.remove();
    };

    // Thêm style cho preview
    const style = document.createElement('style');
    style.textContent = `
        .preview-item {
            transition: transform 0.2s;
        }
        .preview-item:hover {
            transform: scale(1.05);
        }
        .remove-preview {
            transition: all 0.2s;
            opacity: 0.8;
        }
        .remove-preview:hover {
            opacity: 1;
            transform: scale(1.1);
        }
        .preview-item video {
            max-height: 200px;
            background: #f8f9fa;
        }
    `;
    document.head.appendChild(style);

    // Khởi chạy hàm theo dõi ban đầu
    const debouncedCheckReviewStatus = debounce(checkReviewStatus, 300);
    debouncedCheckReviewStatus();
}); 