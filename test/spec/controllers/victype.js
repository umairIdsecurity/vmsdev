'use strict';

describe('Controller: VictypeCtrl', function () {

  // load the controller's module
  beforeEach(module('avmsKioskApp'));

  var VictypeCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    VictypeCtrl = $controller('VictypeCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
