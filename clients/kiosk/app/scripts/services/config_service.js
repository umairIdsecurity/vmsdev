'use strict';

/**
 * @ngdoc service
 * @name kioskApp.configService
 * @description
 * This service contains all the relevant data from our GET Admin request, including
 * things like company tag line, compliance terms, or custom styles.
 */
angular.module('kiosk.ConfigService', [])
  .factory('ConfigService', ['$rootScope', 'DataService', function ($rootScope, DataService) {
    var initialConfig = {companyTagLine: '', pickupLocation: 'Reception', brandInfo: {companyLogoURL: 'images/IDSecLogo.png', actionForwardButton: {}, completeButton: {}, neutralButton: {}, navigationMenu: {}, sideMenueAndHeaderText: {}}};

    function setBrandingInfo(info) {
      initialConfig.brandInfo.companyLogoURL = info.companyLogoURL;
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
          console.log(initialConfig.complianceTerms);
          initialConfig.companyTagLine = data.companyTagLine.toUpperCase();
          setBrandingInfo(data.brandInfo);

          $rootScope.$broadcast('config:updated', initialConfig);
        },
        function(data, responseCode) {
          initialConfig.error = data;
        }
      );
    }

    loadConfiguration();

    return initialConfig;
  }]);
