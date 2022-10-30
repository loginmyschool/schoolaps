/*******************************
 * Global Variables
 * ****************************/
window.global = {
	ajaxSend : function () {

	},
	ajaxComplete : function () {

	},
	ajaxSuccess : function () {

	},
	ajaxError : function () {

	},
	ajaxStop : function () {

	},

	ajaxResponseScripts :{}
};
/*******************************
 * Colors
 * ****************************/
window.Color = {
	Success : "#4EB862",
	Error 	: "#FF134A",
	Warn 	: "#FBB13C",
	Primary : "#673ab7",
	secondary 	: "#ff5722"
};
/*******************************
 * Element Selector
 * ****************************/
var xpeed = function(selector, context = null) {
	if (selector) {
		if(context) {
			if (window === this) {
				return new xpeed(selector);
			}
			if (typeof (selector) == "object") {
				this.e = selector;
				this.elements = [selector];

			} else {
				this.e = context.querySelectorAll(selector)[0];
				this.elements = context.querySelectorAll(selector)[0];
			}
			return this;
		} else {
			if (window === this) {
				return new xpeed(selector);
			}
			if (typeof (selector) == "object") {
				this.e = selector;
				this.elements = [selector];

			} else {
				this.e = document.querySelectorAll(selector)[0];
				this.elements = document.querySelectorAll(selector);
			}
			return this;
		}
	} else {
		xpeed.prototype.about();
	}
};
xpeed.fn = xpeed.prototype = {
	constructor	:	xpeed,
	about 		: 	function(){
		var about = {"Xpeed JS" : {
				"Developed by" : "Nafish Ahmed",
				"Version" : "2.0",
				"Company" : "nJS Corporation",
			}};
		console.log(about);
	},
	each 		: 	function(func){
		this.elements.forEach(function (f) {
			func(f);
		});
	},
	css 		: 	function (prop, val=""){
		element = this.e;
		var style = prop + ":" + val + ";";
		if (element.getAttribute("style")) {
			var styles = element.getAttribute("style").split(";");


			styles.forEach(function (e) {
				var nodes = e.split(":");
				if (prop.trim() !== nodes[0].trim() && nodes[0]) {
					style += nodes[0] + ":" + nodes[1] + ";";
				}
			});
		}
		element.setAttribute("style", style);
	},
	//functions
	serialize 	: 	function (type="") {
		var object = {};
		var form = this.e;
		var inputs = form.querySelectorAll("input, select, textarea");
		inputs.forEach(function (input) {
			if(input.type==="file"){
				object[input.name] = input.files[0];
			} else {
				object[input.name] = input.value;
			}
		});

		switch (type) {
			case "formdata":
				formdata = new FormData;
				for (var [key, value] of Object.entries(object)) {
					formdata.append(key, value);
				}
				return formdata;
				break;
			case "json":
				return JSON.stringify(object);
				break;
			default:
				return object;
				break;
		};
	},
	append 		:	function(element){
		var div = document.createElement('div');
		div.innerHTML = element.trim();
		element = div.firstChild;
		this.e.appendChild(element);
	},
	editable 	:  	function (action) {
		let form = this.e;
		switch (action) {
			case false:
				form.setAttribute("editable", "false");
				break;
			case true:
				form.setAttribute("editable", "true");
				break;
		}


		xpeed("input, select, textarea").each(function (input) {
			switch (action) {
				case false:
					input.setAttribute("disabled", "disabled")
					break;
				case true:
					input.removeAttribute("disabled", "disabled")
					break;
			}
		});
	},
	addClass	: 	function(skt){
		this.e.classList.add(skt);
	},
	removeClass : 	function(skt){
		this.e.classList.remove(skt);
	},
	hasClass	:	function(skt){
		return this.e.classList.contains(skt);
	},
	/////Events
	click 		:	function(method){
		this.e.addEventListener("click",function () {
			method();
		});
	},
	submit 		:	function(method){
		var element = this.e;
		element.addEventListener("submit", function (e) {
			e.preventDefault();
			if (!element.hasAttribute("disabled")) {
				method(e);
			}
		});
	},
	change 		:	function(method){
		this.e.addEventListener("change", function (e){
			e.preventDefault();
			method(e);
		});

	},
	//property
	html 		: 	function(newhtml=null){
		if(newhtml){
			this.e.innerHTML = newhtml;
		}
		return this.e.innerHTML;
	},
	val 		:	function(newval=null) {
		if(newval){
			this.e.value = newhtml;
		}
		return this.e.value;
	},
	attr		:	function(prop, val = null){
		if(value !=null){
			this.e.setAttribute(prop, val);
		}
		return this.e.getAttribute(prop);
	},
	checked 	:	function(order=null) {
		if(order===true && order!=null){
			this.e.checked = true;
		}
		else if(order===false && order!=null){
			this.e.checked = false;
		}
		return this.e.checked;
	},
	parent		:	function(){
		this.e = this.e.parentNode;
		this.elements = [this.e.parentNode];
		return this;
	},
	child		: function(el){
		this.e = xpeed(el, this.e).e;
		this.elements = [xpeed(el, this.e).elements];
		return this;
	},
	///Effects
	fadeIn 		: 	function (timeGiven=2000, displayGiven="inherit", callback=function () {}) {
		let count = 10;
		let time_per_count = timeGiven/count;
		let opacity_per_count = 1/count;
		let element = this.e;
		let opacity = 0;
		///

		element.style.display = displayGiven;
		let loop = setInterval(function () {
			count--;
			opacity+=opacity_per_count;
			element.style.opacity = opacity;
			if(count===0){
				clearInterval(loop);
				element.style.opacity = 1;
				callback();
			}
		}, time_per_count);

	},
	fadeOut 	: 	function (timeGiven=2000, displayGiven="inherit", callback=function () {}) {
		let count = 10;
		let time_per_count = timeGiven/count;
		let opacity_per_count = 1/count;
		let element = this.e;
		///
		let opacity = 1;
		let loop = setInterval(function () {
			count--;
			opacity-=opacity_per_count;

			element.style.opacity = opacity;
			if(count===0){
				clearInterval(loop);
				element.style.opacity = 0;
				element.style.display = "none";
				callback();
			}
		}, time_per_count);


	},
	hide		:	function () {
		this.style("display", "none");
		return this;
	},
	show		:	function (disp="inherit") {
		this.style("display", disp);
		return this;
	},
	toggle		: 	function (displayType="inherit") {
		var disp=!displayType?"inherit":displayType;

		this.e.forEach(function(element){
			if (element.style.display !== 'none') {
				element.style.display = 'none';
			} else {
				element.style.display = disp;
			}
		});
		return this;
	},
	///Other stuffs
	load		:	function (link, callBack) {
		let res_content = this.e;
		xpeed.ajax({
			url 	:	link,
			start	:	function(){
				xpeed(res_content).html("Please wait...")
			},
			success	:	function (response) {
				xpeed(res_content).html(response);
			},
			error	:	function (message) {
				console.log(message);
			}
		})
	}
};
xpeed.ajax = function(parameters = {}){
	this.url = "";
	this.formdata = null;
	this.data_type = "text/html";
	this.method="GET";
	//callback
	this.onStartFunction 	= function 	(e) {};
	this.onSuccessFunction 	= function 	(e) {};
	this.onErrorFunction 	= function 	() {};
	this.onEndFunction 		= function 	(e) {};
	this.onProgressFunction 	= function 	() {};
	this.onAbortFunction 	= function	(){};
	//object
	this.xmlHttp = null;
	if (this instanceof xpeed.ajax) {

		try {
			// Opera 8.0+, Firefox, Safari
			this.xmlHttp = new XMLHttpRequest();
		} catch (e) {
			// Internet Explorer Browsers
			try {
				this.xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					this.xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {
					// Something went wrong
					alert("Your browser broke!");
				}
			}
		}
		///set parameters
		if("url" in parameters){this.url = parameters.url;}
		if("content_type" in parameters){this.data_type = parameters.content_type;}
		if("method" in parameters){this.method = parameters.method;}
		if("data" in parameters){this.formdata  = parameters.data;}
		//EVENTS
		if("start" in parameters){this.onStartFunction = parameters.start;}
		if("success" in parameters){this.onSuccessFunction = parameters.success;}
		if("error" in parameters){this.onErrorFunction = parameters.error;}
		if("end" in parameters){this.onEndFunction = parameters.end;}
		if("progress" in parameters){this.onProgressFunction = parameters.progress;}
		if((this.method==="get" || this.method==="GET") &&this.formdata!=null){
			this.url+="?";
			for (var field of this.formdata.entries()) {
				this.url+=field[0]+"="+field[1]+"&";
			}
			var lastChar = this.url.slice(-1);
			if(lastChar==="&"||lastChar==="?"){
				this.url = this.url.slice(0, -1);
			}
		}
		this.commit();
	} else return new xpeed.ajax(parameters);
};
xpeed.ajax.prototype = {
	commit : function () {
		this.onStartFunction();
		this.xmlHttp.addEventListener("loadend", this.onEndFunction);
		this.xmlHttp.upload.addEventListener("progress", this.onProgressFunction, false);
		this.xmlHttp.addEventListener("error", this.onErrorFunction);
		this.xmlHttp.addEventListener("abort", this.onAbortFunction);
		///Success Function
		let successFunction = this.onSuccessFunction;
		this.xmlHttp.onreadystatechange = function () {
			if (this.readyState === 4) {
				if (this.status === 200) {
					var scripttext = this.response;
					var re = /<script\b[^>]*>([\s\S]*?)<\/script>/gm;
					var match;
					while (match === re.exec(scripttext)) {
						window.eval(match[1]);
					}
					successFunction(this.response);
				}
			}
		};


		this.xmlHttp.open(this.method, this.url, true);
		this.xmlHttp.setRequestHeader('Accept', this.data_type);

		if (this.formdata != null && (this.method === "post" || this.method === "POST")) {
			this.formdata.append("timestamp", Math.floor(Date.now() / 1000));
			this.xmlHttp.send(this.formdata);
		} else {
			this.xmlHttp.send();
		}
	}
}
/*******************************
 * Ajax
 * ****************************/
class Ajax {
	url = "";
	formdata = null;
	data_type = "text/html";
	method="GET";
	//callback
	onStartFunction = function (e) {

	};
	onSuccessFunction = function (e) {

	};
	onErrorFunction = function () {

	};
	onEndFunction = function (e) {
		window.alert(e);
	};
	onProgressFunction = function () {

	};
	onAbortFunction = function(){

	};
	//object
	xmlHttp=new XMLHttpRequest();
	constructor(parameters){

		try {
			// Opera 8.0+, Firefox, Safari
			this.xmlHttp = new XMLHttpRequest();
		} catch (e) {

			// Internet Explorer Browsers
			try {
				this.xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {

				try {
					this.xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {
					// Something went wrong
					alert("Your browser broke!");
				}
			}
		}
		///set parameters
		if("url" in parameters){this.url = parameters.url;}
		if("content_type" in parameters){this.data_type = parameters.content_type;}
		if("method" in parameters){this.method = parameters.method;}
		if("data" in parameters){this.formdata  = parameters.data;}
		//EVENTS
		if("start" in parameters){this.onStartFunction = parameters.start;}
		if("success" in parameters){this.onSuccessFunction = parameters.success;}
		if("error" in parameters){this.onErrorFunction = parameters.error;}
		if("end" in parameters){this.onEndFunction = parameters.end;}
		if("progress" in parameters){this.onProgressFunction = parameters.progress;}


		if((this.method==="get" || this.method==="GET") &&this.formdata!=null){
			this.url+="?";
			for (var field of this.formdata.entries()) {
				this.url+=field[0]+"="+field[1]+"&";
			}
			var lastChar = this.url.slice(-1);
			if(lastChar==="&"||lastChar==="?"){
				this.url = this.url.slice(0, -1);
			}
		}


		this.commit();
	};
	commit() {
		console.log(this.url);
		this.onStartFunction();
		this.xmlHttp.addEventListener("loadend", this.onEndFunction);
		this.xmlHttp.upload.addEventListener("progress", this.onProgressFunction, false);
		this.xmlHttp.addEventListener("error", this.onErrorFunction);
		this.xmlHttp.addEventListener("abort", this.onAbortFunction);
		///Success Function
		var oReq = this.xmlHttp;
		var successFunction = this.onSuccessFunction;
		this.xmlHttp.onreadystatechange = function () {
			if (oReq.readyState === 4) {
				if (oReq.status === 200) {
					var scripttext = oReq.response;
					var re = /<script\b[^>]*>([\s\S]*?)<\/script>/gm;
					var match;
					while (match = re.exec(scripttext)) {
						window.eval(match[1]);
					}
					successFunction(oReq.response);
				}
			}
		};


		this.xmlHttp.open(this.method, this.url, true);
		this.xmlHttp.setRequestHeader('Accept', this.data_type);

		if (this.formdata != null && (this.method === "post" || this.method === "POST")) {
			this.formdata.append("timestamp", Math.floor(Date.now() / 1000));
			this.xmlHttp.send(this.formdata);
		} else {
			this.xmlHttp.send();
		}
	};
}
/*******************************
 * Popup
 * ****************************/
window.Popup = function(parameters) {
	this.content = "This is a sample popup";
	this.title = "New Popup";

	if ("content" in parameters) {
		this.content = parameters.content;
	}

	if ("title" in parameters) {
		this.title = parameters.title;
	}

	xpeed(".xpd-popup .close-button").click(function () {
		window.Popup.prototype.hide();
	});

};
window.Popup.prototype.show =  function(){
	xpeed("body").style("overflow-y", "hidden");
	xpeed(".main").style("filter", "blur(5px)");

	//set contens
	xpeed(".xpd-popup .content").html(this.content);
	xpeed(".xpd-popup .title").html(this.title);

	xpeed(".xpd-popup ").show();
};
window.Popup.prototype.hide = function(){
	xpeed("body").style("overflow-y", "auto");
	xpeed(".main").style("filter", "blur(0px)");
	//remove contens
	xpeed(".xpd-popup .content").html("");
	xpeed(".xpd-popup .title").html("");
	xpeed(".xpd-popup ").hide();
};
/*******************************
 * Toast
 * ****************************/
class Toast  {
	constructor(message){
		this.template = document.createElement("div");
		this.random_class = "progress_alert" + (Math.floor((Math.random() * 10) + 1));

		this.template.classList.add("xpd-alert", "p-l", "p-left-m", "p-right-m", "m-s", "border-radius-xs", "text-m","white", this.random_class);
		this.template.style.backgroundColor = "rgba(37,37,37,1)";
		this.template.style.minWidth = "200px";
		this.template.innerHTML = message;
	}
	show(){
		if(!document.querySelector(".alert-container")){
			let alert_container = document.createElement("div");
			alert_container.style.position = "fixed";
			alert_container.style.left		= "0";
			alert_container.style.bottom	= "0";

			alert_container.classList.add("alert-container");

			document.body.appendChild(alert_container);
		}
		document.querySelector(".alert-container").appendChild(this.template);
		return this;
	};
	destroy(timeout=0){
		var template = this.template;
		setTimeout(function () {
			document.querySelector(".alert-container").removeChild(template);
		}, timeout);
		return this;
	};
	setMessage(message){
		this.template.innerHTML = message;
		return this;
	};
	setBackground(color){
		this.template.style.backgroundColor = color;
		return this;
	};
}
Toast.Length  = {
	Long 	: 2000,
	Medium	: 1000,
	Short	: 500
};
/*******************************
 * Confirmed
 ******************************/
window.ask = function(parameters) {
	let headerText = "Are you sure?";
	let contentText = "Lorem ipsum dolar";
	let allowFunction = null;
	let denyFunction = null;


	if ("allow" in parameters) {
		allowFunction = parameters.allow;
	}

	if ("deny" in parameters) {
		denyFunction = parameters.deny;
	}

	if("title" in parameters){
		headerText = parameters.title;
	}

	if("content" in parameters){
		contentText = parameters.content;
	}

	/****************/


	let header = document.createElement("div");
	header.setAttribute("class", "head p-xxl p-bottom-none text-l left");
	header.innerHTML = headerText;

	//Content

	let content = document.createElement("div");
	content.setAttribute("class", "p-xxl p-top-s p-bottom-m text-l left");
	content.innerHTML = contentText;

	let allow_button = document.createElement("button");
	allow_button.setAttribute("class", "p-s p-left-l p-right-l hover-background-light-green hover-white pointable");
	allow_button.innerHTML = "Confirm";
	let deny_button = document.createElement("button");
	deny_button.setAttribute("class", "p-s p-left-l p-right-l m-left-m hover-background-red hover-white pointable");
	deny_button.innerHTML = "Cancel";
	let footer = document.createElement("div");
	footer.setAttribute("class", "left p-xxl p-top-s");

	footer.appendChild(allow_button);
	footer.appendChild(deny_button);
	/**************/
	//Wrapper
	let wrapper = document.createElement("div");
	wrapper.setAttribute("style", "min-width:250px");
	wrapper.setAttribute("class", " background-white");
	wrapper.appendChild(header);
	wrapper.appendChild(content);
	wrapper.appendChild(footer);

	//Main content
	let template = document.createElement("div");
	template.setAttribute("class","xpd-popup  p-l center");
	//template.setAttribute("style", );
	template.style.cssText ="display:flex; justify-content: center; align-items: center; background-color:rgba(0,0,0,0.3); position: fixed; height: 100%; width: 100%; top: 0; left: 0; ";
	template.appendChild(wrapper);
	document.body.appendChild(template);
	xpeed(allow_button).click(function () {
		document.body.removeChild(template);
		allowFunction?allowFunction():null;
	});
	xpeed(deny_button).click(function () {
		document.body.removeChild(template);
		denyFunction?denyFunction():null;
	});
};








