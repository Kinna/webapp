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