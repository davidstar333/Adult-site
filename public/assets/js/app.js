'use strict';

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

window.RTCPeerConnection = window.RTCPeerConnection || window.webkitRTCPeerConnection || window.mozRTCPeerConnection;
window.RTCIceCandidate = window.RTCIceCandidate || window.mozRTCIceCandidate || window.webkitRTCIceCandidate;
window.RTCSessionDescription = window.RTCSessionDescription || window.mozRTCSessionDescription || window.webkitRTCSessionDescription;
window.URL = window.URL || window.mozURL || window.webkitURL;
window.navigator.getUserMedia = window.navigator.getUserMedia || window.navigator.webkitGetUserMedia || window.navigator.mozGetUserMedia;

'use strict';
if ((typeof PerformerChat === 'undefined' ? 'undefined' : _typeof(PerformerChat)) === undefined) {
				var PerformerChat = {};
}

angular.module('matroshkiApp', ['ngCookies', 'ngSanitize', 'ui.bootstrap', 'btford.socket-io',
//  'ngTagsInput',
//  'ngCkeditor'
//  'ui.tinymce',
'angularLazyImg'], function ($interpolateProvider) {
				$interpolateProvider.startSymbol('<%');
				$interpolateProvider.endSymbol('%>');
}).constant('appSettings', window.appSettings).constant('PerformerChat', PerformerChat).value('_', _).value('$', $);

angular.module('matroshkiApp').factory('commonHelper', function ($location) {
				return {
								stringRepeat: function stringRepeat(num, replace) {
												return new Array(num + 1).join(replace);
								},
								externalLinks: function externalLinks(text) {
												return String(text).replace(/href=/gm, "class=\"ex-link\" href=");
								},
								localStorageIsEnabled: function localStorageIsEnabled() {
												var uid = new Date(),
												    result;

												try {
																localStorage.setItem("uid", uid);
																result = localStorage.getItem("uid") === uid;
																localStorage.removeItem("uid");
																return result && localStorage;
												} catch (e) {}
								},
								readJsonFromController: function readJsonFromController(file) {
												var request = new XMLHttpRequest();
												request.open('GET', file, false);
												request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
												request.send(null);
												try {
																return JSON.parse(request.responseText);
												} catch (e) {
																return '';
												}
								},
								getBadWords: function getBadWords(input) {
												if (input) {
																var badwords = [];
																for (var i = 0; i < swearwords.length; i++) {
																				var swear = new RegExp(swearwords[i], 'g');
																				if (input.match(swear)) {
																								badwords.push(swearwords[i]);
																				}
																}
																return badwords;
												}
								},
								replaceBadWords: function replaceBadWords(input) {
												if (this.localStorageIsEnabled()) {
																if (localStorage.getItem('localSwears') === null) {
																				// stringify the array so that it can be stored in local storage
																				localStorage.setItem('localSwears', JSON.stringify(readJsonFromController(swearWordPath)));
																}
																swearwords = JSON.parse(localStorage.getItem('localSwears'));
												} else {
																swearwords = this.readJsonFromController(swearWordPath);
												}
												if (swearwords === null) {
																return input;
												}
												if (input) {
																for (var i = 0; i < swearwords.length; i++) {
																				var swear = new RegExp('\\b' + swearwords[i] + '\\b', 'gi');
																				if (input.match(swear)) {
																								var replacement = this.stringRepeat(swearwords[i].length, "*");
																								input = input.replace(swear, replacement);
																				}
																}
																return input;
												} else {
																return input;
												}
								},
								obToquery: function obToquery(obj, prefix) {
												var str = [];
												for (var p in obj) {
																var k = prefix ? prefix + "[" + p + "]" : p,
																    v = obj[k];
																str.push(angular.isObject(v) ? this.obToquery(v, k) : k + "=" + encodeURIComponent(v));
												}
												return str.join("&");
								},
								isExpired: function isExpired(object) {
												if (!object.expiresOn) {
																return false;
												}
												if (new Date(object.expiresOn).getTime() < new Date().getTime() && object.expiresOn) {
																return true;
												}
												return false;
								},
								scrollTo: function (_scrollTo) {
												function scrollTo(_x, _x2, _x3) {
																return _scrollTo.apply(this, arguments);
												}

												scrollTo.toString = function () {
																return _scrollTo.toString();
												};

												return scrollTo;
								}(function (element, to, duration) {
												if (duration < 0) return;
												var difference = to - element.scrollTop;
												var perTick = difference / duration * 10;

												setTimeout(function () {
																element.scrollTop = element.scrollTop + perTick;
																if (element.scrollTop == to) return;
																scrollTo(element, to, duration - 10);
												}, 10);
								}),
								removeLastSpace: function removeLastSpace(str) {
												return str.replace(/\s+$/, '');
								},
								numberToAlpha: function numberToAlpha(data) {
												var string = '';
												switch (data) {
																case '0':
																				string = 'A';
																				break;
																case '1':
																				string = 'B';
																				break;
																case '2':
																				string = 'C';
																				break;
																case '3':
																				string = 'D';
																				break;
																case '4':
																				string = 'F';
																				break;
												}
												return string;
								},
								secondsToDateTime: function secondsToDateTime(second, type) {
												var string = '';

												var date = this.coverMilisecondToTime(second * 1000, 'minute');
												string = date.seconds + ' second' + date.secondsS;
												if (date.minutes > 0) {
																string = date.minutes + ' min' + date.minutesS + ' ' + string;
												}
												return string;
												return;
								},
								coverMilisecondToTime: function coverMilisecondToTime(millis, type, options) {
												var seconds = 0;
												var minutes = 0;
												var hours = 0;
												var days = 0;
												var months = 0;
												var years = 0;
												if (type === 'day') {
																seconds = Math.round(millis / 1000 % 60);
																minutes = Math.floor(millis / 60000 % 60);
																hours = Math.floor(millis / 3600000 % 24);
																days = Math.floor(millis / 3600000 / 24);
																months = 0;
																years = 0;
												} else if (type === 'second') {
																seconds = Math.floor(millis / 1000);
																minutes = 0;
																hours = 0;
																days = 0;
																months = 0;
																years = 0;
												} else if (type === 'minute') {
																if (options && options.fixed) {
																				seconds = (millis / 1000).toFixed(options.fixed);
																} else {
																				seconds = Math.round(millis / 1000 % 60);
																}
																minutes = Math.floor(millis / 60000);
																hours = 0;
																days = 0;
																months = 0;
																years = 0;
												} else if (type === 'hour') {
																seconds = Math.round(millis / 1000 % 60);
																minutes = Math.floor(millis / 60000 % 60);
																hours = Math.floor(millis / 3600000);
																days = 0;
																months = 0;
																years = 0;
												} else if (type === 'month') {
																seconds = Math.round(millis / 1000 % 60);
																minutes = Math.floor(millis / 60000 % 60);
																hours = Math.floor(millis / 3600000 % 24);
																days = Math.floor(millis / 3600000 / 24 % 30);
																months = Math.floor(millis / 3600000 / 24 / 30);
																years = 0;
												} else if (type === 'year') {
																seconds = Math.round(millis / 1000 % 60);
																minutes = Math.floor(millis / 60000 % 60);
																hours = Math.floor(millis / 3600000 % 24);
																days = Math.floor(millis / 3600000 / 24 % 30);
																months = Math.floor(millis / 3600000 / 24 / 30 % 12);
																years = Math.floor(millis / 3600000 / 24 / 365);
												}
												var secondsS = seconds < 2 ? '' : 's';
												var minutesS = minutes < 2 ? '' : 's';
												var hoursS = hours < 2 ? '' : 's';
												var daysS = days < 2 ? '' : 's';
												var monthsS = months < 2 ? '' : 's';
												var yearsS = years < 2 ? '' : 's';
												return {
																seconds: seconds,
																secondsS: secondsS,
																minutes: minutes,
																minutesS: minutesS,
																hours: hours,
																hoursS: hoursS,
																days: days,
																daysS: daysS,
																months: months,
																monthsS: monthsS,
																years: years,
																yearsS: yearsS
												};
								}
				};
}).factory("extractAndParse", function ($q) {
				function unzip(zipfile) {}

				function extractAndParse(zipfile) {
								var dfd = $q.defer();
								var reader = new FileReader();

								reader.onerror = dfd.reject.bind(dfd);
								reader.onload = function (e) {
												if (!reader.result) dfd.reject(new Error("Unknown error"));
												var zip = new JSZip(reader.result);
												var nFile = 0;
												for (var i in zip.files) {
																var filename = zip.files[i].name;
																if (zip.files[i].name) {
																				var ext = filename.split('.').pop();
																				if (ext == 'xls' || ext == 'xlsx') {
																								nFile++;
																				}
																}
												}
												if (nFile != 1) {
																dfd.reject(new Error('Your zip file should contain only one spreadsheet.'));
												}
												dfd.resolve({ status: 'ok' });
								};
								reader.readAsArrayBuffer(zipfile);
								return dfd.promise;
				}

				return extractAndParse;
}).factory('dateParserHelpers', [function () {

				'use strict';

				var cache = {};

				return {
								// Returns string value within a range if it's an integer
								getInteger: function getInteger(string, startPoint, minLength, maxLength) {
												var val = string.substring(startPoint);
												var matcher = cache[minLength + '_' + maxLength];
												if (!matcher) {
																matcher = new RegExp('^(\\d{' + minLength + ',' + maxLength + '})');
																cache[minLength + '_' + maxLength] = matcher;
												}

												var match = matcher.exec(val);
												if (match) {
																return match[1];
												}
												return null;
								}
				};
}]).factory('$dateParser', ['$locale', 'dateParserHelpers', function ($locale, dateParserHelpers) {

				'use strict';

				// Fetch date and time formats from $locale service

				var datetimeFormats = $locale.DATETIME_FORMATS;

				// Build array of month and day names
				var monthNames = datetimeFormats.MONTH.concat(datetimeFormats.SHORTMONTH);
				var dayNames = datetimeFormats.DAY.concat(datetimeFormats.SHORTDAY);

				return function (val, format) {

								// If input is a Date object, there's no need to process it
								if (angular.isDate(val)) {
												return val;
								}

								try {
												val = val + '';
												format = format + '';

												// If no format is provided, just pass it to the Date constructor
												if (!format.length) {
																return new Date(val);
												}

												// Check if format exists in the format collection
												if (datetimeFormats[format]) {
																format = datetimeFormats[format];
												}

												// Initial values
												var now = new Date(),
												    i_val = 0,
												    i_format = 0,
												    format_token = '',
												    year = now.getFullYear(),
												    month = now.getMonth() + 1,
												    date = now.getDate(),
												    hh = 0,
												    mm = 0,
												    ss = 0,
												    sss = 0,
												    ampm = 'am',
												    z = 0,
												    parsedZ = false;

												// TODO: Extract this into a helper function perhaps?
												while (i_format < format.length) {
																// Get next token from format string
																format_token = format.charAt(i_format);

																var token = '';

																// TODO: Handle double single quotes
																// Handle quote marks for strings within format string
																if (format.charAt(i_format) == "'") {
																				var _i_format = i_format;

																				while (format.charAt(++i_format) != "'" && i_format < format.length) {
																								token += format.charAt(i_format);
																				}

																				if (val.substring(i_val, i_val + token.length) != token) {
																								throw 'Pattern value mismatch';
																				}

																				i_val += token.length;
																				i_format++;

																				continue;
																}

																while (format.charAt(i_format) == format_token && i_format < format.length) {
																				token += format.charAt(i_format++);
																}

																// Extract contents of value based on format token
																if (token == 'yyyy' || token == 'yy' || token == 'y') {
																				var minLength, maxLength;

																				if (token == 'yyyy') {
																								minLength = 4;
																								maxLength = 4;
																				}

																				if (token == 'yy') {
																								minLength = 2;
																								maxLength = 2;
																				}

																				if (token == 'y') {
																								minLength = 2;
																								maxLength = 4;
																				}

																				year = dateParserHelpers.getInteger(val, i_val, minLength, maxLength);

																				if (year === null) {
																								throw 'Invalid year';
																				}

																				i_val += year.length;

																				if (year.length == 2) {
																								if (year > 70) {
																												year = 1900 + (year - 0);
																								} else {
																												year = 2000 + (year - 0);
																								}
																				}
																} else if (token === 'MMMM' || token == 'MMM') {
																				month = 0;

																				for (var i = 0; i < monthNames.length; i++) {
																								var month_name = monthNames[i];

																								if (val.substring(i_val, i_val + month_name.length).toLowerCase() == month_name.toLowerCase()) {
																												month = i + 1;
																												if (month > 12) {
																																month -= 12;
																												}

																												i_val += month_name.length;

																												break;
																								}
																				}

																				if (month < 1 || month > 12) {
																								throw 'Invalid month';
																				}
																} else if (token == 'EEEE' || token == 'EEE') {
																				for (var j = 0; j < dayNames.length; j++) {
																								var day_name = dayNames[j];

																								if (val.substring(i_val, i_val + day_name.length).toLowerCase() == day_name.toLowerCase()) {
																												i_val += day_name.length;
																												break;
																								}
																				}
																} else if (token == 'MM' || token == 'M') {
																				month = dateParserHelpers.getInteger(val, i_val, token.length, 2);

																				if (month === null || month < 1 || month > 12) {
																								throw 'Invalid month';
																				}

																				i_val += month.length;
																} else if (token == 'dd' || token == 'd') {
																				date = dateParserHelpers.getInteger(val, i_val, token.length, 2);

																				if (date === null || date < 1 || date > 31) {
																								throw 'Invalid date';
																				}

																				i_val += date.length;
																} else if (token == 'HH' || token == 'H') {
																				hh = dateParserHelpers.getInteger(val, i_val, token.length, 2);

																				if (hh === null || hh < 0 || hh > 23) {
																								throw 'Invalid hours';
																				}

																				i_val += hh.length;
																} else if (token == 'hh' || token == 'h') {
																				hh = dateParserHelpers.getInteger(val, i_val, token.length, 2);

																				if (hh === null || hh < 1 || hh > 12) {
																								throw 'Invalid hours';
																				}

																				i_val += hh.length;
																} else if (token == 'mm' || token == 'm') {
																				mm = dateParserHelpers.getInteger(val, i_val, token.length, 2);

																				if (mm === null || mm < 0 || mm > 59) {
																								throw 'Invalid minutes';
																				}

																				i_val += mm.length;
																} else if (token == 'ss' || token == 's') {
																				ss = dateParserHelpers.getInteger(val, i_val, token.length, 2);

																				if (ss === null || ss < 0 || ss > 59) {
																								throw 'Invalid seconds';
																				}

																				i_val += ss.length;
																} else if (token === 'sss') {
																				sss = dateParserHelpers.getInteger(val, i_val, 3, 3);

																				if (sss === null || sss < 0 || sss > 999) {
																								throw 'Invalid milliseconds';
																				}

																				i_val += 3;
																} else if (token == 'a') {
																				if (val.substring(i_val, i_val + 2).toLowerCase() == 'am') {
																								ampm = 'AM';
																				} else if (val.substring(i_val, i_val + 2).toLowerCase() == 'pm') {
																								ampm = 'PM';
																				} else {
																								throw 'Invalid AM/PM';
																				}

																				i_val += 2;
																} else if (token == 'Z') {
																				parsedZ = true;

																				if (val[i_val] === 'Z') {
																								z = 0;

																								i_val += 1;
																				} else {
																								if (val[i_val + 3] === ':') {
																												var tzStr = val.substring(i_val, i_val + 6);

																												z = parseInt(tzStr.substr(0, 3), 10) * 60 + parseInt(tzStr.substr(4, 2), 10);

																												i_val += 6;
																								} else {
																												var tzStr = val.substring(i_val, i_val + 5);

																												z = parseInt(tzStr.substr(0, 3), 10) * 60 + parseInt(tzStr.substr(3, 2), 10);

																												i_val += 5;
																								}
																				}

																				if (z > 720 || z < -720) {
																								throw 'Invalid timezone';
																				}
																} else {
																				if (val.substring(i_val, i_val + token.length) != token) {
																								throw 'Pattern value mismatch';
																				} else {
																								i_val += token.length;
																				}
																}
												}

												// If there are any trailing characters left in the value, it doesn't match
												if (i_val != val.length) {
																throw 'Pattern value mismatch';
												}

												// Convert to integer
												year = parseInt(year, 10);
												month = parseInt(month, 10);
												date = parseInt(date, 10);
												hh = parseInt(hh, 10);
												mm = parseInt(mm, 10);
												ss = parseInt(ss, 10);
												sss = parseInt(sss, 10);

												// Is date valid for month?
												if (month == 2) {
																// Check for leap year
																if (year % 4 === 0 && year % 100 !== 0 || year % 400 === 0) {
																				// leap year
																				if (date > 29) {
																								throw 'Invalid date';
																				}
																} else {
																				if (date > 28) {
																								throw 'Invalid date';
																				}
																}
												}

												if (month == 4 || month == 6 || month == 9 || month == 11) {
																if (date > 30) {
																				throw 'Invalid date';
																}
												}

												// Correct hours value
												if (hh < 12 && ampm == 'PM') {
																hh += 12;
												} else if (hh > 11 && ampm == 'AM') {
																hh -= 12;
												}

												var localDate = new Date(year, month - 1, date, hh, mm, ss, sss);

												if (parsedZ) {
																return new Date(localDate.getTime() - (z + localDate.getTimezoneOffset()) * 60000);
												}

												return localDate;
								} catch (e) {
												return undefined;
								}
				};
}]);
angular.module('matroshkiApp').filter('removeSpaces', function () {
				return function (string) {
								return angular.isDefined(string) ? string.replace(/\s/g, '') : '';
				};
}).filter('fromNow', function () {
				return function (string) {
								return angular.isDefined(string) ? moment(string).fromNow() : '';
				};
}).filter('elipsis', function () {
				return function (string, count) {
								if (angular.isDefined(string)) {
												return string.length > count ? string.substring(0, count) + '...' : string;
								} else {
												return '';
								}
				};
}).filter('ucFirst', function () {
				return function (string) {
								return angular.isDefined(string) ? string.charAt(0).toUpperCase() + string.slice(1) : '';
				};
}).filter('unit', function () {
				return function (string) {
								return angular.isDefined(string) && angular.isNumber(string) ? string + ' cm' : '';
				};
}).filter('minutePlural', function () {
				return function (number) {
								number = isNaN(number) ? 0 : number;
								return angular.isDefined(number) && angular.isNumber(number) && number > 1 ? number + ' minutes' : number + ' minute';
				};
}).filter('unique', function () {
				return function (arr, field) {
								return _.uniq(arr, function (a) {
												return a[field];
								});
				};
}).filter('convertIcon', function () {
				return function (string) {
								if (!string) {
												return '';
								}
								var emojis = $.emojiarea.icons;
								var util = {};
								util.escapeRegex = function (str) {
												return (str + '').replace(/([.?*+^$[\]\\(){}|-])/g, '\\$1');
								};
								util.htmlEntities = function (str) {
												return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
								};
								var EmojiArea = function EmojiArea() {};
								EmojiArea.createIcon = function (group, emoji) {
												var filename = $.emojiarea.icons[group]['icons'][emoji];
												var path = $.emojiarea.path || '';
												if (path.length && path.charAt(path.length - 1) !== '/') {
																path += '/';
												}
												return '<img src="' + path + filename + '" alt="' + util.htmlEntities(emoji) + '">';
								};

								for (var group in emojis) {
												for (var key in emojis[group]['icons']) {
																if (emojis[group]['icons'].hasOwnProperty(key)) {

																				string = string.replace(new RegExp(util.escapeRegex(key), 'g'), EmojiArea.createIcon(group, key));
																}
												}
								}
								return string;

								//return $.emoticons.replace(string);
				};
}).filter('capitalize', function () {
				return function (input, all) {
								var reg = !all ? /([^\W_]+[^\s-]*) */g : /([^\W_]+[^\s-]*)/;
								return !!input ? input.replace(reg, function (txt) {
												return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
								}) : '';
				};
}).filter('linkify', function () {
				return function (text) {
								var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
								return text.replace(exp, '<a href="$1" target="_blank">$1</a>');
				};
}).filter('htmlToPlaintext', function () {
				return function (text) {
								var a = $('<div/>');
								a.html(text);
								return a.text();
				};
}).filter('htmlToPlaintextImg', function () {
				return function (text) {
								var a = $('<div/>');
								a.html(text);
								a.find('img').each(function () {
												$(this).after('{Image here}').remove();
								});
								return a.text();
				};
}).filter('angularHtmlToPlaintext', function () {
				return function (text) {
								return angular.element(text).text();
				};
}).filter('phoneNumber', function () {
				return function (str) {
								if (typeof str !== 'string') {
												return '';
								}
								return str;
				};
}).filter('decimal', function () {
				return function (input, places) {
								return !isNaN(input) ? parseFloat(input).toFixed(places) : input;
				};
}).filter('round', function () {
				return function (input) {
								return !isNaN(input) ? Math.round(input) : 0;
				};
}).filter('age', function () {
				return function (input, defaultText) {

								defaultText = defaultText || 'Unknown';
								if (!input) {
												return 'Unknown';
								} else {
												var birthdate = new Date(input);
												var cur = new Date();
												var diff = cur - birthdate; // This is the difference in milliseconds
												return Math.floor(diff / 31536000000); // Divide by 1000*60*60*24*365
								}
				};
}).filter('avatar', function (appSettings) {
				return function (avatar) {
								if (avatar != null && avatar.indexOf('imageSmall') != -1) {

												var meta = unserialize(avatar);
												if (meta && meta.imageMedium) {
																return appSettings.BASE_URL + meta.imageMedium;
												}
								}
								if (avatar != null && avatar.indexOf('http') != -1) {
												return avatar;
								}
								if (appSettings.placeholderAvatars && appSettings.placeholderAvatars.length) {
												return appSettings.placeholderAvatars[Math.floor(Math.random() * appSettings.placeholderAvatars.length)];
								}
								return appSettings.BASE_URL + 'images/64x64.png';
				};
}).filter('mainImage', function (appSettings) {
				return function (data) {

								if (data == null || data.mainImage == null) {
												return appSettings.BASE_URL + 'images/default-gallery.png';
								}
								return appSettings.BASE_URL + data.mainImage;
				};
}).filter('imageMedium', function (appSettings) {
				return function (data) {

								if (data == '') {
												return appSettings.BASE_URL + 'images/no_image_thumb.png';
								}
								if (data != '') {
												var images = unserialize(data);
												if (images && data.indexOf('imageMedium') != -1) {
																return appSettings.BASE_URL + images.imageMedium;
												} else {
																return appSettings.BASE_URL + 'images/no_image_thumb.png';
												}
								}
				};
}).filter('thumbnail230', function (appSettings) {
				return function (data) {

								if (data == '') {
												return appSettings.BASE_URL + 'images/no_image_thumb.png';
								}
								if (data != '') {
												var images = unserialize(data);
												if (images && data.indexOf('thumbnail230') != -1) {
																return images.thumbnail230;
												} else {
																return appSettings.BASE_URL + 'images/no_image_thumb.png';
												}
								}
				};
}).filter('chatUsername', function () {
				return function (user, username) {
								if (typeof user == 'undefined') {
												return 'guest';
								}
								//            console.log('user',user.username);
								if (user && user.username == null) {
												return 'guest';
								}
								if (user) {
												return username && user.username == username ? 'me' : user.username; //? user.username : 'guest';
								}
				};
}).filter('statusColor', function () {
				return function (practice) {

								if (new Date(practice.expiresOn).getTime() < new Date().getTime() && practice.expiresOn) {
												return 'label-warning';
								}
								if (practice.status == 'draft') {
												return 'label-info';
								}
								if (practice.status == 'published') {
												return 'label-primary';
								}
								if (practice.status == 'revoked') {
												return 'label-danger';
								}
								return 'label-danger';
				};
}).filter('stringifyNumber', function () {
				return function (n) {
								var special = ['zeroth', 'first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth', 'ninth', 'tenth', 'eleventh', 'twelvth', 'thirteenth', 'fourteenth', 'fifteenth', 'sixteenth', 'seventeenth', 'eighteenth', 'nineteenth'];
								var deca = ['twent', 'thirt', 'fourt', 'fift', 'sixt', 'sevent', 'eight', 'ninet'];

								if (n < 20) return special[n];
								if (n % 10 === 0) return deca[Math.floor(n / 10) - 2] + 'ieth';
								return deca[Math.floor(n / 10) - 2] + 'y-' + special[n % 10];
				};
}).filter('secondToMinutes', function () {
				return function (second) {
								if (angular.isNumber(second)) {
												return second / 60;
								}
								return 0;
				};
}).filter('unique', function () {
				return function (collection, keyname) {
								var output = [],
								    keys = [];

								angular.forEach(collection, function (item) {
												var key = item[keyname];
												if (keys.indexOf(key) === -1) {
																keys.push(key);
																output.push(item);
												}
								});

								return output;
				};
}).filter('externalLinks', function () {
				return function (text) {
								return String(text).replace(/href=/gm, "class=\"ex-link\" href=");
				};
}).filter('relativeTime', function () {
				return function (time) {
								return moment(time, 'YYYY-MM-DD H:s:i').fromNow();
				};
}).filter('shortDate', function () {
				return function (data) {
								var date = new Date(data.createdAt);

								return date.getDay() + '-' + '-' + date.getMonth() + '-' + date.getFullYear();
				};
}).filter('mediumDate', function () {
				return function (date) {
								//            var date = new Date(date);
								return moment(date).format('MM-DD-YYYY');
				};
}).filter('spaceText', function () {
				return function (data) {
								if (data) {
												return data.replace('_', ' ');
								}
				};
}).filter('spaceCapitalLetters', function () {
				return function (text) {
								if (angular.isString(text)) {
												return text.replace(/([A-Z])/g, ' $1').trim();
								}
				};
}).filter('itemType', function (appSettings) {
				return function (data) {
								if (data == 'performer_product') {
												return 'product';
								}
								return data;
				};
});
function unserialize(data) {
				//  discuss at: http://phpjs.org/functions/unserialize/
				// original by: Arpad Ray (mailto:arpad@php.net)
				// improved by: Pedro Tainha (http://www.pedrotainha.com)
				// improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
				// improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
				// improved by: Chris
				// improved by: James
				// improved by: Le Torbi
				// improved by: Eli Skeggs
				// bugfixed by: dptr1988
				// bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
				// bugfixed by: Brett Zamir (http://brett-zamir.me)
				//  revised by: d3x
				//    input by: Brett Zamir (http://brett-zamir.me)
				//    input by: Martin (http://www.erlenwiese.de/)
				//    input by: kilops
				//    input by: Jaroslaw Czarniak
				//        note: We feel the main purpose of this function should be to ease the transport of data between php & js
				//        note: Aiming for PHP-compatibility, we have to translate objects to arrays
				//   example 1: unserialize('a:3:{i:0;s:5:"Kevin";i:1;s:3:"van";i:2;s:9:"Zonneveld";}');
				//   returns 1: ['Kevin', 'van', 'Zonneveld']
				//   example 2: unserialize('a:3:{s:9:"firstName";s:5:"Kevin";s:7:"midName";s:3:"van";s:7:"surName";s:9:"Zonneveld";}');
				//   returns 2: {firstName: 'Kevin', midName: 'van', surName: 'Zonneveld'}

				var that = this,
				    utf8Overhead = function utf8Overhead(chr) {
								// http://phpjs.org/functions/unserialize:571#comment_95906
								var code = chr.charCodeAt(0);
								if (code < 0x0080 || 0x00A0 <= code && code <= 0x00FF || [338, 339, 352, 353, 376, 402, 8211, 8212, 8216, 8217, 8218, 8220, 8221, 8222, 8224, 8225, 8226, 8230, 8240, 8364, 8482].indexOf(code) != -1) {
												return 0;
								}
								if (code < 0x0800) {
												return 1;
								}
								return 2;
				};
				error = function error(type, msg, filename, line) {
								throw new that.window[type](msg, filename, line);
				};
				read_until = function read_until(data, offset, stopchr) {
								var i = 2,
								    buf = [],
								    chr = data.slice(offset, offset + 1);

								while (chr != stopchr) {
												if (i + offset > data.length) {
																error('Error', 'Invalid');
												}
												buf.push(chr);
												chr = data.slice(offset + (i - 1), offset + i);
												i += 1;
								}
								return [buf.length, buf.join('')];
				};
				read_chrs = function read_chrs(data, offset, length) {
								var i, chr, buf;

								buf = [];
								for (i = 0; i < length; i++) {
												chr = data.slice(offset + (i - 1), offset + i);
												buf.push(chr);
												length -= utf8Overhead(chr);
								}
								return [buf.length, buf.join('')];
				};
				_unserialize = function (_unserialize2) {
								function _unserialize(_x4, _x5) {
												return _unserialize2.apply(this, arguments);
								}

								_unserialize.toString = function () {
												return _unserialize2.toString();
								};

								return _unserialize;
				}(function (data, offset) {
								var dtype,
								    dataoffset,
								    keyandchrs,
								    keys,
								    contig,
								    length,
								    array,
								    readdata,
								    readData,
								    ccount,
								    stringlength,
								    i,
								    key,
								    kprops,
								    kchrs,
								    vprops,
								    vchrs,
								    value,
								    chrs = 0,
								    typeconvert = function typeconvert(x) {
												return x;
								};

								if (!offset) {
												offset = 0;
								}
								dtype = data.slice(offset, offset + 1).toLowerCase();

								dataoffset = offset + 2;

								switch (dtype) {
												case 'i':
																typeconvert = function typeconvert(x) {
																				return parseInt(x, 10);
																};
																readData = read_until(data, dataoffset, ';');
																chrs = readData[0];
																readdata = readData[1];
																dataoffset += chrs + 1;
																break;
												case 'b':
																typeconvert = function typeconvert(x) {
																				return parseInt(x, 10) !== 0;
																};
																readData = read_until(data, dataoffset, ';');
																chrs = readData[0];
																readdata = readData[1];
																dataoffset += chrs + 1;
																break;
												case 'd':
																typeconvert = function typeconvert(x) {
																				return parseFloat(x);
																};
																readData = read_until(data, dataoffset, ';');
																chrs = readData[0];
																readdata = readData[1];
																dataoffset += chrs + 1;
																break;
												case 'n':
																readdata = null;
																break;
												case 's':
																ccount = read_until(data, dataoffset, ':');
																chrs = ccount[0];
																stringlength = ccount[1];
																dataoffset += chrs + 2;

																readData = read_chrs(data, dataoffset + 1, parseInt(stringlength, 10));
																chrs = readData[0];
																readdata = readData[1];
																dataoffset += chrs + 2;
																if (chrs != parseInt(stringlength, 10) && chrs != readdata.length) {
																				error('SyntaxError', 'String length mismatch');
																}
																break;
												case 'a':
																readdata = {};

																keyandchrs = read_until(data, dataoffset, ':');
																chrs = keyandchrs[0];
																keys = keyandchrs[1];
																dataoffset += chrs + 2;

																length = parseInt(keys, 10);
																contig = true;

																for (i = 0; i < length; i++) {
																				kprops = _unserialize(data, dataoffset);
																				kchrs = kprops[1];
																				key = kprops[2];
																				dataoffset += kchrs;

																				vprops = _unserialize(data, dataoffset);
																				vchrs = vprops[1];
																				value = vprops[2];
																				dataoffset += vchrs;

																				if (key !== i) contig = false;

																				readdata[key] = value;
																}

																if (contig) {
																				array = new Array(length);
																				for (i = 0; i < length; i++) {
																								array[i] = readdata[i];
																				}readdata = array;
																}

																dataoffset += 1;
																break;
												default:
																error('SyntaxError', 'Unknown / Unhandled data type(s): ' + dtype);
																break;
								}
								return [dtype, dataoffset - offset, typeconvert(readdata)];
				});

				return _unserialize(data + '', 0)[2];
}
//# sourceMappingURL=app.js.map
