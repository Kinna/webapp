/**
 * This directive can be used on an input to force correct integer value.
 */
angular.module('numbers').directive('msInteger', ['NumbersService', function(NumbersService){
	return{
		restrict: 'A',
		require: 'ngModel',
		link: function(scope, element, attr, controller){

			controller.$parsers.push(function(data){
				var val = NumbersService.stringToInteger(data);
				scope.ngModel = val;
				return val;
			});

			controller.$formatters.push(function(data){
				return NumbersService.integerToString(data);
			});
		}
	}
}]);