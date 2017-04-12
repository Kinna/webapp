angular.module('numbers').factory('NumbersService', [function(){
	var service = {};

	/*
	If the format is correct decimal format, the value will be converted from string to float (both punctuation and
	comma are allowed as decimal separators). If the format is incorrect, the input will be returned as output in
	string format.
	 */
	service.stringToDecimal = function(data){
		var newData = data;
		if(!_.isString(newData)) newData = angular.toJson(newData);
		newData = newData.replace(/,/g, '.');
		if(newData.match(/^(-?\d*\.?\d*)$/)) return parseFloat(newData);
		else return data;
	};

	/*
	Will convert the number to correct danish style in string format, with comma as separator.
	 */
	service.decimalToString = function(data){
		var newData = _.toString(data);
		return newData.replace(/\./g, ',');
	};

	return service;
}]);