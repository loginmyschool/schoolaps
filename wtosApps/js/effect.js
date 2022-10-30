//effects
var fadeOut = function(elem) {
    var o = 1;
    var timer = setInterval(function () {
        if (o <= 0.0) {
            clearInterval(timer);
        };
        elem.style.opacity = o;
        elem.style.filter = 'alpha(opacity=' + o * 100 + ")";
        o -= 0.1;
    }, 25);
	setTimeout(function() {
  				elem.style.display = "none";
	}, 500);
	
};
var fadeIn = function(elem, ifBlock) {
    var o = 0;
		 elem.style.opacity = "0";
		 if(ifBlock==true){
			elem.style.display = "block";
		 }else{
		 	elem.style.display = "inherit";
		 }
    var timer = setInterval(function () {
        if (o >= 1.0) {
            clearInterval(timer);
        };
        elem.style.opacity = o;
        elem.style.filter = 'alpha(opacity=' + o * 100 + ")";
        o += 0.1;
    }, 25);
};

function fadeToggle(elem, type){
	if(elem.style.display=='none'){
		fadeIn(elem, type);
		
	} else {
		fadeOut(elem);
	}
}