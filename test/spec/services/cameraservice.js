'use strict';

describe('Service: CameraService', function () {

  // load the service's module
  beforeEach(module('avmsKioskApp'));

  // instantiate service
  var CameraService;
  beforeEach(inject(function (_CameraService_) {
    CameraService = _CameraService_;
  }));

  it('should do something', function () {
    expect(!!CameraService).toBe(true);
  });

});
