angular.module('user').directive('wLoginForm', function(){
	return{
		restrict: 'E',
		scope: {
			title: '@wTitle'
		},
		templateUrl: 'modules/user/login.html'
	};
});