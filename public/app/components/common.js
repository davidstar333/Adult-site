angular.module('matroshkiApp').factory('commonHelper', function($location) {
	return {
		stringRepeat: function(num, replace) {
			return new Array(num + 1).join(replace);
		},
		externalLinks:function(text){
		return String(text).replace(/href=/gm, "class=\"ex-link\" href=");
		
		},
		localStorageIsEnabled: function() {
			var uid = new Date(),
							result;

			try {
				localStorage.setItem("uid", uid);
				result = localStorage.getItem("uid") === uid;
				localStorage.removeItem("uid");
				return result && localStorage;
			} catch (e) {
			}
		},
		readJsonFromController: function(file) {
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
		getBadWords: function(input) {
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
		replaceBadWords: function(input) {
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
					var swear =  new RegExp('\\b' + swearwords[i] + '\\b', 'gi');
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
		obToquery: function(obj, prefix) {
			var str = [];
			for (var p in obj) {
				var k = prefix ? prefix + "[" + p + "]" : p,
								v = obj[k];
				str.push(angular.isObject(v) ? this.obToquery(v, k) : (k) + "=" + encodeURIComponent(v));
			}
			return str.join("&");
		},
		isExpired: function(object) {
			if (!object.expiresOn) {
				return false;
			}
			if (new Date(object.expiresOn).getTime() < new Date().getTime() && object.expiresOn) {
				return true;
			}
			return false;
		},
		scrollTo: function(element, to, duration) {
			if (duration < 0)
				return;
			var difference = to - element.scrollTop;
			var perTick = difference / duration * 10;

			setTimeout(function() {
				element.scrollTop = element.scrollTop + perTick;
				if (element.scrollTop == to)
					return;
				scrollTo(element, to, duration - 10);
			}, 10);
		},
		removeLastSpace: function(str) {
			return str.replace(/\s+$/, '');
		},
		numberToAlpha: function(data) {
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
		secondsToDateTime: function(second, type) {
			var string = '';

			var date = this.coverMilisecondToTime(second * 1000, 'minute');
			string = date.seconds + ' second' + date.secondsS;
			if (date.minutes > 0) {
				string = date.minutes + ' min' + date.minutesS + ' ' + string;
			}
			return string;
			return;
		},
		coverMilisecondToTime: function(millis, type, options) {
			var seconds = 0;
			var minutes = 0;
			var hours = 0;
			var days = 0;
			var months = 0;
			var years = 0;
			if (type === 'day') {
				seconds = Math.round((millis / 1000) % 60);
				minutes = Math.floor(((millis / (60000)) % 60));
				hours = Math.floor(((millis / (3600000)) % 24));
				days = Math.floor(((millis / (3600000)) / 24));
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
					seconds = Math.round((millis / 1000) % 60);
				}
				minutes = Math.floor(millis / 60000);
				hours = 0;
				days = 0;
				months = 0;
				years = 0;
			} else if (type === 'hour') {
				seconds = Math.round((millis / 1000) % 60);
				minutes = Math.floor(((millis / (60000)) % 60));
				hours = Math.floor(millis / 3600000);
				days = 0;
				months = 0;
				years = 0;
			} else if (type === 'month') {
				seconds = Math.round((millis / 1000) % 60);
				minutes = Math.floor(((millis / (60000)) % 60));
				hours = Math.floor(((millis / (3600000)) % 24));
				days = Math.floor(((millis / (3600000)) / 24) % 30);
				months = Math.floor(((millis / (3600000)) / 24) / 30);
				years = 0;
			} else if (type === 'year') {
				seconds = Math.round((millis / 1000) % 60);
				minutes = Math.floor(((millis / (60000)) % 60));
				hours = Math.floor(((millis / (3600000)) % 24));
				days = Math.floor(((millis / (3600000)) / 24) % 30);
				months = Math.floor(((millis / (3600000)) / 24 / 30) % 12);
				years = Math.floor((millis / (3600000)) / 24 / 365);
			}
			var secondsS = (seconds < 2) ? '' : 's';
			var minutesS = (minutes < 2) ? '' : 's';
			var hoursS = (hours < 2) ? '' : 's';
			var daysS = (days < 2) ? '' : 's';
			var monthsS = (months < 2) ? '' : 's';
			var yearsS = (years < 2) ? '' : 's';
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
}
)
	.factory("extractAndParse", function($q) {
		function unzip(zipfile) {

		}

		function extractAndParse(zipfile) {
			var dfd = $q.defer();
			var reader = new FileReader();

			reader.onerror = dfd.reject.bind(dfd);
			reader.onload = function(e) {
				if (!reader.result)
					dfd.reject(new Error("Unknown error"));
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
				dfd.resolve({status: 'ok'});
			};
			reader.readAsArrayBuffer(zipfile);
			return dfd.promise;
		}

		return extractAndParse;
	})
	.factory('dateParserHelpers', [function() {

			'use strict';

			var cache = {};

			return {
				// Returns string value within a range if it's an integer
				getInteger: function(string, startPoint, minLength, maxLength) {
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
		}])
	.factory('$dateParser', ['$locale', 'dateParserHelpers', function($locale, dateParserHelpers) {

			'use strict';

			// Fetch date and time formats from $locale service
			var datetimeFormats = $locale.DATETIME_FORMATS;

			// Build array of month and day names
			var monthNames = datetimeFormats.MONTH.concat(datetimeFormats.SHORTMONTH);
			var dayNames = datetimeFormats.DAY.concat(datetimeFormats.SHORTDAY);

			return function(val, format) {

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

							while ((format.charAt(++i_format) != "'") && (i_format < format.length)) {
								token += format.charAt(i_format);
							}

							if (val.substring(i_val, i_val + token.length) != token) {
								throw 'Pattern value mismatch';
							}

							i_val += token.length;
							i_format++;

							continue;
						}

						while ((format.charAt(i_format) == format_token) && (i_format < format.length)) {
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

							if ((month < 1) || (month > 12)) {
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

							if (month === null || (month < 1) || (month > 12)) {
								throw 'Invalid month';
							}

							i_val += month.length;
						} else if (token == 'dd' || token == 'd') {
							date = dateParserHelpers.getInteger(val, i_val, token.length, 2);

							if (date === null || (date < 1) || (date > 31)) {
								throw 'Invalid date';
							}

							i_val += date.length;
						} else if (token == 'HH' || token == 'H') {
							hh = dateParserHelpers.getInteger(val, i_val, token.length, 2);

							if (hh === null || (hh < 0) || (hh > 23)) {
								throw 'Invalid hours';
							}

							i_val += hh.length;
						} else if (token == 'hh' || token == 'h') {
							hh = dateParserHelpers.getInteger(val, i_val, token.length, 2);

							if (hh === null || (hh < 1) || (hh > 12)) {
								throw 'Invalid hours';
							}

							i_val += hh.length;
						} else if (token == 'mm' || token == 'm') {
							mm = dateParserHelpers.getInteger(val, i_val, token.length, 2);

							if (mm === null || (mm < 0) || (mm > 59)) {
								throw 'Invalid minutes';
							}

							i_val += mm.length;
						} else if (token == 'ss' || token == 's') {
							ss = dateParserHelpers.getInteger(val, i_val, token.length, 2);

							if (ss === null || (ss < 0) || (ss > 59)) {
								throw 'Invalid seconds';
							}

							i_val += ss.length;
						} else if (token === 'sss') {
							sss = dateParserHelpers.getInteger(val, i_val, 3, 3);

							if (sss === null || (sss < 0) || (sss > 999)) {
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

									z = (parseInt(tzStr.substr(0, 3), 10) * 60) + parseInt(tzStr.substr(4, 2), 10);

									i_val += 6;
								} else {
									var tzStr = val.substring(i_val, i_val + 5);

									z = (parseInt(tzStr.substr(0, 3), 10) * 60) + parseInt(tzStr.substr(3, 2), 10);

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
						if (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0)) { // leap year
							if (date > 29) {
								throw 'Invalid date';
							}
						} else {
							if (date > 28) {
								throw 'Invalid date';
							}
						}
					}

					if ((month == 4) || (month == 6) || (month == 9) || (month == 11)) {
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