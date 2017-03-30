angular.module('user').directive('wResetPasswordForm', function(){
	return{
		restrict: 'E',
		scope: {
			title: '@wTitle'
		},
		templateUrl: 'modules/user/reset-password.html'
	};
});