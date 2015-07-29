'use strict';

/**
 * @ngdoc service
 * @name kioskApp.dataService
 * @description
 * # dataService
 * Factory in the kioskApp.
 */
angular.module('kiosk.DataService', [])
	.factory('DataService', ['$http', 'VisitService', 'VMSConfig', function ($http, VisitService, VMSConfig) {
		console.log('Data service got config: ' + VMSConfig);
		var authToken = VMSConfig.authToken;
		$http.defaults.headers.common['HTTP_X_VMS_TOKEN'] = authToken;
	return {
		baseURL: VMSConfig.baseURL,      
		adminEmail: VMSConfig.adminEmail,	  
		kiosk:'',
		workstation:0,
		cardType:0,
		ktoken:'',
		info:[],
		authLogin: function(email, password, onSuccess, onFailure) {
			var url = this.baseURL + '/authorization/admin';
			var params = { grant_type:'password', email: email, password: password,};
			$http.post(url, params).success(onSuccess).error(onFailure);
		},
		
		getAdmin: function(onSuccess, onFailure) {
			var url = this.baseURL + '/admin/' + this.adminEmail;
			console.log('GET: ' + url);
			$http.defaults.headers.common['HTTP_X_VMS_TOKEN'] = this.authToken;
			$http.get(url).success(onSuccess).error(onFailure);
		},
		
		getWorkstation: function(onSuccess, onFailure) {
			var url = this.baseURL + '/custom/workstations';
			var params = { email: this.adminEmail}; 
			$http.defaults.headers.common['HTTP_X_VMS_TOKEN'] = this.authToken;
			$http.post(url, params).success(onSuccess).error(onFailure);
		},
		
		resgiterKiosk: function(onSuccess, onFailure) {
			var url = this.baseURL + '/custom/registerkiosk';
			var params = { email: this.adminEmail, kiosk:this.kiosk, workstation: this.workstation}; 
			$http.defaults.headers.common['HTTP_X_VMS_TOKEN'] = this.authToken;
			$http.post(url, params).success(onSuccess).error(onFailure);
		},
		
		getVisitor: function(visitorEmail, onSuccess, onFailure) {
			var url = this.baseURL + '/visitor/' + visitorEmail;
			console.log('GET: ' + url);
			$http.get(url).success(onSuccess).error(onFailure);
		},
		
		searchComp: function(comp, onSuccess, onFailure) {
			var url = this.baseURL + '/custom/search';
			var params = { email: this.adminEmail, comp: escape(comp)}; 
			console.log('GET: ' + url);
			$http.post(url, params).success(onSuccess).error(onFailure);
		},
		
		createVisitor: function(visitorInfo, onSuccess, onFailure) {
			var url = this.baseURL + '/visitor';
			var params = { firstName: visitorInfo.firstName,
			lastName: visitorInfo.lastName,
			email: visitorInfo.email,
			/*company: '1', // TODO: this needs to change to 'visitorInfo.companyName' after the API has been fixed.*/
			company: visitorInfo.companyName, /* Changed as 27-July by fixing API */
			password: '123456',
			visitorType: '2',
			workstation:this.workstation};
			
			$http.post(url, params).success(onSuccess).error(onFailure);
		},
		
		getCardType: function(onSuccess, onFailure) {
			var url = this.baseURL + '/custom/cardtype';
			var params = { email: this.adminEmail, workstation: this.workstation}; 
			$http.defaults.headers.common['HTTP_X_VMS_TOKEN'] = this.authToken;
			$http.post(url, params).success(onSuccess).error(onFailure);
		},

		getCardDetail: function(VisitorService, onSuccess, onFailure) {			
			var url = this.baseURL + '/custom/carddetail';			
			var params = { ctype: VisitorService.cardType};			
			$http.post(url, params).success(onSuccess).error(onFailure);
		},
		
		searchHost: function(query, onSuccess, onFailure) {
			var url = this.baseURL + '/host/search?query=' + escape(query);
			console.log('GET: ' + url);
			$http.get(url).success(onSuccess).error(onFailure);
		},
		
		createVisit: function(visitInfo, onSuccess, onFailure) {
			var url = this.baseURL + '/visit';
			console.log('POST: ' + url);
			$http.post(url, visitInfo).success(onSuccess).error(onFailure);
		},
		
		uploadPhoto: function(photoData, onSuccess, onFailure) {
			var url = this.baseURL + '/visit/' + VisitService.visitID + '/file/';
			console.log('POST: ' + url);
			var blobBin = atob(photoData.split(',')[1]);
			var array = [];
			for(var i = 0; i < blobBin.length; i++) {
				array.push(blobBin.charCodeAt(i));
			}
			var file = new Blob([new Uint8Array(array)], {type: 'image/png'});
			var fd = new FormData();
			fd.append('file', file, "filename.png");
			$http.post(url, fd).success(onSuccess).error(onFailure);
		},
				
		searchVisits: function(vicNum, onSuccess, onFailure) {
			var url = this.baseURL + '/visit?VICNumber=' + vicNum;
			console.log('GET: ' + url);
			$http.get(url).success(onSuccess).error(onFailure);
		},
		
		// This function expects visitInfo to be an object that has been returned from a call to
		// 'get visit by VIC Number'
		checkOutVisit: function(visitInfo, onSuccess, onFailure) {
			var url = this.baseURL + '/visit/' ;
			var params = { visitID: visitInfo.visitID,
			visitorID: visitInfo.visitorID,
			hostID: visitInfo.hostID,
			visitorType: visitInfo.visitorType,
			startTime: visitInfo.startTime,
			expectedEndTime: visitInfo.expectedEndTime,
			checkOutTime: new Date().toJSON(),
			visitReason: 1,
			workstation: 8 };
			console.log('PUT: ' + url);
			$http.put(url, params).success(onSuccess).error(onFailure);
		}
	};
}]);
