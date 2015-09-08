'use strict';

/**
 * @ngdoc service
 * @name kioskApp.cameraService
 * @description
 * Some neccessities for accessing the camera.
 */
angular.module('avmsKioskApp.CameraService', [])
  .factory('CameraService', function ($window) {
    var hasUserMedia = function() {
      return !!getUserMedia();
    };

    var getUserMedia = function() {
      navigator.getUserMedia = ($window.navigator.getUserMedia ||
                                $window.navigator.webkitGetUserMedia ||
                                $window.navigator.mozGetUserMedia ||
                                $window.navigator.msGetUserMedia);
      return navigator.getUserMedia;
    };

    return { hasUserMedia: hasUserMedia(),
             getUserMedia: getUserMedia,
             currentStream: null,
             capturedPhotoURL: null };
  });
