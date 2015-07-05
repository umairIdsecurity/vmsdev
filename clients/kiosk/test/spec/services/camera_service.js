'use strict';

describe('Service: cameraService', function () {

  // load the service's module
  beforeEach(module('kioskApp'));

  // instantiate service
  var cameraService;
  beforeEach(inject(function (_cameraService_) {
    cameraService = _cameraService_;
  }));

  it('should do something', function () {
    expect(!!cameraService).toBe(true);
  });

});
