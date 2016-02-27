'use strict';

describe('Controller: PreregistrationDeclarationsCtrl', function () {

  // load the controller's module
  beforeEach(module('avmsKioskApp'));

  var PreregistrationDeclarationsCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    PreregistrationDeclarationsCtrl = $controller('PreregistrationDeclarationsCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
