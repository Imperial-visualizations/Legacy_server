
$("#description").on('keyup',function(){
	if($("#description").val().length > 160){
		$("#limit-160-char").addClass("red");
	}else{
		$("#limit-160-char").removeClass("red");
	}
	$("#limit-160-char").attr("data-limit-display",($("#description").val().length+"/160"));
	if($(this).val().match(/^[0-9a-zA-z\s\\(\)\=\[\]\{\}\^_.,'"\!\?\+\-\:\;]+$/g) === null){
		console.log("BAD BOY");
	}else{

	}
	$("#previewDescription").text($("#description").val());
});
$("#limit-160-char").attr("data-limit-display",($("#description").val().length+"/160"));

$(".collapse").on('hide.bs.collapse', function () {
  $("#"+$(this).attr("aria-labelledby")+">h5").attr("data-expand-display","+");
});
$(".collapse").on('show.bs.collapse', function () {
  $("#"+$(this).attr("aria-labelledby")+">h5").attr("data-expand-display","-");
});

