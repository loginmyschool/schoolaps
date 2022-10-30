function empty(a,b,c,d,e,f,g){
	
}
//check connection

function doesConnectionExist() {
    if(navigator.onLine == true){
		return true;	
	} else {
		return false;
	}
}
//end

function spinar(size, cls, color){
	if (color == ""){color = "#dead1b";}
	var spinar = ''+
		'<svg class="spinner '+cls+'" width="'+size+'" height="'+size+'" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">'+
   			'<circle class="path" fill="none" stroke="'+color+'" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>'+
		'</svg>'+

	'';
	return spinar;
}
function loading(type){
	if(type=="android"){
		var data = ''+
		'<div class="loading android p-l" >'+
			'<div class="wrapper background-white p-l border-radius-s box-shadow-xs animation-slow">'+
				'<table>'+
					'<tr>'+
						'<th width="60px;">'+
							'<svg class="spinner" width="35px" height="35px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">'+
								'<circle class="path" fill="none" stroke="var(--green)" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>'+
							'</svg>'+
						'</th>'+
						'<td class="text-m">'+
							'Please wait...'+
						'</td>'+
					'</tr>'+
				'</table>'+
			'</div>'+
		'</div>';
	} else if(type=="ios") {
		var data = ''+
		'<div class="loading" >'+
			'<div class="inner">'+
				 '<svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 27 27">'+
					'<path d="M18.696,10.5c-0.275-0.479-0.113-1.09,0.365-1.367l4.759-2.751c0.482-0.273,1.095-0.11,1.37,0.368 c0.276,0.479,0.115,1.092-0.364,1.364l-4.764,2.751C19.583,11.141,18.973,10.977,18.696,10.5z"/>'+
					'<path d="M16.133,6.938l2.75-4.765c0.276-0.478,0.889-0.643,1.367-0.366c0.479,0.276,0.641,0.886,0.365,1.366l-2.748,4.762 C17.591,8.415,16.979,8.58,16.5,8.303C16.021,8.027,15.856,7.414,16.133,6.938z"/>'+
					'<path d="M13.499,7.5c-0.552,0-1-0.448-1-1.001V1c0-0.554,0.448-1,1-1c0.554,0,1.003,0.447,1.003,1v5.499 C14.5,7.053,14.053,7.5,13.499,7.5z"/>'+
					'<path d="M8.303,10.5c-0.277,0.477-0.888,0.641-1.365,0.365L2.175,8.114C1.697,7.842,1.532,7.229,1.808,6.75 c0.277-0.479,0.89-0.642,1.367-0.368l4.762,2.751C8.416,9.41,8.58,10.021,8.303,10.5z"/>'+
					'<path d="M9.133,7.937l-2.75-4.763c-0.276-0.48-0.111-1.09,0.365-1.366c0.479-0.277,1.09-0.114,1.367,0.366l2.75,4.765 c0.274,0.476,0.112,1.088-0.367,1.364C10.021,8.581,9.409,8.415,9.133,7.937z"/>'+
					'<path d="M6.499,14.5H1c-0.554,0-1-0.448-1-1c0-0.554,0.447-1.001,1-1.001h5.499c0.552,0,1.001,0.448,1.001,1.001 C7.5,14.052,7.052,14.5,6.499,14.5z"/>'+
					'<path d="M8.303,16.502c0.277,0.478,0.113,1.088-0.365,1.366l-4.762,2.749c-0.478,0.273-1.091,0.112-1.368-0.366 c-0.276-0.479-0.111-1.089,0.367-1.368l4.762-2.748C7.415,15.856,8.026,16.021,8.303,16.502z"/>'+
					'<path d="M10.866,20.062l-2.75,4.767c-0.277,0.475-0.89,0.639-1.367,0.362c-0.477-0.277-0.642-0.886-0.365-1.365l2.75-4.764 c0.277-0.477,0.888-0.638,1.366-0.365C10.978,18.974,11.141,19.585,10.866,20.062z"/>'+
					'<path d="M13.499,19.502c0.554,0,1.003,0.448,1.003,1.002v5.498c0,0.55-0.448,0.999-1.003,0.999c-0.552,0-1-0.447-1-0.999v-5.498 C12.499,19.95,12.946,19.502,13.499,19.502z"/>'+
					'<path d="M17.867,19.062l2.748,4.764c0.275,0.479,0.113,1.088-0.365,1.365c-0.479,0.276-1.091,0.112-1.367-0.362l-2.75-4.767 c-0.276-0.477-0.111-1.088,0.367-1.365C16.979,18.424,17.591,18.585,17.867,19.062z"/>'+
					'<path d="M18.696,16.502c0.276-0.48,0.887-0.646,1.365-0.367l4.765,2.748c0.479,0.279,0.64,0.889,0.364,1.368 c-0.275,0.479-0.888,0.64-1.37,0.366l-4.759-2.749C18.583,17.59,18.421,16.979,18.696,16.502z"/>'+
					'<path d="M25.998,12.499h-5.501c-0.552,0-1.001,0.448-1.001,1.001c0,0.552,0.447,1,1.001,1h5.501c0.554,0,1.002-0.448,1.002-1 C27,12.946,26.552,12.499,25.998,12.499z"/>'+
				  '<svg>'+
			'</div>'+			
		'</div>';
	}
	return data;
}

/////
function spinerInline(){
	var spin = "<center><div style=' height:30px; width:30px; background:#fff; padding:5px; box-shadow:0px 0px 1px rgba(0,0,0,0.1); border-radius:100%; '><img src='wtosApps/images/tail-spin.svg' height='20px' width='20px'/></div></center>";
	return spin;
}
function getEl(type,el){
	if (type == 'id' || type=='#'){
		return document.getElementById(el);
	}
	if (type == '.'){
		var elm = document.getElementsByClassName(el);
		for(i=0; i<elm.length; i++){
			return elm[i];
		}
	}
}
//check string
function checkString(el){
	var	str = el.split("").length;
	if(str > 20 ){ var text = "...";} else {var text = "";}
	return text;
}
////thumb 
function thumbUrl(file){
	
	var image = (file.match(/\.(jpeg|jpg|gif|png)$/) != null);
	var pdf = (file.match(/\.(pdf)$/) != null);
	///file exist
	var http = new XMLHttpRequest();
    http.open('HEAD', file, false);
    http.send();
    var exist =  http.status!=404;
	/////////
	if(image == true && exist == true){
		file = file;
	} else if(pdf == true){
		file = "images/pdf.png";
	} else {
		file = "images/file.png";
	}	
	return file;
	
}
//rand color
function randColor(){
	var back = ["#f44336","#607d8b","#3f51b5","#2196f3","#4caf50", "#ff7043","#7e57c2","#536DFE","#00ACC1","#00B8D4","#0091EA"];
  	return back[Math.floor(Math.random() * back.length)];	
}
//alertbox
function alerter(text){
	if (typeof Website2APK != "undefined") {
   		Website2APK.showToast(text);
	} else {
		getEl(".","alertBox").innerHTML = text;
		getEl(".","alertBox").style.opacity = 1;
		getEl(".","alertBox").style.bottom = "0px"; 
		setTimeout(function(){
			getEl(".","alertBox").style.opacity = 0;
			getEl(".","alertBox").style.bottom = "-80px";  
		}, 1500);
	}
}
////conform
function confirmer(text,yesFunc) {
	var cBox = getEl('.','confirmBox');
    var c = getEl('.','confirm');
    getEl('.','confirm-text').innerHTML = text;
    fadeIn(cBox);
	
    getEl('.','confirmYes').addEventListener('click', function() {  
         yesFunc();
         fadeOut(cBox);
         yesFunc = function () {};
   	}, false);
    getEl('.','confirmNo').addEventListener('click', function() {  
         fadeOut(cBox);
         yesFunc = function () {};
    }, false);
}
//downloader
function downloader(url, type, name){
	var ajax=new XMLHttpRequest();
	ajax.open("GET", url, true);
	ajax.responseType = 'blob';
	ajax.onreadystatechange = function (oEvent) { 
		if (ajax.readyState === 4) {  
        	if (ajax.status === 200) { 
				ajax.onload=function(e){download(ajax.response, name, type ); }
			} else { 
				alerter('Ops! file is deleted');
			}
		}
	}
	if (typeof Website2APK != "undefined") {
   		Website2APK.openExternal(url);
	} else {
		ajax.send();
	}
}
//page
function pager(order, data, name){
	if(order == 'close'){
		fadeOut(getEl('.', 'page'));
	}
	
	
	///fadeIn
	if(order == 'open'){
		getEl('.', 'page').innerHTML = ''+
			'<header id="header" class="background-green">'+
				'<table style="width:100%;">'+
					'<tr>'+
						'<td width="40px" style="text-align:left">'+
							'<span onclick="pager(`close`);"><i class="mi mi-arrow-back"></i></span> '+
						'</td>'+
						'<td>'+
							'<a style="float:left" id="titleBar">'+name+'</a>'+
						'</td>'+
					'</tr>'+
				'</table>'+
		
			'</header>'+
			'<div class="scroll" style="height:calc(100% - 60px)">'+
			data+
			'</div>'+
		'';
		
		///profile
		
		
		///
		fadeIn(getEl('.', 'page'));
		
	}
}
///date time
function today(part, date, form){
	
	if(date != ""){
		var today = new Date(date);	
	} else {
		var today = new Date();	
	}
	
	var dd = today.getDate();
	var mm = today.getMonth()+1;
	var yyyy = today.getFullYear();
	
	
	var MM = ["","Jan", "Feb", "March", "April", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"];
	
	///dd///
	var s = ["th","st","nd","rd"], v = dd%100;
	var DD = dd+(s[(v-20)%10]||s[v]||s[0]);
	/////
	var sd = '', sm = '';
	if(isNaN(mm)){mm = "", sm = ""} else {sm = MM[mm];}
	if(isNaN(dd)){dd = "", sd = ""} else {sd = DD;}
	if(isNaN(yyyy)){yyyy = ""}
	

	

	if(form == "dd/mm/yyyy"){date = dd+"/"+mm+"/"+yyyy;}
	if(form == "dd-mm-yyyy"){date = dd+"-"+mm+"-"+yyyy;;}
	if(form == "sd sm yyyy"){date = sd+" "+sm+" "+yyyy;}
	if(form == "sd sm"){date = sd+" "+sm;}
	if(form == "sm yyyy"){date = sm +" "+yyyy;}
	/////time 
	var hours = today.getHours();
  	var minutes = today.getMinutes();
	var seconds = today.getSeconds();
  	var ampm = hours >= 12 ? 'PM' : 'AM';
  	hours = hours % 12; 
	if(hours < 10){hours = hours  ? '0'+hours : 12; } else {hours = hours  ? hours : 12; };
  	minutes = minutes < 10 ? '0'+minutes : minutes;
	seconds = seconds < 10 ? '0'+seconds : seconds;
  	var time = hours + ':' + minutes+ '' + ampm;
	////////
	if(part == "date"){return date;};
	if(part == "time"){return time;};
	
};
////json loaded
function jsonLoader(url, name, callback, cbd, cbd2, loading){
	var ajax= window.XMLHttpRequest ?
        new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
		
		ajax.onloadstart = function() {
			//ajax loader
    		if(loading != "no"){
				fadeIn(getEl('.', 'loading'));
			};
		};
		ajax.onreadystatechange = function (oEvent) {  
    		if (ajax.readyState === 4) {  
        		if (ajax.status === 200) {  
          			var data = JSON.parse(this.responseText);
					window[name] = data;
					callback(cbd, cbd2);
					//ajax loader
					if(loading != "no"){
						fadeOut(getEl('.', 'loading'));
					};
        		} else {  
           			
					if(loading != "no"){
						fadeOut(getEl('.', 'loading'));
					}
        		}  
    		}  
		};
		ajax.onloadend = function() {
    		
        	
		};
	ajax.open("GET", url, true);
	ajax.send();
}
////ajax with callback//////
function ajaxCallback(url, method,  callback, callbackData,loading){
	
	var ajax= window.XMLHttpRequest ?
        	new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
	//onload end
		ajax.onloadstart = function (e) {
			if(loading != "no"){
				fadeIn(getEl('.', 'loading'));
			};
		};
		ajax.onreadystatechange = function (oEvent) {  
    		if (ajax.readyState === 4) {  
        		if (ajax.status === 200) { 
          			callback(callbackData);
					if(loading != "no"){
						fadeOut(getEl('.', 'loading'));
					}
        		} else {  
					if(loading != "no"){
						fadeOut(getEl('.', 'loading'));
					}
					alerter('Ops! something went wrong.');
        		}  
    		}  
		};
		
		ajax.open(method, url);
		ajax.send();
		

}
///////ajax for for upload a data
function ajaxUploadCallback(url, method, formdata, callback, callbackData, cbd){
		
		
		
		var ajax= window.XMLHttpRequest ?
        new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
		//onload end
		ajax.onloadstart = function (e) {
			fadeIn(getEl('.','progressBar'));
		};
		//on load progress
		ajax.upload.onprogress = function (e) {
    		if (e.lengthComputable) {
				getEl("id","progressBar").style.width = (Math.floor((e.loaded / e.total) * 100) + '%');
				getEl(".","progressText").innerHTML = (Math.floor((e.loaded / e.total) * 100) + '%');
				
    		};
		};
		ajax.onreadystatechange = function (oEvent) {  
    		if (ajax.readyState === 4) { 
        		if (ajax.status === 200) {
					alerter('Successfull');
					setTimeout(function(){
						fadeOut(getEl('.','progressBar'));
						getEl("id","progressBar").style.width = '0%';
          				callback(callbackData, cbd);
						pager('close');
					},3000);
					
        		} else {  
					fadeOut(getEl('.','progressBar'));
					getEl("id","progressBar").style.width = '0%';
					pager('close');
					alerter('Ops! Something went wrong.');
        		}  
    		}  
		};
		
		ajax.open(method, url, true);
		ajax.send(formdata);
		

}