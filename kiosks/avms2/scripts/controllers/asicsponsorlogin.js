'use strict';

/**
 * @ngdoc function
 * @name avmsKioskApp.controller:AsicsponsorloginCtrl
 * @description
 * # AsicsponsorloginCtrl
 * Controller of the avmsKioskApp
 */
angular.module('avmsKioskApp')
  .controller('AsicsponsorloginCtrl', function ($scope) {
    $scope.showModal = function() {
		angular.element("#forgotModal").show();
	}

	$scope.closeModal = function() {
		angular.element("#forgotModal").hide();
	}
  });
