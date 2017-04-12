/**
 * This directive can be used on an input to force correct decimal mark.
 */
angular.module('numbers').directive('msInteger', ['NumbersService', function(NumbersService){
	return{
		restrict: 'A',
		require: 'ngModel',
		link: function(scope, element, attr, controller){
			element.on('keydown', function(event){
				if(event.key == '.'){
					event.preventDefault();
					element.val(element.val() + ',');
				}
			});

			controller.$parsers.push(function(data) {
				return NumbersService.stringToDecimal(data);
				//convert data from view format to model format
				//return dateFilter(data, scope.format); //converted
			});

			controller.$formatters.push(function(data) {
				return NumbersService.decimalToString(data);
				//convert data from model format to view format
				//return dateFilter(data, scope.format); //converted
			});
		}
	}
}]);