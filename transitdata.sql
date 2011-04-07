--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: trips; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE trips (
    route_id integer,
    trip_id integer NOT NULL,
    trip_headsign text,
    service_id text
);


ALTER TABLE public.trips OWNER TO postgres;

--
-- Data for Name: trips; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY trips (route_id, trip_id, trip_headsign, service_id) FROM stdin;
\.


--
-- Name: trips_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY trips
    ADD CONSTRAINT trips_pkey PRIMARY KEY (trip_id);


--
-- Name: routetrips; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX routetrips ON trips USING btree (route_id);


--
-- PostgreSQL database dump complete
--

