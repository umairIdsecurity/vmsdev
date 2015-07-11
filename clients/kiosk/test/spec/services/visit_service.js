'use strict';

describe('Service: visitService', function () {

  // load the service's module
  beforeEach(module('kioskApp'));

  // instantiate service
  var visitService;
  beforeEach(inject(function (_visitService_) {
    visitService = _visitService_;
  }));

  it('should do something', function () {
    expect(!!visitService).toBe(true);
  });

});
