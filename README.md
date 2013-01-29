# SETUP

 * Clone my github
  
```bash
  cd <root path to install the files to.  DO NOT USE YOUR BASE NEWZNAB PATH>
  git clone https://github.com/Miatrix/Miatrix_newznab_performance_pack.git <path to save it to>
  ```  

  * Backup the files you are about to replease incase you want to go back to stock nnplus
  * Copy the files from where you installed to the files in your newznab directory. (so misc/update_scripts/update_releases.php replaces the one in your misc/update_scripts directory)  


# Sample setup using stock directories.
  * base install directory /var/www/newznab
  * my github to be saved at /var/www/newznab/misc/testing/Miatrix

```bash
  cd /var/www/newznab/misc/testing
  git clone https://github.com/Miatrix/Miatrix_newznab_performance_pack.git Miatrix

  # Backup the files in misc/update_scripts
  cd /var/www/newznab/misc/update_scripts
  cp update_releases.php update_releases.stock

  # Backup the files in www/lib/framework
  cd /var/www/newznab/www/lib/framework
  cp db.php db.stock

  # Backup the files in www/lib
  cd /var/www/newznab/www/lib
  cp binaries.php binaries.stock
  cp releases.php releases.stock

  # now lets update the files
  cd /var/www/newznab/misc/testing/Miatrix
  cp misc/update_scripts/*.php  /var/www/newznab/misc/update_scripts/
  cp www/lib/framework/db.php /var/www/newznab/www/lib/framework/db.php
  cp www/lib/*.php /var/www/newznab/www/lib/
  ```

  * In your misc/update_scripts path you should now be able to run update_releases.php alt.binaries.tv and have it only run for that group.
  * In that same path you now have an update_releases_threaded.php that will run the update_releases processes threaded.  Default is 10 threads, but you can change it in the file.
