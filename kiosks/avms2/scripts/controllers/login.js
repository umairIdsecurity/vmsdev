'use strict';

/**
 * @ngdoc function
 * @name avmsKioskApp.controller:LoginCtrl
 * @description
 * # LoginCtrl
 * Controller of the avmsKioskApp
 */
angular.module('avmsKioskApp')
  .controller('LoginCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];

	$scope.showModal = function() {
		angular.element("#forgotModal").show();
	}

	$scope.closeModal = function() {
		angular.element("#forgotModal").hide();
	}
  });
