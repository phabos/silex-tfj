var TFAdmin = {};
TFAdmin = {
	openGmapsPopup : function(obj){
		var location = obj.attr('href');
      	$('#gmapsadmin').attr("src",location);
	    $('#gmapsModal').modal({show:true})
	},
	onAutoDestroy : function(){
		setTimeout(function(){ 
			$('.msgbox').each(function( index ) {
			    $( this ).hide('slow');
			});
		}, 3000);
	},
	onContentSubmit : function () {
		$('textarea#eg-textarea').update($('textarea#eg-textarea').editable('getHTML', true, true));
	}
}
