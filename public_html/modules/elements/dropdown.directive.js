/**
 * @w-options: Array of {id, name} objects
 * @w-popup: Whether the dropdown should popup os full screen on small devices
 */
angular.module('elements').directive('wDropdown', [function(){
	return {
		restrict: 'E',
		scope: {
			options: '=wOptions',
			popup: '@wPopup'
		},
		templateUrl: 'modules/elements/dropdown.html',
		link: function link(scope, element){

		}
	}
}]);