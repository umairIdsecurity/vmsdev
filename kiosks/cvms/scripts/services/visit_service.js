'use strict';

/**
 * @ngdoc service
 * @name kioskApp.visitService
 * @description
 * # visitService
 * Factory in the kioskApp.
 */
angular.module('kiosk.VisitService', [])
  .factory('VisitService', function () {
    return { visitID: null };
  });
