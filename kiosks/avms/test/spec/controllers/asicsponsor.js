'use strict';

describe('Controller: AsicsponsorCtrl', function () {

  // load the controller's module
  beforeEach(module('avmsKioskApp'));

  var AsicsponsorCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    AsicsponsorCtrl = $controller('AsicsponsorCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
