'use strict';

/**
 * @ngdoc service
 * @name avmsKioskApp.ConfigService
 * @description
 * # ConfigService
 * Service in the avmsKioskApp.
 */
angular.module('avmsKioskApp.ConfigService', [])
  .factory('ConfigService', ['$rootScope', '$location', '$localStorage', 'DataService', function ($rootScope, $location, $localStorage, DataService) {
    var initialConfig = {companyTagLine: '', pickupLocation: 'Reception', brandInfo: {companyLogoURL: '/AVMS_kiosk/images/avms_logo.png', actionForwardButton: {}, completeButton: {}, neutralButton: {}, navigationMenu: {}, sideMenueAndHeaderText: {}}};

    function setBrandingInfo(info) {
		initialConfig.brandInfo.companyLogoURL = "data:image;base64," + info.companyLogoURL;
		var infoKeys = ['actionForwardButton', 'completeButton', 'neutralButton', 'navigationMenu', 'sideMenueAndHeaderText'];
		angular.forEach(infoKeys, function(key) {
			angular.forEach(info[key], function(v, k) {
				if(k.substring(0, 5) != "hover") {
					var jsKey = k.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();
					initialConfig.brandInfo[key][jsKey] = v;
				}
			});
		});
    }

    function loadConfiguration() {
		DataService.getAdmin(
			function(data, responseCode) {
				initialConfig.companyName = data.companyName;
				initialConfig.pickupLocation = data.VICPickupLocation;
				initialConfig.complianceTerms = data.complianceTerms;				
				initialConfig.companyTagLine = data.companyTagLine.toUpperCase();
				console.log(initialConfig.complianceTerms);
				setBrandingInfo(data.brandInfo);

				$rootScope.$broadcast('config:updated', initialConfig);
			},
			function(data, responseCode) {
				if(responseCode == 401 && data.errorCode == 'UNAUTHORIZED'){/* If not Authorised send back to Login screen */
					delete $localStorage.globals;
					DataService.authToken = '';
					DataService.kiosk = '';
					DataService.workstation = '';
					DataService.ktoken = '';
					DataService.info[0] = "Requested Token is expired, Please login."
					$location.path('/');
				}
				initialConfig.error = data;
			}
		);
    }

    loadConfiguration();

    return initialConfig;
}]);