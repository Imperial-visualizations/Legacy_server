$(document).ready(function(){
	$("#visual_id").on('keyup',function(){
		visual_id = $(this).val().toLowerCase().trim();
		if(visual_id.match("^[a-z]+[0-9]*(_([0-9]|[a-z])+)*$") === null){
			$("#visual_id_help_text").removeClass("text-muted");
			$("#visual_id_help_text").addClass("text-danger");
			$("#visual_id_help_text").html("Invalid input!<br>Making sure it starts with a letter, and only contains numbers, letters or underscores (_). The underscore cannot be the last character.");
		}else{
			$("#visual_id_help_text").removeClass("text-danger");
			$("#visual_id_help_text").addClass("text-muted");
			$("#visual_id_help_text").html($("#visual_id_help_text").attr("data-prefix")+visual_id);
		}
	});

	$(".publish_buttons").each(function(){
		$(this).on('click',function(){
			$('#publishConfirmationContent').html('An email will be sent to Dr Caroline asking her to approve the visualisation before it can be seen by the world.<br>If you want the visualisation to be taken down at any point please speak to an Admin.');
			$("#publishConfirmationPublishButton").attr('data-visual-id',$(this).attr("data-visual-id"));
			$("#publishConfirmationPublishButton").attr('data-text-id',$(this).attr("data-text-id"));
			$('#publishConfirmation').modal();
		});
	});
	$("#publishConfirmationPublishButton").on('click',function(){
		$.post("/CORE/ajax.php", { type: "publish_a_visual_1", visual_id: $(this).attr("data-visual-id"), text_id: $(this).attr("data-text-id")}, function(result){
			if (result.error) {
				console.log(result.error);
				$("#publishConfirmationContent").append('<div class="row"><div class="col"><div class="alert alert-danger alert-dismissible fade show" role="alert">	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
				$("#publishConfirmationPublishButton").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
				$("#publishConfirmationPublishButton").addClass("btn-danger");
			}else{
				console.log(result);
				$("#publishConfirmationPublishButton").html('Success <i class="fa fa-check" aria-hidden="true"></i>');
				$("#publishConfirmationPublishButton").removeClass("btn-warning");
				$("#publishConfirmationPublishButton").removeClass("btn-danger");
				$("#publishConfirmationPublishButton").addClass("btn-success");
				if(Cookies.get("PRIVILEGE")>1){
					setTimeout(function(){ 
						window.location.href += "#"+$("#publishConfirmationPublishButton").attr("data-text-id");
						location.reload();
					}, 500);
				}else{
					setTimeout(function(){ window.location.replace("/Tlogin/"); }, 500);
				}
			}
		},"json");
		event.preventDefault();
	});

	$("#create_a_visual_submit").on('click',function(){
		console.log("clicked");
		text_id_TBS = $("#visual_id").val().toLowerCase().trim();
		title_TBS = text_id_TBS.replace(/_/g," ").replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()});
		collaborator_school_id_1_TBS = $("#collaborator_school_id_1").val().toLowerCase().trim();
		collaborator_school_id_2_TBS = $("#collaborator_school_id_2").val().toLowerCase().trim();
		if(text_id_TBS.match("^[a-z]+[0-9]*(_([0-9]|[a-z])+)*$") === null){
			$("#create_a_visual").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Invalid visual_id format. </div></div></div>');
			$("#create_a_visual_submit").html('Retry <i class="fa fa-user-plus" aria-hidden="true"></i>');
			$("#create_a_visual_submit").addClass("btn-warning");
		}else{
			if(collaborator_school_id_1_TBS.match("^([a-z]{1,3}[0-9]{1,6})|([a-z]{4,10})$") === null && collaborator_school_id_1_TBS !== ""){
				$("#create_a_visual").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Invalid collaborator_school_id_1 format. </div></div></div>');
				$("#create_a_visual_submit").html('Retry <i class="fa fa-user-plus" aria-hidden="true"></i>');
				$("#create_a_visual_submit").addClass("btn-warning");
			}else{
				if(collaborator_school_id_2_TBS.match("^([a-z]{1,3}[0-9]{1,6})|([a-z]{4,10})$") === null && collaborator_school_id_2_TBS !== ""){
					$("#create_a_visual").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Invalid collaborator_school_id_2 format. </div></div></div>');
					$("#create_a_visual_submit").html('Retry <i class="fa fa-user-plus" aria-hidden="true"></i>');
					$("#create_a_visual_submit").addClass("btn-warning");
				}else{
					console.log({ type: "create_a_visual", text_id: text_id_TBS, title:title_TBS, collaborator_school_id_1: collaborator_school_id_1_TBS, collaborator_school_id_2: collaborator_school_id_2_TBS,  course: $("#course").val()});
					$.post("/CORE/ajax.php", { type: "create_a_visual", text_id: text_id_TBS , title:title_TBS, collaborator_school_id_1: collaborator_school_id_1_TBS, collaborator_school_id_2: collaborator_school_id_2_TBS, course: $("#course").val()}, function(result){
						if (result.error) {
							console.log(result.error);
							if(result.error.code == 066 || result.error.code == 054){
								$("#create_a_visual").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
								$("#create_a_visual_submit").html('Retry <i class="fa fa-user-plus" aria-hidden="true"></i>');
								$("#create_a_visual_submit").addClass("btn-warning");
							}else{
								$("#create_a_visual").append('<div class="row"><div class="col"><div class="alert alert-danger alert-dismissible fade show" role="alert">	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
								$("#create_a_visual_submit").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
								$("#create_a_visual_submit").addClass("btn-danger");
							}
						}else{
							console.log(result);
							$("#create_a_visual_submit").html('Success <i class="fa fa-check" aria-hidden="true"></i>');
							$("#create_a_visual_submit").removeClass("btn-warning");
							$("#create_a_visual_submit").removeClass("btn-danger");
							$("#create_a_visual_submit").addClass("btn-success");
							if(Cookies.get("PRIVILEGE")==1 || Cookies.get("PRIVILEGE")==2){
								setTimeout(function(){ window.location.replace("/Develop/UpdateVisual/?visual_id="+text_id_TBS); }, 500);
							}else{
								setTimeout(function(){ window.location.replace("/Tlogin/"); }, 500);
							}
						}
					},"json");
				}
			}

		}
		event.preventDefault();
	});
});