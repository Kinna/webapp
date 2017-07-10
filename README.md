# Preparing new project

## Directories and files

Create the following directories:

* app
	* controllers
	* models
	* views
* database
* public_html
	* app
		* less
	* js
	* css
	* less

Then move following files from the _start_files_ directory:

- /app/routes.php
- /database/create.php
- /public_html/app/app.module.js
- /public_html/app/app.routes.js
- /public_html/app/index.html
- /.env

## PHPStorm

1. Click _Edit Configurations_ in dropdown in upper right corner
2. Click _Add new configuration_ and select _PHP Built-in Web Server_ 
3. Name the server - eg. _PHP Server_
4. Update the _Document root_ path to the /public_html directory
5. If error _Interpreter is not specified or invalid_ is present at the bottom of the dialog, click _Fix_ and select the installed PHP version from the dropdown.

## XDebug

Toggle the _Start Listening for PHP Debug Connections_ button in upper right corner.

# Building the web app

Node.js must be installed on the computer in order to build the app.

To download or update NPM packages needed to build the app:

	npm install

To download or update all third-party libraries:

	bower install
	
To move needed files from _bower_components_ to the final directories:
	
	grunt bower
	
To create the index view file and update CSS files for development mode:
	
	grunt 
	
To create the index view file and update CSS files for production mode:

	grunt production

# Database
	
The _database_ directory is used to created the database tables needed in the application.
	
# Putting the webapp online

When production files are uploaded to the server, the js files in public_html/app should be removed