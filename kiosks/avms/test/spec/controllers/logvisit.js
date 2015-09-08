'use strict';

describe('Controller: LogvisitCtrl', function () {

  // load the controller's module
  beforeEach(module('avmsKioskApp'));

  var LogvisitCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    LogvisitCtrl = $controller('LogvisitCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
