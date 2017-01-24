'use strict';
angular.module('myApp')
.controller('RegisterController', function($scope, RegistrationService){
	//default variables
	$scope.submitText = "Save";
	$scope.submitted = false;
	$scope.message = '';
	$scope.isFormValid = false;
	$scope.User = {
		name: '',
		emailID: '',
		password: '',
		age: ''
	}
	//check form validation
	$scope.$watch('regForm.$valid',function(newValue){
		$scope.isFormValid = newValue;

	});
	//save data
	$scope.SaveData = function (data) {
		if($scope.submitText == 'Save'){
			$scope.submitted = true;
			$scope.message = '';
			if($scope.isFormValid){
				$scope.submitText = 'Pelase Wait...';
				$scope.User = data;
				console.log(data);
				RegistrationService.SaveFormData($scope.User).then(function(d){
					//if(d == 'success'){
						//console.log(d);
						//have to clear the form here
						clearForm();
					//}
					$scope.submitText = 'Save';
					$scope.message = d.data.message;
				});


			} else{
				$scope.message = 'Please fill the required fields value';
			}
		}
	}
	//clear form
	function clearForm() {
		$scope.User = {};
		//$scope.regForm.$setPristime();
		//$scope.submitted = false;
	}
})

.factory('RegistrationService', function($http, $q){
	var fac = {};
	fac.SaveFormData = function(data){
		var defer = $q.defer();
		var url = "http://35.161.138.102/src/public/userDetails.php/addUserDetails";
		return $http.post(url, data);
	}
	return fac;
})













//confirm password check
.directive('validPasswordC', function() {
  return {
    require: 'ngModel',
    scope: {

      reference: '=validPasswordC'

    },
    link: function(scope, elm, attrs, ctrl) {
      ctrl.$parsers.unshift(function(viewValue, $scope) {

        var noMatch = viewValue != scope.reference
        ctrl.$setValidity('noMatch', !noMatch);
        return (noMatch)?noMatch:!noMatch;
      });

      scope.$watch("reference", function(value) {;
        ctrl.$setValidity('noMatch', value === ctrl.$viewValue);

      });
    }
  }
});
