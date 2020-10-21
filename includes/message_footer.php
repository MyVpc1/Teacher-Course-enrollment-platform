<script>
$('.search > input').on('keyup', function() {
  var rex = new RegExp($(this).val(), 'i');
    $('.people .person').hide();
    $('.people .person').filter(function() {
        return rex.test($(this).text());
    }).show();
});

$(window).on('load', function(event) {
    if ($(this).hasClass('.active')) {
        return false;
    } else {
        var findChat = "person6";
        var personName = "<?php echo $_GET['getMessages']; ?>";
        var personImage = $(this).find('img').attr('src');
        var hideTheNonSelectedContent = $(this).parents('.chat-system').find('.chat-box .chat-not-selected').hide();
        var showChatInnerContent = $(this).parents('.chat-system').find('.chat-box .chat-box-inner').show();

        if (window.innerWidth <= 767) {
          $('.chat-box .current-chat-user-name .name').html(personName.split(' ')[0]);
        } else if (window.innerWidth > 767) {
          $('.chat-box .current-chat-user-name .name').html(personName);
        }
        $('.chat-box .current-chat-user-name img').attr('src', personImage);
        $('.chat').removeClass('active-chat');
        $('.user-list-box .person').removeClass('active');
        $('.chat-box .chat-box-inner').css('height', '100%');
        $(this).addClass('active');
        $('.chat[data-chat = '+findChat+']').addClass('active-chat');
    }
    if ($(this).parents('.user-list-box').hasClass('user-list-box-show')) {
      $(this).parents('.user-list-box').removeClass('user-list-box-show');
    }
    $('.chat-meta-user').addClass('chat-active');
    $('.chat-box').css('height', 'calc(100vh - 30px)');
    $('.chat-footer').addClass('chat-active');

  $(".chat-conversation-box").animate({ scrollTop: $(".chat").height() }, 1000);
});

$('.mail-write-box').on('keydown', function(event) {
    if(event.key === 'Enter') {
        var chatInput = $(this);
        var chatMessageValue = chatInput.val();
        if (chatMessageValue === '') { return; }
        $messageHtml = '<div class="bubble me">' + chatMessageValue + '</div>';
        var appendMessage = $(this).parents('.chat-system').find('.active-chat').append($messageHtml);
        var clearChatInput = chatInput.val('');
        $(".chat-conversation-box").animate({ scrollTop: $(".chat").height() }, 1000);
            $.ajax({
              url     : "https://fyores.com/ajax/message_request.php",
              method  : "GET",
              data    : {getMessages: chatMessageValue, toMsg: "<?php echo $user_id; ?>"},
              success : function(data){
                  
              }
            });
    }
});
    
var timeout = setInterval(reloadChat, 1000);    
function reloadChat()
{
    $.ajax({
          url     : "https://fyores.com/ajax/message_request.php",
          method  : "GET",
          data    : {byMsg: "<?php echo $user_id; ?>"},
          success : function(data){
              if(data){
                  $(".chat-conversation-box").animate({ scrollTop: $(".chat").height() }, 1000);
                  $('.chat').append(data);
              }   
          }
        });
}
</script>