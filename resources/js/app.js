
require('./bootstrap');
import 'bootstrap';

// Hàm định dạng thời gian
function formatTimeDiff(eventTime) {
    const now = new Date();
    const diff = Math.floor((now - eventTime) / 1000); // Giây
    if (diff < 60) return `${diff} giây trước`;
    const minutes = Math.floor(diff / 60);
    if (minutes < 60) return `${minutes} phút trước`;
    const hours = Math.floor(minutes / 60);
    return `${hours} giờ trước`;
}

// Hàm hiển thị thông báo
function showOrderNotification(data) {
    const orderMessage = document.getElementById('orderMessage');
    const orderTime = document.getElementById('orderTime');
    const orderImage = document.getElementById('orderImage');
    const notificationElement = document.getElementById('orderNotification');

    if (!notificationElement) {
        console.error('Notification element not found!');
        return;
    }

    // Thời gian từ dữ liệu sự kiện
    const eventTime = new Date(data.created_at || Date.now());

    // Cập nhật nội dung
    orderMessage.textContent = data.message || 'Đơn hàng mới (không có thông tin)';
    orderTime.textContent = formatTimeDiff(eventTime);
    orderImage.src = data.product_image || '/default-image.jpg';

     // 🛠️ Cập nhật href để trỏ đến trang chi tiết sản phẩm
     notificationElement.href = data.product_url || '#';

    // Xử lý lỗi tải ảnh
    orderImage.onerror = () => {
        console.error('Không thể tải ảnh:', data.product_image);
        orderImage.src = '/default-image.jpg';
    };

    // Hiển thị thông báo
    notificationElement.classList.add('show');

    // Cập nhật thời gian mỗi giây
    const interval = setInterval(() => {
        orderTime.textContent = formatTimeDiff(eventTime);
    }, 1000);

    // Ẩn thông báo sau 30 giây
    setTimeout(() => {
        notificationElement.classList.remove('show');
        clearInterval(interval);
    }, 30000); // 30 giây
}

// Lắng nghe sự kiện từ Pusher
document.addEventListener('DOMContentLoaded', function () {
    window.Echo.channel('orders')
        .listen('OrderPlaced', (e) => {
            console.log('Order placed:', e);
            showOrderNotification(e);
        });
});

//nhắn tin
Echo.private('chat.' + userChatId)
    .listen('MessageSent', (event) => {
        console.log('New message received:', event.message);
        displayMessage(event.message.message, event.message.sender_id);
    });

import './bootstrap';

