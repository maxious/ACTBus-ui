createdb transitdata
createlang -d transitdata plpgsql
psql -d transitdata -f /var/www/lib/postgis.sql
# curl https://github.com/maxious/ACTBus-ui/raw/master/transitdata.cbrfeed.sql.gz -o transitdata.cbrfeed.sql.gz 
#made with pg_dump transitdata | gzip -c >  transitdata.cbrfeed.sql.gz
gunzip /var/www/transitdata.cbrfeed.sql.gz
psql -d transitdata -f /var/www/transitdata.cbrfeed.sql
#createuser transitdata -SDRP
#password transitdata
#psql -d transitdata -c "GRANT SELECT ON TABLE agency,calendar,calendar_dates,routes,stop_times,stops,trips TO transitdata;"
#psql -d transitdata -c "GRANT SELECT,INSERT ON TABLE myway_observations,myway_timingdeltas,myway_routes,myway_stops TO transitdata;"
#psql -d transitdata -c	"GRANT SELECT,INSERT,UPDATE ON TABLE servicealerts_alerts,servicealerts_informed TO transitdata;"
#psql -d transitdata -c	"GRANT USAGE,SELECT ON SEQUENCE servicealerts_alerts_id_seq TO transitdata;"
##psql -d transitdata -c "GRANT SELECT ON ALL TABLES IN SCHEMA public TO transitdata;"
## INSERT INTO geometry_columns(f_table_catalog, f_table_schema, f_table_name, f_geometry_column, coord_dimension, srid, "type")
##SELECT '', 'public', 'shapes', 'shape_pt', ST_CoordDim(shape_pt), ST_SRID(shape_pt), GeometryType(shape_pt)
##FROM shapes LIMIT 1;
php /var/www/updatedb.php
