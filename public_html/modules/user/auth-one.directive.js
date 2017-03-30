angular.module('user').directive('wAuthOne', function(){
	return{
		restrict: 'E',
		scope: {
			title: '@wTitle'
		},
		templateUrl: 'modules/user/auth-one.html',
		controller: ['$scope', function($scope){
			$scope.view = 'login';

			$scope.isView = function(view){
				return view == $scope.view;
			};

			$scope.back = function(){
				$scope.view = 'login';
			};

			$scope.createAccount = function(){
				$scope.view = 'account';
			};

			$scope.resetPassword = function(){
				$scope.view = 'reset';
			};
		}]
	};
});