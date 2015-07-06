'use strict';

describe('Controller: HostSearchCtrl', function () {

  // load the controller's module
  beforeEach(module('kioskApp'));

  var HostSearchCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    HostSearchCtrl = $controller('HostSearchCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
