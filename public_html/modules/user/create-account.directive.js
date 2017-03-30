angular.module('user').directive('wCreateAccountForm', function(){
	return{
		restrict: 'E',
		scope: {
			title: '@wTitle'
		},
		templateUrl: 'modules/user/create-account.html',
		controller: ['$scope', 'ApiService', 'NotificationService', function($scope, ApiService, NotificationService){
			$scope.user = {
				name: 'Kinna',
				email: 'kinna.mk@gmail.com',
				password: '123',
				passwordRepeated: '123'
			};

			$scope.createAccount = function(){
				if($scope.user.password != $scope.user.passwordRepeated){
					NotificationService.addError('De to passwords er ikke ens.', 10);
					return;
				}
				ApiService.post('users', $scope.user, function(error, data){
					if(error) NotificationService.addError('Der skete en server fejl ved oprettelse af kontoen.', 10);
					else NotificationService.addSuccess('Din konto er oprettet. Du kan nu logge ind.', 10);
				});
			};
		}]
	};
});