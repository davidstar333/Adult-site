/**
*@return return video player
*@author LongPham <long.it.stu@gmail.com>
**/

$('#video-like').hide();
$(document).on('click','a.viewVideo',function(e){
  e.preventDefault();
  var itemId = parseInt($(this).data('id'));
  var ownerId = parseInt($(this).data('owner'));
  console.log(itemId);
  if(typeof itemId === 'undefined' || isNaN(itemId)){
    return false;
  }
  $('#video-like a').attr('id','like_'+itemId+'_'+ownerId+'');// Add to like video Id
  $('#video-like .count_like').attr('id','count_'+itemId); // Add to count video Id
  var getVideoData = $.post(appSettings['BASE_URL']+'getvideo', { itemId: itemId } );
    getVideoData.done(function( data ) {
    if(data.success===true){
     $('#video-like').show();
     $('#count_'+itemId).html(data.totalLike);
       var player= jwplayer('video-player'); // Created new video player
       player.setup({
        width:'100%',
        height:'350px',
        aspectratio: '16:9',
        image: data.poster,
        sources: [{
          file: data.videoHD,
        },{
          file: data.videoSD,
        }]
      });
     }

   }).fail(function(data){
    alertify.error("Error!. " + data.responseJSON.message, '15')
  });
  
 });
/**
*@action like video
*@author LongPham <long.it.stu@gmail.com>
**/
$(document).ready(function(){
  $(document).on('click','a[id*="like_"]',function(e){
    e.preventDefault();

    var getElement = $(this).attr("id");

    var arrayElement = getElement.split('_');

    var itemId = arrayElement[1];

    var ownerId = arrayElement[2];

    var likeThis = $.post(appSettings['BASE_URL']+'like', { itemId: itemId , ownerId: ownerId } );

    likeThis.done(function( data ) {
      if(data.success===true){
        var totalLike = $('#count_'+itemId).html();
        $('#count_'+itemId).html(Number(totalLike)+1);
        alertify.success("Success!. " + data.message, '15')
      }else{
        alertify.success("Success!. " + data.message, '15')
      }
    }).fail(function(data){

      alertify.error("Error!. " + data.responseJSON.message, '15')

    });
  });
});
