/**
 * This service is a wrapper around the HTTP service. It will return error and data in callback functions and print
 * errors to the console.
 */
angular.module('api').factory('ApiService', ['$http', function($http){
	var service = {};

	// The callback onResponse has two arguments: error and data
	service.get = function(url, onResponse){
		$http.get(url).then(function(response){
			onResponse(null, response.data);
		}, function(response){
			console.error(response.data);
			onResponse(response.data, null);
		});
	};

	service.post = function(url, data, onResponse){
		$http.post(url, angular.toJson(data)).then(function(response){
			onResponse(null, response.data);
		}, function(response){
			console.error(response.data);
			onResponse(response.data, null);
		});
	};

	// Use to get raw file
	service.file = function(url, onResponse){
		$http.get(url).then(function(response){
			console.log(response);
			onResponse(null, angular.fromJson(response.data));
		}, function(response){
			console.error('POST ' + url + ': HTTP error');
			onResponse('HTTP error', null);
		});
	};

	return service;
}]);