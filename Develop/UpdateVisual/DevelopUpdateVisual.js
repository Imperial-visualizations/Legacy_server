var uploadType;
function updateDeleteFileButton(){	
	$(".file_delete_buttons").each(function(){
		$(this).off();
		$(this).on('click',function(){
			$("#deleteConfirmationDeleteButton").text("Yes go ahead and delete the file.");
			$('#deleteConfirmationContent').html('Please make sure all your changes have been saved because this page will be reloaded after the file <code>'+$(this).attr("data-file-path")+'</code> has been deleted. You will lose all your unsaved data and this action is irreversible. ');
			$("#deleteConfirmationDeleteButton").attr('data-function','file_delete');
			$("#deleteConfirmationDeleteButton").attr('data-file-path',$(this).attr("data-file-path"));
			$('#deleteConfirmation').modal();
		});
	});
	$(".delete_collaborator_button").each(function(){
		$(this).off();
		$(this).on('click',function(){
			$("#deleteConfirmationDeleteButton").text("Unlink this collaborator");
			$('#deleteConfirmationContent').html('Please make sure all your changes have been saved because this page will be reloaded after the collaborator <br><span class="font-weight-bold">'+$(this).attr("data-user-name")+'</span><br> has been unlinked from this visualisation. You will lose all your unsaved data and this action is irreversible. ');
			$("#deleteConfirmationDeleteButton").attr('data-function','delete_collaborator');
			$("#deleteConfirmationDeleteButton").attr('data-user-id',$(this).attr("data-user-id"));
			$("#deleteConfirmationDeleteButton").attr('data-visual-id',$(this).attr("data-visual-id"));
			$('#deleteConfirmation').modal();
		});
	});

}	
var canUndo = 0;
var undo = 0;
$(document).ready(function(){

	$("#previewDescription").text($("#description").val());
	$("#previewTitle").text($("#visualisation_title").val());

	$("#visualisation_title").on('keyup',function(){
		$("#previewTitle").text($("#visualisation_title").val());
	});

	$(".add_collaborator_button").on('click',function(){
		$("#AddCollaborator").modal();
		$("#collaborator_school_id").focus();
	});
	$("#collaborator_school_id").on('keyup',function(){
		school_id_TBS = $(this).val().toLowerCase().trim();
		if(school_id_TBS.match("^[a-z]{1,3}[0-9]{1,6}$") === null){
			$("#collaborator_school_id_feedback").removeClass("text-success");
			$("#collaborator_school_id_feedback").addClass("text-warning");
			$("#collaborator_school_id_feedback").text("Invalid format. It has to be something similar to 'ab1234'");
		}else{
			$.post("/CORE/ajax.php", { type: "get_user_info", school_id: school_id_TBS}, function(result){
			    if (result.error) {
					if(result.error.code == 093){
						$("#collaborator_school_id_feedback").removeClass("text-success");
						$("#collaborator_school_id_feedback").removeClass("text-danger");
						$("#collaborator_school_id_feedback").addClass("text-warning");
						$("#collaborator_school_id_feedback").text(result.error.message);
					}else{
						console.log(result.error);
						$("#collaborator_school_id_feedback").removeClass("text-success");
						$("#collaborator_school_id_feedback").removeClass("text-warning");
						$("#collaborator_school_id_feedback").addClass("text-danger");
						$("#collaborator_school_id_feedback").text("Unknow Error");
					}
			    }else{
				    console.log(result.success);
				    $("#AddCollaboratorButton").attr("data-user-id-to-be-added",result.success.info.ID);
					$("#collaborator_school_id_feedback").removeClass("text-warning");
					$("#collaborator_school_id_feedback").removeClass("text-danger");
					$("#collaborator_school_id_feedback").addClass("text-success");
					$("#collaborator_school_id_feedback").text(result.success.message);
			    }
			},"json");
		}
	});
	$("#AddCollaboratorButton").on('click',function(){
		console.log({ type: "link_a_user", visual_id: $(this).attr("data-visual-id"), user_id_TBAdded: $(this).attr("data-user-id-to-be-added") });
		$.post("/CORE/ajax.php", { type: "link_a_user", visual_id: $(this).attr("data-visual-id"), user_id_TBAdded: $(this).attr("data-user-id-to-be-added") }, function(result){
		    if (result.error) {
				if(result.error.code == 093){
					$("#collaborator_school_id_feedback").removeClass("text-success");
					$("#collaborator_school_id_feedback").removeClass("text-danger");
					$("#collaborator_school_id_feedback").addClass("text-warning");
					$("#collaborator_school_id_feedback").text(result.error.message);
					$("#AddCollaboratorButton").html('Retry');
			        $("#AddCollaboratorButton").addClass("btn-warning");
				}else{
					console.log(result.error);
					$("#collaborator_school_id_feedback").removeClass("text-success");
					$("#collaborator_school_id_feedback").removeClass("text-warning");
					$("#collaborator_school_id_feedback").addClass("text-danger");
					$("#collaborator_school_id_feedback").text("Unknow Error");
					$("#AddCollaboratorButton").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
			        $("#AddCollaboratorButton").addClass("btn-danger");
				}
		    }else{
			    console.log(result);			    
				$("#collaborator_school_id_feedback").removeClass("text-warning");
				$("#collaborator_school_id_feedback").removeClass("text-danger");
				$("#collaborator_school_id_feedback").addClass("text-success");
				$("#collaborator_school_id_feedback").text(result.success.message);
				$("#collaborator_list").append(result.success.new_collaborator_html);
				$("#AddCollaboratorButton").html('Success <i class="fa fa-check" aria-hidden="true"></i>');
				updateDeleteFileButton();
				$("#AddCollaboratorButton").removeClass("btn-warning");
				$("#AddCollaboratorButton").removeClass("btn-danger");
				$("#AddCollaboratorButton").addClass("btn-success");
				setTimeout(function(){
					$("#collaborator_school_id_feedback").removeClass("text-warning");
					$("#collaborator_school_id_feedback").removeClass("text-danger");
					$("#collaborator_school_id_feedback").removeClass("text-success");
					$("#collaborator_school_id_feedback").html("");
					$("#collaborator_school_id").val("");
					$("#AddCollaboratorButton").removeClass("btn-warning");
					$("#AddCollaboratorButton").removeClass("btn-danger");
					$("#AddCollaboratorButton").removeClass("btn-success");
					$("#AddCollaboratorButton").addClass("btn-primary");
					$("#AddCollaboratorButton").text("Add Collaborator");
					$("#AddCollaboratorButton").attr("data-visual-id","");
					$("#AddCollaboratorButton").attr("data-user-id-to-be-added","");
					$("#AddCollaborator").modal("hide");
				},500);
		    }
		},"json");
	});

	$(".libraries-checkboxes").on('change',function(){
		$("#headInsert").text("");
		$("#bottomInsert").text("");
		$(".libraries-checkboxes:checked").each(function(){
			if($(this).attr("data-isasync")==1){
				if($(this).attr("data-type")=="CSS"){
					$("#headInsert").text($("#headInsert").text()+'\n    <link rel=\"stylesheet\" href=\"'+$(this).attr("data-file-path")+'\">');
				}else if($(this).attr("data-type")=="JS"){
					$("#headInsert").text($("#headInsert").text()+'\n    <script type=\"text/javascript\" src=\"'+$(this).attr("data-file-path")+'\" '+(( ($(this).attr("id") == 'js_mathjax_html') || ($(this).attr("id")  == 'js_mathjax_svg'))?'async':'')+'><\/script>');
				}else if($(this).attr("data-type")=="selfJS"){
					if($("input[name='"+$(this).val()+"RADIO'][value=Async]").prop("checked")){
						$("#headInsert").text($("#headInsert").text()+'\n    <script type=\"text/javascript\" src=\"'+$(this).attr("data-file-path")+'\"><\/script>');
					}else{
						$("#bottomInsert").text($("#bottomInsert").text()+'\n    <script type=\"text/javascript\" src=\"'+$(this).attr("data-file-path")+'\"><\/script>');
					}
				}
			}else if($(this).attr("data-isasync")==0){
				if($(this).attr("data-type")=="JS"){
					$("#bottomInsert").text($("#bottomInsert").text()+'\n    <script type=\"text/javascript\" src=\"'+$(this).attr("data-file-path")+'\"><\/script>');
				}else if($(this).attr("data-type")=="selfJS"){
					if($("input[name='"+$(this).val()+"RADIO'][value=Async]").prop("checked")){
						$("#headInsert").text($("#headInsert").text()+'\n    <script type=\"text/javascript\" src=\"'+$(this).attr("data-file-path")+'\"><\/script>');
					}else{
						$("#bottomInsert").text($("#bottomInsert").text()+'\n    <script type=\"text/javascript\" src=\"'+$(this).attr("data-file-path")+'\"><\/script>');
					}
				}
			}
			
		});
	});
	$(".headOrBottomRadios").on('change',function(){
		$("#headInsert").text("");
		$("#bottomInsert").text("");
		$(".libraries-checkboxes[data-file-path='"+$(this).attr("data-file-path")+"']").attr("data-isasync",($("input[name='"+$(this).attr("name")+"'][value=Async]").prop("checked")?"1":"0"));
		$(".libraries-checkboxes:checked").each(function(){
			if($(this).attr("data-isasync")==1){
				if($(this).attr("data-type")=="CSS"){
					$("#headInsert").text($("#headInsert").text()+'\n    <link rel=\"stylesheet\" href=\"'+$(this).attr("data-file-path")+'\">');
				}else if($(this).attr("data-type")=="JS"){
					$("#headInsert").text($("#headInsert").text()+'\n    <script type=\"text/javascript\" src=\"'+$(this).attr("data-file-path")+'\"><\/script>');
				}else if($(this).attr("data-type")=="selfJS"){
					if($("input[name='"+$(this).val()+"RADIO'][value=Async]").prop("checked")){
						$("#headInsert").text($("#headInsert").text()+'\n    <script type=\"text/javascript\" src=\"'+$(this).attr("data-file-path")+'\"><\/script>');
					}else{
						$("#bottomInsert").text($("#bottomInsert").text()+'\n    <script type=\"text/javascript\" src=\"'+$(this).attr("data-file-path")+'\"><\/script>');
					}
				}
			}else if($(this).attr("data-isasync")==0){
				if($(this).attr("data-type")=="JS"){
					$("#bottomInsert").text($("#bottomInsert").text()+'\n    <script type=\"text/javascript\" src=\"'+$(this).attr("data-file-path")+'\"><\/script>');
				}else if($(this).attr("data-type")=="selfJS"){
					if($("input[name='"+$(this).val()+"RADIO'][value=Async]").prop("checked")){
						$("#headInsert").text($("#headInsert").text()+'\n    <script type=\"text/javascript\" src=\"'+$(this).attr("data-file-path")+'\"><\/script>');
					}else{
						$("#bottomInsert").text($("#bottomInsert").text()+'\n    <script type=\"text/javascript\" src=\"'+$(this).attr("data-file-path")+'\"><\/script>');
					}
				}
			}
			
		});
	});
	

	$("#deleteConfirmationDeleteButton").on('click',function(){
		if($(this).attr('data-function') == 'delete_collaborator'){
			$.post("/CORE/ajax.php", { type: "unlink_a_user", user_id: $("#deleteConfirmationDeleteButton").attr("data-user-id"), visual_id: $("#deleteConfirmationDeleteButton").attr('data-visual-id')}, function(result){
			    if (result.error) {
			      console.log(result.error);
			      if(result.error.code == 081){
			        $("#deleteConfirmationContent").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
			        $("#deleteConfirmationDeleteButton").html('Retry delete');
			        $("#deleteConfirmationDeleteButton").addClass("btn-warning");
			      }else{
			        $("#deleteConfirmationContent").append('<div class="row"><div class="col"><div class="alert alert-danger alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
			        $("#deleteConfirmationDeleteButton").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
			        $("#deleteConfirmationDeleteButton").addClass("btn-danger");
			      }
			    }else{
			      console.log(result.success);
			      $("#deleteConfirmationDeleteButton").html('Success <i class="fa fa-check" aria-hidden="true"></i>');
			      $("#deleteConfirmationDeleteButton").removeClass("btn-warning");
			      $("#deleteConfirmationDeleteButton").removeClass("btn-danger");
			      $("#deleteConfirmationDeleteButton").addClass("btn-success");
			      if(Cookies.get("PRIVILEGE")>1){
			        setTimeout(function(){ window.location.reload(); }, 500);
			      }else{
			        setTimeout(function(){ window.location.replace("/Tlogin/"); }, 500);
			      }
			    }
			},"json");
		}else if($(this).attr('data-function') == 'file_delete'){
			if(canUndo == 0){
				canUndo = 1;
				$("#deleteConfirmationDeleteButton").text("Undo (Deleting file in 5s)");
				if(undo != 1){
					setTimeout(function(){
						$("#deleteConfirmationDeleteButton").text("Undo (Deleting file in 4s)");
						if(undo != 1){
							setTimeout(function(){
								$("#deleteConfirmationDeleteButton").text("Undo (Deleting file in 3s)");
								if(undo != 1){
									setTimeout(function(){
										$("#deleteConfirmationDeleteButton").text("Undo (Deleting file in 2s)");
										if(undo != 1){
											setTimeout(function(){
												$("#deleteConfirmationDeleteButton").text("Undo (Deleting file in 1s)");
												if(undo != 1){
													setTimeout(function(){
														$("#deleteConfirmationDeleteButton").text("Undo (Deleting file in 0s)");
														if(undo != 1){
															setTimeout(function(){
																$("#deleteConfirmationDeleteButton").text("Deleted.");
																canUndo = 0;
																//Ajax and reload
																$.post("/CORE/ajax.php", { type: "delete_a_file", text_id: $("#deleteConfirmationDeleteButton").attr("data-text-id"), path: $("#deleteConfirmationDeleteButton").attr('data-file-path')}, function(result){
														            if (result.error) {
														              console.log(result.error);
														              if(result.error.code == 071 || result.error.code == 074){
														                $("#deleteConfirmationContent").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
														                $("#deleteConfirmationDeleteButton").html('Retry delete');
														                $("#deleteConfirmationDeleteButton").addClass("btn-warning");
														              }else{
														                $("#deleteConfirmationContent").append('<div class="row"><div class="col"><div class="alert alert-danger alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
														                $("#deleteConfirmationDeleteButton").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
														                $("#deleteConfirmationDeleteButton").addClass("btn-danger");
														              }
														            }else{
														              console.log(result.success);
														              $("#deleteConfirmationDeleteButton").html('Success <i class="fa fa-check" aria-hidden="true"></i>');
														              $("#deleteConfirmationDeleteButton").removeClass("btn-warning");
														              $("#deleteConfirmationDeleteButton").removeClass("btn-danger");
														              $("#deleteConfirmationDeleteButton").addClass("btn-success");
														              if(Cookies.get("PRIVILEGE")>1){
														                setTimeout(function(){ window.location.reload(); }, 500);
														              }else{
														                setTimeout(function(){ window.location.replace("/Tlogin/"); }, 500);
														              }
														            }
														        },"json");
															},1000);
														}else{
															$("#deleteConfirmationDeleteButton").text("Ok I won't delete the file for now : )");
															undo = 0;
															canUndo = 0;
															setTimeout(function(){
																$("#deleteConfirmationDeleteButton").text("Delete");
																
															},2000);
														}
													},1000);
												}else{
													$("#deleteConfirmationDeleteButton").text("Ok I won't delete the file for now : )");
													undo = 0;
													canUndo = 0;
													setTimeout(function(){
														$("#deleteConfirmationDeleteButton").text("Delete");
														
													},2000);
												}
											},1000);
										}else{
											$("#deleteConfirmationDeleteButton").text("Ok I won't delete the file for now : )");
											undo = 0;
											canUndo = 0;
											setTimeout(function(){
												$("#deleteConfirmationDeleteButton").text("Delete");
												
											},2000);
										}
									},1000);
								}else{
									$("#deleteConfirmationDeleteButton").text("Ok I won't delete the file for now : )");
									undo = 0;
									canUndo = 0;
									setTimeout(function(){
										$("#deleteConfirmationDeleteButton").text("Delete");
										
									},2000);
								}
							},1000);
						}else{
							$("#deleteConfirmationDeleteButton").text("Ok I won't delete the file for now : )");
							undo = 0;
							canUndo = 0;
							setTimeout(function(){
								$("#deleteConfirmationDeleteButton").text("Delete");
							},2000);
						}
					},1000);
				}else{
					$("#deleteConfirmationDeleteButton").text("Ok I won't delete the file for now : )");
					undo = 0;
					setTimeout(function(){
						$("#deleteConfirmationDeleteButton").text("Delete");
						canUndo = 0;
						
					},2000);
				}
			}else{
				undo = 1;
			}
		}
	});
	$("#deleteConfirmationCancelButton").on('click',function(){
		if(canUndo == 0){
		}else{
			undo = 1;
		}
	});


	$( '.inputfile' ).each( function(){
		var inputFile	 = $( this );
		inputFile.on( 'change', function( e ){
			var fileName = '';
			var uploadType2 = $(this).parent()[0].elements.type.value;
			console.log(uploadType2);
	        $("#"+uploadType2+"Progress").css("width","0%");
	        $("#"+uploadType2+"Progress").attr("aria-valuenow",0);

			if( this.files && this.files.length > 1 ){
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			}else if( e.target.value ){
				fileName = e.target.value.split( '\\' ).pop();
				if(uploadType2 == "screenshot"){
					fileName = "SCREENSHOT"+fileName.substr(fileName.lastIndexOf('.'));
				}
			}
			$("#"+uploadType2+"ChooseFileButton").css("display","none");
			$("#"+uploadType2+"UploadButton").css("display","inline-block");
			if( fileName ){
				$("#"+uploadType2+"UploadButton").html( 'Upload <span class="font-italic">'+fileName+'</span> <i class="fa fa-upload" aria-hidden="true"></i>' );
			}else{
				$("#"+uploadType2+"UploadButton").html( 'Upload <i class="fa fa-upload" aria-hidden="true"></i>' );
			}
		});
	});	  

	$('#screenshotUploadForm').submit(function(e) {
	    var formData = new FormData(this);
	    uploadType = $(this)[0].elements.type.value;
	    $.ajax({
	        type:'POST',
	        url: '/CORE/uploader.php',
	        data:formData,
	        xhr: function() {
	                var myXhr = $.ajaxSettings.xhr();
	                if(myXhr.upload){
	                    myXhr.upload.addEventListener('progress',progress, false);
	                }
	                return myXhr;
	        },
	        cache:false,
	        contentType: false,
	        processData: false,
	        dataType: 'json',

	        success:function(data){
	        	console.log(data);
	        	if(data.totalFileFailed == 0){
	        		for(i=0;i<data.fileInfos.length;i++){
	        			$("#previewImg").attr("src",data.fileInfos[i].filePath.replace(/\\/g, ""));
						$("#previewDescription").text($("#description").val());
						$("#previewTitle").text($("#visualisation_title").val());
	        		}
		            $("#"+uploadType+"UploadButton").html('Success <i class="fa fa-check" aria-hidden="true"></i>');
		            $("#"+uploadType+"UploadButton").removeClass('btn-primary');
		            $("#"+uploadType+"UploadButton").addClass('btn-success');
		            setTimeout(function(){
			            $("#"+uploadType+"UploadButton").html('Upload <i class="fa fa-upload" aria-hidden="true"></i>');
			            $("#"+uploadType+"UploadButton").removeClass('btn-success');
			            $("#"+uploadType+"UploadButton").addClass('btn-primary');
						$("#"+uploadType+"UploadButton").css("display","none");
						$("#"+uploadType+"ChooseFileButton").css("display","inline-block");
		            },1000);
					$("#"+uploadType+"UploadForm")[0].reset();
	        	}else{
	                $("#"+uploadType+"UploadButton").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
	                $("#"+uploadType+"UploadButton").addClass("btn-danger");
		            setTimeout(function(){
			            $("#"+uploadType+"UploadButton").html('Upload <i class="fa fa-upload" aria-hidden="true"></i>');
			            $("#"+uploadType+"UploadButton").removeClass('btn-danger');
			            $("#"+uploadType+"UploadButton").addClass('btn-primary');
						$("#"+uploadType+"UploadButton").css("display","none");
						$("#"+uploadType+"ChooseFileButton").css("display","inline-block");
		            },1000);
					$("#"+uploadType+"UploadForm")[0].reset();
	        	}
	        },

	        error: function(data){
	            console.log(data);
                $("#"+uploadType+"UploadButton").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
                $("#"+uploadType+"UploadButton").addClass("btn-danger");
	            setTimeout(function(){
		            $("#"+uploadType+"UploadButton").html('Upload <i class="fa fa-upload" aria-hidden="true"></i>');
		            $("#"+uploadType+"UploadButton").removeClass('btn-danger');
		            $("#"+uploadType+"UploadButton").addClass('btn-primary');
					$("#"+uploadType+"UploadButton").css("display","none");
					$("#"+uploadType+"ChooseFileButton").css("display","inline-block");
	            },1000);
				$("#"+uploadType+"UploadForm")[0].reset();
	        }
	    });
	    updateDeleteFileButton();
	    e.preventDefault();

	});


	$('#JSVUploadForm').submit(function(e) {
	    var formData = new FormData(this);
	    uploadType = $(this)[0].elements.type.value;
	    $.ajax({
	        type:'POST',
	        url: '/CORE/uploader.php',
	        data:formData,
	        xhr: function() {
	                var myXhr = $.ajaxSettings.xhr();
	                if(myXhr.upload){
	                    myXhr.upload.addEventListener('progress',progress, false);
	                }
	                return myXhr;
	        },
	        cache:false,
	        contentType: false,
	        processData: false,
	        dataType: 'json',

	        success:function(data){
	        	console.log(data);
	        	glob = data;
	        	if(data.totalFileFailed == 0){
	        		for(i=0;i<data.fileInfos.length;i++){
	        			if(data.fileInfos[i].fileType == 'js'){
	        				if($('input[data-file-path="'+data.fileInfos[i].filePath+'"]').length){}else{
	        				$("#JSFiles").append('<div class="form-check"><label class="form-check-label font-italic"><input class="form-check-input" type="checkbox" data-file-path="'+data.fileInfos[i].filePath+'" value="'+data.fileInfos[i].fileName+'"> scripts/'+data.fileInfos[i].fileName+'</label><label class="headOrBottom"><input class="" type="radio" name="'+data.fileInfos[i].fileName+'RADIO" id="headOrBottomLabelB'+data.fileInfos[i].fileName+'" value="Sync" checked><label for="headOrBottomLabelB'+data.fileInfos[i].fileName+'" class="headOrBottomLabel">Sync</label>/<input class="" type="radio" name="'+data.fileInfos[i].fileName+'RADIO" id="headOrBottomLabelH'+data.fileInfos[i].fileName+'" value="Async"><label for="headOrBottomLabelH'+data.fileInfos[i].fileName+'" class="headOrBottomLabel">Async</label></label></div>');
		        			}
	        			}else if(data.fileInfos[i].fileType == 'css'){
	        				if($('input[data-file-path="'+data.fileInfos[i].filePath+'"]').length){}else{
	        				$("#CSSFiles").append('<div class="form-check"><label class="form-check-label font-italic"><input class="form-check-input" type="checkbox" data-file-path="'+data.fileInfos[i].filePath+'" value="'+data.fileInfos[i].fileName+'"> styles/'+data.fileInfos[i].fileName+'</label></div>');
		        			}
	        			}
	        		}
		            $("#"+uploadType+"UploadButton").html('Success <i class="fa fa-check" aria-hidden="true"></i>');
		            $("#"+uploadType+"UploadButton").removeClass('btn-primary');
		            $("#"+uploadType+"UploadButton").addClass('btn-success');
		            setTimeout(function(){
			            $("#"+uploadType+"UploadButton").html('Upload <i class="fa fa-upload" aria-hidden="true"></i>');
			            $("#"+uploadType+"UploadButton").removeClass('btn-success');
			            $("#"+uploadType+"UploadButton").addClass('btn-primary');
						$("#"+uploadType+"UploadButton").css("display","none");
						$("#"+uploadType+"ChooseFileButton").css("display","inline-block");
		            },1000);
					$("#"+uploadType+"UploadForm")[0].reset();
	        	}else if(data.totalFileSuccessed < data.totalFileUploaded){

	        		for(i=0;i<data.fileInfos.length;i++){
	        			if(data.fileInfos[i].error){
	                		$("#JSVUploadForm").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+data.fileInfos[i].error+'</div></div></div>');
	        			}else if(data.fileInfos[i].fileType == 'js'){
	        				if($('input[data-file-path="'+data.fileInfos[i].filePath+'"]').length){}else{
	        				$("#JSFiles").append('<div class="form-check"><label class="form-check-label font-italic"><input class="form-check-input" type="checkbox"  data-file-path="'+data.fileInfos[i].filePath+'" value="'+data.fileInfos[i].fileName+'"> scripts/'+data.fileInfos[i].fileName+'</label><label class="headOrBottom"><input class="" type="radio" name="'+data.fileInfos[i].fileName+'RADIO" id="headOrBottomLabelB'+data.fileInfos[i].fileName+'" value="Sync" checked><label for="headOrBottomLabelB'+data.fileInfos[i].fileName+'" class="headOrBottomLabel">Sync</label>/<input class="" type="radio" name="'+data.fileInfos[i].fileName+'RADIO" id="headOrBottomLabelH'+data.fileInfos[i].fileName+'" value="Async"><label for="headOrBottomLabelH'+data.fileInfos[i].fileName+'" class="headOrBottomLabel">Async</label></label></div>');
		        			}
	        			}else if(data.fileInfos[i].fileType == 'css'){
	        				if($('input[data-file-path="'+data.fileInfos[i].filePath+'"]').length){}else{
	        				$("#CSSFiles").append('<div class="form-check"><label class="form-check-label font-italic"><input class="form-check-input" type="checkbox" data-file-path="'+data.fileInfos[i].filePath+'" value="'+data.fileInfos[i].fileName+'"> styles/'+data.fileInfos[i].fileName+'</label></div>');
		        			}
	        			}
	        		}
	                $("#"+uploadType+"UploadButton").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
	                $("#"+uploadType+"UploadButton").addClass("btn-warning");
		            setTimeout(function(){
			            $("#"+uploadType+"UploadButton").html('Upload <i class="fa fa-upload" aria-hidden="true"></i>');
			            $("#"+uploadType+"UploadButton").removeClass('btn-warning');
			            $("#"+uploadType+"UploadButton").addClass('btn-primary');
						$("#"+uploadType+"UploadButton").css("display","none");
						$("#"+uploadType+"ChooseFileButton").css("display","inline-block");
		            },1000);
					$("#"+uploadType+"UploadForm")[0].reset();
	        	}else if(data.totalFileSuccessed == 0){

	        		for(i=0;i<data.fileInfos.length;i++){
	        			if(data.fileInfos[i].error){
	                		$("#JSVUploadForm").append('<div class="row"><div class="col"><div class="alert alert-danger alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+data.fileInfos[i].error+'</div></div></div>');
	        			}else{
		        		}
	        		}
	                $("#"+uploadType+"UploadButton").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
	                $("#"+uploadType+"UploadButton").addClass("btn-danger");
		            setTimeout(function(){
			            $("#"+uploadType+"UploadButton").html('Upload <i class="fa fa-upload" aria-hidden="true"></i>');
			            $("#"+uploadType+"UploadButton").removeClass('btn-danger');
			            $("#"+uploadType+"UploadButton").addClass('btn-primary');
						$("#"+uploadType+"UploadButton").css("display","none");
						$("#"+uploadType+"ChooseFileButton").css("display","inline-block");
		            },1000);
					$("#"+uploadType+"UploadForm")[0].reset();
	        	}else{
	                $("#"+uploadType+"UploadButton").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
	                $("#"+uploadType+"UploadButton").addClass("btn-danger");
		            setTimeout(function(){
			            $("#"+uploadType+"UploadButton").html('Upload <i class="fa fa-upload" aria-hidden="true"></i>');
			            $("#"+uploadType+"UploadButton").removeClass('btn-danger');
			            $("#"+uploadType+"UploadButton").addClass('btn-primary');
						$("#"+uploadType+"UploadButton").css("display","none");
						$("#"+uploadType+"ChooseFileButton").css("display","inline-block");
		            },1000);
					$("#"+uploadType+"UploadForm")[0].reset();
	        	}
	        	$("#directory_tree").html(data.folderTree);
	        },

	        error: function(data){
	            console.log(data);
                $("#"+uploadType+"UploadButton").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
                $("#"+uploadType+"UploadButton").addClass("btn-danger");
	            setTimeout(function(){
		            $("#"+uploadType+"UploadButton").html('Upload <i class="fa fa-upload" aria-hidden="true"></i>');
		            $("#"+uploadType+"UploadButton").removeClass('btn-danger');
		            $("#"+uploadType+"UploadButton").addClass('btn-primary');
					$("#"+uploadType+"UploadButton").css("display","none");
					$("#"+uploadType+"ChooseFileButton").css("display","inline-block");
	            },1000);
				$("#"+uploadType+"UploadForm")[0].reset();
	        }
	    });
		updateDeleteFileButton();
	    e.preventDefault();

	});
	$('#JNVUploadForm').submit(function(e) {
	    var formData = new FormData(this);
	    uploadType = $(this)[0].elements.type.value;
	    $.ajax({
	        type:'POST',
	        url: '/CORE/uploader.php',
	        data:formData,
	        xhr: function() {
	                var myXhr = $.ajaxSettings.xhr();
	                if(myXhr.upload){
	                    myXhr.upload.addEventListener('progress',progress, false);
	                }
	                return myXhr;
	        },
	        cache:false,
	        contentType: false,
	        processData: false,
	        dataType: 'json',

	        success:function(data){
	        	console.log(data);
	        	glob = data;
	        	if(data.totalFileFailed == 0){
	        		for(i=0;i<data.fileInfos.length;i++){
	        		}
		            $("#"+uploadType+"UploadButton").html('Success <i class="fa fa-check" aria-hidden="true"></i>');
		            $("#"+uploadType+"UploadButton").removeClass('btn-primary');
		            $("#"+uploadType+"UploadButton").addClass('btn-success');
		            setTimeout(function(){
			            $("#"+uploadType+"UploadButton").html('Upload <i class="fa fa-upload" aria-hidden="true"></i>');
			            $("#"+uploadType+"UploadButton").removeClass('btn-success');
			            $("#"+uploadType+"UploadButton").addClass('btn-primary');
						$("#"+uploadType+"UploadButton").css("display","none");
						$("#"+uploadType+"ChooseFileButton").css("display","inline-block");
		            },1000);
					$("#"+uploadType+"UploadForm")[0].reset();
	        	}else if(data.totalFileSuccessed < data.totalFileUploaded){

	        		for(i=0;i<data.fileInfos.length;i++){
	        			if(data.fileInfos[i].error){
	                		$("#JSVUploadForm").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+data.fileInfos[i].error+'</div></div></div>');
	        			}else{
		        		}
	        		}
	                $("#"+uploadType+"UploadButton").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
	                $("#"+uploadType+"UploadButton").addClass("btn-warning");
		            setTimeout(function(){
			            $("#"+uploadType+"UploadButton").html('Upload <i class="fa fa-upload" aria-hidden="true"></i>');
			            $("#"+uploadType+"UploadButton").removeClass('btn-warning');
			            $("#"+uploadType+"UploadButton").addClass('btn-primary');
						$("#"+uploadType+"UploadButton").css("display","none");
						$("#"+uploadType+"ChooseFileButton").css("display","inline-block");
		            },1000);
					$("#"+uploadType+"UploadForm")[0].reset();
	        	}else if(data.totalFileSuccessed == 0){

	        		for(i=0;i<data.fileInfos.length;i++){
	        			if(data.fileInfos[i].error){
	                		$("#JSVUploadForm").append('<div class="row"><div class="col"><div class="alert alert-danger alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+data.fileInfos[i].error+'</div></div></div>');
	        			}else{
		        		}
	        		}
	                $("#"+uploadType+"UploadButton").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
	                $("#"+uploadType+"UploadButton").addClass("btn-danger");
		            setTimeout(function(){
			            $("#"+uploadType+"UploadButton").html('Upload <i class="fa fa-upload" aria-hidden="true"></i>');
			            $("#"+uploadType+"UploadButton").removeClass('btn-danger');
			            $("#"+uploadType+"UploadButton").addClass('btn-primary');
						$("#"+uploadType+"UploadButton").css("display","none");
						$("#"+uploadType+"ChooseFileButton").css("display","inline-block");
		            },1000);
					$("#"+uploadType+"UploadForm")[0].reset();
	        	}else{
	                $("#"+uploadType+"UploadButton").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
	                $("#"+uploadType+"UploadButton").addClass("btn-danger");
		            setTimeout(function(){
			            $("#"+uploadType+"UploadButton").html('Upload <i class="fa fa-upload" aria-hidden="true"></i>');
			            $("#"+uploadType+"UploadButton").removeClass('btn-danger');
			            $("#"+uploadType+"UploadButton").addClass('btn-primary');
						$("#"+uploadType+"UploadButton").css("display","none");
						$("#"+uploadType+"ChooseFileButton").css("display","inline-block");
		            },1000);
					$("#"+uploadType+"UploadForm")[0].reset();
	        	}
	        	$("#directory_tree").html(data.folderTree);
	        },

	        error: function(data){
	            console.log(data);
                $("#"+uploadType+"UploadButton").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
                $("#"+uploadType+"UploadButton").addClass("btn-danger");
	            setTimeout(function(){
		            $("#"+uploadType+"UploadButton").html('Upload <i class="fa fa-upload" aria-hidden="true"></i>');
		            $("#"+uploadType+"UploadButton").removeClass('btn-danger');
		            $("#"+uploadType+"UploadButton").addClass('btn-primary');
					$("#"+uploadType+"UploadButton").css("display","none");
					$("#"+uploadType+"ChooseFileButton").css("display","inline-block");
	            },1000);
				$("#"+uploadType+"UploadForm")[0].reset();
	        }
	    });
		updateDeleteFileButton();
	    e.preventDefault();

	});
	$('#PVUploadForm').submit(function(e) {
	    var formData = new FormData(this);
	    uploadType = $(this)[0].elements.type.value;
	    $.ajax({
	        type:'POST',
	        url: '/CORE/uploader.php',
	        data:formData,
	        xhr: function() {
	                var myXhr = $.ajaxSettings.xhr();
	                if(myXhr.upload){
	                    myXhr.upload.addEventListener('progress',progress, false);
	                }
	                return myXhr;
	        },
	        cache:false,
	        contentType: false,
	        processData: false,
	        dataType: 'json',

	        success:function(data){
	        	console.log(data);
	        	glob = data;
	        	if(data.totalFileFailed == 0){
	        		for(i=0;i<data.fileInfos.length;i++){
	        		}
		            $("#"+uploadType+"UploadButton").html('Success <i class="fa fa-check" aria-hidden="true"></i>');
		            $("#"+uploadType+"UploadButton").removeClass('btn-primary');
		            $("#"+uploadType+"UploadButton").addClass('btn-success');
		            setTimeout(function(){
			            $("#"+uploadType+"UploadButton").html('Upload <i class="fa fa-upload" aria-hidden="true"></i>');
			            $("#"+uploadType+"UploadButton").removeClass('btn-success');
			            $("#"+uploadType+"UploadButton").addClass('btn-primary');
						$("#"+uploadType+"UploadButton").css("display","none");
						$("#"+uploadType+"ChooseFileButton").css("display","inline-block");
		            },1000);
					$("#"+uploadType+"UploadForm")[0].reset();
	        	}else if(data.totalFileSuccessed < data.totalFileUploaded){

	        		for(i=0;i<data.fileInfos.length;i++){
	        			if(data.fileInfos[i].error){
	                		$("#JSVUploadForm").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+data.fileInfos[i].error+'</div></div></div>');
	        			}else{
		        		}
	        		}
	                $("#"+uploadType+"UploadButton").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
	                $("#"+uploadType+"UploadButton").addClass("btn-warning");
		            setTimeout(function(){
			            $("#"+uploadType+"UploadButton").html('Upload <i class="fa fa-upload" aria-hidden="true"></i>');
			            $("#"+uploadType+"UploadButton").removeClass('btn-warning');
			            $("#"+uploadType+"UploadButton").addClass('btn-primary');
						$("#"+uploadType+"UploadButton").css("display","none");
						$("#"+uploadType+"ChooseFileButton").css("display","inline-block");
		            },1000);
					$("#"+uploadType+"UploadForm")[0].reset();
	        	}else if(data.totalFileSuccessed == 0){

	        		for(i=0;i<data.fileInfos.length;i++){
	        			if(data.fileInfos[i].error){
	                		$("#JSVUploadForm").append('<div class="row"><div class="col"><div class="alert alert-danger alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+data.fileInfos[i].error+'</div></div></div>');
	        			}else{
		        		}
	        		}
	                $("#"+uploadType+"UploadButton").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
	                $("#"+uploadType+"UploadButton").addClass("btn-danger");
		            setTimeout(function(){
			            $("#"+uploadType+"UploadButton").html('Upload <i class="fa fa-upload" aria-hidden="true"></i>');
			            $("#"+uploadType+"UploadButton").removeClass('btn-danger');
			            $("#"+uploadType+"UploadButton").addClass('btn-primary');
						$("#"+uploadType+"UploadButton").css("display","none");
						$("#"+uploadType+"ChooseFileButton").css("display","inline-block");
		            },1000);
					$("#"+uploadType+"UploadForm")[0].reset();
	        	}else{
	                $("#"+uploadType+"UploadButton").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
	                $("#"+uploadType+"UploadButton").addClass("btn-danger");
		            setTimeout(function(){
			            $("#"+uploadType+"UploadButton").html('Upload <i class="fa fa-upload" aria-hidden="true"></i>');
			            $("#"+uploadType+"UploadButton").removeClass('btn-danger');
			            $("#"+uploadType+"UploadButton").addClass('btn-primary');
						$("#"+uploadType+"UploadButton").css("display","none");
						$("#"+uploadType+"ChooseFileButton").css("display","inline-block");
		            },1000);
					$("#"+uploadType+"UploadForm")[0].reset();
	        	}
	        	$("#directory_tree").html(data.folderTree);
	        },

	        error: function(data){
	            console.log(data);
                $("#"+uploadType+"UploadButton").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
                $("#"+uploadType+"UploadButton").addClass("btn-danger");
	            setTimeout(function(){
		            $("#"+uploadType+"UploadButton").html('Upload <i class="fa fa-upload" aria-hidden="true"></i>');
		            $("#"+uploadType+"UploadButton").removeClass('btn-danger');
		            $("#"+uploadType+"UploadButton").addClass('btn-primary');
					$("#"+uploadType+"UploadButton").css("display","none");
					$("#"+uploadType+"ChooseFileButton").css("display","inline-block");
	            },1000);
				$("#"+uploadType+"UploadForm")[0].reset();
	        }
	    });
		updateDeleteFileButton();
	    e.preventDefault();

	});

	updateDeleteFileButton();

	function progress(e){

	    if(e.lengthComputable){
	        var max = e.total;
	        var current = e.loaded;

	        var Percentage = (current * 100)/max;
	        console.log(Percentage);

	        // $("screenshotProgress").css("display","block");
	        $("#"+uploadType+"Progress").css("width",Percentage+"%");
	        $("#"+uploadType+"Progress").attr("aria-valuenow",Percentage);

	        if(Percentage >= 100)
	        {
	           // process completed  
	            setTimeout(function(){
			        $("#"+uploadType+"Progress").css("width","0%");
			        $("#"+uploadType+"Progress").attr("aria-valuenow",0);
	            },1000);
	        }
	    }  
	 }	

	 $("#save_changes").on('click',function(){
	 	if($("#visualisation_title").val().length > 100){
	 		//Error
	 		alert("The title is too long");
	 	}else{
		 	if($("#description").val().length > 160){
		 		//Error
		 		alert("The description is too long");
		 	}else{
		 		visual_id_TBS = $("#save_changes").attr("data-visual-id");
		 		title_TBS = $("#visualisation_title").val();
		 		description_TBS = $("#description").val();
		 		bodyHtml_TBS = $("#bodyHtml").val();
		 		isLogged_TBS = (($("#logged").prop("checked"))?1:0);
		 		azure_url_TBS = "https://notebooks.azure.com/"+($("#azure-url").val().trim());
		 		visualisationsXlibrary_TBS = [];
		 		visualisationsXselflibrary_TBS = [];
				$(".libraries-checkboxes:checked").each(function(){
					if($(this).attr("data-type")=="selfCSS"){
						visualisationsXselflibrary_TBS.push({file_path:$(this).attr("data-file-path"),type:"CSS",isAsync:$(this).attr("data-isasync")});
					}else if($(this).attr("data-type")=="selfJS"){
						console.log($(this).attr("data-isasync"));
						visualisationsXselflibrary_TBS.push({file_path:$(this).attr("data-file-path"),type:"JS",isAsync:$(this).attr("data-isasync")});
					}else{
						visualisationsXlibrary_TBS.push({id:$(this).attr("id"),type:$(this).attr("data-type")});
					}
				});
				$.post("/CORE/ajax.php", { type: "update_visual", visual_id:visual_id_TBS,title:title_TBS,description:description_TBS,bodyHtml:bodyHtml_TBS,isLogged:isLogged_TBS,visualisationsXlibrary:visualisationsXlibrary_TBS,visualisationsXselflibrary:visualisationsXselflibrary_TBS,azure_url:azure_url_TBS}, function(result){
				    if (result.error) {
				      console.log(result.error);
				      if(result.error.code == 081){
				        $(".codeMessages").append('<div class="row"><div class="col"><div class="alert alert-warning alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
				        $("#save_changes").html('Retry delete');
				        $("#save_changes").addClass("btn-warning");
				      }else{
				        $(".codeMessages").append('<div class="row"><div class="col"><div class="alert alert-danger alert-dismissible fade show" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+result.error.message+'</div></div></div>');
				        $("#save_changes").html('Error <i class="fa fa-times" aria-hidden="true"></i>');
				        $("#save_changes").addClass("btn-danger");
				      }
				    }else{
				      console.log(result);
				      $("#save_changes").html('Success <i class="fa fa-check" aria-hidden="true"></i>');
				      $("#save_changes").removeClass("btn-warning");
				      $("#save_changes").removeClass("btn-danger");
				      $("#save_changes").addClass("btn-success");
				      if(Cookies.get("PRIVILEGE")>1){
				        setTimeout(function(){ window.location.reload(); }, 500);
				      }else{
				        setTimeout(function(){ window.location.replace("/Tlogin/"); }, 500);
				      }
				    }
				},"json");
		 	}
	 	}
	 });
});