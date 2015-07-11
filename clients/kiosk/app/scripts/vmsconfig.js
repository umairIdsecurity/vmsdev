/**
 * @ngdoc Module
 * @name kiosk.config
 * @description
 * This module just defines a single constant for the configuration
 * values in Kiosk. It can be extended later (if needed) to support
 * different environments.
 */
angular.module('kiosk.config', []).constant('VMSConfig',
{
  baseURL:"http://vmsdev.identitysecurity.com.au/index.php",
  authToken: "IzVPOD9PXjz26sSCPkKV",
  adminEmail: "tom@growthapps.net"
});
