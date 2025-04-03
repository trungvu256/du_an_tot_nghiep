import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Cấu hình Pusher và Laravel Echo
window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'your-pusher-app-key',
    cluster: 'your-pusher-app-cluster',
    forceTLS: true,
});

// Lắng nghe kênh chat giữa người dùng và admin
let userId = document.getElementById('user_id').value; // Lấy ID người dùng
let receiverId = document.getElementById('receiver_id').value; // Lấy ID người nhận tin nhắn (admin)

window.Echo.private(`chat.${Math.min(userId, receiverId)}.${Math.max(userId, receiverId)}`)
    .listen('MessageSent', (event) => {
        // Cập nhật giao diện với tin nhắn mới
        let messageElement = document.createElement('div');
        messageElement.classList.add('message');
        messageElement.innerHTML = `
            <strong>${event.user_name}</strong>: ${event.message}
        `;
        document.getElementById('messages').appendChild(messageElement);

        // Cuộn xuống cuối chat (nếu cần)
        document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
    });
