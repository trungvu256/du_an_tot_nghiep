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
            padding: 10px;
            border-radius: 8px;
            max-width: 80%;
            word-wrap: break-word;
        }
        .message.sent {
            background-color: #007bff;
            color: white;
            margin-left: auto;
        }
        .message.received {
            background-color: #e9ecef;
            color: black;
            margin-right: auto;
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
    </style>
</head>
<body>
<div class="container mt-4">
    <h3 class="mb-4">Chat với {{ Auth::user()->is_admin ? 'khách hàng' : 'quản trị viên' }}</h3>

    <div class="row">
        <!-- Danh sách người dùng -->
        <div class="col-md-4">
            <div class="user-list">
                <h5 class="p-3 bg-light border-bottom mb-0">Người dùng</h5>
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

            <form id="message-form" class="mt-3">
                @csrf
                <input type="hidden" id="receiver_id" name="receiver_id">
                <div class="input-group">
                    <input type="text" class="form-control message-input" id="message" name="message" 
                           placeholder="Nhập tin nhắn..." autocomplete="off">
                    <button type="submit" class="btn btn-primary send-button">Gửi</button>
                </div>
            </form>
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

    // Khởi tạo Pusher
    const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        encrypted: true
    });

    // Subscribe to channel for current user
    const channel = pusher.subscribe('chat.' + currentUserId);

    // Bind to the message.sent event
    channel.bind('message.sent', function(data) {
    console.log('Received message:', data);
    const message = data.message;
    
    // Bỏ qua nếu tin nhắn do chính người dùng gửi
    if (message.sender_id === currentUserId) {
        return;
    }

    if (selectedUserId && (message.sender_id === parseInt(selectedUserId) || message.receiver_id === parseInt(selectedUserId))) {
        // Tin nhắn từ cuộc trò chuyện hiện tại
        currentMessages.push(message);
        appendMessage(message);
        scrollToBottom();
    } else if (message.sender_id !== currentUserId) {
        // Tin nhắn từ người khác
        incrementUnreadCount(message.sender_id);
    }
});
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
    
    if (!selectedUserId || !message) return;

    // Tạo tin nhắn tạm thời với thuộc tính isTemp
    const tempMessage = {
        sender_id: currentUserId,
        receiver_id: parseInt(selectedUserId),
        message: message,
        created_at: new Date().toISOString(),
        isTemp: true // Đánh dấu là tin nhắn tạm thời
    };

    // Thêm vào danh sách tin nhắn và hiển thị
    currentMessages.push(tempMessage);
    appendMessage(tempMessage);
    scrollToBottom();
    messageInput.value = '';

    fetch('/chat/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            message: message,
            receiver_id: selectedUserId
        })
    })
    .then(res => {
        if (!res.ok) throw new Error('Network response was not ok');
        return res.json();
    })
    .then(msg => {
        // Tìm và thay thế tin nhắn tạm thời
        const index = currentMessages.findIndex(m => 
            m.isTemp && m.sender_id === currentUserId && m.message === message
        );
        if (index !== -1) {
            currentMessages[index] = msg; // Thay thế bằng tin nhắn từ server
            // Cập nhật giao diện
            const messagesDiv = document.getElementById('messages');
            const messageElements = messagesDiv.getElementsByClassName('message');
            if (messageElements[index]) {
                messageElements[index].innerHTML = msg.message;
            }
        } else {
            // Nếu không tìm thấy tin nhắn tạm thời, thêm mới (trường hợp hiếm)
            currentMessages.push(msg);
            appendMessage(msg);
            scrollToBottom();
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
    div.innerHTML = msg.message;
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
  </script>
@endsection
