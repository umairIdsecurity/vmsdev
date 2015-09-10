'use strict';

describe('Controller: AsicsponsorremoteCtrl', function () {

  // load the controller's module
  beforeEach(module('avmsKioskApp'));

  var AsicsponsorremoteCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    AsicsponsorremoteCtrl = $controller('AsicsponsorremoteCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
