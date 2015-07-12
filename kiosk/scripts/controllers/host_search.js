'use strict';

/**
 * @ngdoc function
 * @name kioskApp.controller:HostSearchCtrl
 * @description
 * Allows the visitor to search the remote database of hosts and choose one.
 * Results of the API search are displayed to the user, through the 'hostOptions'
 * variable on the scope.
 */
angular.module('kioskApp')
  .controller('HostSearchCtrl', ['$scope', '$location', 'VisitorService', '$http', 'DataService', 'VisitService', 'ConfigService',
              function ($scope, $location, VisitorService, $http, DataService, VisitService, ConfigService) {
                function updateStyles() {
                  $scope.forwardButtonStyle = ConfigService.brandInfo.actionForwardButton;
                  $scope.backButtonStyle = ConfigService.brandInfo.neutralButton;
                }

                $scope.hasError = false;

                $scope.visitor = VisitorService;
                $scope.host = null;
                $scope.hostOptions = [];
                $scope.query = '';

                $scope.choose = function(host) {
                  $scope.host = host;
                  $scope.query = null;
                };

                $scope.notifyHost = function() {
                  VisitorService.setHost($scope.host);
                  DataService.createVisit({ visitorID: VisitorService.visitorID,
                                          hostID: VisitorService.host.hostID,
                                          visitorType: 2,
                                          startTime: new Date().toJSON(),
                                          expectedEndTime: new Date().toJSON(),
                                          visitReason: 1,
                                          workstation: 8 },
                                          function(data, responseCode) {
                                            var visitInfo = data[0];
                                            VisitService.visitID = visitInfo.visitID;
                                            $scope.hasError = false;
                                            console.log('Got visitID: '+ visitInfo.visitID);
                                            $location.path('photo_capture');
                                          },
                                          function(data, responseCode) {
                                            console.log('Create visit failed: ' + data);
                                            $scope.hasError = true;
                                          });
                };

                $scope.performNewSearch = function() {
                  $scope.hostOptions = [];
                  if ($scope.query.length > 3) {
                    $scope.host = null;
                    DataService.searchHost($scope.query,
                                           function(data, responseCode) {
                                             $scope.hostOptions = data;
                                             var results = null;
                                             if(data.length > 5) {
                                               results = data.slice(0, 5);
                                             }
                                             else {
                                               results = data;
                                             }
                                             $scope.hostOptions = results;
                                           },
                                           function(data, responseCode) {
                                             $scope.hostOptions = [];
                                           });
                  }
                };

                $scope.goBack = function() {
                  $location.path('visitor_email');
                };

                updateStyles();
              }]);
