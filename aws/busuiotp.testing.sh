wget http://s3-ap-southeast-1.amazonaws.com/busresources/testing/Graph.obj \
-O /tmp/Graph.obj
/etc/init.d/tomcat6 stop
rm -rfv /usr/share/tomcat6/webapps/opentripplanner*
wget http://s3-ap-southeast-1.amazonaws.com/busresources/testing/opentripplanner-webapp.war \
-O /usr/share/tomcat6/webapps/opentripplanner-webapp.war
wget http://s3-ap-southeast-1.amazonaws.com/busresources/testing/opentripplanner-api-webapp.war \
-O /usr/share/tomcat6/webapps/opentripplanner-api-webapp.war
/etc/init.d/tomcat6 restart
