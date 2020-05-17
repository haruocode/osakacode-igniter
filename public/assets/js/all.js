/*!
 * JavaScript Cookie v2.1.1
 * https://github.com/js-cookie/js-cookie
 *
 * Copyright 2006, 2015 Klaus Hartl & Fagner Brack
 * Released under the MIT license
 */
;(function (factory) {
	if (typeof define === 'function' && define.amd) {
		define(factory);
	} else if (typeof exports === 'object') {
		module.exports = factory();
	} else {
		var OldCookies = window.Cookies;
		var api = window.Cookies = factory();
		api.noConflict = function () {
			window.Cookies = OldCookies;
			return api;
		};
	}
}(function () {
	function extend() {
		var i = 0;
		var result = {};
		for (; i < arguments.length; i++) {
			var attributes = arguments[i];
			for (var key in attributes) {
				result[key] = attributes[key];
			}
		}
		return result;
	}

	function init(converter) {
		function api(key, value, attributes) {
			var result;
			if (typeof document === 'undefined') {
				return;
			}

			// Write

			if (arguments.length > 1) {
				attributes = extend({
					path: '/'
				}, api.defaults, attributes);

				if (typeof attributes.expires === 'number') {
					var expires = new Date();
					expires.setMilliseconds(expires.getMilliseconds() + attributes.expires * 864e+5);
					attributes.expires = expires;
				}

				try {
					result = JSON.stringify(value);
					if (/^[\{\[]/.test(result)) {
						value = result;
					}
				} catch (e) {
				}

				if (!converter.write) {
					value = encodeURIComponent(String(value))
						.replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent);
				} else {
					value = converter.write(value, key);
				}

				key = encodeURIComponent(String(key));
				key = key.replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent);
				key = key.replace(/[\(\)]/g, escape);

				return (document.cookie = [
					key, '=', value,
					attributes.expires && '; expires=' + attributes.expires.toUTCString(), // use expires attribute, max-age is not supported by IE
					attributes.path && '; path=' + attributes.path,
					attributes.domain && '; domain=' + attributes.domain,
					attributes.secure ? '; secure' : ''
				].join(''));
			}

			// Read

			if (!key) {
				result = {};
			}

			// To prevent the for loop in the first place assign an empty array
			// in case there are no cookies at all. Also prevents odd result when
			// calling "get()"
			var cookies = document.cookie ? document.cookie.split('; ') : [];
			var rdecode = /(%[0-9A-Z]{2})+/g;
			var i = 0;

			for (; i < cookies.length; i++) {
				var parts = cookies[i].split('=');
				var name = parts[0].replace(rdecode, decodeURIComponent);
				var cookie = parts.slice(1).join('=');

				if (cookie.charAt(0) === '"') {
					cookie = cookie.slice(1, -1);
				}

				try {
					cookie = converter.read ?
						converter.read(cookie, name) : converter(cookie, name) ||
					cookie.replace(rdecode, decodeURIComponent);

					if (this.json) {
						try {
							cookie = JSON.parse(cookie);
						} catch (e) {
						}
					}

					if (key === name) {
						result = cookie;
						break;
					}

					if (!key) {
						result[name] = cookie;
					}
				} catch (e) {
				}
			}

			return result;
		}

		api.set = api;
		api.get = function (key) {
			return api(key);
		};
		api.getJSON = function () {
			return api.apply({
				json: true
			}, [].slice.call(arguments));
		};
		api.defaults = {};

		api.remove = function (key, attributes) {
			api(key, '', extend(attributes, {
				expires: -1
			}));
		};

		api.withConverter = init;

		return api;
	}

	return init(function () {
	});
}));
var UploaderScript = UploaderScript || {};
UploaderScript.config = {
	url: '/file/upload',
	file_ext: 'jpg,gif,png,jpeg,bmp',
	browse_button: '',
	image_wrapper: '',
	csrf_token: {},
	loading: '',
	error_wrapper: '',
	max_file_size: '10mb',
	multi_selection: false,
	file_name: ''
};
UploaderScript.init = function (option, callback) {
	$.extend(UploaderScript.config, option);
	if (!UploaderScript.config.browse_button || !$('#' + UploaderScript.config.browse_button).length) {
		console.log('Error : Khong tim thay browse_button');
		return false;
	}

	var uploader = new plupload.Uploader({
		runtimes: 'html5,flash,html4',
		multipart_params: UploaderScript.config.csrf_token,
		browse_button: UploaderScript.config.browse_button,
		max_file_size: UploaderScript.config.max_file_size,
		multi_selection : UploaderScript.config.multi_selection,
		url: UploaderScript.config.url,
		flash_swf_url: 'plupload/js/plupload.flash.swf',
		silverlight_xap_url: 'plupload/js/plupload.silverlight.xap',
		filters: [{
			title: "Image files",
			extensions: UploaderScript.config.file_ext
		}]
	});
	uploader.init();
	uploader.bind('FilesAdded', function (up, file) {
		uploader.start();
	});
	uploader.bind('UploadProgress', function (up, file) {
		if (UploaderScript.config.loading) {
			$('#' + UploaderScript.config.loading).html(file.percent + '%');
		}
	});
	uploader.bind('FileUploaded', function (up, file, resp) {
		if (resp.status == 200) {
			var fileInfo = resp.response;
			fileInfo = JSON.parse(fileInfo);
			filename = fileInfo.result.filename;
			filepath = fileInfo.result.filepath;
			$('#' + UploaderScript.config.image_wrapper).attr('src', filepath);
			UploaderScript.config.file_name = filename;
			callback();
		}
	});
};
function enableTabTextarea(textarea, e) {
	var keyCode = e.keyCode || e.which;

	if (keyCode == 9) {
		e.preventDefault();
		var start = textarea.get(0).selectionStart;
		var end = textarea.get(0).selectionEnd;
		// set textarea value to: text before caret + tab + text after caret
		textarea.val(textarea.val().substring(0, start)
			+ "\t"
			+ textarea.val().substring(end));

		// put caret at right position again
		textarea.get(0).selectionStart =
			textarea.get(0).selectionEnd = start + 1;
	}
}

var alert_timeout = 0;
$.alert = function (message) {
	clearTimeout(alert_timeout);
	$('body').find('.Alert').remove();
	var content = '<div class="Alert" style="display: block;">' +
		'<i class="material-icons">speaker_notes</i>' +
		'<a href="#" class="Alert__body" target="_blank">' +
		message +
		'</a>' +
		'</div>';
	$('body').append(content);
	alert_timeout = setTimeout(function () {
		$('body').find('.Alert').remove();
	},3000);
};
//form submit
$('.ajax-submit').submit(function () {
	// submit the form
	$(this).ajaxSubmit({
		dataType: 'json',
		success: function (resp) {
			if (resp.success && resp.msg) {
				$.alert(resp.msg);
			}
		},
		error: function (error) {

			console.log(error);
		}
	});
	// return false to prevent normal browser submit and page navigation
	return false;
});

//toggle class when lesson change status
$('form.lesson-watched-toggle').find('button.Button--Naked').click(function () {
	$(this).parent().toggleClass('Lesson-Status--completed');
});
$('.button-playlist-action').click(function () {
	$(this).toggleClass('Button--active');
});
$('#lesson-complete-toggle-button').click(function () {
	if ($(this).closest('form').hasClass('Lesson-Status--completed')) {
		$(this).find('span').html('Incomplete');
		$(this).closest('form').removeClass('Lesson-Status--completed');
	} else {
		$(this).find('span').html('Completed');
		$(this).closest('form').addClass('Lesson-Status--completed');
	}
});
$('.reply-markdown-body textarea').on('keydown',function(e){
	enableTabTextarea($(this),e);
});
