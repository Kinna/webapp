
angular.module('notification').directive('msAlertParent', [function(){
	return{
		restrict: 'E',
		scope: {
			group: '@msGroup'
		},
		templateUrl: 'modules/notification/alerts.html',
		controller: ['$scope', 'NotificationService', function($scope, NotificationService){
			$scope.notifications = NotificationService.get();

			$scope.$on('notificationChange', function(event, args){
				$scope.notifications = args;
			});

			$scope.closeNotification = function(id){
				NotificationService.close(id);
			};
		}]
	};
}]);
