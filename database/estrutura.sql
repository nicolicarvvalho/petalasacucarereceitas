--
-- PostgreSQL database dump
--

\restrict uiWdon1QMre1xIdlmQbbp52BKXwql8qhFwFuKRuDobuC73M7jPHsDKyDuLxyJ8l

-- Dumped from database version 18.6 (Ubuntu 18.6-0ubuntu0.26.04.1)
-- Dumped by pg_dump version 18.6 (Ubuntu 18.6-0ubuntu0.26.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
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
-- Name: receitas; Type: TABLE; Schema: public; Owner: administrador
--

CREATE TABLE public.receitas (
    id integer NOT NULL,
    usuario_id integer NOT NULL,
    categoria character varying(20) NOT NULL,
    nome character varying(150) NOT NULL,
    ingredientes text NOT NULL,
    modo_preparo text NOT NULL,
    tempo_preparo character varying(50),
    diiculdade character varying(50),
    imagem text
);


ALTER TABLE public.receitas OWNER TO administrador;

--
-- Name: receitas_id_seq; Type: SEQUENCE; Schema: public; Owner: administrador
--

CREATE SEQUENCE public.receitas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.receitas_id_seq OWNER TO administrador;

--
-- Name: receitas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: administrador
--

ALTER SEQUENCE public.receitas_id_seq OWNED BY public.receitas.id;


--
-- Name: usuarios; Type: TABLE; Schema: public; Owner: administrador
--

CREATE TABLE public.usuarios (
    id integer NOT NULL,
    email character varying(100) NOT NULL,
    senha character varying(255) NOT NULL,
    fotoperfil text
);


ALTER TABLE public.usuarios OWNER TO administrador;

--
-- Name: usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: administrador
--

CREATE SEQUENCE public.usuarios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usuarios_id_seq OWNER TO administrador;

--
-- Name: usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: administrador
--

ALTER SEQUENCE public.usuarios_id_seq OWNED BY public.usuarios.id;


--
-- Name: receitas id; Type: DEFAULT; Schema: public; Owner: administrador
--

ALTER TABLE ONLY public.receitas ALTER COLUMN id SET DEFAULT nextval('public.receitas_id_seq'::regclass);


--
-- Name: usuarios id; Type: DEFAULT; Schema: public; Owner: administrador
--

ALTER TABLE ONLY public.usuarios ALTER COLUMN id SET DEFAULT nextval('public.usuarios_id_seq'::regclass);


--
-- Name: receitas receitas_pkey; Type: CONSTRAINT; Schema: public; Owner: administrador
--

ALTER TABLE ONLY public.receitas
    ADD CONSTRAINT receitas_pkey PRIMARY KEY (id);


--
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: administrador
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

\unrestrict uiWdon1QMre1xIdlmQbbp52BKXwql8qhFwFuKRuDobuC73M7jPHsDKyDuLxyJ8l

