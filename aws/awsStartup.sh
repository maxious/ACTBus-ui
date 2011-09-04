#!/bin/bash
#this script should be run from a fresh git checkout from github
#ami base must have yum install lighttpd-fastcgi, git, tomcat6 
#php-cli php-gd tomcat6-webapps tomcat6-admin-webapps svn maven2
#postgres postgres-server php-pg
#http://www.how2forge.org/installing-lighttpd-with-php5-and-mysql-support-on-fedora-12

sh busuiphp.sh
sh busuidb.sh
sh busuiotp.sh


