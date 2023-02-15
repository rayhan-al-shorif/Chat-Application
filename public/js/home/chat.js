var newMessage = '';
var currentUserId = $('#currentUserId').val();
$(document).ready(function () {
    handleGetMessage();
    handleActiveChat();
    handleSendMessage();
    pusher();
    handleUserSelect();
    others();
    handleOnlineOrOffline();
});

function handleUserSelect(){
    new TomSelect("#recipient-user",{
    allowEmptyOption: false,
    create: false,
    });
}
function handleActiveChat(){
    $('.chat_list').on('click', function(){
        $('.chat_list').removeClass('active_chat');
        $(this).addClass('active_chat');
        handleGetMessage();
        let userName = $(this).find('.chat_ib h5').html();
        userName = userName.replace(/<span[^>]*>([^<]+)<\/span>/g, '');
        userName = userName.replace(/\s+$/, '');
        let id = $(this).attr('id');
        checkUserActiveStatus(userName, id);
        others();
    });
}

function handleSendMessage(){
    $(".write_msg").on("keyup", function(e) {
            if (e.keyCode == 13) {
                $('.msg_send_btn').click();
            }
    });
    $('.msg_send_btn').on('click', function(){
        var message = $('.write_msg').val();
        if(message != ''){
            $('.msg_history').append(`
                <div class="outgoing_msg">
                    <div class="sent_msg">
                        <p>${message}</p>
                        <span class="time_date">Today</span>
                    </div>
                </div>
            `);
            $('.write_msg').val('');
            axios.post('/send-message', {
                message: message,
                to: $('.active_chat').attr('id')
            }).then(function (response) {
                $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
            });
        }else{
           toastr.danger('Please type a message');
        }
    });
    $('.sendMsg').on('click', function(){
        var message = $('#message-text').val();
        if(message != ''){
            axios.post('/send-message', {
                message: message,
                to: $('#recipient-user').val()
            }).then(function (response) {
                location.reload();
            });
        }else{
           toastr.danger('Please type a message');
        }
    });
}
function pusher(){
    var pusher = new Pusher('4a1deb97c499118feee8', {
    cluster: 'ap2'
    });
    var channel = pusher.subscribe('my-channel');
    var eventName = "my-event";
    channel.bind(eventName, function (data) {
        let {from, to, message} = data.message;
        if(to == currentUserId){
            appendIncomingMessage(message);
        }
    });
}
function handleGetMessage(){
    $('.msg_history').html('');
    let toId = $(".active_chat").attr('id');
    axios.get(`get-message/${toId}`)
        .then(function (response) {
            response.data.messages.map(function (message) {
                if(message.from == currentUserId){
                    appendOutgoingMessage(message.message);
                }else{
                    appendIncomingMessage(message.message);
                }
            });
        });
}
function appendIncomingMessage(message){
    message = messageLineBreak(message);
    $('.msg_history').append(`
        <div class="incoming_msg">
            <div class="received_msg">
                <div class="received_withd_msg">
                    <p>${message}</p>
                    <span class="time_date">Today</span>
                </div>
            </div>
            <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png"
                    alt="sunil"> </div>
        </div>
    `);
    $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
}
function appendOutgoingMessage(message){
    message = messageLineBreak(message);
    $('.msg_history').append(`
        <div class="outgoing_msg">
            <div class="sent_msg">
                <p>${message}</p>
                <span class="time_date">Today</span>
            </div>
        </div>
    `);
    $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
}


function messageLineBreak(message){
    let length = message.length;
    let newMessage = '';
    if(length > 35){
        let newLength = parseInt(length / 35);
        for (let index = 0; index < newLength+1; index++) {
            let start = index * 35;
            let end = (index+1) * 35;
            if(index == 0){
                newMessage = message.substr(start, end);
            }else{
                newMessage = newMessage + ' ' + message.substr(start, end);
            }
        }
    }else{
        newMessage = message;
    }
    return newMessage;
}


function checkUserActiveStatus(userName, id){
    axios.get(`/check-user-active-status/${id}`)
        .then(function (response) {
           var status = response.data.status;
           let getStatus = status == 1 ? '<span class="text-white online">online</span>' : '<span class="text-secondary offline">offline</span>';
           let html = `<span>${userName}</span> <span class="font-weight-bold">${getStatus}</span>`;
            $('.msg_user_info h5').html(html);
        });
}


function others() {
    $('.msg_history').html("&nbsp;");
}


function handleOnlineOrOffline() {
    setInterval(function () {
        $('.online').toggleClass('text-white');
     }, 700);
}
