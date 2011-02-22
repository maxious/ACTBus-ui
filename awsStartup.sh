#!/bin/bash
#this script should be run from a fresh git checkout from http://maxious.lambdacomplex.org
#ami base must have LAMP, tomcat etc.
cp -rfv busui/* /var/www
chcon 
wget http://s3.amazonaws.com/busResources/cbrfeed.zip -o /var/www/cbrfeed.zip
screen -d /var/www/view.sh
wget -o /tmp/Graph.obj
wget -o /var/lib/tomcat/webapps/otp.jar
cp otp/config.xml /var/lib/tomcat
cp otp/config.js /var/lib/tomcat
/etc/init.d/tomcat5 start