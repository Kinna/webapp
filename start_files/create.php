<?php
/**
 * Use this file to build the database structure
 */
require_once('../libs/custom/database/database-includer.php');
use Database\Database;
$db = new Database();

$db->deleteTable('Table');
$db->createTable('Table', function($table){
	$table->init();
	$table->string('name');
});

$employee = $db->getTableRow('Table');
$employee->insert(array(
	'name' => 'Abc'
));