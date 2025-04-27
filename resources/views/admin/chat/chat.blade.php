@extends('admin.layouts.main')

@section('content')
    <style>
        .chat-container {
            height: 500px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 15px;
            background-color: #f8f9fa;
            margin-bottom: 20px;
        }
        .message {
            margin-bottom: 15px;
            padding: 10px 16px;
            border-radius: 16px;
            max-width: 80%;
            word-wrap: break-word;
            display: inline-block;
            min-width: 40px;
        }
        .message.sent {
            background-color: #007bff;
            color: white;
            margin-left: auto;
            display: inline-block;
            text-align: left;
            float: right;
            clear: both;
        }
        .message.received {
            background-color: #e9ecef;
            color: black;
            margin-right: auto;
            display: inline-block;
            text-align: left;
            float: left;
            clear: both;
        }
        .message-text {
            margin-bottom: 5px;
        }
        .message-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            margin: 5px 0;
            display: block;
        }
        .message-time {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
            text-align: right;
        }
        .user-list {
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }
        .user-item {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
            transition: background-color 0.2s;
            position: relative;
        }
        .user-item:hover {
            background-color: #f0f2f5;
        }
        .user-item.active {
            background-color: #e7f1ff;
            border-left: 3px solid #007bff;
        }
        .message-input {
            border-radius: 20px;
            padding: 8px 15px;
        }
        .send-button {
            border-radius: 20px;
            padding: 8px 20px;
        }
        .no-messages {
            text-align: center;
            color: #6c757d;
            padding: 20px;
        }
        #message-form {
            opacity: 0.5;
            pointer-events: none;
        }
        #message-form.active {
            opacity: 1;
            pointer-events: all;
        }
        .unread-badge {
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
        .image-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .image-preview img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 8px;
            object-fit: cover;
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
    </style>
</head>
<body>
<div id="chat-toast" style="display:none;position:fixed;bottom:30px;right:30px;z-index:9999;min-width:220px;background:#007bff;color:#fff;padding:16px 24px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.15);font-size:15px;">
    <span id="chat-toast-msg"></span>
</div>
<div id="chat-bell" style="position:fixed;top:30px;right:30px;z-index:9999;cursor:pointer;">
    <i class="fas fa-bell" style="font-size:28px;color:#007bff;transition:0.2s;" id="bell-icon"></i>
    <span id="bell-badge" style="display:none;position:absolute;top:-8px;right:-8px;background:#ff3b30;color:#fff;border-radius:50%;padding:2px 7px;font-size:13px;font-weight:bold;">0</span>
</div>
<div class="container mt-4">
    <h3 class="mb-4">{{ Auth::user()->is_admin ? 'khách hàng' : 'quản trị viên' }}</h3>

    <div class="row">
        <!-- Danh sách người dùng -->
        <div class="col-md-4">
            {{-- <h5 class="p-3 bg-light border-bottom mb-0">Người dùng</h5> --}}
            <div class="user-list">
                
                @foreach ($users as $user)
                    <div class="user-item" data-user-id="{{ $user->id }}">
                        {{ $user->name }}
                        <span class="unread-badge" id="unread-{{ $user->id }}">0</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Khung chat -->
        <div class="col-md-8">
            <div class="chat-container" id="chat-container">
                <div id="messages">
                    <div class="no-messages">
                        Chọn một người dùng để bắt đầu cuộc trò chuyện
                    </div>
                </div>
            </div>

            <form id="message-form" class="chat-input">
                @csrf
                <input type="hidden" id="receiver_id" name="receiver_id">
                <div class="chat-input">
                    <input type="text" class="form-control message-input" id="message" name="message" 
                           placeholder="Nhập tin nhắn..." autocomplete="off">
                    <input type="file" id="imageInput" name="image[]" accept="image/*" multiple style="display: none;">
                    <div class="input-actions d-flex justify-content-between w-100">
                    <button type="button" class="action-btn btn p-0" onclick="document.getElementById('imageInput').click()">
                        <i class="bi bi-card-image text-secondary fs-4"></i>
                    </button>

                    <button type="submit" class="action-btn btn p-0"><i class="bi bi-send text-secondary fs-4"></i></button>
                </div>
                    
                </div>
                <div class="image-preview" id="imagePreview"></div>
            </form>

            <style>
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
#message {
    flex: 1;
    border: none;
    background: transparent;
    outline: none;
    padding: 10px;
    font-size: 14px;
}
.btn-icon {
    width: 24px;
    height: 24px;
}

                </style>
            </style>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
    let currentUserId = {{ Auth::id() }};
    let selectedUserId = localStorage.getItem('selectedUserId');
    let currentMessages = [];
    let unreadCounts = {};
    let selectedImages = [];

    // Khởi tạo Pusher
    const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        encrypted: true
    });

    // Subscribe to channel for current user
    const channel = pusher.subscribe('chat.' + currentUserId);

    // Khai báo âm thanh notification (dùng file nội bộ hoặc link mp3)
    let notificationSound = new Audio('/assets/sounds/notification.mp3');

    // Đảm bảo notificationSound được kích hoạt sau lần click đầu tiên trên trang
    document.addEventListener('click', function enableAudio() {
        notificationSound.muted = true;
        notificationSound.play().then(() => {
            notificationSound.pause();
            notificationSound.muted = false;
            document.removeEventListener('click', enableAudio);
        }).catch(() => {});
    });

    // Hàm phát âm thanh thông báo
    function playNotificationSound() {
        if (notificationSound) {
            notificationSound.currentTime = 0;
            notificationSound.play().catch(error => {
                console.error('Error playing notification sound:', error);
            });
        }
    }

    // Hàm di chuyển user lên đầu danh sách khi có tin nhắn mới
    function moveUserToTop(userId) {
        const userList = document.querySelector('.user-list');
        const userItem = document.querySelector(`.user-item[data-user-id="${userId}"]`);
        if (userList && userItem) {
            userList.insertBefore(userItem, userList.firstChild);
        }
    }

    // Bind to the message.sent event
    channel.bind('message.sent', function(data) {
        console.log('Received message:', data);
        const message = data.message;
        // Bỏ qua nếu tin nhắn do chính người dùng gửi
        if (message.sender_id === currentUserId) {
            return;
        }
        // Phát chuông khi có tin nhắn mới từ người khác
        playNotificationSound();
        // Đẩy user lên đầu danh sách
        moveUserToTop(message.sender_id);
        // Nếu KHÔNG ở đúng cuộc trò chuyện, chỉ hiện thông báo popup
        if (!selectedUserId || (parseInt(message.sender_id) !== parseInt(selectedUserId) && parseInt(message.receiver_id) !== parseInt(selectedUserId))) {
            showChatToast('Bạn có tin nhắn mới!');
        }
        // Giữ nguyên các logic cũ
        if (selectedUserId && (message.sender_id === parseInt(selectedUserId) || message.receiver_id === parseInt(selectedUserId))) {
            currentMessages.push(message);
            appendMessage(message);
            scrollToBottom();
        } else if (message.sender_id !== currentUserId) {
            incrementUnreadCount(message.sender_id);
        }
    });

    // Xử lý chọn ảnh
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        selectedImages = [...selectedImages, ...files];
        updateImagePreviews();
    });

    function updateImagePreviews() {
        const previewContainer = document.getElementById('imagePreview');
        previewContainer.innerHTML = '';
        
        selectedImages.forEach((file, index) => {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.alt = 'Preview';
            previewContainer.appendChild(img);
        });
    }

    // Chọn người dùng để chat
    document.querySelectorAll('.user-item').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('.user-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');

            selectedUserId = this.dataset.userId;
            localStorage.setItem('selectedUserId', selectedUserId);
            
            // Reset unread count
            resetUnreadCount(selectedUserId);
            
            document.getElementById('receiver_id').value = selectedUserId;
            document.getElementById('message-form').classList.add('active');
            
            loadMessages();
        });
    });

    function loadMessages() {
        document.getElementById('messages').innerHTML = '<div class="text-center">Đang tải...</div>';

        fetch(`/chat/${selectedUserId}`)
            .then(res => res.json())
            .then(messages => {
                currentMessages = messages;
                displayMessages();
            })
            .catch(error => {
                console.error('Error fetching messages:', error);
                document.getElementById('messages').innerHTML = 
                    '<div class="text-danger text-center">Có lỗi xảy ra khi tải tin nhắn</div>';
            });
    }

    function displayMessages() {
        const messagesDiv = document.getElementById('messages');
        messagesDiv.innerHTML = '';
        
        if (currentMessages.length === 0) {
            messagesDiv.innerHTML = '<div class="no-messages">Chưa có tin nhắn nào</div>';
            return;
        }

        currentMessages.forEach(msg => appendMessage(msg));
        scrollToBottom();
    }

    // Gửi tin nhắn
    document.getElementById('message-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const messageInput = document.getElementById('message');
        const message = messageInput.value.trim();
        
        if (!selectedUserId || (!message && selectedImages.length === 0)) {
            alert('Vui lòng nhập tin nhắn hoặc chọn ít nhất một hình ảnh');
            return;
        }

        const formData = new FormData();
        formData.append('message', message);
        formData.append('receiver_id', selectedUserId);
        selectedImages.forEach(file => formData.append('image[]', file));

        // Tạo tin nhắn tạm thời
        const tempMessage = {
            sender_id: currentUserId,
            receiver_id: parseInt(selectedUserId),
            message: message,
            image_urls: selectedImages.map(file => URL.createObjectURL(file)),
            created_at: new Date().toISOString(),
            isTemp: true
        };

        // Thêm vào danh sách tin nhắn và hiển thị
        currentMessages.push(tempMessage);
        appendMessage(tempMessage);
        scrollToBottom();
        messageInput.value = '';
        selectedImages = [];
        document.getElementById('imagePreview').innerHTML = '';

        fetch('/chat/send', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Tìm và thay thế tin nhắn tạm thời
                const index = currentMessages.findIndex(m => m.isTemp);
                if (index !== -1) {
                    currentMessages[index] = data.message;
                    displayMessages();
                }
                // Đẩy user lên đầu danh sách sau khi gửi tin nhắn thành công
                moveUserToTop(selectedUserId);
            } else {
                throw new Error(data.message || 'Không thể gửi tin nhắn');
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
            alert('Không thể gửi tin nhắn. Vui lòng thử lại.');
        });
    });

    // Hiển thị tin nhắn
    function appendMessage(msg) {
        const div = document.createElement('div');
        div.className = `message ${msg.sender_id == currentUserId ? 'sent' : 'received'}`;
        let content = '';
        // Thêm text nếu có
        if (msg.message && msg.message.trim() !== '') {
            content += `<div class="message-text">${msg.message}</div>`;
        }
        // Thêm ảnh nếu có
        let imageUrls = msg.image_urls;
        if (typeof imageUrls === 'string') {
            try {
                imageUrls = JSON.parse(imageUrls);
            } catch (e) {
                imageUrls = [];
            }
        }
        if (Array.isArray(imageUrls) && imageUrls.length > 0) {
            content += `<div class="message-images" style="display:flex;gap:8px;flex-wrap:wrap;">`;
            imageUrls.forEach(url => {
                content += `<img src="${url}" class="message-image" alt="Hình ảnh tin nhắn" style="margin:0;">`;
            });
            content += `</div>`;
        }
        // Nếu không có text và không có ảnh thì không render gì
        if ((!msg.message || msg.message.trim() === '') && (!Array.isArray(imageUrls) || imageUrls.length === 0)) return;
        // Thêm thời gian
        const time = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        content += `<div class="message-time">${time}</div>`;
        div.innerHTML = content;
        document.getElementById('messages').appendChild(div);
    }

    // Cuộn xuống tin nhắn mới nhất
    function scrollToBottom() {
        const container = document.getElementById('chat-container');
        container.scrollTop = container.scrollHeight;
    }

    // Xử lý tin nhắn chưa đọc
    function incrementUnreadCount(senderId) {
        unreadCounts[senderId] = (unreadCounts[senderId] || 0) + 1;
        updateUnreadBadge(senderId);
    }

    function resetUnreadCount(userId) {
        unreadCounts[userId] = 0;
        updateUnreadBadge(userId);
    }

    function updateUnreadBadge(userId) {
        const badge = document.getElementById(`unread-${userId}`);
        if (badge) {
            const count = unreadCounts[userId] || 0;
            badge.textContent = count;
            badge.style.display = count > 0 ? 'block' : 'none';
        }
    }

    // Khởi tạo form
    if (!selectedUserId) {
        document.getElementById('message-form').classList.remove('active');
    } else {
        const userItem = document.querySelector(`.user-item[data-user-id="${selectedUserId}"]`);
        if (userItem) {
            userItem.classList.add('active');
            document.getElementById('receiver_id').value = selectedUserId;
            document.getElementById('message-form').classList.add('active');
            loadMessages();
        }
    }

    // Xử lý lỗi kết nối Pusher
    pusher.connection.bind('error', function(err) {
        console.error('Pusher connection error:', err);
    });

    pusher.connection.bind('connected', function() {
        console.log('Connected to Pusher');
    });

    // Hàm hiển thị toast thông báo
    function showChatToast(msg) {
        const toast = document.getElementById('chat-toast');
        document.getElementById('chat-toast-msg').textContent = msg;
        toast.style.display = 'block';
        setTimeout(() => { toast.style.display = 'none'; }, 3500);
    }

    // Hàm rung chuông
    function ringBell() {
        const bell = document.getElementById('bell-icon');
        bell.style.color = '#ff3b30';
        bell.classList.add('fa-shake');
        setTimeout(() => {
            bell.classList.remove('fa-shake');
            bell.style.color = '#007bff';
        }, 1200);
    }

    // Cập nhật badge chuông
    function updateBellBadge(count) {
        const badge = document.getElementById('bell-badge');
        if (count > 0) {
            badge.textContent = count;
            badge.style.display = 'block';
        } else {
            badge.style.display = 'none';
        }
    }

    // Khi click chuông thì reset badge
    document.getElementById('chat-bell').addEventListener('click', function() {
        updateBellBadge(0);
    });
</script>
@endsection
