--
-- PostgreSQL database dump
--

-- Dumped from database version 9.0.4
-- Dumped by pg_dump version 9.0.4
-- Started on 2011-10-07 22:30:10

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 2772 (class 1262 OID 18349)
-- Name: transitdata; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE transitdata WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'English_Australia.1252' LC_CTYPE = 'English_Australia.1252';


ALTER DATABASE transitdata OWNER TO postgres;

\connect transitdata

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 1170 (class 2612 OID 11574)
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: postgres
--

CREATE OR REPLACE PROCEDURAL LANGUAGE plpgsql;


ALTER PROCEDURAL LANGUAGE plpgsql OWNER TO postgres;

SET search_path = public, pg_catalog;

--
-- TOC entry 1088 (class 0 OID 0)
-- Name: box2d; Type: SHELL TYPE; Schema: public; Owner: postgres
--

CREATE TYPE box2d;


--
-- TOC entry 15 (class 1255 OID 18351)
-- Dependencies: 6 1088
-- Name: box2d_in(cstring); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION box2d_in(cstring) RETURNS box2d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX2DFLOAT4_in';


ALTER FUNCTION public.box2d_in(cstring) OWNER TO postgres;

--
-- TOC entry 19 (class 1255 OID 18352)
-- Dependencies: 6 1088
-- Name: box2d_out(box2d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION box2d_out(box2d) RETURNS cstring
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX2DFLOAT4_out';


ALTER FUNCTION public.box2d_out(box2d) OWNER TO postgres;

--
-- TOC entry 1087 (class 1247 OID 18350)
-- Dependencies: 15 6 19
-- Name: box2d; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE box2d (
    INTERNALLENGTH = 16,
    INPUT = box2d_in,
    OUTPUT = box2d_out,
    ALIGNMENT = int4,
    STORAGE = plain
);


ALTER TYPE public.box2d OWNER TO postgres;

--
-- TOC entry 1091 (class 0 OID 0)
-- Name: box3d; Type: SHELL TYPE; Schema: public; Owner: postgres
--

CREATE TYPE box3d;


--
-- TOC entry 20 (class 1255 OID 18355)
-- Dependencies: 6 1091
-- Name: box3d_in(cstring); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION box3d_in(cstring) RETURNS box3d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_in';


ALTER FUNCTION public.box3d_in(cstring) OWNER TO postgres;

--
-- TOC entry 21 (class 1255 OID 18356)
-- Dependencies: 6 1091
-- Name: box3d_out(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION box3d_out(box3d) RETURNS cstring
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_out';


ALTER FUNCTION public.box3d_out(box3d) OWNER TO postgres;

--
-- TOC entry 1090 (class 1247 OID 18354)
-- Dependencies: 21 6 20
-- Name: box3d; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE box3d (
    INTERNALLENGTH = 48,
    INPUT = box3d_in,
    OUTPUT = box3d_out,
    ALIGNMENT = double,
    STORAGE = plain
);


ALTER TYPE public.box3d OWNER TO postgres;

--
-- TOC entry 1094 (class 0 OID 0)
-- Name: box3d_extent; Type: SHELL TYPE; Schema: public; Owner: postgres
--

CREATE TYPE box3d_extent;


--
-- TOC entry 22 (class 1255 OID 18359)
-- Dependencies: 6 1094
-- Name: box3d_extent_in(cstring); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION box3d_extent_in(cstring) RETURNS box3d_extent
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_in';


ALTER FUNCTION public.box3d_extent_in(cstring) OWNER TO postgres;

--
-- TOC entry 23 (class 1255 OID 18360)
-- Dependencies: 6 1094
-- Name: box3d_extent_out(box3d_extent); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION box3d_extent_out(box3d_extent) RETURNS cstring
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_extent_out';


ALTER FUNCTION public.box3d_extent_out(box3d_extent) OWNER TO postgres;

--
-- TOC entry 1093 (class 1247 OID 18358)
-- Dependencies: 6 22 23
-- Name: box3d_extent; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE box3d_extent (
    INTERNALLENGTH = 48,
    INPUT = box3d_extent_in,
    OUTPUT = box3d_extent_out,
    ALIGNMENT = double,
    STORAGE = plain
);


ALTER TYPE public.box3d_extent OWNER TO postgres;

--
-- TOC entry 1097 (class 0 OID 0)
-- Name: chip; Type: SHELL TYPE; Schema: public; Owner: postgres
--

CREATE TYPE chip;


--
-- TOC entry 24 (class 1255 OID 18363)
-- Dependencies: 6 1097
-- Name: chip_in(cstring); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION chip_in(cstring) RETURNS chip
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_in';


ALTER FUNCTION public.chip_in(cstring) OWNER TO postgres;

--
-- TOC entry 25 (class 1255 OID 18364)
-- Dependencies: 6 1097
-- Name: chip_out(chip); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION chip_out(chip) RETURNS cstring
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_out';


ALTER FUNCTION public.chip_out(chip) OWNER TO postgres;

--
-- TOC entry 1096 (class 1247 OID 18362)
-- Dependencies: 6 25 24
-- Name: chip; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE chip (
    INTERNALLENGTH = variable,
    INPUT = chip_in,
    OUTPUT = chip_out,
    ALIGNMENT = double,
    STORAGE = extended
);


ALTER TYPE public.chip OWNER TO postgres;

--
-- TOC entry 1100 (class 0 OID 0)
-- Name: geography; Type: SHELL TYPE; Schema: public; Owner: postgres
--

CREATE TYPE geography;


--
-- TOC entry 26 (class 1255 OID 18367)
-- Dependencies: 6
-- Name: geography_analyze(internal); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_analyze(internal) RETURNS boolean
    LANGUAGE c STRICT
    AS '$libdir/postgis-1.5', 'geography_analyze';


ALTER FUNCTION public.geography_analyze(internal) OWNER TO postgres;

--
-- TOC entry 27 (class 1255 OID 18368)
-- Dependencies: 6 1100
-- Name: geography_in(cstring, oid, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_in(cstring, oid, integer) RETURNS geography
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_in';


ALTER FUNCTION public.geography_in(cstring, oid, integer) OWNER TO postgres;

--
-- TOC entry 28 (class 1255 OID 18369)
-- Dependencies: 6 1100
-- Name: geography_out(geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_out(geography) RETURNS cstring
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_out';


ALTER FUNCTION public.geography_out(geography) OWNER TO postgres;

--
-- TOC entry 29 (class 1255 OID 18370)
-- Dependencies: 6
-- Name: geography_typmod_in(cstring[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_typmod_in(cstring[]) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_typmod_in';


ALTER FUNCTION public.geography_typmod_in(cstring[]) OWNER TO postgres;

--
-- TOC entry 30 (class 1255 OID 18371)
-- Dependencies: 6
-- Name: geography_typmod_out(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_typmod_out(integer) RETURNS cstring
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_typmod_out';


ALTER FUNCTION public.geography_typmod_out(integer) OWNER TO postgres;

--
-- TOC entry 1099 (class 1247 OID 18366)
-- Dependencies: 29 30 26 6 27 28
-- Name: geography; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE geography (
    INTERNALLENGTH = variable,
    INPUT = geography_in,
    OUTPUT = geography_out,
    TYPMOD_IN = geography_typmod_in,
    TYPMOD_OUT = geography_typmod_out,
    ANALYZE = geography_analyze,
    ALIGNMENT = double,
    STORAGE = main
);


ALTER TYPE public.geography OWNER TO postgres;

--
-- TOC entry 1103 (class 0 OID 0)
-- Name: geometry; Type: SHELL TYPE; Schema: public; Owner: postgres
--

CREATE TYPE geometry;


--
-- TOC entry 31 (class 1255 OID 18374)
-- Dependencies: 6
-- Name: geometry_analyze(internal); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_analyze(internal) RETURNS boolean
    LANGUAGE c STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_analyze';


ALTER FUNCTION public.geometry_analyze(internal) OWNER TO postgres;

--
-- TOC entry 32 (class 1255 OID 18375)
-- Dependencies: 6 1103
-- Name: geometry_in(cstring); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_in(cstring) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_in';


ALTER FUNCTION public.geometry_in(cstring) OWNER TO postgres;

--
-- TOC entry 33 (class 1255 OID 18376)
-- Dependencies: 6 1103
-- Name: geometry_out(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_out(geometry) RETURNS cstring
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_out';


ALTER FUNCTION public.geometry_out(geometry) OWNER TO postgres;

--
-- TOC entry 34 (class 1255 OID 18377)
-- Dependencies: 6 1103
-- Name: geometry_recv(internal); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_recv(internal) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_recv';


ALTER FUNCTION public.geometry_recv(internal) OWNER TO postgres;

--
-- TOC entry 35 (class 1255 OID 18378)
-- Dependencies: 6 1103
-- Name: geometry_send(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_send(geometry) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_send';


ALTER FUNCTION public.geometry_send(geometry) OWNER TO postgres;

--
-- TOC entry 1102 (class 1247 OID 18373)
-- Dependencies: 35 31 32 6 33 34
-- Name: geometry; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE geometry (
    INTERNALLENGTH = variable,
    INPUT = geometry_in,
    OUTPUT = geometry_out,
    RECEIVE = geometry_recv,
    SEND = geometry_send,
    ANALYZE = geometry_analyze,
    DELIMITER = ':',
    ALIGNMENT = int4,
    STORAGE = main
);


ALTER TYPE public.geometry OWNER TO postgres;

--
-- TOC entry 1105 (class 1247 OID 18382)
-- Dependencies: 6 2410
-- Name: geometry_dump; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE geometry_dump AS (
	path integer[],
	geom geometry
);


ALTER TYPE public.geometry_dump OWNER TO postgres;

--
-- TOC entry 1108 (class 0 OID 0)
-- Name: gidx; Type: SHELL TYPE; Schema: public; Owner: postgres
--

CREATE TYPE gidx;


--
-- TOC entry 36 (class 1255 OID 18384)
-- Dependencies: 6 1108
-- Name: gidx_in(cstring); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION gidx_in(cstring) RETURNS gidx
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'gidx_in';


ALTER FUNCTION public.gidx_in(cstring) OWNER TO postgres;

--
-- TOC entry 37 (class 1255 OID 18385)
-- Dependencies: 6 1108
-- Name: gidx_out(gidx); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION gidx_out(gidx) RETURNS cstring
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'gidx_out';


ALTER FUNCTION public.gidx_out(gidx) OWNER TO postgres;

--
-- TOC entry 1107 (class 1247 OID 18383)
-- Dependencies: 36 6 37
-- Name: gidx; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE gidx (
    INTERNALLENGTH = variable,
    INPUT = gidx_in,
    OUTPUT = gidx_out,
    ALIGNMENT = double,
    STORAGE = plain
);


ALTER TYPE public.gidx OWNER TO postgres;

--
-- TOC entry 1111 (class 0 OID 0)
-- Name: pgis_abs; Type: SHELL TYPE; Schema: public; Owner: postgres
--

CREATE TYPE pgis_abs;


--
-- TOC entry 38 (class 1255 OID 18388)
-- Dependencies: 6 1111
-- Name: pgis_abs_in(cstring); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgis_abs_in(cstring) RETURNS pgis_abs
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'pgis_abs_in';


ALTER FUNCTION public.pgis_abs_in(cstring) OWNER TO postgres;

--
-- TOC entry 39 (class 1255 OID 18389)
-- Dependencies: 6 1111
-- Name: pgis_abs_out(pgis_abs); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgis_abs_out(pgis_abs) RETURNS cstring
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'pgis_abs_out';


ALTER FUNCTION public.pgis_abs_out(pgis_abs) OWNER TO postgres;

--
-- TOC entry 1110 (class 1247 OID 18387)
-- Dependencies: 39 6 38
-- Name: pgis_abs; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE pgis_abs (
    INTERNALLENGTH = 8,
    INPUT = pgis_abs_in,
    OUTPUT = pgis_abs_out,
    ALIGNMENT = double,
    STORAGE = plain
);


ALTER TYPE public.pgis_abs OWNER TO postgres;

--
-- TOC entry 1114 (class 0 OID 0)
-- Name: spheroid; Type: SHELL TYPE; Schema: public; Owner: postgres
--

CREATE TYPE spheroid;


--
-- TOC entry 40 (class 1255 OID 18392)
-- Dependencies: 6 1114
-- Name: spheroid_in(cstring); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION spheroid_in(cstring) RETURNS spheroid
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'ellipsoid_in';


ALTER FUNCTION public.spheroid_in(cstring) OWNER TO postgres;

--
-- TOC entry 41 (class 1255 OID 18393)
-- Dependencies: 6 1114
-- Name: spheroid_out(spheroid); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION spheroid_out(spheroid) RETURNS cstring
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'ellipsoid_out';


ALTER FUNCTION public.spheroid_out(spheroid) OWNER TO postgres;

--
-- TOC entry 1113 (class 1247 OID 18391)
-- Dependencies: 6 41 40
-- Name: spheroid; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE spheroid (
    INTERNALLENGTH = 65,
    INPUT = spheroid_in,
    OUTPUT = spheroid_out,
    ALIGNMENT = double,
    STORAGE = plain
);


ALTER TYPE public.spheroid OWNER TO postgres;

--
-- TOC entry 42 (class 1255 OID 18395)
-- Dependencies: 6 1102
-- Name: _st_asgeojson(integer, geometry, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_asgeojson(integer, geometry, integer, integer) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_asGeoJson';


ALTER FUNCTION public._st_asgeojson(integer, geometry, integer, integer) OWNER TO postgres;

--
-- TOC entry 43 (class 1255 OID 18396)
-- Dependencies: 1099 6
-- Name: _st_asgeojson(integer, geography, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_asgeojson(integer, geography, integer, integer) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_as_geojson';


ALTER FUNCTION public._st_asgeojson(integer, geography, integer, integer) OWNER TO postgres;

--
-- TOC entry 44 (class 1255 OID 18397)
-- Dependencies: 1102 6
-- Name: _st_asgml(integer, geometry, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_asgml(integer, geometry, integer, integer) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_asGML';


ALTER FUNCTION public._st_asgml(integer, geometry, integer, integer) OWNER TO postgres;

--
-- TOC entry 45 (class 1255 OID 18398)
-- Dependencies: 1099 6
-- Name: _st_asgml(integer, geography, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_asgml(integer, geography, integer, integer) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_as_gml';


ALTER FUNCTION public._st_asgml(integer, geography, integer, integer) OWNER TO postgres;

--
-- TOC entry 46 (class 1255 OID 18399)
-- Dependencies: 6 1102
-- Name: _st_askml(integer, geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_askml(integer, geometry, integer) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_asKML';


ALTER FUNCTION public._st_askml(integer, geometry, integer) OWNER TO postgres;

--
-- TOC entry 47 (class 1255 OID 18400)
-- Dependencies: 1099 6
-- Name: _st_askml(integer, geography, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_askml(integer, geography, integer) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_as_kml';


ALTER FUNCTION public._st_askml(integer, geography, integer) OWNER TO postgres;

--
-- TOC entry 49 (class 1255 OID 18402)
-- Dependencies: 6 1099
-- Name: _st_bestsrid(geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_bestsrid(geography) RETURNS integer
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_BestSRID($1,$1)$_$;


ALTER FUNCTION public._st_bestsrid(geography) OWNER TO postgres;

--
-- TOC entry 48 (class 1255 OID 18401)
-- Dependencies: 1099 6 1099
-- Name: _st_bestsrid(geography, geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_bestsrid(geography, geography) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_bestsrid';


ALTER FUNCTION public._st_bestsrid(geography, geography) OWNER TO postgres;

--
-- TOC entry 50 (class 1255 OID 18403)
-- Dependencies: 1102 6 1102
-- Name: _st_buffer(geometry, double precision, cstring); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_buffer(geometry, double precision, cstring) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'buffer';


ALTER FUNCTION public._st_buffer(geometry, double precision, cstring) OWNER TO postgres;

--
-- TOC entry 51 (class 1255 OID 18404)
-- Dependencies: 6 1102 1102
-- Name: _st_contains(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_contains(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'contains';


ALTER FUNCTION public._st_contains(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 52 (class 1255 OID 18405)
-- Dependencies: 6 1102 1102
-- Name: _st_containsproperly(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_containsproperly(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'containsproperly';


ALTER FUNCTION public._st_containsproperly(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 53 (class 1255 OID 18406)
-- Dependencies: 6 1102 1102
-- Name: _st_coveredby(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_coveredby(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'coveredby';


ALTER FUNCTION public._st_coveredby(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 54 (class 1255 OID 18407)
-- Dependencies: 1102 6 1102
-- Name: _st_covers(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_covers(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'covers';


ALTER FUNCTION public._st_covers(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 55 (class 1255 OID 18408)
-- Dependencies: 1099 6 1099
-- Name: _st_covers(geography, geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_covers(geography, geography) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'geography_covers';


ALTER FUNCTION public._st_covers(geography, geography) OWNER TO postgres;

--
-- TOC entry 56 (class 1255 OID 18409)
-- Dependencies: 1102 6 1102
-- Name: _st_crosses(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_crosses(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'crosses';


ALTER FUNCTION public._st_crosses(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 57 (class 1255 OID 18410)
-- Dependencies: 1102 6 1102
-- Name: _st_dfullywithin(geometry, geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_dfullywithin(geometry, geometry, double precision) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_dfullywithin';


ALTER FUNCTION public._st_dfullywithin(geometry, geometry, double precision) OWNER TO postgres;

--
-- TOC entry 58 (class 1255 OID 18411)
-- Dependencies: 1099 1099 6
-- Name: _st_distance(geography, geography, double precision, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_distance(geography, geography, double precision, boolean) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'geography_distance';


ALTER FUNCTION public._st_distance(geography, geography, double precision, boolean) OWNER TO postgres;

--
-- TOC entry 59 (class 1255 OID 18412)
-- Dependencies: 1105 1170 6 1102
-- Name: _st_dumppoints(geometry, integer[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_dumppoints(the_geom geometry, cur_path integer[]) RETURNS SETOF geometry_dump
    LANGUAGE plpgsql
    AS $$
DECLARE
  tmp geometry_dump;
  tmp2 geometry_dump;
  nb_points integer;
  nb_geom integer;
  i integer;
  j integer;
  g geometry;
  
BEGIN
  
  RAISE DEBUG '%,%', cur_path, ST_GeometryType(the_geom);

  -- Special case (MULTI* OR GEOMETRYCOLLECTION) : iterate and return the DumpPoints of the geometries
  SELECT ST_NumGeometries(the_geom) INTO nb_geom;

  IF (nb_geom IS NOT NULL) THEN
    
    i = 1;
    FOR tmp2 IN SELECT (ST_Dump(the_geom)).* LOOP

      FOR tmp IN SELECT * FROM _ST_DumpPoints(tmp2.geom, cur_path || tmp2.path) LOOP
	    RETURN NEXT tmp;
      END LOOP;
      i = i + 1;
      
    END LOOP;

    RETURN;
  END IF;
  

  -- Special case (POLYGON) : return the points of the rings of a polygon
  IF (ST_GeometryType(the_geom) = 'ST_Polygon') THEN

    FOR tmp IN SELECT * FROM _ST_DumpPoints(ST_ExteriorRing(the_geom), cur_path || ARRAY[1]) LOOP
      RETURN NEXT tmp;
    END LOOP;
    
    j := ST_NumInteriorRings(the_geom);
    FOR i IN 1..j LOOP
        FOR tmp IN SELECT * FROM _ST_DumpPoints(ST_InteriorRingN(the_geom, i), cur_path || ARRAY[i+1]) LOOP
          RETURN NEXT tmp;
        END LOOP;
    END LOOP;
    
    RETURN;
  END IF;

    
  -- Special case (POINT) : return the point
  IF (ST_GeometryType(the_geom) = 'ST_Point') THEN

    tmp.path = cur_path || ARRAY[1];
    tmp.geom = the_geom;

    RETURN NEXT tmp;
    RETURN;

  END IF;


  -- Use ST_NumPoints rather than ST_NPoints to have a NULL value if the_geom isn't
  -- a LINESTRING or CIRCULARSTRING.
  SELECT ST_NumPoints(the_geom) INTO nb_points;

  -- This should never happen
  IF (nb_points IS NULL) THEN
    RAISE EXCEPTION 'Unexpected error while dumping geometry %', ST_AsText(the_geom);
  END IF;

  FOR i IN 1..nb_points LOOP
    tmp.path = cur_path || ARRAY[i];
    tmp.geom := ST_PointN(the_geom, i);
    RETURN NEXT tmp;
  END LOOP;
   
END
$$;


ALTER FUNCTION public._st_dumppoints(the_geom geometry, cur_path integer[]) OWNER TO postgres;

--
-- TOC entry 60 (class 1255 OID 18413)
-- Dependencies: 1102 6 1102
-- Name: _st_dwithin(geometry, geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_dwithin(geometry, geometry, double precision) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'LWGEOM_dwithin';


ALTER FUNCTION public._st_dwithin(geometry, geometry, double precision) OWNER TO postgres;

--
-- TOC entry 61 (class 1255 OID 18414)
-- Dependencies: 1099 6 1099
-- Name: _st_dwithin(geography, geography, double precision, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_dwithin(geography, geography, double precision, boolean) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'geography_dwithin';


ALTER FUNCTION public._st_dwithin(geography, geography, double precision, boolean) OWNER TO postgres;

--
-- TOC entry 62 (class 1255 OID 18415)
-- Dependencies: 1102 6 1102
-- Name: _st_equals(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_equals(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'geomequals';


ALTER FUNCTION public._st_equals(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 63 (class 1255 OID 18416)
-- Dependencies: 1099 6 1099
-- Name: _st_expand(geography, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_expand(geography, double precision) RETURNS geography
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_expand';


ALTER FUNCTION public._st_expand(geography, double precision) OWNER TO postgres;

--
-- TOC entry 64 (class 1255 OID 18417)
-- Dependencies: 1102 6 1102
-- Name: _st_intersects(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_intersects(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'intersects';


ALTER FUNCTION public._st_intersects(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 65 (class 1255 OID 18418)
-- Dependencies: 1102 6 1102
-- Name: _st_linecrossingdirection(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_linecrossingdirection(geometry, geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'ST_LineCrossingDirection';


ALTER FUNCTION public._st_linecrossingdirection(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 66 (class 1255 OID 18419)
-- Dependencies: 1102 6 1102 1102
-- Name: _st_longestline(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_longestline(geometry, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_longestline2d';


ALTER FUNCTION public._st_longestline(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 67 (class 1255 OID 18420)
-- Dependencies: 1102 6 1102
-- Name: _st_maxdistance(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_maxdistance(geometry, geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_maxdistance2d_linestring';


ALTER FUNCTION public._st_maxdistance(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 68 (class 1255 OID 18421)
-- Dependencies: 6 1102 1102
-- Name: _st_orderingequals(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_orderingequals(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'LWGEOM_same';


ALTER FUNCTION public._st_orderingequals(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 69 (class 1255 OID 18422)
-- Dependencies: 1102 6 1102
-- Name: _st_overlaps(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_overlaps(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'overlaps';


ALTER FUNCTION public._st_overlaps(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 70 (class 1255 OID 18423)
-- Dependencies: 1099 6 1099
-- Name: _st_pointoutside(geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_pointoutside(geography) RETURNS geography
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_point_outside';


ALTER FUNCTION public._st_pointoutside(geography) OWNER TO postgres;

--
-- TOC entry 71 (class 1255 OID 18424)
-- Dependencies: 1102 6 1102
-- Name: _st_touches(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_touches(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'touches';


ALTER FUNCTION public._st_touches(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 72 (class 1255 OID 18425)
-- Dependencies: 1102 6 1102
-- Name: _st_within(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION _st_within(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'within';


ALTER FUNCTION public._st_within(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 73 (class 1255 OID 18426)
-- Dependencies: 6 1170
-- Name: addauth(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION addauth(text) RETURNS boolean
    LANGUAGE plpgsql
    AS $_$ 
DECLARE
	lockid alias for $1;
	okay boolean;
	myrec record;
BEGIN
	-- check to see if table exists
	--  if not, CREATE TEMP TABLE mylock (transid xid, lockcode text)
	okay := 'f';
	FOR myrec IN SELECT * FROM pg_class WHERE relname = 'temp_lock_have_table' LOOP
		okay := 't';
	END LOOP; 
	IF (okay <> 't') THEN 
		CREATE TEMP TABLE temp_lock_have_table (transid xid, lockcode text);
			-- this will only work from pgsql7.4 up
			-- ON COMMIT DELETE ROWS;
	END IF;

	--  INSERT INTO mylock VALUES ( $1)
--	EXECUTE 'INSERT INTO temp_lock_have_table VALUES ( '||
--		quote_literal(getTransactionID()) || ',' ||
--		quote_literal(lockid) ||')';

	INSERT INTO temp_lock_have_table VALUES (getTransactionID(), lockid);

	RETURN true::boolean;
END;
$_$;


ALTER FUNCTION public.addauth(text) OWNER TO postgres;

--
-- TOC entry 74 (class 1255 OID 18427)
-- Dependencies: 1102 6 1102
-- Name: addbbox(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION addbbox(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_addBBOX';


ALTER FUNCTION public.addbbox(geometry) OWNER TO postgres;

--
-- TOC entry 79 (class 1255 OID 18430)
-- Dependencies: 6 1170
-- Name: addgeometrycolumn(character varying, character varying, integer, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION addgeometrycolumn(character varying, character varying, integer, character varying, integer) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	ret  text;
BEGIN
	SELECT AddGeometryColumn('','',$1,$2,$3,$4,$5) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.addgeometrycolumn(character varying, character varying, integer, character varying, integer) OWNER TO postgres;

--
-- TOC entry 78 (class 1255 OID 18429)
-- Dependencies: 6 1170
-- Name: addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer) RETURNS text
    LANGUAGE plpgsql STABLE STRICT
    AS $_$
DECLARE
	ret  text;
BEGIN
	SELECT AddGeometryColumn('',$1,$2,$3,$4,$5,$6) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer) OWNER TO postgres;

--
-- TOC entry 77 (class 1255 OID 18428)
-- Dependencies: 6 1170
-- Name: addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	catalog_name alias for $1;
	schema_name alias for $2;
	table_name alias for $3;
	column_name alias for $4;
	new_srid alias for $5;
	new_type alias for $6;
	new_dim alias for $7;
	rec RECORD;
	sr varchar;
	real_schema name;
	sql text;

BEGIN

	-- Verify geometry type
	IF ( NOT ( (new_type = 'GEOMETRY') OR
			   (new_type = 'GEOMETRYCOLLECTION') OR
			   (new_type = 'POINT') OR
			   (new_type = 'MULTIPOINT') OR
			   (new_type = 'POLYGON') OR
			   (new_type = 'MULTIPOLYGON') OR
			   (new_type = 'LINESTRING') OR
			   (new_type = 'MULTILINESTRING') OR
			   (new_type = 'GEOMETRYCOLLECTIONM') OR
			   (new_type = 'POINTM') OR
			   (new_type = 'MULTIPOINTM') OR
			   (new_type = 'POLYGONM') OR
			   (new_type = 'MULTIPOLYGONM') OR
			   (new_type = 'LINESTRINGM') OR
			   (new_type = 'MULTILINESTRINGM') OR
			   (new_type = 'CIRCULARSTRING') OR
			   (new_type = 'CIRCULARSTRINGM') OR
			   (new_type = 'COMPOUNDCURVE') OR
			   (new_type = 'COMPOUNDCURVEM') OR
			   (new_type = 'CURVEPOLYGON') OR
			   (new_type = 'CURVEPOLYGONM') OR
			   (new_type = 'MULTICURVE') OR
			   (new_type = 'MULTICURVEM') OR
			   (new_type = 'MULTISURFACE') OR
			   (new_type = 'MULTISURFACEM')) )
	THEN
		RAISE EXCEPTION 'Invalid type name - valid ones are:
	POINT, MULTIPOINT,
	LINESTRING, MULTILINESTRING,
	POLYGON, MULTIPOLYGON,
	CIRCULARSTRING, COMPOUNDCURVE, MULTICURVE,
	CURVEPOLYGON, MULTISURFACE,
	GEOMETRY, GEOMETRYCOLLECTION,
	POINTM, MULTIPOINTM,
	LINESTRINGM, MULTILINESTRINGM,
	POLYGONM, MULTIPOLYGONM,
	CIRCULARSTRINGM, COMPOUNDCURVEM, MULTICURVEM
	CURVEPOLYGONM, MULTISURFACEM,
	or GEOMETRYCOLLECTIONM';
		RETURN 'fail';
	END IF;


	-- Verify dimension
	IF ( (new_dim >4) OR (new_dim <0) ) THEN
		RAISE EXCEPTION 'invalid dimension';
		RETURN 'fail';
	END IF;

	IF ( (new_type LIKE '%M') AND (new_dim!=3) ) THEN
		RAISE EXCEPTION 'TypeM needs 3 dimensions';
		RETURN 'fail';
	END IF;


	-- Verify SRID
	IF ( new_srid != -1 ) THEN
		SELECT SRID INTO sr FROM spatial_ref_sys WHERE SRID = new_srid;
		IF NOT FOUND THEN
			RAISE EXCEPTION 'AddGeometryColumns() - invalid SRID';
			RETURN 'fail';
		END IF;
	END IF;


	-- Verify schema
	IF ( schema_name IS NOT NULL AND schema_name != '' ) THEN
		sql := 'SELECT nspname FROM pg_namespace ' ||
			'WHERE text(nspname) = ' || quote_literal(schema_name) ||
			'LIMIT 1';
		RAISE DEBUG '%', sql;
		EXECUTE sql INTO real_schema;

		IF ( real_schema IS NULL ) THEN
			RAISE EXCEPTION 'Schema % is not a valid schemaname', quote_literal(schema_name);
			RETURN 'fail';
		END IF;
	END IF;

	IF ( real_schema IS NULL ) THEN
		RAISE DEBUG 'Detecting schema';
		sql := 'SELECT n.nspname AS schemaname ' ||
			'FROM pg_catalog.pg_class c ' ||
			  'JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace ' ||
			'WHERE c.relkind = ' || quote_literal('r') ||
			' AND n.nspname NOT IN (' || quote_literal('pg_catalog') || ', ' || quote_literal('pg_toast') || ')' ||
			' AND pg_catalog.pg_table_is_visible(c.oid)' ||
			' AND c.relname = ' || quote_literal(table_name);
		RAISE DEBUG '%', sql;
		EXECUTE sql INTO real_schema;

		IF ( real_schema IS NULL ) THEN
			RAISE EXCEPTION 'Table % does not occur in the search_path', quote_literal(table_name);
			RETURN 'fail';
		END IF;
	END IF;


	-- Add geometry column to table
	sql := 'ALTER TABLE ' ||
		quote_ident(real_schema) || '.' || quote_ident(table_name)
		|| ' ADD COLUMN ' || quote_ident(column_name) ||
		' geometry ';
	RAISE DEBUG '%', sql;
	EXECUTE sql;


	-- Delete stale record in geometry_columns (if any)
	sql := 'DELETE FROM geometry_columns WHERE
		f_table_catalog = ' || quote_literal('') ||
		' AND f_table_schema = ' ||
		quote_literal(real_schema) ||
		' AND f_table_name = ' || quote_literal(table_name) ||
		' AND f_geometry_column = ' || quote_literal(column_name);
	RAISE DEBUG '%', sql;
	EXECUTE sql;


	-- Add record in geometry_columns
	sql := 'INSERT INTO geometry_columns (f_table_catalog,f_table_schema,f_table_name,' ||
										  'f_geometry_column,coord_dimension,srid,type)' ||
		' VALUES (' ||
		quote_literal('') || ',' ||
		quote_literal(real_schema) || ',' ||
		quote_literal(table_name) || ',' ||
		quote_literal(column_name) || ',' ||
		new_dim::text || ',' ||
		new_srid::text || ',' ||
		quote_literal(new_type) || ')';
	RAISE DEBUG '%', sql;
	EXECUTE sql;


	-- Add table CHECKs
	sql := 'ALTER TABLE ' ||
		quote_ident(real_schema) || '.' || quote_ident(table_name)
		|| ' ADD CONSTRAINT '
		|| quote_ident('enforce_srid_' || column_name)
		|| ' CHECK (ST_SRID(' || quote_ident(column_name) ||
		') = ' || new_srid::text || ')' ;
	RAISE DEBUG '%', sql;
	EXECUTE sql;

	sql := 'ALTER TABLE ' ||
		quote_ident(real_schema) || '.' || quote_ident(table_name)
		|| ' ADD CONSTRAINT '
		|| quote_ident('enforce_dims_' || column_name)
		|| ' CHECK (ST_NDims(' || quote_ident(column_name) ||
		') = ' || new_dim::text || ')' ;
	RAISE DEBUG '%', sql;
	EXECUTE sql;

	IF ( NOT (new_type = 'GEOMETRY')) THEN
		sql := 'ALTER TABLE ' ||
			quote_ident(real_schema) || '.' || quote_ident(table_name) || ' ADD CONSTRAINT ' ||
			quote_ident('enforce_geotype_' || column_name) ||
			' CHECK (GeometryType(' ||
			quote_ident(column_name) || ')=' ||
			quote_literal(new_type) || ' OR (' ||
			quote_ident(column_name) || ') is null)';
		RAISE DEBUG '%', sql;
		EXECUTE sql;
	END IF;

	RETURN
		real_schema || '.' ||
		table_name || '.' || column_name ||
		' SRID:' || new_srid::text ||
		' TYPE:' || new_type ||
		' DIMS:' || new_dim::text || ' ';
END;
$_$;


ALTER FUNCTION public.addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer) OWNER TO postgres;

--
-- TOC entry 80 (class 1255 OID 18431)
-- Dependencies: 1102 6 1102 1102
-- Name: addpoint(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION addpoint(geometry, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_addpoint';


ALTER FUNCTION public.addpoint(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 81 (class 1255 OID 18432)
-- Dependencies: 1102 6 1102 1102
-- Name: addpoint(geometry, geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION addpoint(geometry, geometry, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_addpoint';


ALTER FUNCTION public.addpoint(geometry, geometry, integer) OWNER TO postgres;

--
-- TOC entry 83 (class 1255 OID 18434)
-- Dependencies: 1102 6 1102
-- Name: affine(geometry, double precision, double precision, double precision, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION affine(geometry, double precision, double precision, double precision, double precision, double precision, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT affine($1,  $2, $3, 0,  $4, $5, 0,  0, 0, 1,  $6, $7, 0)$_$;


ALTER FUNCTION public.affine(geometry, double precision, double precision, double precision, double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 82 (class 1255 OID 18433)
-- Dependencies: 6 1102 1102
-- Name: affine(geometry, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION affine(geometry, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_affine';


ALTER FUNCTION public.affine(geometry, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 84 (class 1255 OID 18435)
-- Dependencies: 6 1102
-- Name: area(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION area(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_area_polygon';


ALTER FUNCTION public.area(geometry) OWNER TO postgres;

--
-- TOC entry 85 (class 1255 OID 18436)
-- Dependencies: 6 1102
-- Name: area2d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION area2d(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_area_polygon';


ALTER FUNCTION public.area2d(geometry) OWNER TO postgres;

--
-- TOC entry 86 (class 1255 OID 18437)
-- Dependencies: 1102 6
-- Name: asbinary(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION asbinary(geometry) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_asBinary';


ALTER FUNCTION public.asbinary(geometry) OWNER TO postgres;

--
-- TOC entry 87 (class 1255 OID 18438)
-- Dependencies: 6 1102
-- Name: asbinary(geometry, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION asbinary(geometry, text) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_asBinary';


ALTER FUNCTION public.asbinary(geometry, text) OWNER TO postgres;

--
-- TOC entry 88 (class 1255 OID 18439)
-- Dependencies: 1102 6
-- Name: asewkb(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION asewkb(geometry) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'WKBFromLWGEOM';


ALTER FUNCTION public.asewkb(geometry) OWNER TO postgres;

--
-- TOC entry 89 (class 1255 OID 18440)
-- Dependencies: 6 1102
-- Name: asewkb(geometry, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION asewkb(geometry, text) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'WKBFromLWGEOM';


ALTER FUNCTION public.asewkb(geometry, text) OWNER TO postgres;

--
-- TOC entry 90 (class 1255 OID 18441)
-- Dependencies: 1102 6
-- Name: asewkt(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION asewkt(geometry) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_asEWKT';


ALTER FUNCTION public.asewkt(geometry) OWNER TO postgres;

--
-- TOC entry 92 (class 1255 OID 18443)
-- Dependencies: 6 1102
-- Name: asgml(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION asgml(geometry) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGML(2, $1, 15, 0)$_$;


ALTER FUNCTION public.asgml(geometry) OWNER TO postgres;

--
-- TOC entry 91 (class 1255 OID 18442)
-- Dependencies: 1102 6
-- Name: asgml(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION asgml(geometry, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGML(2, $1, $2, 0)$_$;


ALTER FUNCTION public.asgml(geometry, integer) OWNER TO postgres;

--
-- TOC entry 93 (class 1255 OID 18444)
-- Dependencies: 1102 6
-- Name: ashexewkb(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION ashexewkb(geometry) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_asHEXEWKB';


ALTER FUNCTION public.ashexewkb(geometry) OWNER TO postgres;

--
-- TOC entry 94 (class 1255 OID 18445)
-- Dependencies: 6 1102
-- Name: ashexewkb(geometry, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION ashexewkb(geometry, text) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_asHEXEWKB';


ALTER FUNCTION public.ashexewkb(geometry, text) OWNER TO postgres;

--
-- TOC entry 96 (class 1255 OID 18447)
-- Dependencies: 6 1102
-- Name: askml(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION askml(geometry) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsKML(2, transform($1,4326), 15)$_$;


ALTER FUNCTION public.askml(geometry) OWNER TO postgres;

--
-- TOC entry 95 (class 1255 OID 18446)
-- Dependencies: 6 1102
-- Name: askml(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION askml(geometry, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsKML(2, transform($1,4326), $2)$_$;


ALTER FUNCTION public.askml(geometry, integer) OWNER TO postgres;

--
-- TOC entry 97 (class 1255 OID 18448)
-- Dependencies: 1102 6
-- Name: askml(integer, geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION askml(integer, geometry, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsKML($1, transform($2,4326), $3)$_$;


ALTER FUNCTION public.askml(integer, geometry, integer) OWNER TO postgres;

--
-- TOC entry 100 (class 1255 OID 18451)
-- Dependencies: 1102 6
-- Name: assvg(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION assvg(geometry) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'assvg_geometry';


ALTER FUNCTION public.assvg(geometry) OWNER TO postgres;

--
-- TOC entry 99 (class 1255 OID 18450)
-- Dependencies: 6 1102
-- Name: assvg(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION assvg(geometry, integer) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'assvg_geometry';


ALTER FUNCTION public.assvg(geometry, integer) OWNER TO postgres;

--
-- TOC entry 98 (class 1255 OID 18449)
-- Dependencies: 6 1102
-- Name: assvg(geometry, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION assvg(geometry, integer, integer) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'assvg_geometry';


ALTER FUNCTION public.assvg(geometry, integer, integer) OWNER TO postgres;

--
-- TOC entry 101 (class 1255 OID 18452)
-- Dependencies: 6 1102
-- Name: astext(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION astext(geometry) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_asText';


ALTER FUNCTION public.astext(geometry) OWNER TO postgres;

--
-- TOC entry 102 (class 1255 OID 18453)
-- Dependencies: 6 1102 1102
-- Name: azimuth(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION azimuth(geometry, geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_azimuth';


ALTER FUNCTION public.azimuth(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 103 (class 1255 OID 18454)
-- Dependencies: 1170 1102 6
-- Name: bdmpolyfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION bdmpolyfromtext(text, integer) RETURNS geometry
    LANGUAGE plpgsql IMMUTABLE STRICT
    AS $_$
DECLARE
	geomtext alias for $1;
	srid alias for $2;
	mline geometry;
	geom geometry;
BEGIN
	mline := MultiLineStringFromText(geomtext, srid);

	IF mline IS NULL
	THEN
		RAISE EXCEPTION 'Input is not a MultiLinestring';
	END IF;

	geom := multi(BuildArea(mline));

	RETURN geom;
END;
$_$;


ALTER FUNCTION public.bdmpolyfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 75 (class 1255 OID 18455)
-- Dependencies: 1170 1102 6
-- Name: bdpolyfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION bdpolyfromtext(text, integer) RETURNS geometry
    LANGUAGE plpgsql IMMUTABLE STRICT
    AS $_$
DECLARE
	geomtext alias for $1;
	srid alias for $2;
	mline geometry;
	geom geometry;
BEGIN
	mline := MultiLineStringFromText(geomtext, srid);

	IF mline IS NULL
	THEN
		RAISE EXCEPTION 'Input is not a MultiLinestring';
	END IF;

	geom := BuildArea(mline);

	IF GeometryType(geom) != 'POLYGON'
	THEN
		RAISE EXCEPTION 'Input returns more then a single polygon, try using BdMPolyFromText instead';
	END IF;

	RETURN geom;
END;
$_$;


ALTER FUNCTION public.bdpolyfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 76 (class 1255 OID 18456)
-- Dependencies: 1102 6 1102
-- Name: boundary(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION boundary(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'boundary';


ALTER FUNCTION public.boundary(geometry) OWNER TO postgres;

--
-- TOC entry 104 (class 1255 OID 18457)
-- Dependencies: 1102 6
-- Name: box(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION box(geometry) RETURNS box
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_to_BOX';


ALTER FUNCTION public.box(geometry) OWNER TO postgres;

--
-- TOC entry 105 (class 1255 OID 18458)
-- Dependencies: 1090 6
-- Name: box(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION box(box3d) RETURNS box
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_to_BOX';


ALTER FUNCTION public.box(box3d) OWNER TO postgres;

--
-- TOC entry 106 (class 1255 OID 18459)
-- Dependencies: 1093 1087 6
-- Name: box2d(box3d_extent); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION box2d(box3d_extent) RETURNS box2d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_to_BOX2DFLOAT4';


ALTER FUNCTION public.box2d(box3d_extent) OWNER TO postgres;

--
-- TOC entry 107 (class 1255 OID 18460)
-- Dependencies: 1102 1087 6
-- Name: box2d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION box2d(geometry) RETURNS box2d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_to_BOX2DFLOAT4';


ALTER FUNCTION public.box2d(geometry) OWNER TO postgres;

--
-- TOC entry 108 (class 1255 OID 18461)
-- Dependencies: 1087 1090 6
-- Name: box2d(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION box2d(box3d) RETURNS box2d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_to_BOX2DFLOAT4';


ALTER FUNCTION public.box2d(box3d) OWNER TO postgres;

--
-- TOC entry 109 (class 1255 OID 18462)
-- Dependencies: 6 1090 1102
-- Name: box3d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION box3d(geometry) RETURNS box3d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_to_BOX3D';


ALTER FUNCTION public.box3d(geometry) OWNER TO postgres;

--
-- TOC entry 110 (class 1255 OID 18463)
-- Dependencies: 1087 6 1090
-- Name: box3d(box2d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION box3d(box2d) RETURNS box3d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX2DFLOAT4_to_BOX3D';


ALTER FUNCTION public.box3d(box2d) OWNER TO postgres;

--
-- TOC entry 111 (class 1255 OID 18464)
-- Dependencies: 1090 6 1093
-- Name: box3d_extent(box3d_extent); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION box3d_extent(box3d_extent) RETURNS box3d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_extent_to_BOX3D';


ALTER FUNCTION public.box3d_extent(box3d_extent) OWNER TO postgres;

--
-- TOC entry 112 (class 1255 OID 18465)
-- Dependencies: 6 1090
-- Name: box3dtobox(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION box3dtobox(box3d) RETURNS box
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT box($1)$_$;


ALTER FUNCTION public.box3dtobox(box3d) OWNER TO postgres;

--
-- TOC entry 113 (class 1255 OID 18466)
-- Dependencies: 1102 6 1102
-- Name: buffer(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION buffer(geometry, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'buffer';


ALTER FUNCTION public.buffer(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 114 (class 1255 OID 18467)
-- Dependencies: 1102 6 1102
-- Name: buffer(geometry, double precision, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION buffer(geometry, double precision, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT ST_Buffer($1, $2, $3)$_$;


ALTER FUNCTION public.buffer(geometry, double precision, integer) OWNER TO postgres;

--
-- TOC entry 115 (class 1255 OID 18468)
-- Dependencies: 1102 6 1102
-- Name: buildarea(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION buildarea(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'LWGEOM_buildarea';


ALTER FUNCTION public.buildarea(geometry) OWNER TO postgres;

--
-- TOC entry 116 (class 1255 OID 18469)
-- Dependencies: 6 1102
-- Name: bytea(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION bytea(geometry) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_to_bytea';


ALTER FUNCTION public.bytea(geometry) OWNER TO postgres;

--
-- TOC entry 117 (class 1255 OID 18470)
-- Dependencies: 6 1102 1102
-- Name: centroid(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION centroid(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'centroid';


ALTER FUNCTION public.centroid(geometry) OWNER TO postgres;

--
-- TOC entry 119 (class 1255 OID 18472)
-- Dependencies: 6
-- Name: checkauth(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION checkauth(text, text) RETURNS integer
    LANGUAGE sql
    AS $_$ SELECT CheckAuth('', $1, $2) $_$;


ALTER FUNCTION public.checkauth(text, text) OWNER TO postgres;

--
-- TOC entry 118 (class 1255 OID 18471)
-- Dependencies: 1170 6
-- Name: checkauth(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION checkauth(text, text, text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$ 
DECLARE
	schema text;
BEGIN
	IF NOT LongTransactionsEnabled() THEN
		RAISE EXCEPTION 'Long transaction support disabled, use EnableLongTransaction() to enable.';
	END IF;

	if ( $1 != '' ) THEN
		schema = $1;
	ELSE
		SELECT current_schema() into schema;
	END IF;

	-- TODO: check for an already existing trigger ?

	EXECUTE 'CREATE TRIGGER check_auth BEFORE UPDATE OR DELETE ON ' 
		|| quote_ident(schema) || '.' || quote_ident($2)
		||' FOR EACH ROW EXECUTE PROCEDURE CheckAuthTrigger('
		|| quote_literal($3) || ')';

	RETURN 0;
END;
$_$;


ALTER FUNCTION public.checkauth(text, text, text) OWNER TO postgres;

--
-- TOC entry 120 (class 1255 OID 18473)
-- Dependencies: 6
-- Name: checkauthtrigger(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION checkauthtrigger() RETURNS trigger
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'check_authorization';


ALTER FUNCTION public.checkauthtrigger() OWNER TO postgres;

--
-- TOC entry 121 (class 1255 OID 18474)
-- Dependencies: 1102 1102 6 1102
-- Name: collect(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION collect(geometry, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE
    AS '$libdir/postgis-1.5', 'LWGEOM_collect';


ALTER FUNCTION public.collect(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 122 (class 1255 OID 18475)
-- Dependencies: 1102 1087 1087 6
-- Name: combine_bbox(box2d, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION combine_bbox(box2d, geometry) RETURNS box2d
    LANGUAGE c IMMUTABLE
    AS '$libdir/postgis-1.5', 'BOX2DFLOAT4_combine';


ALTER FUNCTION public.combine_bbox(box2d, geometry) OWNER TO postgres;

--
-- TOC entry 123 (class 1255 OID 18476)
-- Dependencies: 6 1093 1102 1093
-- Name: combine_bbox(box3d_extent, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION combine_bbox(box3d_extent, geometry) RETURNS box3d_extent
    LANGUAGE c IMMUTABLE
    AS '$libdir/postgis-1.5', 'BOX3D_combine';


ALTER FUNCTION public.combine_bbox(box3d_extent, geometry) OWNER TO postgres;

--
-- TOC entry 124 (class 1255 OID 18477)
-- Dependencies: 6 1102 1090 1090
-- Name: combine_bbox(box3d, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION combine_bbox(box3d, geometry) RETURNS box3d
    LANGUAGE c IMMUTABLE
    AS '$libdir/postgis-1.5', 'BOX3D_combine';


ALTER FUNCTION public.combine_bbox(box3d, geometry) OWNER TO postgres;

--
-- TOC entry 125 (class 1255 OID 18478)
-- Dependencies: 1096 6
-- Name: compression(chip); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION compression(chip) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_getCompression';


ALTER FUNCTION public.compression(chip) OWNER TO postgres;

--
-- TOC entry 126 (class 1255 OID 18479)
-- Dependencies: 1102 1102 6
-- Name: contains(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION contains(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'contains';


ALTER FUNCTION public.contains(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 127 (class 1255 OID 18480)
-- Dependencies: 1102 1102 6
-- Name: convexhull(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION convexhull(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'convexhull';


ALTER FUNCTION public.convexhull(geometry) OWNER TO postgres;

--
-- TOC entry 128 (class 1255 OID 18481)
-- Dependencies: 6 1102 1102
-- Name: crosses(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION crosses(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'crosses';


ALTER FUNCTION public.crosses(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 129 (class 1255 OID 18482)
-- Dependencies: 6 1096
-- Name: datatype(chip); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION datatype(chip) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_getDatatype';


ALTER FUNCTION public.datatype(chip) OWNER TO postgres;

--
-- TOC entry 130 (class 1255 OID 18483)
-- Dependencies: 1102 1102 6 1102
-- Name: difference(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION difference(geometry, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'difference';


ALTER FUNCTION public.difference(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 131 (class 1255 OID 18484)
-- Dependencies: 1102 6
-- Name: dimension(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dimension(geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_dimension';


ALTER FUNCTION public.dimension(geometry) OWNER TO postgres;

--
-- TOC entry 132 (class 1255 OID 18485)
-- Dependencies: 1170 6
-- Name: disablelongtransactions(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION disablelongtransactions() RETURNS text
    LANGUAGE plpgsql
    AS $$ 
DECLARE
	rec RECORD;

BEGIN

	--
	-- Drop all triggers applied by CheckAuth()
	--
	FOR rec IN
		SELECT c.relname, t.tgname, t.tgargs FROM pg_trigger t, pg_class c, pg_proc p
		WHERE p.proname = 'checkauthtrigger' and t.tgfoid = p.oid and t.tgrelid = c.oid
	LOOP
		EXECUTE 'DROP TRIGGER ' || quote_ident(rec.tgname) ||
			' ON ' || quote_ident(rec.relname);
	END LOOP;

	--
	-- Drop the authorization_table table
	--
	FOR rec IN SELECT * FROM pg_class WHERE relname = 'authorization_table' LOOP
		DROP TABLE authorization_table;
	END LOOP;

	--
	-- Drop the authorized_tables view
	--
	FOR rec IN SELECT * FROM pg_class WHERE relname = 'authorized_tables' LOOP
		DROP VIEW authorized_tables;
	END LOOP;

	RETURN 'Long transactions support disabled';
END;
$$;


ALTER FUNCTION public.disablelongtransactions() OWNER TO postgres;

--
-- TOC entry 133 (class 1255 OID 18486)
-- Dependencies: 1102 6 1102
-- Name: disjoint(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION disjoint(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'disjoint';


ALTER FUNCTION public.disjoint(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 134 (class 1255 OID 18487)
-- Dependencies: 1102 6 1102
-- Name: distance(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION distance(geometry, geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'LWGEOM_mindistance2d';


ALTER FUNCTION public.distance(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 135 (class 1255 OID 18488)
-- Dependencies: 1102 6 1102
-- Name: distance_sphere(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION distance_sphere(geometry, geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'LWGEOM_distance_sphere';


ALTER FUNCTION public.distance_sphere(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 136 (class 1255 OID 18489)
-- Dependencies: 6 1102 1102 1113
-- Name: distance_spheroid(geometry, geometry, spheroid); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION distance_spheroid(geometry, geometry, spheroid) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'LWGEOM_distance_ellipsoid';


ALTER FUNCTION public.distance_spheroid(geometry, geometry, spheroid) OWNER TO postgres;

--
-- TOC entry 137 (class 1255 OID 18490)
-- Dependencies: 1102 6 1102
-- Name: dropbbox(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dropbbox(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_dropBBOX';


ALTER FUNCTION public.dropbbox(geometry) OWNER TO postgres;

--
-- TOC entry 140 (class 1255 OID 18493)
-- Dependencies: 6 1170
-- Name: dropgeometrycolumn(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dropgeometrycolumn(character varying, character varying) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	ret text;
BEGIN
	SELECT DropGeometryColumn('','',$1,$2) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.dropgeometrycolumn(character varying, character varying) OWNER TO postgres;

--
-- TOC entry 139 (class 1255 OID 18492)
-- Dependencies: 6 1170
-- Name: dropgeometrycolumn(character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dropgeometrycolumn(character varying, character varying, character varying) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	ret text;
BEGIN
	SELECT DropGeometryColumn('',$1,$2,$3) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.dropgeometrycolumn(character varying, character varying, character varying) OWNER TO postgres;

--
-- TOC entry 138 (class 1255 OID 18491)
-- Dependencies: 6 1170
-- Name: dropgeometrycolumn(character varying, character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dropgeometrycolumn(character varying, character varying, character varying, character varying) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	catalog_name alias for $1;
	schema_name alias for $2;
	table_name alias for $3;
	column_name alias for $4;
	myrec RECORD;
	okay boolean;
	real_schema name;

BEGIN


	-- Find, check or fix schema_name
	IF ( schema_name != '' ) THEN
		okay = 'f';

		FOR myrec IN SELECT nspname FROM pg_namespace WHERE text(nspname) = schema_name LOOP
			okay := 't';
		END LOOP;

		IF ( okay <> 't' ) THEN
			RAISE NOTICE 'Invalid schema name - using current_schema()';
			SELECT current_schema() into real_schema;
		ELSE
			real_schema = schema_name;
		END IF;
	ELSE
		SELECT current_schema() into real_schema;
	END IF;

	-- Find out if the column is in the geometry_columns table
	okay = 'f';
	FOR myrec IN SELECT * from geometry_columns where f_table_schema = text(real_schema) and f_table_name = table_name and f_geometry_column = column_name LOOP
		okay := 't';
	END LOOP;
	IF (okay <> 't') THEN
		RAISE EXCEPTION 'column not found in geometry_columns table';
		RETURN 'f';
	END IF;

	-- Remove ref from geometry_columns table
	EXECUTE 'delete from geometry_columns where f_table_schema = ' ||
		quote_literal(real_schema) || ' and f_table_name = ' ||
		quote_literal(table_name)  || ' and f_geometry_column = ' ||
		quote_literal(column_name);

	-- Remove table column
	EXECUTE 'ALTER TABLE ' || quote_ident(real_schema) || '.' ||
		quote_ident(table_name) || ' DROP COLUMN ' ||
		quote_ident(column_name);

	RETURN real_schema || '.' || table_name || '.' || column_name ||' effectively removed.';

END;
$_$;


ALTER FUNCTION public.dropgeometrycolumn(character varying, character varying, character varying, character varying) OWNER TO postgres;

--
-- TOC entry 143 (class 1255 OID 18496)
-- Dependencies: 6
-- Name: dropgeometrytable(character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dropgeometrytable(character varying) RETURNS text
    LANGUAGE sql STRICT
    AS $_$ SELECT DropGeometryTable('','',$1) $_$;


ALTER FUNCTION public.dropgeometrytable(character varying) OWNER TO postgres;

--
-- TOC entry 142 (class 1255 OID 18495)
-- Dependencies: 6
-- Name: dropgeometrytable(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dropgeometrytable(character varying, character varying) RETURNS text
    LANGUAGE sql STRICT
    AS $_$ SELECT DropGeometryTable('',$1,$2) $_$;


ALTER FUNCTION public.dropgeometrytable(character varying, character varying) OWNER TO postgres;

--
-- TOC entry 141 (class 1255 OID 18494)
-- Dependencies: 1170 6
-- Name: dropgeometrytable(character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dropgeometrytable(character varying, character varying, character varying) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	catalog_name alias for $1;
	schema_name alias for $2;
	table_name alias for $3;
	real_schema name;

BEGIN

	IF ( schema_name = '' ) THEN
		SELECT current_schema() into real_schema;
	ELSE
		real_schema = schema_name;
	END IF;

	-- Remove refs from geometry_columns table
	EXECUTE 'DELETE FROM geometry_columns WHERE ' ||
		'f_table_schema = ' || quote_literal(real_schema) ||
		' AND ' ||
		' f_table_name = ' || quote_literal(table_name);

	-- Remove table
	EXECUTE 'DROP TABLE '
		|| quote_ident(real_schema) || '.' ||
		quote_ident(table_name);

	RETURN
		real_schema || '.' ||
		table_name ||' dropped.';

END;
$_$;


ALTER FUNCTION public.dropgeometrytable(character varying, character varying, character varying) OWNER TO postgres;

--
-- TOC entry 144 (class 1255 OID 18497)
-- Dependencies: 6 1102 1105
-- Name: dump(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dump(geometry) RETURNS SETOF geometry_dump
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_dump';


ALTER FUNCTION public.dump(geometry) OWNER TO postgres;

--
-- TOC entry 145 (class 1255 OID 18498)
-- Dependencies: 1105 6 1102
-- Name: dumprings(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dumprings(geometry) RETURNS SETOF geometry_dump
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_dump_rings';


ALTER FUNCTION public.dumprings(geometry) OWNER TO postgres;

--
-- TOC entry 146 (class 1255 OID 18499)
-- Dependencies: 1170 6
-- Name: enablelongtransactions(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION enablelongtransactions() RETURNS text
    LANGUAGE plpgsql
    AS $$ 
DECLARE
	"query" text;
	exists bool;
	rec RECORD;

BEGIN

	exists = 'f';
	FOR rec IN SELECT * FROM pg_class WHERE relname = 'authorization_table'
	LOOP
		exists = 't';
	END LOOP;

	IF NOT exists
	THEN
		"query" = 'CREATE TABLE authorization_table (
			toid oid, -- table oid
			rid text, -- row id
			expires timestamp,
			authid text
		)';
		EXECUTE "query";
	END IF;

	exists = 'f';
	FOR rec IN SELECT * FROM pg_class WHERE relname = 'authorized_tables'
	LOOP
		exists = 't';
	END LOOP;

	IF NOT exists THEN
		"query" = 'CREATE VIEW authorized_tables AS ' ||
			'SELECT ' ||
			'n.nspname as schema, ' ||
			'c.relname as table, trim(' ||
			quote_literal(chr(92) || '000') ||
			' from t.tgargs) as id_column ' ||
			'FROM pg_trigger t, pg_class c, pg_proc p ' ||
			', pg_namespace n ' ||
			'WHERE p.proname = ' || quote_literal('checkauthtrigger') ||
			' AND c.relnamespace = n.oid' ||
			' AND t.tgfoid = p.oid and t.tgrelid = c.oid';
		EXECUTE "query";
	END IF;

	RETURN 'Long transactions support enabled';
END;
$$;


ALTER FUNCTION public.enablelongtransactions() OWNER TO postgres;

--
-- TOC entry 147 (class 1255 OID 18500)
-- Dependencies: 6 1102 1102
-- Name: endpoint(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION endpoint(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_endpoint_linestring';


ALTER FUNCTION public.endpoint(geometry) OWNER TO postgres;

--
-- TOC entry 148 (class 1255 OID 18501)
-- Dependencies: 1102 6 1102
-- Name: envelope(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION envelope(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_envelope';


ALTER FUNCTION public.envelope(geometry) OWNER TO postgres;

--
-- TOC entry 149 (class 1255 OID 18502)
-- Dependencies: 6 1102 1102
-- Name: equals(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION equals(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geomequals';


ALTER FUNCTION public.equals(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 151 (class 1255 OID 18504)
-- Dependencies: 6 1087
-- Name: estimated_extent(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION estimated_extent(text, text) RETURNS box2d
    LANGUAGE c IMMUTABLE STRICT SECURITY DEFINER
    AS '$libdir/postgis-1.5', 'LWGEOM_estimated_extent';


ALTER FUNCTION public.estimated_extent(text, text) OWNER TO postgres;

--
-- TOC entry 150 (class 1255 OID 18503)
-- Dependencies: 1087 6
-- Name: estimated_extent(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION estimated_extent(text, text, text) RETURNS box2d
    LANGUAGE c IMMUTABLE STRICT SECURITY DEFINER
    AS '$libdir/postgis-1.5', 'LWGEOM_estimated_extent';


ALTER FUNCTION public.estimated_extent(text, text, text) OWNER TO postgres;

--
-- TOC entry 152 (class 1255 OID 18505)
-- Dependencies: 1090 6 1090
-- Name: expand(box3d, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION expand(box3d, double precision) RETURNS box3d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_expand';


ALTER FUNCTION public.expand(box3d, double precision) OWNER TO postgres;

--
-- TOC entry 153 (class 1255 OID 18506)
-- Dependencies: 1087 1087 6
-- Name: expand(box2d, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION expand(box2d, double precision) RETURNS box2d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX2DFLOAT4_expand';


ALTER FUNCTION public.expand(box2d, double precision) OWNER TO postgres;

--
-- TOC entry 154 (class 1255 OID 18507)
-- Dependencies: 6 1102 1102
-- Name: expand(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION expand(geometry, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_expand';


ALTER FUNCTION public.expand(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 155 (class 1255 OID 18508)
-- Dependencies: 6 1102 1102
-- Name: exteriorring(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION exteriorring(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_exteriorring_polygon';


ALTER FUNCTION public.exteriorring(geometry) OWNER TO postgres;

--
-- TOC entry 156 (class 1255 OID 18509)
-- Dependencies: 1096 6
-- Name: factor(chip); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION factor(chip) RETURNS real
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_getFactor';


ALTER FUNCTION public.factor(chip) OWNER TO postgres;

--
-- TOC entry 158 (class 1255 OID 18511)
-- Dependencies: 1087 6 1170
-- Name: find_extent(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION find_extent(text, text) RETURNS box2d
    LANGUAGE plpgsql IMMUTABLE STRICT
    AS $_$
DECLARE
	tablename alias for $1;
	columnname alias for $2;
	myrec RECORD;

BEGIN
	FOR myrec IN EXECUTE 'SELECT extent("' || columnname || '") FROM "' || tablename || '"' LOOP
		return myrec.extent;
	END LOOP;
END;
$_$;


ALTER FUNCTION public.find_extent(text, text) OWNER TO postgres;

--
-- TOC entry 157 (class 1255 OID 18510)
-- Dependencies: 6 1170 1087
-- Name: find_extent(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION find_extent(text, text, text) RETURNS box2d
    LANGUAGE plpgsql IMMUTABLE STRICT
    AS $_$
DECLARE
	schemaname alias for $1;
	tablename alias for $2;
	columnname alias for $3;
	myrec RECORD;

BEGIN
	FOR myrec IN EXECUTE 'SELECT extent("' || columnname || '") FROM "' || schemaname || '"."' || tablename || '"' LOOP
		return myrec.extent;
	END LOOP;
END;
$_$;


ALTER FUNCTION public.find_extent(text, text, text) OWNER TO postgres;

--
-- TOC entry 159 (class 1255 OID 18512)
-- Dependencies: 1170 6
-- Name: find_srid(character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION find_srid(character varying, character varying, character varying) RETURNS integer
    LANGUAGE plpgsql IMMUTABLE STRICT
    AS $_$
DECLARE
	schem text;
	tabl text;
	sr int4;
BEGIN
	IF $1 IS NULL THEN
	  RAISE EXCEPTION 'find_srid() - schema is NULL!';
	END IF;
	IF $2 IS NULL THEN
	  RAISE EXCEPTION 'find_srid() - table name is NULL!';
	END IF;
	IF $3 IS NULL THEN
	  RAISE EXCEPTION 'find_srid() - column name is NULL!';
	END IF;
	schem = $1;
	tabl = $2;
-- if the table contains a . and the schema is empty
-- split the table into a schema and a table
-- otherwise drop through to default behavior
	IF ( schem = '' and tabl LIKE '%.%' ) THEN
	 schem = substr(tabl,1,strpos(tabl,'.')-1);
	 tabl = substr(tabl,length(schem)+2);
	ELSE
	 schem = schem || '%';
	END IF;

	select SRID into sr from geometry_columns where f_table_schema like schem and f_table_name = tabl and f_geometry_column = $3;
	IF NOT FOUND THEN
	   RAISE EXCEPTION 'find_srid() - couldnt find the corresponding SRID - is the geometry registered in the GEOMETRY_COLUMNS table?  Is there an uppercase/lowercase missmatch?';
	END IF;
	return sr;
END;
$_$;


ALTER FUNCTION public.find_srid(character varying, character varying, character varying) OWNER TO postgres;

--
-- TOC entry 160 (class 1255 OID 18513)
-- Dependencies: 1170 6
-- Name: fix_geometry_columns(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION fix_geometry_columns() RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
	mislinked record;
	result text;
	linked integer;
	deleted integer;
	foundschema integer;
BEGIN

	-- Since 7.3 schema support has been added.
	-- Previous postgis versions used to put the database name in
	-- the schema column. This needs to be fixed, so we try to
	-- set the correct schema for each geometry_colums record
	-- looking at table, column, type and srid.
	UPDATE geometry_columns SET f_table_schema = n.nspname
		FROM pg_namespace n, pg_class c, pg_attribute a,
			pg_constraint sridcheck, pg_constraint typecheck
			WHERE ( f_table_schema is NULL
		OR f_table_schema = ''
			OR f_table_schema NOT IN (
					SELECT nspname::varchar
					FROM pg_namespace nn, pg_class cc, pg_attribute aa
					WHERE cc.relnamespace = nn.oid
					AND cc.relname = f_table_name::name
					AND aa.attrelid = cc.oid
					AND aa.attname = f_geometry_column::name))
			AND f_table_name::name = c.relname
			AND c.oid = a.attrelid
			AND c.relnamespace = n.oid
			AND f_geometry_column::name = a.attname

			AND sridcheck.conrelid = c.oid
		AND sridcheck.consrc LIKE '(srid(% = %)'
			AND sridcheck.consrc ~ textcat(' = ', srid::text)

			AND typecheck.conrelid = c.oid
		AND typecheck.consrc LIKE
		'((geometrytype(%) = ''%''::text) OR (% IS NULL))'
			AND typecheck.consrc ~ textcat(' = ''', type::text)

			AND NOT EXISTS (
					SELECT oid FROM geometry_columns gc
					WHERE c.relname::varchar = gc.f_table_name
					AND n.nspname::varchar = gc.f_table_schema
					AND a.attname::varchar = gc.f_geometry_column
			);

	GET DIAGNOSTICS foundschema = ROW_COUNT;

	-- no linkage to system table needed
	return 'fixed:'||foundschema::text;

END;
$$;


ALTER FUNCTION public.fix_geometry_columns() OWNER TO postgres;

--
-- TOC entry 161 (class 1255 OID 18514)
-- Dependencies: 1102 1102 6
-- Name: force_2d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION force_2d(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_force_2d';


ALTER FUNCTION public.force_2d(geometry) OWNER TO postgres;

--
-- TOC entry 162 (class 1255 OID 18515)
-- Dependencies: 1102 6 1102
-- Name: force_3d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION force_3d(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_force_3dz';


ALTER FUNCTION public.force_3d(geometry) OWNER TO postgres;

--
-- TOC entry 163 (class 1255 OID 18516)
-- Dependencies: 6 1102 1102
-- Name: force_3dm(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION force_3dm(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_force_3dm';


ALTER FUNCTION public.force_3dm(geometry) OWNER TO postgres;

--
-- TOC entry 164 (class 1255 OID 18517)
-- Dependencies: 6 1102 1102
-- Name: force_3dz(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION force_3dz(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_force_3dz';


ALTER FUNCTION public.force_3dz(geometry) OWNER TO postgres;

--
-- TOC entry 165 (class 1255 OID 18518)
-- Dependencies: 6 1102 1102
-- Name: force_4d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION force_4d(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_force_4d';


ALTER FUNCTION public.force_4d(geometry) OWNER TO postgres;

--
-- TOC entry 166 (class 1255 OID 18519)
-- Dependencies: 6 1102 1102
-- Name: force_collection(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION force_collection(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_force_collection';


ALTER FUNCTION public.force_collection(geometry) OWNER TO postgres;

--
-- TOC entry 167 (class 1255 OID 18520)
-- Dependencies: 6 1102 1102
-- Name: forcerhr(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION forcerhr(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_forceRHR_poly';


ALTER FUNCTION public.forcerhr(geometry) OWNER TO postgres;

--
-- TOC entry 169 (class 1255 OID 18522)
-- Dependencies: 6 1099 1102
-- Name: geography(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography(geometry) RETURNS geography
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_from_geometry';


ALTER FUNCTION public.geography(geometry) OWNER TO postgres;

--
-- TOC entry 168 (class 1255 OID 18521)
-- Dependencies: 6 1099 1099
-- Name: geography(geography, integer, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography(geography, integer, boolean) RETURNS geography
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_enforce_typmod';


ALTER FUNCTION public.geography(geography, integer, boolean) OWNER TO postgres;

--
-- TOC entry 170 (class 1255 OID 18523)
-- Dependencies: 6 1099 1099
-- Name: geography_cmp(geography, geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_cmp(geography, geography) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_cmp';


ALTER FUNCTION public.geography_cmp(geography, geography) OWNER TO postgres;

--
-- TOC entry 171 (class 1255 OID 18524)
-- Dependencies: 6 1099 1099
-- Name: geography_eq(geography, geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_eq(geography, geography) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_eq';


ALTER FUNCTION public.geography_eq(geography, geography) OWNER TO postgres;

--
-- TOC entry 172 (class 1255 OID 18525)
-- Dependencies: 6 1099 1099
-- Name: geography_ge(geography, geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_ge(geography, geography) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_ge';


ALTER FUNCTION public.geography_ge(geography, geography) OWNER TO postgres;

--
-- TOC entry 173 (class 1255 OID 18526)
-- Dependencies: 6
-- Name: geography_gist_compress(internal); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_gist_compress(internal) RETURNS internal
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'geography_gist_compress';


ALTER FUNCTION public.geography_gist_compress(internal) OWNER TO postgres;

--
-- TOC entry 174 (class 1255 OID 18527)
-- Dependencies: 6 1102
-- Name: geography_gist_consistent(internal, geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_gist_consistent(internal, geometry, integer) RETURNS boolean
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'geography_gist_consistent';


ALTER FUNCTION public.geography_gist_consistent(internal, geometry, integer) OWNER TO postgres;

--
-- TOC entry 175 (class 1255 OID 18528)
-- Dependencies: 6
-- Name: geography_gist_decompress(internal); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_gist_decompress(internal) RETURNS internal
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'geography_gist_decompress';


ALTER FUNCTION public.geography_gist_decompress(internal) OWNER TO postgres;

--
-- TOC entry 176 (class 1255 OID 18529)
-- Dependencies: 6
-- Name: geography_gist_join_selectivity(internal, oid, internal, smallint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_gist_join_selectivity(internal, oid, internal, smallint) RETURNS double precision
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'geography_gist_join_selectivity';


ALTER FUNCTION public.geography_gist_join_selectivity(internal, oid, internal, smallint) OWNER TO postgres;

--
-- TOC entry 177 (class 1255 OID 18530)
-- Dependencies: 6
-- Name: geography_gist_penalty(internal, internal, internal); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_gist_penalty(internal, internal, internal) RETURNS internal
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'geography_gist_penalty';


ALTER FUNCTION public.geography_gist_penalty(internal, internal, internal) OWNER TO postgres;

--
-- TOC entry 178 (class 1255 OID 18531)
-- Dependencies: 6
-- Name: geography_gist_picksplit(internal, internal); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_gist_picksplit(internal, internal) RETURNS internal
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'geography_gist_picksplit';


ALTER FUNCTION public.geography_gist_picksplit(internal, internal) OWNER TO postgres;

--
-- TOC entry 179 (class 1255 OID 18532)
-- Dependencies: 6 1087 1087
-- Name: geography_gist_same(box2d, box2d, internal); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_gist_same(box2d, box2d, internal) RETURNS internal
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'geography_gist_same';


ALTER FUNCTION public.geography_gist_same(box2d, box2d, internal) OWNER TO postgres;

--
-- TOC entry 180 (class 1255 OID 18533)
-- Dependencies: 6
-- Name: geography_gist_selectivity(internal, oid, internal, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_gist_selectivity(internal, oid, internal, integer) RETURNS double precision
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'geography_gist_selectivity';


ALTER FUNCTION public.geography_gist_selectivity(internal, oid, internal, integer) OWNER TO postgres;

--
-- TOC entry 181 (class 1255 OID 18534)
-- Dependencies: 6
-- Name: geography_gist_union(bytea, internal); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_gist_union(bytea, internal) RETURNS internal
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'geography_gist_union';


ALTER FUNCTION public.geography_gist_union(bytea, internal) OWNER TO postgres;

--
-- TOC entry 182 (class 1255 OID 18535)
-- Dependencies: 6 1099 1099
-- Name: geography_gt(geography, geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_gt(geography, geography) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_gt';


ALTER FUNCTION public.geography_gt(geography, geography) OWNER TO postgres;

--
-- TOC entry 183 (class 1255 OID 18536)
-- Dependencies: 1099 1099 6
-- Name: geography_le(geography, geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_le(geography, geography) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_le';


ALTER FUNCTION public.geography_le(geography, geography) OWNER TO postgres;

--
-- TOC entry 184 (class 1255 OID 18537)
-- Dependencies: 1099 1099 6
-- Name: geography_lt(geography, geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_lt(geography, geography) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_lt';


ALTER FUNCTION public.geography_lt(geography, geography) OWNER TO postgres;

--
-- TOC entry 185 (class 1255 OID 18538)
-- Dependencies: 1099 1099 6
-- Name: geography_overlaps(geography, geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_overlaps(geography, geography) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_overlaps';


ALTER FUNCTION public.geography_overlaps(geography, geography) OWNER TO postgres;

--
-- TOC entry 186 (class 1255 OID 18539)
-- Dependencies: 6
-- Name: geography_typmod_dims(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_typmod_dims(integer) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_typmod_dims';


ALTER FUNCTION public.geography_typmod_dims(integer) OWNER TO postgres;

--
-- TOC entry 187 (class 1255 OID 18540)
-- Dependencies: 6
-- Name: geography_typmod_srid(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_typmod_srid(integer) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_typmod_srid';


ALTER FUNCTION public.geography_typmod_srid(integer) OWNER TO postgres;

--
-- TOC entry 188 (class 1255 OID 18541)
-- Dependencies: 6
-- Name: geography_typmod_type(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geography_typmod_type(integer) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_typmod_type';


ALTER FUNCTION public.geography_typmod_type(integer) OWNER TO postgres;

--
-- TOC entry 190 (class 1255 OID 18543)
-- Dependencies: 6 1102
-- Name: geomcollfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geomcollfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE
	WHEN geometrytype(GeomFromText($1)) = 'GEOMETRYCOLLECTION'
	THEN GeomFromText($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.geomcollfromtext(text) OWNER TO postgres;

--
-- TOC entry 189 (class 1255 OID 18542)
-- Dependencies: 6 1102
-- Name: geomcollfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geomcollfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE
	WHEN geometrytype(GeomFromText($1, $2)) = 'GEOMETRYCOLLECTION'
	THEN GeomFromText($1,$2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.geomcollfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 192 (class 1255 OID 18545)
-- Dependencies: 6 1102
-- Name: geomcollfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geomcollfromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE
	WHEN geometrytype(GeomFromWKB($1)) = 'GEOMETRYCOLLECTION'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.geomcollfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 191 (class 1255 OID 18544)
-- Dependencies: 6 1102
-- Name: geomcollfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geomcollfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE
	WHEN geometrytype(GeomFromWKB($1, $2)) = 'GEOMETRYCOLLECTION'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.geomcollfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 193 (class 1255 OID 18546)
-- Dependencies: 6 1093 1102
-- Name: geometry(box3d_extent); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry(box3d_extent) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_to_LWGEOM';


ALTER FUNCTION public.geometry(box3d_extent) OWNER TO postgres;

--
-- TOC entry 194 (class 1255 OID 18547)
-- Dependencies: 6 1102 1087
-- Name: geometry(box2d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry(box2d) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX2DFLOAT4_to_LWGEOM';


ALTER FUNCTION public.geometry(box2d) OWNER TO postgres;

--
-- TOC entry 195 (class 1255 OID 18548)
-- Dependencies: 6 1102 1090
-- Name: geometry(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry(box3d) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_to_LWGEOM';


ALTER FUNCTION public.geometry(box3d) OWNER TO postgres;

--
-- TOC entry 196 (class 1255 OID 18549)
-- Dependencies: 6 1102
-- Name: geometry(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry(text) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'parse_WKT_lwgeom';


ALTER FUNCTION public.geometry(text) OWNER TO postgres;

--
-- TOC entry 197 (class 1255 OID 18550)
-- Dependencies: 6 1102 1096
-- Name: geometry(chip); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry(chip) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_to_LWGEOM';


ALTER FUNCTION public.geometry(chip) OWNER TO postgres;

--
-- TOC entry 198 (class 1255 OID 18551)
-- Dependencies: 6 1102
-- Name: geometry(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry(bytea) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_from_bytea';


ALTER FUNCTION public.geometry(bytea) OWNER TO postgres;

--
-- TOC entry 199 (class 1255 OID 18552)
-- Dependencies: 6 1102 1099
-- Name: geometry(geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry(geography) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geometry_from_geography';


ALTER FUNCTION public.geometry(geography) OWNER TO postgres;

--
-- TOC entry 200 (class 1255 OID 18553)
-- Dependencies: 6 1102 1102
-- Name: geometry_above(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_above(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_above';


ALTER FUNCTION public.geometry_above(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 201 (class 1255 OID 18554)
-- Dependencies: 6 1102 1102
-- Name: geometry_below(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_below(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_below';


ALTER FUNCTION public.geometry_below(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 202 (class 1255 OID 18555)
-- Dependencies: 6 1102 1102
-- Name: geometry_cmp(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_cmp(geometry, geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'lwgeom_cmp';


ALTER FUNCTION public.geometry_cmp(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 203 (class 1255 OID 18556)
-- Dependencies: 6 1102 1102
-- Name: geometry_contain(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_contain(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_contain';


ALTER FUNCTION public.geometry_contain(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 204 (class 1255 OID 18557)
-- Dependencies: 1102 1102 6
-- Name: geometry_contained(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_contained(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_contained';


ALTER FUNCTION public.geometry_contained(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 205 (class 1255 OID 18558)
-- Dependencies: 1102 1102 6
-- Name: geometry_eq(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_eq(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'lwgeom_eq';


ALTER FUNCTION public.geometry_eq(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 206 (class 1255 OID 18559)
-- Dependencies: 6 1102 1102
-- Name: geometry_ge(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_ge(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'lwgeom_ge';


ALTER FUNCTION public.geometry_ge(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 207 (class 1255 OID 18560)
-- Dependencies: 6
-- Name: geometry_gist_joinsel(internal, oid, internal, smallint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_gist_joinsel(internal, oid, internal, smallint) RETURNS double precision
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'LWGEOM_gist_joinsel';


ALTER FUNCTION public.geometry_gist_joinsel(internal, oid, internal, smallint) OWNER TO postgres;

--
-- TOC entry 208 (class 1255 OID 18561)
-- Dependencies: 6
-- Name: geometry_gist_sel(internal, oid, internal, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_gist_sel(internal, oid, internal, integer) RETURNS double precision
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'LWGEOM_gist_sel';


ALTER FUNCTION public.geometry_gist_sel(internal, oid, internal, integer) OWNER TO postgres;

--
-- TOC entry 209 (class 1255 OID 18562)
-- Dependencies: 1102 6 1102
-- Name: geometry_gt(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_gt(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'lwgeom_gt';


ALTER FUNCTION public.geometry_gt(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 210 (class 1255 OID 18563)
-- Dependencies: 6 1102 1102
-- Name: geometry_le(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_le(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'lwgeom_le';


ALTER FUNCTION public.geometry_le(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 211 (class 1255 OID 18564)
-- Dependencies: 1102 1102 6
-- Name: geometry_left(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_left(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_left';


ALTER FUNCTION public.geometry_left(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 212 (class 1255 OID 18565)
-- Dependencies: 6 1102 1102
-- Name: geometry_lt(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_lt(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'lwgeom_lt';


ALTER FUNCTION public.geometry_lt(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 213 (class 1255 OID 18566)
-- Dependencies: 1102 6 1102
-- Name: geometry_overabove(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_overabove(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_overabove';


ALTER FUNCTION public.geometry_overabove(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 214 (class 1255 OID 18567)
-- Dependencies: 1102 1102 6
-- Name: geometry_overbelow(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_overbelow(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_overbelow';


ALTER FUNCTION public.geometry_overbelow(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 215 (class 1255 OID 18568)
-- Dependencies: 6 1102 1102
-- Name: geometry_overlap(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_overlap(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_overlap';


ALTER FUNCTION public.geometry_overlap(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 216 (class 1255 OID 18569)
-- Dependencies: 1102 6 1102
-- Name: geometry_overleft(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_overleft(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_overleft';


ALTER FUNCTION public.geometry_overleft(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 217 (class 1255 OID 18570)
-- Dependencies: 1102 6 1102
-- Name: geometry_overright(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_overright(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_overright';


ALTER FUNCTION public.geometry_overright(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 218 (class 1255 OID 18571)
-- Dependencies: 6 1102 1102
-- Name: geometry_right(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_right(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_right';


ALTER FUNCTION public.geometry_right(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 219 (class 1255 OID 18572)
-- Dependencies: 1102 6 1102
-- Name: geometry_same(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_same(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_samebox';


ALTER FUNCTION public.geometry_same(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 220 (class 1255 OID 18573)
-- Dependencies: 6 1102 1102
-- Name: geometry_samebox(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometry_samebox(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_samebox';


ALTER FUNCTION public.geometry_samebox(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 221 (class 1255 OID 18574)
-- Dependencies: 6 1102
-- Name: geometryfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometryfromtext(text) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_from_text';


ALTER FUNCTION public.geometryfromtext(text) OWNER TO postgres;

--
-- TOC entry 222 (class 1255 OID 18575)
-- Dependencies: 6 1102
-- Name: geometryfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometryfromtext(text, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_from_text';


ALTER FUNCTION public.geometryfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 223 (class 1255 OID 18576)
-- Dependencies: 6 1102 1102
-- Name: geometryn(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometryn(geometry, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_geometryn_collection';


ALTER FUNCTION public.geometryn(geometry, integer) OWNER TO postgres;

--
-- TOC entry 224 (class 1255 OID 18577)
-- Dependencies: 6 1102
-- Name: geometrytype(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geometrytype(geometry) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_getTYPE';


ALTER FUNCTION public.geometrytype(geometry) OWNER TO postgres;

--
-- TOC entry 225 (class 1255 OID 18578)
-- Dependencies: 6 1102
-- Name: geomfromewkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geomfromewkb(bytea) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOMFromWKB';


ALTER FUNCTION public.geomfromewkb(bytea) OWNER TO postgres;

--
-- TOC entry 226 (class 1255 OID 18579)
-- Dependencies: 6 1102
-- Name: geomfromewkt(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geomfromewkt(text) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'parse_WKT_lwgeom';


ALTER FUNCTION public.geomfromewkt(text) OWNER TO postgres;

--
-- TOC entry 227 (class 1255 OID 18580)
-- Dependencies: 6 1102
-- Name: geomfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geomfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT geometryfromtext($1)$_$;


ALTER FUNCTION public.geomfromtext(text) OWNER TO postgres;

--
-- TOC entry 228 (class 1255 OID 18581)
-- Dependencies: 6 1102
-- Name: geomfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geomfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT geometryfromtext($1, $2)$_$;


ALTER FUNCTION public.geomfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 229 (class 1255 OID 18582)
-- Dependencies: 6 1102
-- Name: geomfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geomfromwkb(bytea) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_from_WKB';


ALTER FUNCTION public.geomfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 230 (class 1255 OID 18583)
-- Dependencies: 6 1102
-- Name: geomfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geomfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT setSRID(GeomFromWKB($1), $2)$_$;


ALTER FUNCTION public.geomfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 231 (class 1255 OID 18584)
-- Dependencies: 6 1102 1102 1102
-- Name: geomunion(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION geomunion(geometry, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geomunion';


ALTER FUNCTION public.geomunion(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 232 (class 1255 OID 18585)
-- Dependencies: 6 1170
-- Name: get_proj4_from_srid(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_proj4_from_srid(integer) RETURNS text
    LANGUAGE plpgsql IMMUTABLE STRICT
    AS $_$
BEGIN
	RETURN proj4text::text FROM spatial_ref_sys WHERE srid= $1;
END;
$_$;


ALTER FUNCTION public.get_proj4_from_srid(integer) OWNER TO postgres;

--
-- TOC entry 233 (class 1255 OID 18586)
-- Dependencies: 6 1087 1102
-- Name: getbbox(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getbbox(geometry) RETURNS box2d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_to_BOX2DFLOAT4';


ALTER FUNCTION public.getbbox(geometry) OWNER TO postgres;

--
-- TOC entry 234 (class 1255 OID 18587)
-- Dependencies: 6 1102
-- Name: getsrid(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getsrid(geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_getSRID';


ALTER FUNCTION public.getsrid(geometry) OWNER TO postgres;

--
-- TOC entry 235 (class 1255 OID 18588)
-- Dependencies: 6
-- Name: gettransactionid(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION gettransactionid() RETURNS xid
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'getTransactionID';


ALTER FUNCTION public.gettransactionid() OWNER TO postgres;

--
-- TOC entry 236 (class 1255 OID 18589)
-- Dependencies: 6 1102
-- Name: hasbbox(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION hasbbox(geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_hasBBOX';


ALTER FUNCTION public.hasbbox(geometry) OWNER TO postgres;

--
-- TOC entry 237 (class 1255 OID 18590)
-- Dependencies: 6 1096
-- Name: height(chip); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION height(chip) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_getHeight';


ALTER FUNCTION public.height(chip) OWNER TO postgres;

--
-- TOC entry 238 (class 1255 OID 18591)
-- Dependencies: 6 1102 1102
-- Name: interiorringn(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION interiorringn(geometry, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_interiorringn_polygon';


ALTER FUNCTION public.interiorringn(geometry, integer) OWNER TO postgres;

--
-- TOC entry 239 (class 1255 OID 18592)
-- Dependencies: 6 1102 1102 1102
-- Name: intersection(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION intersection(geometry, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'intersection';


ALTER FUNCTION public.intersection(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 240 (class 1255 OID 18593)
-- Dependencies: 6 1102 1102
-- Name: intersects(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION intersects(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'intersects';


ALTER FUNCTION public.intersects(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 241 (class 1255 OID 18594)
-- Dependencies: 6 1102
-- Name: isclosed(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION isclosed(geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_isclosed_linestring';


ALTER FUNCTION public.isclosed(geometry) OWNER TO postgres;

--
-- TOC entry 242 (class 1255 OID 18595)
-- Dependencies: 6 1102
-- Name: isempty(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION isempty(geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_isempty';


ALTER FUNCTION public.isempty(geometry) OWNER TO postgres;

--
-- TOC entry 243 (class 1255 OID 18596)
-- Dependencies: 6 1102
-- Name: isring(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION isring(geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'isring';


ALTER FUNCTION public.isring(geometry) OWNER TO postgres;

--
-- TOC entry 244 (class 1255 OID 18597)
-- Dependencies: 6 1102
-- Name: issimple(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION issimple(geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'issimple';


ALTER FUNCTION public.issimple(geometry) OWNER TO postgres;

--
-- TOC entry 245 (class 1255 OID 18598)
-- Dependencies: 6 1102
-- Name: isvalid(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION isvalid(geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'isvalid';


ALTER FUNCTION public.isvalid(geometry) OWNER TO postgres;

--
-- TOC entry 246 (class 1255 OID 18599)
-- Dependencies: 6 1102
-- Name: length(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION length(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_length_linestring';


ALTER FUNCTION public.length(geometry) OWNER TO postgres;

--
-- TOC entry 247 (class 1255 OID 18600)
-- Dependencies: 6 1102
-- Name: length2d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION length2d(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_length2d_linestring';


ALTER FUNCTION public.length2d(geometry) OWNER TO postgres;

--
-- TOC entry 248 (class 1255 OID 18601)
-- Dependencies: 6 1102 1113
-- Name: length2d_spheroid(geometry, spheroid); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION length2d_spheroid(geometry, spheroid) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'LWGEOM_length2d_ellipsoid';


ALTER FUNCTION public.length2d_spheroid(geometry, spheroid) OWNER TO postgres;

--
-- TOC entry 249 (class 1255 OID 18602)
-- Dependencies: 6 1102
-- Name: length3d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION length3d(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_length_linestring';


ALTER FUNCTION public.length3d(geometry) OWNER TO postgres;

--
-- TOC entry 250 (class 1255 OID 18603)
-- Dependencies: 6 1102 1113
-- Name: length3d_spheroid(geometry, spheroid); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION length3d_spheroid(geometry, spheroid) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_length_ellipsoid_linestring';


ALTER FUNCTION public.length3d_spheroid(geometry, spheroid) OWNER TO postgres;

--
-- TOC entry 251 (class 1255 OID 18604)
-- Dependencies: 6 1102 1113
-- Name: length_spheroid(geometry, spheroid); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION length_spheroid(geometry, spheroid) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'LWGEOM_length_ellipsoid_linestring';


ALTER FUNCTION public.length_spheroid(geometry, spheroid) OWNER TO postgres;

--
-- TOC entry 252 (class 1255 OID 18605)
-- Dependencies: 6 1102 1102
-- Name: line_interpolate_point(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION line_interpolate_point(geometry, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_line_interpolate_point';


ALTER FUNCTION public.line_interpolate_point(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 253 (class 1255 OID 18606)
-- Dependencies: 6 1102 1102
-- Name: line_locate_point(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION line_locate_point(geometry, geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_line_locate_point';


ALTER FUNCTION public.line_locate_point(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 254 (class 1255 OID 18607)
-- Dependencies: 6 1102 1102
-- Name: line_substring(geometry, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION line_substring(geometry, double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_line_substring';


ALTER FUNCTION public.line_substring(geometry, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 255 (class 1255 OID 18608)
-- Dependencies: 6 1102 1102
-- Name: linefrommultipoint(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION linefrommultipoint(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_line_from_mpoint';


ALTER FUNCTION public.linefrommultipoint(geometry) OWNER TO postgres;

--
-- TOC entry 256 (class 1255 OID 18609)
-- Dependencies: 6 1102
-- Name: linefromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION linefromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1)) = 'LINESTRING'
	THEN GeomFromText($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.linefromtext(text) OWNER TO postgres;

--
-- TOC entry 257 (class 1255 OID 18610)
-- Dependencies: 6 1102
-- Name: linefromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION linefromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1, $2)) = 'LINESTRING'
	THEN GeomFromText($1,$2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.linefromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 259 (class 1255 OID 18612)
-- Dependencies: 6 1102
-- Name: linefromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION linefromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'LINESTRING'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.linefromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 258 (class 1255 OID 18611)
-- Dependencies: 6 1102
-- Name: linefromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION linefromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1, $2)) = 'LINESTRING'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.linefromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 260 (class 1255 OID 18613)
-- Dependencies: 6 1102 1102
-- Name: linemerge(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION linemerge(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'linemerge';


ALTER FUNCTION public.linemerge(geometry) OWNER TO postgres;

--
-- TOC entry 261 (class 1255 OID 18614)
-- Dependencies: 1102 6
-- Name: linestringfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION linestringfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT LineFromText($1)$_$;


ALTER FUNCTION public.linestringfromtext(text) OWNER TO postgres;

--
-- TOC entry 262 (class 1255 OID 18615)
-- Dependencies: 6 1102
-- Name: linestringfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION linestringfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT LineFromText($1, $2)$_$;


ALTER FUNCTION public.linestringfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 264 (class 1255 OID 18617)
-- Dependencies: 1102 6
-- Name: linestringfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION linestringfromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'LINESTRING'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.linestringfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 263 (class 1255 OID 18616)
-- Dependencies: 1102 6
-- Name: linestringfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION linestringfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1, $2)) = 'LINESTRING'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.linestringfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 265 (class 1255 OID 18618)
-- Dependencies: 1102 6 1102
-- Name: locate_along_measure(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION locate_along_measure(geometry, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT locate_between_measures($1, $2, $2) $_$;


ALTER FUNCTION public.locate_along_measure(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 266 (class 1255 OID 18619)
-- Dependencies: 6 1102 1102
-- Name: locate_between_measures(geometry, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION locate_between_measures(geometry, double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_locate_between_m';


ALTER FUNCTION public.locate_between_measures(geometry, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 269 (class 1255 OID 18622)
-- Dependencies: 6
-- Name: lockrow(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION lockrow(text, text, text) RETURNS integer
    LANGUAGE sql STRICT
    AS $_$ SELECT LockRow(current_schema(), $1, $2, $3, now()::timestamp+'1:00'); $_$;


ALTER FUNCTION public.lockrow(text, text, text) OWNER TO postgres;

--
-- TOC entry 268 (class 1255 OID 18621)
-- Dependencies: 6
-- Name: lockrow(text, text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION lockrow(text, text, text, text) RETURNS integer
    LANGUAGE sql STRICT
    AS $_$ SELECT LockRow($1, $2, $3, $4, now()::timestamp+'1:00'); $_$;


ALTER FUNCTION public.lockrow(text, text, text, text) OWNER TO postgres;

--
-- TOC entry 270 (class 1255 OID 18623)
-- Dependencies: 6
-- Name: lockrow(text, text, text, timestamp without time zone); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION lockrow(text, text, text, timestamp without time zone) RETURNS integer
    LANGUAGE sql STRICT
    AS $_$ SELECT LockRow(current_schema(), $1, $2, $3, $4); $_$;


ALTER FUNCTION public.lockrow(text, text, text, timestamp without time zone) OWNER TO postgres;

--
-- TOC entry 267 (class 1255 OID 18620)
-- Dependencies: 6 1170
-- Name: lockrow(text, text, text, text, timestamp without time zone); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION lockrow(text, text, text, text, timestamp without time zone) RETURNS integer
    LANGUAGE plpgsql STRICT
    AS $_$ 
DECLARE
	myschema alias for $1;
	mytable alias for $2;
	myrid   alias for $3;
	authid alias for $4;
	expires alias for $5;
	ret int;
	mytoid oid;
	myrec RECORD;
	
BEGIN

	IF NOT LongTransactionsEnabled() THEN
		RAISE EXCEPTION 'Long transaction support disabled, use EnableLongTransaction() to enable.';
	END IF;

	EXECUTE 'DELETE FROM authorization_table WHERE expires < now()'; 

	SELECT c.oid INTO mytoid FROM pg_class c, pg_namespace n
		WHERE c.relname = mytable
		AND c.relnamespace = n.oid
		AND n.nspname = myschema;

	-- RAISE NOTICE 'toid: %', mytoid;

	FOR myrec IN SELECT * FROM authorization_table WHERE 
		toid = mytoid AND rid = myrid
	LOOP
		IF myrec.authid != authid THEN
			RETURN 0;
		ELSE
			RETURN 1;
		END IF;
	END LOOP;

	EXECUTE 'INSERT INTO authorization_table VALUES ('||
		quote_literal(mytoid::text)||','||quote_literal(myrid)||
		','||quote_literal(expires::text)||
		','||quote_literal(authid) ||')';

	GET DIAGNOSTICS ret = ROW_COUNT;

	RETURN ret;
END;
$_$;


ALTER FUNCTION public.lockrow(text, text, text, text, timestamp without time zone) OWNER TO postgres;

--
-- TOC entry 271 (class 1255 OID 18624)
-- Dependencies: 1170 6
-- Name: longtransactionsenabled(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION longtransactionsenabled() RETURNS boolean
    LANGUAGE plpgsql
    AS $$ 
DECLARE
	rec RECORD;
BEGIN
	FOR rec IN SELECT oid FROM pg_class WHERE relname = 'authorized_tables'
	LOOP
		return 't';
	END LOOP;
	return 'f';
END;
$$;


ALTER FUNCTION public.longtransactionsenabled() OWNER TO postgres;

--
-- TOC entry 272 (class 1255 OID 18625)
-- Dependencies: 6
-- Name: lwgeom_gist_compress(internal); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION lwgeom_gist_compress(internal) RETURNS internal
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'LWGEOM_gist_compress';


ALTER FUNCTION public.lwgeom_gist_compress(internal) OWNER TO postgres;

--
-- TOC entry 273 (class 1255 OID 18626)
-- Dependencies: 6 1102
-- Name: lwgeom_gist_consistent(internal, geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION lwgeom_gist_consistent(internal, geometry, integer) RETURNS boolean
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'LWGEOM_gist_consistent';


ALTER FUNCTION public.lwgeom_gist_consistent(internal, geometry, integer) OWNER TO postgres;

--
-- TOC entry 274 (class 1255 OID 18627)
-- Dependencies: 6
-- Name: lwgeom_gist_decompress(internal); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION lwgeom_gist_decompress(internal) RETURNS internal
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'LWGEOM_gist_decompress';


ALTER FUNCTION public.lwgeom_gist_decompress(internal) OWNER TO postgres;

--
-- TOC entry 275 (class 1255 OID 18628)
-- Dependencies: 6
-- Name: lwgeom_gist_penalty(internal, internal, internal); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION lwgeom_gist_penalty(internal, internal, internal) RETURNS internal
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'LWGEOM_gist_penalty';


ALTER FUNCTION public.lwgeom_gist_penalty(internal, internal, internal) OWNER TO postgres;

--
-- TOC entry 276 (class 1255 OID 18629)
-- Dependencies: 6
-- Name: lwgeom_gist_picksplit(internal, internal); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION lwgeom_gist_picksplit(internal, internal) RETURNS internal
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'LWGEOM_gist_picksplit';


ALTER FUNCTION public.lwgeom_gist_picksplit(internal, internal) OWNER TO postgres;

--
-- TOC entry 277 (class 1255 OID 18630)
-- Dependencies: 6 1087 1087
-- Name: lwgeom_gist_same(box2d, box2d, internal); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION lwgeom_gist_same(box2d, box2d, internal) RETURNS internal
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'LWGEOM_gist_same';


ALTER FUNCTION public.lwgeom_gist_same(box2d, box2d, internal) OWNER TO postgres;

--
-- TOC entry 278 (class 1255 OID 18631)
-- Dependencies: 6
-- Name: lwgeom_gist_union(bytea, internal); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION lwgeom_gist_union(bytea, internal) RETURNS internal
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'LWGEOM_gist_union';


ALTER FUNCTION public.lwgeom_gist_union(bytea, internal) OWNER TO postgres;

--
-- TOC entry 279 (class 1255 OID 18632)
-- Dependencies: 6 1102
-- Name: m(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION m(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_m_point';


ALTER FUNCTION public.m(geometry) OWNER TO postgres;

--
-- TOC entry 280 (class 1255 OID 18633)
-- Dependencies: 6 1102 1102 1087
-- Name: makebox2d(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION makebox2d(geometry, geometry) RETURNS box2d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX2DFLOAT4_construct';


ALTER FUNCTION public.makebox2d(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 281 (class 1255 OID 18634)
-- Dependencies: 1090 1102 6 1102
-- Name: makebox3d(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION makebox3d(geometry, geometry) RETURNS box3d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_construct';


ALTER FUNCTION public.makebox3d(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 282 (class 1255 OID 18635)
-- Dependencies: 1102 6 1102 1102
-- Name: makeline(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION makeline(geometry, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_makeline';


ALTER FUNCTION public.makeline(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 283 (class 1255 OID 18636)
-- Dependencies: 1102 6 1104
-- Name: makeline_garray(geometry[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION makeline_garray(geometry[]) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_makeline_garray';


ALTER FUNCTION public.makeline_garray(geometry[]) OWNER TO postgres;

--
-- TOC entry 284 (class 1255 OID 18637)
-- Dependencies: 1102 6
-- Name: makepoint(double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION makepoint(double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_makepoint';


ALTER FUNCTION public.makepoint(double precision, double precision) OWNER TO postgres;

--
-- TOC entry 285 (class 1255 OID 18638)
-- Dependencies: 6 1102
-- Name: makepoint(double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION makepoint(double precision, double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_makepoint';


ALTER FUNCTION public.makepoint(double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 286 (class 1255 OID 18639)
-- Dependencies: 6 1102
-- Name: makepoint(double precision, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION makepoint(double precision, double precision, double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_makepoint';


ALTER FUNCTION public.makepoint(double precision, double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 287 (class 1255 OID 18640)
-- Dependencies: 1102 6
-- Name: makepointm(double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION makepointm(double precision, double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_makepoint3dm';


ALTER FUNCTION public.makepointm(double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 289 (class 1255 OID 18642)
-- Dependencies: 1102 6 1102
-- Name: makepolygon(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION makepolygon(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_makepoly';


ALTER FUNCTION public.makepolygon(geometry) OWNER TO postgres;

--
-- TOC entry 288 (class 1255 OID 18641)
-- Dependencies: 6 1104 1102 1102
-- Name: makepolygon(geometry, geometry[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION makepolygon(geometry, geometry[]) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_makepoly';


ALTER FUNCTION public.makepolygon(geometry, geometry[]) OWNER TO postgres;

--
-- TOC entry 290 (class 1255 OID 18643)
-- Dependencies: 1102 6 1102
-- Name: max_distance(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION max_distance(geometry, geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_maxdistance2d_linestring';


ALTER FUNCTION public.max_distance(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 291 (class 1255 OID 18644)
-- Dependencies: 6 1102
-- Name: mem_size(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION mem_size(geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_mem_size';


ALTER FUNCTION public.mem_size(geometry) OWNER TO postgres;

--
-- TOC entry 293 (class 1255 OID 18646)
-- Dependencies: 6 1102
-- Name: mlinefromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION mlinefromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1)) = 'MULTILINESTRING'
	THEN GeomFromText($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.mlinefromtext(text) OWNER TO postgres;

--
-- TOC entry 292 (class 1255 OID 18645)
-- Dependencies: 6 1102
-- Name: mlinefromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION mlinefromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE
	WHEN geometrytype(GeomFromText($1, $2)) = 'MULTILINESTRING'
	THEN GeomFromText($1,$2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.mlinefromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 295 (class 1255 OID 18648)
-- Dependencies: 1102 6
-- Name: mlinefromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION mlinefromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'MULTILINESTRING'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.mlinefromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 294 (class 1255 OID 18647)
-- Dependencies: 6 1102
-- Name: mlinefromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION mlinefromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1, $2)) = 'MULTILINESTRING'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.mlinefromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 297 (class 1255 OID 18650)
-- Dependencies: 6 1102
-- Name: mpointfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION mpointfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1)) = 'MULTIPOINT'
	THEN GeomFromText($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.mpointfromtext(text) OWNER TO postgres;

--
-- TOC entry 296 (class 1255 OID 18649)
-- Dependencies: 6 1102
-- Name: mpointfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION mpointfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1,$2)) = 'MULTIPOINT'
	THEN GeomFromText($1,$2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.mpointfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 299 (class 1255 OID 18652)
-- Dependencies: 1102 6
-- Name: mpointfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION mpointfromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'MULTIPOINT'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.mpointfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 298 (class 1255 OID 18651)
-- Dependencies: 1102 6
-- Name: mpointfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION mpointfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1,$2)) = 'MULTIPOINT'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.mpointfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 301 (class 1255 OID 18654)
-- Dependencies: 6 1102
-- Name: mpolyfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION mpolyfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1)) = 'MULTIPOLYGON'
	THEN GeomFromText($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.mpolyfromtext(text) OWNER TO postgres;

--
-- TOC entry 300 (class 1255 OID 18653)
-- Dependencies: 6 1102
-- Name: mpolyfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION mpolyfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1, $2)) = 'MULTIPOLYGON'
	THEN GeomFromText($1,$2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.mpolyfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 303 (class 1255 OID 18656)
-- Dependencies: 1102 6
-- Name: mpolyfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION mpolyfromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'MULTIPOLYGON'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.mpolyfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 302 (class 1255 OID 18655)
-- Dependencies: 6 1102
-- Name: mpolyfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION mpolyfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1, $2)) = 'MULTIPOLYGON'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.mpolyfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 304 (class 1255 OID 18657)
-- Dependencies: 6 1102 1102
-- Name: multi(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION multi(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_force_multi';


ALTER FUNCTION public.multi(geometry) OWNER TO postgres;

--
-- TOC entry 306 (class 1255 OID 18659)
-- Dependencies: 6 1102
-- Name: multilinefromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION multilinefromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'MULTILINESTRING'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.multilinefromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 305 (class 1255 OID 18658)
-- Dependencies: 6 1102
-- Name: multilinefromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION multilinefromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1, $2)) = 'MULTILINESTRING'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.multilinefromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 307 (class 1255 OID 18660)
-- Dependencies: 6 1102
-- Name: multilinestringfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION multilinestringfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT ST_MLineFromText($1)$_$;


ALTER FUNCTION public.multilinestringfromtext(text) OWNER TO postgres;

--
-- TOC entry 308 (class 1255 OID 18661)
-- Dependencies: 6 1102
-- Name: multilinestringfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION multilinestringfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT MLineFromText($1, $2)$_$;


ALTER FUNCTION public.multilinestringfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 310 (class 1255 OID 18663)
-- Dependencies: 6 1102
-- Name: multipointfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION multipointfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT MPointFromText($1)$_$;


ALTER FUNCTION public.multipointfromtext(text) OWNER TO postgres;

--
-- TOC entry 309 (class 1255 OID 18662)
-- Dependencies: 1102 6
-- Name: multipointfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION multipointfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT MPointFromText($1, $2)$_$;


ALTER FUNCTION public.multipointfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 312 (class 1255 OID 18665)
-- Dependencies: 6 1102
-- Name: multipointfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION multipointfromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'MULTIPOINT'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.multipointfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 311 (class 1255 OID 18664)
-- Dependencies: 6 1102
-- Name: multipointfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION multipointfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1,$2)) = 'MULTIPOINT'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.multipointfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 314 (class 1255 OID 18667)
-- Dependencies: 6 1102
-- Name: multipolyfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION multipolyfromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'MULTIPOLYGON'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.multipolyfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 313 (class 1255 OID 18666)
-- Dependencies: 1102 6
-- Name: multipolyfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION multipolyfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1, $2)) = 'MULTIPOLYGON'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.multipolyfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 316 (class 1255 OID 18669)
-- Dependencies: 1102 6
-- Name: multipolygonfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION multipolygonfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT MPolyFromText($1)$_$;


ALTER FUNCTION public.multipolygonfromtext(text) OWNER TO postgres;

--
-- TOC entry 315 (class 1255 OID 18668)
-- Dependencies: 1102 6
-- Name: multipolygonfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION multipolygonfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT MPolyFromText($1, $2)$_$;


ALTER FUNCTION public.multipolygonfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 317 (class 1255 OID 18670)
-- Dependencies: 6 1102
-- Name: ndims(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION ndims(geometry) RETURNS smallint
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_ndims';


ALTER FUNCTION public.ndims(geometry) OWNER TO postgres;

--
-- TOC entry 318 (class 1255 OID 18671)
-- Dependencies: 1102 6 1102
-- Name: noop(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION noop(geometry) RETURNS geometry
    LANGUAGE c STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_noop';


ALTER FUNCTION public.noop(geometry) OWNER TO postgres;

--
-- TOC entry 319 (class 1255 OID 18672)
-- Dependencies: 1102 6
-- Name: npoints(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION npoints(geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_npoints';


ALTER FUNCTION public.npoints(geometry) OWNER TO postgres;

--
-- TOC entry 320 (class 1255 OID 18673)
-- Dependencies: 6 1102
-- Name: nrings(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nrings(geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_nrings';


ALTER FUNCTION public.nrings(geometry) OWNER TO postgres;

--
-- TOC entry 321 (class 1255 OID 18674)
-- Dependencies: 1102 6
-- Name: numgeometries(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION numgeometries(geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_numgeometries_collection';


ALTER FUNCTION public.numgeometries(geometry) OWNER TO postgres;

--
-- TOC entry 322 (class 1255 OID 18675)
-- Dependencies: 6 1102
-- Name: numinteriorring(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION numinteriorring(geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_numinteriorrings_polygon';


ALTER FUNCTION public.numinteriorring(geometry) OWNER TO postgres;

--
-- TOC entry 323 (class 1255 OID 18676)
-- Dependencies: 1102 6
-- Name: numinteriorrings(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION numinteriorrings(geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_numinteriorrings_polygon';


ALTER FUNCTION public.numinteriorrings(geometry) OWNER TO postgres;

--
-- TOC entry 324 (class 1255 OID 18677)
-- Dependencies: 1102 6
-- Name: numpoints(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION numpoints(geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_numpoints_linestring';


ALTER FUNCTION public.numpoints(geometry) OWNER TO postgres;

--
-- TOC entry 325 (class 1255 OID 18678)
-- Dependencies: 6 1102 1102
-- Name: overlaps(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION "overlaps"(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'overlaps';


ALTER FUNCTION public."overlaps"(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 326 (class 1255 OID 18679)
-- Dependencies: 6 1102
-- Name: perimeter(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION perimeter(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_perimeter_poly';


ALTER FUNCTION public.perimeter(geometry) OWNER TO postgres;

--
-- TOC entry 327 (class 1255 OID 18680)
-- Dependencies: 6 1102
-- Name: perimeter2d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION perimeter2d(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_perimeter2d_poly';


ALTER FUNCTION public.perimeter2d(geometry) OWNER TO postgres;

--
-- TOC entry 328 (class 1255 OID 18681)
-- Dependencies: 1102 6
-- Name: perimeter3d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION perimeter3d(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_perimeter_poly';


ALTER FUNCTION public.perimeter3d(geometry) OWNER TO postgres;

--
-- TOC entry 329 (class 1255 OID 18682)
-- Dependencies: 1104 6 1110
-- Name: pgis_geometry_accum_finalfn(pgis_abs); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgis_geometry_accum_finalfn(pgis_abs) RETURNS geometry[]
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'pgis_geometry_accum_finalfn';


ALTER FUNCTION public.pgis_geometry_accum_finalfn(pgis_abs) OWNER TO postgres;

--
-- TOC entry 330 (class 1255 OID 18683)
-- Dependencies: 6 1110 1110 1102
-- Name: pgis_geometry_accum_transfn(pgis_abs, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgis_geometry_accum_transfn(pgis_abs, geometry) RETURNS pgis_abs
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'pgis_geometry_accum_transfn';


ALTER FUNCTION public.pgis_geometry_accum_transfn(pgis_abs, geometry) OWNER TO postgres;

--
-- TOC entry 331 (class 1255 OID 18684)
-- Dependencies: 1102 6 1110
-- Name: pgis_geometry_collect_finalfn(pgis_abs); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgis_geometry_collect_finalfn(pgis_abs) RETURNS geometry
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'pgis_geometry_collect_finalfn';


ALTER FUNCTION public.pgis_geometry_collect_finalfn(pgis_abs) OWNER TO postgres;

--
-- TOC entry 332 (class 1255 OID 18685)
-- Dependencies: 6 1102 1110
-- Name: pgis_geometry_makeline_finalfn(pgis_abs); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgis_geometry_makeline_finalfn(pgis_abs) RETURNS geometry
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'pgis_geometry_makeline_finalfn';


ALTER FUNCTION public.pgis_geometry_makeline_finalfn(pgis_abs) OWNER TO postgres;

--
-- TOC entry 333 (class 1255 OID 18686)
-- Dependencies: 1110 6 1102
-- Name: pgis_geometry_polygonize_finalfn(pgis_abs); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgis_geometry_polygonize_finalfn(pgis_abs) RETURNS geometry
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'pgis_geometry_polygonize_finalfn';


ALTER FUNCTION public.pgis_geometry_polygonize_finalfn(pgis_abs) OWNER TO postgres;

--
-- TOC entry 334 (class 1255 OID 18687)
-- Dependencies: 1102 6 1110
-- Name: pgis_geometry_union_finalfn(pgis_abs); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pgis_geometry_union_finalfn(pgis_abs) RETURNS geometry
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'pgis_geometry_union_finalfn';


ALTER FUNCTION public.pgis_geometry_union_finalfn(pgis_abs) OWNER TO postgres;

--
-- TOC entry 335 (class 1255 OID 18688)
-- Dependencies: 6 1102
-- Name: point_inside_circle(geometry, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION point_inside_circle(geometry, double precision, double precision, double precision) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_inside_circle_point';


ALTER FUNCTION public.point_inside_circle(geometry, double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 336 (class 1255 OID 18689)
-- Dependencies: 1102 6
-- Name: pointfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pointfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1)) = 'POINT'
	THEN GeomFromText($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.pointfromtext(text) OWNER TO postgres;

--
-- TOC entry 337 (class 1255 OID 18690)
-- Dependencies: 6 1102
-- Name: pointfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pointfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1, $2)) = 'POINT'
	THEN GeomFromText($1,$2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.pointfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 339 (class 1255 OID 18692)
-- Dependencies: 1102 6
-- Name: pointfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pointfromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'POINT'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.pointfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 338 (class 1255 OID 18691)
-- Dependencies: 6 1102
-- Name: pointfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pointfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1, $2)) = 'POINT'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.pointfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 340 (class 1255 OID 18693)
-- Dependencies: 1102 6 1102
-- Name: pointn(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pointn(geometry, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_pointn_linestring';


ALTER FUNCTION public.pointn(geometry, integer) OWNER TO postgres;

--
-- TOC entry 341 (class 1255 OID 18694)
-- Dependencies: 1102 6 1102
-- Name: pointonsurface(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION pointonsurface(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'pointonsurface';


ALTER FUNCTION public.pointonsurface(geometry) OWNER TO postgres;

--
-- TOC entry 342 (class 1255 OID 18695)
-- Dependencies: 6 1102
-- Name: polyfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION polyfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1)) = 'POLYGON'
	THEN GeomFromText($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.polyfromtext(text) OWNER TO postgres;

--
-- TOC entry 343 (class 1255 OID 18696)
-- Dependencies: 6 1102
-- Name: polyfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION polyfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1, $2)) = 'POLYGON'
	THEN GeomFromText($1,$2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.polyfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 345 (class 1255 OID 18698)
-- Dependencies: 1102 6
-- Name: polyfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION polyfromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'POLYGON'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.polyfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 344 (class 1255 OID 18697)
-- Dependencies: 1102 6
-- Name: polyfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION polyfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1, $2)) = 'POLYGON'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.polyfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 347 (class 1255 OID 18700)
-- Dependencies: 6 1102
-- Name: polygonfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION polygonfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT PolyFromText($1)$_$;


ALTER FUNCTION public.polygonfromtext(text) OWNER TO postgres;

--
-- TOC entry 346 (class 1255 OID 18699)
-- Dependencies: 6 1102
-- Name: polygonfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION polygonfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT PolyFromText($1, $2)$_$;


ALTER FUNCTION public.polygonfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 349 (class 1255 OID 18702)
-- Dependencies: 6 1102
-- Name: polygonfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION polygonfromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'POLYGON'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.polygonfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 348 (class 1255 OID 18701)
-- Dependencies: 1102 6
-- Name: polygonfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION polygonfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1,$2)) = 'POLYGON'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.polygonfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 350 (class 1255 OID 18703)
-- Dependencies: 1104 1102 6
-- Name: polygonize_garray(geometry[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION polygonize_garray(geometry[]) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'polygonize_garray';


ALTER FUNCTION public.polygonize_garray(geometry[]) OWNER TO postgres;

--
-- TOC entry 351 (class 1255 OID 18704)
-- Dependencies: 6 1170
-- Name: populate_geometry_columns(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION populate_geometry_columns() RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
	inserted    integer;
	oldcount    integer;
	probed      integer;
	stale       integer;
	gcs         RECORD;
	gc          RECORD;
	gsrid       integer;
	gndims      integer;
	gtype       text;
	query       text;
	gc_is_valid boolean;

BEGIN
	SELECT count(*) INTO oldcount FROM geometry_columns;
	inserted := 0;

	EXECUTE 'TRUNCATE geometry_columns';

	-- Count the number of geometry columns in all tables and views
	SELECT count(DISTINCT c.oid) INTO probed
	FROM pg_class c,
		 pg_attribute a,
		 pg_type t,
		 pg_namespace n
	WHERE (c.relkind = 'r' OR c.relkind = 'v')
	AND t.typname = 'geometry'
	AND a.attisdropped = false
	AND a.atttypid = t.oid
	AND a.attrelid = c.oid
	AND c.relnamespace = n.oid
	AND n.nspname NOT ILIKE 'pg_temp%';

	-- Iterate through all non-dropped geometry columns
	RAISE DEBUG 'Processing Tables.....';

	FOR gcs IN
	SELECT DISTINCT ON (c.oid) c.oid, n.nspname, c.relname
		FROM pg_class c,
			 pg_attribute a,
			 pg_type t,
			 pg_namespace n
		WHERE c.relkind = 'r'
		AND t.typname = 'geometry'
		AND a.attisdropped = false
		AND a.atttypid = t.oid
		AND a.attrelid = c.oid
		AND c.relnamespace = n.oid
		AND n.nspname NOT ILIKE 'pg_temp%'
	LOOP

	inserted := inserted + populate_geometry_columns(gcs.oid);
	END LOOP;

	-- Add views to geometry columns table
	RAISE DEBUG 'Processing Views.....';
	FOR gcs IN
	SELECT DISTINCT ON (c.oid) c.oid, n.nspname, c.relname
		FROM pg_class c,
			 pg_attribute a,
			 pg_type t,
			 pg_namespace n
		WHERE c.relkind = 'v'
		AND t.typname = 'geometry'
		AND a.attisdropped = false
		AND a.atttypid = t.oid
		AND a.attrelid = c.oid
		AND c.relnamespace = n.oid
	LOOP

	inserted := inserted + populate_geometry_columns(gcs.oid);
	END LOOP;

	IF oldcount > inserted THEN
	stale = oldcount-inserted;
	ELSE
	stale = 0;
	END IF;

	RETURN 'probed:' ||probed|| ' inserted:'||inserted|| ' conflicts:'||probed-inserted|| ' deleted:'||stale;
END

$$;


ALTER FUNCTION public.populate_geometry_columns() OWNER TO postgres;

--
-- TOC entry 352 (class 1255 OID 18705)
-- Dependencies: 1170 6
-- Name: populate_geometry_columns(oid); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION populate_geometry_columns(tbl_oid oid) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
	gcs         RECORD;
	gc          RECORD;
	gsrid       integer;
	gndims      integer;
	gtype       text;
	query       text;
	gc_is_valid boolean;
	inserted    integer;

BEGIN
	inserted := 0;

	-- Iterate through all geometry columns in this table
	FOR gcs IN
	SELECT n.nspname, c.relname, a.attname
		FROM pg_class c,
			 pg_attribute a,
			 pg_type t,
			 pg_namespace n
		WHERE c.relkind = 'r'
		AND t.typname = 'geometry'
		AND a.attisdropped = false
		AND a.atttypid = t.oid
		AND a.attrelid = c.oid
		AND c.relnamespace = n.oid
		AND n.nspname NOT ILIKE 'pg_temp%'
		AND c.oid = tbl_oid
	LOOP

	RAISE DEBUG 'Processing table %.%.%', gcs.nspname, gcs.relname, gcs.attname;

	DELETE FROM geometry_columns
	  WHERE f_table_schema = quote_ident(gcs.nspname)
	  AND f_table_name = quote_ident(gcs.relname)
	  AND f_geometry_column = quote_ident(gcs.attname);

	gc_is_valid := true;

	-- Try to find srid check from system tables (pg_constraint)
	gsrid :=
		(SELECT replace(replace(split_part(s.consrc, ' = ', 2), ')', ''), '(', '')
		 FROM pg_class c, pg_namespace n, pg_attribute a, pg_constraint s
		 WHERE n.nspname = gcs.nspname
		 AND c.relname = gcs.relname
		 AND a.attname = gcs.attname
		 AND a.attrelid = c.oid
		 AND s.connamespace = n.oid
		 AND s.conrelid = c.oid
		 AND a.attnum = ANY (s.conkey)
		 AND s.consrc LIKE '%srid(% = %');
	IF (gsrid IS NULL) THEN
		-- Try to find srid from the geometry itself
		EXECUTE 'SELECT srid(' || quote_ident(gcs.attname) || ')
				 FROM ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || '
				 WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1'
			INTO gc;
		gsrid := gc.srid;

		-- Try to apply srid check to column
		IF (gsrid IS NOT NULL) THEN
			BEGIN
				EXECUTE 'ALTER TABLE ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || '
						 ADD CONSTRAINT ' || quote_ident('enforce_srid_' || gcs.attname) || '
						 CHECK (srid(' || quote_ident(gcs.attname) || ') = ' || gsrid || ')';
			EXCEPTION
				WHEN check_violation THEN
					RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not apply constraint CHECK (srid(%) = %)', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname), quote_ident(gcs.attname), gsrid;
					gc_is_valid := false;
			END;
		END IF;
	END IF;

	-- Try to find ndims check from system tables (pg_constraint)
	gndims :=
		(SELECT replace(split_part(s.consrc, ' = ', 2), ')', '')
		 FROM pg_class c, pg_namespace n, pg_attribute a, pg_constraint s
		 WHERE n.nspname = gcs.nspname
		 AND c.relname = gcs.relname
		 AND a.attname = gcs.attname
		 AND a.attrelid = c.oid
		 AND s.connamespace = n.oid
		 AND s.conrelid = c.oid
		 AND a.attnum = ANY (s.conkey)
		 AND s.consrc LIKE '%ndims(% = %');
	IF (gndims IS NULL) THEN
		-- Try to find ndims from the geometry itself
		EXECUTE 'SELECT ndims(' || quote_ident(gcs.attname) || ')
				 FROM ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || '
				 WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1'
			INTO gc;
		gndims := gc.ndims;

		-- Try to apply ndims check to column
		IF (gndims IS NOT NULL) THEN
			BEGIN
				EXECUTE 'ALTER TABLE ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || '
						 ADD CONSTRAINT ' || quote_ident('enforce_dims_' || gcs.attname) || '
						 CHECK (ndims(' || quote_ident(gcs.attname) || ') = '||gndims||')';
			EXCEPTION
				WHEN check_violation THEN
					RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not apply constraint CHECK (ndims(%) = %)', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname), quote_ident(gcs.attname), gndims;
					gc_is_valid := false;
			END;
		END IF;
	END IF;

	-- Try to find geotype check from system tables (pg_constraint)
	gtype :=
		(SELECT replace(split_part(s.consrc, '''', 2), ')', '')
		 FROM pg_class c, pg_namespace n, pg_attribute a, pg_constraint s
		 WHERE n.nspname = gcs.nspname
		 AND c.relname = gcs.relname
		 AND a.attname = gcs.attname
		 AND a.attrelid = c.oid
		 AND s.connamespace = n.oid
		 AND s.conrelid = c.oid
		 AND a.attnum = ANY (s.conkey)
		 AND s.consrc LIKE '%geometrytype(% = %');
	IF (gtype IS NULL) THEN
		-- Try to find geotype from the geometry itself
		EXECUTE 'SELECT geometrytype(' || quote_ident(gcs.attname) || ')
				 FROM ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || '
				 WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1'
			INTO gc;
		gtype := gc.geometrytype;
		--IF (gtype IS NULL) THEN
		--    gtype := 'GEOMETRY';
		--END IF;

		-- Try to apply geometrytype check to column
		IF (gtype IS NOT NULL) THEN
			BEGIN
				EXECUTE 'ALTER TABLE ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || '
				ADD CONSTRAINT ' || quote_ident('enforce_geotype_' || gcs.attname) || '
				CHECK ((geometrytype(' || quote_ident(gcs.attname) || ') = ' || quote_literal(gtype) || ') OR (' || quote_ident(gcs.attname) || ' IS NULL))';
			EXCEPTION
				WHEN check_violation THEN
					-- No geometry check can be applied. This column contains a number of geometry types.
					RAISE WARNING 'Could not add geometry type check (%) to table column: %.%.%', gtype, quote_ident(gcs.nspname),quote_ident(gcs.relname),quote_ident(gcs.attname);
			END;
		END IF;
	END IF;

	IF (gsrid IS NULL) THEN
		RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine the srid', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
	ELSIF (gndims IS NULL) THEN
		RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine the number of dimensions', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
	ELSIF (gtype IS NULL) THEN
		RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine the geometry type', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
	ELSE
		-- Only insert into geometry_columns if table constraints could be applied.
		IF (gc_is_valid) THEN
			INSERT INTO geometry_columns (f_table_catalog,f_table_schema, f_table_name, f_geometry_column, coord_dimension, srid, type)
			VALUES ('', gcs.nspname, gcs.relname, gcs.attname, gndims, gsrid, gtype);
			inserted := inserted + 1;
		END IF;
	END IF;
	END LOOP;

	-- Add views to geometry columns table
	FOR gcs IN
	SELECT n.nspname, c.relname, a.attname
		FROM pg_class c,
			 pg_attribute a,
			 pg_type t,
			 pg_namespace n
		WHERE c.relkind = 'v'
		AND t.typname = 'geometry'
		AND a.attisdropped = false
		AND a.atttypid = t.oid
		AND a.attrelid = c.oid
		AND c.relnamespace = n.oid
		AND n.nspname NOT ILIKE 'pg_temp%'
		AND c.oid = tbl_oid
	LOOP
		RAISE DEBUG 'Processing view %.%.%', gcs.nspname, gcs.relname, gcs.attname;

		EXECUTE 'SELECT ndims(' || quote_ident(gcs.attname) || ')
				 FROM ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || '
				 WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1'
			INTO gc;
		gndims := gc.ndims;

		EXECUTE 'SELECT srid(' || quote_ident(gcs.attname) || ')
				 FROM ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || '
				 WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1'
			INTO gc;
		gsrid := gc.srid;

		EXECUTE 'SELECT geometrytype(' || quote_ident(gcs.attname) || ')
				 FROM ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || '
				 WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1'
			INTO gc;
		gtype := gc.geometrytype;

		IF (gndims IS NULL) THEN
			RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine ndims', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
		ELSIF (gsrid IS NULL) THEN
			RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine srid', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
		ELSIF (gtype IS NULL) THEN
			RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine gtype', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
		ELSE
			query := 'INSERT INTO geometry_columns (f_table_catalog,f_table_schema, f_table_name, f_geometry_column, coord_dimension, srid, type) ' ||
					 'VALUES ('''', ' || quote_literal(gcs.nspname) || ',' || quote_literal(gcs.relname) || ',' || quote_literal(gcs.attname) || ',' || gndims || ',' || gsrid || ',' || quote_literal(gtype) || ')';
			EXECUTE query;
			inserted := inserted + 1;
		END IF;
	END LOOP;

	RETURN inserted;
END

$$;


ALTER FUNCTION public.populate_geometry_columns(tbl_oid oid) OWNER TO postgres;

--
-- TOC entry 353 (class 1255 OID 18707)
-- Dependencies: 1102 1102 6
-- Name: postgis_addbbox(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_addbbox(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_addBBOX';


ALTER FUNCTION public.postgis_addbbox(geometry) OWNER TO postgres;

--
-- TOC entry 354 (class 1255 OID 18708)
-- Dependencies: 6
-- Name: postgis_cache_bbox(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_cache_bbox() RETURNS trigger
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'cache_bbox';


ALTER FUNCTION public.postgis_cache_bbox() OWNER TO postgres;

--
-- TOC entry 355 (class 1255 OID 18709)
-- Dependencies: 1102 6 1102
-- Name: postgis_dropbbox(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_dropbbox(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_dropBBOX';


ALTER FUNCTION public.postgis_dropbbox(geometry) OWNER TO postgres;

--
-- TOC entry 356 (class 1255 OID 18710)
-- Dependencies: 1170 6
-- Name: postgis_full_version(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_full_version() RETURNS text
    LANGUAGE plpgsql IMMUTABLE
    AS $$
DECLARE
	libver text;
	projver text;
	geosver text;
	libxmlver text;
	usestats bool;
	dbproc text;
	relproc text;
	fullver text;
BEGIN
	SELECT postgis_lib_version() INTO libver;
	SELECT postgis_proj_version() INTO projver;
	SELECT postgis_geos_version() INTO geosver;
	SELECT postgis_libxml_version() INTO libxmlver;
	SELECT postgis_uses_stats() INTO usestats;
	SELECT postgis_scripts_installed() INTO dbproc;
	SELECT postgis_scripts_released() INTO relproc;

	fullver = 'POSTGIS="' || libver || '"';

	IF  geosver IS NOT NULL THEN
		fullver = fullver || ' GEOS="' || geosver || '"';
	END IF;

	IF  projver IS NOT NULL THEN
		fullver = fullver || ' PROJ="' || projver || '"';
	END IF;

	IF  libxmlver IS NOT NULL THEN
		fullver = fullver || ' LIBXML="' || libxmlver || '"';
	END IF;

	IF usestats THEN
		fullver = fullver || ' USE_STATS';
	END IF;

	-- fullver = fullver || ' DBPROC="' || dbproc || '"';
	-- fullver = fullver || ' RELPROC="' || relproc || '"';

	IF dbproc != relproc THEN
		fullver = fullver || ' (procs from ' || dbproc || ' need upgrade)';
	END IF;

	RETURN fullver;
END
$$;


ALTER FUNCTION public.postgis_full_version() OWNER TO postgres;

--
-- TOC entry 357 (class 1255 OID 18711)
-- Dependencies: 6
-- Name: postgis_geos_version(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_geos_version() RETURNS text
    LANGUAGE c IMMUTABLE
    AS '$libdir/postgis-1.5', 'postgis_geos_version';


ALTER FUNCTION public.postgis_geos_version() OWNER TO postgres;

--
-- TOC entry 358 (class 1255 OID 18712)
-- Dependencies: 1087 6 1102
-- Name: postgis_getbbox(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_getbbox(geometry) RETURNS box2d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_to_BOX2DFLOAT4';


ALTER FUNCTION public.postgis_getbbox(geometry) OWNER TO postgres;

--
-- TOC entry 359 (class 1255 OID 18713)
-- Dependencies: 6
-- Name: postgis_gist_joinsel(internal, oid, internal, smallint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_gist_joinsel(internal, oid, internal, smallint) RETURNS double precision
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'LWGEOM_gist_joinsel';


ALTER FUNCTION public.postgis_gist_joinsel(internal, oid, internal, smallint) OWNER TO postgres;

--
-- TOC entry 360 (class 1255 OID 18714)
-- Dependencies: 6
-- Name: postgis_gist_sel(internal, oid, internal, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_gist_sel(internal, oid, internal, integer) RETURNS double precision
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'LWGEOM_gist_sel';


ALTER FUNCTION public.postgis_gist_sel(internal, oid, internal, integer) OWNER TO postgres;

--
-- TOC entry 361 (class 1255 OID 18715)
-- Dependencies: 6 1102
-- Name: postgis_hasbbox(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_hasbbox(geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_hasBBOX';


ALTER FUNCTION public.postgis_hasbbox(geometry) OWNER TO postgres;

--
-- TOC entry 362 (class 1255 OID 18716)
-- Dependencies: 6
-- Name: postgis_lib_build_date(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_lib_build_date() RETURNS text
    LANGUAGE c IMMUTABLE
    AS '$libdir/postgis-1.5', 'postgis_lib_build_date';


ALTER FUNCTION public.postgis_lib_build_date() OWNER TO postgres;

--
-- TOC entry 363 (class 1255 OID 18717)
-- Dependencies: 6
-- Name: postgis_lib_version(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_lib_version() RETURNS text
    LANGUAGE c IMMUTABLE
    AS '$libdir/postgis-1.5', 'postgis_lib_version';


ALTER FUNCTION public.postgis_lib_version() OWNER TO postgres;

--
-- TOC entry 364 (class 1255 OID 18718)
-- Dependencies: 6
-- Name: postgis_libxml_version(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_libxml_version() RETURNS text
    LANGUAGE c IMMUTABLE
    AS '$libdir/postgis-1.5', 'postgis_libxml_version';


ALTER FUNCTION public.postgis_libxml_version() OWNER TO postgres;

--
-- TOC entry 365 (class 1255 OID 18719)
-- Dependencies: 1102 1102 6
-- Name: postgis_noop(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_noop(geometry) RETURNS geometry
    LANGUAGE c STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_noop';


ALTER FUNCTION public.postgis_noop(geometry) OWNER TO postgres;

--
-- TOC entry 366 (class 1255 OID 18720)
-- Dependencies: 6
-- Name: postgis_proj_version(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_proj_version() RETURNS text
    LANGUAGE c IMMUTABLE
    AS '$libdir/postgis-1.5', 'postgis_proj_version';


ALTER FUNCTION public.postgis_proj_version() OWNER TO postgres;

--
-- TOC entry 367 (class 1255 OID 18721)
-- Dependencies: 6
-- Name: postgis_scripts_build_date(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_scripts_build_date() RETURNS text
    LANGUAGE sql IMMUTABLE
    AS $$SELECT '2010-03-11 19:15:17'::text AS version$$;


ALTER FUNCTION public.postgis_scripts_build_date() OWNER TO postgres;

--
-- TOC entry 368 (class 1255 OID 18722)
-- Dependencies: 6
-- Name: postgis_scripts_installed(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_scripts_installed() RETURNS text
    LANGUAGE sql IMMUTABLE
    AS $$SELECT '1.5 r5385'::text AS version$$;


ALTER FUNCTION public.postgis_scripts_installed() OWNER TO postgres;

--
-- TOC entry 369 (class 1255 OID 18723)
-- Dependencies: 6
-- Name: postgis_scripts_released(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_scripts_released() RETURNS text
    LANGUAGE c IMMUTABLE
    AS '$libdir/postgis-1.5', 'postgis_scripts_released';


ALTER FUNCTION public.postgis_scripts_released() OWNER TO postgres;

--
-- TOC entry 370 (class 1255 OID 18724)
-- Dependencies: 6 1102 1102
-- Name: postgis_transform_geometry(geometry, text, text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_transform_geometry(geometry, text, text, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'transform_geom';


ALTER FUNCTION public.postgis_transform_geometry(geometry, text, text, integer) OWNER TO postgres;

--
-- TOC entry 371 (class 1255 OID 18725)
-- Dependencies: 6
-- Name: postgis_uses_stats(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_uses_stats() RETURNS boolean
    LANGUAGE c IMMUTABLE
    AS '$libdir/postgis-1.5', 'postgis_uses_stats';


ALTER FUNCTION public.postgis_uses_stats() OWNER TO postgres;

--
-- TOC entry 372 (class 1255 OID 18726)
-- Dependencies: 6
-- Name: postgis_version(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_version() RETURNS text
    LANGUAGE c IMMUTABLE
    AS '$libdir/postgis-1.5', 'postgis_version';


ALTER FUNCTION public.postgis_version() OWNER TO postgres;

--
-- TOC entry 373 (class 1255 OID 18727)
-- Dependencies: 6 1170
-- Name: probe_geometry_columns(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION probe_geometry_columns() RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
	inserted integer;
	oldcount integer;
	probed integer;
	stale integer;
BEGIN

	SELECT count(*) INTO oldcount FROM geometry_columns;

	SELECT count(*) INTO probed
		FROM pg_class c, pg_attribute a, pg_type t,
			pg_namespace n,
			pg_constraint sridcheck, pg_constraint typecheck

		WHERE t.typname = 'geometry'
		AND a.atttypid = t.oid
		AND a.attrelid = c.oid
		AND c.relnamespace = n.oid
		AND sridcheck.connamespace = n.oid
		AND typecheck.connamespace = n.oid
		AND sridcheck.conrelid = c.oid
		AND sridcheck.consrc LIKE '(srid('||a.attname||') = %)'
		AND typecheck.conrelid = c.oid
		AND typecheck.consrc LIKE
		'((geometrytype('||a.attname||') = ''%''::text) OR (% IS NULL))'
		;

	INSERT INTO geometry_columns SELECT
		''::varchar as f_table_catalogue,
		n.nspname::varchar as f_table_schema,
		c.relname::varchar as f_table_name,
		a.attname::varchar as f_geometry_column,
		2 as coord_dimension,
		trim(both  ' =)' from
			replace(replace(split_part(
				sridcheck.consrc, ' = ', 2), ')', ''), '(', ''))::integer AS srid,
		trim(both ' =)''' from substr(typecheck.consrc,
			strpos(typecheck.consrc, '='),
			strpos(typecheck.consrc, '::')-
			strpos(typecheck.consrc, '=')
			))::varchar as type
		FROM pg_class c, pg_attribute a, pg_type t,
			pg_namespace n,
			pg_constraint sridcheck, pg_constraint typecheck
		WHERE t.typname = 'geometry'
		AND a.atttypid = t.oid
		AND a.attrelid = c.oid
		AND c.relnamespace = n.oid
		AND sridcheck.connamespace = n.oid
		AND typecheck.connamespace = n.oid
		AND sridcheck.conrelid = c.oid
		AND sridcheck.consrc LIKE '(st_srid('||a.attname||') = %)'
		AND typecheck.conrelid = c.oid
		AND typecheck.consrc LIKE
		'((geometrytype('||a.attname||') = ''%''::text) OR (% IS NULL))'

			AND NOT EXISTS (
					SELECT oid FROM geometry_columns gc
					WHERE c.relname::varchar = gc.f_table_name
					AND n.nspname::varchar = gc.f_table_schema
					AND a.attname::varchar = gc.f_geometry_column
			);

	GET DIAGNOSTICS inserted = ROW_COUNT;

	IF oldcount > probed THEN
		stale = oldcount-probed;
	ELSE
		stale = 0;
	END IF;

	RETURN 'probed:'||probed::text||
		' inserted:'||inserted::text||
		' conflicts:'||(probed-inserted)::text||
		' stale:'||stale::text;
END

$$;


ALTER FUNCTION public.probe_geometry_columns() OWNER TO postgres;

--
-- TOC entry 374 (class 1255 OID 18728)
-- Dependencies: 1102 6 1102
-- Name: relate(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION relate(geometry, geometry) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'relate_full';


ALTER FUNCTION public.relate(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 375 (class 1255 OID 18729)
-- Dependencies: 1102 6 1102
-- Name: relate(geometry, geometry, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION relate(geometry, geometry, text) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'relate_pattern';


ALTER FUNCTION public.relate(geometry, geometry, text) OWNER TO postgres;

--
-- TOC entry 376 (class 1255 OID 18730)
-- Dependencies: 6 1102 1102
-- Name: removepoint(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION removepoint(geometry, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_removepoint';


ALTER FUNCTION public.removepoint(geometry, integer) OWNER TO postgres;

--
-- TOC entry 377 (class 1255 OID 18731)
-- Dependencies: 6
-- Name: rename_geometry_table_constraints(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION rename_geometry_table_constraints() RETURNS text
    LANGUAGE sql IMMUTABLE
    AS $$
SELECT 'rename_geometry_table_constraint() is obsoleted'::text
$$;


ALTER FUNCTION public.rename_geometry_table_constraints() OWNER TO postgres;

--
-- TOC entry 378 (class 1255 OID 18732)
-- Dependencies: 6 1102 1102
-- Name: reverse(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION reverse(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_reverse';


ALTER FUNCTION public.reverse(geometry) OWNER TO postgres;

--
-- TOC entry 379 (class 1255 OID 18733)
-- Dependencies: 1102 6 1102
-- Name: rotate(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION rotate(geometry, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT rotateZ($1, $2)$_$;


ALTER FUNCTION public.rotate(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 380 (class 1255 OID 18734)
-- Dependencies: 1102 1102 6
-- Name: rotatex(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION rotatex(geometry, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT affine($1, 1, 0, 0, 0, cos($2), -sin($2), 0, sin($2), cos($2), 0, 0, 0)$_$;


ALTER FUNCTION public.rotatex(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 381 (class 1255 OID 18735)
-- Dependencies: 1102 1102 6
-- Name: rotatey(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION rotatey(geometry, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT affine($1,  cos($2), 0, sin($2),  0, 1, 0,  -sin($2), 0, cos($2), 0,  0, 0)$_$;


ALTER FUNCTION public.rotatey(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 382 (class 1255 OID 18736)
-- Dependencies: 1102 6 1102
-- Name: rotatez(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION rotatez(geometry, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT affine($1,  cos($2), -sin($2), 0,  sin($2), cos($2), 0,  0, 0, 1,  0, 0, 0)$_$;


ALTER FUNCTION public.rotatez(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 384 (class 1255 OID 18738)
-- Dependencies: 1102 6 1102
-- Name: scale(geometry, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION scale(geometry, double precision, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT scale($1, $2, $3, 1)$_$;


ALTER FUNCTION public.scale(geometry, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 383 (class 1255 OID 18737)
-- Dependencies: 6 1102 1102
-- Name: scale(geometry, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION scale(geometry, double precision, double precision, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT affine($1,  $2, 0, 0,  0, $3, 0,  0, 0, $4,  0, 0, 0)$_$;


ALTER FUNCTION public.scale(geometry, double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 385 (class 1255 OID 18739)
-- Dependencies: 6 1102 1102
-- Name: se_envelopesintersect(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION se_envelopesintersect(geometry, geometry) RETURNS boolean
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ 
	SELECT $1 && $2
	$_$;


ALTER FUNCTION public.se_envelopesintersect(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 386 (class 1255 OID 18740)
-- Dependencies: 6 1102
-- Name: se_is3d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION se_is3d(geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_hasz';


ALTER FUNCTION public.se_is3d(geometry) OWNER TO postgres;

--
-- TOC entry 387 (class 1255 OID 18741)
-- Dependencies: 1102 6
-- Name: se_ismeasured(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION se_ismeasured(geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_hasm';


ALTER FUNCTION public.se_ismeasured(geometry) OWNER TO postgres;

--
-- TOC entry 388 (class 1255 OID 18742)
-- Dependencies: 1102 1102 6
-- Name: se_locatealong(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION se_locatealong(geometry, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT locate_between_measures($1, $2, $2) $_$;


ALTER FUNCTION public.se_locatealong(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 389 (class 1255 OID 18743)
-- Dependencies: 1102 1102 6
-- Name: se_locatebetween(geometry, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION se_locatebetween(geometry, double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_locate_between_m';


ALTER FUNCTION public.se_locatebetween(geometry, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 390 (class 1255 OID 18744)
-- Dependencies: 1102 6
-- Name: se_m(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION se_m(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_m_point';


ALTER FUNCTION public.se_m(geometry) OWNER TO postgres;

--
-- TOC entry 391 (class 1255 OID 18745)
-- Dependencies: 1102 6
-- Name: se_z(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION se_z(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_z_point';


ALTER FUNCTION public.se_z(geometry) OWNER TO postgres;

--
-- TOC entry 392 (class 1255 OID 18746)
-- Dependencies: 1102 6 1102
-- Name: segmentize(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION segmentize(geometry, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_segmentize2d';


ALTER FUNCTION public.segmentize(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 393 (class 1255 OID 18747)
-- Dependencies: 1096 1096 6
-- Name: setfactor(chip, real); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION setfactor(chip, real) RETURNS chip
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_setFactor';


ALTER FUNCTION public.setfactor(chip, real) OWNER TO postgres;

--
-- TOC entry 394 (class 1255 OID 18748)
-- Dependencies: 1102 6 1102 1102
-- Name: setpoint(geometry, integer, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION setpoint(geometry, integer, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_setpoint_linestring';


ALTER FUNCTION public.setpoint(geometry, integer, geometry) OWNER TO postgres;

--
-- TOC entry 395 (class 1255 OID 18749)
-- Dependencies: 1096 6 1096
-- Name: setsrid(chip, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION setsrid(chip, integer) RETURNS chip
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_setSRID';


ALTER FUNCTION public.setsrid(chip, integer) OWNER TO postgres;

--
-- TOC entry 396 (class 1255 OID 18750)
-- Dependencies: 6 1102 1102
-- Name: setsrid(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION setsrid(geometry, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_setSRID';


ALTER FUNCTION public.setsrid(geometry, integer) OWNER TO postgres;

--
-- TOC entry 397 (class 1255 OID 18751)
-- Dependencies: 1102 6 1102
-- Name: shift_longitude(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION shift_longitude(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_longitude_shift';


ALTER FUNCTION public.shift_longitude(geometry) OWNER TO postgres;

--
-- TOC entry 398 (class 1255 OID 18752)
-- Dependencies: 1102 1102 6
-- Name: simplify(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION simplify(geometry, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_simplify2d';


ALTER FUNCTION public.simplify(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 401 (class 1255 OID 18755)
-- Dependencies: 6 1102 1102
-- Name: snaptogrid(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION snaptogrid(geometry, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT SnapToGrid($1, 0, 0, $2, $2)$_$;


ALTER FUNCTION public.snaptogrid(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 400 (class 1255 OID 18754)
-- Dependencies: 1102 6 1102
-- Name: snaptogrid(geometry, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION snaptogrid(geometry, double precision, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT SnapToGrid($1, 0, 0, $2, $3)$_$;


ALTER FUNCTION public.snaptogrid(geometry, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 399 (class 1255 OID 18753)
-- Dependencies: 1102 6 1102
-- Name: snaptogrid(geometry, double precision, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION snaptogrid(geometry, double precision, double precision, double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_snaptogrid';


ALTER FUNCTION public.snaptogrid(geometry, double precision, double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 402 (class 1255 OID 18756)
-- Dependencies: 6 1102 1102 1102
-- Name: snaptogrid(geometry, geometry, double precision, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION snaptogrid(geometry, geometry, double precision, double precision, double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_snaptogrid_pointoff';


ALTER FUNCTION public.snaptogrid(geometry, geometry, double precision, double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 403 (class 1255 OID 18757)
-- Dependencies: 6 1096
-- Name: srid(chip); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION srid(chip) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_getSRID';


ALTER FUNCTION public.srid(chip) OWNER TO postgres;

--
-- TOC entry 404 (class 1255 OID 18758)
-- Dependencies: 6 1102
-- Name: srid(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION srid(geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_getSRID';


ALTER FUNCTION public.srid(geometry) OWNER TO postgres;

--
-- TOC entry 405 (class 1255 OID 18759)
-- Dependencies: 6 1102 1102
-- Name: st_addmeasure(geometry, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_addmeasure(geometry, double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'ST_AddMeasure';


ALTER FUNCTION public.st_addmeasure(geometry, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 406 (class 1255 OID 18760)
-- Dependencies: 1102 6 1102 1102
-- Name: st_addpoint(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_addpoint(geometry, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_addpoint';


ALTER FUNCTION public.st_addpoint(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 407 (class 1255 OID 18761)
-- Dependencies: 1102 6 1102 1102
-- Name: st_addpoint(geometry, geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_addpoint(geometry, geometry, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_addpoint';


ALTER FUNCTION public.st_addpoint(geometry, geometry, integer) OWNER TO postgres;

--
-- TOC entry 409 (class 1255 OID 18763)
-- Dependencies: 1102 6 1102
-- Name: st_affine(geometry, double precision, double precision, double precision, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_affine(geometry, double precision, double precision, double precision, double precision, double precision, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT affine($1,  $2, $3, 0,  $4, $5, 0,  0, 0, 1,  $6, $7, 0)$_$;


ALTER FUNCTION public.st_affine(geometry, double precision, double precision, double precision, double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 408 (class 1255 OID 18762)
-- Dependencies: 1102 6 1102
-- Name: st_affine(geometry, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_affine(geometry, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_affine';


ALTER FUNCTION public.st_affine(geometry, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 410 (class 1255 OID 18764)
-- Dependencies: 1102 6
-- Name: st_area(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_area(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_area_polygon';


ALTER FUNCTION public.st_area(geometry) OWNER TO postgres;

--
-- TOC entry 412 (class 1255 OID 18766)
-- Dependencies: 6 1099
-- Name: st_area(geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_area(geography) RETURNS double precision
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT ST_Area($1, true)$_$;


ALTER FUNCTION public.st_area(geography) OWNER TO postgres;

--
-- TOC entry 413 (class 1255 OID 18767)
-- Dependencies: 6
-- Name: st_area(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_area(text) RETURNS double precision
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_Area($1::geometry);  $_$;


ALTER FUNCTION public.st_area(text) OWNER TO postgres;

--
-- TOC entry 411 (class 1255 OID 18765)
-- Dependencies: 6 1099
-- Name: st_area(geography, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_area(geography, boolean) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'geography_area';


ALTER FUNCTION public.st_area(geography, boolean) OWNER TO postgres;

--
-- TOC entry 414 (class 1255 OID 18768)
-- Dependencies: 6 1102
-- Name: st_area2d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_area2d(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_area_polygon';


ALTER FUNCTION public.st_area2d(geometry) OWNER TO postgres;

--
-- TOC entry 415 (class 1255 OID 18769)
-- Dependencies: 6 1102
-- Name: st_asbinary(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asbinary(geometry) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_asBinary';


ALTER FUNCTION public.st_asbinary(geometry) OWNER TO postgres;

--
-- TOC entry 417 (class 1255 OID 18771)
-- Dependencies: 1099 6
-- Name: st_asbinary(geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asbinary(geography) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_as_binary';


ALTER FUNCTION public.st_asbinary(geography) OWNER TO postgres;

--
-- TOC entry 418 (class 1255 OID 18772)
-- Dependencies: 6
-- Name: st_asbinary(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asbinary(text) RETURNS bytea
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_AsBinary($1::geometry);  $_$;


ALTER FUNCTION public.st_asbinary(text) OWNER TO postgres;

--
-- TOC entry 416 (class 1255 OID 18770)
-- Dependencies: 6 1102
-- Name: st_asbinary(geometry, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asbinary(geometry, text) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_asBinary';


ALTER FUNCTION public.st_asbinary(geometry, text) OWNER TO postgres;

--
-- TOC entry 419 (class 1255 OID 18773)
-- Dependencies: 6 1102
-- Name: st_asewkb(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asewkb(geometry) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'WKBFromLWGEOM';


ALTER FUNCTION public.st_asewkb(geometry) OWNER TO postgres;

--
-- TOC entry 420 (class 1255 OID 18774)
-- Dependencies: 6 1102
-- Name: st_asewkb(geometry, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asewkb(geometry, text) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'WKBFromLWGEOM';


ALTER FUNCTION public.st_asewkb(geometry, text) OWNER TO postgres;

--
-- TOC entry 421 (class 1255 OID 18775)
-- Dependencies: 1102 6
-- Name: st_asewkt(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asewkt(geometry) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_asEWKT';


ALTER FUNCTION public.st_asewkt(geometry) OWNER TO postgres;

--
-- TOC entry 423 (class 1255 OID 18777)
-- Dependencies: 1102 6
-- Name: st_asgeojson(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgeojson(geometry) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGeoJson(1, $1, 15, 0)$_$;


ALTER FUNCTION public.st_asgeojson(geometry) OWNER TO postgres;

--
-- TOC entry 429 (class 1255 OID 18783)
-- Dependencies: 6 1099
-- Name: st_asgeojson(geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgeojson(geography) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGeoJson(1, $1, 15, 0)$_$;


ALTER FUNCTION public.st_asgeojson(geography) OWNER TO postgres;

--
-- TOC entry 430 (class 1255 OID 18784)
-- Dependencies: 6
-- Name: st_asgeojson(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgeojson(text) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_AsGeoJson($1::geometry);  $_$;


ALTER FUNCTION public.st_asgeojson(text) OWNER TO postgres;

--
-- TOC entry 422 (class 1255 OID 18776)
-- Dependencies: 6 1102
-- Name: st_asgeojson(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgeojson(geometry, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGeoJson(1, $1, $2, 0)$_$;


ALTER FUNCTION public.st_asgeojson(geometry, integer) OWNER TO postgres;

--
-- TOC entry 424 (class 1255 OID 18778)
-- Dependencies: 6 1102
-- Name: st_asgeojson(integer, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgeojson(integer, geometry) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGeoJson($1, $2, 15, 0)$_$;


ALTER FUNCTION public.st_asgeojson(integer, geometry) OWNER TO postgres;

--
-- TOC entry 428 (class 1255 OID 18782)
-- Dependencies: 1099 6
-- Name: st_asgeojson(geography, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgeojson(geography, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGeoJson(1, $1, $2, 0)$_$;


ALTER FUNCTION public.st_asgeojson(geography, integer) OWNER TO postgres;

--
-- TOC entry 431 (class 1255 OID 18785)
-- Dependencies: 1099 6
-- Name: st_asgeojson(integer, geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgeojson(integer, geography) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGeoJson($1, $2, 15, 0)$_$;


ALTER FUNCTION public.st_asgeojson(integer, geography) OWNER TO postgres;

--
-- TOC entry 425 (class 1255 OID 18779)
-- Dependencies: 1102 6
-- Name: st_asgeojson(integer, geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgeojson(integer, geometry, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGeoJson($1, $2, $3, 0)$_$;


ALTER FUNCTION public.st_asgeojson(integer, geometry, integer) OWNER TO postgres;

--
-- TOC entry 426 (class 1255 OID 18780)
-- Dependencies: 1102 6
-- Name: st_asgeojson(geometry, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgeojson(geometry, integer, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGeoJson(1, $1, $2, $3)$_$;


ALTER FUNCTION public.st_asgeojson(geometry, integer, integer) OWNER TO postgres;

--
-- TOC entry 432 (class 1255 OID 18786)
-- Dependencies: 6 1099
-- Name: st_asgeojson(integer, geography, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgeojson(integer, geography, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGeoJson($1, $2, $3, 0)$_$;


ALTER FUNCTION public.st_asgeojson(integer, geography, integer) OWNER TO postgres;

--
-- TOC entry 433 (class 1255 OID 18787)
-- Dependencies: 6 1099
-- Name: st_asgeojson(geography, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgeojson(geography, integer, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGeoJson(1, $1, $2, $3)$_$;


ALTER FUNCTION public.st_asgeojson(geography, integer, integer) OWNER TO postgres;

--
-- TOC entry 427 (class 1255 OID 18781)
-- Dependencies: 1102 6
-- Name: st_asgeojson(integer, geometry, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgeojson(integer, geometry, integer, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGeoJson($1, $2, $3, $4)$_$;


ALTER FUNCTION public.st_asgeojson(integer, geometry, integer, integer) OWNER TO postgres;

--
-- TOC entry 434 (class 1255 OID 18788)
-- Dependencies: 6 1099
-- Name: st_asgeojson(integer, geography, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgeojson(integer, geography, integer, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGeoJson($1, $2, $3, $4)$_$;


ALTER FUNCTION public.st_asgeojson(integer, geography, integer, integer) OWNER TO postgres;

--
-- TOC entry 436 (class 1255 OID 18790)
-- Dependencies: 6 1102
-- Name: st_asgml(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgml(geometry) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGML(2, $1, 15, 0)$_$;


ALTER FUNCTION public.st_asgml(geometry) OWNER TO postgres;

--
-- TOC entry 442 (class 1255 OID 18796)
-- Dependencies: 1099 6
-- Name: st_asgml(geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgml(geography) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGML(2, $1, 15, 0)$_$;


ALTER FUNCTION public.st_asgml(geography) OWNER TO postgres;

--
-- TOC entry 443 (class 1255 OID 18797)
-- Dependencies: 6
-- Name: st_asgml(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgml(text) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_AsGML($1::geometry);  $_$;


ALTER FUNCTION public.st_asgml(text) OWNER TO postgres;

--
-- TOC entry 435 (class 1255 OID 18789)
-- Dependencies: 6 1102
-- Name: st_asgml(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgml(geometry, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGML(2, $1, $2, 0)$_$;


ALTER FUNCTION public.st_asgml(geometry, integer) OWNER TO postgres;

--
-- TOC entry 437 (class 1255 OID 18791)
-- Dependencies: 6 1102
-- Name: st_asgml(integer, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgml(integer, geometry) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGML($1, $2, 15, 0)$_$;


ALTER FUNCTION public.st_asgml(integer, geometry) OWNER TO postgres;

--
-- TOC entry 441 (class 1255 OID 18795)
-- Dependencies: 6 1099
-- Name: st_asgml(geography, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgml(geography, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGML(2, $1, $2, 0)$_$;


ALTER FUNCTION public.st_asgml(geography, integer) OWNER TO postgres;

--
-- TOC entry 444 (class 1255 OID 18798)
-- Dependencies: 6 1099
-- Name: st_asgml(integer, geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgml(integer, geography) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGML($1, $2, 15, 0)$_$;


ALTER FUNCTION public.st_asgml(integer, geography) OWNER TO postgres;

--
-- TOC entry 438 (class 1255 OID 18792)
-- Dependencies: 6 1102
-- Name: st_asgml(integer, geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgml(integer, geometry, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGML($1, $2, $3, 0)$_$;


ALTER FUNCTION public.st_asgml(integer, geometry, integer) OWNER TO postgres;

--
-- TOC entry 439 (class 1255 OID 18793)
-- Dependencies: 6 1102
-- Name: st_asgml(geometry, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgml(geometry, integer, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGML(2, $1, $2, $3)$_$;


ALTER FUNCTION public.st_asgml(geometry, integer, integer) OWNER TO postgres;

--
-- TOC entry 445 (class 1255 OID 18799)
-- Dependencies: 6 1099
-- Name: st_asgml(integer, geography, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgml(integer, geography, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGML($1, $2, $3, 0)$_$;


ALTER FUNCTION public.st_asgml(integer, geography, integer) OWNER TO postgres;

--
-- TOC entry 446 (class 1255 OID 18800)
-- Dependencies: 6 1099
-- Name: st_asgml(geography, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgml(geography, integer, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGML(2, $1, $2, $3)$_$;


ALTER FUNCTION public.st_asgml(geography, integer, integer) OWNER TO postgres;

--
-- TOC entry 440 (class 1255 OID 18794)
-- Dependencies: 6 1102
-- Name: st_asgml(integer, geometry, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgml(integer, geometry, integer, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGML($1, $2, $3, $4)$_$;


ALTER FUNCTION public.st_asgml(integer, geometry, integer, integer) OWNER TO postgres;

--
-- TOC entry 447 (class 1255 OID 18801)
-- Dependencies: 6 1099
-- Name: st_asgml(integer, geography, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgml(integer, geography, integer, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsGML($1, $2, $3, $4)$_$;


ALTER FUNCTION public.st_asgml(integer, geography, integer, integer) OWNER TO postgres;

--
-- TOC entry 448 (class 1255 OID 18802)
-- Dependencies: 6 1102
-- Name: st_ashexewkb(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_ashexewkb(geometry) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_asHEXEWKB';


ALTER FUNCTION public.st_ashexewkb(geometry) OWNER TO postgres;

--
-- TOC entry 449 (class 1255 OID 18803)
-- Dependencies: 6 1102
-- Name: st_ashexewkb(geometry, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_ashexewkb(geometry, text) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_asHEXEWKB';


ALTER FUNCTION public.st_ashexewkb(geometry, text) OWNER TO postgres;

--
-- TOC entry 451 (class 1255 OID 18805)
-- Dependencies: 6 1102
-- Name: st_askml(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_askml(geometry) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsKML(2, ST_Transform($1,4326), 15)$_$;


ALTER FUNCTION public.st_askml(geometry) OWNER TO postgres;

--
-- TOC entry 455 (class 1255 OID 18809)
-- Dependencies: 6 1099
-- Name: st_askml(geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_askml(geography) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsKML(2, $1, 15)$_$;


ALTER FUNCTION public.st_askml(geography) OWNER TO postgres;

--
-- TOC entry 456 (class 1255 OID 18810)
-- Dependencies: 6
-- Name: st_askml(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_askml(text) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_AsKML($1::geometry);  $_$;


ALTER FUNCTION public.st_askml(text) OWNER TO postgres;

--
-- TOC entry 450 (class 1255 OID 18804)
-- Dependencies: 6 1102
-- Name: st_askml(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_askml(geometry, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsKML(2, ST_Transform($1,4326), $2)$_$;


ALTER FUNCTION public.st_askml(geometry, integer) OWNER TO postgres;

--
-- TOC entry 452 (class 1255 OID 18806)
-- Dependencies: 6 1102
-- Name: st_askml(integer, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_askml(integer, geometry) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsKML($1, ST_Transform($2,4326), 15)$_$;


ALTER FUNCTION public.st_askml(integer, geometry) OWNER TO postgres;

--
-- TOC entry 454 (class 1255 OID 18808)
-- Dependencies: 6 1099
-- Name: st_askml(geography, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_askml(geography, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsKML(2, $1, $2)$_$;


ALTER FUNCTION public.st_askml(geography, integer) OWNER TO postgres;

--
-- TOC entry 457 (class 1255 OID 18811)
-- Dependencies: 6 1099
-- Name: st_askml(integer, geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_askml(integer, geography) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsKML($1, $2, 15)$_$;


ALTER FUNCTION public.st_askml(integer, geography) OWNER TO postgres;

--
-- TOC entry 453 (class 1255 OID 18807)
-- Dependencies: 6 1102
-- Name: st_askml(integer, geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_askml(integer, geometry, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsKML($1, ST_Transform($2,4326), $3)$_$;


ALTER FUNCTION public.st_askml(integer, geometry, integer) OWNER TO postgres;

--
-- TOC entry 458 (class 1255 OID 18812)
-- Dependencies: 6 1099
-- Name: st_askml(integer, geography, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_askml(integer, geography, integer) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsKML($1, $2, $3)$_$;


ALTER FUNCTION public.st_askml(integer, geography, integer) OWNER TO postgres;

--
-- TOC entry 461 (class 1255 OID 18815)
-- Dependencies: 6 1102
-- Name: st_assvg(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_assvg(geometry) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'assvg_geometry';


ALTER FUNCTION public.st_assvg(geometry) OWNER TO postgres;

--
-- TOC entry 464 (class 1255 OID 18818)
-- Dependencies: 6 1099
-- Name: st_assvg(geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_assvg(geography) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_as_svg';


ALTER FUNCTION public.st_assvg(geography) OWNER TO postgres;

--
-- TOC entry 465 (class 1255 OID 18819)
-- Dependencies: 6
-- Name: st_assvg(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_assvg(text) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_AsSVG($1::geometry);  $_$;


ALTER FUNCTION public.st_assvg(text) OWNER TO postgres;

--
-- TOC entry 460 (class 1255 OID 18814)
-- Dependencies: 6 1102
-- Name: st_assvg(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_assvg(geometry, integer) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'assvg_geometry';


ALTER FUNCTION public.st_assvg(geometry, integer) OWNER TO postgres;

--
-- TOC entry 463 (class 1255 OID 18817)
-- Dependencies: 6 1099
-- Name: st_assvg(geography, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_assvg(geography, integer) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_as_svg';


ALTER FUNCTION public.st_assvg(geography, integer) OWNER TO postgres;

--
-- TOC entry 459 (class 1255 OID 18813)
-- Dependencies: 6 1102
-- Name: st_assvg(geometry, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_assvg(geometry, integer, integer) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'assvg_geometry';


ALTER FUNCTION public.st_assvg(geometry, integer, integer) OWNER TO postgres;

--
-- TOC entry 462 (class 1255 OID 18816)
-- Dependencies: 6 1099
-- Name: st_assvg(geography, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_assvg(geography, integer, integer) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_as_svg';


ALTER FUNCTION public.st_assvg(geography, integer, integer) OWNER TO postgres;

--
-- TOC entry 466 (class 1255 OID 18820)
-- Dependencies: 6 1102
-- Name: st_astext(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_astext(geometry) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_asText';


ALTER FUNCTION public.st_astext(geometry) OWNER TO postgres;

--
-- TOC entry 467 (class 1255 OID 18821)
-- Dependencies: 6 1099
-- Name: st_astext(geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_astext(geography) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_as_text';


ALTER FUNCTION public.st_astext(geography) OWNER TO postgres;

--
-- TOC entry 468 (class 1255 OID 18822)
-- Dependencies: 6
-- Name: st_astext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_astext(text) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_AsText($1::geometry);  $_$;


ALTER FUNCTION public.st_astext(text) OWNER TO postgres;

--
-- TOC entry 469 (class 1255 OID 18823)
-- Dependencies: 6 1102 1102
-- Name: st_azimuth(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_azimuth(geometry, geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_azimuth';


ALTER FUNCTION public.st_azimuth(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 470 (class 1255 OID 18824)
-- Dependencies: 6 1170 1102
-- Name: st_bdmpolyfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_bdmpolyfromtext(text, integer) RETURNS geometry
    LANGUAGE plpgsql IMMUTABLE STRICT
    AS $_$
DECLARE
	geomtext alias for $1;
	srid alias for $2;
	mline geometry;
	geom geometry;
BEGIN
	mline := ST_MultiLineStringFromText(geomtext, srid);

	IF mline IS NULL
	THEN
		RAISE EXCEPTION 'Input is not a MultiLinestring';
	END IF;

	geom := multi(ST_BuildArea(mline));

	RETURN geom;
END;
$_$;


ALTER FUNCTION public.st_bdmpolyfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 471 (class 1255 OID 18825)
-- Dependencies: 6 1170 1102
-- Name: st_bdpolyfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_bdpolyfromtext(text, integer) RETURNS geometry
    LANGUAGE plpgsql IMMUTABLE STRICT
    AS $_$
DECLARE
	geomtext alias for $1;
	srid alias for $2;
	mline geometry;
	geom geometry;
BEGIN
	mline := ST_MultiLineStringFromText(geomtext, srid);

	IF mline IS NULL
	THEN
		RAISE EXCEPTION 'Input is not a MultiLinestring';
	END IF;

	geom := ST_BuildArea(mline);

	IF GeometryType(geom) != 'POLYGON'
	THEN
		RAISE EXCEPTION 'Input returns more then a single polygon, try using BdMPolyFromText instead';
	END IF;

	RETURN geom;
END;
$_$;


ALTER FUNCTION public.st_bdpolyfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 472 (class 1255 OID 18826)
-- Dependencies: 6 1102 1102
-- Name: st_boundary(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_boundary(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'boundary';


ALTER FUNCTION public.st_boundary(geometry) OWNER TO postgres;

--
-- TOC entry 473 (class 1255 OID 18827)
-- Dependencies: 6 1102
-- Name: st_box(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_box(geometry) RETURNS box
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_to_BOX';


ALTER FUNCTION public.st_box(geometry) OWNER TO postgres;

--
-- TOC entry 474 (class 1255 OID 18828)
-- Dependencies: 6 1090
-- Name: st_box(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_box(box3d) RETURNS box
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_to_BOX';


ALTER FUNCTION public.st_box(box3d) OWNER TO postgres;

--
-- TOC entry 475 (class 1255 OID 18829)
-- Dependencies: 6 1087 1102
-- Name: st_box2d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_box2d(geometry) RETURNS box2d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_to_BOX2DFLOAT4';


ALTER FUNCTION public.st_box2d(geometry) OWNER TO postgres;

--
-- TOC entry 476 (class 1255 OID 18830)
-- Dependencies: 6 1087 1090
-- Name: st_box2d(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_box2d(box3d) RETURNS box2d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_to_BOX2DFLOAT4';


ALTER FUNCTION public.st_box2d(box3d) OWNER TO postgres;

--
-- TOC entry 477 (class 1255 OID 18831)
-- Dependencies: 6 1087 1093
-- Name: st_box2d(box3d_extent); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_box2d(box3d_extent) RETURNS box2d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_to_BOX2DFLOAT4';


ALTER FUNCTION public.st_box2d(box3d_extent) OWNER TO postgres;

--
-- TOC entry 478 (class 1255 OID 18832)
-- Dependencies: 6 1087
-- Name: st_box2d_in(cstring); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_box2d_in(cstring) RETURNS box2d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX2DFLOAT4_in';


ALTER FUNCTION public.st_box2d_in(cstring) OWNER TO postgres;

--
-- TOC entry 479 (class 1255 OID 18833)
-- Dependencies: 6 1087
-- Name: st_box2d_out(box2d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_box2d_out(box2d) RETURNS cstring
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX2DFLOAT4_out';


ALTER FUNCTION public.st_box2d_out(box2d) OWNER TO postgres;

--
-- TOC entry 480 (class 1255 OID 18834)
-- Dependencies: 6 1090 1102
-- Name: st_box3d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_box3d(geometry) RETURNS box3d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_to_BOX3D';


ALTER FUNCTION public.st_box3d(geometry) OWNER TO postgres;

--
-- TOC entry 481 (class 1255 OID 18835)
-- Dependencies: 6 1090 1087
-- Name: st_box3d(box2d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_box3d(box2d) RETURNS box3d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX2DFLOAT4_to_BOX3D';


ALTER FUNCTION public.st_box3d(box2d) OWNER TO postgres;

--
-- TOC entry 482 (class 1255 OID 18836)
-- Dependencies: 6 1090 1093
-- Name: st_box3d_extent(box3d_extent); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_box3d_extent(box3d_extent) RETURNS box3d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_extent_to_BOX3D';


ALTER FUNCTION public.st_box3d_extent(box3d_extent) OWNER TO postgres;

--
-- TOC entry 483 (class 1255 OID 18837)
-- Dependencies: 6 1090
-- Name: st_box3d_in(cstring); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_box3d_in(cstring) RETURNS box3d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_in';


ALTER FUNCTION public.st_box3d_in(cstring) OWNER TO postgres;

--
-- TOC entry 484 (class 1255 OID 18838)
-- Dependencies: 6 1090
-- Name: st_box3d_out(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_box3d_out(box3d) RETURNS cstring
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_out';


ALTER FUNCTION public.st_box3d_out(box3d) OWNER TO postgres;

--
-- TOC entry 485 (class 1255 OID 18839)
-- Dependencies: 6 1102 1102
-- Name: st_buffer(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_buffer(geometry, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'buffer';


ALTER FUNCTION public.st_buffer(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 488 (class 1255 OID 18842)
-- Dependencies: 6 1099 1099
-- Name: st_buffer(geography, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_buffer(geography, double precision) RETURNS geography
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT geography(ST_Transform(ST_Buffer(ST_Transform(geometry($1), _ST_BestSRID($1)), $2), 4326))$_$;


ALTER FUNCTION public.st_buffer(geography, double precision) OWNER TO postgres;

--
-- TOC entry 489 (class 1255 OID 18843)
-- Dependencies: 6 1102
-- Name: st_buffer(text, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_buffer(text, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_Buffer($1::geometry, $2);  $_$;


ALTER FUNCTION public.st_buffer(text, double precision) OWNER TO postgres;

--
-- TOC entry 486 (class 1255 OID 18840)
-- Dependencies: 6 1102 1102
-- Name: st_buffer(geometry, double precision, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_buffer(geometry, double precision, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT _ST_Buffer($1, $2,
		CAST('quad_segs='||CAST($3 AS text) as cstring))
	   $_$;


ALTER FUNCTION public.st_buffer(geometry, double precision, integer) OWNER TO postgres;

--
-- TOC entry 487 (class 1255 OID 18841)
-- Dependencies: 6 1102 1102
-- Name: st_buffer(geometry, double precision, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_buffer(geometry, double precision, text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT _ST_Buffer($1, $2,
		CAST( regexp_replace($3, '^[0123456789]+$',
			'quad_segs='||$3) AS cstring)
		)
	   $_$;


ALTER FUNCTION public.st_buffer(geometry, double precision, text) OWNER TO postgres;

--
-- TOC entry 490 (class 1255 OID 18844)
-- Dependencies: 6 1102 1102
-- Name: st_buildarea(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_buildarea(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'LWGEOM_buildarea';


ALTER FUNCTION public.st_buildarea(geometry) OWNER TO postgres;

--
-- TOC entry 491 (class 1255 OID 18845)
-- Dependencies: 6 1102
-- Name: st_bytea(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_bytea(geometry) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_to_bytea';


ALTER FUNCTION public.st_bytea(geometry) OWNER TO postgres;

--
-- TOC entry 492 (class 1255 OID 18846)
-- Dependencies: 6 1102 1102
-- Name: st_centroid(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_centroid(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'centroid';


ALTER FUNCTION public.st_centroid(geometry) OWNER TO postgres;

--
-- TOC entry 493 (class 1255 OID 18847)
-- Dependencies: 6 1096
-- Name: st_chip_in(cstring); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_chip_in(cstring) RETURNS chip
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_in';


ALTER FUNCTION public.st_chip_in(cstring) OWNER TO postgres;

--
-- TOC entry 494 (class 1255 OID 18848)
-- Dependencies: 6 1096
-- Name: st_chip_out(chip); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_chip_out(chip) RETURNS cstring
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_out';


ALTER FUNCTION public.st_chip_out(chip) OWNER TO postgres;

--
-- TOC entry 495 (class 1255 OID 18849)
-- Dependencies: 6 1102 1102 1102
-- Name: st_closestpoint(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_closestpoint(geometry, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_closestpoint';


ALTER FUNCTION public.st_closestpoint(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 497 (class 1255 OID 18851)
-- Dependencies: 6 1102 1104
-- Name: st_collect(geometry[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_collect(geometry[]) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_collect_garray';


ALTER FUNCTION public.st_collect(geometry[]) OWNER TO postgres;

--
-- TOC entry 496 (class 1255 OID 18850)
-- Dependencies: 6 1102 1102 1102
-- Name: st_collect(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_collect(geometry, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE
    AS '$libdir/postgis-1.5', 'LWGEOM_collect';


ALTER FUNCTION public.st_collect(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 498 (class 1255 OID 18852)
-- Dependencies: 6 1102 1102
-- Name: st_collectionextract(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_collectionextract(geometry, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'ST_CollectionExtract';


ALTER FUNCTION public.st_collectionextract(geometry, integer) OWNER TO postgres;

--
-- TOC entry 499 (class 1255 OID 18853)
-- Dependencies: 6 1087 1087 1102
-- Name: st_combine_bbox(box2d, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_combine_bbox(box2d, geometry) RETURNS box2d
    LANGUAGE c IMMUTABLE
    AS '$libdir/postgis-1.5', 'BOX2DFLOAT4_combine';


ALTER FUNCTION public.st_combine_bbox(box2d, geometry) OWNER TO postgres;

--
-- TOC entry 500 (class 1255 OID 18854)
-- Dependencies: 6 1093 1093 1102
-- Name: st_combine_bbox(box3d_extent, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_combine_bbox(box3d_extent, geometry) RETURNS box3d_extent
    LANGUAGE c IMMUTABLE
    AS '$libdir/postgis-1.5', 'BOX3D_combine';


ALTER FUNCTION public.st_combine_bbox(box3d_extent, geometry) OWNER TO postgres;

--
-- TOC entry 501 (class 1255 OID 18855)
-- Dependencies: 6 1090 1090 1102
-- Name: st_combine_bbox(box3d, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_combine_bbox(box3d, geometry) RETURNS box3d
    LANGUAGE c IMMUTABLE
    AS '$libdir/postgis-1.5', 'BOX3D_combine';


ALTER FUNCTION public.st_combine_bbox(box3d, geometry) OWNER TO postgres;

--
-- TOC entry 502 (class 1255 OID 18856)
-- Dependencies: 6 1096
-- Name: st_compression(chip); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_compression(chip) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_getCompression';


ALTER FUNCTION public.st_compression(chip) OWNER TO postgres;

--
-- TOC entry 503 (class 1255 OID 18857)
-- Dependencies: 6 1102 1102
-- Name: st_contains(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_contains(geometry, geometry) RETURNS boolean
    LANGUAGE sql IMMUTABLE
    AS $_$SELECT $1 && $2 AND _ST_Contains($1,$2)$_$;


ALTER FUNCTION public.st_contains(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 504 (class 1255 OID 18858)
-- Dependencies: 6 1102 1102
-- Name: st_containsproperly(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_containsproperly(geometry, geometry) RETURNS boolean
    LANGUAGE sql IMMUTABLE
    AS $_$SELECT $1 && $2 AND _ST_ContainsProperly($1,$2)$_$;


ALTER FUNCTION public.st_containsproperly(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 505 (class 1255 OID 18859)
-- Dependencies: 6 1102 1102
-- Name: st_convexhull(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_convexhull(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'convexhull';


ALTER FUNCTION public.st_convexhull(geometry) OWNER TO postgres;

--
-- TOC entry 506 (class 1255 OID 18860)
-- Dependencies: 6 1102
-- Name: st_coorddim(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_coorddim(geometry) RETURNS smallint
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_ndims';


ALTER FUNCTION public.st_coorddim(geometry) OWNER TO postgres;

--
-- TOC entry 507 (class 1255 OID 18861)
-- Dependencies: 6 1102 1102
-- Name: st_coveredby(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_coveredby(geometry, geometry) RETURNS boolean
    LANGUAGE sql IMMUTABLE
    AS $_$SELECT $1 && $2 AND _ST_CoveredBy($1,$2)$_$;


ALTER FUNCTION public.st_coveredby(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 508 (class 1255 OID 18862)
-- Dependencies: 6 1099 1099
-- Name: st_coveredby(geography, geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_coveredby(geography, geography) RETURNS boolean
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT $1 && $2 AND _ST_Covers($2, $1)$_$;


ALTER FUNCTION public.st_coveredby(geography, geography) OWNER TO postgres;

--
-- TOC entry 509 (class 1255 OID 18863)
-- Dependencies: 6
-- Name: st_coveredby(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_coveredby(text, text) RETURNS boolean
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_CoveredBy($1::geometry, $2::geometry);  $_$;


ALTER FUNCTION public.st_coveredby(text, text) OWNER TO postgres;

--
-- TOC entry 510 (class 1255 OID 18864)
-- Dependencies: 6 1102 1102
-- Name: st_covers(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_covers(geometry, geometry) RETURNS boolean
    LANGUAGE sql IMMUTABLE
    AS $_$SELECT $1 && $2 AND _ST_Covers($1,$2)$_$;


ALTER FUNCTION public.st_covers(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 511 (class 1255 OID 18865)
-- Dependencies: 6 1099 1099
-- Name: st_covers(geography, geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_covers(geography, geography) RETURNS boolean
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT $1 && $2 AND _ST_Covers($1, $2)$_$;


ALTER FUNCTION public.st_covers(geography, geography) OWNER TO postgres;

--
-- TOC entry 512 (class 1255 OID 18866)
-- Dependencies: 6
-- Name: st_covers(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_covers(text, text) RETURNS boolean
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_Covers($1::geometry, $2::geometry);  $_$;


ALTER FUNCTION public.st_covers(text, text) OWNER TO postgres;

--
-- TOC entry 513 (class 1255 OID 18867)
-- Dependencies: 6 1102 1102
-- Name: st_crosses(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_crosses(geometry, geometry) RETURNS boolean
    LANGUAGE sql IMMUTABLE
    AS $_$SELECT $1 && $2 AND _ST_Crosses($1,$2)$_$;


ALTER FUNCTION public.st_crosses(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 515 (class 1255 OID 18869)
-- Dependencies: 6 1102 1102
-- Name: st_curvetoline(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_curvetoline(geometry) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT ST_CurveToLine($1, 32)$_$;


ALTER FUNCTION public.st_curvetoline(geometry) OWNER TO postgres;

--
-- TOC entry 514 (class 1255 OID 18868)
-- Dependencies: 6 1102 1102
-- Name: st_curvetoline(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_curvetoline(geometry, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_curve_segmentize';


ALTER FUNCTION public.st_curvetoline(geometry, integer) OWNER TO postgres;

--
-- TOC entry 516 (class 1255 OID 18870)
-- Dependencies: 6 1096
-- Name: st_datatype(chip); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_datatype(chip) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_getDatatype';


ALTER FUNCTION public.st_datatype(chip) OWNER TO postgres;

--
-- TOC entry 517 (class 1255 OID 18871)
-- Dependencies: 6 1102 1102
-- Name: st_dfullywithin(geometry, geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_dfullywithin(geometry, geometry, double precision) RETURNS boolean
    LANGUAGE sql IMMUTABLE
    AS $_$SELECT $1 && ST_Expand($2,$3) AND $2 && ST_Expand($1,$3) AND _ST_DFullyWithin(ST_ConvexHull($1), ST_ConvexHull($2), $3)$_$;


ALTER FUNCTION public.st_dfullywithin(geometry, geometry, double precision) OWNER TO postgres;

--
-- TOC entry 518 (class 1255 OID 18872)
-- Dependencies: 6 1102 1102 1102
-- Name: st_difference(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_difference(geometry, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'difference';


ALTER FUNCTION public.st_difference(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 519 (class 1255 OID 18873)
-- Dependencies: 6 1102
-- Name: st_dimension(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_dimension(geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_dimension';


ALTER FUNCTION public.st_dimension(geometry) OWNER TO postgres;

--
-- TOC entry 520 (class 1255 OID 18874)
-- Dependencies: 6 1102 1102
-- Name: st_disjoint(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_disjoint(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'disjoint';


ALTER FUNCTION public.st_disjoint(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 521 (class 1255 OID 18875)
-- Dependencies: 6 1102 1102
-- Name: st_distance(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_distance(geometry, geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'LWGEOM_mindistance2d';


ALTER FUNCTION public.st_distance(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 523 (class 1255 OID 18877)
-- Dependencies: 6 1099 1099
-- Name: st_distance(geography, geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_distance(geography, geography) RETURNS double precision
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_Distance($1, $2, 0.0, true)$_$;


ALTER FUNCTION public.st_distance(geography, geography) OWNER TO postgres;

--
-- TOC entry 524 (class 1255 OID 18878)
-- Dependencies: 6
-- Name: st_distance(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_distance(text, text) RETURNS double precision
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_Distance($1::geometry, $2::geometry);  $_$;


ALTER FUNCTION public.st_distance(text, text) OWNER TO postgres;

--
-- TOC entry 522 (class 1255 OID 18876)
-- Dependencies: 6 1099 1099
-- Name: st_distance(geography, geography, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_distance(geography, geography, boolean) RETURNS double precision
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_Distance($1, $2, 0.0, $3)$_$;


ALTER FUNCTION public.st_distance(geography, geography, boolean) OWNER TO postgres;

--
-- TOC entry 525 (class 1255 OID 18879)
-- Dependencies: 6 1102 1102
-- Name: st_distance_sphere(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_distance_sphere(geometry, geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'LWGEOM_distance_sphere';


ALTER FUNCTION public.st_distance_sphere(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 526 (class 1255 OID 18880)
-- Dependencies: 6 1102 1102 1113
-- Name: st_distance_spheroid(geometry, geometry, spheroid); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_distance_spheroid(geometry, geometry, spheroid) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'LWGEOM_distance_ellipsoid';


ALTER FUNCTION public.st_distance_spheroid(geometry, geometry, spheroid) OWNER TO postgres;

--
-- TOC entry 527 (class 1255 OID 18881)
-- Dependencies: 6 1105 1102
-- Name: st_dump(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_dump(geometry) RETURNS SETOF geometry_dump
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_dump';


ALTER FUNCTION public.st_dump(geometry) OWNER TO postgres;

--
-- TOC entry 528 (class 1255 OID 18882)
-- Dependencies: 6 1105 1102
-- Name: st_dumppoints(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_dumppoints(geometry) RETURNS SETOF geometry_dump
    LANGUAGE sql
    AS $_$
  SELECT * FROM _ST_DumpPoints($1, NULL);
$_$;


ALTER FUNCTION public.st_dumppoints(geometry) OWNER TO postgres;

--
-- TOC entry 529 (class 1255 OID 18883)
-- Dependencies: 6 1105 1102
-- Name: st_dumprings(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_dumprings(geometry) RETURNS SETOF geometry_dump
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_dump_rings';


ALTER FUNCTION public.st_dumprings(geometry) OWNER TO postgres;

--
-- TOC entry 530 (class 1255 OID 18884)
-- Dependencies: 6 1102 1102
-- Name: st_dwithin(geometry, geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_dwithin(geometry, geometry, double precision) RETURNS boolean
    LANGUAGE sql IMMUTABLE
    AS $_$SELECT $1 && ST_Expand($2,$3) AND $2 && ST_Expand($1,$3) AND _ST_DWithin($1, $2, $3)$_$;


ALTER FUNCTION public.st_dwithin(geometry, geometry, double precision) OWNER TO postgres;

--
-- TOC entry 532 (class 1255 OID 18886)
-- Dependencies: 6 1099 1099
-- Name: st_dwithin(geography, geography, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_dwithin(geography, geography, double precision) RETURNS boolean
    LANGUAGE sql IMMUTABLE
    AS $_$SELECT $1 && _ST_Expand($2,$3) AND $2 && _ST_Expand($1,$3) AND _ST_DWithin($1, $2, $3, true)$_$;


ALTER FUNCTION public.st_dwithin(geography, geography, double precision) OWNER TO postgres;

--
-- TOC entry 533 (class 1255 OID 18887)
-- Dependencies: 6
-- Name: st_dwithin(text, text, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_dwithin(text, text, double precision) RETURNS boolean
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_DWithin($1::geometry, $2::geometry, $3);  $_$;


ALTER FUNCTION public.st_dwithin(text, text, double precision) OWNER TO postgres;

--
-- TOC entry 531 (class 1255 OID 18885)
-- Dependencies: 6 1099 1099
-- Name: st_dwithin(geography, geography, double precision, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_dwithin(geography, geography, double precision, boolean) RETURNS boolean
    LANGUAGE sql IMMUTABLE
    AS $_$SELECT $1 && _ST_Expand($2,$3) AND $2 && _ST_Expand($1,$3) AND _ST_DWithin($1, $2, $3, $4)$_$;


ALTER FUNCTION public.st_dwithin(geography, geography, double precision, boolean) OWNER TO postgres;

--
-- TOC entry 534 (class 1255 OID 18888)
-- Dependencies: 6 1102 1102
-- Name: st_endpoint(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_endpoint(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_endpoint_linestring';


ALTER FUNCTION public.st_endpoint(geometry) OWNER TO postgres;

--
-- TOC entry 535 (class 1255 OID 18889)
-- Dependencies: 6 1102 1102
-- Name: st_envelope(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_envelope(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_envelope';


ALTER FUNCTION public.st_envelope(geometry) OWNER TO postgres;

--
-- TOC entry 536 (class 1255 OID 18890)
-- Dependencies: 6 1102 1102
-- Name: st_equals(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_equals(geometry, geometry) RETURNS boolean
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT $1 && $2 AND _ST_Equals($1,$2)$_$;


ALTER FUNCTION public.st_equals(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 538 (class 1255 OID 18892)
-- Dependencies: 6 1087
-- Name: st_estimated_extent(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_estimated_extent(text, text) RETURNS box2d
    LANGUAGE c IMMUTABLE STRICT SECURITY DEFINER
    AS '$libdir/postgis-1.5', 'LWGEOM_estimated_extent';


ALTER FUNCTION public.st_estimated_extent(text, text) OWNER TO postgres;

--
-- TOC entry 537 (class 1255 OID 18891)
-- Dependencies: 6 1087
-- Name: st_estimated_extent(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_estimated_extent(text, text, text) RETURNS box2d
    LANGUAGE c IMMUTABLE STRICT SECURITY DEFINER
    AS '$libdir/postgis-1.5', 'LWGEOM_estimated_extent';


ALTER FUNCTION public.st_estimated_extent(text, text, text) OWNER TO postgres;

--
-- TOC entry 539 (class 1255 OID 18893)
-- Dependencies: 6 1090 1090
-- Name: st_expand(box3d, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_expand(box3d, double precision) RETURNS box3d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_expand';


ALTER FUNCTION public.st_expand(box3d, double precision) OWNER TO postgres;

--
-- TOC entry 540 (class 1255 OID 18896)
-- Dependencies: 6 1087 1087
-- Name: st_expand(box2d, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_expand(box2d, double precision) RETURNS box2d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX2DFLOAT4_expand';


ALTER FUNCTION public.st_expand(box2d, double precision) OWNER TO postgres;

--
-- TOC entry 541 (class 1255 OID 18897)
-- Dependencies: 6 1102 1102
-- Name: st_expand(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_expand(geometry, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_expand';


ALTER FUNCTION public.st_expand(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 542 (class 1255 OID 18898)
-- Dependencies: 6 1102 1102
-- Name: st_exteriorring(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_exteriorring(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_exteriorring_polygon';


ALTER FUNCTION public.st_exteriorring(geometry) OWNER TO postgres;

--
-- TOC entry 543 (class 1255 OID 18899)
-- Dependencies: 6 1096
-- Name: st_factor(chip); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_factor(chip) RETURNS real
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_getFactor';


ALTER FUNCTION public.st_factor(chip) OWNER TO postgres;

--
-- TOC entry 545 (class 1255 OID 18901)
-- Dependencies: 6 1170 1087
-- Name: st_find_extent(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_find_extent(text, text) RETURNS box2d
    LANGUAGE plpgsql IMMUTABLE STRICT
    AS $_$
DECLARE
	tablename alias for $1;
	columnname alias for $2;
	myrec RECORD;

BEGIN
	FOR myrec IN EXECUTE 'SELECT extent("' || columnname || '") FROM "' || tablename || '"' LOOP
		return myrec.extent;
	END LOOP;
END;
$_$;


ALTER FUNCTION public.st_find_extent(text, text) OWNER TO postgres;

--
-- TOC entry 544 (class 1255 OID 18900)
-- Dependencies: 6 1170 1087
-- Name: st_find_extent(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_find_extent(text, text, text) RETURNS box2d
    LANGUAGE plpgsql IMMUTABLE STRICT
    AS $_$
DECLARE
	schemaname alias for $1;
	tablename alias for $2;
	columnname alias for $3;
	myrec RECORD;

BEGIN
	FOR myrec IN EXECUTE 'SELECT extent("' || columnname || '") FROM "' || schemaname || '"."' || tablename || '"' LOOP
		return myrec.extent;
	END LOOP;
END;
$_$;


ALTER FUNCTION public.st_find_extent(text, text, text) OWNER TO postgres;

--
-- TOC entry 546 (class 1255 OID 18902)
-- Dependencies: 6 1102 1102
-- Name: st_force_2d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_force_2d(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_force_2d';


ALTER FUNCTION public.st_force_2d(geometry) OWNER TO postgres;

--
-- TOC entry 547 (class 1255 OID 18903)
-- Dependencies: 6 1102 1102
-- Name: st_force_3d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_force_3d(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_force_3dz';


ALTER FUNCTION public.st_force_3d(geometry) OWNER TO postgres;

--
-- TOC entry 548 (class 1255 OID 18904)
-- Dependencies: 6 1102 1102
-- Name: st_force_3dm(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_force_3dm(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_force_3dm';


ALTER FUNCTION public.st_force_3dm(geometry) OWNER TO postgres;

--
-- TOC entry 549 (class 1255 OID 18905)
-- Dependencies: 6 1102 1102
-- Name: st_force_3dz(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_force_3dz(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_force_3dz';


ALTER FUNCTION public.st_force_3dz(geometry) OWNER TO postgres;

--
-- TOC entry 550 (class 1255 OID 18906)
-- Dependencies: 6 1102 1102
-- Name: st_force_4d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_force_4d(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_force_4d';


ALTER FUNCTION public.st_force_4d(geometry) OWNER TO postgres;

--
-- TOC entry 551 (class 1255 OID 18907)
-- Dependencies: 6 1102 1102
-- Name: st_force_collection(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_force_collection(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_force_collection';


ALTER FUNCTION public.st_force_collection(geometry) OWNER TO postgres;

--
-- TOC entry 552 (class 1255 OID 18908)
-- Dependencies: 6 1102 1102
-- Name: st_forcerhr(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_forcerhr(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_forceRHR_poly';


ALTER FUNCTION public.st_forcerhr(geometry) OWNER TO postgres;

--
-- TOC entry 553 (class 1255 OID 18909)
-- Dependencies: 6 1099
-- Name: st_geogfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geogfromtext(text) RETURNS geography
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_from_text';


ALTER FUNCTION public.st_geogfromtext(text) OWNER TO postgres;

--
-- TOC entry 554 (class 1255 OID 18910)
-- Dependencies: 6 1099
-- Name: st_geogfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geogfromwkb(bytea) RETURNS geography
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_from_binary';


ALTER FUNCTION public.st_geogfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 555 (class 1255 OID 18911)
-- Dependencies: 6 1099
-- Name: st_geographyfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geographyfromtext(text) RETURNS geography
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geography_from_text';


ALTER FUNCTION public.st_geographyfromtext(text) OWNER TO postgres;

--
-- TOC entry 557 (class 1255 OID 18913)
-- Dependencies: 6 1102
-- Name: st_geohash(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geohash(geometry) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT ST_GeoHash($1, 0)$_$;


ALTER FUNCTION public.st_geohash(geometry) OWNER TO postgres;

--
-- TOC entry 556 (class 1255 OID 18912)
-- Dependencies: 6 1102
-- Name: st_geohash(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geohash(geometry, integer) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'ST_GeoHash';


ALTER FUNCTION public.st_geohash(geometry, integer) OWNER TO postgres;

--
-- TOC entry 559 (class 1255 OID 18915)
-- Dependencies: 6 1102
-- Name: st_geomcollfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geomcollfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE
	WHEN geometrytype(ST_GeomFromText($1)) = 'GEOMETRYCOLLECTION'
	THEN ST_GeomFromText($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_geomcollfromtext(text) OWNER TO postgres;

--
-- TOC entry 558 (class 1255 OID 18914)
-- Dependencies: 6 1102
-- Name: st_geomcollfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geomcollfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE
	WHEN geometrytype(ST_GeomFromText($1, $2)) = 'GEOMETRYCOLLECTION'
	THEN ST_GeomFromText($1,$2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_geomcollfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 561 (class 1255 OID 18917)
-- Dependencies: 6 1102
-- Name: st_geomcollfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geomcollfromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE
	WHEN geometrytype(ST_GeomFromWKB($1)) = 'GEOMETRYCOLLECTION'
	THEN ST_GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_geomcollfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 560 (class 1255 OID 18916)
-- Dependencies: 6 1102
-- Name: st_geomcollfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geomcollfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE
	WHEN geometrytype(GeomFromWKB($1, $2)) = 'GEOMETRYCOLLECTION'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_geomcollfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 562 (class 1255 OID 18918)
-- Dependencies: 6 1102 1087
-- Name: st_geometry(box2d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry(box2d) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX2DFLOAT4_to_LWGEOM';


ALTER FUNCTION public.st_geometry(box2d) OWNER TO postgres;

--
-- TOC entry 563 (class 1255 OID 18919)
-- Dependencies: 6 1102 1090
-- Name: st_geometry(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry(box3d) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_to_LWGEOM';


ALTER FUNCTION public.st_geometry(box3d) OWNER TO postgres;

--
-- TOC entry 564 (class 1255 OID 18920)
-- Dependencies: 6 1102
-- Name: st_geometry(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry(text) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'parse_WKT_lwgeom';


ALTER FUNCTION public.st_geometry(text) OWNER TO postgres;

--
-- TOC entry 565 (class 1255 OID 18921)
-- Dependencies: 6 1102 1096
-- Name: st_geometry(chip); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry(chip) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_to_LWGEOM';


ALTER FUNCTION public.st_geometry(chip) OWNER TO postgres;

--
-- TOC entry 566 (class 1255 OID 18922)
-- Dependencies: 6 1102
-- Name: st_geometry(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry(bytea) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_from_bytea';


ALTER FUNCTION public.st_geometry(bytea) OWNER TO postgres;

--
-- TOC entry 567 (class 1255 OID 18923)
-- Dependencies: 6 1102 1093
-- Name: st_geometry(box3d_extent); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry(box3d_extent) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_to_LWGEOM';


ALTER FUNCTION public.st_geometry(box3d_extent) OWNER TO postgres;

--
-- TOC entry 568 (class 1255 OID 18924)
-- Dependencies: 6 1102 1102
-- Name: st_geometry_above(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_above(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_above';


ALTER FUNCTION public.st_geometry_above(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 569 (class 1255 OID 18925)
-- Dependencies: 6
-- Name: st_geometry_analyze(internal); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_analyze(internal) RETURNS boolean
    LANGUAGE c STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_analyze';


ALTER FUNCTION public.st_geometry_analyze(internal) OWNER TO postgres;

--
-- TOC entry 570 (class 1255 OID 18926)
-- Dependencies: 6 1102 1102
-- Name: st_geometry_below(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_below(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_below';


ALTER FUNCTION public.st_geometry_below(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 571 (class 1255 OID 18927)
-- Dependencies: 6 1102 1102
-- Name: st_geometry_cmp(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_cmp(geometry, geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'lwgeom_cmp';


ALTER FUNCTION public.st_geometry_cmp(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 572 (class 1255 OID 18928)
-- Dependencies: 6 1102 1102
-- Name: st_geometry_contain(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_contain(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_contain';


ALTER FUNCTION public.st_geometry_contain(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 573 (class 1255 OID 18929)
-- Dependencies: 6 1102 1102
-- Name: st_geometry_contained(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_contained(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_contained';


ALTER FUNCTION public.st_geometry_contained(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 574 (class 1255 OID 18930)
-- Dependencies: 6 1102 1102
-- Name: st_geometry_eq(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_eq(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'lwgeom_eq';


ALTER FUNCTION public.st_geometry_eq(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 575 (class 1255 OID 18931)
-- Dependencies: 6 1102 1102
-- Name: st_geometry_ge(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_ge(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'lwgeom_ge';


ALTER FUNCTION public.st_geometry_ge(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 576 (class 1255 OID 18932)
-- Dependencies: 6 1102 1102
-- Name: st_geometry_gt(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_gt(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'lwgeom_gt';


ALTER FUNCTION public.st_geometry_gt(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 577 (class 1255 OID 18933)
-- Dependencies: 6 1102
-- Name: st_geometry_in(cstring); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_in(cstring) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_in';


ALTER FUNCTION public.st_geometry_in(cstring) OWNER TO postgres;

--
-- TOC entry 578 (class 1255 OID 18934)
-- Dependencies: 6 1102 1102
-- Name: st_geometry_le(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_le(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'lwgeom_le';


ALTER FUNCTION public.st_geometry_le(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 579 (class 1255 OID 18935)
-- Dependencies: 6 1102 1102
-- Name: st_geometry_left(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_left(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_left';


ALTER FUNCTION public.st_geometry_left(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 580 (class 1255 OID 18936)
-- Dependencies: 6 1102 1102
-- Name: st_geometry_lt(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_lt(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'lwgeom_lt';


ALTER FUNCTION public.st_geometry_lt(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 581 (class 1255 OID 18937)
-- Dependencies: 6 1102
-- Name: st_geometry_out(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_out(geometry) RETURNS cstring
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_out';


ALTER FUNCTION public.st_geometry_out(geometry) OWNER TO postgres;

--
-- TOC entry 582 (class 1255 OID 18938)
-- Dependencies: 6 1102 1102
-- Name: st_geometry_overabove(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_overabove(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_overabove';


ALTER FUNCTION public.st_geometry_overabove(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 583 (class 1255 OID 18939)
-- Dependencies: 6 1102 1102
-- Name: st_geometry_overbelow(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_overbelow(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_overbelow';


ALTER FUNCTION public.st_geometry_overbelow(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 584 (class 1255 OID 18940)
-- Dependencies: 6 1102 1102
-- Name: st_geometry_overlap(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_overlap(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_overlap';


ALTER FUNCTION public.st_geometry_overlap(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 585 (class 1255 OID 18941)
-- Dependencies: 6 1102 1102
-- Name: st_geometry_overleft(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_overleft(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_overleft';


ALTER FUNCTION public.st_geometry_overleft(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 586 (class 1255 OID 18942)
-- Dependencies: 6 1102 1102
-- Name: st_geometry_overright(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_overright(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_overright';


ALTER FUNCTION public.st_geometry_overright(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 587 (class 1255 OID 18943)
-- Dependencies: 6 1102
-- Name: st_geometry_recv(internal); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_recv(internal) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_recv';


ALTER FUNCTION public.st_geometry_recv(internal) OWNER TO postgres;

--
-- TOC entry 588 (class 1255 OID 18944)
-- Dependencies: 6 1102 1102
-- Name: st_geometry_right(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_right(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_right';


ALTER FUNCTION public.st_geometry_right(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 589 (class 1255 OID 18945)
-- Dependencies: 6 1102 1102
-- Name: st_geometry_same(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_same(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_samebox';


ALTER FUNCTION public.st_geometry_same(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 590 (class 1255 OID 18946)
-- Dependencies: 6 1102
-- Name: st_geometry_send(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometry_send(geometry) RETURNS bytea
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_send';


ALTER FUNCTION public.st_geometry_send(geometry) OWNER TO postgres;

--
-- TOC entry 591 (class 1255 OID 18947)
-- Dependencies: 6 1102
-- Name: st_geometryfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometryfromtext(text) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_from_text';


ALTER FUNCTION public.st_geometryfromtext(text) OWNER TO postgres;

--
-- TOC entry 592 (class 1255 OID 18948)
-- Dependencies: 6 1102
-- Name: st_geometryfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometryfromtext(text, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_from_text';


ALTER FUNCTION public.st_geometryfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 593 (class 1255 OID 18949)
-- Dependencies: 6 1102 1102
-- Name: st_geometryn(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometryn(geometry, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_geometryn_collection';


ALTER FUNCTION public.st_geometryn(geometry, integer) OWNER TO postgres;

--
-- TOC entry 594 (class 1255 OID 18950)
-- Dependencies: 6 1102
-- Name: st_geometrytype(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geometrytype(geometry) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geometry_geometrytype';


ALTER FUNCTION public.st_geometrytype(geometry) OWNER TO postgres;

--
-- TOC entry 595 (class 1255 OID 18951)
-- Dependencies: 6 1102
-- Name: st_geomfromewkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geomfromewkb(bytea) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOMFromWKB';


ALTER FUNCTION public.st_geomfromewkb(bytea) OWNER TO postgres;

--
-- TOC entry 596 (class 1255 OID 18952)
-- Dependencies: 6 1102
-- Name: st_geomfromewkt(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geomfromewkt(text) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'parse_WKT_lwgeom';


ALTER FUNCTION public.st_geomfromewkt(text) OWNER TO postgres;

--
-- TOC entry 597 (class 1255 OID 18953)
-- Dependencies: 6 1102
-- Name: st_geomfromgml(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geomfromgml(text) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geom_from_gml';


ALTER FUNCTION public.st_geomfromgml(text) OWNER TO postgres;

--
-- TOC entry 598 (class 1255 OID 18954)
-- Dependencies: 6 1102
-- Name: st_geomfromkml(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geomfromkml(text) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geom_from_kml';


ALTER FUNCTION public.st_geomfromkml(text) OWNER TO postgres;

--
-- TOC entry 599 (class 1255 OID 18955)
-- Dependencies: 6 1102
-- Name: st_geomfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geomfromtext(text) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_from_text';


ALTER FUNCTION public.st_geomfromtext(text) OWNER TO postgres;

--
-- TOC entry 600 (class 1255 OID 18956)
-- Dependencies: 6 1102
-- Name: st_geomfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geomfromtext(text, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_from_text';


ALTER FUNCTION public.st_geomfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 601 (class 1255 OID 18957)
-- Dependencies: 6 1102
-- Name: st_geomfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geomfromwkb(bytea) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_from_WKB';


ALTER FUNCTION public.st_geomfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 602 (class 1255 OID 18958)
-- Dependencies: 6 1102
-- Name: st_geomfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_geomfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT ST_SetSRID(ST_GeomFromWKB($1), $2)$_$;


ALTER FUNCTION public.st_geomfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 603 (class 1255 OID 18959)
-- Dependencies: 6 1102
-- Name: st_gmltosql(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_gmltosql(text) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geom_from_gml';


ALTER FUNCTION public.st_gmltosql(text) OWNER TO postgres;

--
-- TOC entry 604 (class 1255 OID 18960)
-- Dependencies: 6 1102
-- Name: st_hasarc(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_hasarc(geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_has_arc';


ALTER FUNCTION public.st_hasarc(geometry) OWNER TO postgres;

--
-- TOC entry 605 (class 1255 OID 18961)
-- Dependencies: 6 1102 1102
-- Name: st_hausdorffdistance(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_hausdorffdistance(geometry, geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'hausdorffdistance';


ALTER FUNCTION public.st_hausdorffdistance(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 606 (class 1255 OID 18962)
-- Dependencies: 6 1102 1102
-- Name: st_hausdorffdistance(geometry, geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_hausdorffdistance(geometry, geometry, double precision) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'hausdorffdistancedensify';


ALTER FUNCTION public.st_hausdorffdistance(geometry, geometry, double precision) OWNER TO postgres;

--
-- TOC entry 607 (class 1255 OID 18963)
-- Dependencies: 6 1096
-- Name: st_height(chip); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_height(chip) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_getHeight';


ALTER FUNCTION public.st_height(chip) OWNER TO postgres;

--
-- TOC entry 608 (class 1255 OID 18964)
-- Dependencies: 6 1102 1102
-- Name: st_interiorringn(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_interiorringn(geometry, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_interiorringn_polygon';


ALTER FUNCTION public.st_interiorringn(geometry, integer) OWNER TO postgres;

--
-- TOC entry 609 (class 1255 OID 18965)
-- Dependencies: 6 1102 1102 1102
-- Name: st_intersection(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_intersection(geometry, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'intersection';


ALTER FUNCTION public.st_intersection(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 610 (class 1255 OID 18966)
-- Dependencies: 6 1099 1099 1099
-- Name: st_intersection(geography, geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_intersection(geography, geography) RETURNS geography
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT geography(ST_Transform(ST_Intersection(ST_Transform(geometry($1), _ST_BestSRID($1, $2)), ST_Transform(geometry($2), _ST_BestSRID($1, $2))), 4326))$_$;


ALTER FUNCTION public.st_intersection(geography, geography) OWNER TO postgres;

--
-- TOC entry 611 (class 1255 OID 18967)
-- Dependencies: 6 1102
-- Name: st_intersection(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_intersection(text, text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_Intersection($1::geometry, $2::geometry);  $_$;


ALTER FUNCTION public.st_intersection(text, text) OWNER TO postgres;

--
-- TOC entry 612 (class 1255 OID 18968)
-- Dependencies: 6 1102 1102
-- Name: st_intersects(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_intersects(geometry, geometry) RETURNS boolean
    LANGUAGE sql IMMUTABLE
    AS $_$SELECT $1 && $2 AND _ST_Intersects($1,$2)$_$;


ALTER FUNCTION public.st_intersects(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 613 (class 1255 OID 18969)
-- Dependencies: 6 1099 1099
-- Name: st_intersects(geography, geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_intersects(geography, geography) RETURNS boolean
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT $1 && $2 AND _ST_Distance($1, $2, 0.0, false) < 0.00001$_$;


ALTER FUNCTION public.st_intersects(geography, geography) OWNER TO postgres;

--
-- TOC entry 614 (class 1255 OID 18970)
-- Dependencies: 6
-- Name: st_intersects(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_intersects(text, text) RETURNS boolean
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_Intersects($1::geometry, $2::geometry);  $_$;


ALTER FUNCTION public.st_intersects(text, text) OWNER TO postgres;

--
-- TOC entry 615 (class 1255 OID 18971)
-- Dependencies: 6 1102
-- Name: st_isclosed(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_isclosed(geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_isclosed_linestring';


ALTER FUNCTION public.st_isclosed(geometry) OWNER TO postgres;

--
-- TOC entry 616 (class 1255 OID 18972)
-- Dependencies: 6 1102
-- Name: st_isempty(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_isempty(geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_isempty';


ALTER FUNCTION public.st_isempty(geometry) OWNER TO postgres;

--
-- TOC entry 617 (class 1255 OID 18973)
-- Dependencies: 6 1102
-- Name: st_isring(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_isring(geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'isring';


ALTER FUNCTION public.st_isring(geometry) OWNER TO postgres;

--
-- TOC entry 618 (class 1255 OID 18974)
-- Dependencies: 6 1102
-- Name: st_issimple(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_issimple(geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'issimple';


ALTER FUNCTION public.st_issimple(geometry) OWNER TO postgres;

--
-- TOC entry 619 (class 1255 OID 18975)
-- Dependencies: 6 1102
-- Name: st_isvalid(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_isvalid(geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'isvalid';


ALTER FUNCTION public.st_isvalid(geometry) OWNER TO postgres;

--
-- TOC entry 620 (class 1255 OID 18976)
-- Dependencies: 6 1102
-- Name: st_isvalidreason(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_isvalidreason(geometry) RETURNS text
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'isvalidreason';


ALTER FUNCTION public.st_isvalidreason(geometry) OWNER TO postgres;

--
-- TOC entry 621 (class 1255 OID 18977)
-- Dependencies: 6 1102
-- Name: st_length(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_length(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_length2d_linestring';


ALTER FUNCTION public.st_length(geometry) OWNER TO postgres;

--
-- TOC entry 623 (class 1255 OID 18979)
-- Dependencies: 6 1099
-- Name: st_length(geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_length(geography) RETURNS double precision
    LANGUAGE sql IMMUTABLE
    AS $_$SELECT ST_Length($1, true)$_$;


ALTER FUNCTION public.st_length(geography) OWNER TO postgres;

--
-- TOC entry 624 (class 1255 OID 18980)
-- Dependencies: 6
-- Name: st_length(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_length(text) RETURNS double precision
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_Length($1::geometry);  $_$;


ALTER FUNCTION public.st_length(text) OWNER TO postgres;

--
-- TOC entry 622 (class 1255 OID 18978)
-- Dependencies: 6 1099
-- Name: st_length(geography, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_length(geography, boolean) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'geography_length';


ALTER FUNCTION public.st_length(geography, boolean) OWNER TO postgres;

--
-- TOC entry 625 (class 1255 OID 18981)
-- Dependencies: 6 1102
-- Name: st_length2d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_length2d(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_length2d_linestring';


ALTER FUNCTION public.st_length2d(geometry) OWNER TO postgres;

--
-- TOC entry 626 (class 1255 OID 18982)
-- Dependencies: 6 1102 1113
-- Name: st_length2d_spheroid(geometry, spheroid); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_length2d_spheroid(geometry, spheroid) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'LWGEOM_length2d_ellipsoid';


ALTER FUNCTION public.st_length2d_spheroid(geometry, spheroid) OWNER TO postgres;

--
-- TOC entry 627 (class 1255 OID 18983)
-- Dependencies: 6 1102
-- Name: st_length3d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_length3d(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_length_linestring';


ALTER FUNCTION public.st_length3d(geometry) OWNER TO postgres;

--
-- TOC entry 628 (class 1255 OID 18984)
-- Dependencies: 6 1102 1113
-- Name: st_length3d_spheroid(geometry, spheroid); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_length3d_spheroid(geometry, spheroid) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'LWGEOM_length_ellipsoid_linestring';


ALTER FUNCTION public.st_length3d_spheroid(geometry, spheroid) OWNER TO postgres;

--
-- TOC entry 629 (class 1255 OID 18985)
-- Dependencies: 6 1102 1113
-- Name: st_length_spheroid(geometry, spheroid); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_length_spheroid(geometry, spheroid) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'LWGEOM_length_ellipsoid_linestring';


ALTER FUNCTION public.st_length_spheroid(geometry, spheroid) OWNER TO postgres;

--
-- TOC entry 630 (class 1255 OID 18986)
-- Dependencies: 6 1102 1102
-- Name: st_line_interpolate_point(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_line_interpolate_point(geometry, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_line_interpolate_point';


ALTER FUNCTION public.st_line_interpolate_point(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 631 (class 1255 OID 18987)
-- Dependencies: 6 1102 1102
-- Name: st_line_locate_point(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_line_locate_point(geometry, geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_line_locate_point';


ALTER FUNCTION public.st_line_locate_point(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 632 (class 1255 OID 18988)
-- Dependencies: 6 1102 1102
-- Name: st_line_substring(geometry, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_line_substring(geometry, double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_line_substring';


ALTER FUNCTION public.st_line_substring(geometry, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 633 (class 1255 OID 18989)
-- Dependencies: 6 1102 1102
-- Name: st_linecrossingdirection(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_linecrossingdirection(geometry, geometry) RETURNS integer
    LANGUAGE sql IMMUTABLE
    AS $_$ SELECT CASE WHEN NOT $1 && $2 THEN 0 ELSE _ST_LineCrossingDirection($1,$2) END $_$;


ALTER FUNCTION public.st_linecrossingdirection(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 634 (class 1255 OID 18990)
-- Dependencies: 6 1102 1102
-- Name: st_linefrommultipoint(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_linefrommultipoint(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_line_from_mpoint';


ALTER FUNCTION public.st_linefrommultipoint(geometry) OWNER TO postgres;

--
-- TOC entry 635 (class 1255 OID 18991)
-- Dependencies: 6 1102
-- Name: st_linefromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_linefromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromText($1)) = 'LINESTRING'
	THEN ST_GeomFromText($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_linefromtext(text) OWNER TO postgres;

--
-- TOC entry 636 (class 1255 OID 18992)
-- Dependencies: 6 1102
-- Name: st_linefromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_linefromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1, $2)) = 'LINESTRING'
	THEN GeomFromText($1,$2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_linefromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 638 (class 1255 OID 18994)
-- Dependencies: 6 1102
-- Name: st_linefromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_linefromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromWKB($1)) = 'LINESTRING'
	THEN ST_GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_linefromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 637 (class 1255 OID 18993)
-- Dependencies: 6 1102
-- Name: st_linefromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_linefromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromWKB($1, $2)) = 'LINESTRING'
	THEN ST_GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_linefromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 639 (class 1255 OID 18995)
-- Dependencies: 6 1102 1102
-- Name: st_linemerge(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_linemerge(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'linemerge';


ALTER FUNCTION public.st_linemerge(geometry) OWNER TO postgres;

--
-- TOC entry 641 (class 1255 OID 18997)
-- Dependencies: 6 1102
-- Name: st_linestringfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_linestringfromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'LINESTRING'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_linestringfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 640 (class 1255 OID 18996)
-- Dependencies: 6 1102
-- Name: st_linestringfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_linestringfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromWKB($1, $2)) = 'LINESTRING'
	THEN ST_GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_linestringfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 642 (class 1255 OID 18998)
-- Dependencies: 6 1102 1102
-- Name: st_linetocurve(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_linetocurve(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_line_desegmentize';


ALTER FUNCTION public.st_linetocurve(geometry) OWNER TO postgres;

--
-- TOC entry 643 (class 1255 OID 18999)
-- Dependencies: 6 1102 1102
-- Name: st_locate_along_measure(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_locate_along_measure(geometry, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT locate_between_measures($1, $2, $2) $_$;


ALTER FUNCTION public.st_locate_along_measure(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 644 (class 1255 OID 19000)
-- Dependencies: 6 1102 1102
-- Name: st_locate_between_measures(geometry, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_locate_between_measures(geometry, double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_locate_between_m';


ALTER FUNCTION public.st_locate_between_measures(geometry, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 645 (class 1255 OID 19001)
-- Dependencies: 6 1102 1102
-- Name: st_locatebetweenelevations(geometry, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_locatebetweenelevations(geometry, double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'ST_LocateBetweenElevations';


ALTER FUNCTION public.st_locatebetweenelevations(geometry, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 646 (class 1255 OID 19002)
-- Dependencies: 6 1102 1102 1102
-- Name: st_longestline(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_longestline(geometry, geometry) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_LongestLine(ST_ConvexHull($1), ST_ConvexHull($2))$_$;


ALTER FUNCTION public.st_longestline(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 647 (class 1255 OID 19003)
-- Dependencies: 6 1102
-- Name: st_m(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_m(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_m_point';


ALTER FUNCTION public.st_m(geometry) OWNER TO postgres;

--
-- TOC entry 648 (class 1255 OID 19004)
-- Dependencies: 6 1087 1102 1102
-- Name: st_makebox2d(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_makebox2d(geometry, geometry) RETURNS box2d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX2DFLOAT4_construct';


ALTER FUNCTION public.st_makebox2d(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 649 (class 1255 OID 19005)
-- Dependencies: 6 1090 1102 1102
-- Name: st_makebox3d(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_makebox3d(geometry, geometry) RETURNS box3d
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_construct';


ALTER FUNCTION public.st_makebox3d(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 650 (class 1255 OID 19006)
-- Dependencies: 6 1102
-- Name: st_makeenvelope(double precision, double precision, double precision, double precision, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_makeenvelope(double precision, double precision, double precision, double precision, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'ST_MakeEnvelope';


ALTER FUNCTION public.st_makeenvelope(double precision, double precision, double precision, double precision, integer) OWNER TO postgres;

--
-- TOC entry 651 (class 1255 OID 19007)
-- Dependencies: 6 1102 1104
-- Name: st_makeline(geometry[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_makeline(geometry[]) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_makeline_garray';


ALTER FUNCTION public.st_makeline(geometry[]) OWNER TO postgres;

--
-- TOC entry 652 (class 1255 OID 19008)
-- Dependencies: 6 1102 1102 1102
-- Name: st_makeline(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_makeline(geometry, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_makeline';


ALTER FUNCTION public.st_makeline(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 653 (class 1255 OID 19009)
-- Dependencies: 6 1102 1104
-- Name: st_makeline_garray(geometry[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_makeline_garray(geometry[]) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_makeline_garray';


ALTER FUNCTION public.st_makeline_garray(geometry[]) OWNER TO postgres;

--
-- TOC entry 654 (class 1255 OID 19010)
-- Dependencies: 6 1102
-- Name: st_makepoint(double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_makepoint(double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_makepoint';


ALTER FUNCTION public.st_makepoint(double precision, double precision) OWNER TO postgres;

--
-- TOC entry 655 (class 1255 OID 19011)
-- Dependencies: 6 1102
-- Name: st_makepoint(double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_makepoint(double precision, double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_makepoint';


ALTER FUNCTION public.st_makepoint(double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 656 (class 1255 OID 19012)
-- Dependencies: 6 1102
-- Name: st_makepoint(double precision, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_makepoint(double precision, double precision, double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_makepoint';


ALTER FUNCTION public.st_makepoint(double precision, double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 657 (class 1255 OID 19013)
-- Dependencies: 6 1102
-- Name: st_makepointm(double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_makepointm(double precision, double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_makepoint3dm';


ALTER FUNCTION public.st_makepointm(double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 659 (class 1255 OID 19015)
-- Dependencies: 6 1102 1102
-- Name: st_makepolygon(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_makepolygon(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_makepoly';


ALTER FUNCTION public.st_makepolygon(geometry) OWNER TO postgres;

--
-- TOC entry 658 (class 1255 OID 19014)
-- Dependencies: 6 1102 1102 1104
-- Name: st_makepolygon(geometry, geometry[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_makepolygon(geometry, geometry[]) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_makepoly';


ALTER FUNCTION public.st_makepolygon(geometry, geometry[]) OWNER TO postgres;

--
-- TOC entry 660 (class 1255 OID 19016)
-- Dependencies: 6 1102 1102
-- Name: st_maxdistance(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_maxdistance(geometry, geometry) RETURNS double precision
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_MaxDistance(ST_ConvexHull($1), ST_ConvexHull($2))$_$;


ALTER FUNCTION public.st_maxdistance(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 661 (class 1255 OID 19017)
-- Dependencies: 6 1102
-- Name: st_mem_size(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_mem_size(geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_mem_size';


ALTER FUNCTION public.st_mem_size(geometry) OWNER TO postgres;

--
-- TOC entry 663 (class 1255 OID 19020)
-- Dependencies: 6 1102 1102
-- Name: st_minimumboundingcircle(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_minimumboundingcircle(geometry) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT ST_MinimumBoundingCircle($1, 48)$_$;


ALTER FUNCTION public.st_minimumboundingcircle(geometry) OWNER TO postgres;

--
-- TOC entry 662 (class 1255 OID 19018)
-- Dependencies: 6 1170 1102 1102
-- Name: st_minimumboundingcircle(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_minimumboundingcircle(inputgeom geometry, segs_per_quarter integer) RETURNS geometry
    LANGUAGE plpgsql IMMUTABLE STRICT
    AS $$
	DECLARE
	hull GEOMETRY;
	ring GEOMETRY;
	center GEOMETRY;
	radius DOUBLE PRECISION;
	dist DOUBLE PRECISION;
	d DOUBLE PRECISION;
	idx1 integer;
	idx2 integer;
	l1 GEOMETRY;
	l2 GEOMETRY;
	p1 GEOMETRY;
	p2 GEOMETRY;
	a1 DOUBLE PRECISION;
	a2 DOUBLE PRECISION;


	BEGIN

	-- First compute the ConvexHull of the geometry
	hull = ST_ConvexHull(inputgeom);
	--A point really has no MBC
	IF ST_GeometryType(hull) = 'ST_Point' THEN
		RETURN hull;
	END IF;
	-- convert the hull perimeter to a linestring so we can manipulate individual points
	--If its already a linestring force it to a closed linestring
	ring = CASE WHEN ST_GeometryType(hull) = 'ST_LineString' THEN ST_AddPoint(hull, ST_StartPoint(hull)) ELSE ST_ExteriorRing(hull) END;

	dist = 0;
	-- Brute Force - check every pair
	FOR i in 1 .. (ST_NumPoints(ring)-2)
		LOOP
			FOR j in i .. (ST_NumPoints(ring)-1)
				LOOP
				d = ST_Distance(ST_PointN(ring,i),ST_PointN(ring,j));
				-- Check the distance and update if larger
				IF (d > dist) THEN
					dist = d;
					idx1 = i;
					idx2 = j;
				END IF;
			END LOOP;
		END LOOP;

	-- We now have the diameter of the convex hull.  The following line returns it if desired.
	-- RETURN MakeLine(PointN(ring,idx1),PointN(ring,idx2));

	-- Now for the Minimum Bounding Circle.  Since we know the two points furthest from each
	-- other, the MBC must go through those two points. Start with those points as a diameter of a circle.

	-- The radius is half the distance between them and the center is midway between them
	radius = ST_Distance(ST_PointN(ring,idx1),ST_PointN(ring,idx2)) / 2.0;
	center = ST_Line_interpolate_point(ST_MakeLine(ST_PointN(ring,idx1),ST_PointN(ring,idx2)),0.5);

	-- Loop through each vertex and check if the distance from the center to the point
	-- is greater than the current radius.
	FOR k in 1 .. (ST_NumPoints(ring)-1)
		LOOP
		IF(k <> idx1 and k <> idx2) THEN
			dist = ST_Distance(center,ST_PointN(ring,k));
			IF (dist > radius) THEN
				-- We have to expand the circle.  The new circle must pass trhough
				-- three points - the two original diameters and this point.

				-- Draw a line from the first diameter to this point
				l1 = ST_Makeline(ST_PointN(ring,idx1),ST_PointN(ring,k));
				-- Compute the midpoint
				p1 = ST_line_interpolate_point(l1,0.5);
				-- Rotate the line 90 degrees around the midpoint (perpendicular bisector)
				l1 = ST_Translate(ST_Rotate(ST_Translate(l1,-X(p1),-Y(p1)),pi()/2),X(p1),Y(p1));
				--  Compute the azimuth of the bisector
				a1 = ST_Azimuth(ST_PointN(l1,1),ST_PointN(l1,2));
				--  Extend the line in each direction the new computed distance to insure they will intersect
				l1 = ST_AddPoint(l1,ST_Makepoint(X(ST_PointN(l1,2))+sin(a1)*dist,Y(ST_PointN(l1,2))+cos(a1)*dist),-1);
				l1 = ST_AddPoint(l1,ST_Makepoint(X(ST_PointN(l1,1))-sin(a1)*dist,Y(ST_PointN(l1,1))-cos(a1)*dist),0);

				-- Repeat for the line from the point to the other diameter point
				l2 = ST_Makeline(ST_PointN(ring,idx2),ST_PointN(ring,k));
				p2 = ST_Line_interpolate_point(l2,0.5);
				l2 = ST_Translate(ST_Rotate(ST_Translate(l2,-X(p2),-Y(p2)),pi()/2),X(p2),Y(p2));
				a2 = ST_Azimuth(ST_PointN(l2,1),ST_PointN(l2,2));
				l2 = ST_AddPoint(l2,ST_Makepoint(X(ST_PointN(l2,2))+sin(a2)*dist,Y(ST_PointN(l2,2))+cos(a2)*dist),-1);
				l2 = ST_AddPoint(l2,ST_Makepoint(X(ST_PointN(l2,1))-sin(a2)*dist,Y(ST_PointN(l2,1))-cos(a2)*dist),0);

				-- The new center is the intersection of the two bisectors
				center = ST_Intersection(l1,l2);
				-- The new radius is the distance to any of the three points
				radius = ST_Distance(center,ST_PointN(ring,idx1));
			END IF;
		END IF;
		END LOOP;
	--DONE!!  Return the MBC via the buffer command
	RETURN ST_Buffer(center,radius,segs_per_quarter);

	END;
$$;


ALTER FUNCTION public.st_minimumboundingcircle(inputgeom geometry, segs_per_quarter integer) OWNER TO postgres;

--
-- TOC entry 665 (class 1255 OID 19022)
-- Dependencies: 6 1102
-- Name: st_mlinefromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_mlinefromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromText($1)) = 'MULTILINESTRING'
	THEN ST_GeomFromText($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_mlinefromtext(text) OWNER TO postgres;

--
-- TOC entry 664 (class 1255 OID 19021)
-- Dependencies: 6 1102
-- Name: st_mlinefromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_mlinefromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE
	WHEN geometrytype(GeomFromText($1, $2)) = 'MULTILINESTRING'
	THEN GeomFromText($1,$2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_mlinefromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 667 (class 1255 OID 19024)
-- Dependencies: 6 1102
-- Name: st_mlinefromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_mlinefromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromWKB($1)) = 'MULTILINESTRING'
	THEN ST_GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_mlinefromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 666 (class 1255 OID 19023)
-- Dependencies: 6 1102
-- Name: st_mlinefromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_mlinefromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromWKB($1, $2)) = 'MULTILINESTRING'
	THEN ST_GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_mlinefromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 669 (class 1255 OID 19026)
-- Dependencies: 6 1102
-- Name: st_mpointfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_mpointfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromText($1)) = 'MULTIPOINT'
	THEN ST_GeomFromText($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_mpointfromtext(text) OWNER TO postgres;

--
-- TOC entry 668 (class 1255 OID 19025)
-- Dependencies: 6 1102
-- Name: st_mpointfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_mpointfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1, $2)) = 'MULTIPOINT'
	THEN GeomFromText($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_mpointfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 672 (class 1255 OID 19028)
-- Dependencies: 6 1102
-- Name: st_mpointfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_mpointfromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromWKB($1)) = 'MULTIPOINT'
	THEN ST_GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_mpointfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 671 (class 1255 OID 19027)
-- Dependencies: 6 1102
-- Name: st_mpointfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_mpointfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1, $2)) = 'MULTIPOINT'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_mpointfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 674 (class 1255 OID 19030)
-- Dependencies: 6 1102
-- Name: st_mpolyfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_mpolyfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromText($1)) = 'MULTIPOLYGON'
	THEN ST_GeomFromText($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_mpolyfromtext(text) OWNER TO postgres;

--
-- TOC entry 673 (class 1255 OID 19029)
-- Dependencies: 6 1102
-- Name: st_mpolyfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_mpolyfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromText($1, $2)) = 'MULTIPOLYGON'
	THEN ST_GeomFromText($1,$2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_mpolyfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 676 (class 1255 OID 19032)
-- Dependencies: 6 1102
-- Name: st_mpolyfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_mpolyfromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromWKB($1)) = 'MULTIPOLYGON'
	THEN ST_GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_mpolyfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 675 (class 1255 OID 19031)
-- Dependencies: 6 1102
-- Name: st_mpolyfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_mpolyfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromWKB($1, $2)) = 'MULTIPOLYGON'
	THEN ST_GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_mpolyfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 677 (class 1255 OID 19033)
-- Dependencies: 6 1102 1102
-- Name: st_multi(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_multi(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_force_multi';


ALTER FUNCTION public.st_multi(geometry) OWNER TO postgres;

--
-- TOC entry 678 (class 1255 OID 19034)
-- Dependencies: 6 1102
-- Name: st_multilinefromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_multilinefromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromWKB($1)) = 'MULTILINESTRING'
	THEN ST_GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_multilinefromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 679 (class 1255 OID 19035)
-- Dependencies: 6 1102
-- Name: st_multilinestringfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_multilinestringfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT ST_MLineFromText($1)$_$;


ALTER FUNCTION public.st_multilinestringfromtext(text) OWNER TO postgres;

--
-- TOC entry 680 (class 1255 OID 19036)
-- Dependencies: 6 1102
-- Name: st_multilinestringfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_multilinestringfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT MLineFromText($1, $2)$_$;


ALTER FUNCTION public.st_multilinestringfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 681 (class 1255 OID 19037)
-- Dependencies: 6 1102
-- Name: st_multipointfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_multipointfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT MPointFromText($1)$_$;


ALTER FUNCTION public.st_multipointfromtext(text) OWNER TO postgres;

--
-- TOC entry 683 (class 1255 OID 19039)
-- Dependencies: 6 1102
-- Name: st_multipointfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_multipointfromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromWKB($1)) = 'MULTIPOINT'
	THEN ST_GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_multipointfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 682 (class 1255 OID 19038)
-- Dependencies: 6 1102
-- Name: st_multipointfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_multipointfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromWKB($1,$2)) = 'MULTIPOINT'
	THEN ST_GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_multipointfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 685 (class 1255 OID 19041)
-- Dependencies: 6 1102
-- Name: st_multipolyfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_multipolyfromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromWKB($1)) = 'MULTIPOLYGON'
	THEN ST_GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_multipolyfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 684 (class 1255 OID 19040)
-- Dependencies: 6 1102
-- Name: st_multipolyfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_multipolyfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromWKB($1, $2)) = 'MULTIPOLYGON'
	THEN ST_GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_multipolyfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 687 (class 1255 OID 19043)
-- Dependencies: 6 1102
-- Name: st_multipolygonfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_multipolygonfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT MPolyFromText($1)$_$;


ALTER FUNCTION public.st_multipolygonfromtext(text) OWNER TO postgres;

--
-- TOC entry 686 (class 1255 OID 19042)
-- Dependencies: 6 1102
-- Name: st_multipolygonfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_multipolygonfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT MPolyFromText($1, $2)$_$;


ALTER FUNCTION public.st_multipolygonfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 688 (class 1255 OID 19044)
-- Dependencies: 6 1102
-- Name: st_ndims(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_ndims(geometry) RETURNS smallint
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_ndims';


ALTER FUNCTION public.st_ndims(geometry) OWNER TO postgres;

--
-- TOC entry 689 (class 1255 OID 19045)
-- Dependencies: 6 1102
-- Name: st_npoints(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_npoints(geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_npoints';


ALTER FUNCTION public.st_npoints(geometry) OWNER TO postgres;

--
-- TOC entry 690 (class 1255 OID 19046)
-- Dependencies: 6 1102
-- Name: st_nrings(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_nrings(geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_nrings';


ALTER FUNCTION public.st_nrings(geometry) OWNER TO postgres;

--
-- TOC entry 691 (class 1255 OID 19047)
-- Dependencies: 6 1102
-- Name: st_numgeometries(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_numgeometries(geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_numgeometries_collection';


ALTER FUNCTION public.st_numgeometries(geometry) OWNER TO postgres;

--
-- TOC entry 692 (class 1255 OID 19048)
-- Dependencies: 6 1102
-- Name: st_numinteriorring(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_numinteriorring(geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_numinteriorrings_polygon';


ALTER FUNCTION public.st_numinteriorring(geometry) OWNER TO postgres;

--
-- TOC entry 693 (class 1255 OID 19049)
-- Dependencies: 6 1102
-- Name: st_numinteriorrings(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_numinteriorrings(geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_numinteriorrings_polygon';


ALTER FUNCTION public.st_numinteriorrings(geometry) OWNER TO postgres;

--
-- TOC entry 694 (class 1255 OID 19050)
-- Dependencies: 6 1102
-- Name: st_numpoints(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_numpoints(geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_numpoints_linestring';


ALTER FUNCTION public.st_numpoints(geometry) OWNER TO postgres;

--
-- TOC entry 695 (class 1255 OID 19051)
-- Dependencies: 6 1102 1102
-- Name: st_orderingequals(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_orderingequals(geometry, geometry) RETURNS boolean
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ 
	SELECT $1 ~= $2 AND _ST_OrderingEquals($1, $2)
	$_$;


ALTER FUNCTION public.st_orderingequals(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 696 (class 1255 OID 19052)
-- Dependencies: 6 1102 1102
-- Name: st_overlaps(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_overlaps(geometry, geometry) RETURNS boolean
    LANGUAGE sql IMMUTABLE
    AS $_$SELECT $1 && $2 AND _ST_Overlaps($1,$2)$_$;


ALTER FUNCTION public.st_overlaps(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 697 (class 1255 OID 19053)
-- Dependencies: 6 1102
-- Name: st_perimeter(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_perimeter(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_perimeter2d_poly';


ALTER FUNCTION public.st_perimeter(geometry) OWNER TO postgres;

--
-- TOC entry 698 (class 1255 OID 19054)
-- Dependencies: 6 1102
-- Name: st_perimeter2d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_perimeter2d(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_perimeter2d_poly';


ALTER FUNCTION public.st_perimeter2d(geometry) OWNER TO postgres;

--
-- TOC entry 699 (class 1255 OID 19055)
-- Dependencies: 6 1102
-- Name: st_perimeter3d(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_perimeter3d(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_perimeter_poly';


ALTER FUNCTION public.st_perimeter3d(geometry) OWNER TO postgres;

--
-- TOC entry 700 (class 1255 OID 19056)
-- Dependencies: 6 1102
-- Name: st_point(double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_point(double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_makepoint';


ALTER FUNCTION public.st_point(double precision, double precision) OWNER TO postgres;

--
-- TOC entry 701 (class 1255 OID 19057)
-- Dependencies: 6 1102
-- Name: st_point_inside_circle(geometry, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_point_inside_circle(geometry, double precision, double precision, double precision) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_inside_circle_point';


ALTER FUNCTION public.st_point_inside_circle(geometry, double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 702 (class 1255 OID 19058)
-- Dependencies: 6 1102
-- Name: st_pointfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_pointfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromText($1)) = 'POINT'
	THEN ST_GeomFromText($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_pointfromtext(text) OWNER TO postgres;

--
-- TOC entry 703 (class 1255 OID 19059)
-- Dependencies: 6 1102
-- Name: st_pointfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_pointfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromText($1, $2)) = 'POINT'
	THEN ST_GeomFromText($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_pointfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 706 (class 1255 OID 19061)
-- Dependencies: 6 1102
-- Name: st_pointfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_pointfromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromWKB($1)) = 'POINT'
	THEN ST_GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_pointfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 705 (class 1255 OID 19060)
-- Dependencies: 6 1102
-- Name: st_pointfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_pointfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromWKB($1, $2)) = 'POINT'
	THEN ST_GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_pointfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 707 (class 1255 OID 19062)
-- Dependencies: 6 1102 1102
-- Name: st_pointn(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_pointn(geometry, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_pointn_linestring';


ALTER FUNCTION public.st_pointn(geometry, integer) OWNER TO postgres;

--
-- TOC entry 708 (class 1255 OID 19063)
-- Dependencies: 6 1102 1102
-- Name: st_pointonsurface(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_pointonsurface(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'pointonsurface';


ALTER FUNCTION public.st_pointonsurface(geometry) OWNER TO postgres;

--
-- TOC entry 709 (class 1255 OID 19064)
-- Dependencies: 6 1102
-- Name: st_polyfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_polyfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromText($1)) = 'POLYGON'
	THEN ST_GeomFromText($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_polyfromtext(text) OWNER TO postgres;

--
-- TOC entry 710 (class 1255 OID 19065)
-- Dependencies: 6 1102
-- Name: st_polyfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_polyfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromText($1, $2)) = 'POLYGON'
	THEN ST_GeomFromText($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_polyfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 712 (class 1255 OID 19067)
-- Dependencies: 6 1102
-- Name: st_polyfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_polyfromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromWKB($1)) = 'POLYGON'
	THEN ST_GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_polyfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 711 (class 1255 OID 19066)
-- Dependencies: 6 1102
-- Name: st_polyfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_polyfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromWKB($1, $2)) = 'POLYGON'
	THEN ST_GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_polyfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 713 (class 1255 OID 19068)
-- Dependencies: 6 1102 1102
-- Name: st_polygon(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_polygon(geometry, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ 
	SELECT setSRID(makepolygon($1), $2)
	$_$;


ALTER FUNCTION public.st_polygon(geometry, integer) OWNER TO postgres;

--
-- TOC entry 715 (class 1255 OID 19070)
-- Dependencies: 6 1102
-- Name: st_polygonfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_polygonfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT ST_PolyFromText($1)$_$;


ALTER FUNCTION public.st_polygonfromtext(text) OWNER TO postgres;

--
-- TOC entry 714 (class 1255 OID 19069)
-- Dependencies: 6 1102
-- Name: st_polygonfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_polygonfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT PolyFromText($1, $2)$_$;


ALTER FUNCTION public.st_polygonfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 717 (class 1255 OID 19072)
-- Dependencies: 6 1102
-- Name: st_polygonfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_polygonfromwkb(bytea) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'POLYGON'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_polygonfromwkb(bytea) OWNER TO postgres;

--
-- TOC entry 716 (class 1255 OID 19071)
-- Dependencies: 6 1102
-- Name: st_polygonfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_polygonfromwkb(bytea, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
	SELECT CASE WHEN geometrytype(ST_GeomFromWKB($1,$2)) = 'POLYGON'
	THEN ST_GeomFromWKB($1, $2)
	ELSE NULL END
	$_$;


ALTER FUNCTION public.st_polygonfromwkb(bytea, integer) OWNER TO postgres;

--
-- TOC entry 718 (class 1255 OID 19073)
-- Dependencies: 6 1102 1104
-- Name: st_polygonize(geometry[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_polygonize(geometry[]) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'polygonize_garray';


ALTER FUNCTION public.st_polygonize(geometry[]) OWNER TO postgres;

--
-- TOC entry 719 (class 1255 OID 19074)
-- Dependencies: 6 1102 1104
-- Name: st_polygonize_garray(geometry[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_polygonize_garray(geometry[]) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'polygonize_garray';


ALTER FUNCTION public.st_polygonize_garray(geometry[]) OWNER TO postgres;

--
-- TOC entry 720 (class 1255 OID 19075)
-- Dependencies: 6
-- Name: st_postgis_gist_joinsel(internal, oid, internal, smallint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_postgis_gist_joinsel(internal, oid, internal, smallint) RETURNS double precision
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'LWGEOM_gist_joinsel';


ALTER FUNCTION public.st_postgis_gist_joinsel(internal, oid, internal, smallint) OWNER TO postgres;

--
-- TOC entry 721 (class 1255 OID 19076)
-- Dependencies: 6
-- Name: st_postgis_gist_sel(internal, oid, internal, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_postgis_gist_sel(internal, oid, internal, integer) RETURNS double precision
    LANGUAGE c
    AS '$libdir/postgis-1.5', 'LWGEOM_gist_sel';


ALTER FUNCTION public.st_postgis_gist_sel(internal, oid, internal, integer) OWNER TO postgres;

--
-- TOC entry 722 (class 1255 OID 19077)
-- Dependencies: 6 1102 1102
-- Name: st_relate(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_relate(geometry, geometry) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'relate_full';


ALTER FUNCTION public.st_relate(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 723 (class 1255 OID 19078)
-- Dependencies: 6 1102 1102
-- Name: st_relate(geometry, geometry, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_relate(geometry, geometry, text) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'relate_pattern';


ALTER FUNCTION public.st_relate(geometry, geometry, text) OWNER TO postgres;

--
-- TOC entry 724 (class 1255 OID 19079)
-- Dependencies: 6 1102 1102
-- Name: st_removepoint(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_removepoint(geometry, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_removepoint';


ALTER FUNCTION public.st_removepoint(geometry, integer) OWNER TO postgres;

--
-- TOC entry 725 (class 1255 OID 19080)
-- Dependencies: 6 1102 1102
-- Name: st_reverse(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_reverse(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_reverse';


ALTER FUNCTION public.st_reverse(geometry) OWNER TO postgres;

--
-- TOC entry 726 (class 1255 OID 19081)
-- Dependencies: 6 1102 1102
-- Name: st_rotate(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_rotate(geometry, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT rotateZ($1, $2)$_$;


ALTER FUNCTION public.st_rotate(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 727 (class 1255 OID 19082)
-- Dependencies: 6 1102 1102
-- Name: st_rotatex(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_rotatex(geometry, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT affine($1, 1, 0, 0, 0, cos($2), -sin($2), 0, sin($2), cos($2), 0, 0, 0)$_$;


ALTER FUNCTION public.st_rotatex(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 728 (class 1255 OID 19083)
-- Dependencies: 6 1102 1102
-- Name: st_rotatey(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_rotatey(geometry, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT affine($1,  cos($2), 0, sin($2),  0, 1, 0,  -sin($2), 0, cos($2), 0,  0, 0)$_$;


ALTER FUNCTION public.st_rotatey(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 729 (class 1255 OID 19084)
-- Dependencies: 6 1102 1102
-- Name: st_rotatez(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_rotatez(geometry, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT affine($1,  cos($2), -sin($2), 0,  sin($2), cos($2), 0,  0, 0, 1,  0, 0, 0)$_$;


ALTER FUNCTION public.st_rotatez(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 731 (class 1255 OID 19086)
-- Dependencies: 6 1102 1102
-- Name: st_scale(geometry, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_scale(geometry, double precision, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT scale($1, $2, $3, 1)$_$;


ALTER FUNCTION public.st_scale(geometry, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 730 (class 1255 OID 19085)
-- Dependencies: 6 1102 1102
-- Name: st_scale(geometry, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_scale(geometry, double precision, double precision, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT affine($1,  $2, 0, 0,  0, $3, 0,  0, 0, $4,  0, 0, 0)$_$;


ALTER FUNCTION public.st_scale(geometry, double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 732 (class 1255 OID 19087)
-- Dependencies: 6 1102 1102
-- Name: st_segmentize(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_segmentize(geometry, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_segmentize2d';


ALTER FUNCTION public.st_segmentize(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 733 (class 1255 OID 19088)
-- Dependencies: 6 1096 1096
-- Name: st_setfactor(chip, real); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_setfactor(chip, real) RETURNS chip
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_setFactor';


ALTER FUNCTION public.st_setfactor(chip, real) OWNER TO postgres;

--
-- TOC entry 734 (class 1255 OID 19089)
-- Dependencies: 6 1102 1102 1102
-- Name: st_setpoint(geometry, integer, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_setpoint(geometry, integer, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_setpoint_linestring';


ALTER FUNCTION public.st_setpoint(geometry, integer, geometry) OWNER TO postgres;

--
-- TOC entry 735 (class 1255 OID 19090)
-- Dependencies: 6 1102 1102
-- Name: st_setsrid(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_setsrid(geometry, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_setSRID';


ALTER FUNCTION public.st_setsrid(geometry, integer) OWNER TO postgres;

--
-- TOC entry 736 (class 1255 OID 19091)
-- Dependencies: 6 1102 1102
-- Name: st_shift_longitude(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_shift_longitude(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_longitude_shift';


ALTER FUNCTION public.st_shift_longitude(geometry) OWNER TO postgres;

--
-- TOC entry 737 (class 1255 OID 19092)
-- Dependencies: 6 1102 1102 1102
-- Name: st_shortestline(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_shortestline(geometry, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_shortestline2d';


ALTER FUNCTION public.st_shortestline(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 738 (class 1255 OID 19093)
-- Dependencies: 6 1102 1102
-- Name: st_simplify(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_simplify(geometry, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_simplify2d';


ALTER FUNCTION public.st_simplify(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 739 (class 1255 OID 19094)
-- Dependencies: 6 1102 1102
-- Name: st_simplifypreservetopology(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_simplifypreservetopology(geometry, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT COST 100
    AS '$libdir/postgis-1.5', 'topologypreservesimplify';


ALTER FUNCTION public.st_simplifypreservetopology(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 740 (class 1255 OID 19097)
-- Dependencies: 6 1102 1102
-- Name: st_snaptogrid(geometry, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_snaptogrid(geometry, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT ST_SnapToGrid($1, 0, 0, $2, $2)$_$;


ALTER FUNCTION public.st_snaptogrid(geometry, double precision) OWNER TO postgres;

--
-- TOC entry 704 (class 1255 OID 19096)
-- Dependencies: 6 1102 1102
-- Name: st_snaptogrid(geometry, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_snaptogrid(geometry, double precision, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT ST_SnapToGrid($1, 0, 0, $2, $3)$_$;


ALTER FUNCTION public.st_snaptogrid(geometry, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 670 (class 1255 OID 19095)
-- Dependencies: 6 1102 1102
-- Name: st_snaptogrid(geometry, double precision, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_snaptogrid(geometry, double precision, double precision, double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_snaptogrid';


ALTER FUNCTION public.st_snaptogrid(geometry, double precision, double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 741 (class 1255 OID 19098)
-- Dependencies: 6 1102 1102 1102
-- Name: st_snaptogrid(geometry, geometry, double precision, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_snaptogrid(geometry, geometry, double precision, double precision, double precision, double precision) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_snaptogrid_pointoff';


ALTER FUNCTION public.st_snaptogrid(geometry, geometry, double precision, double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 742 (class 1255 OID 19099)
-- Dependencies: 6 1113
-- Name: st_spheroid_in(cstring); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_spheroid_in(cstring) RETURNS spheroid
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'ellipsoid_in';


ALTER FUNCTION public.st_spheroid_in(cstring) OWNER TO postgres;

--
-- TOC entry 743 (class 1255 OID 19100)
-- Dependencies: 6 1113
-- Name: st_spheroid_out(spheroid); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_spheroid_out(spheroid) RETURNS cstring
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'ellipsoid_out';


ALTER FUNCTION public.st_spheroid_out(spheroid) OWNER TO postgres;

--
-- TOC entry 744 (class 1255 OID 19101)
-- Dependencies: 6 1096
-- Name: st_srid(chip); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_srid(chip) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_getSRID';


ALTER FUNCTION public.st_srid(chip) OWNER TO postgres;

--
-- TOC entry 745 (class 1255 OID 19102)
-- Dependencies: 6 1102
-- Name: st_srid(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_srid(geometry) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_getSRID';


ALTER FUNCTION public.st_srid(geometry) OWNER TO postgres;

--
-- TOC entry 746 (class 1255 OID 19103)
-- Dependencies: 6 1102 1102
-- Name: st_startpoint(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_startpoint(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_startpoint_linestring';


ALTER FUNCTION public.st_startpoint(geometry) OWNER TO postgres;

--
-- TOC entry 747 (class 1255 OID 19104)
-- Dependencies: 6 1102
-- Name: st_summary(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_summary(geometry) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_summary';


ALTER FUNCTION public.st_summary(geometry) OWNER TO postgres;

--
-- TOC entry 748 (class 1255 OID 19105)
-- Dependencies: 6 1102 1102 1102
-- Name: st_symdifference(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_symdifference(geometry, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'symdifference';


ALTER FUNCTION public.st_symdifference(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 749 (class 1255 OID 19106)
-- Dependencies: 6 1102 1102 1102
-- Name: st_symmetricdifference(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_symmetricdifference(geometry, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'symdifference';


ALTER FUNCTION public.st_symmetricdifference(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 750 (class 1255 OID 19107)
-- Dependencies: 6 1102
-- Name: st_text(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_text(geometry) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_to_text';


ALTER FUNCTION public.st_text(geometry) OWNER TO postgres;

--
-- TOC entry 751 (class 1255 OID 19108)
-- Dependencies: 6 1102 1102
-- Name: st_touches(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_touches(geometry, geometry) RETURNS boolean
    LANGUAGE sql IMMUTABLE
    AS $_$SELECT $1 && $2 AND _ST_Touches($1,$2)$_$;


ALTER FUNCTION public.st_touches(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 752 (class 1255 OID 19109)
-- Dependencies: 6 1102 1102
-- Name: st_transform(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_transform(geometry, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'transform';


ALTER FUNCTION public.st_transform(geometry, integer) OWNER TO postgres;

--
-- TOC entry 754 (class 1255 OID 19111)
-- Dependencies: 6 1102 1102
-- Name: st_translate(geometry, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_translate(geometry, double precision, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT translate($1, $2, $3, 0)$_$;


ALTER FUNCTION public.st_translate(geometry, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 753 (class 1255 OID 19110)
-- Dependencies: 6 1102 1102
-- Name: st_translate(geometry, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_translate(geometry, double precision, double precision, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT affine($1, 1, 0, 0, 0, 1, 0, 0, 0, 1, $2, $3, $4)$_$;


ALTER FUNCTION public.st_translate(geometry, double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 755 (class 1255 OID 19112)
-- Dependencies: 6 1102 1102
-- Name: st_transscale(geometry, double precision, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_transscale(geometry, double precision, double precision, double precision, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT affine($1,  $4, 0, 0,  0, $5, 0,
		0, 0, 1,  $2 * $4, $3 * $5, 0)$_$;


ALTER FUNCTION public.st_transscale(geometry, double precision, double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 757 (class 1255 OID 19114)
-- Dependencies: 6 1102 1104
-- Name: st_union(geometry[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_union(geometry[]) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'pgis_union_geometry_array';


ALTER FUNCTION public.st_union(geometry[]) OWNER TO postgres;

--
-- TOC entry 756 (class 1255 OID 19113)
-- Dependencies: 6 1102 1102 1102
-- Name: st_union(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_union(geometry, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'geomunion';


ALTER FUNCTION public.st_union(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 758 (class 1255 OID 19115)
-- Dependencies: 6 1102 1104
-- Name: st_unite_garray(geometry[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_unite_garray(geometry[]) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'pgis_union_geometry_array';


ALTER FUNCTION public.st_unite_garray(geometry[]) OWNER TO postgres;

--
-- TOC entry 759 (class 1255 OID 19116)
-- Dependencies: 6 1096
-- Name: st_width(chip); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_width(chip) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_getWidth';


ALTER FUNCTION public.st_width(chip) OWNER TO postgres;

--
-- TOC entry 760 (class 1255 OID 19117)
-- Dependencies: 6 1102 1102
-- Name: st_within(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_within(geometry, geometry) RETURNS boolean
    LANGUAGE sql IMMUTABLE
    AS $_$SELECT $1 && $2 AND _ST_Within($1,$2)$_$;


ALTER FUNCTION public.st_within(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 761 (class 1255 OID 19118)
-- Dependencies: 6 1102
-- Name: st_wkbtosql(bytea); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_wkbtosql(bytea) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_from_WKB';


ALTER FUNCTION public.st_wkbtosql(bytea) OWNER TO postgres;

--
-- TOC entry 762 (class 1255 OID 19119)
-- Dependencies: 6 1102
-- Name: st_wkttosql(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_wkttosql(text) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_from_text';


ALTER FUNCTION public.st_wkttosql(text) OWNER TO postgres;

--
-- TOC entry 763 (class 1255 OID 19120)
-- Dependencies: 6 1102
-- Name: st_x(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_x(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_x_point';


ALTER FUNCTION public.st_x(geometry) OWNER TO postgres;

--
-- TOC entry 764 (class 1255 OID 19121)
-- Dependencies: 6 1090
-- Name: st_xmax(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_xmax(box3d) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_xmax';


ALTER FUNCTION public.st_xmax(box3d) OWNER TO postgres;

--
-- TOC entry 765 (class 1255 OID 19122)
-- Dependencies: 6 1090
-- Name: st_xmin(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_xmin(box3d) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_xmin';


ALTER FUNCTION public.st_xmin(box3d) OWNER TO postgres;

--
-- TOC entry 766 (class 1255 OID 19123)
-- Dependencies: 6 1102
-- Name: st_y(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_y(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_y_point';


ALTER FUNCTION public.st_y(geometry) OWNER TO postgres;

--
-- TOC entry 767 (class 1255 OID 19124)
-- Dependencies: 6 1090
-- Name: st_ymax(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_ymax(box3d) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_ymax';


ALTER FUNCTION public.st_ymax(box3d) OWNER TO postgres;

--
-- TOC entry 768 (class 1255 OID 19125)
-- Dependencies: 6 1090
-- Name: st_ymin(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_ymin(box3d) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_ymin';


ALTER FUNCTION public.st_ymin(box3d) OWNER TO postgres;

--
-- TOC entry 769 (class 1255 OID 19126)
-- Dependencies: 6 1102
-- Name: st_z(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_z(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_z_point';


ALTER FUNCTION public.st_z(geometry) OWNER TO postgres;

--
-- TOC entry 770 (class 1255 OID 19127)
-- Dependencies: 6 1090
-- Name: st_zmax(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_zmax(box3d) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_zmax';


ALTER FUNCTION public.st_zmax(box3d) OWNER TO postgres;

--
-- TOC entry 771 (class 1255 OID 19128)
-- Dependencies: 6 1102
-- Name: st_zmflag(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_zmflag(geometry) RETURNS smallint
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_zmflag';


ALTER FUNCTION public.st_zmflag(geometry) OWNER TO postgres;

--
-- TOC entry 772 (class 1255 OID 19129)
-- Dependencies: 6 1090
-- Name: st_zmin(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_zmin(box3d) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_zmin';


ALTER FUNCTION public.st_zmin(box3d) OWNER TO postgres;

--
-- TOC entry 773 (class 1255 OID 19130)
-- Dependencies: 6 1102 1102
-- Name: startpoint(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION startpoint(geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_startpoint_linestring';


ALTER FUNCTION public.startpoint(geometry) OWNER TO postgres;

--
-- TOC entry 774 (class 1255 OID 19131)
-- Dependencies: 6 1102
-- Name: summary(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION summary(geometry) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_summary';


ALTER FUNCTION public.summary(geometry) OWNER TO postgres;

--
-- TOC entry 775 (class 1255 OID 19132)
-- Dependencies: 6 1102 1102 1102
-- Name: symdifference(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION symdifference(geometry, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'symdifference';


ALTER FUNCTION public.symdifference(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 776 (class 1255 OID 19133)
-- Dependencies: 6 1102 1102 1102
-- Name: symmetricdifference(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION symmetricdifference(geometry, geometry) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'symdifference';


ALTER FUNCTION public.symmetricdifference(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 777 (class 1255 OID 19134)
-- Dependencies: 6 1102
-- Name: text(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION text(geometry) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_to_text';


ALTER FUNCTION public.text(geometry) OWNER TO postgres;

--
-- TOC entry 778 (class 1255 OID 19135)
-- Dependencies: 6 1102 1102
-- Name: touches(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION touches(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'touches';


ALTER FUNCTION public.touches(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 779 (class 1255 OID 19136)
-- Dependencies: 6 1102 1102
-- Name: transform(geometry, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION transform(geometry, integer) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'transform';


ALTER FUNCTION public.transform(geometry, integer) OWNER TO postgres;

--
-- TOC entry 781 (class 1255 OID 19138)
-- Dependencies: 6 1102 1102
-- Name: translate(geometry, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION translate(geometry, double precision, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT translate($1, $2, $3, 0)$_$;


ALTER FUNCTION public.translate(geometry, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 780 (class 1255 OID 19137)
-- Dependencies: 6 1102 1102
-- Name: translate(geometry, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION translate(geometry, double precision, double precision, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT affine($1, 1, 0, 0, 0, 1, 0, 0, 0, 1, $2, $3, $4)$_$;


ALTER FUNCTION public.translate(geometry, double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 782 (class 1255 OID 19139)
-- Dependencies: 6 1102 1102
-- Name: transscale(geometry, double precision, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION transscale(geometry, double precision, double precision, double precision, double precision) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT affine($1,  $4, 0, 0,  0, $5, 0,
		0, 0, 1,  $2 * $4, $3 * $5, 0)$_$;


ALTER FUNCTION public.transscale(geometry, double precision, double precision, double precision, double precision) OWNER TO postgres;

--
-- TOC entry 783 (class 1255 OID 19140)
-- Dependencies: 6 1102 1104
-- Name: unite_garray(geometry[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION unite_garray(geometry[]) RETURNS geometry
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'pgis_union_geometry_array';


ALTER FUNCTION public.unite_garray(geometry[]) OWNER TO postgres;

--
-- TOC entry 784 (class 1255 OID 19141)
-- Dependencies: 6 1170
-- Name: unlockrows(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION unlockrows(text) RETURNS integer
    LANGUAGE plpgsql STRICT
    AS $_$ 
DECLARE
	ret int;
BEGIN

	IF NOT LongTransactionsEnabled() THEN
		RAISE EXCEPTION 'Long transaction support disabled, use EnableLongTransaction() to enable.';
	END IF;

	EXECUTE 'DELETE FROM authorization_table where authid = ' ||
		quote_literal($1);

	GET DIAGNOSTICS ret = ROW_COUNT;

	RETURN ret;
END;
$_$;


ALTER FUNCTION public.unlockrows(text) OWNER TO postgres;

--
-- TOC entry 787 (class 1255 OID 19144)
-- Dependencies: 6 1170
-- Name: updategeometrysrid(character varying, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION updategeometrysrid(character varying, character varying, integer) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	ret  text;
BEGIN
	SELECT UpdateGeometrySRID('','',$1,$2,$3) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.updategeometrysrid(character varying, character varying, integer) OWNER TO postgres;

--
-- TOC entry 786 (class 1255 OID 19143)
-- Dependencies: 6 1170
-- Name: updategeometrysrid(character varying, character varying, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION updategeometrysrid(character varying, character varying, character varying, integer) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	ret  text;
BEGIN
	SELECT UpdateGeometrySRID('',$1,$2,$3,$4) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.updategeometrysrid(character varying, character varying, character varying, integer) OWNER TO postgres;

--
-- TOC entry 785 (class 1255 OID 19142)
-- Dependencies: 6 1170
-- Name: updategeometrysrid(character varying, character varying, character varying, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION updategeometrysrid(character varying, character varying, character varying, character varying, integer) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	catalog_name alias for $1;
	schema_name alias for $2;
	table_name alias for $3;
	column_name alias for $4;
	new_srid alias for $5;
	myrec RECORD;
	okay boolean;
	cname varchar;
	real_schema name;

BEGIN


	-- Find, check or fix schema_name
	IF ( schema_name != '' ) THEN
		okay = 'f';

		FOR myrec IN SELECT nspname FROM pg_namespace WHERE text(nspname) = schema_name LOOP
			okay := 't';
		END LOOP;

		IF ( okay <> 't' ) THEN
			RAISE EXCEPTION 'Invalid schema name';
		ELSE
			real_schema = schema_name;
		END IF;
	ELSE
		SELECT INTO real_schema current_schema()::text;
	END IF;

	-- Find out if the column is in the geometry_columns table
	okay = 'f';
	FOR myrec IN SELECT * from geometry_columns where f_table_schema = text(real_schema) and f_table_name = table_name and f_geometry_column = column_name LOOP
		okay := 't';
	END LOOP;
	IF (okay <> 't') THEN
		RAISE EXCEPTION 'column not found in geometry_columns table';
		RETURN 'f';
	END IF;

	-- Update ref from geometry_columns table
	EXECUTE 'UPDATE geometry_columns SET SRID = ' || new_srid::text ||
		' where f_table_schema = ' ||
		quote_literal(real_schema) || ' and f_table_name = ' ||
		quote_literal(table_name)  || ' and f_geometry_column = ' ||
		quote_literal(column_name);

	-- Make up constraint name
	cname = 'enforce_srid_'  || column_name;

	-- Drop enforce_srid constraint
	EXECUTE 'ALTER TABLE ' || quote_ident(real_schema) ||
		'.' || quote_ident(table_name) ||
		' DROP constraint ' || quote_ident(cname);

	-- Update geometries SRID
	EXECUTE 'UPDATE ' || quote_ident(real_schema) ||
		'.' || quote_ident(table_name) ||
		' SET ' || quote_ident(column_name) ||
		' = setSRID(' || quote_ident(column_name) ||
		', ' || new_srid::text || ')';

	-- Reset enforce_srid constraint
	EXECUTE 'ALTER TABLE ' || quote_ident(real_schema) ||
		'.' || quote_ident(table_name) ||
		' ADD constraint ' || quote_ident(cname) ||
		' CHECK (srid(' || quote_ident(column_name) ||
		') = ' || new_srid::text || ')';

	RETURN real_schema || '.' || table_name || '.' || column_name ||' SRID changed to ' || new_srid::text;

END;
$_$;


ALTER FUNCTION public.updategeometrysrid(character varying, character varying, character varying, character varying, integer) OWNER TO postgres;

--
-- TOC entry 788 (class 1255 OID 19145)
-- Dependencies: 6 1096
-- Name: width(chip); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION width(chip) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'CHIP_getWidth';


ALTER FUNCTION public.width(chip) OWNER TO postgres;

--
-- TOC entry 789 (class 1255 OID 19146)
-- Dependencies: 6 1102 1102
-- Name: within(geometry, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION within(geometry, geometry) RETURNS boolean
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'within';


ALTER FUNCTION public.within(geometry, geometry) OWNER TO postgres;

--
-- TOC entry 790 (class 1255 OID 19147)
-- Dependencies: 6 1102
-- Name: x(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION x(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_x_point';


ALTER FUNCTION public.x(geometry) OWNER TO postgres;

--
-- TOC entry 791 (class 1255 OID 19148)
-- Dependencies: 6 1090
-- Name: xmax(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION xmax(box3d) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_xmax';


ALTER FUNCTION public.xmax(box3d) OWNER TO postgres;

--
-- TOC entry 792 (class 1255 OID 19149)
-- Dependencies: 6 1090
-- Name: xmin(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION xmin(box3d) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_xmin';


ALTER FUNCTION public.xmin(box3d) OWNER TO postgres;

--
-- TOC entry 793 (class 1255 OID 19150)
-- Dependencies: 6 1102
-- Name: y(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION y(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_y_point';


ALTER FUNCTION public.y(geometry) OWNER TO postgres;

--
-- TOC entry 794 (class 1255 OID 19151)
-- Dependencies: 6 1090
-- Name: ymax(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION ymax(box3d) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_ymax';


ALTER FUNCTION public.ymax(box3d) OWNER TO postgres;

--
-- TOC entry 795 (class 1255 OID 19152)
-- Dependencies: 6 1090
-- Name: ymin(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION ymin(box3d) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_ymin';


ALTER FUNCTION public.ymin(box3d) OWNER TO postgres;

--
-- TOC entry 796 (class 1255 OID 19153)
-- Dependencies: 6 1102
-- Name: z(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION z(geometry) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_z_point';


ALTER FUNCTION public.z(geometry) OWNER TO postgres;

--
-- TOC entry 797 (class 1255 OID 19154)
-- Dependencies: 6 1090
-- Name: zmax(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION zmax(box3d) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_zmax';


ALTER FUNCTION public.zmax(box3d) OWNER TO postgres;

--
-- TOC entry 798 (class 1255 OID 19155)
-- Dependencies: 6 1102
-- Name: zmflag(geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION zmflag(geometry) RETURNS smallint
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'LWGEOM_zmflag';


ALTER FUNCTION public.zmflag(geometry) OWNER TO postgres;

--
-- TOC entry 799 (class 1255 OID 19156)
-- Dependencies: 6 1090
-- Name: zmin(box3d); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION zmin(box3d) RETURNS double precision
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/postgis-1.5', 'BOX3D_zmin';


ALTER FUNCTION public.zmin(box3d) OWNER TO postgres;

--
-- TOC entry 1175 (class 1255 OID 19157)
-- Dependencies: 6 1104 1102 330 329
-- Name: accum(geometry); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE accum(geometry) (
    SFUNC = pgis_geometry_accum_transfn,
    STYPE = pgis_abs,
    FINALFUNC = pgis_geometry_accum_finalfn
);


ALTER AGGREGATE public.accum(geometry) OWNER TO postgres;

--
-- TOC entry 1176 (class 1255 OID 19158)
-- Dependencies: 6 1102 1102 330 331
-- Name: collect(geometry); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE collect(geometry) (
    SFUNC = pgis_geometry_accum_transfn,
    STYPE = pgis_abs,
    FINALFUNC = pgis_geometry_collect_finalfn
);


ALTER AGGREGATE public.collect(geometry) OWNER TO postgres;

--
-- TOC entry 1177 (class 1255 OID 19159)
-- Dependencies: 6 1093 1102 500
-- Name: extent(geometry); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE extent(geometry) (
    SFUNC = public.st_combine_bbox,
    STYPE = box3d_extent
);


ALTER AGGREGATE public.extent(geometry) OWNER TO postgres;

--
-- TOC entry 1178 (class 1255 OID 19160)
-- Dependencies: 6 1090 1102 124
-- Name: extent3d(geometry); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE extent3d(geometry) (
    SFUNC = public.combine_bbox,
    STYPE = box3d
);


ALTER AGGREGATE public.extent3d(geometry) OWNER TO postgres;

--
-- TOC entry 1179 (class 1255 OID 19161)
-- Dependencies: 6 1102 1102 330 332
-- Name: makeline(geometry); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE makeline(geometry) (
    SFUNC = pgis_geometry_accum_transfn,
    STYPE = pgis_abs,
    FINALFUNC = pgis_geometry_makeline_finalfn
);


ALTER AGGREGATE public.makeline(geometry) OWNER TO postgres;

--
-- TOC entry 1180 (class 1255 OID 19162)
-- Dependencies: 6 1102 1102 496
-- Name: memcollect(geometry); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE memcollect(geometry) (
    SFUNC = public.st_collect,
    STYPE = geometry
);


ALTER AGGREGATE public.memcollect(geometry) OWNER TO postgres;

--
-- TOC entry 1181 (class 1255 OID 19163)
-- Dependencies: 1102 6 1102 231
-- Name: memgeomunion(geometry); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE memgeomunion(geometry) (
    SFUNC = geomunion,
    STYPE = geometry
);


ALTER AGGREGATE public.memgeomunion(geometry) OWNER TO postgres;

--
-- TOC entry 1182 (class 1255 OID 19164)
-- Dependencies: 333 6 1102 1102 330
-- Name: polygonize(geometry); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE polygonize(geometry) (
    SFUNC = pgis_geometry_accum_transfn,
    STYPE = pgis_abs,
    FINALFUNC = pgis_geometry_polygonize_finalfn
);


ALTER AGGREGATE public.polygonize(geometry) OWNER TO postgres;

--
-- TOC entry 1183 (class 1255 OID 19165)
-- Dependencies: 1104 1102 329 330 6
-- Name: st_accum(geometry); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE st_accum(geometry) (
    SFUNC = pgis_geometry_accum_transfn,
    STYPE = pgis_abs,
    FINALFUNC = pgis_geometry_accum_finalfn
);


ALTER AGGREGATE public.st_accum(geometry) OWNER TO postgres;

--
-- TOC entry 1184 (class 1255 OID 19166)
-- Dependencies: 330 331 1102 1102 6
-- Name: st_collect(geometry); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE st_collect(geometry) (
    SFUNC = pgis_geometry_accum_transfn,
    STYPE = pgis_abs,
    FINALFUNC = pgis_geometry_collect_finalfn
);


ALTER AGGREGATE public.st_collect(geometry) OWNER TO postgres;

--
-- TOC entry 1185 (class 1255 OID 19167)
-- Dependencies: 1102 6 1093 500
-- Name: st_extent(geometry); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE st_extent(geometry) (
    SFUNC = public.st_combine_bbox,
    STYPE = box3d_extent
);


ALTER AGGREGATE public.st_extent(geometry) OWNER TO postgres;

--
-- TOC entry 1171 (class 1255 OID 19168)
-- Dependencies: 1090 6 1102 501
-- Name: st_extent3d(geometry); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE st_extent3d(geometry) (
    SFUNC = public.st_combine_bbox,
    STYPE = box3d
);


ALTER AGGREGATE public.st_extent3d(geometry) OWNER TO postgres;

--
-- TOC entry 1172 (class 1255 OID 19169)
-- Dependencies: 1102 330 332 6 1102
-- Name: st_makeline(geometry); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE st_makeline(geometry) (
    SFUNC = pgis_geometry_accum_transfn,
    STYPE = pgis_abs,
    FINALFUNC = pgis_geometry_makeline_finalfn
);


ALTER AGGREGATE public.st_makeline(geometry) OWNER TO postgres;

--
-- TOC entry 1173 (class 1255 OID 19170)
-- Dependencies: 1102 6 496 1102
-- Name: st_memcollect(geometry); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE st_memcollect(geometry) (
    SFUNC = public.st_collect,
    STYPE = geometry
);


ALTER AGGREGATE public.st_memcollect(geometry) OWNER TO postgres;

--
-- TOC entry 1174 (class 1255 OID 19171)
-- Dependencies: 756 6 1102 1102
-- Name: st_memunion(geometry); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE st_memunion(geometry) (
    SFUNC = public.st_union,
    STYPE = geometry
);


ALTER AGGREGATE public.st_memunion(geometry) OWNER TO postgres;

--
-- TOC entry 1186 (class 1255 OID 19172)
-- Dependencies: 1102 6 1102 330 333
-- Name: st_polygonize(geometry); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE st_polygonize(geometry) (
    SFUNC = pgis_geometry_accum_transfn,
    STYPE = pgis_abs,
    FINALFUNC = pgis_geometry_polygonize_finalfn
);


ALTER AGGREGATE public.st_polygonize(geometry) OWNER TO postgres;

--
-- TOC entry 1187 (class 1255 OID 19173)
-- Dependencies: 334 330 1102 6 1102
-- Name: st_union(geometry); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE st_union(geometry) (
    SFUNC = pgis_geometry_accum_transfn,
    STYPE = pgis_abs,
    FINALFUNC = pgis_geometry_union_finalfn
);


ALTER AGGREGATE public.st_union(geometry) OWNER TO postgres;

--
-- TOC entry 1893 (class 2617 OID 19174)
-- Dependencies: 1102 6 207 208 215 1102
-- Name: &&; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR && (
    PROCEDURE = geometry_overlap,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = &&,
    RESTRICT = geometry_gist_sel,
    JOIN = geometry_gist_joinsel
);


ALTER OPERATOR public.&& (geometry, geometry) OWNER TO postgres;

--
-- TOC entry 1894 (class 2617 OID 19175)
-- Dependencies: 1099 6 176 180 185 1099
-- Name: &&; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR && (
    PROCEDURE = geography_overlaps,
    LEFTARG = geography,
    RIGHTARG = geography,
    COMMUTATOR = &&,
    RESTRICT = geography_gist_selectivity,
    JOIN = geography_gist_join_selectivity
);


ALTER OPERATOR public.&& (geography, geography) OWNER TO postgres;

--
-- TOC entry 1895 (class 2617 OID 19177)
-- Dependencies: 1102 216 6 1102
-- Name: &<; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR &< (
    PROCEDURE = geometry_overleft,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = &>,
    RESTRICT = positionsel,
    JOIN = positionjoinsel
);


ALTER OPERATOR public.&< (geometry, geometry) OWNER TO postgres;

--
-- TOC entry 1896 (class 2617 OID 19179)
-- Dependencies: 1102 214 6 1102
-- Name: &<|; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR &<| (
    PROCEDURE = geometry_overbelow,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = |&>,
    RESTRICT = positionsel,
    JOIN = positionjoinsel
);


ALTER OPERATOR public.&<| (geometry, geometry) OWNER TO postgres;

--
-- TOC entry 1897 (class 2617 OID 19176)
-- Dependencies: 6 217 1102 1102
-- Name: &>; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR &> (
    PROCEDURE = geometry_overright,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = &<,
    RESTRICT = positionsel,
    JOIN = positionjoinsel
);


ALTER OPERATOR public.&> (geometry, geometry) OWNER TO postgres;

--
-- TOC entry 1898 (class 2617 OID 19182)
-- Dependencies: 212 6 1102 1102
-- Name: <; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR < (
    PROCEDURE = geometry_lt,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = >,
    NEGATOR = >=,
    RESTRICT = contsel,
    JOIN = contjoinsel
);


ALTER OPERATOR public.< (geometry, geometry) OWNER TO postgres;

--
-- TOC entry 1901 (class 2617 OID 19185)
-- Dependencies: 6 184 1099 1099
-- Name: <; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR < (
    PROCEDURE = geography_lt,
    LEFTARG = geography,
    RIGHTARG = geography,
    COMMUTATOR = >,
    NEGATOR = >=,
    RESTRICT = contsel,
    JOIN = contjoinsel
);


ALTER OPERATOR public.< (geography, geography) OWNER TO postgres;

--
-- TOC entry 1902 (class 2617 OID 19187)
-- Dependencies: 6 211 1102 1102
-- Name: <<; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR << (
    PROCEDURE = geometry_left,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = >>,
    RESTRICT = positionsel,
    JOIN = positionjoinsel
);


ALTER OPERATOR public.<< (geometry, geometry) OWNER TO postgres;

--
-- TOC entry 1903 (class 2617 OID 19189)
-- Dependencies: 1102 1102 201 6
-- Name: <<|; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR <<| (
    PROCEDURE = geometry_below,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = |>>,
    RESTRICT = positionsel,
    JOIN = positionjoinsel
);


ALTER OPERATOR public.<<| (geometry, geometry) OWNER TO postgres;

--
-- TOC entry 1904 (class 2617 OID 19190)
-- Dependencies: 6 210 1102 1102
-- Name: <=; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR <= (
    PROCEDURE = geometry_le,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = >=,
    NEGATOR = >,
    RESTRICT = contsel,
    JOIN = contjoinsel
);


ALTER OPERATOR public.<= (geometry, geometry) OWNER TO postgres;

--
-- TOC entry 1905 (class 2617 OID 19191)
-- Dependencies: 1099 1099 183 6
-- Name: <=; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR <= (
    PROCEDURE = geography_le,
    LEFTARG = geography,
    RIGHTARG = geography,
    COMMUTATOR = >=,
    NEGATOR = >,
    RESTRICT = contsel,
    JOIN = contjoinsel
);


ALTER OPERATOR public.<= (geography, geography) OWNER TO postgres;

--
-- TOC entry 1906 (class 2617 OID 19192)
-- Dependencies: 205 1102 6 1102
-- Name: =; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR = (
    PROCEDURE = geometry_eq,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = =,
    RESTRICT = contsel,
    JOIN = contjoinsel
);


ALTER OPERATOR public.= (geometry, geometry) OWNER TO postgres;

--
-- TOC entry 1907 (class 2617 OID 19193)
-- Dependencies: 171 1099 6 1099
-- Name: =; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR = (
    PROCEDURE = geography_eq,
    LEFTARG = geography,
    RIGHTARG = geography,
    COMMUTATOR = =,
    RESTRICT = contsel,
    JOIN = contjoinsel
);


ALTER OPERATOR public.= (geography, geography) OWNER TO postgres;

--
-- TOC entry 1899 (class 2617 OID 19180)
-- Dependencies: 1102 209 1102 6
-- Name: >; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR > (
    PROCEDURE = geometry_gt,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = <,
    NEGATOR = <=,
    RESTRICT = contsel,
    JOIN = contjoinsel
);


ALTER OPERATOR public.> (geometry, geometry) OWNER TO postgres;

--
-- TOC entry 1908 (class 2617 OID 19183)
-- Dependencies: 6 182 1099 1099
-- Name: >; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR > (
    PROCEDURE = geography_gt,
    LEFTARG = geography,
    RIGHTARG = geography,
    COMMUTATOR = <,
    NEGATOR = <=,
    RESTRICT = contsel,
    JOIN = contjoinsel
);


ALTER OPERATOR public.> (geography, geography) OWNER TO postgres;

--
-- TOC entry 1909 (class 2617 OID 19181)
-- Dependencies: 6 206 1102 1102
-- Name: >=; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR >= (
    PROCEDURE = geometry_ge,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = <=,
    NEGATOR = <,
    RESTRICT = contsel,
    JOIN = contjoinsel
);


ALTER OPERATOR public.>= (geometry, geometry) OWNER TO postgres;

--
-- TOC entry 1910 (class 2617 OID 19184)
-- Dependencies: 6 172 1099 1099
-- Name: >=; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR >= (
    PROCEDURE = geography_ge,
    LEFTARG = geography,
    RIGHTARG = geography,
    COMMUTATOR = <=,
    NEGATOR = <,
    RESTRICT = contsel,
    JOIN = contjoinsel
);


ALTER OPERATOR public.>= (geography, geography) OWNER TO postgres;

--
-- TOC entry 1911 (class 2617 OID 19186)
-- Dependencies: 1102 1102 218 6
-- Name: >>; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR >> (
    PROCEDURE = geometry_right,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = <<,
    RESTRICT = positionsel,
    JOIN = positionjoinsel
);


ALTER OPERATOR public.>> (geometry, geometry) OWNER TO postgres;

--
-- TOC entry 1912 (class 2617 OID 19195)
-- Dependencies: 6 204 1102 1102
-- Name: @; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR @ (
    PROCEDURE = geometry_contained,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = ~,
    RESTRICT = contsel,
    JOIN = contjoinsel
);


ALTER OPERATOR public.@ (geometry, geometry) OWNER TO postgres;

--
-- TOC entry 1900 (class 2617 OID 19178)
-- Dependencies: 6 1102 213 1102
-- Name: |&>; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR |&> (
    PROCEDURE = geometry_overabove,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = &<|,
    RESTRICT = positionsel,
    JOIN = positionjoinsel
);


ALTER OPERATOR public.|&> (geometry, geometry) OWNER TO postgres;

--
-- TOC entry 1913 (class 2617 OID 19188)
-- Dependencies: 200 6 1102 1102
-- Name: |>>; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR |>> (
    PROCEDURE = geometry_above,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = <<|,
    RESTRICT = positionsel,
    JOIN = positionjoinsel
);


ALTER OPERATOR public.|>> (geometry, geometry) OWNER TO postgres;

--
-- TOC entry 1914 (class 2617 OID 19194)
-- Dependencies: 203 1102 1102 6
-- Name: ~; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR ~ (
    PROCEDURE = geometry_contain,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = @,
    RESTRICT = contsel,
    JOIN = contjoinsel
);


ALTER OPERATOR public.~ (geometry, geometry) OWNER TO postgres;

--
-- TOC entry 1915 (class 2617 OID 19196)
-- Dependencies: 6 1102 1102 220
-- Name: ~=; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR ~= (
    PROCEDURE = geometry_samebox,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = ~=,
    RESTRICT = eqsel,
    JOIN = eqjoinsel
);


ALTER OPERATOR public.~= (geometry, geometry) OWNER TO postgres;

--
-- TOC entry 2028 (class 2616 OID 19198)
-- Dependencies: 6 1099 2139
-- Name: btree_geography_ops; Type: OPERATOR CLASS; Schema: public; Owner: postgres
--

CREATE OPERATOR CLASS btree_geography_ops
    DEFAULT FOR TYPE geography USING btree AS
    OPERATOR 1 <(geography,geography) ,
    OPERATOR 2 <=(geography,geography) ,
    OPERATOR 3 =(geography,geography) ,
    OPERATOR 4 >=(geography,geography) ,
    OPERATOR 5 >(geography,geography) ,
    FUNCTION 1 geography_cmp(geography,geography);


ALTER OPERATOR CLASS public.btree_geography_ops USING btree OWNER TO postgres;

--
-- TOC entry 2029 (class 2616 OID 19206)
-- Dependencies: 6 1102 2140
-- Name: btree_geometry_ops; Type: OPERATOR CLASS; Schema: public; Owner: postgres
--

CREATE OPERATOR CLASS btree_geometry_ops
    DEFAULT FOR TYPE geometry USING btree AS
    OPERATOR 1 <(geometry,geometry) ,
    OPERATOR 2 <=(geometry,geometry) ,
    OPERATOR 3 =(geometry,geometry) ,
    OPERATOR 4 >=(geometry,geometry) ,
    OPERATOR 5 >(geometry,geometry) ,
    FUNCTION 1 geometry_cmp(geometry,geometry);


ALTER OPERATOR CLASS public.btree_geometry_ops USING btree OWNER TO postgres;

--
-- TOC entry 2030 (class 2616 OID 19214)
-- Dependencies: 2141 6 1107 1099
-- Name: gist_geography_ops; Type: OPERATOR CLASS; Schema: public; Owner: postgres
--

CREATE OPERATOR CLASS gist_geography_ops
    DEFAULT FOR TYPE geography USING gist AS
    STORAGE gidx ,
    OPERATOR 3 &&(geography,geography) ,
    FUNCTION 1 geography_gist_consistent(internal,geometry,integer) ,
    FUNCTION 2 geography_gist_union(bytea,internal) ,
    FUNCTION 3 geography_gist_compress(internal) ,
    FUNCTION 4 geography_gist_decompress(internal) ,
    FUNCTION 5 geography_gist_penalty(internal,internal,internal) ,
    FUNCTION 6 geography_gist_picksplit(internal,internal) ,
    FUNCTION 7 geography_gist_same(box2d,box2d,internal);


ALTER OPERATOR CLASS public.gist_geography_ops USING gist OWNER TO postgres;

--
-- TOC entry 2031 (class 2616 OID 19224)
-- Dependencies: 1102 6 2142 1087
-- Name: gist_geometry_ops; Type: OPERATOR CLASS; Schema: public; Owner: postgres
--

CREATE OPERATOR CLASS gist_geometry_ops
    DEFAULT FOR TYPE geometry USING gist AS
    STORAGE box2d ,
    OPERATOR 1 <<(geometry,geometry) ,
    OPERATOR 2 &<(geometry,geometry) ,
    OPERATOR 3 &&(geometry,geometry) ,
    OPERATOR 4 &>(geometry,geometry) ,
    OPERATOR 5 >>(geometry,geometry) ,
    OPERATOR 6 ~=(geometry,geometry) ,
    OPERATOR 7 ~(geometry,geometry) ,
    OPERATOR 8 @(geometry,geometry) ,
    OPERATOR 9 &<|(geometry,geometry) ,
    OPERATOR 10 <<|(geometry,geometry) ,
    OPERATOR 11 |>>(geometry,geometry) ,
    OPERATOR 12 |&>(geometry,geometry) ,
    FUNCTION 1 lwgeom_gist_consistent(internal,geometry,integer) ,
    FUNCTION 2 lwgeom_gist_union(bytea,internal) ,
    FUNCTION 3 lwgeom_gist_compress(internal) ,
    FUNCTION 4 lwgeom_gist_decompress(internal) ,
    FUNCTION 5 lwgeom_gist_penalty(internal,internal,internal) ,
    FUNCTION 6 lwgeom_gist_picksplit(internal,internal) ,
    FUNCTION 7 lwgeom_gist_same(box2d,box2d,internal);


ALTER OPERATOR CLASS public.gist_geometry_ops USING gist OWNER TO postgres;

SET search_path = pg_catalog;

--
-- TOC entry 2712 (class 2605 OID 19244)
-- Dependencies: 110 110 1087 1090
-- Name: CAST (public.box2d AS public.box3d); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.box2d AS public.box3d) WITH FUNCTION public.box3d(public.box2d) AS IMPLICIT;


--
-- TOC entry 2713 (class 2605 OID 19245)
-- Dependencies: 194 1102 1087 194
-- Name: CAST (public.box2d AS public.geometry); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.box2d AS public.geometry) WITH FUNCTION public.geometry(public.box2d) AS IMPLICIT;


--
-- TOC entry 2714 (class 2605 OID 19246)
-- Dependencies: 105 1090 105
-- Name: CAST (public.box3d AS box); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.box3d AS box) WITH FUNCTION public.box(public.box3d) AS IMPLICIT;


--
-- TOC entry 2715 (class 2605 OID 19247)
-- Dependencies: 108 108 1087 1090
-- Name: CAST (public.box3d AS public.box2d); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.box3d AS public.box2d) WITH FUNCTION public.box2d(public.box3d) AS IMPLICIT;


--
-- TOC entry 2716 (class 2605 OID 19248)
-- Dependencies: 195 1090 1102 195
-- Name: CAST (public.box3d AS public.geometry); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.box3d AS public.geometry) WITH FUNCTION public.geometry(public.box3d) AS IMPLICIT;


--
-- TOC entry 2717 (class 2605 OID 19249)
-- Dependencies: 106 106 1087 1093
-- Name: CAST (public.box3d_extent AS public.box2d); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.box3d_extent AS public.box2d) WITH FUNCTION public.box2d(public.box3d_extent) AS IMPLICIT;


--
-- TOC entry 2718 (class 2605 OID 19250)
-- Dependencies: 111 1093 1090 111
-- Name: CAST (public.box3d_extent AS public.box3d); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.box3d_extent AS public.box3d) WITH FUNCTION public.box3d_extent(public.box3d_extent) AS IMPLICIT;


--
-- TOC entry 2719 (class 2605 OID 19251)
-- Dependencies: 193 1093 193 1102
-- Name: CAST (public.box3d_extent AS public.geometry); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.box3d_extent AS public.geometry) WITH FUNCTION public.geometry(public.box3d_extent) AS IMPLICIT;


--
-- TOC entry 2523 (class 2605 OID 19252)
-- Dependencies: 198 1102 198
-- Name: CAST (bytea AS public.geometry); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (bytea AS public.geometry) WITH FUNCTION public.geometry(bytea) AS IMPLICIT;


--
-- TOC entry 2720 (class 2605 OID 19253)
-- Dependencies: 197 197 1096 1102
-- Name: CAST (public.chip AS public.geometry); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.chip AS public.geometry) WITH FUNCTION public.geometry(public.chip) AS IMPLICIT;


--
-- TOC entry 2721 (class 2605 OID 19254)
-- Dependencies: 168 1099 1099 168
-- Name: CAST (public.geography AS public.geography); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.geography AS public.geography) WITH FUNCTION public.geography(public.geography, integer, boolean) AS IMPLICIT;


--
-- TOC entry 2722 (class 2605 OID 19255)
-- Dependencies: 199 199 1099 1102
-- Name: CAST (public.geography AS public.geometry); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.geography AS public.geometry) WITH FUNCTION public.geometry(public.geography);


--
-- TOC entry 2725 (class 2605 OID 19256)
-- Dependencies: 104 104 1102
-- Name: CAST (public.geometry AS box); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.geometry AS box) WITH FUNCTION public.box(public.geometry) AS IMPLICIT;


--
-- TOC entry 2726 (class 2605 OID 19257)
-- Dependencies: 107 107 1102 1087
-- Name: CAST (public.geometry AS public.box2d); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.geometry AS public.box2d) WITH FUNCTION public.box2d(public.geometry) AS IMPLICIT;


--
-- TOC entry 2727 (class 2605 OID 19258)
-- Dependencies: 109 1090 109 1102
-- Name: CAST (public.geometry AS public.box3d); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.geometry AS public.box3d) WITH FUNCTION public.box3d(public.geometry) AS IMPLICIT;


--
-- TOC entry 2723 (class 2605 OID 19259)
-- Dependencies: 116 116 1102
-- Name: CAST (public.geometry AS bytea); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.geometry AS bytea) WITH FUNCTION public.bytea(public.geometry) AS IMPLICIT;


--
-- TOC entry 2728 (class 2605 OID 19260)
-- Dependencies: 169 1102 169 1099
-- Name: CAST (public.geometry AS public.geography); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.geometry AS public.geography) WITH FUNCTION public.geography(public.geometry) AS IMPLICIT;


--
-- TOC entry 2724 (class 2605 OID 19261)
-- Dependencies: 777 777 1102
-- Name: CAST (public.geometry AS text); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.geometry AS text) WITH FUNCTION public.text(public.geometry) AS IMPLICIT;


--
-- TOC entry 2589 (class 2605 OID 19262)
-- Dependencies: 196 196 1102
-- Name: CAST (text AS public.geometry); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (text AS public.geometry) WITH FUNCTION public.geometry(text) AS IMPLICIT;


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 2411 (class 1259 OID 19263)
-- Dependencies: 6
-- Name: agency; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE agency (
    agency_url text,
    agency_name text,
    agency_timezone text,
    agency_id integer NOT NULL
);


ALTER TABLE public.agency OWNER TO postgres;

--
-- TOC entry 2412 (class 1259 OID 19269)
-- Dependencies: 6
-- Name: calendar; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE calendar (
    service_id text NOT NULL,
    start_date text,
    end_date text,
    monday integer,
    tuesday integer,
    wednesday integer,
    thursday integer,
    friday integer,
    saturday integer,
    sunday integer
);


ALTER TABLE public.calendar OWNER TO postgres;

--
-- TOC entry 2413 (class 1259 OID 19275)
-- Dependencies: 6
-- Name: calendar_dates; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE calendar_dates (
    service_id text NOT NULL,
    date text NOT NULL,
    exception_type text
);


ALTER TABLE public.calendar_dates OWNER TO postgres;

--
-- TOC entry 2414 (class 1259 OID 19281)
-- Dependencies: 2518 6
-- Name: geography_columns; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW geography_columns AS
    SELECT current_database() AS f_table_catalog, n.nspname AS f_table_schema, c.relname AS f_table_name, a.attname AS f_geography_column, geography_typmod_dims(a.atttypmod) AS coord_dimension, geography_typmod_srid(a.atttypmod) AS srid, geography_typmod_type(a.atttypmod) AS type FROM pg_class c, pg_attribute a, pg_type t, pg_namespace n WHERE ((((((c.relkind = ANY (ARRAY['r'::"char", 'v'::"char"])) AND (t.typname = 'geography'::name)) AND (a.attisdropped = false)) AND (a.atttypid = t.oid)) AND (a.attrelid = c.oid)) AND (c.relnamespace = n.oid));


ALTER TABLE public.geography_columns OWNER TO postgres;

SET default_with_oids = true;

--
-- TOC entry 2415 (class 1259 OID 19286)
-- Dependencies: 6
-- Name: geometry_columns; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE geometry_columns (
    f_table_catalog character varying(256) NOT NULL,
    f_table_schema character varying(256) NOT NULL,
    f_table_name character varying(256) NOT NULL,
    f_geometry_column character varying(256) NOT NULL,
    coord_dimension integer NOT NULL,
    srid integer NOT NULL,
    type character varying(30) NOT NULL
);


ALTER TABLE public.geometry_columns OWNER TO postgres;

SET default_with_oids = false;

--
-- TOC entry 2416 (class 1259 OID 19292)
-- Dependencies: 6
-- Name: myway_observations; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE myway_observations (
    observation_id text NOT NULL,
    myway_stop text,
    "time" timestamp with time zone,
    myway_route text
);


ALTER TABLE public.myway_observations OWNER TO postgres;

--
-- TOC entry 2417 (class 1259 OID 19298)
-- Dependencies: 6
-- Name: myway_routes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE myway_routes (
    myway_route text NOT NULL,
    route_full_name text
);


ALTER TABLE public.myway_routes OWNER TO postgres;

--
-- TOC entry 2418 (class 1259 OID 19304)
-- Dependencies: 6 2417
-- Name: myway_routes_myway_route_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE myway_routes_myway_route_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.myway_routes_myway_route_seq OWNER TO postgres;

--
-- TOC entry 2775 (class 0 OID 0)
-- Dependencies: 2418
-- Name: myway_routes_myway_route_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE myway_routes_myway_route_seq OWNED BY myway_routes.myway_route;


--
-- TOC entry 2419 (class 1259 OID 19306)
-- Dependencies: 2417 6
-- Name: myway_routes_route_full_name_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE myway_routes_route_full_name_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.myway_routes_route_full_name_seq OWNER TO postgres;

--
-- TOC entry 2776 (class 0 OID 0)
-- Dependencies: 2419
-- Name: myway_routes_route_full_name_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE myway_routes_route_full_name_seq OWNED BY myway_routes.route_full_name;


--
-- TOC entry 2420 (class 1259 OID 19308)
-- Dependencies: 6
-- Name: myway_stops; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE myway_stops (
    myway_stop text NOT NULL,
    stop_code text,
    stop_street text
);


ALTER TABLE public.myway_stops OWNER TO postgres;

--
-- TOC entry 2421 (class 1259 OID 19314)
-- Dependencies: 6
-- Name: myway_timingdeltas; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE myway_timingdeltas (
    observation_id text NOT NULL,
    route_full_name text,
    stop_code text,
    timing_delta integer,
    "time" time with time zone,
    date date,
    timing_period text,
    stop_sequence integer
);


ALTER TABLE public.myway_timingdeltas OWNER TO postgres;

--
-- TOC entry 2422 (class 1259 OID 19320)
-- Dependencies: 6 2421
-- Name: myway_timingdeltas_timing_period_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE myway_timingdeltas_timing_period_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.myway_timingdeltas_timing_period_seq OWNER TO postgres;

--
-- TOC entry 2777 (class 0 OID 0)
-- Dependencies: 2422
-- Name: myway_timingdeltas_timing_period_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE myway_timingdeltas_timing_period_seq OWNED BY myway_timingdeltas.timing_period;


--
-- TOC entry 2423 (class 1259 OID 19322)
-- Dependencies: 6
-- Name: routes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE routes (
    route_type integer,
    route_id integer NOT NULL,
    route_short_name text,
    route_long_name text,
    agency_id integer,
    route_url text,
    route_color text,
    route_text_color text
);


ALTER TABLE public.routes OWNER TO postgres;

--
-- TOC entry 2424 (class 1259 OID 19328)
-- Dependencies: 6
-- Name: servicealerts_alerts; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE servicealerts_alerts (
    id integer NOT NULL,
    url text,
    description text,
    start timestamp with time zone,
    "end" timestamp with time zone
);


ALTER TABLE public.servicealerts_alerts OWNER TO postgres;

--
-- TOC entry 2425 (class 1259 OID 19334)
-- Dependencies: 6 2424
-- Name: servicealerts_alerts_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE servicealerts_alerts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.servicealerts_alerts_id_seq OWNER TO postgres;

--
-- TOC entry 2778 (class 0 OID 0)
-- Dependencies: 2425
-- Name: servicealerts_alerts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE servicealerts_alerts_id_seq OWNED BY servicealerts_alerts.id;


--
-- TOC entry 2426 (class 1259 OID 19336)
-- Dependencies: 6
-- Name: servicealerts_informed; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE servicealerts_informed (
    servicealert_id integer NOT NULL,
    informed_class text NOT NULL,
    informed_id text NOT NULL,
    informed_action text
);


ALTER TABLE public.servicealerts_informed OWNER TO postgres;

--
-- TOC entry 2427 (class 1259 OID 19342)
-- Dependencies: 6
-- Name: shapes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE shapes (
    shape_id text NOT NULL,
    shape_pt_lat double precision,
    shape_pt_lon double precision,
    shape_pt_sequence integer NOT NULL,
    shape_dist_traveled integer
);


ALTER TABLE public.shapes OWNER TO postgres;

--
-- TOC entry 2428 (class 1259 OID 19348)
-- Dependencies: 6
-- Name: spatial_ref_sys; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE spatial_ref_sys (
    srid integer NOT NULL,
    auth_name character varying(256),
    auth_srid integer,
    srtext character varying(2048),
    proj4text character varying(2048)
);


ALTER TABLE public.spatial_ref_sys OWNER TO postgres;

--
-- TOC entry 2431 (class 1259 OID 20682)
-- Dependencies: 6
-- Name: stop_times; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE stop_times (
    trip_id integer NOT NULL,
    arrival_time time without time zone,
    departure_time time without time zone,
    stop_id integer,
    stop_sequence integer NOT NULL,
    stop_headsign text,
    pickup_type text,
    drop_off_type text,
    shape_dist_travelled text
);


ALTER TABLE public.stop_times OWNER TO postgres;

--
-- TOC entry 2429 (class 1259 OID 19360)
-- Dependencies: 6 1099
-- Name: stops; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE stops (
    stop_lat double precision,
    stop_code text,
    stop_lon double precision,
    stop_id integer NOT NULL,
    stop_name text,
    zone_id text,
    "position" geography
);


ALTER TABLE public.stops OWNER TO postgres;

--
-- TOC entry 2430 (class 1259 OID 19366)
-- Dependencies: 6
-- Name: trips; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE trips (
    route_id integer,
    trip_id integer NOT NULL,
    trip_headsign text,
    service_id text,
    shape_id text
);


ALTER TABLE public.trips OWNER TO postgres;

--
-- TOC entry 2729 (class 2604 OID 19372)
-- Dependencies: 2425 2424
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE servicealerts_alerts ALTER COLUMN id SET DEFAULT nextval('servicealerts_alerts_id_seq'::regclass);


--
-- TOC entry 2731 (class 2606 OID 19374)
-- Dependencies: 2411 2411
-- Name: agency_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY agency
    ADD CONSTRAINT agency_pkey PRIMARY KEY (agency_id);


--
-- TOC entry 2735 (class 2606 OID 19376)
-- Dependencies: 2413 2413 2413
-- Name: calendar_dates_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY calendar_dates
    ADD CONSTRAINT calendar_dates_pkey PRIMARY KEY (service_id, date);


--
-- TOC entry 2733 (class 2606 OID 19378)
-- Dependencies: 2412 2412
-- Name: calendar_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY calendar
    ADD CONSTRAINT calendar_pkey PRIMARY KEY (service_id);


--
-- TOC entry 2737 (class 2606 OID 19380)
-- Dependencies: 2415 2415 2415 2415 2415
-- Name: geometry_columns_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY geometry_columns
    ADD CONSTRAINT geometry_columns_pk PRIMARY KEY (f_table_catalog, f_table_schema, f_table_name, f_geometry_column);


--
-- TOC entry 2739 (class 2606 OID 19382)
-- Dependencies: 2416 2416
-- Name: myway_observations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY myway_observations
    ADD CONSTRAINT myway_observations_pkey PRIMARY KEY (observation_id);


--
-- TOC entry 2741 (class 2606 OID 19384)
-- Dependencies: 2417 2417
-- Name: myway_routes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY myway_routes
    ADD CONSTRAINT myway_routes_pkey PRIMARY KEY (myway_route);


--
-- TOC entry 2745 (class 2606 OID 19386)
-- Dependencies: 2421 2421
-- Name: myway_timingdeltas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY myway_timingdeltas
    ADD CONSTRAINT myway_timingdeltas_pkey PRIMARY KEY (observation_id);


--
-- TOC entry 2743 (class 2606 OID 19388)
-- Dependencies: 2420 2420
-- Name: mywaystops_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY myway_stops
    ADD CONSTRAINT mywaystops_pkey PRIMARY KEY (myway_stop);


--
-- TOC entry 2748 (class 2606 OID 19390)
-- Dependencies: 2423 2423
-- Name: routes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY routes
    ADD CONSTRAINT routes_pkey PRIMARY KEY (route_id);


--
-- TOC entry 2750 (class 2606 OID 19392)
-- Dependencies: 2424 2424
-- Name: servicealerts_alerts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY servicealerts_alerts
    ADD CONSTRAINT servicealerts_alerts_pkey PRIMARY KEY (id);


--
-- TOC entry 2752 (class 2606 OID 19394)
-- Dependencies: 2426 2426 2426 2426
-- Name: servicealerts_informed_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY servicealerts_informed
    ADD CONSTRAINT servicealerts_informed_pkey PRIMARY KEY (servicealert_id, informed_class, informed_id);


--
-- TOC entry 2754 (class 2606 OID 19396)
-- Dependencies: 2427 2427 2427
-- Name: shapes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY shapes
    ADD CONSTRAINT shapes_pkey PRIMARY KEY (shape_id, shape_pt_sequence);


--
-- TOC entry 2756 (class 2606 OID 19398)
-- Dependencies: 2428 2428
-- Name: spatial_ref_sys_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY spatial_ref_sys
    ADD CONSTRAINT spatial_ref_sys_pkey PRIMARY KEY (srid);


--
-- TOC entry 2766 (class 2606 OID 20689)
-- Dependencies: 2431 2431 2431
-- Name: stop_times_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY stop_times
    ADD CONSTRAINT stop_times_pkey PRIMARY KEY (trip_id, stop_sequence);


--
-- TOC entry 2758 (class 2606 OID 19402)
-- Dependencies: 2429 2429
-- Name: stops_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY stops
    ADD CONSTRAINT stops_pkey PRIMARY KEY (stop_id);


--
-- TOC entry 2760 (class 2606 OID 19404)
-- Dependencies: 2429 2429
-- Name: stops_stop_code_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY stops
    ADD CONSTRAINT stops_stop_code_key UNIQUE (stop_code);


--
-- TOC entry 2763 (class 2606 OID 19406)
-- Dependencies: 2430 2430
-- Name: trips_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY trips
    ADD CONSTRAINT trips_pkey PRIMARY KEY (trip_id);


--
-- TOC entry 2746 (class 1259 OID 19407)
-- Dependencies: 2423
-- Name: routenumber; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX routenumber ON routes USING btree (route_short_name);


--
-- TOC entry 2761 (class 1259 OID 19408)
-- Dependencies: 2430
-- Name: routetrips; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX routetrips ON trips USING btree (route_id);


--
-- TOC entry 2764 (class 1259 OID 20690)
-- Dependencies: 2431 2431 2431
-- Name: starttime; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX starttime ON stop_times USING btree (trip_id, stop_id, stop_sequence);


--
-- TOC entry 2767 (class 1259 OID 20691)
-- Dependencies: 2431 2431
-- Name: stoptimes; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX stoptimes ON stop_times USING btree (arrival_time, stop_id);


--
-- TOC entry 2768 (class 1259 OID 20692)
-- Dependencies: 2431 2431
-- Name: triptimes; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX triptimes ON stop_times USING btree (trip_id, arrival_time);


--
-- TOC entry 2769 (class 2606 OID 19412)
-- Dependencies: 2426 2749 2424
-- Name: servicealerts_alertid; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY servicealerts_informed
    ADD CONSTRAINT servicealerts_alertid FOREIGN KEY (servicealert_id) REFERENCES servicealerts_alerts(id);


--
-- TOC entry 2774 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2011-10-07 22:30:11

--
-- PostgreSQL database dump complete
--

