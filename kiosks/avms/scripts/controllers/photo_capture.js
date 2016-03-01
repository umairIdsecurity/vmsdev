'use strict';

/**
 * @ngdoc function
 * @name avmsKioskApp.controller:PhotoCaptureCtrl
 * @description
 * # PhotoCaptureCtrl
 * Controller of the avmsKioskApp
 */
angular.module('avmsKioskApp')
  .controller('PhotoCaptureCtrl', ['$scope', '$location', 'CameraService', 'VisitorService','DataService', 'ConfigService', function ($scope, $location, CameraService, VisitorService, DataService, ConfigService) {
    function updateStyles() {
      $scope.forwardButtonStyle = ConfigService.brandInfo.actionForwardButton;
      $scope.backButtonStyle = ConfigService.brandInfo.neutralButton;
    }

    $scope.hasError = false;
    $scope.showControls = true;
    $scope.showSpinner = false;

    var showNotice = function() {
      $location.path('pickup_notice');
    };

    $scope.useCapturedPhoto = function() {
      console.log('uploading...');
      $scope.showSpinner = true;
      $scope.showControls = false;
      VisitorService.profilePhotoURL = CameraService.capturedPhotoURL;
      DataService.uploadPhoto(VisitorService.profilePhotoURL,
                              function(data, responseCode) {
                                showNotice();
                              },
                              function(data, responseCode) {
                                $scope.hasError = true;
                              });
    };

    $scope.goBack = function() {
      $location.path('asicSponsorRemote');
    };

    updateStyles();
  }]);
