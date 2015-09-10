'use strict';

describe('Controller: PickupCtrl', function () {

  // load the controller's module
  beforeEach(module('avmsKioskApp'));

  var PickupCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    PickupCtrl = $controller('PickupCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
