@extends('master')
@section('content')
<div id="chat-box">
    <h4>Hỗ trợ khách hàng</h4>
    <div class="chat">
        <div id="messages">
            @foreach ($messages as $msg)
                <div class="{{ $msg->sender_id == Auth::id() ? 'admin' : 'user' }}">
                    {{ $msg->message }}
                </div>
            @endforeach
        </div>
        <br>
        <input type="text" id="message-input" placeholder="Nhập tin nhắn...">
        <button onclick="sendMessage()">Gửi</button>
        <button onclick="closeChat()">Đóng</button>
    </div>
</div>
@endsection