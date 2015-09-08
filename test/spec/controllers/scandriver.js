'use strict';

describe('Controller: ScandriverCtrl', function () {

  // load the controller's module
  beforeEach(module('avmsKioskApp'));

  var ScandriverCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    ScandriverCtrl = $controller('ScandriverCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
