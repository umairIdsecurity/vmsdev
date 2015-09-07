'use strict';

describe('Service: VisitService', function () {

  // load the service's module
  beforeEach(module('avmsKioskApp'));

  // instantiate service
  var VisitService;
  beforeEach(inject(function (_VisitService_) {
    VisitService = _VisitService_;
  }));

  it('should do something', function () {
    expect(!!VisitService).toBe(true);
  });

});
