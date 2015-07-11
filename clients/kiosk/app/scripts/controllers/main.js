'use strict';

/**
 * @ngdoc function
 * @name kioskApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the kioskApp
 */
angular.module('kioskApp')
  .controller('MainCtrl', ['$scope', '$location', 'ConfigService', function ($scope, $location, ConfigService) {
    function updateStyles() {
      $scope.forwardButtonStyle = ConfigService.brandInfo.actionForwardButton;

      $scope.checkOutButtonStyle = ConfigService.brandInfo.neutralButton;

      $scope.imgSrc = ConfigService.brandInfo.companyLogoURL;

      $scope.tagLine = ConfigService.companyTagLine;
    }

    // due to the network lag, we listen to a notification and update accordingly.
    $scope.$on('config:updated', updateStyles);

    $scope.changeView = function() {
      $location.path('compliance');
    };

    updateStyles();
  }]);
