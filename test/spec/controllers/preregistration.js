'use strict';

describe('Controller: PreregistrationCtrl', function () {

  // load the controller's module
  beforeEach(module('avmsKioskApp'));

  var PreregistrationCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    PreregistrationCtrl = $controller('PreregistrationCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
