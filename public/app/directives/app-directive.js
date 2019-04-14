/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



'use strict';

angular.module('matroshkiApp')
        .directive('pwCheck', [function () {
                return {
                    require: 'ngModel',
                    link: function (scope, elem, attrs, ctrl) {
                        var firstPassword = '#' + attrs.pwCheck;
                        elem.add(firstPassword).on('keyup', function () {
                            scope.$apply(function () {
                                // console.info(elem.val() === $(firstPassword).val());
                                ctrl.$setValidity('pwmatch', elem.val() === $(firstPassword).val());
                            });
                        });
                    }
                };
            }])

        .directive('integer', function () {
            return {
                require: 'ngModel',
                link: function (scope, elm, attrs, ctrl) {
                    ctrl.$validators.integer = function (modelValue, viewValue) {
                        if (ctrl.$isEmpty(modelValue)) {
                            // consider empty models to be valid
                            return true;
                        }
                        var INTEGER_REGEXP = /^\-?\d+$/;
                        if (INTEGER_REGEXP.test(viewValue)) {
                            // it is valid
                            return true;
                        }

                        // it is invalid
                        return false;
                    };
                }
            };
        })
        .directive('welcomeMessage', function () {
            return {
                restrict: 'AE',
                scope: {
                    message: '@message'
                },
                controller: function ($scope) {
                    if ($scope.message != '') {
                        alertify.message($scope.message, 20);
                    }
                }
            };
        })

        .directive('validateWebAddress', function () {
            var URL_REGEXP = /^((?:http|ftp)s?:\/\/)(?:(?:[A-Z0-9](?:[A-Z0-9-]{0,61}[A-Z0-9])?\.)+(?:[A-Z]{2,6}\.?|[A-Z0-9-]{2,}\.?)|localhost|\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})(?::\d+)?(?:\/?|[\/?]\S+)$/i;
            return {
                require: 'ngModel',
                restrict: 'A',
                link: function (scope, element, attrs, ctrl) {
                    element.on("keyup", function () {
                        var isValidUrl = URL_REGEXP.test(element.val());
                        if (isValidUrl && element.hasClass('alert-danger') || element.val() == '') {
                            element.removeClass('alert-danger');
                        } else if (isValidUrl == false && !element.hasClass('alert-danger')) {
                            element.addClass('alert-danger');
                        }
                    });
                }
            };
        })
        .directive('welcomePopup', [ 'socket', 'userService', '$window', function (socket, userService, $window) {
            return {
                restrict: 'EA',
                scope: {
                    inRoom: '=inRoom'
                },
                controller: function ($scope, $timeout, $uibModal, appSettings) {
                    
                    if (!appSettings.USER && !sessionStorage.closePopup) {
                        $timeout(function () {
                            var autoInstance = $uibModal.open({
                                animation: true,
                                templateUrl: appSettings.BASE_URL + 'app/modals/register-modal/modal.html?v=' + Math.random().toString(36).slice(2),
                                controller: 'RegisterInstanceCtrl',
                                backdrop: 'static',
                                size: 'lg welcome',
                                keyboard: false
                            });
                            autoInstance.result.then(function (res) {

                            });
                        }, 3);
                    }
                    
                    socket.on('video-chat-request', function (data) {
                        //get request name
                        //

                        if (appSettings.USER && appSettings.USER.role == 'model' && appSettings.USER.id == data.model) {
                            userService.findMember(data.from).then(function (user) {

                                if (user.status == 200 && user.data.id) {
                                    //show messages for private request
                                    data.requestUrl = appSettings.BASE_URL + 'models/privatechat/' + data.from + '?roomId=' + data.room + '&vr=' + data.virtualRoom;
                                    data.name = user.data.firstName + ' ' + user.data.lastName;
                                    data.username = user.data.username;
                                    data.avatar = user.data.avatar;
                                    
                                    //show as confirm
                                    if(!$scope.inRoom){
                                            
                                            alertify.confirm(data.name + ' send private chat request.', function(){
                                            $window.location.href = data.requestUrl;
                                        },function(){
                                            callBackDenial(data);

                                        }).setting('labels',{'ok':'Accept', 'cancel': 'Deny'}).setHeader('Private Chat').autoCancel(25).setting('modal', false);
                                    }else{
                                        var msg = alertify.message('You just received a private call request from ' + data.name + ', click here to accept.',25);
                                        msg.callback = function (isClicked) {
                                            if (isClicked)
                                                $window.location.href = data.requestUrl;
                                            else
                                                callBackDenial(data);
    
                                        };
                                    }
                                }
                            });
                        }
                    });
                    function callBackDenial(data){
                        angular.element('ul.list-user li#private-'+data.from).remove();
                        var totalRequest = angular.element('.tab-content .tab-private ul.list-user li').length;

                        angular.element('span#private-amount').text(totalRequest);
                        socket.emit('model-denial-request', data.virtualRoom);
                    }
                    
                }
            };
        }])
        .directive('validateEmail', function () {
            var EMAIL_REGEXP = /^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;

            return {
                require: 'ngModel',
                restrict: '',
                link: function (scope, elm, attrs, ctrl) {
                    // only apply the validator if ngModel is present and Angular has added the email validator
                    if (ctrl && ctrl.$validators.email) {

                        // this will overwrite the default Angular email validator
                        ctrl.$validators.email = function (modelValue) {
                            return ctrl.$isEmpty(modelValue) || EMAIL_REGEXP.test(modelValue);
                        };
                    }
                }
            };
        })
        .directive('fallbackSrc', function () {
            var fallbackSrc = {
                link: function postLink(scope, iElement, iAttrs) {
                    iElement.bind('error', function () {
                        angular.element(this).attr("src", iAttrs.fallbackSrc);
                    });
                }
            }
            return fallbackSrc;
        })
        .directive('emojiInput', [ '$timeout', function ($timeout) {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function ($scope, $el, $attr, ngModel) {
            $.emojiarea.path = '/lib/jquery-emojiarea-master/packs/basic/images';
            
            var options = $scope.$eval({wysiwyg:true});
            var $wysiwyg =  $($el[0]).emojiarea(options);
            $wysiwyg.on('change', function () {
                ngModel.$setViewValue($wysiwyg.val());
                $scope.$apply();
            });
            
         $('.chat-mes').on('keypress',function(e) {

            var code = e.keyCode || e.which;
            if(code == 13) {
                angular.element('#send-message').trigger('click');
               e.preventDefault();
            }
         });
            ngModel.$formatters.push(function (data) {
                // emojiarea doesn't have a proper destroy :( so we have to remove and rebuild
                $wysiwyg.siblings('.emoji-wysiwyg-editor, .emoji-button').remove();
                $timeout(function () {
                    $wysiwyg.emojiarea(options);
                }, 0);
                return data;
            });
        }
    };
}]);