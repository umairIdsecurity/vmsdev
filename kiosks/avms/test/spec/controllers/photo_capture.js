'use strict';

describe('Controller: PhotoCaptureCtrl', function () {

  // load the controller's module
  beforeEach(module('avmsKioskApp'));

  var PhotoCaptureCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    PhotoCaptureCtrl = $controller('PhotoCaptureCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
