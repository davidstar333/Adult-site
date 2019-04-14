angular.module('matroshkiApp').controller('RegisterInstanceCtrl', function (appSettings, $scope, $uibModalInstance, authService) {

  $scope.errors = {};
  $scope.user = {};
  $scope.welcomeImage = appSettings.registerImage;
  
  $scope.formSubmitted = false;
  $scope.createFreeAccount = function (form) {
    $scope.errors = {};
    if(!form.$valid){
      return false;
    }
    $scope.formSubmitted = true;
    
    authService.createUser($scope.user, function (data){
      
      if(data.success){
        
        alertify.success(data.message);
        sessionStorage.closePopup = true;
        $uibModalInstance.close(data);
      }else{
        $scope.formSubmitted = false;
        if(data.errors){
          $scope.errors = data.errors;
        }
//        alertify.error(data.message);
      }
    }, function (err){
      
    });
  };


  $scope.cancel = function () {
    sessionStorage.closePopup = true;
    $uibModalInstance.dismiss('cancel');
  };
});