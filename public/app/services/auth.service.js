angular.module('matroshkiApp')
.factory('authService', [ '$http', 'userService', '$cookieStore', '$q', 'appSettings', function ($http, userService, $cookieStore, $q, appSettings) {
  var currentUser = userService.get();
  return {
    /**
     * Authenticate user and save token
     *
     * @param  {Object}   user     - login info
     * @param  {Function} callback - optional
     * @return {Promise}
     */
    login: function (user, callback) {
      var cb = callback || angular.noop;
      var deferred = $q.defer();

      $http.post(appSettings.BASE_URL + 'api/v1/auth/login', {
        username: user.username,
        password: user.password
      })
      .success(function (data) {
        $cookieStore.put('token', data.token);
        currentUser = userService.get();
        deferred.resolve(data);
        return cb();
      })
      .error(function (err) {
        this.logout();
        deferred.reject(err);
        return cb(err);
      }.bind(this));

      return deferred.promise;
    },
    /*
     * Update password after confirm email
     * @returns {function}
     */
    resetPassword: function (user) {
      return $http.post(ppSettings.BASE_URL + 'api/v1/users/resetPassword', {
        email: user.email,
        password: user.password,
        confirmPassword: user.confirmPassword
      });
    },
    /*
     * Forgot password
     * @returns {undefined}
     */
    forgotPassword: function (user, cb) {
      return $http.post(ppSettings.BASE_URL + 'api/users/forgotPassword', {
        email: user.email
      }).success(function (data) {
        return cb(data);
      })
      .error(function (err) {
        return cb(err);
      }.bind(this));
    },
    /**
     * Delete access token and user info
     *
     * @param  {Function}
     */
    logout: function () {
      $cookieStore.remove('token');
      currentUser = {};
    },
    /**
     * Create a new user
     *
     * @param  {Object}   user     - user info
     * @param  {Function} callback - optional
     * @return {Promise}
     */
     createUser: function (user, callback) {
       var cb = callback || angular.noop;
       return $http.post(appSettings.BASE_URL + 'api/v1/user/account-new', user)
      .success(function (data) {
        return cb(data);
      })
      .error(function (err) {
        return cb(err);
      }).$promise;
     },
    /**
     * Change password
     *
     * @param  {String}   oldPassword
     * @param  {String}   newPassword
     * @param  {Function} callback    - optional
     * @return {Promise}
     */
    changePassword: function (oldPassword, newPassword, callback) {
      var cb = callback || angular.noop;
      
      return $http.put(appSettings.BASE_URL + 'api/v1/users/change-password', {
        oldPassword: oldPassword,
        newPassword: newPassword
      })
      .success(function (data) {
        return cb(data);
      })
      .error(function (err) {
        return cb(err);
      }).$promise;
    },
    /**
     * Gets all available info on authenticated user
     *
     * @return {Object} user
     */
    getCurrentUser: function () {
      return currentUser;
    },
    /**
     * Check if a user is logged in
     *
     * @return {Boolean}
     */
    isLoggedIn: function () {
      return currentUser.hasOwnProperty('role');
    },
    /**
     * Waits for currentUser to resolve before checking if user is logged in
     */
    isLoggedInAsync: function (cb) {
      if (currentUser.hasOwnProperty('$promise')) {
        currentUser.$promise.then(function () {
          cb(true);
        }).catch(function () {
          cb(false);
        });
      } else if (currentUser.hasOwnProperty('role')) {
        cb(true);
      } else {
        cb(false);
      }
    },
    /**
     * Check if a user is an admin
     *
     * @return {Boolean}
     */

    /**
     * Get auth token
     */
    getToken: function () {
      return $cookieStore.get('token');
    },
    recoverPassword: function (email, callback) {
      var cb = callback || angular.noop;
      var deferred = $q.defer();

      $http.post(ppSettings.BASE_URL + 'auth/recoverPassword', {
        email: email
      })
      .success(function (data) {
        deferred.resolve(data);
        return cb();
      })
      .error(function (err) {
        deferred.reject(err);
        return cb(err);
      }.bind(this));

      return deferred.promise;
    },
    confirmResetPasswordToken: function (token, callback) {
      var cb = callback || angular.noop;
      var deferred = $q.defer();

      $http.get(ppSettings.BASE_URL + 'auth/confirmPasswordResetToken/' + token)
        .success(function (data) {
          //do login
          $cookieStore.put('token', data.token);
          currentUser = userService.get();

          deferred.resolve(data);
          return cb();
        })
        .error(function (err) {
          deferred.reject(err);
          return cb(err);
        }.bind(this));

      return deferred.promise;
    }
  };
}]);