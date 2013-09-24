QCN Explorer
-----------------

Welcome to the QCN Explorer, a graphical modular simulator of the QCN network.


Installation
-----------------

Installation of this interface should be pretty straight forward. 

1. Copy directory into your web server's root document directory (ie. /var/www/html)
2. Make a mysql user and database for the project
3. Populate the user database using emboinc.sql ( mysql -u [username] -p[password] [database_name] < emboinc.sql ... note there is no space between -p and [password])
4. Make sure the webserver's user (apache, www-data or nobody) has write access to files/JSON, files/input/* and files/output/*
5. Set the $mysql_user, $mysql_pass, $mysql_host, $mysql_db, and $siteURL in the config.inc
6. Hope for the best.

Note: As of 4/5/2013 the simulator executable is just a place holder. Once a simplified version of EmBOINC-QCN is available it should be incorporated by changing the $SIM_EXE constant in the config.inc file.

If you get permission denied errors and the webserver's user has write access to the folders mentioned above check if you have SElinux installed. You can switch it to permissive mode to test if that's the problem ( echo 0 > /selinux/enforce )