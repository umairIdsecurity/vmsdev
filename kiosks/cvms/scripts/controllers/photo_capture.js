'use strict';

/**
 * @ngdoc function
 * @name kioskApp.controller:PhotoCaptureCtrl
 * @description
 * Most of the heavy lifting here is done through the camera.js directive.
 * The useCapturedPhoto function provides a hook point where the camera directive
 * can pass its output to this controller.
 */
angular.module('kioskApp')
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
      $location.path('host_search');
    };

    updateStyles();
  }]);
