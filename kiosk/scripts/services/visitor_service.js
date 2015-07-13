'use strict';

angular.module('kiosk.VisitorService', [])
  .factory('VisitorService', function() {
    var currentVisitor = {  reset: function() {
                              this.firstName = null;
                              this.lastName = null;
                              this.email = null;
                              this.visitorID = null;
                              this.companyName = null;
                              this.password = null;
                              this.termsAccepted = null;
                              this.profilePhotoURL = null;
                              this.host = null;
                            },
                            setHost: function(host) {
                              this.host = host;
                            }
    };
    currentVisitor.reset();
    return currentVisitor;
  });
