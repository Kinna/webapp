angular.module('dialog').factory('DialogService', ['$uibModal', '$rootScope', function($uibModal, $rootScope){
	var service = {};

	var modal = null;

	/**
	 * Opens a dialog.
	 * @param title The title of the dialog
	 * @param acceptText The text on the accept button
	 * @param template The template used in the dialog body. Header and footer are standard.
	 * @param controller The controller used by the template. The controller must call $scope.dialogClose in order to
	 * close the dialog with acceptance.
	 * @param onAccept Callback function called if user accepted.
	 */
	service.open = function(title, acceptText, template, controller, onAccept){
		var scope = $rootScope.$new();
		scope.title = title;
		scope.acceptText = acceptText;
		scope.template = template;
		scope.dialogClose = function(){
			modal.close();
			onAccept();
		};
		scope.dialogDismiss = function(){
			modal.close();
		};

		modal = $uibModal.open({
			templateUrl: 'modules/dialog/dialog.html',
			controller: controller,
			scope: scope,
			backdrop: 'static'
		});
	};

	return service;
}]);