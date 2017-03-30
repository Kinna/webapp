angular.module('user').directive('wAuthTwo', function(){
	return{
		restrict: 'E',
		scope: {
			title: '@wTitle'
		},
		templateUrl: 'modules/user/auth-two.html',
		controller: ['$scope', function($scope){
			$scope.reset = false;
			$scope.resetPassword = function(){
				$scope.reset = true;
			};

			$scope.back = function(){
				$scope.reset = false;
			};
		}]
	};
});