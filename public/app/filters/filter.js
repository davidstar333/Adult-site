angular.module('matroshkiApp')

        .filter('removeSpaces', function () {
            return function (string) {
                return angular.isDefined(string) ? string.replace(/\s/g, '') : '';
            };
        })
        .filter('fromNow', function () {
            return function (string) {
                return angular.isDefined(string) ? moment(string).fromNow() : '';
            };
        })
        .filter('elipsis', function () {
            return function (string, count) {
                if (angular.isDefined(string)) {
                    return string.length > count ? string.substring(0, count) + '...' : string;
                } else {
                    return '';
                }
            };
        })
        .filter('ucFirst', function () {
            return function (string) {
                return angular.isDefined(string) ? string.charAt(0).toUpperCase() + string.slice(1) : '';
            };
        })
        .filter('unit', function () {
            return function (string) {
                return (angular.isDefined(string) && angular.isNumber(string)) ? string + ' cm' : '';
            };
        })
        .filter('minutePlural', function () {
            return function (number) {
                number = isNaN(number) ? 0 : number;
                return (angular.isDefined(number) && angular.isNumber(number) && number > 1) ? number + ' minutes' : number + ' minute';
            };
        })
        .filter('unique', function () {
            return function (arr, field) {
                return _.uniq(arr, function (a) {
                    return a[field];
                });
            };
        })
        .filter('convertIcon', function () {
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
                var EmojiArea = function () {};
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
        })
        .filter('capitalize', function () {
            return function (input, all) {
                var reg = !(all) ? /([^\W_]+[^\s-]*) */g : /([^\W_]+[^\s-]*)/;
                return (!!input) ? input.replace(reg, function (txt) {
                    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                }) : '';
            }
        })
        .filter('linkify', function () {
            return function (text) {
                var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
                return text.replace(exp, '<a href="$1" target="_blank">$1</a>');
            };
        })
        .filter('htmlToPlaintext', function () {
            return function (text) {
                var a = $('<div/>');
                a.html(text);
                return  a.text();
            };
        })
        .filter('htmlToPlaintextImg', function () {
            return function (text) {
                var a = $('<div/>');
                a.html(text);
                a.find('img').each(function () {
                    $(this).after('{Image here}').remove();
                });
                return  a.text();
            };
        })
        .filter('angularHtmlToPlaintext', function () {
            return function (text) {
                return angular.element(text).text();
            };
        })
        .filter('phoneNumber', function () {
            return function (str) {
                if (typeof str !== 'string') {
                    return '';
                }
                return str;
            };
        })
        .filter('decimal', function () {
            return function (input, places) {
                return !isNaN(input) ? parseFloat(input).toFixed(places) : input;
            };
        }
        )
        .filter('round', function () {
            return function (input) {
                return !isNaN(input) ? Math.round(input) : 0;
            };
        })
        .filter('age', function () {
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
        })
        .filter('avatar', function (appSettings) {
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
                if(appSettings.placeholderAvatars && appSettings.placeholderAvatars.length) {
                    return appSettings.placeholderAvatars[Math.floor(Math.random()*appSettings.placeholderAvatars.length)];
                }
                return appSettings.BASE_URL + 'images/64x64.png';

            };
        })
        .filter('mainImage', function (appSettings) {
            return function (data) {

                if (data == null || data.mainImage == null) {
                    return appSettings.BASE_URL + 'images/default-gallery.png';
                }
                return appSettings.BASE_URL + data.mainImage;
            };
        })
        .filter('imageMedium', function (appSettings) {
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
        })
        .filter('thumbnail230', function (appSettings) {
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
        })
        .filter('chatUsername', function () {
            return function (user, username) {
                if (typeof user == 'undefined') {
                    return 'guest';
                }
//            console.log('user',user.username);
                if (user && user.username == null) {
                    return 'guest';
                }
                if (user) {
                    return (username && user.username == username) ? 'me' : user.username;//? user.username : 'guest';
                }
            };
        })
        .filter('statusColor', function () {
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
        })
        .filter('stringifyNumber', function () {
            return function (n) {
                var special = ['zeroth', 'first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth', 'ninth', 'tenth', 'eleventh', 'twelvth', 'thirteenth', 'fourteenth', 'fifteenth', 'sixteenth', 'seventeenth', 'eighteenth', 'nineteenth'];
                var deca = ['twent', 'thirt', 'fourt', 'fift', 'sixt', 'sevent', 'eight', 'ninet'];


                if (n < 20)
                    return special[n];
                if (n % 10 === 0)
                    return deca[Math.floor(n / 10) - 2] + 'ieth';
                return deca[Math.floor(n / 10) - 2] + 'y-' + special[n % 10];

            };
        })
        .filter('secondToMinutes', function () {
            return function (second) {
                if (angular.isNumber(second)) {
                    return second / 60;
                }
                return 0;
            };
        })
        .filter('unique', function () {
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
        })
        .filter('externalLinks', function () {
            return function (text) {
                return String(text).replace(/href=/gm, "class=\"ex-link\" href=");
            }
        })
        .filter('relativeTime', function () {
            return function (time) {
                return moment(time, 'YYYY-MM-DD H:s:i').fromNow();
            };
        })
        .filter('shortDate', function () {
            return function (data) {
                var date = new Date(data.createdAt);

                return date.getDay() + '-' + '-' + date.getMonth() + '-' + date.getFullYear();
            };
        })
        .filter('mediumDate', function () {
            return function (date) {
//            var date = new Date(date);
                return moment(date).format('MM-DD-YYYY');
            };
        })

        .filter('spaceText', function () {
            return function (data) {
                if (data) {
                    return data.replace('_', ' ');
                }
            };
        })
        .filter('spaceCapitalLetters', function () {
            return function (text) {
                if (angular.isString(text)) {
                    return text.replace(/([A-Z])/g, ' $1').trim();
                }
            };
        })
        .filter('itemType', function (appSettings) {
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
            utf8Overhead = function (chr) {
                // http://phpjs.org/functions/unserialize:571#comment_95906
                var code = chr.charCodeAt(0);
                if (code < 0x0080
                        || 0x00A0 <= code && code <= 0x00FF
                        || [338, 339, 352, 353, 376, 402, 8211, 8212, 8216, 8217, 8218, 8220, 8221, 8222, 8224, 8225, 8226, 8230, 8240, 8364, 8482].indexOf(code) != -1)
                {
                    return 0;
                }
                if (code < 0x0800) {
                    return 1;
                }
                return 2;
            };
    error = function (type, msg, filename, line) {
        throw new that.window[type](msg, filename, line);
    };
    read_until = function (data, offset, stopchr) {
        var i = 2,
                buf = [],
                chr = data.slice(offset, offset + 1);

        while (chr != stopchr) {
            if ((i + offset) > data.length) {
                error('Error', 'Invalid');
            }
            buf.push(chr);
            chr = data.slice(offset + (i - 1), offset + i);
            i += 1;
        }
        return [buf.length, buf.join('')];
    };
    read_chrs = function (data, offset, length) {
        var i, chr, buf;

        buf = [];
        for (i = 0; i < length; i++) {
            chr = data.slice(offset + (i - 1), offset + i);
            buf.push(chr);
            length -= utf8Overhead(chr);
        }
        return [buf.length, buf.join('')];
    };
    _unserialize = function (data, offset) {
        var dtype, dataoffset, keyandchrs, keys, contig,
                length, array, readdata, readData, ccount,
                stringlength, i, key, kprops, kchrs, vprops,
                vchrs, value, chrs = 0,
                typeconvert = function (x) {
                    return x;
                };

        if (!offset) {
            offset = 0;
        }
        dtype = (data.slice(offset, offset + 1))
                .toLowerCase();

        dataoffset = offset + 2;

        switch (dtype) {
            case 'i':
                typeconvert = function (x) {
                    return parseInt(x, 10);
                };
                readData = read_until(data, dataoffset, ';');
                chrs = readData[0];
                readdata = readData[1];
                dataoffset += chrs + 1;
                break;
            case 'b':
                typeconvert = function (x) {
                    return parseInt(x, 10) !== 0;
                };
                readData = read_until(data, dataoffset, ';');
                chrs = readData[0];
                readdata = readData[1];
                dataoffset += chrs + 1;
                break;
            case 'd':
                typeconvert = function (x) {
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

                    if (key !== i)
                        contig = false;

                    readdata[key] = value;
                }

                if (contig) {
                    array = new Array(length);
                    for (i = 0; i < length; i++)
                        array[i] = readdata[i];
                    readdata = array;
                }

                dataoffset += 1;
                break;
            default:
                error('SyntaxError', 'Unknown / Unhandled data type(s): ' + dtype);
                break;
        }
        return [dtype, dataoffset - offset, typeconvert(readdata)];
    };

    return _unserialize((data + ''), 0)[2];
}