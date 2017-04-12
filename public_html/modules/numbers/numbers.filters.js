angular.module('numbers').filter('decimalToString', ['NumbersService', function(NumbersService){
	return function(input){
		return NumbersService.decimalToString(input);
	};
}]);