/**
 * @w-options: Array of {id, name} objects
 */
angular.module('elements').directive('wAutocomplete', [function(){
	return {
		restrict: 'E',
		scope: {
			options: '=wOptions',
			model: '=wModel'
		},
		templateUrl: 'modules/elements/autocomplete.html',
		controller: ['$scope', function($scope){
			$scope.open = false;

			$scope.selectOption = function(option){
				console.log('Option click');
				$scope.model = option.name;
				$scope.open = false;
			};

			$scope.openDropdown = function(){
				$scope.open = true;
			};

			$scope.focusOut = function(){
				console.log('Blur')
				$scope.open = false;
			}
		}],
		link: function link(scope, element){
			scope.select = function(option){

			}
		}
	}
}]);

angular.module('elements').filter('wContains', function(){
	return function(options, needle){
		if(_.isUndefined(needle) || needle == '') return options;
		var filteredOptions = [];
		options.forEach(function(option){
			if(option.name.includes(needle)) filteredOptions.push(option);
		});
		return filteredOptions;

		/*return _.filter(options, function(option){
			return _.includes(option.name, needle);
		});*/
	};
});