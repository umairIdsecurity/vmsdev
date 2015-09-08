'use strict';

/**
 * @ngdoc function
 * @name avmsKioskApp.controller:ReasonCtrl
 * @description
 * # ReasonCtrl
 * Controller of the avmsKioskApp
 */
angular.module('avmsKioskApp')
  .controller('ReasonCtrl', function ($scope) {
    
    $scope.company = 'Random Co.';
    $scope.contact_name = 'Jan Schimdt';
    $scope.contact_email = 'jane.schmidt@company.com';
    $scope.contact_number = '+63512345678';
  });
