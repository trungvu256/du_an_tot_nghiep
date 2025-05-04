
require('./bootstrap');
import 'bootstrap';

// Hàm định dạng thời gian
function formatTimeDiff(eventTime) {
    const now = new Date();
    const diff = Math.floor((now - eventTime) / 1000); // Giây

    if (diff < 60) return `Một khách hàng vừa đặt mua cách đây ${diff} giây`;
    
    const minutes = Math.floor(diff / 60);
    if (minutes < 60) return `Một khách hàng vừa đặt mua cách đây ${minutes} phút`;
    
    const hours = Math.floor(minutes / 60);
    return `Một khách hàng vừa đặt mua cách đây ${hours} giờ`;
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

    // Thời gian tạo đơn hàng
    const eventTime = new Date(data.created_at || Date.now());

    // Cập nhật nội dung thông báo
    orderMessage.innerHTML = `
        <p>Sản phẩm</p>
        ${data.message || 'Đơn hàng mới (không có thông tin)'}
    `;
    orderImage.src = data.product_image || '/default-image.jpg';
    notificationElement.href = data.product_url || '#';

    // Cập nhật thời gian lần đầu
    orderTime.textContent = formatTimeDiff(eventTime);

    // Xử lý lỗi ảnh
    orderImage.onerror = () => {
        console.warn('Không thể tải ảnh sản phẩm, dùng ảnh mặc định');
        orderImage.src = '/default-image.jpg';
    };

    // Hiển thị thông báo
    notificationElement.classList.add('show');

    // Cập nhật "cách đây X phút" mỗi giây
    const interval = setInterval(() => {
        orderTime.textContent = formatTimeDiff(eventTime);
    }, 1000);

    // Ẩn sau 30 giây
    setTimeout(() => {
        notificationElement.classList.remove('show');
        clearInterval(interval);
    }, 30000);
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

