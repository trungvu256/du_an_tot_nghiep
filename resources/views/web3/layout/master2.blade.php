<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">

<head>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @include('web3.layout.css')
    @include('web3.layout.menu')
    <style>
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
        .chat-interface {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 700px;
            height: 500px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: none;
            flex-direction: row;
            z-index: 1000;
            overflow: hidden;
        }
        .chat-interface.active { display: flex; }
        .user-list {
            width: 250px;
            height: 100%;
            background-color: #fff;
            border-right: 1px solid #e4e4e4;
            display: flex;
            flex-direction: column;
        }
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
        .user-list-search {
            padding: 10px 15px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #e4e4e4;
        }
        .user-list-search input {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #e4e4e4;
            border-radius: 20px;
            margin-right: 10px;
            outline: none;
            font-size: 14px;
        }
        .user-list-search span {
            font-size: 14px;
            color: #888;
            cursor: pointer;
        }
        .user-list-body {
            flex: 1;
            overflow-y: auto;
            padding: 0;
        }
        .user-item {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .user-item:hover { background-color: #f0f2f5; }
        .user-item.active {
            background-color: #e7f1ff;
            border-left: 3px solid #007bff;
        }
        .user-item .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }
        .user-item .user-info {
            flex: 1;
        }
        .user-item .user-info .user-name {
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }
        .user-item .user-info .last-message {
            font-size: 12px;
            color: #888;
            white-space: nowrap;
            overflow: hidden | text-overflow: ellipsis;
        }
        .user-item .unread-badge {
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            display: none;
        }
        .chat-container {
            flex: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
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
        }
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            background-color: #f0f2f5;
        }
        .chat-input {
            padding: 10px 15px;
            border-top: 1px solid #e4e4e4;
            background-color: white;
            position: relative;
        }
        .chat-input input[type="text"] {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #e4e4e4;
            border-radius: 20px;
            outline: none;
            margin-bottom: 10px;
        }
        .chat-input .input-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }
        .chat-input .input-actions button.image-btn {
            background-color: #f0f2f5;
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin-right: 10px;
            transition: background-color 0.2s;
        }
        .chat-input .input-actions button.image-btn:hover {
            background-color: #e0e0e0;
        }
        .chat-input .input-actions button.send-btn {
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
        .chat-input.dragover {
            background-color: #e0f7fa;
            border: 2px dashed #0084ff;
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
        .message-image {
            max-width: 150px;
            border-radius: 15px;
            margin: 5px 0;
            display: block;
        }
        .message-time {
            font-size: 10px;
            color: #888;
            margin-top: 4px;
            display: block;
            clear: both;
        }
        .chat-bubble {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background-color: white;
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
        .placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: center;
            color: #6c757d;
        }
        .placeholder img {
            width: 150px;
            margin-bottom: 15px;
        }
        .image-preview {
            position: absolute;
            bottom: 80px;
            left: 15px;
            right: 15px;
            background-color: #fff;
            border: 1px solid #e4e4e4;
            border-radius: 10px;
            padding: 10px;
            display: none;
            align-items: center;
            justify-content: flex-start;
            flex-wrap: wrap;
            gap: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 10;
        }
        .image-preview .preview-item {
            position: relative;
            display: inline-block;
        }
        .image-preview img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 5px;
            object-fit: cover;
        }
        .image-preview .remove-image {
            position: absolute;
            top: -5px;
            right: -5px;
            background: rgba(0,0,0,0.5);
            border: none;
            border-radius: 50%;
            color: #fff;
            font-size: 12px;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        #chat-bell {
            position: fixed;
            top: 30px;
            right: 30px;
            z-index: 9999;
            cursor: pointer;
        }
        #bell-icon {
            font-size: 28px;
            color: #007bff;
            transition: 0.2s;
        }
        #bell-badge {
            display: none;
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ff3b30;
            color: #fff;
            border-radius: 50%;
            padding: 2px 7px;
            font-size: 13px;
            font-weight: bold;
        }
        #chat-toast {
            display: none;
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            min-width: 220px;
            background: #007bff;
            color: #fff;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            font-size: 15px;
        }
        #chat-toast-msg {
            display: block;
        }
        .chat-bubble.shake {
            animation: shake 0.5s;
            animation-iteration-count: 2;
        }
        @keyframes shake {
            0% { transform: translate(0, 0); }
            20% { transform: translate(-4px, 0); }
            40% { transform: translate(4px, 0); }
            60% { transform: translate(-4px, 0); }
            80% { transform: translate(4px, 0); }
            100% { transform: translate(0, 0); }
        }
    </style>
     <style>
        .order-notification {
    position: fixed;
    bottom: 20px;
    left: 20px;
    display: flex;
    align-items: flex-start;
    background-color: #fff;
    border-radius: 8px;
    padding: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    text-decoration: none;
    max-width: 320px;
    z-index: 1000;
    color: inherit;
    transition: all 0.3s ease;
}

.order-notification img {
    width: 50px;
    height: 70px;
    object-fit: cover;
    margin-right: 12px;
    border-radius: 4px;
}

.order-notification .content {
    flex: 1;
}

.order-notification .title {
    margin: 0;
    font-size: 13px;
    color: #666;
}

.order-notification .name {
    margin: 2px 0;
    font-size: 15px;
    font-weight: bold;
    color: #000;
}

.order-notification .time {
    font-size: 12px;
    color: #888;
}

.order-notification .close-btn {
    position: absolute;
    top: 6px;
    right: 8px;
    background: none;
    border: none;
    font-size: 18px;
    color: #aaa;
    cursor: pointer;
}

    </style>
</head>

<body>
    @yield('content')
    <a id="orderNotification" class="order-notification" href="#">
        <img id="orderImage" src="" alt="Hình ảnh sản phẩm">
        <div class="content">
            <p id="orderMessage" class="name"></p>
            <span id="orderTime" class="time">Một khách đã mua cách đây</span>
        </div>
        <button class="close-btn" onclick="this.parentElement.style.display='none';">×</button>
    </a>

    @if (Auth::check() && !Auth::user()->is_admin)
        <div class="chat-bubble" id="chatBubble">
            <img src="https://tse1.mm.bing.net/th?id=OIP.tA0EfhHSbC3rCP5UxPahuwHaG3&pid=Api&P=0&h=220" alt="Chat">
            <span class="unread-badge" id="total-unread">0</span>
        </div>

        <div class="chat-interface" id="chatInterface">
            <div class="user-list" id="userList">
                <div class="user-list-header">
                    <h3>Chat</h3>
                </div>
                {{-- <div class="user-list-search">
                    <input type="text" placeholder="Tìm theo tên" id="searchUserInput">
                    <span>Tất cả</span>
                </div> --}}
                <div class="user-list-body">
                    @if(isset($users) && $users->isNotEmpty())
                        @php $hasAdmins = false; @endphp
                        @foreach ($users as $user)
                        @if($user->is_admin == 1)
                            @php $hasAdmins = true; @endphp
                            <div class="user-item" data-user-id="{{ $user->id }}">
                                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/anhlogin.jpg') }}"
                                     width="50" height="50" class="rounded-circle border" style="object-fit: cover;">
                                <div class="user-info">
                                    <div class="user-name">{{ $user->name }}</div>
                                    <div class="last-message" id="last-message-{{ $user->id }}"></div>
                                </div>
                                <span class="unread-badge" id="unread-{{ $user->id }}"></span>
                            </div>
                        @endif
                    @endforeach
                    
                        @if(!$hasAdmins)
                            <div class="text-center p-3">Không có quản trị viên nào</div>
                        @endif
                    @else
                        <div class="text-center p-3">Không có người dùng nào</div>
                    @endif
                </div>
            </div>

            <div class="chat-container" id="chatContainer">
                <div class="chat-header">
                    <h3 id="chatHeaderTitle">Chat với quản trị viên</h3>
                    <button onclick="closeChat()" style="background: none; border: none; color: white;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="chat-messages" id="chatMessages">
                    <div class="placeholder">
                        <img src="{{ asset('assets/images/shopee-chat-placeholder.png') }}" alt="Hình ảnh placeholder">
                        <div>Chào mừng bạn đến với shop Chat</div>
                        <div>Bắt đầu trả lời nguồn mua!</div>
                    </div>
                </div>
                <form id="message-form" class="chat-input">
                    @csrf
                    <input type="hidden" id="receiver_id" name="receiver_id">
                
                    <div class="chat-input">
                        <input type="text" id="messageInput" name="message" placeholder="Nhập nội dung tin nhắn..." disabled>
                
                        <div class="input-actions d-flex justify-content-between w-100">
                            <button type="button" class="action-btn btn p-0" onclick="document.getElementById('imageInput').click()">
                                <i class="bi bi-card-image text-secondary fs-4"></i>
                            </button>
                        
                            <button type="submit" class="action-btn btn p-0">
                                <i class="bi bi-send text-secondary fs-4"></i>
                            </button>
                        </div>
                        
                    </div>
                
                    <input type="file" id="imageInput" name="image[]" accept="image/*" multiple style="display: none;">
                
                    <div class="image-preview" id="imagePreview"></div>
                </form>
                <style>
                    .chat-input {
    padding: 10px;
    background: #fff;
    border-top: 1px solid #eee;
}

.chat-input-wrapper {
    display: flex;
    align-items: center;
    background: #f1f1f1;
    border-radius: 25px;
    padding: 5px 10px;
}

#messageInput {
    flex: 1;
    border: none;
    background: transparent;
    outline: none;
    padding: 10px;
    font-size: 14px;
}

.input-actions {
    display: flex;
    gap: 5px;
    margin-left: 5px;
}

.action-btn {
    background: none;
    border: none;
    padding: 5px;
    border-radius: 50%;
    cursor: pointer;
    transition: background 0.2s;
}

/* .action-btn:hover {
    background: #e0e0e0;
} */

.btn-icon {
    width: 24px;
    height: 24px;
}

                </style>
            </div>
        </div>
    @endif

    @include('web3.layout.footer')
    @include('web3.layout.tab')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    @include('web3.layout.js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        if (notificationName) notificationName.textContent = senderName;
        if (notificationMessage) notificationMessage.textContent = message;
        if (notificationAvatar) notificationAvatar.src = avatarUrl || '{{ asset('assets/images/default-avatar.png') }}';

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

    // Hàm hiển thị thông báo popup có chuông khi có tin nhắn mới
    function showChatBellNotification(message = 'Bạn có tin nhắn mới!') {
        let toast = document.getElementById('chat-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'chat-toast';
            toast.innerHTML = `<span id="chat-toast-msg"><i class="bi bi-bell-fill" style="margin-right:8px;color:gold;"></i>${message}</span>`;
            document.body.appendChild(toast);
        } else {
            document.getElementById('chat-toast-msg').innerHTML = `<i class="bi bi-bell-fill" style="margin-right:8px;color:gold;"></i>${message}`;
        }
        toast.style.display = 'block';
        // Phát âm thanh chuông
        playNotificationSound();
        setTimeout(() => { toast.style.display = 'none'; }, 4000);
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
            // Thay thế tin nhắn tạm bằng tin nhắn thật
            const idx = currentMessages.findIndex(m => m.temp_id === message.temp_id);
            if (idx !== -1) {
                currentMessages[idx] = message;
                displayMessages();
            }
            // Cập nhật tin nhắn tạm trong giao diện (nếu còn)
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
            // Kiểm tra xem tin nhắn đã tồn tại chưa (theo id)
            const existingMessage = currentMessages.find(m => m.id === message.id);
            if (!existingMessage) {
                currentMessages.push(message);
                appendMessage(message.message, message.sender_id === currentUserId, message.created_at, null, message.image_urls);
                scrollToBottom();
            }
        } else if (message.sender_id !== currentUserId) {
            playNotificationSound(); // Luôn phát chuông khi có tin nhắn mới từ người khác
            incrementUnreadCount(message.sender_id);
            const chatBubble = document.getElementById('chatBubble');
            chatBubble.classList.add('shake');
            setTimeout(() => chatBubble.classList.remove('shake'), 1200);
            updateTotalUnreadBadge();
            const sender = document.querySelector(`.user-item[data-user-id="${message.sender_id}"]`);
            if (sender) {
                // Nếu bạn vẫn muốn hiện notification popup, giữ lại dòng dưới, nếu không thì xóa hoặc comment lại
                // showMessageNotification(
                //     sender.textContent.trim(),
                //     message.message,
                //     sender.querySelector('img')?.src
                // );
            }
        }
    });

    // Hàm phát âm thanh thông báo
    function playNotificationSound() {
        console.log('Play sound!');
        if (notificationSound) {
            notificationSound.currentTime = 0; // Reset âm thanh về đầu
            notificationSound.play().catch(error => {
                console.error('Error playing notification sound:', error);
                showAudioHelpPopup();
            });
        }
    }

    // Hiển thị popup hướng dẫn nếu không phát được âm thanh
    function showAudioHelpPopup() {
        let help = document.getElementById('audio-help-popup');
        if (!help) {
            help = document.createElement('div');
            help.id = 'audio-help-popup';
            help.style.position = 'fixed';
            help.style.bottom = '160px';
            help.style.right = '30px';
            help.style.background = '#fff';
            help.style.border = '1px solid #ccc';
            help.style.padding = '16px 24px';
            help.style.borderRadius = '8px';
            help.style.zIndex = 9999;
            help.style.boxShadow = '0 2px 8px rgba(0,0,0,0.15)';
            help.innerHTML = `<b>Không phát được âm thanh?</b><br>1. Truy cập <a href='https://hieuung.com/wp-content/uploads/2022/10/nhac-chuong-tin-nhan-messenger.mp3' target='_blank'>link này</a> để test.<br>2. Nếu không nghe được, hãy thay file mp3 khác vào đúng thư mục đó hoặc dùng link mp3 trực tuyến khác.`;
            document.body.appendChild(help);
            setTimeout(() => { help.remove(); }, 10000);
        }
    }

    // Chuyển đổi trạng thái mở/đóng của cửa sổ chat
    function openChat() {
        isChatOpen = true;
        const chatInterface = document.getElementById('chatInterface');
        chatInterface.classList.add('active');
        chatInterface.style.display = 'flex';
        attachUserItemEvents();
        if (selectedUserId) loadMessages();
    }
    function closeChat() {
        isChatOpen = false;
        const chatInterface = document.getElementById('chatInterface');
        chatInterface.classList.remove('active');
        chatInterface.style.display = 'none';
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
                // document.getElementById('chatHeaderTitle').textContent = `Chat với ${this.textContent.trim()}`;
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
            appendMessage(msg.message, msg.sender_id == currentUserId, msg.created_at, null, msg.image_urls);
        });
        scrollToBottom();
    }

    // Thêm tin nhắn vào giao diện
    function appendMessage(text, isSent, timestamp, tempId = null, imageUrls = null) {
        const container = document.getElementById('chatMessages');
        const div = document.createElement('div');
        div.className = `message ${isSent ? 'sent' : 'received'}`;
        if (tempId) div.dataset.id = tempId;

        const content = document.createElement('div');
        content.className = 'message-content';
        
        // Hiển thị nhiều ảnh nếu có
        let images = imageUrls;
        if (typeof images === 'string') {
            try { images = JSON.parse(images); } catch (e) { images = []; }
        }
        if (Array.isArray(images) && images.length > 0) {
            images.forEach(url => {
                if (url) {
                    const img = document.createElement('img');
                    img.src = url;
                    img.className = 'message-image';
                    content.appendChild(img);
                }
            });
        }
        
        if (text) {
            const textNode = document.createElement('div');
            textNode.textContent = text;
            content.appendChild(textNode);
        }

        const time = document.createElement('span');
        time.className = 'message-time';
        time.textContent = new Date(timestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        div.appendChild(content);
        div.appendChild(time);
        container.appendChild(div);
    }

    // Xử lý khi chọn ảnh
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const files = e.target.files;
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        if (files.length > 0) {
            preview.style.display = 'flex';
            
            for (let file of files) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'preview-item';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        
                        const removeBtn = document.createElement('button');
                        removeBtn.className = 'remove-image';
                        removeBtn.innerHTML = '×';
                        removeBtn.onclick = function() {
                            div.remove();
                            if (preview.children.length === 0) {
                                preview.style.display = 'none';
                            }
                        };
                        
                        div.appendChild(img);
                        div.appendChild(removeBtn);
                        preview.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                }
            }
        } else {
            preview.style.display = 'none';
        }
    });

    // Gửi tin nhắn
    async function sendMessage() {
        const input = document.getElementById('messageInput');
        const text = input.value.trim();
        const imageInput = document.getElementById('imageInput');
        const preview = document.getElementById('imagePreview');
        
        // Kiểm tra điều kiện gửi tin nhắn
        if (!selectedUserId) {
            alert('Vui lòng chọn người nhận tin nhắn');
            return;
        }

        if (!text && imageInput.files.length === 0) {
            alert('Vui lòng nhập tin nhắn hoặc chọn ít nhất một hình ảnh');
            return;
        }

        const formData = new FormData();
        if (text) {
            formData.append('message', text);
        }
        formData.append('receiver_id', selectedUserId);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        // Thêm ảnh vào formData nếu có
        if (imageInput.files.length > 0) {
            for (let file of imageInput.files) {
                if (file.type.startsWith('image/')) {
                    formData.append('image[]', file);
                }
            }
        }

        const tempId = `temp-${Date.now()}`;
        
        // Không hiển thị tin nhắn tạm khi gửi nữa
        // appendMessage(text, true, new Date().toISOString(), tempId);
        // scrollToBottom();
        
        // Reset form
        input.value = '';
        imageInput.value = '';
        preview.innerHTML = '';
        preview.style.display = 'none';

        try {
            const res = await fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (!res.ok) {
                const errorData = await res.json();
                throw new Error(errorData.message || 'Failed to send message');
            }

            const realMsg = await res.json();
            console.log('Message sent successfully:', realMsg);

            // Thay thế tin nhắn tạm bằng tin nhắn thật nếu có temp_id
            if (realMsg && realMsg.message && realMsg.message.temp_id) {
                const idx = currentMessages.findIndex(m => m.temp_id === realMsg.message.temp_id);
                if (idx !== -1) {
                    currentMessages[idx] = realMsg.message;
                    displayMessages();
                }
            }

            // Cập nhật tin nhắn tạm với ảnh nếu có (giữ lại cho trường hợp không dùng temp_id)
            const tempEl = document.querySelector(`#chatMessages .message[data-id="${tempId}"]`);
            if (tempEl) {
                if (realMsg.images && realMsg.images.length > 0) {
                    const content = tempEl.querySelector('.message-content');
                    realMsg.images.forEach(imageUrl => {
                        const img = document.createElement('img');
                        img.src = imageUrl;
                        img.className = 'message-image';
                        content.insertBefore(img, content.firstChild);
                    });
                }
                tempEl.removeAttribute('data-id');
            }
        } catch (err) {
            console.error('Send error:', err);
            const tempEl = document.querySelector(`#chatMessages .message[data-id="${tempId}"]`);
            if (tempEl) {
                tempEl.remove();
            }
            alert('Không thể gửi tin nhắn: ' + err.message);
        }
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

    // Lắng nghe sự kiện click vào biểu tượng chat để mở cửa sổ chat
    document.getElementById('chatBubble').addEventListener('click', function() {
        openChat();
        // Khi mở chat, xóa hiệu ứng rung và reset badge
        const chatBubble = document.getElementById('chatBubble');
        chatBubble.classList.remove('shake');
        unreadCounts = {};
        updateTotalUnreadBadge();
    });

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

    // Đảm bảo notificationSound được kích hoạt sau lần click đầu tiên trên trang
    document.addEventListener('click', function enableAudio() {
        notificationSound.muted = true;
        notificationSound.play().then(() => {
            notificationSound.pause();
            notificationSound.muted = false;
            document.removeEventListener('click', enableAudio);
        }).catch(() => {});
    });
</script>

@yield('scripts')
</body>
</html>