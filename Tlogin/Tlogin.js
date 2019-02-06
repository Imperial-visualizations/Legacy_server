$.urlParam = function(name){
  var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
  return ((results==null)?0:results[1]);
}
  $(document).ready(function(){
    $( "#log_in_submit" ).on("click",function( event ) {
      school_id_TBS = $("#school_id").val().toLowerCase().trim();
      password_TBS = $("#password").val();
      if(school_id_TBS.match("^([a-z]{1,3}[0-9]{1,6})|([a-z]{4,10})$") === null ){
        $("#log_in").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Invalid Input.</div></div></div>');
        $("#log_in_submit").html('Retry <i class="fa fa-user-plus" aria-hidden="true"></i>');
        $("#log_in_submit").addClass("btn-warning");
      }else{
        $.post("../CORE/ajax.php", { type: "log_in", school_id: school_id_TBS, password: password_TBS}, function(result){
            if (result.error) {
              console.log(result.error);
              if(result.error.code == 023){
                $("#log_in").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
                $("#log_in_submit").html('Retry <i class="fa fa-user-plus" aria-hidden="true"></i>');
				$("#log_in_submit").removeClass("btn-primary");
				$("#log_in_submit").removeClass("btn-danger");
                $("#log_in_submit").addClass("btn-warning");
              }else{
                $("#log_in").append('<div class="row"><div class="col"><div class="alert alert-danger alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
                $("#log_in_submit").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
				$("#log_in_submit").removeClass("btn-primary");
				$("#log_in_submit").removeClass("btn-warning");
                $("#log_in_submit").addClass("btn-danger");
              }
            }else{
              console.log(result.success);
              $("#log_in_submit").removeClass("btn-primary");
              $("#log_in_submit").removeClass("btn-warning");
              $("#log_in_submit").removeClass("btn-danger");
              $("#log_in_submit").addClass("btn-success");
              $("#log_in_submit").html('Success <i class="fa fa-check" aria-hidden="true"></i>');
              if($.urlParam('from') == 0){
                setTimeout(function(){ window.location.replace("../developers.php"); }, 500);
              }else{
                setTimeout(function(){ window.location.replace(decodeURIComponent($.urlParam('from'))); }, 500);
              }
              
            }
        },"json");
      }
      event.preventDefault();
    });
  });