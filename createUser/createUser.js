  $(document).ready(function(){
    $( "#create_a_user_submit" ).on("click",function( event ) {
      // console.log("clicked");
      full_name_TBS = $("#full_name").val().trim();
      school_id_TBS = $("#school_id").val().toLowerCase().trim();
      password_TBS = $("#password").val();
      // console.log(full_name_TBS,school_id_TBS,password_TBS);
      if(full_name_TBS.match("^[A-z\\'\\-]+(\\s[A-z\\'\\-]+){1,3}$") === null || school_id_TBS.match("^([a-z]{1,3}[0-9]{1,6})|([a-z]{4,10})$") === null ){
        $("#create_a_user").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>: ( Invalid Input.</div></div></div>');
        $("#create_a_user_submit").html('Retry <i class="fa fa-user-plus" aria-hidden="true"></i>');
        $("#create_a_user_submit").addClass("btn-warning");
      }else{
        $.post("/CORE/ajax.php", { type: "create_a_user", school_id: school_id_TBS, full_name: full_name_TBS, privilege: $("#privilege").val(), password: password_TBS}, function(result){
            if (result.error) {
              console.log(result.error);
              if(result.error.code == "013"){
                $("#create_a_user").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+',<a href="/Tlogin/">Login</a></div></div></div>');
                $("#create_a_user_submit").html('Retry <i class="fa fa-user-plus" aria-hidden="true"></i>');
                $("#create_a_user_submit").addClass("btn-warning");
              }else{
                $("#create_a_user").append('<div class="row"><div class="col"><div class="alert alert-danger alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
                $("#create_a_user_submit").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
                $("#create_a_user_submit").addClass("btn-danger");
              }
            }else{
              console.log(result.success);
              $("#create_a_user_submit").html('Success <i class="fa fa-check" aria-hidden="true"></i>');
              $("#create_a_user_submit").removeClass("btn-warning");
              $("#create_a_user_submit").removeClass("btn-danger");
              $("#create_a_user_submit").addClass("btn-success");
              if(Cookies.get("PRIVILEGE")>1){
                setTimeout(function(){ window.location.reload(); }, 500);
              }else{
                setTimeout(function(){ window.location.replace("/Tlogin/"); }, 500);
              }
            }
        },"json");
      }
      event.preventDefault();
    });
  });