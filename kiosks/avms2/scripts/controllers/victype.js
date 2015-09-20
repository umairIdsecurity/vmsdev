'use strict';

/**
 * @ngdoc function
 * @name avmsKioskApp.controller:VictypeCtrl
 * @description
 * # VictypeCtrl
 * Controller of the avmsKioskApp
 */
angular.module('avmsKioskApp')
  .controller('VictypeCtrl', function ($scope) {
    $scope.ctypeOptions = [
		{"id":"1","name":"24 Hour - VIC","card_image":"/kiosks/avms/images/vic.png"},
		{"id":"2","name":"Extended - VIC","card_image":"/kiosks/avms/images/evic.png"},
	];

	$scope.getCDetail = function ($index) {
		$scope.selected_card = $scope.ctypeOptions[$index].id;
	};
  });
