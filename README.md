Alpha Phi Omega - Epsilon Chapter's Website
===========

Epsilon's chapter management website

###Info for connecting to the server
The server is hosted on an Amazon Linux EC2 Instance through the apo.epsilon.webmaster account.
In the Important Files folder of the apo.epsilon.webmaster Google Drive, you shoudl find all the files you should need to connect through SSH to the server.
The public IP address of the server is: 54.148.24.65
The config file isn't necessary, but it makes things a hell of a lot easier.  It goes in your .ssh folder (which is hidden by default).
With the config file, you can connect by typing `ssh apo` instead of `ssh -i ./Desktop/APO/admin.pem 54.148.24.65` 

Now, with all that said you should hopefully not need to connect to the server often, if at all.  I suggest connecting on a monthly basis or so and running `sudo yum update` just to make sure things are kept up to date, since that's the main reason we left Truman's servers, that they haven't updated in years.

**Do not mess with changing the permissions unless you know what you are doing, you will break something.**
*Google is your savior, and if you break something, you will be using it for hours.*

###Info for updating the site
The site is set up so that whenever a push is made to the APO-Epsilon/apo-website github repository, that it should automatically pull the changes to the Amazon server.  This is done because there is a file in the root of the server called `gitpull.php` which is polled by a webhook through the repository settings.
The code for that simple php file is: `<?php echo shell_exec("/usr/bin/git pull 2>&1"); ?>` and ther permissions are _-rw-rwSr--_.  Make sure that all the folders have permission to be changed/created by the apache user, or else it won't do anything if you have a new folder.

###Info about the github repository
Issues are kept at the [APO-Epsilon/apo-website/issues](https://github.com/APO-Epsilon/apo-website/issues).  Use it to keep track of progress, assign committee members to certain tasks, close issues when finished, etc. 
The credentials.csv file contains the needed credentials for connecting and making changes to the repository from the command line.  If you use the desktop app instead, you will probably have an easier time.
Since it is github, anyone can make changes and submit a pull request for you to merge the changes.  So technically there is no need to grant others permission to make their own changes.  But if you have an active committee you can add their github account to the team called [Webmaster Committee](https://github.com/orgs/APO-Epsilon/teams/webmaster-committee). 
**Only the official executive webmaster(s) should be on the team called [Owners](https://github.com/orgs/APO-Epsilon/teams/owners).**
