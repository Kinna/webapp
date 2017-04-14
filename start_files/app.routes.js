angular.module('app').config(['$routeProvider', function($routeProvider) {
	$routeProvider
		.when('/', {
			templateUrl: 'app/core/default.html'
		});
}]);