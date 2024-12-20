--
-- PostgreSQL database dump
--

-- Dumped from database version 16.2
-- Dumped by pg_dump version 16.2

-- Started on 2024-12-20 15:25:00

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 216 (class 1259 OID 33221)
-- Name: projects; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.projects (
    project_id integer NOT NULL,
    project_name character varying(255) NOT NULL,
    project_description text,
    project_image character varying(255)
);


ALTER TABLE public.projects OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 33220)
-- Name: projects_project_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.projects_project_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.projects_project_id_seq OWNER TO postgres;

--
-- TOC entry 4787 (class 0 OID 0)
-- Dependencies: 215
-- Name: projects_project_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.projects_project_id_seq OWNED BY public.projects.project_id;


--
-- TOC entry 4634 (class 2604 OID 33224)
-- Name: projects project_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.projects ALTER COLUMN project_id SET DEFAULT nextval('public.projects_project_id_seq'::regclass);


--
-- TOC entry 4781 (class 0 OID 33221)
-- Dependencies: 216
-- Data for Name: projects; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.projects (project_id, project_name, project_description, project_image) FROM stdin;
1	project1	this_is project1	C:\\other\\img_test_itco\\project1.png
2	project2	this_is project2	C:\\other\\img_test_itco\\project2.png
107	djjjdjfj	fdsifndsinfi sdifsdifhidshfidf	
85	ddd	fefwref	
95	ffdsfdf rrr	fffffffffff	
94	ffdsfdf rr	fffffffffff ss	
108	new1	dfsfa fdsafd afaefaf	
77	smallhouse	my dmallhouse is really small and beautiful yes	
92	ffdsfdf	fffffffffff	
93	ffdsfdf r	fffffffffff	
106	vbfghvythvyhtj	vnhfnv hvyvnyt trvyvn yvthyrthv	
3	new_name	new_description 2e	new_img
70	5 ggrewr	htyrjhb yeug6u5u6e	
\.


--
-- TOC entry 4788 (class 0 OID 0)
-- Dependencies: 215
-- Name: projects_project_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.projects_project_id_seq', 108, true);


--
-- TOC entry 4636 (class 2606 OID 33228)
-- Name: projects projects_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.projects
    ADD CONSTRAINT projects_pkey PRIMARY KEY (project_id);


-- Completed on 2024-12-20 15:25:00

--
-- PostgreSQL database dump complete
--

