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

	/*
	 If the format is correct integer format, the value will be converted from string to integer. If the format is
	 incorrect, the input will be returned as output in string format.
	 */
	service.stringToInteger = function(data){
		var newData = data;
		if(!_.isString(newData)) newData = angular.toJson(newData);
		newData = newData.replace(/,/g, '.');
		if(newData.match(/^(-?\d*)$/)) return parseInt(newData);
		else return data;
	};

	/*
	 Will convert the number to string format.
	 */
	service.integerToString = function(data){
		data = _.toString(data);
		return data;//.replace(/^[0]*/g, '');
	};

	return service;
}]);