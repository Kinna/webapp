angular.module('elements').directive('wlCheckbox', function(){
	return{
		restrict: 'E',
		scope: {
			model: '=wlModel',
			checked: '@wlChecked',
			unchecked: '@wlUnchecked',
			label: '@wlLabel'
		},
		templateUrl: 'modules/elements/checkbox.html',
		controller: ['$scope', function($scope){
			if(_.isUndefined($scope.checked)) $scope['checked'] = 'check-square-o';
			if(_.isUndefined($scope.unchecked)) $scope['unchecked'] = 'square-o';
			if(_.isUndefined($scope.model)) $scope['model'] = false;

			$scope.toggle = function(){
				$scope.model = !$scope.model;
			};
		}]

	};
});