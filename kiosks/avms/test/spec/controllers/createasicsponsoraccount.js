'use strict';

describe('Controller: CreateasicsponsoraccountCtrl', function () {

  // load the controller's module
  beforeEach(module('avmsKioskApp'));

  var CreateasicsponsoraccountCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    CreateasicsponsoraccountCtrl = $controller('CreateasicsponsoraccountCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
