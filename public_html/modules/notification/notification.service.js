/**
 * This service can be used anywhere in the application to show notifications. Only one notification can be shown at a
 * time, so additional notifications will be queued and shown in order when prior notifications are closed.
 */
angular.module('notification').factory('NotificationService', ['$rootScope', '$timeout', function($rootScope, $timeout){
	var service = {};

	var notificationQueue = [];
	var notifications = [];
	var uniqueId = 1;

	service.get = function(){
		return notifications;
	};

	service.error = function(text, timeout, group){
		addNotification('danger', text, timeout, group);
	};

	service.warning = function(text, timeout, group){
		addNotification('warning', text, timeout, group);
	};

	service.success = function(text, timeout, group){
		addNotification('success', text, timeout, group);
	};



	service.close = function(id){
		_.remove(notifications, {id: id});
		$rootScope.$broadcast('notificationChange', notifications);
	};

	service.closeGroup = function(group){
		_.remove(notifications, {group: group});
		$rootScope.$broadcast('notificationChange', notifications);
	};

	function addNotification(type, text, timeout, group){
		if(_.isUndefined(group)) group = null;
		var id = getId();
		notifications.push({
			id: id,
			type: type,
			text: text,
			group: group
		});
		if(timeout){
			$timeout(function(){
				service.close(id);
			}, timeout * 1000);
		}
		$rootScope.$broadcast('notificationChange', notifications);
	}

	function getId(){
		uniqueId++;
		if(uniqueId > 1000) uniqueId = 1;
		return uniqueId;
	}

	function addNotificationOld(type, text, timeout){
		if(_.isUndefined(timeout)) timeout = false;
		var toast = {
			templateUrl: 'modules/notification/notification.html',
			hideDelay: false,
			position: 'top right',
			controller: ['$scope', 'NotificationService', function ($scope, NotificationService) {
				$scope.type = type;
				$scope.text = text;

				$scope.close = function(){
					NotificationService.close();
				}
			}],
			timeout: timeout
		};
		if(parent != null) toast['parent'] = parent;
		
		notificationQueue.push(toast);
		// Only open toast now, if this is the only one
		if(notificationQueue.length == 1){
			openNextToast();
		}
	}

	function openNextToast(){
		if(notificationQueue.length > 0){
			$mdToast.show(notificationQueue[0]);
			// Close notification if timeout is specified
			if(notificationQueue[0].timeout){
				$timeout(function(){
					service.close();
				}, notificationQueue[0].timeout * 1000);
			}
		}
	}

	return service;
}]);