/**
 * This directive will make sure the modelValue property is in number format if the input value is a correct decimal
 * number. It will also make sure that numbers are displayed in correct danish format.
 */
angular.module('numbers').directive('msDecimal', ['NumbersService', function(NumbersService){
	return{
		restrict: 'A',
		require: 'ngModel',
		scope: {
			ngModel: '='
		},
		link: function(scope, element, attr, controller){

			controller.$parsers.push(function(data){
				var val = NumbersService.stringToDecimal(data);
				scope.ngModel = val;
				return val;
			});

			controller.$formatters.push(function(data){
				return NumbersService.decimalToString(data);
			});
		}
	}
}]);