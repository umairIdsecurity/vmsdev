'use strict';

describe('Directive: camera', function () {

  // load the directive's module
  beforeEach(module('avmsKioskApp'));

  var element,
    scope;

  beforeEach(inject(function ($rootScope) {
    scope = $rootScope.$new();
  }));

  it('should make hidden element visible', inject(function ($compile) {
    element = angular.element('<camera></camera>');
    element = $compile(element)(scope);
    expect(element.text()).toBe('this is the camera directive');
  }));
});
