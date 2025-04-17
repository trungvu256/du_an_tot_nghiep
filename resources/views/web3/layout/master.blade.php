<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('web3.layout.css')
    @include('web3.layout.header')
    <style>
        /* CSS từ mã bóng chat, giữ nguyên */
        .order-notification {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 10px 15px;
            display: flex;
            align-items: center;
            max-width: 350px;
            z-index: 1050;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        .order-notification.show { opacity: 1; }
        .order-notification img {
            width: 40px;
            height: 40px;
            border-radius: 5px;
            margin-right: 10px;
        }
        .order-notification .content { flex: 1; }
        .order-notification .content p {
            margin: 0;
            font-size: 14px;
            color: #333;
        }
        .order-notification .content .time {
            font-size: 12px;
            color: #888;
        }
        .chat-container {
            position: fixed;
            bottom: 90px;
            right: 20px;
            width: 350px;
            height: 500px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: none;
            flex-direction: column;
            z-index: 1000;
            overflow: hidden;
        }
        .chat-container.active { display: flex; }
        .chat-header {
            padding: 15px;
            background-color: #0084ff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .chat-header h3 {
            margin: 0;
            font-size: 16px;
            cursor: pointer;
        }
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            background-color: #f0f2f5;
        }
        .chat-input {
            padding: 15px;
            border-top: 1px solid #e4e4e4;
            display: flex;
            align-items: center;
            background-color: white;
        }
        .chat-input input {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #e4e4e4;
            border-radius: 20px;
            margin-right: 10px;
            outline: none;
        }
        .chat-input button {
            background-color: #0084ff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .message {
            margin-bottom: 10px;
            max-width: 80%;
            clear: both;
        }
        .message.sent { float: right; }
        .message.received { float: left; }
        .message-content {
            padding: 8px 12px;
            border-radius: 15px;
            font-size: 14px;
            word-wrap: break-word;
        }
        .message.sent .message-content {
            background-color: #0084ff;
            color: white;
        }
        .message.received .message-content {
            background-color: #e4e6eb;
            color: black;
        }
        .message-time {
            font-size: 10px;
            color: #888;
            margin-top: 4px;
            display: block;
        }
        .chat-bubble {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background-color: #0084ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            z-index: 1000;
        }
        .chat-bubble img {
            width: 30px;
            height: 30px;
        }
        .chat-bubble .unread-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ff3b30;
            color: white;
            border-radius: 50%;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: bold;
            display: none;
        }
        .user-list {
            position: fixed;
            bottom: 90px;
            right: 390px;
            width: 250px;
            max-height: 500px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: none;
            flex-direction: column;
            z-index: 1000;
            overflow: hidden;
        }
        .user-list.active { display: flex; }
        .user-list-header {
            padding: 15px;
            background-color: #0084ff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .user-list-header h3 {
            margin: 0;
            font-size: 16px;
        }
        .user-list-body {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            background-color: #f0f2f5;
        }
        .user-item {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
            transition: background-color 0.2s;
            position: relative;
        }
        .user-item:hover { background-color: #f0f2f5; }
        .user-item.active {
            background-color: #e7f1ff;
            border-left: 3px solid #007bff;
        }
        .user-item .unread-badge {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            display: none;
        }
        /* Thêm CSS cho thông báo tin nhắn mới */
        .message-notification {
            position: fixed;
            bottom: 100px;
            right: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 12px;
            display: flex;
            align-items: center;
            max-width: 300px;
            z-index: 1050;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }
        .message-notification.show {
            opacity: 1;
            transform: translateY(0);
        }
        .message-notification img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 12px;
            object-fit: cover;
        }
        .message-notification .content {
            flex: 1;
            overflow: hidden;
        }
        .message-notification .content .name {
            font-weight: 600;
            font-size: 14px;
            color: #333;
            margin-bottom: 4px;
        }
        .message-notification .content .message {
            font-size: 13px;
            color: #666;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .message-notification .close {
            position: absolute;
            top: 8px;
            right: 8px;
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            font-size: 16px;
            padding: 0;
        }
    </style>
</head>
<body>
    @yield('content')
    <a id="orderNotification" class="order-notification" href="#">
        <img id="orderImage" src="" alt="Product Image">
        <div class="content">
            <p id="orderMessage"></p>
            <span id="orderTime" class="time"></span>
        </div>
    </a>

    <!-- Chat Bubble -->
    <div class="chat-bubble" id="chatBubble">
        <img src="{{ asset('assets/images/messenger.png') }}" alt="Chat">
        <span class="unread-badge" id="total-unread">0</span>
    </div>

    <!-- User List -->
    <div class="user-list" id="userList">
        <div class="user-list-header">
            <h3>Người dùng</h3>
            <button onclick="toggleUserList()" style="background: none; border: none; color: white;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="user-list-body">
            @if(isset($users) && $users->isNotEmpty())
                @foreach ($users as $user)
                    <div class="user-item" data-user-id="{{ $user->id }}">
                        {{ $user->name }}
                        <span class="unread-badge" id="unread-{{ $user->id }}">0</span>
                    </div>
                @endforeach
            @else
                <div class="text-center p-3">Không có người dùng nào</div>
            @endif
        </div>
    </div>

    <!-- Chat Container -->
    <div class="chat-container" id="chatContainer">
        <div class="chat-header">
            <h3 id="chatHeaderTitle" onclick="toggleUserList()">
                @if (Auth::check())
                    Chat với {{ Auth::user()->is_admin ? 'khách hàng' : 'quản trị viên' }}
                @else
                    Chat với khách
                @endif
            </h3>
            <button onclick="toggleChat()" style="background: none; border: none; color: white;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="chat-messages" id="chatMessages">
            <div class="no-messages text-center" style="color: #6c757d; padding: 20px;">
                Chọn một người dùng để bắt đầu cuộc trò chuyện
            </div>
        </div>
        <form id="message-form" class="chat-input">
            @csrf
            <input type="hidden" id="receiver_id" name="receiver_id">
            <input type="text" id="messageInput" name="message" placeholder="Nhập tin nhắn...">
            <button type="submit">
                <i class="fas fa-paper-plane"></i>Gửi
            </button>
        </form>
    </div>

    <!-- Thêm thông báo tin nhắn mới -->
    <div class="message-notification" id="messageNotification">
        <button class="close" onclick="hideMessageNotification()">&times;</button>
        <img id="notificationAvatar" src="" alt="Avatar">
        <div class="content">
            <div class="name" id="notificationName"></div>
            <div class="message" id="notificationMessage"></div>
        </div>
    </div>

    @include('web3.layout.footer')
    @include('web3.layout.tab')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    @include('web3.layout.js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
    // Khai báo các biến toàn cục
    let currentUserId = {{ Auth::id() }};
    let selectedUserId = localStorage.getItem('selectedUserId') || null;
    let currentMessages = [];
    let unreadCounts = {};
    let isChatOpen = false;
    let isUserListOpen = false;
    let messageCache = new Set();
    let notificationSound = new Audio('{{ asset('assets/sounds/notification.mp3') }}');
    let tempMessages = new Map(); // Thêm Map để quản lý tin nhắn tạm

    // Cấu hình Pusher
    Pusher.logToConsole = false;
    const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        encrypted: true,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }
    });

    const channel = pusher.subscribe('chat.' + currentUserId);

    channel.bind('pusher:subscription_succeeded', () => {
        console.log('Pusher connected');
    });

    // Hàm hiển thị thông báo tin nhắn mới
    function showMessageNotification(senderName, message, avatarUrl) {
        const notification = document.getElementById('messageNotification');
        const notificationName = document.getElementById('notificationName');
        const notificationMessage = document.getElementById('notificationMessage');
        const notificationAvatar = document.getElementById('notificationAvatar');

        notificationName.textContent = senderName;
        notificationMessage.textContent = message;
        notificationAvatar.src = avatarUrl || '{{ asset('assets/images/default-avatar.png') }}';

        notification.classList.add('show');

        // Tự động ẩn thông báo sau 5 giây
        setTimeout(() => {
            hideMessageNotification();
        }, 5000);

        // Thêm sự kiện click để mở chat
        notification.onclick = function() {
            hideMessageNotification();
            toggleChat();
        };
    }

    // Hàm ẩn thông báo tin nhắn mới
    function hideMessageNotification() {
        const notification = document.getElementById('messageNotification');
        notification.classList.remove('show');
    }

    // Cập nhật phần xử lý tin nhắn mới
    channel.bind('message.sent', function(data) {
        if (!data || !data.message) return;

        const message = data.message;
        const messageKey = message.temp_id || `${message.id}`;

        // Kiểm tra xem tin nhắn đã được xử lý chưa
        if (messageCache.has(messageKey)) return;
        messageCache.add(messageKey);

        // Nếu là tin nhắn phản hồi từ gửi (có temp_id)
        if (message.temp_id) {
            // Xóa tin nhắn tạm khỏi Map
            tempMessages.delete(message.temp_id);
            
            // Cập nhật tin nhắn tạm trong giao diện
            const tempEl = document.querySelector(`#chatMessages .message[data-id="${message.temp_id}"]`);
            if (tempEl) {
                tempEl.querySelector('.message-content').textContent = message.message;
                tempEl.querySelector('.message-time').textContent =
                    new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                tempEl.removeAttribute('data-id');
            }
            return;
        }

        // Nếu là tin nhắn mới
        if (selectedUserId && (message.sender_id == selectedUserId || message.receiver_id == selectedUserId)) {
            // Kiểm tra xem tin nhắn đã tồn tại chưa
            const existingMessage = currentMessages.find(m => m.id === message.id);
            if (!existingMessage) {
                currentMessages.push(message);
                appendMessage(message.message, message.sender_id === currentUserId, message.created_at);
                scrollToBottom();
            }
        } else if (message.sender_id !== currentUserId) {
            incrementUnreadCount(message.sender_id);
            if (!isChatOpen) {
                playNotificationSound();
                const sender = document.querySelector(`.user-item[data-user-id="${message.sender_id}"]`);
                if (sender) {
                    showMessageNotification(
                        sender.textContent.trim(),
                        message.message,
                        sender.querySelector('img')?.src
                    );
                }
            }
        }
    });

    // Hàm phát âm thanh thông báo
    function playNotificationSound() {
        if (notificationSound) {
            notificationSound.currentTime = 0; // Reset âm thanh về đầu
            notificationSound.play().catch(error => {
                console.error('Error playing notification sound:', error);
            });
        }
    }

    // Chuyển đổi trạng thái mở/đóng của cửa sổ chat
    function toggleChat() {
        isChatOpen = !isChatOpen;
        document.getElementById('chatContainer').classList.toggle('active');
        if (isChatOpen && selectedUserId) loadMessages();
    }

    // Chuyển đổi trạng thái mở/đóng của danh sách người dùng
    function toggleUserList(forceClose = false) {
        isUserListOpen = forceClose ? false : !isUserListOpen;
        document.getElementById('userList').classList.toggle('active', isUserListOpen);
        if (isUserListOpen && !isChatOpen) toggleChat();
    }

    // Gắn sự kiện cho các mục người dùng
    function attachUserItemEvents() {
        document.querySelectorAll('.user-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.user-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                selectedUserId = this.dataset.userId;
                localStorage.setItem('selectedUserId', selectedUserId);
                document.getElementById('chatHeaderTitle').textContent = `Chat với ${this.textContent.trim()}`;
                resetUnreadCount(selectedUserId);
                document.getElementById('receiver_id').value = selectedUserId;
                document.getElementById('messageInput').disabled = false;
                document.querySelector('.chat-input button').disabled = false;
                loadMessages();
                toggleUserList(true);
            });
        });
    }

    // Tải các tin nhắn cũ từ server
    async function loadMessages() {
        if (!selectedUserId) {
            document.getElementById('chatMessages').innerHTML = 
                '<div class="text-center p-3 text-muted">Chọn người dùng để bắt đầu trò chuyện</div>';
            return;
        }

        document.getElementById('chatMessages').innerHTML = '<div class="text-center p-3 text-muted">Đang tải...</div>';

        try {
            const response = await fetch(`/chat/${selectedUserId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            if (!response.ok) {
                throw new Error('Failed to load messages');
            }

            const messages = await response.json();
            currentMessages = messages;
            messageCache.clear();
            displayMessages();
        } catch (err) {
            console.error(err);
            document.getElementById('chatMessages').innerHTML = 
                `<div class="text-danger text-center p-3">Không thể tải tin nhắn. Vui lòng thử lại sau.</div>`;
        }
    }

    // Hiển thị các tin nhắn trong giao diện
    function displayMessages() {
        const messagesContainer = document.getElementById('chatMessages');
        messagesContainer.innerHTML = '';
        messageCache.clear();

        currentMessages.forEach(msg => {
            const messageKey = `${msg.id}`;
            messageCache.add(messageKey);
            appendMessage(msg.message, msg.sender_id == currentUserId, msg.created_at);
        });
        scrollToBottom();
    }

    // Gửi tin nhắn
    async function sendMessage() {
        const input = document.getElementById('messageInput');
        const text = input.value.trim();
        if (!selectedUserId || !text) return;

        const tempId = `temp-${Date.now()}`;
        const tempMsg = {
            id: tempId,
            temp_id: tempId,
            sender_id: currentUserId,
            receiver_id: parseInt(selectedUserId),
            message: text,
            created_at: new Date().toISOString(),
            isTemp: true
        };

        // Lưu tin nhắn tạm vào Map
        tempMessages.set(tempId, tempMsg);
        
        // Hiển thị tin nhắn tạm
        appendMessage(text, true, tempMsg.created_at, tempId);
        scrollToBottom();
        input.value = '';

        try {
            const res = await fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: text, receiver_id: selectedUserId, temp_id: tempId })
            });

            if (!res.ok) {
                throw new Error('Failed to send message');
            }

            const realMsg = await res.json();
            // Xóa tin nhắn tạm khỏi Map sau khi gửi thành công
            tempMessages.delete(tempId);
        } catch (err) {
            console.error('Send error:', err);
            // Nếu gửi thất bại, xóa tin nhắn tạm khỏi giao diện
            const tempEl = document.querySelector(`#chatMessages .message[data-id="${tempId}"]`);
            if (tempEl) {
                tempEl.remove();
            }
            tempMessages.delete(tempId);
            alert('Không thể gửi tin nhắn. Vui lòng thử lại.');
        }
    }

    // Thêm tin nhắn vào giao diện
    function appendMessage(text, isSent, timestamp, tempId = null) {
        const container = document.getElementById('chatMessages');
        const div = document.createElement('div');
        div.className = `message ${isSent ? 'sent' : 'received'}`;
        if (tempId) div.dataset.id = tempId;

        const content = document.createElement('div');
        content.className = 'message-content';
        content.textContent = text;

        const time = document.createElement('span');
        time.className = 'message-time';
        time.textContent = new Date(timestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        div.appendChild(content);
        div.appendChild(time);
        container.appendChild(div);
    }

    // Cuộn xuống dưới cùng của danh sách tin nhắn
    function scrollToBottom() {
        const container = document.getElementById('chatMessages');
        container.scrollTop = container.scrollHeight;
    }

    // Cập nhật số lượng tin nhắn chưa đọc
    function incrementUnreadCount(id) {
        unreadCounts[id] = (unreadCounts[id] || 0) + 1;
        updateUnreadBadge(id);
        updateTotalUnreadBadge();
    }

    // Reset số lượng tin nhắn chưa đọc
    function resetUnreadCount(id) {
        unreadCounts[id] = 0;
        updateUnreadBadge(id);
        updateTotalUnreadBadge();
    }

    // Cập nhật biểu tượng số tin nhắn chưa đọc cho từng người dùng
    function updateUnreadBadge(id) {
        const badge = document.getElementById(`unread-${id}`);
        if (badge) {
            const count = unreadCounts[id] || 0;
            badge.textContent = count;
            badge.style.display = count > 0 ? 'block' : 'none';
        }
    }

    // Cập nhật biểu tượng tổng số tin nhắn chưa đọc
    function updateTotalUnreadBadge() {
        const badge = document.getElementById('total-unread');
        const total = Object.values(unreadCounts).reduce((sum, c) => sum + c, 0);
        badge.textContent = total;
        badge.style.display = total > 0 ? 'block' : 'none';
    }

    // Lắng nghe sự kiện click vào biểu tượng chat để mở/đóng cửa sổ chat
    document.getElementById('chatBubble').addEventListener('click', toggleChat);

    // Gửi tin nhắn khi form được submit
    document.getElementById('message-form').addEventListener('submit', function(e) {
        e.preventDefault();
        sendMessage();
    });

    // Khi trang đã tải xong, gắn các sự kiện và tải tin nhắn nếu cần
    document.addEventListener('DOMContentLoaded', function() {
        attachUserItemEvents();
        if (selectedUserId) {
            const item = document.querySelector(`.user-item[data-user-id="${selectedUserId}"]`);
            if (item) {
                item.classList.add('active');
                document.getElementById('chatHeaderTitle').textContent = `Chat với ${item.textContent.trim()}`;
                document.getElementById('receiver_id').value = selectedUserId;
                document.getElementById('messageInput').disabled = false;
                document.querySelector('.chat-input button').disabled = false;
                loadMessages();
            }
        }

        // Lấy số lượng tin nhắn chưa đọc
        fetch('/chat/unread/count', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(res => res.json())
        .then(data => {
            unreadCounts = data.unread_counts || {};
            Object.keys(unreadCounts).forEach(id => updateUnreadBadge(id));
            updateTotalUnreadBadge();
        });
    });
</script>

    
</body>
</html>