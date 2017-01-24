'use strict';

// declare modules
angular.module('Authentication', []);
angular.module('Home', []);

//var app = angular.module('myApp', []);
var app = angular.module('myApp', [
  'Authentication',
  'Home',
  'ngRoute',
  'ngCookies'
]);
app.config(['$routeProvider', function($routeProvider) {

  $routeProvider
    .when('/login', {
      controller: 'LoginController',
      templateUrl: 'modules/authentication/views/login.html',
      hideMenus: true
    })

  .when('/', {
    controller: 'HomeController',
    templateUrl: 'views/index.html'
  })

  .when('/about', {
    controller: 'AboutController',
    templateUrl: 'views/about.html'
  })

	.when('/wayto', {
		controller: 'waytoController',
		templateUrl: 'views/wayto.html'
	})

	.when('/commongood', {
		controller: 'commonGoodController',
		templateUrl: 'views/commongood.html'
	})

	.when('/profile', {
		controller: 'profileController',
		templateUrl: 'views/profile.html'
	})

	.when('/register', {
		controller: 'RegisterController',
		templateUrl: 'modules/registration/views/registration.html'
	})
	//login redirections
  .otherwise({
    redirectTo: '/'
  });
}])

app.run(['$rootScope', '$location', '$cookieStore', '$http',
  function($rootScope, $location, $cookieStore, $http) {
    // keep user logged in after page refresh
    $rootScope.globals = $cookieStore.get('globals') || {};
    if ($rootScope.globals.currentUser) {
      $http.defaults.headers.common['Authorization'] = 'Basic ' + $rootScope.globals.currentUser.authdata; // jshint ignore:line
    }

    $rootScope.$on('$locationChangeStart', function(event, next, current) {
      // redirect to login page if not logged in
      var allowedPages = $.inArray($location.path(), ['/','#!', '/about', '/wayto', '/commongood', '/register']) === -1;
			//console.log($location.path());
	  var loggedIn = $rootScope.globals.currentUser;
      //if (allowedPages && !loggedIn) {
		if (allowedPages && !loggedIn) {
			$location.path('/login');
		  }
    });
  }
]);

app.controller('profileController', function($scope, profileFactory){
	  $scope.createProfile = false;
    $scope.toggle = function() {
        $scope.createProfile = !$scope.createProfile;
    };

	//$scope.profileData = [{"name": "blr"}];

	/*$http.get("http://35.161.138.102/src/public/userDetails.php/getUserDetailsByEmailId").then(function (response) {
		  $scope.profileData = response.data;
		  console.log(response.data)
	  });

	  profileFactory.getprofileData().then(
			function(data){
				$scope.profileData = data.data;
				console.log(data.data);
			},
			function(err){
				alert(err.status);
			}
		);*/



});

app.factory("profileFactory", function($http){
	//url = "";
	return {
		getprofileData  : function(email){
			return $http.get("http://35.161.138.102/src/public/userDetails.php/getUserDetailsByEmailId");
		}
	}

});




app.controller('communityCtrl', function($scope, $http) {
  $http.get("json/community.json").then(function (response) {
      $scope.communityData = response.data.data;
  });
  $http.get("json/upcomingEvents.json").then(function (response) {
      $scope.upcomingEventsData = response.data.data;
  });
});


/*
//Request Invite Controller...
app.controller('inviteController', function($scope, $http) {
      // create a blank object to handle form data.
        $scope.user = {};
		var data = $scope.user;
      // calling our submit function.
        $scope.submitForm = function() {
        // Posting data to php file
        $http({
          method  : 'POST',
          url     :  '',
          data    : data, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'}
         })
          .success(function(data) {
            if (data.errors) {
              // Showing errors.
              //$scope.errorName = data.errors.name;
              //$scope.errorUserName = data.errors.username;
              $scope.errorEmail = data.errors.email;
			 // console.log(data);
            } else {
              $scope.message = data.message;
            }
          });
        };
});
*/
