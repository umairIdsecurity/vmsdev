'use strict';

describe('Controller: ReasonCtrl', function () {

  // load the controller's module
  beforeEach(module('avmsKioskApp'));

  var ReasonCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    ReasonCtrl = $controller('ReasonCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
