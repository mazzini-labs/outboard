
# OutBoard
###### By Richard F. Feuerriegel


##### Current version: 2.2.5                            Release Date: 2009-05-07


##### Official Web site
-----------------
	http://outboard.sourceforge.net/


## Brief Overview
--------------
This program emulates an office "in/out" board using PHP and MySQL. The
board is displayed in a browser window that updates on a regular basis.
There is an administrative area, and a timeclock reports section.


## Major Features
--------------
Below are the major, new features for each version. More detailed
information is in the CHANGES file.

	New for version 2.2.4 (2007-02-16):
	-----------------------------------
	+ Customizable session cookie timeout

	New for version 2.2.3 (2006-12-06):
	-----------------------------------
	+ Zebra striping of user rows for alternating colors

	New for version 2.2.0 (2005-03-04):
	---------------------------------
	+ Configurable setting to disallow a user to change someone
	  else's dot and remarks.

	New for version 2.1.0 (2005-02-19):
	---------------------------------
	+ The board now scrolls to the correct editing position
	+ An optional link can be created via the config file to 
	  open a small window for arbitrary uses, such as employee 
	  schedules.

	New for version 2.0.0 (2005-02-18):
	---------------------------------
	+ Timeclock reports for users and administrators
	+ Automatic moving of dots to "out" if users are idle
	+ Major source code refactoring on many files
	+ New classes and more object-oriented programming
	+ OB header reprints after set number of rows
	+ Passwords are now encrypted in the database.

	New for version 1.4.0 (2002-04-15):
	---------------------------------
	+ Basic Authentication is used automatically if available
	+ Multiple users can have Administration privileges
	+ Updated character widths file
	+ Minor bug fixes

	New for version 1.3.0 (2001-06-12):
	---------------------------------
	+ Automatic installation of necessary tables
	+ Integrated user administration interface
	+ Integrated authentication system (.htaccess optional)
	+ Updated character widths file
	+ Minor bug fixes 

	New for version 1.2.0 (2000-11-13):
	---------------------------------
	+ Simple interface that emulates a real "in/out" board
	+ Accidental write protection via a "change" button
	+ Ten "return by" times (8:00AM to 5:00PM)
	+ Separate In and Out columns
	+ Column for Remarks, with automatic "anti-wrapping" 
	+ Automatic page refresh with daytime and nighttime rates
	+ Javascript 1.2 compliant (and required)
	+ Netscape 4 and Internet Explorer 5 tested
	+ Hovering over a dot shows when it was last changed
	+ Automatic logging of changes made to the board

## SOFTWARE Requirements
---------------------
	+ JavaScript 1.2+ compliant web browser (Netscape or I.E.)
	+ Apache 1.3.X or 2.X (http://www.apache.org)
	+ PHP 4.2+ Apache module (http://www.php.net)
	+ MySQL 3.23+ (http://www.mysql.com)
	+ Basic understanding of how to use the above software. :-)



-------------------------------
# -- Installation Instructions --
-------------------------------

-----------------------------------------------------------------------
#### IMPORTANT: If you already have the OutBoard installed, please follow the UPGRADE instructions instead of these. 

------> Backup your config.php file! <------


### STEP 1.  Unpack the outboard-X.X.tar.gz file, and change the directory name, (or make a symbolic link) to "outboard" off your web root:
```
  cd WEB_DOCUMENT_ROOT_DIRECTORY      (example: cd /opt/apache/htdocs)
  mv outboard-X.X.tar.gz  .
  tar -xvzf outboard-X.X.tar.gz       (X.X will be the version number)
```

OPTIONAL:
```
  mv outboard-X.X outboard
```

The URL to it should be something like this:

	http://www.someplace.com/outboard-X.X

If you changed the name of the directory to outboard, the URL will be:

	http://www.someplace.com/outboard

You will need to make sure that the user which the web server runs as has access to read the files in the outboard directory. In many cases, the server runs as "nobody", so you whould perform the following commands:
```
	chown -R nobody outboard-X.X
	chmod -R 755 outboard-X.X
```

-----------------------------------------------------------------------
### STEP 2. Edit the config/config.php file to match your configuration. 

You will need to at least check/set the database server name, database name, username, and the password for the database user. The OutBoard database user must have full permission to that database. (Insert, Delete, Select, etc.)


-----------------------------------------------------------------------
### STEP 3. Create the MySQL Database 

In the config.php file, which you should have edited in STEP 2, there is a variable that controls to which database the OutBoard will talk.
By default, this is set to "outboard". You can keep this, in which case you will need to make a new database by that name (or you can choose an existing database.) It is recommended that you use a NEW database, and name it "outboard".

To make a new database in which to store the tables, run the following command:
```
	mysqladmin -u USERNAME --password=PASSWORD create outboard
```
Replace USERNAME and PASSWORD with the apropriate information for your MySQL installation. Please refer to your MySQL documentation for further information about how to create a database, and set permissions on that database. 

If you have an existing database that you want to use (this is not recommended), make sure its information is in the config.php file.
   

-----------------------------------------------------------------------
### STEP 4. Initiate the automatic table installation

At this point, the OutBoard will be ready to install the tables that it needs in the chosen database. You just need to point your browser to the board's URL:
```
	http://www.somewhere.com/outboard   (or outboard-X.X [Step 0])
```
A new window will be created (if you have JavaScript enabled), and you will be prompted to check the configuration. Enter a new admin username, name, and password, and then click the Install button.

This step will FAIL if the database information at the top of the config.php file is not correct. Errors at this point are most likely with MySQL permissions. Check your MySQL documentation first if you have problems at this stage. Also, read about the MySQL reload command.

As an extra security measure, RENAME the include/install.php script. 
It should not be able to run once you change the installtables configuration setting to false, but it's better to be safe than sorry.

-----------------------------------------------------------------------
### STEP 4a) OPTIONAL -- Install the Basic Authentication files:

By default the OutBoard will use its own internal authentication system. Optionally, you can have it use the Basic Authentication information provided by an .htaccess file. 

You can create an .htaccess file (in the Outboard directory) with the following lines:
```
AuthUserFile /path_to_apache_password_file/passwd
AuthName "Outboard"
AuthType Basic
require valid-user
```
You can also use "require user username1 username2" as the last line. 
If you already have a usable Apache password file, point to it on the AuthUserFile line. Refer to your Apache documentation on how to create a password file.


-----------------------------------------------------------------------
### STEP 5. Access the outboard with your web browser. :-)  See STEP 1.

You will first need to login as the admin user using your chosen password, and create new users. 

##### Notes
-----

* READONLY users can login to the board, but their name will not show up in the list, nor will they be able to change anything.

* Internal passwords (in the DB) are not used if basic authentication is in use.

* You might have to turn off magic quotes in the php.ini file if you get "backslash multiplication" problems. 


##### History
-------
| Version | Date |
|---|---|
| Version 2.2.5 |                                 Release Date: 2009-05-07 |
| Version 2.2.4 |                                 Release Date: 2007-02-16 |
| Version 2.2.3 |                                 Release Date: 2006-12-06 |
| Version 2.2.2 |                                 Release Date: 2005-10-25 |
| Version 2.2.1 |                                 Release Date: 2005-03-06 |
| Version 2.2.0 |                                 Release Date: 2005-03-04 |
| Version 2.1.0 |                                 Release Date: 2005-02-19 |
| Version 2.0.0 |                                 Release Date: 2005-02-18 |
| Version 1.4.0 |                                 Release Date: 2002-04-15 |
| Version 1.3.0 |                                 Release Date: 2001-06-12 |
| First released version: 1.2 |                   Release Date: 2000-11-13 |

