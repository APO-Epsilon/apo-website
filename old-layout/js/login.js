$(document).ready(function(){
  $("input").focus(function(){
    $(this).css("background-color","#FFCB46");
  });
  $("input").blur(function(){
    $(this).css("background-color","#E4E4E9");
  });
    $('input[type="text"]').addClass("idleField");
	$('input[type="text"]').focus(function() {
		$(this).removeClass("idleField").addClass("focusField");
        if (this.value == this.defaultValue){
        this.value = '';
    }
        if(this.value != this.defaultValue){
	this.select();
        }
    });
    $('input[type="text"]').blur(function() {
    $(this).removeClass("focusField").addClass("idleField");
		if ($.trim(this.value === '')){
        this.value = (this.defaultValue ? this.defaultValue : '');
    }
    });
});