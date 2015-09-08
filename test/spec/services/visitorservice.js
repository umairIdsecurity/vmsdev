'use strict';

describe('Service: VisitorService', function () {

  // load the service's module
  beforeEach(module('avmsKioskApp'));

  // instantiate service
  var VisitorService;
  beforeEach(inject(function (_VisitorService_) {
    VisitorService = _VisitorService_;
  }));

  it('should do something', function () {
    expect(!!VisitorService).toBe(true);
  });

});
