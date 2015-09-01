'use strict';

/**
 * @ngdoc service
 * @name avmsKioskApp.VisitorService
 * @description
 * # VisitorService
 * Service in the avmsKioskApp.
 */
angular.module('avmsKioskApp.VisitorService', [])
	.factory('VisitorService', function() {
		var currentVisitor = {  reset: function() {
                              this.firstName = null;
                              this.lastName = null;
                              this.email = null;
                              this.visitorID = null;
                              this.companyName = null;
							  this.cardType = null;
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