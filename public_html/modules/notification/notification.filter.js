angular.module('notification').filter('group', [function(){
	return function(input, group){
		return _.filter(input, {group: group});
	}
}]);