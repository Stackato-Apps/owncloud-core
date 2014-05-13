# ownCloud

[ownCloud](http://ownCloud.org) gives you freedom and control over your own data.
A personal cloud which runs on your own server.

### Build Status on [Jenkins CI](https://ci.owncloud.org/)
Git master: [![Build Status](https://ci.owncloud.org/buildStatus/icon?job=ownCloud-Server%28master%29)](https://ci.owncloud.org/job/ownCloud-Server%28master%29/)

### Installation instructions
http://doc.owncloud.org/server/5.0/developer_manual/app/gettingstarted.html

### Contribution Guidelines
http://owncloud.org/dev/contribute/

### Get in touch
* [Forum](http://forum.owncloud.org)
* [Mailing list](https://mail.kde.org/mailman/listinfo/owncloud)
* [IRC channel](https://webchat.freenode.net/?channels=owncloud)
* [Twitter](https://twitter.com/ownClouders)

### Important notice on translations
Please submit translations via Transifex:
https://www.transifex.com/projects/p/owncloud/

For more detailed information about translations:
http://owncloud.org/dev/translation/ucnh 

### Modified for Stackato:
ownCloud will be pushed with a filesystem and mysql service, which will
automatically be bound in.

To deploy 

    stackato push -n

The default admin login credentials are

    Username: stackato
    Password: changeme

##### Stackato and automatic configuration caveat
After initial deployment, each subsequent push will trigger the automatic configuration process to run again and cause a "Username is already being used" error. As a workaround, open the app (to trigger the automatic configuration process to generate the config file) after the initial push and copy the config file to the data directory (persisted on the filesystem).

    stackato run cp config/config.php data/config.php

Then after each subsequent push, run the following before opening the app

    stackato run cp data/config.php config/config.php

Note that opening the app before copying the config file back to the config directory will result in automatic logon failing. An "Automatic logon rejected!" warning will be display, but can be ignored. Proceed to login with appropriate credentials.
