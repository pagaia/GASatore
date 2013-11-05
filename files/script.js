$( document ).ready( function() {
  // Handler for .ready() called.
        $("#Error").hide();
});

function getkey(e){
        if (window.event) return window.event.keyCode;
        else if (e) return e.which; else return null;
}

function goodchars(e, goods){
        var key, keychar;
        key = getkey(e);
        if (key == null) return true;
        // get character
        keychar = String.fromCharCode(key);
        keychar = keychar.toLowerCase();
        goods = goods.toLowerCase();
        // check goodkeys
        if (goods.indexOf(keychar) != -1)
        return true;
        // control keys
        if ( key==null || key==0 || key==8 || key==9 || key==27 )
        return true;
        // else return false
        return false;
}

function validate(){
        var inputs = document.getElementsByTagName('input');
        for (var i = 0; i < inputs.length; ++i) {
                if( inputs[i].value == ""){
                        var error = "Please insert values into the all fields.";
                        $('#Error').text(error);
                        $('#Error').show();
                         return false;
                }


        }

	var select = document.getElementsByTagName('select');
        for (var i = 0; i < select.length; ++i) {
                if( select[i].value == "-1"){
                        var error = "Please select one option";
                        $('#Error').text(error);
                        $('#Error').show();
                         return false;
                }

        }

        return true;

}

function checkPwd(newp, check){
	if(validate()){
		if(newp.value != check.value){
		 	var error = "The fields for new password are not equal. Please try again.";
			$('#Error').text(error);
	                $('#Error').show();
        		return false;
		}
	}else{
		return false;
	}

	return true;
}

function selectAll(first, name){
	var elm = document.getElementsByName(name)
	for( var i=0; i< elm.length; i++){
		elm[i].checked = first.checked;
	}

}
