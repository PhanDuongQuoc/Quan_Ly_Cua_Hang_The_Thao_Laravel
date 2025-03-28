<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Cửa hàng chuyên cung cấp đồ thể thao Future CEO Sport </title>
	<base href="{{asset('')}}">
	<link href='http://fonts.googleapis.com/css?family=Dosis:300,400' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="source/assets/dest/css/font-awesome.min.css">
	<link rel="stylesheet" href="source/assets/dest/vendors/colorbox/example3/colorbox.css">
	<link rel="stylesheet" href="source/assets/dest/rs-plugin/css/settings.css">
	<link rel="stylesheet" href="source/assets/dest/rs-plugin/css/responsive.css">
	<link rel="stylesheet" href="source/assets/dest/css/style.css">
	<link rel="stylesheet" href="source/assets/dest/css/animate.css">
	<link rel="stylesheet" title="style" href="source/assets/dest/css/huong-style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body>

    @include('header')
	<div class="rev-slider">
        @yield('content')
    
			
	</div> <!-- .container -->
    @include('footer')
	@include('contact')

	<div id="chat-box">
    <h4>Hỗ trợ khách hàng</h4>
    <div class="chat">
        <div id="messages">
            
        </div>
        <br>
        <input type="text" id="message-input" placeholder="Nhập tin nhắn...">
        <button onclick="sendMessage()">Gửi</button>
    </div>
</div>




	<!-- include js files -->
	<script src="source/assets/dest/js/jquery.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="source/assets/dest/vendors/jqueryui/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
	<script src="source/assets/dest/vendors/bxslider/jquery.bxslider.min.js"></script>
	<script src="source/assets/dest/vendors/colorbox/jquery.colorbox-min.js"></script>
	<script src="source/assets/dest/vendors/animo/Animo.js"></script>
	<script src="source/assets/dest/vendors/dug/dug.js"></script>
	<script src="source/assets/dest/js/scripts.min.js"></script>
	<script src="source/assets/dest/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
	<script src="source/assets/dest/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
	<script src="source/assets/dest/js/waypoints.min.js"></script>
	<script src="source/assets/dest/js/wow.min.js"></script>
	<!--customjs-->
	<script src="source/assets/dest/js/custom2.js"></script>
	<script>
		$(document).ready(function($) {    
			$(window).scroll(function(){
				if($(this).scrollTop()>150){
				$(".header-bottom").addClass('fixNav')
				}else{
					$(".header-bottom").removeClass('fixNav')
				}}
			)
		});

		let receiverId = null;
		function toggleChat() {
			var chatBox = document.getElementById("chat-box");
			if (chatBox.style.display === "none") {
				chatBox.style.display = "block";
			} else {
				chatBox.style.display = "none";
			}
		}

		async function loadMessages() {
		if (!receiverId) {
			console.error("Không có receiverId, không thể tải tin nhắn!");
			return;
		}

		try {
			let response = await fetch(`/messages/${receiverId}`, { method: "GET" });

			if (!response.ok) {
				throw new Error(`Lỗi HTTP: ${response.status}`);
			}

			let messages = await response.json();
			let messageBox = document.getElementById("messages");
			messageBox.innerHTML = ""; // Xóa nội dung cũ trước khi load mới

			messages.forEach(msg => {
				let messageDiv = document.createElement("div");
				messageDiv.classList.add(msg.sender_id == receiverId ? "user-message" : "admin-message");
				messageDiv.textContent = msg.message;
				messageBox.appendChild(messageDiv);
			});

			messageBox.scrollTop = messageBox.scrollHeight;
		} catch (error) {
			console.error("Lỗi khi tải tin nhắn:", error);
		}
	}

	

	</script>
</body>
</html>
