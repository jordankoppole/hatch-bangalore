'use strict';

angular.module('Authentication')

.controller('LoginController',
    ['$scope', '$rootScope', '$location', 'AuthenticationService',
    function ($scope, $rootScope, $location, AuthenticationService) {
        // reset login status
        AuthenticationService.ClearCredentials();
 				//alert($rootScope.globals);
        $scope.login = function () {
            $scope.dataLoading = true;
            AuthenticationService.Login($scope.emailID, $scope.password, function(response) {
                if(response.error == false) {
                    AuthenticationService.SetCredentials($scope.emailID, $scope.password);
					//$window.location.assign('#/');
					          $scope.userIsLoggedIn = $rootScope.globals.currentUser;
					       //console.log($scope.userIsLoggedIn);
                    $location.path('/profile');
					$scope.$apply();
                } else {
                  //var $httpDefaultCache = $cacheFactory.get('$http');
					//$httpDefaultCache.remove(key);
                    $scope.error = response.message;
                    $scope.dataLoading = false;
                }
            });
        };
    }]);
