#wget http://s3-ap-southeast-1.amazonaws.com/busresources/opentripplanner-webapp.war 
cp ~/workspace/opentripplanner/maven.1277125291275/opentripplanner-webapp/target/opentripplanner-webapp.war ./
#wget http://s3-ap-southeast-1.amazonaws.com/busresources/opentripplanner-api-webapp.war 
cp ~/workspace/opentripplanner/maven.1277125291275/opentripplanner-api-webapp/target/opentripplanner-api-webapp.war ./

dotcloud push actbus.otp ./
