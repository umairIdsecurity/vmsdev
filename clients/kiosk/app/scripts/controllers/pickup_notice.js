'use strict';

/**
 * @ngdoc function
 * @name kioskApp.controller:PickupNoticeCtrl
 * @description
 * # PickupNoticeCtrl
 * Controller of the kioskApp
 */
angular.module('kioskApp')
  .controller('PickupNoticeCtrl', ['$scope', '$location', 'ConfigService', 'VisitorService', function ($scope, $location, ConfigService, VisitorService) {
    $scope.pickupLocation = ConfigService.pickupLocation;
    $scope.startOver = function() {
      $location.path('/');
      VisitorService.reset();
    };
  }]);
