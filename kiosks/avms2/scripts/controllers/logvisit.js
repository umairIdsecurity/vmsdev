'use strict';

/**
 * @ngdoc function
 * @name avmsKioskApp.controller:LogvisitCtrl
 * @description
 * # LogvisitCtrl
 * Controller of the avmsKioskApp
 */
angular.module('avmsKioskApp')
  .controller('LogvisitCtrl', function ($scope) {
    $scope.ctype = {"id":"1","name":"24 Hour - VIC","card_image":"/kiosks/avms/images/vic.png"};
  });
