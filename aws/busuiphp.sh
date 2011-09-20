cp /root/aws.php /tmp/
chmod  777 /var/cache/lighttpd/compress/

mkdir /var/www/lib/staticmaplite/cache 
chcon -h system_u:object_r:httpd_sys_content_t /var/www
chcon -R -h root:object_r:httpd_sys_content_t /var/www/*

chcon -R -t httpd_sys_content_rw_t /var/www/lib/staticmaplite/cache
chmod -R 777 /var/www/lib/staticmaplite/cache 

chcon -R -t httpd_sys_content_rw_t /var/www/labs/tiles
chmod -R 777 /var/www/labs/tiles

mkdir /var/www/lib/openid-php/oid_store
chcon -R -t httpd_sys_content_rw_t /var/www/lib/openid-php/oid_store
chmod -R 777 /var/www/lib/openid-php/oid_store

wget http://s3-ap-southeast-1.amazonaws.com/busresources/cbrfeed.zip \
-O /var/www/cbrfeed.zip
