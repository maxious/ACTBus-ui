--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.2
-- Dumped by pg_dump version 9.1.2
-- Started on 2012-06-16 23:42:05

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 3208 (class 1262 OID 16400)
-- Name: transitdata; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE transitdata WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'English_Australia.1252' LC_CTYPE = 'English_Australia.1252';


ALTER DATABASE transitdata OWNER TO postgres;

\connect transitdata

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 6 (class 2615 OID 21883)
-- Name: topology; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA topology;


ALTER SCHEMA topology OWNER TO postgres;

--
-- TOC entry 200 (class 3079 OID 11639)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 3211 (class 0 OID 0)
-- Dependencies: 200
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- TOC entry 202 (class 3079 OID 45302)
-- Dependencies: 7
-- Name: pg_trgm; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS pg_trgm WITH SCHEMA public;


--
-- TOC entry 3212 (class 0 OID 0)
-- Dependencies: 202
-- Name: EXTENSION pg_trgm; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pg_trgm IS 'text similarity measurement and index searching based on trigrams';


--
-- TOC entry 203 (class 3079 OID 20800)
-- Dependencies: 7
-- Name: postgis; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS postgis WITH SCHEMA public;


--
-- TOC entry 3213 (class 0 OID 0)
-- Dependencies: 203
-- Name: EXTENSION postgis; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION postgis IS 'postgis geometry,geography, and raster spatial types and functions';


--
-- TOC entry 201 (class 3079 OID 21884)
-- Dependencies: 6 203
-- Name: postgis_topology; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS postgis_topology WITH SCHEMA topology;


--
-- TOC entry 3214 (class 0 OID 0)
-- Dependencies: 201
-- Name: EXTENSION postgis_topology; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION postgis_topology IS 'postgis topology spatial types and functions';


SET search_path = public, pg_catalog;

--
-- TOC entry 1157 (class 1255 OID 27559)
-- Dependencies: 7 1534
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
-- TOC entry 1158 (class 1255 OID 27560)
-- Dependencies: 7 1534
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
-- TOC entry 1159 (class 1255 OID 27561)
-- Dependencies: 7 1534
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
-- TOC entry 1160 (class 1255 OID 27562)
-- Dependencies: 1534 7
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
-- TOC entry 1161 (class 1255 OID 27564)
-- Dependencies: 1534 7
-- Name: linestringfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION linestringfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT LineFromText($1)$_$;


ALTER FUNCTION public.linestringfromtext(text) OWNER TO postgres;

--
-- TOC entry 1162 (class 1255 OID 27565)
-- Dependencies: 7 1534
-- Name: linestringfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION linestringfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT LineFromText($1, $2)$_$;


ALTER FUNCTION public.linestringfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 1163 (class 1255 OID 27566)
-- Dependencies: 1534 7
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
-- TOC entry 1164 (class 1255 OID 27567)
-- Dependencies: 1534 7
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
-- TOC entry 1165 (class 1255 OID 27590)
-- Dependencies: 7 1534
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
-- TOC entry 1166 (class 1255 OID 27591)
-- Dependencies: 7 1534
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
-- TOC entry 1167 (class 1255 OID 27592)
-- Dependencies: 1534 7
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
-- TOC entry 1168 (class 1255 OID 27593)
-- Dependencies: 7 1534
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
-- TOC entry 1169 (class 1255 OID 27594)
-- Dependencies: 7 1534
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
-- TOC entry 1170 (class 1255 OID 27595)
-- Dependencies: 1534 7
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
-- TOC entry 1171 (class 1255 OID 27596)
-- Dependencies: 7 1534
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
-- TOC entry 1172 (class 1255 OID 27597)
-- Dependencies: 1534 7
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
-- TOC entry 1173 (class 1255 OID 27598)
-- Dependencies: 7 1534
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
-- TOC entry 1174 (class 1255 OID 27599)
-- Dependencies: 1534 7
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
-- TOC entry 1175 (class 1255 OID 27601)
-- Dependencies: 1534 7
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
-- TOC entry 1176 (class 1255 OID 27603)
-- Dependencies: 1534 7
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
-- TOC entry 1177 (class 1255 OID 27604)
-- Dependencies: 1534 7
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
-- TOC entry 1178 (class 1255 OID 27605)
-- Dependencies: 7 1534
-- Name: multilinestringfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION multilinestringfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT ST_MLineFromText($1)$_$;


ALTER FUNCTION public.multilinestringfromtext(text) OWNER TO postgres;

--
-- TOC entry 1179 (class 1255 OID 27606)
-- Dependencies: 7 1534
-- Name: multilinestringfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION multilinestringfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT MLineFromText($1, $2)$_$;


ALTER FUNCTION public.multilinestringfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 1180 (class 1255 OID 27607)
-- Dependencies: 1534 7
-- Name: multipointfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION multipointfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT MPointFromText($1)$_$;


ALTER FUNCTION public.multipointfromtext(text) OWNER TO postgres;

--
-- TOC entry 1181 (class 1255 OID 27608)
-- Dependencies: 1534 7
-- Name: multipointfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION multipointfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT MPointFromText($1, $2)$_$;


ALTER FUNCTION public.multipointfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 1182 (class 1255 OID 27609)
-- Dependencies: 7 1534
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
-- TOC entry 1183 (class 1255 OID 27610)
-- Dependencies: 7 1534
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
-- TOC entry 1184 (class 1255 OID 27611)
-- Dependencies: 7 1534
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
-- TOC entry 1185 (class 1255 OID 27612)
-- Dependencies: 1534 7
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
-- TOC entry 1186 (class 1255 OID 27613)
-- Dependencies: 7 1534
-- Name: multipolygonfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION multipolygonfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT MPolyFromText($1)$_$;


ALTER FUNCTION public.multipolygonfromtext(text) OWNER TO postgres;

--
-- TOC entry 1187 (class 1255 OID 27614)
-- Dependencies: 7 1534
-- Name: multipolygonfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION multipolygonfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT MPolyFromText($1, $2)$_$;


ALTER FUNCTION public.multipolygonfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 1188 (class 1255 OID 27628)
-- Dependencies: 1534 7
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
-- TOC entry 1189 (class 1255 OID 27629)
-- Dependencies: 7 1534
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
-- TOC entry 1190 (class 1255 OID 27630)
-- Dependencies: 7 1534
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
-- TOC entry 1191 (class 1255 OID 27631)
-- Dependencies: 1534 7
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
-- TOC entry 1192 (class 1255 OID 27634)
-- Dependencies: 7 1534
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
-- TOC entry 1193 (class 1255 OID 27635)
-- Dependencies: 1534 7
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
-- TOC entry 1194 (class 1255 OID 27636)
-- Dependencies: 7 1534
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
-- TOC entry 1195 (class 1255 OID 27637)
-- Dependencies: 7 1534
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
-- TOC entry 1196 (class 1255 OID 27638)
-- Dependencies: 7 1534
-- Name: polygonfromtext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION polygonfromtext(text) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT PolyFromText($1)$_$;


ALTER FUNCTION public.polygonfromtext(text) OWNER TO postgres;

--
-- TOC entry 1197 (class 1255 OID 27639)
-- Dependencies: 1534 7
-- Name: polygonfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION polygonfromtext(text, integer) RETURNS geometry
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT PolyFromText($1, $2)$_$;


ALTER FUNCTION public.polygonfromtext(text, integer) OWNER TO postgres;

--
-- TOC entry 1198 (class 1255 OID 27640)
-- Dependencies: 1534 7
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
-- TOC entry 1199 (class 1255 OID 27641)
-- Dependencies: 1534 7
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
-- TOC entry 1219 (class 1255 OID 27701)
-- Dependencies: 1534 7
-- Name: st_askml(integer, geometry); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_askml(integer, geometry) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsKML($1, ST_Transform($2,4326), 15)$_$;


ALTER FUNCTION public.st_askml(integer, geometry) OWNER TO postgres;

--
-- TOC entry 1220 (class 1255 OID 27702)
-- Dependencies: 1568 7
-- Name: st_askml(integer, geography); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_askml(integer, geography) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT _ST_AsKML($1, $2, 15)$_$;


ALTER FUNCTION public.st_askml(integer, geography) OWNER TO postgres;

--
-- TOC entry 1720 (class 1255 OID 27805)
-- Dependencies: 7 457 1534 1534
-- Name: memcollect(geometry); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE memcollect(geometry) (
    SFUNC = public.st_collect,
    STYPE = geometry
);


ALTER AGGREGATE public.memcollect(geometry) OWNER TO postgres;

--
-- TOC entry 1721 (class 1255 OID 27807)
-- Dependencies: 456 7 1538 1534
-- Name: st_extent3d(geometry); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE st_extent3d(geometry) (
    SFUNC = public.st_combine_bbox,
    STYPE = box3d
);


ALTER AGGREGATE public.st_extent3d(geometry) OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 182 (class 1259 OID 27809)
-- Dependencies: 7
-- Name: agency; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE agency (
    agency_name text NOT NULL,
    agency_url text,
    agency_timezone text,
    agency_lang text,
    agency_phone text,
    agency_fare_url text,
    agency_id integer
);


ALTER TABLE public.agency OWNER TO postgres;

--
-- TOC entry 183 (class 1259 OID 27815)
-- Dependencies: 7
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
-- TOC entry 184 (class 1259 OID 27821)
-- Dependencies: 7
-- Name: calendar_dates; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE calendar_dates (
    service_id text NOT NULL,
    date text NOT NULL,
    exception_type text
);


ALTER TABLE public.calendar_dates OWNER TO postgres;

--
-- TOC entry 185 (class 1259 OID 27827)
-- Dependencies: 7
-- Name: fare_attributes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE fare_attributes (
    fare_id text NOT NULL,
    price double precision,
    currency_type text,
    payment_method integer,
    transfers text,
    transfer_duration integer
);


ALTER TABLE public.fare_attributes OWNER TO postgres;

--
-- TOC entry 186 (class 1259 OID 27833)
-- Dependencies: 7
-- Name: feed_info; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE feed_info (
    feed_publisher_name text NOT NULL,
    feed_publisher_url text,
    feed_lang text,
    feed_start_date text,
    feed_end_date text,
    feed_version text
);


ALTER TABLE public.feed_info OWNER TO postgres;

--
-- TOC entry 187 (class 1259 OID 27839)
-- Dependencies: 7
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
-- TOC entry 188 (class 1259 OID 27845)
-- Dependencies: 7
-- Name: myway_routes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE myway_routes (
    myway_route text NOT NULL,
    route_short_name text,
    trip_headsign text
);


ALTER TABLE public.myway_routes OWNER TO postgres;

--
-- TOC entry 189 (class 1259 OID 27851)
-- Dependencies: 7
-- Name: myway_stops; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE myway_stops (
    myway_stop text NOT NULL,
    stop_id text
);


ALTER TABLE public.myway_stops OWNER TO postgres;

--
-- TOC entry 190 (class 1259 OID 27857)
-- Dependencies: 7
-- Name: myway_timingdeltas; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE myway_timingdeltas (
    observation_id text NOT NULL,
    route_id text,
    stop_id text,
    timing_delta integer,
    "time" time with time zone,
    date date,
    timing_period text,
    stop_sequence integer,
    myway_stop text,
    route_name text
);


ALTER TABLE public.myway_timingdeltas OWNER TO postgres;

--
-- TOC entry 191 (class 1259 OID 27863)
-- Dependencies: 7 190
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
-- TOC entry 3216 (class 0 OID 0)
-- Dependencies: 191
-- Name: myway_timingdeltas_timing_period_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE myway_timingdeltas_timing_period_seq OWNED BY myway_timingdeltas.timing_period;


--
-- TOC entry 192 (class 1259 OID 27865)
-- Dependencies: 7
-- Name: routes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE routes (
    route_id text NOT NULL,
    route_short_name text,
    route_long_name text,
    route_desc text,
    route_type integer,
    route_url text,
    route_text_color text,
    route_color text,
    agency_id text
);


ALTER TABLE public.routes OWNER TO postgres;

--
-- TOC entry 193 (class 1259 OID 27871)
-- Dependencies: 7
-- Name: servicealerts_alerts; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE servicealerts_alerts (
    id integer NOT NULL,
    url text,
    description text,
    start timestamp with time zone,
    "end" timestamp with time zone,
    cause text,
    effect text,
    header text
);


ALTER TABLE public.servicealerts_alerts OWNER TO postgres;

--
-- TOC entry 194 (class 1259 OID 27877)
-- Dependencies: 193 7
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
-- TOC entry 3217 (class 0 OID 0)
-- Dependencies: 194
-- Name: servicealerts_alerts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE servicealerts_alerts_id_seq OWNED BY servicealerts_alerts.id;


--
-- TOC entry 195 (class 1259 OID 27879)
-- Dependencies: 7
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
-- TOC entry 196 (class 1259 OID 27885)
-- Dependencies: 7 1568
-- Name: shapes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE shapes (
    shape_id text NOT NULL,
    shape_pt_lat double precision,
    shape_pt_lon double precision,
    shape_pt_sequence integer NOT NULL,
    shape_dist_traveled integer,
    shape_pt geography
);


ALTER TABLE public.shapes OWNER TO postgres;

--
-- TOC entry 197 (class 1259 OID 27891)
-- Dependencies: 7
-- Name: stop_times; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE stop_times (
    trip_id text NOT NULL,
    arrival_time time without time zone,
    departure_time time without time zone,
    stop_id text,
    stop_sequence integer NOT NULL,
    stop_headsign text,
    pickup_type text,
    drop_off_type text,
    shape_dist_traveled text
);


ALTER TABLE public.stop_times OWNER TO postgres;

--
-- TOC entry 199 (class 1259 OID 36977)
-- Dependencies: 1568 7
-- Name: stops; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE stops (
    stop_id text NOT NULL,
    stop_code text,
    stop_name text,
    stop_desc text,
    stop_lat double precision,
    stop_lon double precision,
    zone_id text,
    stop_url text,
    location_type integer,
    "position" geography
);


ALTER TABLE public.stops OWNER TO postgres;

--
-- TOC entry 198 (class 1259 OID 27903)
-- Dependencies: 7
-- Name: trips; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE trips (
    route_id text,
    service_id text,
    trip_id text NOT NULL,
    trip_headsign text,
    direction_id text,
    block_id text,
    shape_id text,
    wheelchair_accessible text
);


ALTER TABLE public.trips OWNER TO postgres;

--
-- TOC entry 3165 (class 2604 OID 27909)
-- Dependencies: 194 193
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE servicealerts_alerts ALTER COLUMN id SET DEFAULT nextval('servicealerts_alerts_id_seq'::regclass);


--
-- TOC entry 3167 (class 2606 OID 27931)
-- Dependencies: 182 182
-- Name: agency_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY agency
    ADD CONSTRAINT agency_pkey PRIMARY KEY (agency_name);


--
-- TOC entry 3171 (class 2606 OID 27933)
-- Dependencies: 184 184 184
-- Name: calendar_dates_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY calendar_dates
    ADD CONSTRAINT calendar_dates_pkey PRIMARY KEY (service_id, date);


--
-- TOC entry 3169 (class 2606 OID 27935)
-- Dependencies: 183 183
-- Name: calendar_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY calendar
    ADD CONSTRAINT calendar_pkey PRIMARY KEY (service_id);


--
-- TOC entry 3173 (class 2606 OID 27937)
-- Dependencies: 185 185
-- Name: fare_attributes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY fare_attributes
    ADD CONSTRAINT fare_attributes_pkey PRIMARY KEY (fare_id);


--
-- TOC entry 3175 (class 2606 OID 27939)
-- Dependencies: 186 186
-- Name: feed_info_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY feed_info
    ADD CONSTRAINT feed_info_pkey PRIMARY KEY (feed_publisher_name);


--
-- TOC entry 3177 (class 2606 OID 27941)
-- Dependencies: 187 187
-- Name: myway_observations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY myway_observations
    ADD CONSTRAINT myway_observations_pkey PRIMARY KEY (observation_id);


--
-- TOC entry 3179 (class 2606 OID 27943)
-- Dependencies: 188 188
-- Name: myway_routes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY myway_routes
    ADD CONSTRAINT myway_routes_pkey PRIMARY KEY (myway_route);


--
-- TOC entry 3183 (class 2606 OID 27945)
-- Dependencies: 190 190
-- Name: myway_timingdeltas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY myway_timingdeltas
    ADD CONSTRAINT myway_timingdeltas_pkey PRIMARY KEY (observation_id);


--
-- TOC entry 3181 (class 2606 OID 27947)
-- Dependencies: 189 189
-- Name: mywaystops_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY myway_stops
    ADD CONSTRAINT mywaystops_pkey PRIMARY KEY (myway_stop);


--
-- TOC entry 3185 (class 2606 OID 27949)
-- Dependencies: 192 192
-- Name: routes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY routes
    ADD CONSTRAINT routes_pkey PRIMARY KEY (route_id);


--
-- TOC entry 3187 (class 2606 OID 27951)
-- Dependencies: 193 193
-- Name: servicealerts_alerts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY servicealerts_alerts
    ADD CONSTRAINT servicealerts_alerts_pkey PRIMARY KEY (id);


--
-- TOC entry 3189 (class 2606 OID 27953)
-- Dependencies: 195 195 195 195
-- Name: servicealerts_informed_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY servicealerts_informed
    ADD CONSTRAINT servicealerts_informed_pkey PRIMARY KEY (servicealert_id, informed_class, informed_id);


--
-- TOC entry 3191 (class 2606 OID 27955)
-- Dependencies: 196 196 196
-- Name: shapes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY shapes
    ADD CONSTRAINT shapes_pkey PRIMARY KEY (shape_id, shape_pt_sequence);


--
-- TOC entry 3194 (class 2606 OID 27959)
-- Dependencies: 197 197 197
-- Name: stop_times_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY stop_times
    ADD CONSTRAINT stop_times_pkey PRIMARY KEY (trip_id, stop_sequence);


--
-- TOC entry 3203 (class 2606 OID 36984)
-- Dependencies: 199 199
-- Name: stops_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY stops
    ADD CONSTRAINT stops_pkey PRIMARY KEY (stop_id);


--
-- TOC entry 3200 (class 2606 OID 27974)
-- Dependencies: 198 198
-- Name: trips_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY trips
    ADD CONSTRAINT trips_pkey PRIMARY KEY (trip_id);


--
-- TOC entry 3198 (class 1259 OID 27976)
-- Dependencies: 198
-- Name: routetrips; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX routetrips ON trips USING btree (route_id);


--
-- TOC entry 3192 (class 1259 OID 27977)
-- Dependencies: 197 197 197
-- Name: starttime; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX starttime ON stop_times USING btree (trip_id, stop_id, stop_sequence);


--
-- TOC entry 3201 (class 1259 OID 45349)
-- Dependencies: 2586 199
-- Name: stop_name_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX stop_name_idx ON stops USING gist (stop_name gist_trgm_ops);


--
-- TOC entry 3204 (class 1259 OID 36987)
-- Dependencies: 199 2584
-- Name: stops_position_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX stops_position_idx ON stops USING gist ("position");


--
-- TOC entry 3195 (class 1259 OID 27986)
-- Dependencies: 197 197
-- Name: stoptimes; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX stoptimes ON stop_times USING btree (arrival_time, stop_id);


--
-- TOC entry 3196 (class 1259 OID 36921)
-- Dependencies: 197
-- Name: times; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX times ON stop_times USING btree (arrival_time);


--
-- TOC entry 3197 (class 1259 OID 27987)
-- Dependencies: 197 197
-- Name: triptimes; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX triptimes ON stop_times USING btree (trip_id, arrival_time);


--
-- TOC entry 3205 (class 2606 OID 27990)
-- Dependencies: 193 195 3186
-- Name: servicealerts_alertid; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY servicealerts_informed
    ADD CONSTRAINT servicealerts_alertid FOREIGN KEY (servicealert_id) REFERENCES servicealerts_alerts(id);


--
-- TOC entry 3210 (class 0 OID 0)
-- Dependencies: 7
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- TOC entry 3215 (class 0 OID 0)
-- Dependencies: 187
-- Name: myway_observations; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE myway_observations FROM PUBLIC;
REVOKE ALL ON TABLE myway_observations FROM postgres;
GRANT ALL ON TABLE myway_observations TO postgres;


--
-- TOC entry 3218 (class 0 OID 0)
-- Dependencies: 199
-- Name: stops; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE stops FROM PUBLIC;
REVOKE ALL ON TABLE stops FROM postgres;
GRANT ALL ON TABLE stops TO postgres;
GRANT SELECT ON TABLE stops TO transitdata;


-- Completed on 2012-06-16 23:42:05

--
-- PostgreSQL database dump complete
--

