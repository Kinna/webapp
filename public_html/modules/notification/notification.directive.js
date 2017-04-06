/**
 * This directive is used to define a parent element where the notifications should be shown. If it should be possible
 * to show notifications in multiple elements, then assign the ms-notification-parent a value.
 *
 */
angular.module('notification').directive('msNotificationParent', ['$compile', function($compile){
	return{
		restrict: 'A',
		link: function(scope, element, attr){
			console.log(attr);
			scope.group = attr['msNotificationParent'] != '' ? attr['msNotificationParent'] : null;
			element.addClass('notification-parent');
			var notifications = $compile('<div class="notification-container" ms-notifications></div>')(scope);
			element.append(notifications);
		}
	};
}]);

angular.module('notification').directive('msNotifications', function(){
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