$(document).ready(function(){
  $('.grid').masonry({
    // options
    itemSelector: '.card',
    // use element for option
    columnWidth: '.grid-sizer',
    gutter: '.gutter-sizer',
    percentPosition: true
  });
  $('.grid').imagesLoaded().progress( function() {
    $('.grid').masonry('layout');
  });
  $(".approve-and-publish-buttons").each(function(){
    $(this).on('click',function(){
      $.post("/CORE/ajax.php", { type: "publish_a_visual_2", visual_id: $(this).attr("data-visual-id"), text_id: $(this).attr("data-text-id")}, function(result){
        if (result.error) {
          console.log(result.error);
        }else{
          console.log(result);
          if(Cookies.get("PRIVILEGE")>1){
            setTimeout(function(){ 
              location.reload();
            }, 500);
          }else{
            setTimeout(function(){ window.location.replace("/Tlogin/"); }, 500);
          }
        }
      },"json");
      event.preventDefault();
    });
  });
  $(".take-down-button,.reject-buttons").each(function(){
    $(this).on('click',function(){
      $.post("/CORE/ajax.php", { type: "unpublish_a_visual", visual_id: $(this).attr("data-visual-id"), text_id: $(this).attr("data-text-id")}, function(result){
        if (result.error) {
          console.log(result.error);
        }else{
          console.log(result);
          if(Cookies.get("PRIVILEGE")>1){
            setTimeout(function(){ 
              location.reload();
            }, 500);
          }else{
            setTimeout(function(){ window.location.replace("/Tlogin/"); }, 500);
          }
        }
      },"json");
      event.preventDefault();
    });
  });
  // $(".approve-and-publish-buttons").each(function(){
  //   $(this).on('click',function(){
  //     $('#publishConfirmationContent').html('An email will be sent to Dr Caroline asking her to approve the visualisation before it can be seen by the world.<br>If you want the visualisation to be taken down at any point please speak to an Admin.');
  //     $("#publishConfirmationPublishButton").attr('data-visual-id',$(this).attr("data-visual-id"));
  //     $("#publishConfirmationPublishButton").attr('data-text-id',$(this).attr("data-text-id"));
  //     $('#publishConfirmation').modal();
  //   });
  // });
  // $("#publishConfirmationPublishButton").on('click',function(){
  //   $.post("/CORE/ajax.php", { type: "publish_a_visual_1", visual_id: $(this).attr("data-visual-id"), text_id: $(this).attr("data-text-id")}, function(result){
  //     if (result.error) {
  //       console.log(result.error);
  //       if(result.error.code == 066 || result.error.code == 054){
  //         $("#publishConfirmationContent").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
  //         $("#publishConfirmationPublishButton").html('Retry <i class="fa fa-user-plus" aria-hidden="true"></i>');
  //         $("#publishConfirmationPublishButton").addClass("btn-warning");
  //       }else{
  //         $("#publishConfirmationContent").append('<div class="row"><div class="col"><div class="alert alert-danger alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
  //         $("#publishConfirmationPublishButton").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
  //         $("#publishConfirmationPublishButton").addClass("btn-danger");
  //       }
  //     }else{
  //       console.log(result);
  //       $("#publishConfirmationPublishButton").html('Success <i class="fa fa-check" aria-hidden="true"></i>');
  //       $("#publishConfirmationPublishButton").removeClass("btn-warning");
  //       $("#publishConfirmationPublishButton").removeClass("btn-danger");
  //       $("#publishConfirmationPublishButton").addClass("btn-success");
  //       if(Cookies.get("PRIVILEGE")>1){
  //         setTimeout(function(){ window.location.replace("/Develop/DevelopManageVisuals/#"+$(this).attr("data-text-id")); }, 500);
  //       }else{
  //         setTimeout(function(){ window.location.replace("/Tlogin/"); }, 500);
  //       }
  //     }
  //   },"json");
  //   event.preventDefault();
  // });
});
