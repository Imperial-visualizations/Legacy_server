$(document).ready(function(){
  $("#school_id").on('keyup',function(){
    school_id_TBS = $(this).val().toLowerCase().trim();
    if(school_id_TBS.match("^([a-z]{1,3}[0-9]{1,6})|([a-z]{4,10})$") === null){
      $("#school_id_feedback").removeClass("text-success");
      $("#school_id_feedback").addClass("text-warning");
      $("#school_id_feedback").text("Invalid format. It has to be something similar to 'ab1234'");
    }else{
      $.post("/CORE/ajax.php", { type: "get_user_info", school_id: school_id_TBS}, function(result){
          if (result.error) {
            if(result.error.code == 093){
              $("#school_id_feedback").removeClass("text-warning");
              $("#school_id_feedback").removeClass("text-danger");
              $("#school_id_feedback").addClass("text-success");
              $("#school_id_feedback").text("This ID can be used.");
            }else{
              console.log(result.error);
              $("#school_id_feedback").removeClass("text-success");
              $("#school_id_feedback").removeClass("text-warning");
              $("#school_id_feedback").addClass("text-danger");
              $("#school_id_feedback").text("Unknow Error");
            }
          }else{
              $("#school_id_feedback").removeClass("text-success");
              $("#school_id_feedback").removeClass("text-warning");
              $("#school_id_feedback").addClass("text-danger");
              $("#school_id_feedback").text(result.success.message);
          }
      },"json");
    }
  });
    $( "#create_a_user_submit" ).on("click",function( event ) {
      console.log("clicked");
      full_name_TBS = $("#full_name").val().trim();
      school_id_TBS = $("#school_id").val().toLowerCase().trim();
      password_TBS = $("#password").val();
      console.log(full_name_TBS,school_id_TBS);
      if(full_name_TBS.match("^[A-z\\']+(\\s[A-z\\']+){1,3}$") === null || school_id_TBS.match("^([a-z]{1,3}[0-9]{1,6})|([a-z]{4,10})$") === null ){
        $("#create_a_user").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Invalid Input.</div></div></div>');
        $("#create_a_user_submit").html('Retry <i class="fa fa-user-plus" aria-hidden="true"></i>');
        $("#create_a_user_submit").addClass("btn-warning");
      }else{
        $.post("/CORE/ajax.php", { type: "create_a_user", school_id: school_id_TBS, full_name: full_name_TBS, privilege: $("#privilege").val(), password: password_TBS}, function(result){
            if (result.error) {
              console.log(result.error);
              if(result.error.code == 013){
                $("#create_a_user").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
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
    $('input[type=checkbox]#check_all').change(function() { 
      if($( this ).prop("checked")){
        $(".table-checkboxes").each(function(){
          $( this ).prop( "checked", true );
        });
      }else{
        $(".table-checkboxes").each(function(){
          $( this ).prop( "checked", false );
        });
      }
    });
    $("#delete_users").on('click',function(){
        tableCheckboxes = [];
        $(".table-checkboxes").each(function(){
          if($( this ).prop( "checked" )){
            tableCheckboxes.push($( this ).attr("id"));
          }
        });
        if(tableCheckboxes.length > 0){
          $.post("/CORE/ajax.php", { type: "delete_users", school_id_list : tableCheckboxes}, function(result){
              if (result.error) {
                console.log(result.error);
                if(result.error.code == 031){
                  $("#manageUserOptions").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
                  $("#delete_users").html('Retry <i class="fa fa-user-times" aria-hidden="true"></i>');
                  $("#delete_users").addClass("btn-warning");
                }else{
                  $("#manageUserOptions").append('<div class="row"><div class="col"><div class="alert alert-danger alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
                  $("#delete_users").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
                  $("#delete_users").addClass("btn-danger");
                }
              }else{
                console.log(result.success);
                $("#delete_users").html('Success <i class="fa fa-check" aria-hidden="true"></i>');
                if(Cookies.get("PRIVILEGE")>1){
                  setTimeout(function(){ window.location.reload(); }, 500);
                }else{
                  setTimeout(function(){ window.location.replace("/Tlogin/"); }, 500);
                }
              }
          },"json");
        }

    });
    $(".buttons_edit_full_name").on('click',function(){
      $("#editModalLabel").text('Changing Full Name for '+$(this).attr("id"));
      $("#editModalBody").html('<div class="form-group"><label for="full_name">Full Name:</label><input type="text" class="form-control" id="edit_full_name" placeholder="New Name" value="'+$(this).attr("data-old-name")+'"></div>');

      $("#editModalSave").attr("data-id",$(this).attr("id"));
      $("#editModalSave").off();
      $("#editModalSave").on('click',function(){
      full_name_TBS = $("#edit_full_name").val().trim();
      school_id_TBS = $(this).attr("data-id").toLowerCase().trim();
      console.log(full_name_TBS,school_id_TBS);
      if(full_name_TBS.match("^[A-z\\']+(\\s[A-z\\']+){1,3}$") === null || school_id_TBS.match("^([a-z]{1,3}[0-9]{1,6})|([a-z]{4,10})$") === null ){
        $("#editModalBody").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Invalid Input.</div></div></div>');
        $("#editModalSave").html('Retry <i class="fa fa-user-plus" aria-hidden="true"></i>');
        $("#editModalSave").addClass("btn-warning");
      }else{
          $.post("/CORE/ajax.php", { type: "update_full_name", school_id: school_id_TBS, full_name: full_name_TBS}, function(result){
              if (result.error) {
                console.log(result.error);
                if(result.error.code == 042){
                  $("#editModalBody").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
                  $("#editModalSave").html('Retry <i class="fa fa-user-times" aria-hidden="true"></i>');
                  $("#editModalSave").addClass("btn-warning");
                }else{
                  $("#editModalBody").append('<div class="row"><div class="col"><div class="alert alert-danger alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
                  $("#editModalSave").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
                  $("#editModalSave").addClass("btn-danger");
                }
              }else{
                console.log(result);
                $("#editModalSave").html('Success <i class="fa fa-check" aria-hidden="true"></i>');
                $("#editModalSave").removeClass("btn-warning");
                $("#editModalSave").removeClass("btn-danger");
                $("#editModalSave").addClass("btn-success");
                if(Cookies.get("PRIVILEGE")>1){
                  setTimeout(function(){ window.location.reload(); }, 500);
                }else{
                  setTimeout(function(){ window.location.replace("/Tlogin/"); }, 500);
                }
              }
          },"json");
        }
      });
      $('#editModal').modal();
    });
    $(".buttons_edit_privilege").on('click',function(){
      $("#editModalLabel").text('Changing Privilege for '+$(this).attr("id"));
      $("#editModalBody").html('<div class="form-group"><label for="privilege">Privilege:</label><select class="form-control" id="edit_privilege"><option value="0">0: Registered in database, no access</option><option value="1">1: Developers: can create and collaborate works</option><option value="2">2: Admins: create, collaborate on works + manage works and users</option>'+((Cookies.get("PRIVILEGE")==3)?'<option value="3">3: Heads: manage works and users</option>':'')+'</select></div></form></div>');

      $("#editModalSave").attr("data-id",$(this).attr("id"));
      $("#editModalSave").off();
      $("#editModalSave").on('click',function(){
        privilege_TBS = $("#edit_privilege").val();
        school_id_TBS = $(this).attr("data-id").toLowerCase().trim();
        if(privilege_TBS.match("^[0-3]$") === null || school_id_TBS.match("^([a-z]{1,3}[0-9]{1,6})|([a-z]{4,10})$") === null ){
          $("#editModalBody").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Invalid Input.</div></div></div>');
          $("#editModalSave").html('Retry <i class="fa fa-user-plus" aria-hidden="true"></i>');
          $("#editModalSave").addClass("btn-warning");
        }else{
            $.post("/CORE/ajax.php", { type: "update_privilege", school_id: school_id_TBS, privilege: privilege_TBS}, function(result){
                if (result.error) {
                  console.log(result.error);
                  if(result.error.code == 042){
                    $("#editModalBody").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
                    $("#editModalSave").html('Retry <i class="fa fa-user-times" aria-hidden="true"></i>');
                    $("#editModalSave").addClass("btn-warning");
                  }else{
                    $("#editModalBody").append('<div class="row"><div class="col"><div class="alert alert-danger alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
                    $("#editModalSave").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
                    $("#editModalSave").addClass("btn-danger");
                  }
                }else{
                  console.log(result.success);
                  $("#editModalSave").html('Success <i class="fa fa-check" aria-hidden="true"></i>');
                  $("#editModalSave").removeClass("btn-warning");
                  $("#editModalSave").removeClass("btn-danger");
                  $("#editModalSave").addClass("btn-success");
                  if(Cookies.get("PRIVILEGE")>1){
                    setTimeout(function(){ window.location.reload(); }, 500);
                  }else{
                    setTimeout(function(){ window.location.replace("/Tlogin/"); }, 500);
                  }
                }
            },"json");
          }
      });
      $('#editModal').modal();
    });
  });