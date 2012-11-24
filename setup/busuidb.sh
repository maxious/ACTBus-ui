createdb transitdata
createlang -d transitdata plpgsql
psql -d transitdata -f /var/www/lib/postgis.sql
# curl https://github.com/maxious/ACTBus-ui/raw/master/transitdata.cbrfeed.sql.gz -o transitdata.cbrfeed.sql.gz 
#made with pg_dump transitdata | gzip -c >  transitdata.cbrfeed.sql.gz
gunzip /var/www/transitdata.cbrfeed.sql.gz
psql -d transitdata -f /var/www/transitdata.cbrfeed.sql
#createuser transitdata -SDRP
#password transitdata
#psql -d transitdata -c "GRANT SELECT ON TABLE agency,calendar,calendar_dates,routes,shapes,stop_times,stops,trips,x_end_times TO transitdata;"
#psql -d transitdata -c "GRANT SELECT,INSERT ON TABLE myway_observations,myway_timingdeltas,myway_routes,myway_stops TO transitdata;"
#psql -d transitdata -c	"GRANT SELECT,INSERT,UPDATE ON TABLE servicealerts_alerts,servicealerts_informed TO transitdata;"
#psql -d transitdata -c	"GRANT USAGE,SELECT ON SEQUENCE servicealerts_alerts_id_seq TO transitdata;"
##psql -d transitdata -c "GRANT SELECT ON ALL TABLES IN SCHEMA public TO transitdata;"
#psql -d transitdata -c "CREATE OR REPLACE FUNCTION round_time(TIMESTAMP WITH TIME ZONE) RETURNS TIMESTAMP WITH TIME ZONE AS 
#  $$ SELECT date_trunc('hour', $1) + INTERVAL '15 min' * ROUND(date_part('minute', $1) / 15.0) $$ LANGUAGE SQL;"
## INSERT INTO geometry_columns(f_table_catalog, f_table_schema, f_table_name, f_geometry_column, coord_dimension, srid, "type")
##SELECT '', 'public', 'shapes', 'shape_pt', ST_CoordDim(shape_pt), ST_SRID(shape_pt), GeometryType(shape_pt)
##FROM shapes LIMIT 1;
php /var/www/updatedb.php
