// Start Scripts
$(document).ready(function () {
  
  $("input.check-all").change(function () {
    $("input.case:checkbox").prop('checked', $(this).prop("checked"));
  });
//gender register
  $('.btn-gender').click(function () {
//    console.log($('input[name=options]:checked').val());
    $('.btn-gender').removeClass('active');
    $(this).addClass('active');
  })

  $(document).on('click', '#checkForgotPassword', function (e) {
    if ($('#load-from-rest-pw').is(':hidden')) {
      $('#load-from-rest-pw').show('slow');
    } else {
      $('#load-from-rest-pw').hide('slow');
    }
  });

//check range limit
  $("input[type=range]").on('mousedown mousemove change', function (e) {
    //return false if not 0-9
    $(this).next('output').text($(this).val());
  });

  //reset password
  $(document).on('click', '#frm-reset-send', function (e) {
    var emailReset = $('#emailReset').val();
    $('#frm-reset-send').addClass('disabled');
    $.ajax({
      url: appSettings['BASE_URL'] + 'resetpassword',
      type: 'POST',
      data: {
        'emailReset': emailReset
      },
      success: function (data) {
        var error = data.message;
        $('#frm-reset-send').removeClass('disabled');
        if(data.success == true){
          $('#emailReset').val('');
          return alertify.success(data.message);
        }
        return alertify.error(data.message);
      }

    });
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

  var lastpage = 1;


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
          $("a[id*='follow_" + item_id + "']").empty().append('<i class="fa fa-heart"></i>');
          $(this).attr('style', '');
          alertify.success("Success!. " + data.message, '15')
        }
        if (data.disfollow == false && data.success == true) {
          $("a[id*='follow_" + item_id + "']").empty().append('<i style="color:red" class="fa fa-heart"></i>');
          alertify.success("Success!. " + data.message, '15')
        }
        if (data.disfollow == false && data.success == false) {
          alertify.error("Error!. " + data.message, '15')
        }
      }
    });

  });

  //Member Like
  $("[id*='modelLike_']").click(function (event) {
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
          $("a[id*='modelLike']").empty().append('Like');
          alertify.success("Success!. " + data.message, '15')
        }
        if (data.dislike == false && data.success == true) {
          $("a[id*='modelLike']").empty().append('Liked');
          alertify.success("Success!. " + data.message, '15')
        }
        if (data.dislike == false && data.success == false) {
          alertify.error("Error!. " + data.message, '15')
        }
      }
    });
  });
  //datetime filter
//  console.log($('#timePeriodEnd').val());
  $('#datepicker-1 .input-daterange').datetimepicker({
    format: 'YYYY-MM-DD',
    maxDate: ($('#timePeriodEnd').val()) ? $('#timePeriodEnd').val() : null,
    useCurrent: false
  });
  $('#datepicker-2 .input-daterange').datetimepicker({
    format: 'YYYY-MM-DD',
    minDate: ($('#timePeriodStart').val()) ? $('#timePeriodStart').val() : null,
    useCurrent: false //Important! See issue #1075
  });
  $("#datepicker-1 .input-daterange").on("dp.change", function (e) {
    
    $('#datepicker-2 .input-daterange').data("DateTimePicker").minDate(e.date);


  });
  $("#datepicker-2 .input-daterange").on("dp.change", function (e) {

    $("#datepicker-1 .input-daterange").data("DateTimePicker").maxDate(e.date);
  });

});
function getProfileImage(avatar) {
  if (avatar) {
    return appSettings['BASE_URL'] + avatar;
  } else {
    return appSettings['BASE_URL'] + 'images/noimage.png';
  }
}
function goOnlinePopup() {
  window.open(appSettings['BASE_URL'] + 'models/go-online-popup', "_blank", "toolbar=no, scrollbars=yes, resizable=yes, top=0, left=100, width=1100, height=600");
}

$(document).ready(function ()
{
  var enableLoadMoreFeed = true;
  function lastFeedfuntion()
  {

    var ID = $(".feed-scroll-item:last").attr("id");
    var sort = 'desc';
    var orderBy = 'createdAt';
    if (ID && $('.feed-scroll-item').length >= appSettings.LIMIT_PER_PAGE) {
      var id_split = ID.split('-block-');
      var feedId = id_split[1];
//    $('div#last_msg_loader').html('<img src="bigLoader.gif">');
      $.get(appSettings['BASE_URL'] + "api/v1/feed/loadmore/" + feedId + '?sort=' + sort + '&orderBy=' + orderBy,
              function (data) {
                if (data) {
                  $(".feed-scroll-item:last").after(data);
                } else {
                  enableLoadMoreFeed = false;
                }
//              $('div#last_msg_loader').empty();
              });
    }
  }
  ;

  $(window).scroll(function () {
    if ($(window).scrollTop() == $(document).height() - $(window).height() && enableLoadMoreFeed) {
      lastFeedfuntion();
    }
  });

  // Payment Candies
  $(document).on('click', '#paymentCandies1', function (e) {
    e.preventDefault();
    var kiss = $(this).attr('kiss');
    var paymentOption = $(this).attr('value');
    window.location.href = "https://bill.ccbill.com/jpost/signup.cgi?clientAccnum=948332&clientSubacc=0000&formName=201cc&language=English&allowedTypes=" + paymentOption + "&subscriptionTypeId=0000005167:840&userid=" + appSettings.USER.id + "&tokens=" + kiss + "&paymentType=tokens";
  });

  $(document).on('click', '#paymentCandies2', function (e) {
    e.preventDefault();
    var kiss = $(this).attr('kiss');
    var paymentOption = $(this).attr('value');
    window.location.href = "https://bill.ccbill.com/jpost/signup.cgi?clientAccnum=948332&clientSubacc=0000&formName=201cc&language=English&allowedTypes=" + paymentOption + "&subscriptionTypeId=0000005167:840&userid=" + appSettings.USER.id + "&tokens=" + kiss + "&paymentType=tokens";
  });

  $(document).on('click', '#paymentCandies3', function (e) {
    e.preventDefault();
    var kiss = $(this).attr('kiss');
    var paymentOption = $(this).attr('value');
    window.location.href = "https://bill.ccbill.com/jpost/signup.cgi?clientAccnum=948332&clientSubacc=0000&formName=201cc&language=English&allowedTypes=" + paymentOption + "&subscriptionTypeId=0000005167:840&userid=" + appSettings.USER.id + "&tokens=" + kiss + "&paymentType=tokens";
  });

  $(document).on('click', '#paymentCandies4', function (e) {
    e.preventDefault();
    var kiss = $(this).attr('kiss');
    var paymentOption = $(this).attr('value');
    window.location.href = "https://bill.ccbill.com/jpost/signup.cgi?clientAccnum=948332&clientSubacc=0000&formName=201cc&language=English&allowedTypes=" + paymentOption + "&subscriptionTypeId=0000005167:840&userid=" + appSettings.USER.id + "&tokens=" + kiss + "&paymentType=tokens";
  });

  //Gallery Paid
  $(document).on('click', 'a[id*="galleryPaid_"]', function (e) {
    e.preventDefault();
    var el = $(this);
    var Paid = $(this).attr("id");
    var arraySplit = Paid.split('_');
    var galleryId = arraySplit[1];
    var paymentItem = arraySplit[2];
    var paidToId = arraySplit[3];
    var paidPrice = arraySplit[4];
    alertify.confirm("Gallery must be purchased to watch. Do you want to purchase " + paidPrice + " tokens?", function (e) {
      if (e) {
        $.ajax({
          url: appSettings['BASE_URL'] + 'paidgallery',
          type: 'POST',
          data: {
            'galleryId': galleryId,
            'paymentItem': paymentItem,
            'paidToId': paidToId,
            'paidPrice': paidPrice,
          },
          success: function (data) {
            if (data.success == true) {
              el.removeAttr('id');
              alertify.success("Success!. " + data.message, '15')

            }
            if (data.success == false) {
              alertify.error("Error!. " + data.message, '15')
            }
          }
        })
      }
    }).setHeader('<em>purchased Gallery Confirm </em> ');

  });

  $('#modelName').keyup(function (e) {
    e.preventDefault();
    var keyword = $(this).val();
    if (keyword != '') {
      $.get(appSettings['BASE_URL'] + 'searchmodel?modelname=' + keyword, function (data) {
        $('#displayModelName').empty().html(data).fadeIn('fast');
      }).fail(function (data) {
        if (data.success == false) {
          alertify.error("Error!. " + data.message, '15')
        }
      })
      // $.ajax({
      //   url:appSettings['BASE_URL']+'searchmodel?modelname='+keyword,
      //   success:function(data){
      //     $('#displayModelName').empty().html(data).fadeIn('fast');
      //   }
      // })
    } else {
      $('#displayModelName').empty()
    }

  })
  $(document).on('click', '.insertThis', function (e) {
    e.preventDefault();
    $('#modelName').val($(this).attr('modelName'));
    $('#displayModelName').fadeOut('fast');
  })

  $('#autocomplete_newthread_username').keyup(function (e) {
    e.preventDefault();
    var keyword = $(this).val();
    if (keyword != '') {
      $.ajax({
        url: appSettings['BASE_URL'] + 'searchmodel?modelname=' + keyword,
        success: function (data) {
          $('#displayModelName').empty().html(data).fadeIn('fast');
        }
      })
    } else {
      $('#displayModelName').empty()
    }
  })
  $(document).on('click', '.insertThis', function (e) {
    e.preventDefault();
    $('#autocomplete_newthread_username').val($(this).attr('modelName'));
    $('#displayModelName').fadeOut('fast');
  })

  /**
   @Sent tip offline
   @return amount tip
   */
  $('#tipamount').keyup(function (e) {
    e.preventDefault();
    var amountVal = $(this).val();
    if (amountVal === '') {
      $('#memberTipAmount').text('0');
    } else {
      $('#memberTipAmount').text(amountVal);
    }

  });

  $('input#selectBirthDate').datetimepicker({
    format: 'YYYY-MM-DD',
    maxDate: new Date(),
    useCurrent: false
  });


});

//End Script

$(document).ready(function () {
  $(document).on('click', '#model-profile-menu button', function (e) {
    $('#model-profile-menu ul').toggle("slow", function () {

    });
  });
});
function deleteAllMessage(type) {
  var messages = [];
  $('input.case:checkbox:checked').each(function (index) {
    messages.push($(this).val());
  });
  if (messages.length == 0) {
    alertify.error('Please, select at least 1 item.');
    return false;
  }

  alertify.confirm('Are you sure you want to delete message this?',
          function () {
            $.ajax({
              type: 'delete',
              url: appSettings.BASE_URL + 'api/v1/messages/delete/' + type,
              data: {'ids': messages},
              success: function (data) {
                if (data.success) {
                  for (var index in messages) {
                      
                    $('table.messages tr#message-' + messages[index]).remove();
                  }
                  alertify.success(data.message);
                  return window.location.reload();

                }else{
                    alertify.error(data.error);
                }
              }
            });
          }).set('title', 'Confirm');
}
function setFavorite(modelId, id) {
  $.ajax({
    type: 'post',
    url: appSettings.BASE_URL + 'api/v1/user/favorite',
    data: {'model': modelId},
    success: function (data) {

      if (data.success) {
//        console.log(data);
        $('li#model-' + id).remove();

      } else {
        alertify.error(data.error);
      }
    }
  });
}
function confirmDeleteModel(url) {
  alertify.confirm('Are you sure you want to delete this model?',
          function () {
            window.location.href = url;
          }).set('title', 'Confirm');
}
function addModelFavorite(id) {
  $.ajax({
    type: 'post',
    url: appSettings.BASE_URL + 'api/v1/user/favorite',
    data: {'model': id},
    success: function (data) {

      if (data.success) {
        if (data.favorite == 'like') {
          $('.top-detial a i.fa-heart').addClass('fa-red');
        } else {
          $('.top-detial a i.fa-heart').removeClass('fa-red');
        }
      } else {
        alertify.error(data.message);
      }
    }
  });
}
//buy an item
function buyItem(id, item) {
  alertify.confirm("Are you sure you want to buy this?", function (e) {
    if (e) {
      $.ajax({
        url: appSettings.BASE_URL + 'api/v1/buy-item',
        type: 'post',
        data: {
          id: id,
          item: item
        },
        success: function (data) {
          if (!data.success) {
            alertify.alert('Warning', data.message);
          } else {
            alertify.success(data.message);
            window.location.href = data.url;
          }
        }
      });
    }
  }).setHeader('<em> Confirm </em> ');

}
function showPreview(src) {
  $('#previewModel .modal-body').html('<img src="' + src + '" class="img-responsive">');
}
$('.image-galleries .thumbnail').hover(
        function () {
          $(this).find('.caption').slideDown(250); //.fadeIn(250)
        },
        function () {
          $(this).find('.caption').slideUp(250); //.fadeOut(205)
        }
);
jssor_1_slider_init = function () {

  var jssor_1_options = {
    $AutoPlay: false,
    $ArrowNavigatorOptions: {
      $Class: $JssorArrowNavigator$
    },
    $ThumbnailNavigatorOptions: {
      $Class: $JssorThumbnailNavigator$,
      $Cols: 4,
      $SpacingX: 4,
      $SpacingY: 4,
      $Orientation: 2,
      $Align: 0
    }
  };

  var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

  //responsive code begin
  //you can remove responsive code if you don't want the slider scales while window resizing
  function ScaleSlider() {
    var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
    if (refSize) {
      refSize = Math.min(refSize, 810);
      jssor_1_slider.$ScaleWidth(refSize);
    }
    else {
      window.setTimeout(ScaleSlider, 30);
    }
  }
  ScaleSlider();
  $Jssor$.$AddEvent(window, "load", ScaleSlider);
  $Jssor$.$AddEvent(window, "resize", ScaleSlider);
  $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
  //responsive code end
};
if ($('#previewModel').length > 0) {
  jssor_1_slider_init();
}
if($('#modelsearch').length > 0){
    var options = {
            url: function(phrase) {
                    return appSettings.BASE_URL+ "api/v1/search/member?phrase=" + phrase + "&format=json";
            },

            getValue: "name",
            getKey: "key",
            placeholder: 'Name'

    };

    $("#modelsearch").easyAutocomplete(options);
}
var KEYS = {
    backspace: 8,
    tab: 9,
    enter: 13,
    escape: 27,
    space: 32,
    up: 38,
    down: 40,
    left: 37,
    right: 39,
    delete: 46,
    comma: 188
};
if($('input#tagsinput').length > 0){
    $('input#tagsinput').tagsinput({
      maxTags: 5,
      trimValue: true,
      focusClass: 'my-focus-class',
      confirmKeys: [KEYS.enter, KEYS.comma, KEYS.space, KEYS.backspace, KEYS.delete, KEYS.left, KEYS.right]
    });
}
function filterGridForm(){
  $(".payment-list > form").attr('method', 'get').submit();
}