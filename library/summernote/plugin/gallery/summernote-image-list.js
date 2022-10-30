(function(factory) {
	/* Global define */
	if (typeof define === "function" && define.amd) {
		// AMD. Register as an anonymous module.
		define(['jquery'], factory);
	} else if (typeof module === "object" && module.exports) {
		// Node/CommonJS
		module.exports = factory(require('jquery'));
	} else {
		// Browser globals
		factory(window.jQuery);
	}
}(function($) {
	$.extend($.summernote.plugins, {
		imageList: function(context) {
			var self = this;
			var ui = $.summernote.ui;
			var editor = context.layoutInfo.editor;
			var options = context.options;

			// Return early if not included in the toolbar
			var isIncludedInToolbar = false;

			for (var idx in options.toolbar) {
				var buttons = options.toolbar[idx][1];

				if ($.inArray("imageList", buttons) > -1) {
					isIncludedInToolbar = true;
					break;
				}
			}

			if (!isIncludedInToolbar) return;

			// Default options
			var defaultImageListOptions = {
				title: "Image List",
				//tooltip: "Image List",
				buttonHtml: '<i class="las la-images"></i>',
				spinnerHtml: '<span class="fa fa-spinner fa-spin" style="font-size: 100px; line-height: 100px; margin-left: calc(50% - 50px)"></span>',
				endpoint: "",
				fullUrlPrefix: "",
				thumbUrlPrefix: ""
			};

			// Provided options
			var imageListOptions = typeof options.imageList === "undefined" ? {} : options.imageList;

			// Assign default values if not provided
			for (var propertyName in defaultImageListOptions) {
				if (imageListOptions.hasOwnProperty(propertyName) === false) {
					imageListOptions[propertyName] = defaultImageListOptions[propertyName];
				}
			}

			// Add the button
			context.memo("button.imageList", function() {
				var button = ui.button({
					contents: imageListOptions.buttonHtml,
					tooltip: imageListOptions.tooltip,
					click: function(event) {
						self.show();
					}
				});

				// Create jQuery object from button instance.
				return button.render();
			});

			this.createDialog = function(container) {
				var dialogOption = {
					title: imageListOptions.title,
					body: [
						'<div class="image-list-content uk-height-medium" style="overflow-y: auto; overflow-x: hidden"></div>'
					].join(""),
					footer: [
						'<button type="button" class="btn btn-default image-list-btn-close">Close</button>'
					].join(""),
					closeOnEscape: true
				};

				self.$dialog = ui.dialog(dialogOption).render().appendTo(container);

				self.$dialog.find(".modal-dialog").addClass("modal-lg");
			};

			this.showDialog = function() {
				return $.Deferred(function(deferred) {
					ui.onDialogShown(self.$dialog, function() {
						context.triggerEvent("dialog.shown");

						// Show the spinner
						self.$dialog.find(".image-list-content").html(imageListOptions.spinnerHtml);

						// Retrieve the data from the endpoint and render the list
						$.get(
							imageListOptions.endpoint,
							null,
							null,
							"json"
						).done(function(data) {
							var content = [];
							var fullUrlPrefix = imageListOptions.fullUrlPrefix;
							var thumbUrlPrefix = imageListOptions.thumbUrlPrefix;

							for (var i = 0; i < data.length; i++) {
								content.push([
									'<div class="">',
									'<div class="image-list-item">',
									'<img src="' + thumbUrlPrefix + data[i] + '" data-filename="' + data[i] + '" data-full-url="' + fullUrlPrefix + data[i] + '">',
									'<p>' + data[i] + '</p>',
									'</div>',
									'</div>'
								].join(""));


							}

							self.$dialog.find(".image-list-content").html('<div class="uk-grid uk-grid-small uk-child-width-1-3@m uk-child-width-1-2@s" uk-grid>' + content.join("") + '</div>');

							self.$dialog.find(".image-list-item").click(function(event) {
								deferred.resolve({
									filename: $(this).children("img").data("filename"),
									fullUrl: $(this).children("img").data("full-url")
								});
							});
						});

						self.$dialog.find(".image-list-btn-close").click(function(event) {
							ui.hideDialog(self.$dialog);
							self.$dialog.remove();
						});
					});

					ui.onDialogHidden(self.$dialog, function() {
						if (deferred.state() === "pending") {
							deferred.reject();
						}
					});

					ui.showDialog(self.$dialog);
				});
			};

			// Insert selected image into the editor
			this.insertImage = function(filename, fullUrl) {
				fullUrl = fullUrl.replace("https:", "").replace("http:", "");
				context.invoke("editor.insertNode", $('<img src="' + fullUrl + '" data-filename="' + filename + '">')[0]);
			};

			// 
			this.show = function() {
				if (!editor.hasClass("fullscreen")) {
					$("html, body").css("overflow", "");
				}

				context.invoke("editor.saveRange");

				self.showDialog()
					.then(function(data) {
						context.invoke("editor.restoreRange");
						self.insertImage(data.filename, data.fullUrl);
						ui.hideDialog(self.$dialog);
					}).fail(function() {
						context.invoke("editor.restoreRange");
				});
			};

			this.initialize = function() {
				var container = options.dialogsInBody ? $("body") : editor;
				self.createDialog(container);
			};

			this.destroy = function() {
				ui.hideDialog(self.$dialog);
				self.$dialog.remove();
			};
		},
		gallery: function (context){
			let self = this;
			self.dialog=null;
			let ui = $.summernote.ui;
			let editor = context.layoutInfo.editor;
			let options = context.options;
			let _uid = Math.round(Math.random() * (99999 - 11111) + 11111);

			/****
			 * Properties
			 * @type {{button_html: string, list_url: string, tooltip: string, upload_url: string, title: string}}
			 */
			let default_gallery_options = {
				title: "Gallery",
				tooltip: "Gallery",
				button_html: '<i class="las la-images"></i>',
				upload_url : "",
				list_url:""
			};
			// Provided options
			let gallery_options = typeof options.gallery === "undefined" ? {} : options.gallery;
			// Assign default values if not provided
			for (let property in default_gallery_options) {
				if (gallery_options.hasOwnProperty(property) === false) {
					gallery_options[property] = default_gallery_options[property];
				}
			}
			// Add the button
			context.memo("button.gallery", function() {
				let button = ui.button({
					contents: gallery_options.button_html,
					click: function(event) {
						self.show();
					}
				});

				// Create jQuery object from button instance.
				return button.render();
			});

			/****
			 * Modal
			 */

			this.show = ()=>{
				self.dialog = UIkit.modal.dialog(self.content);
				self.dialog.show();
			}

			this.hide = ()=>{
				self.dialog.hide();
			}



			/****
			 * Native function
			 */
			this.initialize = function() {
				/******
				 * Upload Image
				 */
				window["upload_image_"+_uid] = (el)=>{
					let fd = new FormData();
					fd.append("file", el.files[0]);
					fd.append("upload_photo","OK");
					$.ajax({
						// Your server script to process the upload
						url: gallery_options.upload_url,
						type: 'POST',
						// Form data
						data: fd,

						// Tell jQuery not to process data or worry about content-type
						// You *must* include these options!
						cache: false,
						contentType: false,
						processData: false,
						success: (url)=>{
							let container = $("<div>");
							let image = $('<img>').attr('src', url);
							container.append(image[0]);
							container.click(function (){
								context.invoke("editor.insertNode", image[0]);
								self.dialog.hide();
							});
							$("#"+_uid+"_list_note").prepend(container[0]);
						}
					});
				}
				self.content = `
				<div class="uk-modal-header">
					<h3 class="uk-modal-title">${gallery_options.title}</h3>
				</div>
				<div class="uk-modal-body">
					<div>
						<input type="file" onchange='window["upload_image_${_uid}"](this)'>
					</div>
					<div id="${_uid}_list_note" class="uk-grid uk-grid-small" uk-grid>
					
					</div>
				</div>
				`;
			};

			this.destroy = function() {
				//self.dialog=null;
			};
		}
	});
}));