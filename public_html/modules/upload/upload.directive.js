/**
 * This directive is used to upload files to the server.
 */
angular.module('upload').directive('wUpload', ['$http', function($http){
	return{
		restrict: 'E',
		scope: {
			destination: '@wDestination',
			filename: '@wFilename',
			startUpload: '=wStartUpload'
		},
		templateUrl: 'modules/upload/upload.html',
		link: function(scope, element, attr){


			scope.$watch('startUpload', function(start){
				if(start){
					if(element.find('input')[0].files.length < 1){
						console.error('No file selected');
						return;
					}
					var file = element.find('input')[0].files[0];
					console.log(file);

					var formData = new FormData();
					formData.append('file', file);
					formData.append('destination', 'some/path');

					/*$http.post('api/upload', {test: 'k1', test2: 'k2'}).then(function(response){
						console.log('Upload success');
						console.log(response);
					}, function(response){
						console.error('Upload error');
						console.error(response);
					});*/

					$http.post("api/upload", formData, {
						headers: {'Content-Type': undefined},
						transformRequest: angular.identity
					}).then(function(response){
						console.log('Upload success');
						console.log(response);
					}, function(response){
						console.error('Upload error');
						console.error(response);
					});

				}
			});
		}
	};
}]);