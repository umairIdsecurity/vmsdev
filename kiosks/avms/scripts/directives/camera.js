'use strict';

/**
 * @ngdoc directive
 * @name avmsKioskApp.directive:camera
 * @description
 * # camera
 */
angular.module('avmsKioskApp')
  .directive('camera', function (CameraService) {
    return {
      templateUrl: 'views/camera_capture.html',
      restrict: 'EA',
      replace: true,
      transclude: true,
      scope: {
        callBack: '&captureCallback'
      },
      controller: function($scope, $q, $timeout) {
        $scope.retake = function() {
          $scope.isShowingPreview = false;
        };

        $scope.usePhoto = function() {
            CameraService.currentStream.stop();
            $scope.callBack();
        };

        $scope.isShowingPreview = false;
        this.takeSnapshot = function() {
          var canvas = document.querySelector('canvas'),
              ctx    = canvas.getContext('2d'),
              videoElement = document.querySelector('video'),
              d      = $q.defer();

          canvas.width = videoElement.videoWidth;
          canvas.height= videoElement.videoHeight;

          $timeout(function() {
            ctx.fillRect(0,0,$scope.w,$scope.h);
            console.log(canvas.width,canvas.height);
            ctx.drawImage(videoElement, 0, 0, canvas.width, canvas.height);
            var imgDataURL = canvas.toDataURL("image/png");
            console.log('Img Data URL: '+ imgDataURL);
            CameraService.capturedPhotoURL = imgDataURL;
            d.resolve(imgDataURL);
            $scope.isShowingPreview = true;
          }, 0);
          return d.promise;
        };
      },
      link: function(scope, element, attrs) {
        var w = attrs.width || 700,
            h = attrs.heigh || 300;

        if (!CameraService.hasUserMedia) { return; }
        var userMedia = CameraService.getUserMedia(),
            videoElement = document.querySelector('video');
        var onSuccess = function(stream) {
          CameraService.currentStream = stream;
          if (navigator.mozGetUserMedia) {
            videoElement.mozSrcObject = stream;
          }
          else {
            var vendorURL = window.URL || window.webkitURL;
            videoElement.src = window.URL.createObjectURL(stream);
          }
          videoElement.play();
        };

        var onFailure = function(err) {
          console.error(err);
        };

        navigator.getUserMedia({
          video: {
            mandatory: {
              maxHeight: h,
              maxWidth: w
            }
          },
          audio: false
        }, onSuccess, onFailure);
        scope.w = w;
        scope.h = h;
      }
    };
  })
  .directive('cameraControlSnapshot', function() {
    return {
      restrict: 'EA',
      require: '^camera',
      scope: true,
      template: '<a id="snapshotButton" class="capture-btn" ng-click="takeSnapshot()"><img  style="width:100px;" src="http://imgur.com/nQtAKqy.jpg"></img><br/>CAPTURE IMAGE</a>',
      link: function(scope, ele, attrs, cameraCtrl) {
        var btn = $('#snapshotButton').first();
        var vid = $('.camera');
        vid.append(btn);
        scope.takeSnapshot = function() {
          cameraCtrl.takeSnapshot()
          .then(function(image) {
          });
        };
      }
    };
  });
