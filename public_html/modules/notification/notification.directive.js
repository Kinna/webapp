/**
 * This directive is used to define the parent element where the notifications should be shown.
 */
angular.module('notification').directive('notificationParent', ['$compile', function($compile){
	return{
		restrict: 'A',
		link: function(scope, element, attr){
			element.addClass('notification-parent');
			var notifications = $compile('<div class="notification-container" notifications></div>')(scope);
			element.append(notifications);
		}
	};
}]);

angular.module('notification').directive('notifications', function(){
	return{
		restrict: 'EA',
		templateUrl: 'modules/notification/notification.html',
		controller: ['$scope', 'NotificationService', function($scope, NotificationService){
			$scope.notifications = NotificationService.get();

			$scope.$on('notificationChange', function(event, args){
				$scope.notifications = args;
			});

			$scope.closeNotification = function(id){
				NotificationService.close(id);
			};
		}]
	}
});