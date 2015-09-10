'use strict';

describe('Controller: AsicsponsorloginCtrl', function () {

  // load the controller's module
  beforeEach(module('avmsKioskApp'));

  var AsicsponsorloginCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    AsicsponsorloginCtrl = $controller('AsicsponsorloginCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
