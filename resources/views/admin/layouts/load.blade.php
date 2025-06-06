<!-- Loading wrapper start -->
<div id="loading-wrapper">
    <div class="spinner"></div>
</div>
<!-- Loading wrapper end -->

<style>
/* Wrapper toàn màn hình */
#loading-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    transition: opacity 0.3s ease-out;
}

/* Vòng tròn xoay hiện đại */
.spinner {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: 6px solid transparent;
    border-top-color: #3498db; /* Xanh dương */
    border-right-color: #e74c3c; /* Đỏ */
    border-bottom-color: #f1c40f; /* Vàng */
    border-left-color: #2ecc71; /* Xanh lá */
    animation: spin 1s linear infinite;
}

/* Keyframes tạo hiệu ứng xoay */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Class để ẩn loading */
.loading-hidden {
    opacity: 0;
    pointer-events: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ẩn loading sau khi trang đã tải xong
    const loadingWrapper = document.getElementById('loading-wrapper');
    if (loadingWrapper) {
        loadingWrapper.classList.add('loading-hidden');

        // Xóa hoàn toàn loading sau khi animation kết thúc
        setTimeout(() => {
            loadingWrapper.style.display = 'none';
        }, 300);
    }
});

// Xử lý trường hợp có lỗi JavaScript
window.addEventListener('error', function() {
    const loadingWrapper = document.getElementById('loading-wrapper');
    if (loadingWrapper) {
        loadingWrapper.classList.add('loading-hidden');
        setTimeout(() => {
            loadingWrapper.style.display = 'none';
        }, 300);
    }
});
</script>
