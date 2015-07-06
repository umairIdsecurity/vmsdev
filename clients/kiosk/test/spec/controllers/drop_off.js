'use strict';

describe('Controller: DropOffCtrl', function () {

  // load the controller's module
  beforeEach(module('kioskApp'));

  var DropOffCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    DropOffCtrl = $controller('DropOffCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
