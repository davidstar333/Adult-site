// Start Scripts
$(document).ready(function () {
//gender register
  $(document).on('keypress', 'input.enter-comment-form', function (event) {
    if (event.which == 13 && this.value != '') {

      var message = this.value;
      var item = $(this).attr('item');
      var itemId = $(this).attr('item-id');
      var parent = $(this).attr('parent');
      $.ajax({
        url: appSettings['BASE_URL'] + 'api/v1/comments/addNew',
        type: 'POST',
        data: {
          itemId: itemId,
          comment: message,
          parent_id: parent,
          item: item
        },
        success: function (data) {
          $('.enter-comment-form').val('');
          var avatar = getProfileImage(data.avatar);
          $('#parent-comment-box-' + parent).prepend('<li class="comment" id="comment-box-' + data.commentId + '" comment-id="' + data.commentId + '"><a class="pull-left"><img class="avatar" src="' + avatar + '" alt="avatar"></a><div class="comment-body"><div class="comment-heading"><h4 class="user">Me</h4><h5 class="time">' + data.createdAt + '</h5></div><p>' + data.text + '</p></div></li>');
        }

      });
    }

  });
  $(document).on('click', '.like-this-box', function (e) {
    var itemId = $(this).attr('item-id');
    var item = $(this).attr('item');
    var status = $(this).attr('liked');
    $.ajax({
      url: appSettings['BASE_URL'] + 'api/v1/likes/likeMe',
      type: 'POST',
      data: {
        item: item,
        itemId: itemId,
        status: status
      },
      success: function (data) {
        if (data.status == 'error') {
          alertify.alert(data.message);
          return false;
        }
        var liked = (data.status == 'like') ? 'Unlike' : 'like';
        $('#like-thumb-' + itemId).find('span').text(liked);
        $.get(appSettings['BASE_URL'] + 'api/v1/likes/count?itemId=' + itemId + '&item=' + item, function (data) {
          $('#total-likes-' + itemId).text(data);
        });
      }

    });
  });
  $(document).on('click', '.show-comment-box', function (e) {
    $(this).addClass('hidden');
    var parent = $(this).attr('parent');
    var itemId = $(this).attr('item-id');
    var item = $(this).attr('item');
    //$('.reply-enter-box').addClass('hidden');
    $(this).parent().find('.reply-enter-box').removeClass('hidden');
    $.get(appSettings['BASE_URL'] + 'api/v1/comments/subComments?parentId=' + parent + '&itemId=' + itemId + '&item=' + item + '&orderBy=createdAt' + '&sort=desc', function (data) {
      for (var i in data.data) {
        var avatar = getProfileImage(data.data[i].avatar);
        $('#parent-comment-box-' + parent).prepend('<li class="comment" id="comment-box-' + data.data[i].commentId + '" comment-id="' + data.data[i].commentId + '"><a class="pull-left"><img class="avatar" src="' + avatar + '" alt="avatar"></a><div class="comment-body"><div class="comment-heading"><h4 class="user">Me</h4><h5 class="time">' + data.data[i].createdAt + '</h5></div><p>' + data.data[i].text + '</p></div></li>');
      }
    });
  });
  var lastpage = 1;
  $(document).on('click', '.load-more-comment-box', function (e) {
    var itemId = $(this).attr('item-id');
    var parent = $(this).attr('parent');
    var limit = 10;
    var item = $(this).attr('item');
    lastpage += 1;
//    

    $.get(appSettings['BASE_URL'] + 'api/v1/comments/findAll?itemId=' + itemId + '&item=' + item + '&page=' + lastpage + '&orderBy=createdAt&sort=desc&limit=10', function (data) {
      if (data.last_page <= lastpage) {
        $('.load-more-comment-box').addClass('hidden');
      }
      for (var i in data.data) {
        var avatar = getProfileImage(data.data[i].avatar);
        $('#parent-comment-box-0').prepend('<li class="comment" id="comment-box-' + data.data[i].commentId + '" comment-id="' + data.data[i].commentId + '"><a class="pull-left"><img class="avatar" src="' + avatar + '" alt="avatar"></a><div class="comment-body"><div class="comment-heading"><h4 class="user">Me</h4><h5 class="time">' + data.data[i].createdAt + '</h5></div><p>' + data.data[i].text + '</p></div></li>');
      }
    });
  });
  //Delete feed
  $(document).on('click', "[id*='feed-delete-']", function (event) {
    event.preventDefault();
    var feed_id = $(this).attr("id");
    var id_split = feed_id.split('-');
    var id = id_split[2];

    alertify.confirm( "Are you sure you want to delete this?", function (e) {
      if (e) {
        $.ajax({
          url: appSettings['BASE_URL'] + 'api/v1/feed/delete/' + id,
          type: 'DELETE',
          success: function (data) {
            if (data) {
              $('#feed-block-' + id).remove();
              alertify.success('Feed removed.');

            }
          }
        });
      }
    }).setHeader('<em> Confirm </em> ');
  });
  //Delete comment
  $("[id*='delete-comment-']").click(function (event) {
    event.preventDefault();
    var comment_id = $(this).attr("id");
    var id_split = comment_id.split('-');
    var id = id_split[2];

    alertify.confirm("Are you sure you want to delete this comment?", function (e) {
      if (e) {
        $.ajax({
          url: appSettings['BASE_URL'] + 'api/v1/comment/delete/' + id,
          type: 'DELETE',
          success: function (data) {
            if (data) {
              $('#comment-box-' + id).remove();
              alertify.success('Comment removed.');
            }
          }
        });
      }
    });
  });

  //Member follow
  $("[id*='follow_']").click(function (event) {
    event.preventDefault();
    var follow_id = $(this).attr("id");
    var id_split = follow_id.split('_');
    var follow = id_split[0];
    var item_id = id_split[1];

    $.ajax({
      url: appSettings['BASE_URL'] + 'members/follow',
      type: 'POST',
      data: {
        'type': follow,
        'item': item_id,
      }, success: function (data) {
        if (data.disfollow == true && data.success == true) {
          $("a[id*='follow_']").empty().append('Follow');
          alertify.success("Success!. " + data.message, '15')
        }
        if (data.disfollow == false && data.success == true) {
          $("a[id*='follow_']").empty().append('Followed');
          alertify.success("Success!. " + data.message, '15')
        }
        if (data.disfollow == false && data.success == false) {
          alertify.error("Error!. " + data.message, '15')
        }
      }
    });
  });

  //Member Like
  $("[id*='like_']").click(function (event) {
    event.preventDefault();
    var like_id = $(this).attr("id");
    var id_split = like_id.split('_');
    var like = id_split[0];
    var item_id = id_split[1];

    $.ajax({
      url: appSettings['BASE_URL'] + 'members/like',
      type: 'POST',
      data: {
        'type': like,
        'item': item_id,
      }, success: function (data) {
        if (data.dislike == true && data.success == true) {
          $("a[id*='like_']").empty().append('Like');
          alertify.success("Success!. " + data.message, '15')
        }
        if (data.dislike == false && data.success == true) {
          $("a[id*='like_']").empty().append('Liked');
          alertify.success("Success!. " + data.message, '15')
        }
        if (data.dislike == false && data.success == false) {
          alertify.error("Error!. " + data.message, '15')
        }
      }
    });
  });
});
function getProfileImage(avatar) {
  if (avatar) {
    return appSettings['BASE_URL'] + 'images/upload/member/' + avatar;
  } else {
    return appSettings['BASE_URL'] + 'images/noimage.png';
  }
}
function goOnlinePopup() {
  window.open(appSettings['BASE_URL'] + 'models/go-online-popup', "_blank", "toolbar=no, scrollbars=yes, resizable=yes, top=0, left=100, width=1100, height=600");
}
//End Script