--
-- PostgreSQL database dump
--

SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: svcart_advertisement_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_advertisement_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    advertisement_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    description text,
    url character varying(200) DEFAULT ''::character varying NOT NULL,
    start_time timestamp without time zone DEFAULT now() NOT NULL,
    end_time timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    code text,
    img01 character varying(200) DEFAULT ''::character varying NOT NULL,
    img02 character varying(200) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_advertisement_i18ns OWNER TO seevia;

--
-- Name: svcart_advertisement_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_advertisement_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_advertisement_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_advertisement_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_advertisement_i18ns_id_seq OWNED BY svcart_advertisement_i18ns.id;


--
-- Name: svcart_advertisements; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_advertisements (
    id integer NOT NULL,
    store_id integer DEFAULT 0 NOT NULL,
    media_type smallint DEFAULT 0 NOT NULL,
    ad_width integer DEFAULT 0 NOT NULL,
    ad_height integer DEFAULT 0 NOT NULL,
    contact_name character varying(20) DEFAULT ''::character varying NOT NULL,
    contact_email character varying(200) DEFAULT ''::character varying NOT NULL,
    contact_tele character varying(20) DEFAULT ''::character varying NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    is_showimg character(1) DEFAULT '0'::bpchar NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    click_count integer DEFAULT 0 NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_advertisements OWNER TO seevia;

--
-- Name: svcart_advertisements_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_advertisements_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_advertisements_id_seq OWNER TO seevia;

--
-- Name: svcart_advertisements_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_advertisements_id_seq OWNED BY svcart_advertisements.id;


--
-- Name: svcart_article_categories; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_article_categories (
    id bigint NOT NULL,
    category_id integer DEFAULT 0 NOT NULL,
    article_id integer DEFAULT 0 NOT NULL,
    orderby smallint DEFAULT 500::numeric NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_article_categories OWNER TO seevia;

--
-- Name: svcart_article_categories_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_article_categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_article_categories_id_seq OWNER TO seevia;

--
-- Name: svcart_article_categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_article_categories_id_seq OWNED BY svcart_article_categories.id;


--
-- Name: svcart_article_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_article_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    article_id integer DEFAULT 0 NOT NULL,
    title character varying(100) DEFAULT ''::character varying NOT NULL,
    meta_keywords text,
    meta_description text,
    content text,
    author character varying(100) DEFAULT ''::character varying NOT NULL,
    img01 character varying(100) DEFAULT NULL::character varying,
    img02 character varying(100) DEFAULT NULL::character varying,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_article_i18ns OWNER TO seevia;

--
-- Name: svcart_article_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_article_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_article_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_article_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_article_i18ns_id_seq OWNED BY svcart_article_i18ns.id;


--
-- Name: svcart_articles; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_articles (
    id integer NOT NULL,
    store_id integer DEFAULT 0 NOT NULL,
    category_id integer DEFAULT 0 NOT NULL,
    author_email character varying(60) DEFAULT ''::character varying NOT NULL,
    type character varying(20) DEFAULT ''::character varying NOT NULL,
    file_url character varying(255) DEFAULT ''::character varying NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    front character(1) DEFAULT '0'::bpchar NOT NULL,
    importance character(1) DEFAULT '0'::bpchar NOT NULL,
    clicked bigint DEFAULT 0 NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_articles OWNER TO seevia;

--
-- Name: svcart_articles_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_articles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_articles_id_seq OWNER TO seevia;

--
-- Name: svcart_articles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_articles_id_seq OWNED BY svcart_articles.id;


--
-- Name: svcart_booking_products; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_booking_products (
    id integer NOT NULL,
    user_id integer DEFAULT 0 NOT NULL,
    email character varying(60) DEFAULT ''::character varying NOT NULL,
    contact_man character varying(60) DEFAULT ''::character varying NOT NULL,
    telephone character varying(60) DEFAULT ''::character varying NOT NULL,
    product_id integer DEFAULT 0 NOT NULL,
    product_desc character varying(255) DEFAULT ''::character varying NOT NULL,
    product_number integer DEFAULT 0 NOT NULL,
    booking_time timestamp without time zone,
    is_dispose character(1) DEFAULT '0'::bpchar NOT NULL,
    dispose_operation_id integer DEFAULT 0 NOT NULL,
    dispose_time timestamp without time zone,
    dispose_note character varying(255) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_booking_products OWNER TO seevia;

--
-- Name: svcart_booking_products_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_booking_products_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_booking_products_id_seq OWNER TO seevia;

--
-- Name: svcart_booking_products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_booking_products_id_seq OWNED BY svcart_booking_products.id;


--
-- Name: svcart_brand_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_brand_i18ns (
    id bigint NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    brand_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    description text,
    meta_keywords text,
    meta_description text,
    img01 character varying(200) DEFAULT NULL::character varying,
    img02 character varying(200) DEFAULT NULL::character varying,
    img03 character varying(200) DEFAULT NULL::character varying,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_brand_i18ns OWNER TO seevia;

--
-- Name: svcart_brand_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_brand_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_brand_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_brand_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_brand_i18ns_id_seq OWNED BY svcart_brand_i18ns.id;


--
-- Name: svcart_brands; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_brands (
    id integer NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    img01 character varying(200) DEFAULT ''::character varying NOT NULL,
    img02 character varying(200) DEFAULT ''::character varying NOT NULL,
    flash_config character varying(100) DEFAULT ''::character varying NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    url character varying(100) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_brands OWNER TO seevia;

--
-- Name: svcart_brands_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_brands_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_brands_id_seq OWNER TO seevia;

--
-- Name: svcart_brands_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_brands_id_seq OWNED BY svcart_brands.id;


--
-- Name: svcart_card_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_card_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    card_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    description text,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_card_i18ns OWNER TO seevia;

--
-- Name: svcart_card_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_card_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_card_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_card_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_card_i18ns_id_seq OWNED BY svcart_card_i18ns.id;


--
-- Name: svcart_cards; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_cards (
    id integer NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    img01 character varying(200) DEFAULT ''::character varying NOT NULL,
    img02 character varying(200) DEFAULT ''::character varying NOT NULL,
    fee numeric(6,2) DEFAULT 0 NOT NULL,
    free_money numeric(6,2) DEFAULT 0 NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_cards OWNER TO seevia;

--
-- Name: svcart_cards_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_cards_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_cards_id_seq OWNER TO seevia;

--
-- Name: svcart_cards_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_cards_id_seq OWNED BY svcart_cards.id;


--
-- Name: svcart_carts; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_carts (
    id bigint NOT NULL,
    session_id character varying(100) DEFAULT ''::character varying NOT NULL,
    user_id integer DEFAULT 0 NOT NULL,
    store_id integer DEFAULT 0 NOT NULL,
    product_id integer DEFAULT 0 NOT NULL,
    product_code character varying(100) DEFAULT ''::character varying NOT NULL,
    product_name character varying(200) DEFAULT ''::character varying NOT NULL,
    product_price double precision DEFAULT 0 NOT NULL,
    product_quantity smallint DEFAULT 0 NOT NULL,
    product_attrbute text,
    type character(1) DEFAULT NULL::bpchar,
    extension_code character varying(20) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_carts OWNER TO seevia;

--
-- Name: svcart_carts_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_carts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_carts_id_seq OWNER TO seevia;

--
-- Name: svcart_carts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_carts_id_seq OWNED BY svcart_carts.id;


--
-- Name: svcart_categories; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_categories (
    id integer NOT NULL,
    parent_id integer DEFAULT 0 NOT NULL,
    type character(1) DEFAULT 'P'::bpchar NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    link character varying(100) DEFAULT ''::character varying NOT NULL,
    img01 character varying(200) DEFAULT ''::character varying NOT NULL,
    img02 character varying(200) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_categories OWNER TO seevia;

--
-- Name: svcart_categories_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_categories_id_seq OWNER TO seevia;

--
-- Name: svcart_categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_categories_id_seq OWNED BY svcart_categories.id;


--
-- Name: svcart_category_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_category_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    category_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    meta_keywords text,
    meta_description text,
    detail text,
    img01 character varying(200) DEFAULT NULL::character varying,
    img02 character varying(200) DEFAULT NULL::character varying,
    img03 character varying(200) DEFAULT NULL::character varying,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_category_i18ns OWNER TO seevia;

--
-- Name: svcart_category_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_category_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_category_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_category_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_category_i18ns_id_seq OWNED BY svcart_category_i18ns.id;


--
-- Name: svcart_comments; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_comments (
    id integer NOT NULL,
    type character(1) DEFAULT ''::bpchar NOT NULL,
    type_id integer DEFAULT 0 NOT NULL,
    email character varying(60) DEFAULT ''::character varying NOT NULL,
    name character varying(200) DEFAULT ''::character varying NOT NULL,
    title character varying(200) DEFAULT ''::character varying NOT NULL,
    parent_id integer DEFAULT 0 NOT NULL,
    status character(1) DEFAULT '0'::bpchar NOT NULL,
    content text,
    rank character(1) DEFAULT '0'::bpchar NOT NULL,
    ipaddr character varying(20) DEFAULT ''::character varying NOT NULL,
    user_id integer DEFAULT 0 NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_comments OWNER TO seevia;

--
-- Name: svcart_comments_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_comments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_comments_id_seq OWNER TO seevia;

--
-- Name: svcart_comments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_comments_id_seq OWNED BY svcart_comments.id;


--
-- Name: svcart_config_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_config_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    config_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    value text,
    options text,
    description text,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_config_i18ns OWNER TO seevia;

--
-- Name: svcart_config_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_config_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_config_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_config_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_config_i18ns_id_seq OWNED BY svcart_config_i18ns.id;


--
-- Name: svcart_configs; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_configs (
    id integer NOT NULL,
    store_id integer DEFAULT 0 NOT NULL,
    group_code character varying(100) DEFAULT ''::character varying NOT NULL,
    code character varying(60) DEFAULT ''::character varying NOT NULL,
    type character varying(10) DEFAULT ''::character varying NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_configs OWNER TO seevia;

--
-- Name: svcart_configs_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_configs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_configs_id_seq OWNER TO seevia;

--
-- Name: svcart_configs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_configs_id_seq OWNED BY svcart_configs.id;


--
-- Name: svcart_coupon_type_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_coupon_type_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    coupon_type_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    description text,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_coupon_type_i18ns OWNER TO seevia;

--
-- Name: svcart_coupon_type_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_coupon_type_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_coupon_type_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_coupon_type_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_coupon_type_i18ns_id_seq OWNED BY svcart_coupon_type_i18ns.id;


--
-- Name: svcart_coupon_types; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_coupon_types (
    id integer NOT NULL,
    money numeric(10,2) DEFAULT 0 NOT NULL,
    send_type smallint DEFAULT 0 NOT NULL,
    prefix character varying(10) DEFAULT ''::character varying NOT NULL,
    min_amount numeric(10,2) DEFAULT 0 NOT NULL,
    max_amount numeric(10,2) DEFAULT 0 NOT NULL,
    min_products_amount numeric(10,2) DEFAULT 0 NOT NULL,
    send_start_date timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    send_end_date timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    use_start_date timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    use_end_date timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_coupon_types OWNER TO seevia;

--
-- Name: svcart_coupon_types_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_coupon_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_coupon_types_id_seq OWNER TO seevia;

--
-- Name: svcart_coupon_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_coupon_types_id_seq OWNED BY svcart_coupon_types.id;


--
-- Name: svcart_coupons; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_coupons (
    id integer NOT NULL,
    coupon_type_id integer DEFAULT 0 NOT NULL,
    sn_code character varying(20) DEFAULT '0'::character varying NOT NULL,
    max_buy_quantity integer DEFAULT 0 NOT NULL,
    max_use_quantity integer DEFAULT 0 NOT NULL,
    order_amount_discount integer DEFAULT 100::numeric NOT NULL,
    user_id integer DEFAULT 0 NOT NULL,
    used_time timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    order_id integer DEFAULT 0 NOT NULL,
    emailed smallint DEFAULT 0 NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_coupons OWNER TO seevia;

--
-- Name: svcart_coupons_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_coupons_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_coupons_id_seq OWNER TO seevia;

--
-- Name: svcart_coupons_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_coupons_id_seq OWNED BY svcart_coupons.id;


--
-- Name: svcart_department_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_department_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    department_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    description text,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_department_i18ns OWNER TO seevia;

--
-- Name: svcart_department_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_department_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_department_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_department_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_department_i18ns_id_seq OWNED BY svcart_department_i18ns.id;


--
-- Name: svcart_departments; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_departments (
    id integer NOT NULL,
    contact_name character varying(20) DEFAULT ''::character varying NOT NULL,
    contact_email character varying(200) DEFAULT ''::character varying NOT NULL,
    contact_tele character varying(20) DEFAULT ''::character varying NOT NULL,
    contact_mobile character varying(20) DEFAULT ''::character varying NOT NULL,
    contact_fax character varying(20) DEFAULT ''::character varying NOT NULL,
    contact_remark text,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_departments OWNER TO seevia;

--
-- Name: svcart_departments_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_departments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_departments_id_seq OWNER TO seevia;

--
-- Name: svcart_departments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_departments_id_seq OWNED BY svcart_departments.id;


--
-- Name: svcart_flash_images; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_flash_images (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    flash_id integer DEFAULT 0 NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    image character varying(200) DEFAULT ''::character varying NOT NULL,
    title character varying(200) DEFAULT ''::character varying NOT NULL,
    description text,
    url character varying(255) DEFAULT ''::character varying NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_flash_images OWNER TO seevia;

--
-- Name: svcart_flash_images_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_flash_images_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_flash_images_id_seq OWNER TO seevia;

--
-- Name: svcart_flash_images_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_flash_images_id_seq OWNED BY svcart_flash_images.id;


--
-- Name: svcart_flashes; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_flashes (
    id integer NOT NULL,
    type character varying(20) DEFAULT ''::character varying NOT NULL,
    type_id integer DEFAULT 0 NOT NULL,
    roundcorner character varying(20) DEFAULT ''::character varying NOT NULL,
    autoplaytime character varying(20) DEFAULT ''::character varying NOT NULL,
    isheightquality character varying(20) DEFAULT ''::character varying NOT NULL,
    blendmode character varying(20) DEFAULT ''::character varying NOT NULL,
    transduration character varying(20) DEFAULT ''::character varying NOT NULL,
    windowopen character varying(20) DEFAULT ''::character varying NOT NULL,
    btnsetmargin character varying(20) DEFAULT ''::character varying NOT NULL,
    btndistance character varying(20) DEFAULT ''::character varying NOT NULL,
    titlebgcolor character varying(20) DEFAULT ''::character varying NOT NULL,
    titletextcolor character varying(20) DEFAULT ''::character varying NOT NULL,
    titlebgalpha character varying(20) DEFAULT ''::character varying NOT NULL,
    titlemoveduration character varying(20) DEFAULT ''::character varying NOT NULL,
    btnalpha character varying(20) DEFAULT ''::character varying NOT NULL,
    btntextcolor character varying(20) DEFAULT ''::character varying NOT NULL,
    btndefaultcolor character varying(20) DEFAULT ''::character varying NOT NULL,
    btnhovercolor character varying(20) DEFAULT ''::character varying NOT NULL,
    btnfocuscolor character varying(20) DEFAULT ''::character varying NOT NULL,
    changimagemode character varying(20) DEFAULT ''::character varying NOT NULL,
    isshowbtn character varying(20) DEFAULT ''::character varying NOT NULL,
    isshowtitle character varying(20) DEFAULT ''::character varying NOT NULL,
    scalemode character varying(20) DEFAULT ''::character varying NOT NULL,
    transform character varying(20) DEFAULT ''::character varying NOT NULL,
    isshowabout character varying(20) DEFAULT ''::character varying NOT NULL,
    titlefont character varying(20) DEFAULT ''::character varying NOT NULL,
    height integer DEFAULT 314::numeric NOT NULL,
    width integer DEFAULT 741::numeric NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_flashes OWNER TO seevia;

--
-- Name: svcart_flashes_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_flashes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_flashes_id_seq OWNER TO seevia;

--
-- Name: svcart_flashes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_flashes_id_seq OWNED BY svcart_flashes.id;


--
-- Name: svcart_language_dictionaries; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_language_dictionaries (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    location character varying(10) DEFAULT 'front'::character varying NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    type character varying(100) DEFAULT ''::character varying NOT NULL,
    description character varying(255) DEFAULT NULL::character varying,
    value character varying(255) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_language_dictionaries OWNER TO seevia;

--
-- Name: svcart_language_dictionaries_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_language_dictionaries_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_language_dictionaries_id_seq OWNER TO seevia;

--
-- Name: svcart_language_dictionaries_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_language_dictionaries_id_seq OWNED BY svcart_language_dictionaries.id;


--
-- Name: svcart_languages; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_languages (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    charset character varying(100) DEFAULT ''::character varying NOT NULL,
    map character varying(255) DEFAULT ''::character varying NOT NULL,
    img01 character varying(200) DEFAULT ''::character varying NOT NULL,
    img02 character varying(200) DEFAULT ''::character varying NOT NULL,
    front character(1) DEFAULT '1'::bpchar NOT NULL,
    backend character(1) DEFAULT '1'::bpchar NOT NULL,
    is_default character(1) DEFAULT ''::bpchar NOT NULL,
    google_translate_code character varying(255) DEFAULT '0'::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_languages OWNER TO seevia;

--
-- Name: svcart_languages_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_languages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_languages_id_seq OWNER TO seevia;

--
-- Name: svcart_languages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_languages_id_seq OWNED BY svcart_languages.id;


--
-- Name: svcart_link_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_link_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    link_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    description text,
    url character varying(200) DEFAULT ''::character varying NOT NULL,
    click_stat integer DEFAULT 0 NOT NULL,
    img01 character varying(200) DEFAULT ''::character varying NOT NULL,
    img02 character varying(200) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_link_i18ns OWNER TO seevia;

--
-- Name: svcart_link_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_link_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_link_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_link_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_link_i18ns_id_seq OWNED BY svcart_link_i18ns.id;


--
-- Name: svcart_links; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_links (
    id integer NOT NULL,
    contact_name character varying(20) DEFAULT ''::character varying NOT NULL,
    contact_email character varying(200) DEFAULT ''::character varying NOT NULL,
    contact_tele character varying(20) DEFAULT ''::character varying NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_links OWNER TO seevia;

--
-- Name: svcart_links_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_links_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_links_id_seq OWNER TO seevia;

--
-- Name: svcart_links_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_links_id_seq OWNED BY svcart_links.id;


--
-- Name: svcart_mail_template_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_mail_template_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    mail_template_id integer DEFAULT 0 NOT NULL,
    title character varying(100) DEFAULT ''::character varying NOT NULL,
    text_body text,
    html_body text,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_mail_template_i18ns OWNER TO seevia;

--
-- Name: svcart_mail_template_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_mail_template_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_mail_template_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_mail_template_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_mail_template_i18ns_id_seq OWNED BY svcart_mail_template_i18ns.id;


--
-- Name: svcart_mail_templates; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_mail_templates (
    id integer NOT NULL,
    code character varying(200) DEFAULT ''::character varying NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_mail_templates OWNER TO seevia;

--
-- Name: svcart_mail_templates_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_mail_templates_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_mail_templates_id_seq OWNER TO seevia;

--
-- Name: svcart_mail_templates_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_mail_templates_id_seq OWNED BY svcart_mail_templates.id;


--
-- Name: svcart_navigation_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_navigation_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    navigation_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    url character varying(255) DEFAULT ''::character varying NOT NULL,
    description text,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_navigation_i18ns OWNER TO seevia;

--
-- Name: svcart_navigation_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_navigation_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_navigation_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_navigation_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_navigation_i18ns_id_seq OWNED BY svcart_navigation_i18ns.id;


--
-- Name: svcart_navigations; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_navigations (
    id integer NOT NULL,
    type character(1) DEFAULT ''::bpchar NOT NULL,
    orderby smallint DEFAULT 10::numeric NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    icon character varying(200) DEFAULT ''::character varying NOT NULL,
    target character(255) DEFAULT '_self'::bpchar NOT NULL,
    controller character(255) DEFAULT 'pages'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_navigations OWNER TO seevia;

--
-- Name: svcart_navigations_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_navigations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_navigations_id_seq OWNER TO seevia;

--
-- Name: svcart_navigations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_navigations_id_seq OWNED BY svcart_navigations.id;


--
-- Name: svcart_newsletter_lists; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_newsletter_lists (
    id integer NOT NULL,
    email character varying(100) DEFAULT ''::character varying NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_newsletter_lists OWNER TO seevia;

--
-- Name: svcart_newsletter_lists_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_newsletter_lists_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_newsletter_lists_id_seq OWNER TO seevia;

--
-- Name: svcart_newsletter_lists_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_newsletter_lists_id_seq OWNED BY svcart_newsletter_lists.id;


--
-- Name: svcart_operator_action_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_operator_action_i18ns (
    id bigint NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    operator_action_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    "values" character varying(500) DEFAULT ''::character varying NOT NULL,
    description character varying(255) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_operator_action_i18ns OWNER TO seevia;

--
-- Name: svcart_operator_action_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_operator_action_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_operator_action_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_operator_action_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_operator_action_i18ns_id_seq OWNED BY svcart_operator_action_i18ns.id;


--
-- Name: svcart_operator_actions; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_operator_actions (
    id integer NOT NULL,
    level smallint DEFAULT 0 NOT NULL,
    parent_id integer DEFAULT 0 NOT NULL,
    code character varying(255) DEFAULT ''::character varying NOT NULL,
    status character(1) DEFAULT '0'::bpchar NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_operator_actions OWNER TO seevia;

--
-- Name: svcart_operator_actions_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_operator_actions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_operator_actions_id_seq OWNER TO seevia;

--
-- Name: svcart_operator_actions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_operator_actions_id_seq OWNED BY svcart_operator_actions.id;


--
-- Name: svcart_operator_logs; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_operator_logs (
    id integer NOT NULL,
    operator_id integer DEFAULT 0 NOT NULL,
    ipaddress character varying(30) DEFAULT ''::character varying NOT NULL,
    action_url character varying(255) DEFAULT ''::character varying NOT NULL,
    info text,
    type character(1) DEFAULT ''::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_operator_logs OWNER TO seevia;

--
-- Name: svcart_operator_logs_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_operator_logs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_operator_logs_id_seq OWNER TO seevia;

--
-- Name: svcart_operator_logs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_operator_logs_id_seq OWNED BY svcart_operator_logs.id;


--
-- Name: svcart_operator_menu_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_operator_menu_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    operator_menu_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_operator_menu_i18ns OWNER TO seevia;

--
-- Name: svcart_operator_menu_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_operator_menu_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_operator_menu_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_operator_menu_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_operator_menu_i18ns_id_seq OWNED BY svcart_operator_menu_i18ns.id;


--
-- Name: svcart_operator_menus; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_operator_menus (
    id integer NOT NULL,
    parent_id integer DEFAULT 0 NOT NULL,
    operator_action_code character varying(250) DEFAULT ''::character varying NOT NULL,
    type character varying(1) DEFAULT ''::character varying NOT NULL,
    link character varying(200) DEFAULT ''::character varying NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_operator_menus OWNER TO seevia;

--
-- Name: svcart_operator_role_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_operator_role_i18ns (
    id bigint NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    operator_role_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_operator_role_i18ns OWNER TO seevia;

--
-- Name: svcart_operator_role_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_operator_role_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_operator_role_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_operator_role_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_operator_role_i18ns_id_seq OWNED BY svcart_operator_role_i18ns.id;


--
-- Name: svcart_operator_roles; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_operator_roles (
    id integer NOT NULL,
    store_id integer DEFAULT 0 NOT NULL,
    actions text,
    status character(1) DEFAULT '0'::bpchar NOT NULL,
    orderby smallint DEFAULT 500::numeric NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_operator_roles OWNER TO seevia;

--
-- Name: svcart_operator_roles_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_operator_roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_operator_roles_id_seq OWNER TO seevia;

--
-- Name: svcart_operator_roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_operator_roles_id_seq OWNED BY svcart_operator_roles.id;


--
-- Name: svcart_operators; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_operators (
    id integer NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    password character varying(64) DEFAULT ''::character varying NOT NULL,
    email character varying(255) DEFAULT ''::character varying NOT NULL,
    mobile character varying(20) DEFAULT ''::character varying NOT NULL,
    department_id integer DEFAULT 0 NOT NULL,
    store_id integer DEFAULT 0 NOT NULL,
    role_id character varying(200) DEFAULT '0'::character varying NOT NULL,
    actions text,
    default_lang character varying(10) DEFAULT 'zh_cn'::character varying NOT NULL,
    desktop text,
    status character(1) DEFAULT '0'::bpchar NOT NULL,
    last_login_time timestamp without time zone,
    last_login_ip character varying(20) DEFAULT NULL::character varying,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_operators OWNER TO seevia;

--
-- Name: svcart_operators_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_operators_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_operators_id_seq OWNER TO seevia;

--
-- Name: svcart_operators_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_operators_id_seq OWNED BY svcart_operators.id;


--
-- Name: svcart_order_actions; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_order_actions (
    id integer NOT NULL,
    order_id integer DEFAULT 0 NOT NULL,
    from_operator_id integer DEFAULT 0 NOT NULL,
    to_operator_id integer DEFAULT 0 NOT NULL,
    user_id integer DEFAULT 0 NOT NULL,
    order_status smallint DEFAULT 0 NOT NULL,
    shipping_status smallint DEFAULT 0 NOT NULL,
    payment_status smallint DEFAULT 0 NOT NULL,
    action_note character varying(255) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_order_actions OWNER TO seevia;

--
-- Name: svcart_order_actions_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_order_actions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_order_actions_id_seq OWNER TO seevia;

--
-- Name: svcart_order_actions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_order_actions_id_seq OWNED BY svcart_order_actions.id;


--
-- Name: svcart_order_cards; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_order_cards (
    id integer NOT NULL,
    order_id integer DEFAULT 0 NOT NULL,
    card_id integer DEFAULT 0 NOT NULL,
    card_name character varying(120) DEFAULT ''::character varying NOT NULL,
    card_quntity integer DEFAULT 1::numeric NOT NULL,
    card_fee numeric(10,2) DEFAULT 0 NOT NULL,
    note character varying(200) DEFAULT ''::character varying NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_order_cards OWNER TO seevia;

--
-- Name: svcart_order_cards_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_order_cards_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_order_cards_id_seq OWNER TO seevia;

--
-- Name: svcart_order_cards_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_order_cards_id_seq OWNED BY svcart_order_cards.id;


--
-- Name: svcart_order_packagings; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_order_packagings (
    id integer NOT NULL,
    order_id integer DEFAULT 0 NOT NULL,
    packaging_id integer DEFAULT 0 NOT NULL,
    packaging_name character varying(120) DEFAULT ''::character varying NOT NULL,
    packaging_quntity integer DEFAULT 1::numeric NOT NULL,
    packaging_fee numeric(10,2) DEFAULT 0 NOT NULL,
    note character varying(200) DEFAULT ''::character varying NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_order_packagings OWNER TO seevia;

--
-- Name: svcart_order_packagings_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_order_packagings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_order_packagings_id_seq OWNER TO seevia;

--
-- Name: svcart_order_packagings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_order_packagings_id_seq OWNED BY svcart_order_packagings.id;


--
-- Name: svcart_order_products; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_order_products (
    id integer NOT NULL,
    order_id integer DEFAULT 0 NOT NULL,
    product_id integer DEFAULT 0 NOT NULL,
    product_name character varying(120) DEFAULT ''::character varying NOT NULL,
    product_code character varying(60) DEFAULT ''::character varying NOT NULL,
    product_quntity integer DEFAULT 1::numeric NOT NULL,
    product_price numeric(10,2) DEFAULT 0 NOT NULL,
    product_attrbute text,
    note character varying(200) DEFAULT ''::character varying NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    extension_code character varying(20) DEFAULT ''::character varying NOT NULL,
    send_quntity integer DEFAULT 0 NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_order_products OWNER TO seevia;

--
-- Name: svcart_order_products_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_order_products_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_order_products_id_seq OWNER TO seevia;

--
-- Name: svcart_order_products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_order_products_id_seq OWNED BY svcart_order_products.id;


--
-- Name: svcart_orders; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_orders (
    id bigint NOT NULL,
    order_code character varying(60) DEFAULT '0'::character varying NOT NULL,
    user_id integer DEFAULT 0 NOT NULL,
    operator_id integer DEFAULT 0 NOT NULL,
    status smallint DEFAULT 0 NOT NULL,
    shipping_id smallint DEFAULT 0 NOT NULL,
    shipping_name character varying(120) DEFAULT ''::character varying NOT NULL,
    shipping_status smallint DEFAULT 0 NOT NULL,
    shipping_time timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    shipping_fee numeric(10,2) DEFAULT 0 NOT NULL,
    point_fee numeric(10,2) DEFAULT 0 NOT NULL,
    point_use integer DEFAULT 0 NOT NULL,
    payment_id smallint DEFAULT 0 NOT NULL,
    payment_name character varying(120) DEFAULT ''::character varying NOT NULL,
    payment_status smallint DEFAULT 0 NOT NULL,
    payment_time timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    payment_fee numeric(10,2) DEFAULT 0 NOT NULL,
    coupon_id integer DEFAULT 0 NOT NULL,
    consignee character varying(60) DEFAULT ''::character varying NOT NULL,
    address character varying(255) DEFAULT ''::character varying NOT NULL,
    zipcode character varying(60) DEFAULT ''::character varying NOT NULL,
    telephone character varying(60) DEFAULT ''::character varying NOT NULL,
    mobile character varying(60) DEFAULT ''::character varying NOT NULL,
    email character varying(60) DEFAULT ''::character varying NOT NULL,
    best_time character varying(120) DEFAULT ''::character varying NOT NULL,
    sign_building character varying(120) DEFAULT ''::character varying NOT NULL,
    postscript character varying(255) DEFAULT ''::character varying NOT NULL,
    invoice_no character varying(50) DEFAULT ''::character varying NOT NULL,
    note character varying(255) DEFAULT ''::character varying NOT NULL,
    money_paid numeric(10,2) DEFAULT 0 NOT NULL,
    discount numeric(10,2) DEFAULT 0 NOT NULL,
    total numeric(10,2) DEFAULT 0 NOT NULL,
    subtotal numeric(10,2) DEFAULT 0 NOT NULL,
    from_ad smallint DEFAULT 0 NOT NULL,
    referer character varying(255) DEFAULT ''::character varying NOT NULL,
    tax numeric(10,2) DEFAULT 0 NOT NULL,
    insure_fee numeric(10,2) DEFAULT 0 NOT NULL,
    pack_fee numeric(10,2) DEFAULT 0 NOT NULL,
    card_fee numeric(10,2) DEFAULT 0 NOT NULL,
    invoice_type character varying(60) DEFAULT ''::character varying NOT NULL,
    invoice_payee character varying(120) DEFAULT ''::character varying NOT NULL,
    invoice_content character varying(120) DEFAULT ''::character varying NOT NULL,
    how_oos character varying(120) DEFAULT ''::character varying NOT NULL,
    pack_name character varying(120) DEFAULT ''::character varying NOT NULL,
    card_name character varying(120) DEFAULT ''::character varying NOT NULL,
    card_message character varying(255) DEFAULT ''::character varying NOT NULL,
    to_buyer character varying(255) DEFAULT ''::character varying NOT NULL,
    confirm_time timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    regions character varying(200) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_orders OWNER TO seevia;

--
-- Name: svcart_orders_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_orders_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_orders_id_seq OWNER TO seevia;

--
-- Name: svcart_orders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_orders_id_seq OWNED BY svcart_orders.id;


--
-- Name: svcart_packaging_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_packaging_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    packaging_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    description text,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_packaging_i18ns OWNER TO seevia;

--
-- Name: svcart_packaging_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_packaging_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_packaging_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_packaging_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_packaging_i18ns_id_seq OWNED BY svcart_packaging_i18ns.id;


--
-- Name: svcart_packagings; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_packagings (
    id integer NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    img01 character varying(200) DEFAULT ''::character varying NOT NULL,
    img02 character varying(200) DEFAULT ''::character varying NOT NULL,
    fee numeric(6,2) DEFAULT 0 NOT NULL,
    free_money numeric(6,2) DEFAULT 0 NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_packagings OWNER TO seevia;

--
-- Name: svcart_packagings_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_packagings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_packagings_id_seq OWNER TO seevia;

--
-- Name: svcart_packagings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_packagings_id_seq OWNED BY svcart_packagings.id;


--
-- Name: svcart_payment_api_logs; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_payment_api_logs (
    id bigint NOT NULL,
    payment_code character varying(100) DEFAULT ''::character varying NOT NULL,
    type character(1) DEFAULT '0'::bpchar NOT NULL,
    type_id integer DEFAULT 0 NOT NULL,
    amount numeric(10,2) DEFAULT 0 NOT NULL,
    is_paid character(1) DEFAULT '0'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_payment_api_logs OWNER TO seevia;

--
-- Name: svcart_payment_api_logs_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_payment_api_logs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_payment_api_logs_id_seq OWNER TO seevia;

--
-- Name: svcart_payment_api_logs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_payment_api_logs_id_seq OWNED BY svcart_payment_api_logs.id;


--
-- Name: svcart_payment_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_payment_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    payment_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    "values" character varying(500) DEFAULT ''::character varying NOT NULL,
    description character varying(255) DEFAULT NULL::character varying,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_payment_i18ns OWNER TO seevia;

--
-- Name: svcart_payment_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_payment_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_payment_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_payment_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_payment_i18ns_id_seq OWNED BY svcart_payment_i18ns.id;


--
-- Name: svcart_payments; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_payments (
    id bigint NOT NULL,
    store_id integer DEFAULT 0 NOT NULL,
    code character varying(20) DEFAULT ''::character varying NOT NULL,
    fee character varying(10) DEFAULT '0'::character varying NOT NULL,
    orderby smallint DEFAULT 0 NOT NULL,
    config text,
    status character(1) DEFAULT '0'::bpchar NOT NULL,
    is_cod character(1) DEFAULT '0'::bpchar NOT NULL,
    is_online character(1) DEFAULT '0'::bpchar NOT NULL,
    supply_use_flag character(1) DEFAULT '1'::bpchar NOT NULL,
    order_use_flag character(1) DEFAULT '1'::bpchar NOT NULL,
    php_code text,
    version character varying(40) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_payments OWNER TO seevia;

--
-- Name: svcart_payments_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_payments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_payments_id_seq OWNER TO seevia;

--
-- Name: svcart_payments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_payments_id_seq OWNED BY svcart_payments.id;


--
-- Name: svcart_product_articles; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_product_articles (
    id bigint NOT NULL,
    article_id integer DEFAULT 0 NOT NULL,
    product_id integer DEFAULT 0 NOT NULL,
    orderby smallint DEFAULT 500::numeric NOT NULL,
    is_double character(1) DEFAULT '0'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_product_articles OWNER TO seevia;

--
-- Name: svcart_product_articles_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_product_articles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_product_articles_id_seq OWNER TO seevia;

--
-- Name: svcart_product_articles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_product_articles_id_seq OWNED BY svcart_product_articles.id;


--
-- Name: svcart_product_attributes; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_product_attributes (
    id bigint NOT NULL,
    product_id integer DEFAULT 0 NOT NULL,
    product_type_attribute_id bigint DEFAULT 0 NOT NULL,
    product_type_attribute_value text,
    product_type_attribute_price double precision DEFAULT 0 NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_product_attributes OWNER TO seevia;

--
-- Name: svcart_product_attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_product_attributes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_product_attributes_id_seq OWNER TO seevia;

--
-- Name: svcart_product_attributes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_product_attributes_id_seq OWNED BY svcart_product_attributes.id;


--
-- Name: svcart_product_galleries; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_product_galleries (
    id integer NOT NULL,
    product_id integer DEFAULT 0 NOT NULL,
    img_thumb character varying(255) DEFAULT ''::character varying NOT NULL,
    img_detail character varying(255) DEFAULT ''::character varying NOT NULL,
    img_original character varying(255) DEFAULT ''::character varying NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_product_galleries OWNER TO seevia;

--
-- Name: svcart_product_galleries_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_product_galleries_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_product_galleries_id_seq OWNER TO seevia;

--
-- Name: svcart_product_galleries_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_product_galleries_id_seq OWNED BY svcart_product_galleries.id;


--
-- Name: svcart_product_gallery_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_product_gallery_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    product_gallery_id integer DEFAULT 0 NOT NULL,
    description text,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_product_gallery_i18ns OWNER TO seevia;

--
-- Name: svcart_product_gallery_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_product_gallery_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_product_gallery_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_product_gallery_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_product_gallery_i18ns_id_seq OWNED BY svcart_product_gallery_i18ns.id;


--
-- Name: svcart_product_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_product_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    product_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    description text,
    market_price double precision DEFAULT 0 NOT NULL,
    shop_price double precision DEFAULT 0 NOT NULL,
    meta_keywords text,
    meta_description text,
    api_site_url character varying(255) DEFAULT ''::character varying NOT NULL,
    api_cart_url character varying(255) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_product_i18ns OWNER TO seevia;

--
-- Name: svcart_product_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_product_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_product_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_product_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_product_i18ns_id_seq OWNED BY svcart_product_i18ns.id;


--
-- Name: svcart_product_ranks; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_product_ranks (
    id bigint NOT NULL,
    product_id integer DEFAULT 0 NOT NULL,
    rank_id smallint DEFAULT 0 NOT NULL,
    is_default_rank character(1) DEFAULT '0'::bpchar NOT NULL,
    product_price double precision DEFAULT 0 NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_product_ranks OWNER TO seevia;

--
-- Name: svcart_product_ranks_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_product_ranks_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_product_ranks_id_seq OWNER TO seevia;

--
-- Name: svcart_product_ranks_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_product_ranks_id_seq OWNED BY svcart_product_ranks.id;


--
-- Name: svcart_product_relations; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_product_relations (
    id bigint NOT NULL,
    product_id integer DEFAULT 0 NOT NULL,
    related_product_id integer DEFAULT 0 NOT NULL,
    orderby smallint DEFAULT 500::numeric NOT NULL,
    is_double character(1) DEFAULT '0'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_product_relations OWNER TO seevia;

--
-- Name: svcart_product_relations_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_product_relations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_product_relations_id_seq OWNER TO seevia;

--
-- Name: svcart_product_relations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_product_relations_id_seq OWNED BY svcart_product_relations.id;


--
-- Name: svcart_product_type_attribute_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_product_type_attribute_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    product_type_attribute_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_product_type_attribute_i18ns OWNER TO seevia;

--
-- Name: svcart_product_type_attribute_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_product_type_attribute_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_product_type_attribute_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_product_type_attribute_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_product_type_attribute_i18ns_id_seq OWNED BY svcart_product_type_attribute_i18ns.id;


--
-- Name: svcart_product_type_attributes; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_product_type_attributes (
    id integer NOT NULL,
    product_type_id integer DEFAULT 0 NOT NULL,
    attr_value text,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    attr_input_type character(1) DEFAULT '1'::bpchar NOT NULL,
    attr_type character(1) DEFAULT '1'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_product_type_attributes OWNER TO seevia;

--
-- Name: svcart_product_type_attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_product_type_attributes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_product_type_attributes_id_seq OWNER TO seevia;

--
-- Name: svcart_product_type_attributes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_product_type_attributes_id_seq OWNED BY svcart_product_type_attributes.id;


--
-- Name: svcart_product_type_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_product_type_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    type_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_product_type_i18ns OWNER TO seevia;

--
-- Name: svcart_product_type_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_product_type_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_product_type_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_product_type_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_product_type_i18ns_id_seq OWNED BY svcart_product_type_i18ns.id;


--
-- Name: svcart_product_types; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_product_types (
    id integer NOT NULL,
    group_code character varying(20) DEFAULT ''::character varying NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_product_types OWNER TO seevia;

--
-- Name: svcart_product_types_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_product_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_product_types_id_seq OWNER TO seevia;

--
-- Name: svcart_product_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_product_types_id_seq OWNED BY svcart_product_types.id;


--
-- Name: svcart_products; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_products (
    id integer NOT NULL,
    coupon_type_id integer DEFAULT 0 NOT NULL,
    brand_id integer DEFAULT 0 NOT NULL,
    provider_id integer DEFAULT 0 NOT NULL,
    category_id integer DEFAULT 0 NOT NULL,
    code character varying(20) DEFAULT ''::character varying NOT NULL,
    product_name_style character varying(60) DEFAULT '+'::character varying NOT NULL,
    img_thumb character varying(255) DEFAULT ''::character varying NOT NULL,
    img_detail character varying(255) DEFAULT ''::character varying NOT NULL,
    img_original character varying(255) NOT NULL,
    recommand_flag character(1) DEFAULT '0'::bpchar NOT NULL,
    min_buy integer DEFAULT 1::numeric NOT NULL,
    max_buy integer DEFAULT 100::numeric NOT NULL,
    admin_id integer DEFAULT 0 NOT NULL,
    alone character(1) DEFAULT '1'::bpchar NOT NULL,
    forsale character(1) DEFAULT '1'::bpchar NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    weight numeric(10,3) DEFAULT 0 NOT NULL,
    market_price double precision DEFAULT 0 NOT NULL,
    shop_price double precision DEFAULT 0 NOT NULL,
    promotion_price double precision DEFAULT 0 NOT NULL,
    promotion_start timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    promotion_end timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    promotion_status character(1) DEFAULT '0'::bpchar NOT NULL,
    point integer DEFAULT 0 NOT NULL,
    point_fee character varying(11) DEFAULT '0'::character varying NOT NULL,
    view_stat integer DEFAULT 0 NOT NULL,
    sale_stat integer DEFAULT 0 NOT NULL,
    product_type_id integer DEFAULT 0 NOT NULL,
    product_rank_id integer DEFAULT 0 NOT NULL,
    quantity integer DEFAULT 0 NOT NULL,
    extension_code character varying(20) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_products OWNER TO seevia;

--
-- Name: svcart_products_categories; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_products_categories (
    id integer NOT NULL,
    category_id integer DEFAULT 0 NOT NULL,
    product_id integer DEFAULT 0 NOT NULL,
    orderby smallint DEFAULT 500::numeric NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_products_categories OWNER TO seevia;

--
-- Name: svcart_products_categories_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_products_categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_products_categories_id_seq OWNER TO seevia;

--
-- Name: svcart_products_categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_products_categories_id_seq OWNED BY svcart_products_categories.id;


--
-- Name: svcart_products_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_products_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_products_id_seq OWNER TO seevia;

--
-- Name: svcart_products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_products_id_seq OWNED BY svcart_products.id;


--
-- Name: svcart_promotion_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_promotion_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    promotion_id integer DEFAULT 0 NOT NULL,
    title character varying(100) DEFAULT ''::character varying NOT NULL,
    meta_keywords text,
    meta_description text,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_promotion_i18ns OWNER TO seevia;

--
-- Name: svcart_promotion_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_promotion_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_promotion_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_promotion_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_promotion_i18ns_id_seq OWNED BY svcart_promotion_i18ns.id;


--
-- Name: svcart_promotion_products; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_promotion_products (
    id integer NOT NULL,
    store_id integer DEFAULT 0 NOT NULL,
    promotion_id integer DEFAULT 0 NOT NULL,
    product_id integer DEFAULT 0 NOT NULL,
    price numeric(10,2) DEFAULT 0 NOT NULL,
    start_time timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    end_time timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_promotion_products OWNER TO seevia;

--
-- Name: svcart_promotion_products_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_promotion_products_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_promotion_products_id_seq OWNER TO seevia;

--
-- Name: svcart_promotion_products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_promotion_products_id_seq OWNED BY svcart_promotion_products.id;


--
-- Name: svcart_promotions; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_promotions (
    id integer NOT NULL,
    store_id integer DEFAULT 0 NOT NULL,
    type character varying(20) DEFAULT ''::character varying NOT NULL,
    type_ext numeric(10,2) DEFAULT 0 NOT NULL,
    start_time timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    end_time timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    user_rank character varying(255) DEFAULT ''::character varying NOT NULL,
    min_amount numeric(10,2) DEFAULT 0 NOT NULL,
    max_amount numeric(10,2) DEFAULT 0 NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    clicked bigint DEFAULT 0 NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_promotions OWNER TO seevia;

--
-- Name: svcart_promotions_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_promotions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_promotions_id_seq OWNER TO seevia;

--
-- Name: svcart_promotions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_promotions_id_seq OWNED BY svcart_promotions.id;


--
-- Name: svcart_provider_products; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_provider_products (
    id bigint NOT NULL,
    provider_id integer DEFAULT 0 NOT NULL,
    product_id integer DEFAULT 0 NOT NULL,
    price double precision NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    min_buy integer DEFAULT 0 NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_provider_products OWNER TO seevia;

--
-- Name: svcart_provider_products_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_provider_products_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_provider_products_id_seq OWNER TO seevia;

--
-- Name: svcart_provider_products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_provider_products_id_seq OWNED BY svcart_provider_products.id;


--
-- Name: svcart_providers; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_providers (
    id integer NOT NULL,
    store_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    description text,
    meta_keywords text,
    meta_description text,
    contact_name character varying(20) DEFAULT ''::character varying NOT NULL,
    contact_email character varying(200) DEFAULT ''::character varying NOT NULL,
    contact_tele character varying(20) DEFAULT ''::character varying NOT NULL,
    contact_mobile character varying(20) DEFAULT ''::character varying NOT NULL,
    contact_fax character varying(20) DEFAULT ''::character varying NOT NULL,
    contact_address character varying(200) DEFAULT ''::character varying NOT NULL,
    contact_zip character varying(20) DEFAULT ''::character varying NOT NULL,
    contact_remark text,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_providers OWNER TO seevia;

--
-- Name: svcart_providers_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_providers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_providers_id_seq OWNER TO seevia;

--
-- Name: svcart_providers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_providers_id_seq OWNED BY svcart_providers.id;


--
-- Name: svcart_region_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_region_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    region_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    description text,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_region_i18ns OWNER TO seevia;

--
-- Name: svcart_region_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_region_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_region_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_region_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_region_i18ns_id_seq OWNED BY svcart_region_i18ns.id;


--
-- Name: svcart_regions; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_regions (
    id integer NOT NULL,
    parent_id integer DEFAULT 0 NOT NULL,
    level character(1) DEFAULT '2'::bpchar NOT NULL,
    agency_id integer DEFAULT 0 NOT NULL,
    param01 character varying(200) DEFAULT ''::character varying NOT NULL,
    param02 character varying(200) DEFAULT ''::character varying NOT NULL,
    param03 character varying(200) DEFAULT ''::character varying NOT NULL,
    orderby smallint DEFAULT 0 NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_regions OWNER TO seevia;

--
-- Name: svcart_regions_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_regions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_regions_id_seq OWNER TO seevia;

--
-- Name: svcart_regions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_regions_id_seq OWNED BY svcart_regions.id;


--
-- Name: svcart_sessions; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_sessions (
    id character varying(255) DEFAULT ''::character varying NOT NULL,
    data text,
    expires integer
);


ALTER TABLE public.svcart_sessions OWNER TO seevia;

--
-- Name: svcart_shipping_area_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_shipping_area_i18ns (
    id bigint NOT NULL,
    locale character varying(10) NOT NULL,
    shipping_area_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    description text,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_shipping_area_i18ns OWNER TO seevia;

--
-- Name: svcart_shipping_area_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_shipping_area_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_shipping_area_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_shipping_area_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_shipping_area_i18ns_id_seq OWNED BY svcart_shipping_area_i18ns.id;


--
-- Name: svcart_shipping_area_regions; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_shipping_area_regions (
    id bigint NOT NULL,
    shipping_area_id smallint DEFAULT 0 NOT NULL,
    region_id smallint DEFAULT 0 NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_shipping_area_regions OWNER TO seevia;

--
-- Name: svcart_shipping_area_regions_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_shipping_area_regions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_shipping_area_regions_id_seq OWNER TO seevia;

--
-- Name: svcart_shipping_area_regions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_shipping_area_regions_id_seq OWNED BY svcart_shipping_area_regions.id;


--
-- Name: svcart_shipping_areas; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_shipping_areas (
    id integer NOT NULL,
    store_id integer DEFAULT 0 NOT NULL,
    shipping_id smallint DEFAULT 0 NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    status character(1) DEFAULT '0'::bpchar NOT NULL,
    fee_configures text,
    free_subtotal numeric(10,2) DEFAULT 0 NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_shipping_areas OWNER TO seevia;

--
-- Name: svcart_shipping_areas_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_shipping_areas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_shipping_areas_id_seq OWNER TO seevia;

--
-- Name: svcart_shipping_areas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_shipping_areas_id_seq OWNED BY svcart_shipping_areas.id;


--
-- Name: svcart_shipping_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_shipping_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    shipping_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    description text,
    param character varying(200) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_shipping_i18ns OWNER TO seevia;

--
-- Name: svcart_shipping_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_shipping_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_shipping_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_shipping_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_shipping_i18ns_id_seq OWNED BY svcart_shipping_i18ns.id;


--
-- Name: svcart_shippings; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_shippings (
    id bigint NOT NULL,
    store_id integer DEFAULT 0 NOT NULL,
    code character varying(100) DEFAULT ''::character varying NOT NULL,
    insure character(1) DEFAULT '0'::bpchar NOT NULL,
    support_cod character(1) DEFAULT '0'::bpchar NOT NULL,
    status character(1) DEFAULT '0'::bpchar NOT NULL,
    php_code text,
    orderby smallint DEFAULT 0 NOT NULL,
    insure_fee numeric(10,2) DEFAULT 0 NOT NULL,
    version character varying(40) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_shippings OWNER TO seevia;

--
-- Name: svcart_shippings_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_shippings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_shippings_id_seq OWNER TO seevia;

--
-- Name: svcart_shippings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_shippings_id_seq OWNED BY svcart_shippings.id;


--
-- Name: svcart_store_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_store_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    store_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    description text,
    address character varying(255) DEFAULT ''::character varying NOT NULL,
    telephone character varying(20) DEFAULT ''::character varying NOT NULL,
    zipcode character varying(10) DEFAULT ''::character varying NOT NULL,
    transport character varying(255) DEFAULT ''::character varying NOT NULL,
    map character varying(200) DEFAULT ''::character varying NOT NULL,
    url character varying(255) DEFAULT ''::character varying NOT NULL,
    meta_keywords text,
    meta_description text,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_store_i18ns OWNER TO seevia;

--
-- Name: svcart_store_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_store_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_store_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_store_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_store_i18ns_id_seq OWNED BY svcart_store_i18ns.id;


--
-- Name: svcart_store_products; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_store_products (
    id bigint NOT NULL,
    store_id integer DEFAULT 0 NOT NULL,
    product_id integer DEFAULT 0 NOT NULL,
    price double precision DEFAULT 0 NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    start_time timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    end_time timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_store_products OWNER TO seevia;

--
-- Name: svcart_store_products_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_store_products_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_store_products_id_seq OWNER TO seevia;

--
-- Name: svcart_store_products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_store_products_id_seq OWNED BY svcart_store_products.id;


--
-- Name: svcart_stores; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_stores (
    id integer NOT NULL,
    contact_name character varying(50) DEFAULT ''::character varying NOT NULL,
    contact_email character varying(200) DEFAULT ''::character varying NOT NULL,
    contact_tele character varying(20) DEFAULT ''::character varying NOT NULL,
    contact_mobile character varying(20) DEFAULT ''::character varying NOT NULL,
    contact_fax character varying(20) DEFAULT ''::character varying NOT NULL,
    remark text,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_stores OWNER TO seevia;

--
-- Name: svcart_stores_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_stores_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_stores_id_seq OWNER TO seevia;

--
-- Name: svcart_stores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_stores_id_seq OWNED BY svcart_stores.id;


--
-- Name: svcart_templates; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_templates (
    id integer NOT NULL,
    name character varying(60) DEFAULT ''::character varying NOT NULL,
    url character varying(100) DEFAULT 'http://www.seevia.cn/'::character varying NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    is_default character(1) DEFAULT '0'::bpchar NOT NULL,
    author character varying(60) DEFAULT ''::character varying NOT NULL,
    version character varying(20) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_templates OWNER TO seevia;

--
-- Name: svcart_templates_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_templates_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_templates_id_seq OWNER TO seevia;

--
-- Name: svcart_templates_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_templates_id_seq OWNED BY svcart_templates.id;


--
-- Name: svcart_topic_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_topic_i18ns (
    id integer NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    topic_id integer DEFAULT 0 NOT NULL,
    title character varying(255) DEFAULT ''::character varying NOT NULL,
    intro text,
    meta_keywords text,
    meta_description text,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_topic_i18ns OWNER TO seevia;

--
-- Name: svcart_topic_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_topic_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_topic_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_topic_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_topic_i18ns_id_seq OWNED BY svcart_topic_i18ns.id;


--
-- Name: svcart_topic_products; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_topic_products (
    id integer NOT NULL,
    store_id integer DEFAULT 0 NOT NULL,
    topic_id integer DEFAULT 0 NOT NULL,
    product_id integer DEFAULT 0 NOT NULL,
    price numeric(10,2) DEFAULT 0 NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_topic_products OWNER TO seevia;

--
-- Name: svcart_topic_products_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_topic_products_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_topic_products_id_seq OWNER TO seevia;

--
-- Name: svcart_topic_products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_topic_products_id_seq OWNED BY svcart_topic_products.id;


--
-- Name: svcart_topics; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_topics (
    id bigint NOT NULL,
    start_time timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    end_time timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    template character varying(255) DEFAULT ''::character varying NOT NULL,
    css text,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_topics OWNER TO seevia;

--
-- Name: svcart_topics_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_topics_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_topics_id_seq OWNER TO seevia;

--
-- Name: svcart_topics_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_topics_id_seq OWNED BY svcart_topics.id;


--
-- Name: svcart_user_accounts; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_user_accounts (
    id integer NOT NULL,
    user_id integer DEFAULT 0 NOT NULL,
    user_note character varying(255) DEFAULT ''::character varying NOT NULL,
    amount numeric(10,2) DEFAULT 0 NOT NULL,
    paid_time timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    admin_user character varying(255) DEFAULT ''::character varying NOT NULL,
    admin_note character varying(255) DEFAULT ''::character varying NOT NULL,
    process_type character(1) DEFAULT '0'::bpchar NOT NULL,
    payment character varying(90) DEFAULT ''::character varying NOT NULL,
    status character(1) DEFAULT '0'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_user_accounts OWNER TO seevia;

--
-- Name: svcart_user_accounts_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_user_accounts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_user_accounts_id_seq OWNER TO seevia;

--
-- Name: svcart_user_accounts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_user_accounts_id_seq OWNED BY svcart_user_accounts.id;


--
-- Name: svcart_user_addresses; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_user_addresses (
    id integer NOT NULL,
    name character varying(50) DEFAULT ''::character varying NOT NULL,
    user_id integer DEFAULT 0 NOT NULL,
    consignee character varying(60) DEFAULT ''::character varying NOT NULL,
    email character varying(60) DEFAULT ''::character varying NOT NULL,
    address character varying(120) DEFAULT ''::character varying NOT NULL,
    zipcode character varying(60) DEFAULT ''::character varying NOT NULL,
    telephone character varying(60) DEFAULT ''::character varying NOT NULL,
    mobile character varying(60) DEFAULT ''::character varying NOT NULL,
    sign_building character varying(120) DEFAULT ''::character varying NOT NULL,
    best_time character varying(120) DEFAULT ''::character varying NOT NULL,
    regions character varying(200) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_user_addresses OWNER TO seevia;

--
-- Name: svcart_user_addresses_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_user_addresses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_user_addresses_id_seq OWNER TO seevia;

--
-- Name: svcart_user_addresses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_user_addresses_id_seq OWNED BY svcart_user_addresses.id;


--
-- Name: svcart_user_balance_logs; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_user_balance_logs (
    id integer NOT NULL,
    user_id integer DEFAULT 0 NOT NULL,
    amount numeric(10,2) DEFAULT 0 NOT NULL,
    admin_user character varying(255) DEFAULT ''::character varying NOT NULL,
    admin_note character varying(255) DEFAULT ''::character varying NOT NULL,
    system_note character varying(255) DEFAULT ''::character varying NOT NULL,
    log_type character(1) DEFAULT '0'::bpchar NOT NULL,
    type_id character varying(90) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_user_balance_logs OWNER TO seevia;

--
-- Name: svcart_user_balance_logs_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_user_balance_logs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_user_balance_logs_id_seq OWNER TO seevia;

--
-- Name: svcart_user_balance_logs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_user_balance_logs_id_seq OWNED BY svcart_user_balance_logs.id;


--
-- Name: svcart_user_config_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_user_config_i18ns (
    id bigint NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    user_config_id integer DEFAULT 0 NOT NULL,
    code character varying(30) DEFAULT ''::character varying NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    description text,
    "values" text,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_user_config_i18ns OWNER TO seevia;

--
-- Name: svcart_user_config_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_user_config_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_user_config_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_user_config_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_user_config_i18ns_id_seq OWNED BY svcart_user_config_i18ns.id;


--
-- Name: svcart_user_configs; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_user_configs (
    id integer NOT NULL,
    user_id integer DEFAULT 0 NOT NULL,
    user_rank integer DEFAULT 0 NOT NULL,
    code character varying(30) DEFAULT ''::character varying NOT NULL,
    type character varying(10) DEFAULT ''::character varying NOT NULL,
    value character varying(200) DEFAULT ''::character varying NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_user_configs OWNER TO seevia;

--
-- Name: svcart_user_configs_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_user_configs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_user_configs_id_seq OWNER TO seevia;

--
-- Name: svcart_user_configs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_user_configs_id_seq OWNED BY svcart_user_configs.id;


--
-- Name: svcart_user_favorites; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_user_favorites (
    id integer NOT NULL,
    user_id integer DEFAULT 0 NOT NULL,
    type character(2) DEFAULT '0'::bpchar NOT NULL,
    type_id integer DEFAULT 0 NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_user_favorites OWNER TO seevia;

--
-- Name: svcart_user_favorites_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_user_favorites_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_user_favorites_id_seq OWNER TO seevia;

--
-- Name: svcart_user_favorites_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_user_favorites_id_seq OWNED BY svcart_user_favorites.id;


--
-- Name: svcart_user_friend_cats; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_user_friend_cats (
    id integer NOT NULL,
    cat_name character varying(100) DEFAULT ''::character varying NOT NULL,
    cat_desc character varying(200) DEFAULT ''::character varying NOT NULL,
    parent_id integer DEFAULT 0 NOT NULL,
    user_id bigint DEFAULT 0 NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_user_friend_cats OWNER TO seevia;

--
-- Name: svcart_user_friend_cats_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_user_friend_cats_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_user_friend_cats_id_seq OWNER TO seevia;

--
-- Name: svcart_user_friend_cats_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_user_friend_cats_id_seq OWNED BY svcart_user_friend_cats.id;


--
-- Name: svcart_user_friends; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_user_friends (
    id integer NOT NULL,
    user_id integer DEFAULT 0 NOT NULL,
    cat_id integer DEFAULT 0 NOT NULL,
    contact_name character varying(20) DEFAULT ''::character varying NOT NULL,
    contact_mobile character varying(20) DEFAULT ''::character varying NOT NULL,
    contact_email character varying(100) DEFAULT ''::character varying NOT NULL,
    contact_user_name character varying(60) DEFAULT ''::character varying NOT NULL,
    birthday date NOT NULL,
    birthday_wishes character varying(200) DEFAULT ''::character varying NOT NULL,
    remark text,
    last_time timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    address character varying(220) DEFAULT ''::character varying NOT NULL,
    constellation character varying(20) DEFAULT ''::character varying NOT NULL,
    personality character varying(50) DEFAULT ''::character varying NOT NULL,
    sex character(1) DEFAULT '0'::bpchar NOT NULL,
    contact_other_email character varying(100) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_user_friends OWNER TO seevia;

--
-- Name: svcart_user_friends_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_user_friends_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_user_friends_id_seq OWNER TO seevia;

--
-- Name: svcart_user_friends_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_user_friends_id_seq OWNED BY svcart_user_friends.id;


--
-- Name: svcart_user_info_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_user_info_i18ns (
    id bigint NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    user_info_id integer DEFAULT 0 NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    "values" text,
    message character varying(200) DEFAULT ''::character varying NOT NULL,
    remark text,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_user_info_i18ns OWNER TO seevia;

--
-- Name: svcart_user_info_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_user_info_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_user_info_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_user_info_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_user_info_i18ns_id_seq OWNED BY svcart_user_info_i18ns.id;


--
-- Name: svcart_user_info_values; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_user_info_values (
    id bigint NOT NULL,
    user_id integer DEFAULT 0 NOT NULL,
    user_info_id integer DEFAULT 0 NOT NULL,
    value character varying(200) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_user_info_values OWNER TO seevia;

--
-- Name: svcart_user_info_values_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_user_info_values_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_user_info_values_id_seq OWNER TO seevia;

--
-- Name: svcart_user_info_values_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_user_info_values_id_seq OWNED BY svcart_user_info_values.id;


--
-- Name: svcart_user_infos; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_user_infos (
    id integer NOT NULL,
    type character varying(20) DEFAULT ''::character varying NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    front character(1) DEFAULT '1'::bpchar NOT NULL,
    backend character(1) DEFAULT '0'::bpchar NOT NULL,
    orderby smallint DEFAULT 50::numeric NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_user_infos OWNER TO seevia;

--
-- Name: svcart_user_infos_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_user_infos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_user_infos_id_seq OWNER TO seevia;

--
-- Name: svcart_user_infos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_user_infos_id_seq OWNED BY svcart_user_infos.id;


--
-- Name: svcart_user_messages; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_user_messages (
    id integer NOT NULL,
    parent_id integer DEFAULT 0 NOT NULL,
    user_id integer DEFAULT 0 NOT NULL,
    user_name character varying(60) DEFAULT ''::character varying NOT NULL,
    user_email character varying(60) DEFAULT ''::character varying NOT NULL,
    msg_title character varying(200) DEFAULT ''::character varying NOT NULL,
    msg_type smallint DEFAULT 0 NOT NULL,
    msg_content text,
    message_img character varying(255) DEFAULT '0'::character varying NOT NULL,
    order_id bigint DEFAULT 0 NOT NULL,
    status character(1) DEFAULT '0'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_user_messages OWNER TO seevia;

--
-- Name: svcart_user_messages_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_user_messages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_user_messages_id_seq OWNER TO seevia;

--
-- Name: svcart_user_messages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_user_messages_id_seq OWNED BY svcart_user_messages.id;


--
-- Name: svcart_user_point_logs; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_user_point_logs (
    id integer NOT NULL,
    user_id integer DEFAULT 0 NOT NULL,
    point integer DEFAULT 0 NOT NULL,
    admin_user character varying(255) DEFAULT ''::character varying NOT NULL,
    admin_note character varying(255) DEFAULT ''::character varying NOT NULL,
    system_note character varying(255) DEFAULT ''::character varying NOT NULL,
    log_type character(1) DEFAULT '0'::bpchar NOT NULL,
    type_id character varying(90) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_user_point_logs OWNER TO seevia;

--
-- Name: svcart_user_point_logs_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_user_point_logs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_user_point_logs_id_seq OWNER TO seevia;

--
-- Name: svcart_user_point_logs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_user_point_logs_id_seq OWNED BY svcart_user_point_logs.id;


--
-- Name: svcart_user_rank_i18ns; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_user_rank_i18ns (
    id bigint NOT NULL,
    locale character varying(10) DEFAULT ''::character varying NOT NULL,
    user_rank_id integer DEFAULT 0 NOT NULL,
    name character varying(200) DEFAULT ''::character varying NOT NULL,
    descrption text,
    img character varying(200) DEFAULT ''::character varying NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_user_rank_i18ns OWNER TO seevia;

--
-- Name: svcart_user_rank_i18ns_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_user_rank_i18ns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_user_rank_i18ns_id_seq OWNER TO seevia;

--
-- Name: svcart_user_rank_i18ns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_user_rank_i18ns_id_seq OWNED BY svcart_user_rank_i18ns.id;


--
-- Name: svcart_user_ranks; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_user_ranks (
    id bigint NOT NULL,
    min_points bigint DEFAULT 0 NOT NULL,
    max_points bigint DEFAULT 0 NOT NULL,
    discount smallint DEFAULT 0 NOT NULL,
    show_price character(1) DEFAULT '1'::bpchar NOT NULL,
    allow_buy character(1) DEFAULT '1'::bpchar NOT NULL,
    special_rank character(1) DEFAULT '0'::bpchar NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_user_ranks OWNER TO seevia;

--
-- Name: svcart_user_ranks_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_user_ranks_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_user_ranks_id_seq OWNER TO seevia;

--
-- Name: svcart_user_ranks_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_user_ranks_id_seq OWNED BY svcart_user_ranks.id;


--
-- Name: svcart_users; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_users (
    id integer NOT NULL,
    name character varying(20) DEFAULT ''::character varying NOT NULL,
    password character varying(64) DEFAULT ''::character varying NOT NULL,
    email character varying(200) DEFAULT ''::character varying NOT NULL,
    address_id character varying(200) DEFAULT '0'::character varying NOT NULL,
    question character varying(100) DEFAULT ''::character varying NOT NULL,
    answer character varying(100) DEFAULT ''::character varying NOT NULL,
    balance double precision DEFAULT 0 NOT NULL,
    frozen double precision DEFAULT 0 NOT NULL,
    point integer DEFAULT 0 NOT NULL,
    login_times integer DEFAULT 0 NOT NULL,
    login_ipaddr character varying(20) NOT NULL,
    last_login_time timestamp without time zone,
    rank integer DEFAULT 0 NOT NULL,
    status character(1) DEFAULT '1'::bpchar NOT NULL,
    verify_status character(1) DEFAULT '0'::bpchar NOT NULL,
    unvalidate_note character varying(60) DEFAULT ''::character varying NOT NULL,
    birthday date,
    sex smallint DEFAULT 0 NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_users OWNER TO seevia;

--
-- Name: svcart_users_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_users_id_seq OWNER TO seevia;

--
-- Name: svcart_users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_users_id_seq OWNED BY svcart_users.id;


--
-- Name: svcart_virtual_cards; Type: TABLE; Schema: public; Owner: seevia; Tablespace: 
--

CREATE TABLE svcart_virtual_cards (
    id integer NOT NULL,
    product_id integer DEFAULT 0 NOT NULL,
    card_sn character varying(30) DEFAULT ''::character varying NOT NULL,
    card_password character varying(30) DEFAULT ''::character varying NOT NULL,
    end_date timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    is_saled integer DEFAULT 0 NOT NULL,
    order_id integer DEFAULT 0 NOT NULL,
    crc32 integer DEFAULT 0 NOT NULL,
    created timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL,
    modified timestamp without time zone DEFAULT '2008-01-01 00:00:00'::timestamp without time zone NOT NULL
);


ALTER TABLE public.svcart_virtual_cards OWNER TO seevia;

--
-- Name: svcart_virtual_cards_id_seq; Type: SEQUENCE; Schema: public; Owner: seevia
--

CREATE SEQUENCE svcart_virtual_cards_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.svcart_virtual_cards_id_seq OWNER TO seevia;

--
-- Name: svcart_virtual_cards_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: seevia
--

ALTER SEQUENCE svcart_virtual_cards_id_seq OWNED BY svcart_virtual_cards.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_advertisement_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_advertisement_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_advertisements ALTER COLUMN id SET DEFAULT nextval('svcart_advertisements_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_article_categories ALTER COLUMN id SET DEFAULT nextval('svcart_article_categories_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_article_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_article_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_articles ALTER COLUMN id SET DEFAULT nextval('svcart_articles_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_booking_products ALTER COLUMN id SET DEFAULT nextval('svcart_booking_products_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_brand_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_brand_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_brands ALTER COLUMN id SET DEFAULT nextval('svcart_brands_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_card_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_card_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_cards ALTER COLUMN id SET DEFAULT nextval('svcart_cards_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_carts ALTER COLUMN id SET DEFAULT nextval('svcart_carts_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_categories ALTER COLUMN id SET DEFAULT nextval('svcart_categories_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_category_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_category_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_comments ALTER COLUMN id SET DEFAULT nextval('svcart_comments_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_config_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_config_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_configs ALTER COLUMN id SET DEFAULT nextval('svcart_configs_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_coupon_type_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_coupon_type_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_coupon_types ALTER COLUMN id SET DEFAULT nextval('svcart_coupon_types_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_coupons ALTER COLUMN id SET DEFAULT nextval('svcart_coupons_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_department_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_department_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_departments ALTER COLUMN id SET DEFAULT nextval('svcart_departments_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_flash_images ALTER COLUMN id SET DEFAULT nextval('svcart_flash_images_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_flashes ALTER COLUMN id SET DEFAULT nextval('svcart_flashes_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_language_dictionaries ALTER COLUMN id SET DEFAULT nextval('svcart_language_dictionaries_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_languages ALTER COLUMN id SET DEFAULT nextval('svcart_languages_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_link_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_link_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_links ALTER COLUMN id SET DEFAULT nextval('svcart_links_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_mail_template_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_mail_template_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_mail_templates ALTER COLUMN id SET DEFAULT nextval('svcart_mail_templates_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_navigation_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_navigation_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_navigations ALTER COLUMN id SET DEFAULT nextval('svcart_navigations_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_newsletter_lists ALTER COLUMN id SET DEFAULT nextval('svcart_newsletter_lists_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_operator_action_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_operator_action_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_operator_actions ALTER COLUMN id SET DEFAULT nextval('svcart_operator_actions_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_operator_logs ALTER COLUMN id SET DEFAULT nextval('svcart_operator_logs_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_operator_menu_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_operator_menu_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_operator_role_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_operator_role_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_operator_roles ALTER COLUMN id SET DEFAULT nextval('svcart_operator_roles_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_operators ALTER COLUMN id SET DEFAULT nextval('svcart_operators_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_order_actions ALTER COLUMN id SET DEFAULT nextval('svcart_order_actions_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_order_cards ALTER COLUMN id SET DEFAULT nextval('svcart_order_cards_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_order_packagings ALTER COLUMN id SET DEFAULT nextval('svcart_order_packagings_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_order_products ALTER COLUMN id SET DEFAULT nextval('svcart_order_products_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_orders ALTER COLUMN id SET DEFAULT nextval('svcart_orders_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_packaging_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_packaging_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_packagings ALTER COLUMN id SET DEFAULT nextval('svcart_packagings_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_payment_api_logs ALTER COLUMN id SET DEFAULT nextval('svcart_payment_api_logs_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_payment_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_payment_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_payments ALTER COLUMN id SET DEFAULT nextval('svcart_payments_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_product_articles ALTER COLUMN id SET DEFAULT nextval('svcart_product_articles_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_product_attributes ALTER COLUMN id SET DEFAULT nextval('svcart_product_attributes_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_product_galleries ALTER COLUMN id SET DEFAULT nextval('svcart_product_galleries_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_product_gallery_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_product_gallery_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_product_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_product_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_product_ranks ALTER COLUMN id SET DEFAULT nextval('svcart_product_ranks_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_product_relations ALTER COLUMN id SET DEFAULT nextval('svcart_product_relations_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_product_type_attribute_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_product_type_attribute_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_product_type_attributes ALTER COLUMN id SET DEFAULT nextval('svcart_product_type_attributes_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_product_type_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_product_type_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_product_types ALTER COLUMN id SET DEFAULT nextval('svcart_product_types_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_products ALTER COLUMN id SET DEFAULT nextval('svcart_products_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_products_categories ALTER COLUMN id SET DEFAULT nextval('svcart_products_categories_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_promotion_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_promotion_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_promotion_products ALTER COLUMN id SET DEFAULT nextval('svcart_promotion_products_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_promotions ALTER COLUMN id SET DEFAULT nextval('svcart_promotions_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_provider_products ALTER COLUMN id SET DEFAULT nextval('svcart_provider_products_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_providers ALTER COLUMN id SET DEFAULT nextval('svcart_providers_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_region_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_region_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_regions ALTER COLUMN id SET DEFAULT nextval('svcart_regions_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_shipping_area_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_shipping_area_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_shipping_area_regions ALTER COLUMN id SET DEFAULT nextval('svcart_shipping_area_regions_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_shipping_areas ALTER COLUMN id SET DEFAULT nextval('svcart_shipping_areas_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_shipping_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_shipping_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_shippings ALTER COLUMN id SET DEFAULT nextval('svcart_shippings_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_store_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_store_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_store_products ALTER COLUMN id SET DEFAULT nextval('svcart_store_products_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_stores ALTER COLUMN id SET DEFAULT nextval('svcart_stores_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_templates ALTER COLUMN id SET DEFAULT nextval('svcart_templates_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_topic_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_topic_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_topic_products ALTER COLUMN id SET DEFAULT nextval('svcart_topic_products_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_topics ALTER COLUMN id SET DEFAULT nextval('svcart_topics_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_user_accounts ALTER COLUMN id SET DEFAULT nextval('svcart_user_accounts_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_user_addresses ALTER COLUMN id SET DEFAULT nextval('svcart_user_addresses_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_user_balance_logs ALTER COLUMN id SET DEFAULT nextval('svcart_user_balance_logs_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_user_config_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_user_config_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_user_configs ALTER COLUMN id SET DEFAULT nextval('svcart_user_configs_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_user_favorites ALTER COLUMN id SET DEFAULT nextval('svcart_user_favorites_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_user_friend_cats ALTER COLUMN id SET DEFAULT nextval('svcart_user_friend_cats_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_user_friends ALTER COLUMN id SET DEFAULT nextval('svcart_user_friends_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_user_info_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_user_info_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_user_info_values ALTER COLUMN id SET DEFAULT nextval('svcart_user_info_values_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_user_infos ALTER COLUMN id SET DEFAULT nextval('svcart_user_infos_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_user_messages ALTER COLUMN id SET DEFAULT nextval('svcart_user_messages_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_user_point_logs ALTER COLUMN id SET DEFAULT nextval('svcart_user_point_logs_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_user_rank_i18ns ALTER COLUMN id SET DEFAULT nextval('svcart_user_rank_i18ns_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_user_ranks ALTER COLUMN id SET DEFAULT nextval('svcart_user_ranks_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_users ALTER COLUMN id SET DEFAULT nextval('svcart_users_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: seevia
--

ALTER TABLE svcart_virtual_cards ALTER COLUMN id SET DEFAULT nextval('svcart_virtual_cards_id_seq'::regclass);


--
-- Name: svcart_advertisement_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_advertisement_i18ns
    ADD CONSTRAINT svcart_advertisement_i18ns_locale_key UNIQUE (locale, advertisement_id);


--
-- Name: svcart_advertisement_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_advertisement_i18ns
    ADD CONSTRAINT svcart_advertisement_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_advertisements_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_advertisements
    ADD CONSTRAINT svcart_advertisements_pkey PRIMARY KEY (id);


--
-- Name: svcart_article_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_article_categories
    ADD CONSTRAINT svcart_article_categories_pkey PRIMARY KEY (id);


--
-- Name: svcart_article_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_article_i18ns
    ADD CONSTRAINT svcart_article_i18ns_locale_key UNIQUE (locale, article_id);


--
-- Name: svcart_article_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_article_i18ns
    ADD CONSTRAINT svcart_article_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_articles_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_articles
    ADD CONSTRAINT svcart_articles_pkey PRIMARY KEY (id);


--
-- Name: svcart_booking_products_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_booking_products
    ADD CONSTRAINT svcart_booking_products_pkey PRIMARY KEY (id);


--
-- Name: svcart_brand_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_brand_i18ns
    ADD CONSTRAINT svcart_brand_i18ns_locale_key UNIQUE (locale, brand_id);


--
-- Name: svcart_brand_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_brand_i18ns
    ADD CONSTRAINT svcart_brand_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_brands_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_brands
    ADD CONSTRAINT svcart_brands_pkey PRIMARY KEY (id);


--
-- Name: svcart_card_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_card_i18ns
    ADD CONSTRAINT svcart_card_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_cards_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_cards
    ADD CONSTRAINT svcart_cards_pkey PRIMARY KEY (id);


--
-- Name: svcart_carts_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_carts
    ADD CONSTRAINT svcart_carts_pkey PRIMARY KEY (id);


--
-- Name: svcart_carts_user_id_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_carts
    ADD CONSTRAINT svcart_carts_user_id_key UNIQUE (user_id);


--
-- Name: svcart_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_categories
    ADD CONSTRAINT svcart_categories_pkey PRIMARY KEY (id);


--
-- Name: svcart_category_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_category_i18ns
    ADD CONSTRAINT svcart_category_i18ns_locale_key UNIQUE (locale, category_id);


--
-- Name: svcart_category_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_category_i18ns
    ADD CONSTRAINT svcart_category_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_comments_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_comments
    ADD CONSTRAINT svcart_comments_pkey PRIMARY KEY (id);


--
-- Name: svcart_config_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_config_i18ns
    ADD CONSTRAINT svcart_config_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_configs_code_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_configs
    ADD CONSTRAINT svcart_configs_code_key UNIQUE (code);


--
-- Name: svcart_configs_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_configs
    ADD CONSTRAINT svcart_configs_pkey PRIMARY KEY (id);


--
-- Name: svcart_coupon_type_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_coupon_type_i18ns
    ADD CONSTRAINT svcart_coupon_type_i18ns_locale_key UNIQUE (locale, coupon_type_id);


--
-- Name: svcart_coupon_type_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_coupon_type_i18ns
    ADD CONSTRAINT svcart_coupon_type_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_coupon_types_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_coupon_types
    ADD CONSTRAINT svcart_coupon_types_pkey PRIMARY KEY (id);


--
-- Name: svcart_coupons_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_coupons
    ADD CONSTRAINT svcart_coupons_pkey PRIMARY KEY (id);


--
-- Name: svcart_department_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_department_i18ns
    ADD CONSTRAINT svcart_department_i18ns_locale_key UNIQUE (locale, department_id);


--
-- Name: svcart_department_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_department_i18ns
    ADD CONSTRAINT svcart_department_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_departments_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_departments
    ADD CONSTRAINT svcart_departments_pkey PRIMARY KEY (id);


--
-- Name: svcart_flash_images_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_flash_images
    ADD CONSTRAINT svcart_flash_images_pkey PRIMARY KEY (id);


--
-- Name: svcart_flashes_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_flashes
    ADD CONSTRAINT svcart_flashes_pkey PRIMARY KEY (id);


--
-- Name: svcart_flashes_type_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_flashes
    ADD CONSTRAINT svcart_flashes_type_key UNIQUE (type, type_id);


--
-- Name: svcart_language_dictionaries_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_language_dictionaries
    ADD CONSTRAINT svcart_language_dictionaries_locale_key UNIQUE (locale, name);


--
-- Name: svcart_language_dictionaries_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_language_dictionaries
    ADD CONSTRAINT svcart_language_dictionaries_pkey PRIMARY KEY (id);


--
-- Name: svcart_languages_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_languages
    ADD CONSTRAINT svcart_languages_pkey PRIMARY KEY (id);


--
-- Name: svcart_link_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_link_i18ns
    ADD CONSTRAINT svcart_link_i18ns_locale_key UNIQUE (locale, link_id);


--
-- Name: svcart_link_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_link_i18ns
    ADD CONSTRAINT svcart_link_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_links_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_links
    ADD CONSTRAINT svcart_links_pkey PRIMARY KEY (id);


--
-- Name: svcart_mail_template_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_mail_template_i18ns
    ADD CONSTRAINT svcart_mail_template_i18ns_locale_key UNIQUE (locale, mail_template_id);


--
-- Name: svcart_mail_template_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_mail_template_i18ns
    ADD CONSTRAINT svcart_mail_template_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_mail_templates_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_mail_templates
    ADD CONSTRAINT svcart_mail_templates_pkey PRIMARY KEY (id);


--
-- Name: svcart_navigation_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_navigation_i18ns
    ADD CONSTRAINT svcart_navigation_i18ns_locale_key UNIQUE (locale, navigation_id);


--
-- Name: svcart_navigation_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_navigation_i18ns
    ADD CONSTRAINT svcart_navigation_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_navigations_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_navigations
    ADD CONSTRAINT svcart_navigations_pkey PRIMARY KEY (id);


--
-- Name: svcart_newsletter_lists_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_newsletter_lists
    ADD CONSTRAINT svcart_newsletter_lists_pkey PRIMARY KEY (id);


--
-- Name: svcart_operator_action_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_operator_action_i18ns
    ADD CONSTRAINT svcart_operator_action_i18ns_locale_key UNIQUE (locale, operator_action_id);


--
-- Name: svcart_operator_action_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_operator_action_i18ns
    ADD CONSTRAINT svcart_operator_action_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_operator_actions_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_operator_actions
    ADD CONSTRAINT svcart_operator_actions_pkey PRIMARY KEY (id);


--
-- Name: svcart_operator_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_operator_logs
    ADD CONSTRAINT svcart_operator_logs_pkey PRIMARY KEY (id);


--
-- Name: svcart_operator_menu_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_operator_menu_i18ns
    ADD CONSTRAINT svcart_operator_menu_i18ns_locale_key UNIQUE (locale, operator_menu_id);


--
-- Name: svcart_operator_menu_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_operator_menu_i18ns
    ADD CONSTRAINT svcart_operator_menu_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_operator_menus_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_operator_menus
    ADD CONSTRAINT svcart_operator_menus_pkey PRIMARY KEY (id);


--
-- Name: svcart_operator_role_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_operator_role_i18ns
    ADD CONSTRAINT svcart_operator_role_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_operator_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_operator_roles
    ADD CONSTRAINT svcart_operator_roles_pkey PRIMARY KEY (id);


--
-- Name: svcart_operators_name_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_operators
    ADD CONSTRAINT svcart_operators_name_key UNIQUE (name);


--
-- Name: svcart_operators_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_operators
    ADD CONSTRAINT svcart_operators_pkey PRIMARY KEY (id);


--
-- Name: svcart_order_actions_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_order_actions
    ADD CONSTRAINT svcart_order_actions_pkey PRIMARY KEY (id);


--
-- Name: svcart_order_cards_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_order_cards
    ADD CONSTRAINT svcart_order_cards_pkey PRIMARY KEY (id);


--
-- Name: svcart_order_packagings_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_order_packagings
    ADD CONSTRAINT svcart_order_packagings_pkey PRIMARY KEY (id);


--
-- Name: svcart_order_products_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_order_products
    ADD CONSTRAINT svcart_order_products_pkey PRIMARY KEY (id);


--
-- Name: svcart_orders_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_orders
    ADD CONSTRAINT svcart_orders_pkey PRIMARY KEY (id);


--
-- Name: svcart_packaging_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_packaging_i18ns
    ADD CONSTRAINT svcart_packaging_i18ns_locale_key UNIQUE (locale, packaging_id);


--
-- Name: svcart_packaging_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_packaging_i18ns
    ADD CONSTRAINT svcart_packaging_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_packagings_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_packagings
    ADD CONSTRAINT svcart_packagings_pkey PRIMARY KEY (id);


--
-- Name: svcart_payment_api_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_payment_api_logs
    ADD CONSTRAINT svcart_payment_api_logs_pkey PRIMARY KEY (id);


--
-- Name: svcart_payment_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_payment_i18ns
    ADD CONSTRAINT svcart_payment_i18ns_locale_key UNIQUE (locale, payment_id);


--
-- Name: svcart_payment_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_payment_i18ns
    ADD CONSTRAINT svcart_payment_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_payments_code_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_payments
    ADD CONSTRAINT svcart_payments_code_key UNIQUE (code);


--
-- Name: svcart_payments_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_payments
    ADD CONSTRAINT svcart_payments_pkey PRIMARY KEY (id);


--
-- Name: svcart_product_articles_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_product_articles
    ADD CONSTRAINT svcart_product_articles_pkey PRIMARY KEY (id);


--
-- Name: svcart_product_attributes_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_product_attributes
    ADD CONSTRAINT svcart_product_attributes_pkey PRIMARY KEY (id);


--
-- Name: svcart_product_galleries_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_product_galleries
    ADD CONSTRAINT svcart_product_galleries_pkey PRIMARY KEY (id);


--
-- Name: svcart_product_gallery_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_product_gallery_i18ns
    ADD CONSTRAINT svcart_product_gallery_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_product_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_product_i18ns
    ADD CONSTRAINT svcart_product_i18ns_locale_key UNIQUE (locale, product_id);


--
-- Name: svcart_product_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_product_i18ns
    ADD CONSTRAINT svcart_product_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_product_ranks_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_product_ranks
    ADD CONSTRAINT svcart_product_ranks_pkey PRIMARY KEY (id);


--
-- Name: svcart_product_relations_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_product_relations
    ADD CONSTRAINT svcart_product_relations_pkey PRIMARY KEY (id);


--
-- Name: svcart_product_type_attribute_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_product_type_attribute_i18ns
    ADD CONSTRAINT svcart_product_type_attribute_i18ns_locale_key UNIQUE (locale, product_type_attribute_id);


--
-- Name: svcart_product_type_attribute_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_product_type_attribute_i18ns
    ADD CONSTRAINT svcart_product_type_attribute_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_product_type_attributes_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_product_type_attributes
    ADD CONSTRAINT svcart_product_type_attributes_pkey PRIMARY KEY (id);


--
-- Name: svcart_product_type_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_product_type_i18ns
    ADD CONSTRAINT svcart_product_type_i18ns_locale_key UNIQUE (locale, type_id);


--
-- Name: svcart_product_type_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_product_type_i18ns
    ADD CONSTRAINT svcart_product_type_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_product_types_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_product_types
    ADD CONSTRAINT svcart_product_types_pkey PRIMARY KEY (id);


--
-- Name: svcart_products_categories_category_id_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_products_categories
    ADD CONSTRAINT svcart_products_categories_category_id_key UNIQUE (category_id, product_id);


--
-- Name: svcart_products_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_products_categories
    ADD CONSTRAINT svcart_products_categories_pkey PRIMARY KEY (id);


--
-- Name: svcart_products_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_products
    ADD CONSTRAINT svcart_products_pkey PRIMARY KEY (id);


--
-- Name: svcart_promotion_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_promotion_i18ns
    ADD CONSTRAINT svcart_promotion_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_promotion_products_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_promotion_products
    ADD CONSTRAINT svcart_promotion_products_pkey PRIMARY KEY (id);


--
-- Name: svcart_promotions_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_promotions
    ADD CONSTRAINT svcart_promotions_pkey PRIMARY KEY (id);


--
-- Name: svcart_provider_products_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_provider_products
    ADD CONSTRAINT svcart_provider_products_pkey PRIMARY KEY (id);


--
-- Name: svcart_providers_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_providers
    ADD CONSTRAINT svcart_providers_pkey PRIMARY KEY (id);


--
-- Name: svcart_region_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_region_i18ns
    ADD CONSTRAINT svcart_region_i18ns_locale_key UNIQUE (locale, region_id);


--
-- Name: svcart_region_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_region_i18ns
    ADD CONSTRAINT svcart_region_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_regions_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_regions
    ADD CONSTRAINT svcart_regions_pkey PRIMARY KEY (id);


--
-- Name: svcart_sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_sessions
    ADD CONSTRAINT svcart_sessions_pkey PRIMARY KEY (id);


--
-- Name: svcart_shipping_area_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_shipping_area_i18ns
    ADD CONSTRAINT svcart_shipping_area_i18ns_locale_key UNIQUE (locale, shipping_area_id);


--
-- Name: svcart_shipping_area_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_shipping_area_i18ns
    ADD CONSTRAINT svcart_shipping_area_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_shipping_area_regions_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_shipping_area_regions
    ADD CONSTRAINT svcart_shipping_area_regions_pkey PRIMARY KEY (id);


--
-- Name: svcart_shipping_areas_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_shipping_areas
    ADD CONSTRAINT svcart_shipping_areas_pkey PRIMARY KEY (id);


--
-- Name: svcart_shipping_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_shipping_i18ns
    ADD CONSTRAINT svcart_shipping_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_shippings_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_shippings
    ADD CONSTRAINT svcart_shippings_pkey PRIMARY KEY (id);


--
-- Name: svcart_store_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_store_i18ns
    ADD CONSTRAINT svcart_store_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_store_products_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_store_products
    ADD CONSTRAINT svcart_store_products_pkey PRIMARY KEY (id);


--
-- Name: svcart_stores_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_stores
    ADD CONSTRAINT svcart_stores_pkey PRIMARY KEY (id);


--
-- Name: svcart_templates_name_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_templates
    ADD CONSTRAINT svcart_templates_name_key UNIQUE (name);


--
-- Name: svcart_templates_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_templates
    ADD CONSTRAINT svcart_templates_pkey PRIMARY KEY (id);


--
-- Name: svcart_topic_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_topic_i18ns
    ADD CONSTRAINT svcart_topic_i18ns_locale_key UNIQUE (locale, topic_id);


--
-- Name: svcart_topic_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_topic_i18ns
    ADD CONSTRAINT svcart_topic_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_topic_products_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_topic_products
    ADD CONSTRAINT svcart_topic_products_pkey PRIMARY KEY (id);


--
-- Name: svcart_user_accounts_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_user_accounts
    ADD CONSTRAINT svcart_user_accounts_pkey PRIMARY KEY (id);


--
-- Name: svcart_user_addresses_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_user_addresses
    ADD CONSTRAINT svcart_user_addresses_pkey PRIMARY KEY (id);


--
-- Name: svcart_user_balance_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_user_balance_logs
    ADD CONSTRAINT svcart_user_balance_logs_pkey PRIMARY KEY (id);


--
-- Name: svcart_user_config_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_user_config_i18ns
    ADD CONSTRAINT svcart_user_config_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_user_configs_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_user_configs
    ADD CONSTRAINT svcart_user_configs_pkey PRIMARY KEY (id);


--
-- Name: svcart_user_favorites_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_user_favorites
    ADD CONSTRAINT svcart_user_favorites_pkey PRIMARY KEY (id);


--
-- Name: svcart_user_friend_cats_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_user_friend_cats
    ADD CONSTRAINT svcart_user_friend_cats_pkey PRIMARY KEY (id);


--
-- Name: svcart_user_friends_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_user_friends
    ADD CONSTRAINT svcart_user_friends_pkey PRIMARY KEY (id);


--
-- Name: svcart_user_info_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_user_info_i18ns
    ADD CONSTRAINT svcart_user_info_i18ns_locale_key UNIQUE (locale, user_info_id);


--
-- Name: svcart_user_info_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_user_info_i18ns
    ADD CONSTRAINT svcart_user_info_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_user_info_values_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_user_info_values
    ADD CONSTRAINT svcart_user_info_values_pkey PRIMARY KEY (id);


--
-- Name: svcart_user_info_values_user_id_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_user_info_values
    ADD CONSTRAINT svcart_user_info_values_user_id_key UNIQUE (user_id, user_info_id);


--
-- Name: svcart_user_infos_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_user_infos
    ADD CONSTRAINT svcart_user_infos_pkey PRIMARY KEY (id);


--
-- Name: svcart_user_messages_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_user_messages
    ADD CONSTRAINT svcart_user_messages_pkey PRIMARY KEY (id);


--
-- Name: svcart_user_point_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_user_point_logs
    ADD CONSTRAINT svcart_user_point_logs_pkey PRIMARY KEY (id);


--
-- Name: svcart_user_rank_i18ns_locale_key; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_user_rank_i18ns
    ADD CONSTRAINT svcart_user_rank_i18ns_locale_key UNIQUE (locale, user_rank_id);


--
-- Name: svcart_user_rank_i18ns_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_user_rank_i18ns
    ADD CONSTRAINT svcart_user_rank_i18ns_pkey PRIMARY KEY (id);


--
-- Name: svcart_user_ranks_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_user_ranks
    ADD CONSTRAINT svcart_user_ranks_pkey PRIMARY KEY (id);


--
-- Name: svcart_users_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_users
    ADD CONSTRAINT svcart_users_pkey PRIMARY KEY (id);


--
-- Name: svcart_virtual_cards_pkey; Type: CONSTRAINT; Schema: public; Owner: seevia; Tablespace: 
--

ALTER TABLE ONLY svcart_virtual_cards
    ADD CONSTRAINT svcart_virtual_cards_pkey PRIMARY KEY (id);


--
-- Name: svcart_advertisements_svcart_advertisements_status; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_advertisements_svcart_advertisements_status ON svcart_advertisements USING btree (status);


--
-- Name: svcart_advertisements_svcart_advertisements_store_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_advertisements_svcart_advertisements_store_id ON svcart_advertisements USING btree (store_id);


--
-- Name: svcart_article_categories_svcart_article_categories_category_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_article_categories_svcart_article_categories_category_id ON svcart_article_categories USING btree (category_id);


--
-- Name: svcart_article_i18ns_svcart_article_i18ns_author; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_article_i18ns_svcart_article_i18ns_author ON svcart_article_i18ns USING btree (author);


--
-- Name: svcart_article_i18ns_svcart_article_i18ns_content; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_article_i18ns_svcart_article_i18ns_content ON svcart_article_i18ns USING btree (content);


--
-- Name: svcart_article_i18ns_svcart_article_i18ns_locale; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_article_i18ns_svcart_article_i18ns_locale ON svcart_article_i18ns USING btree (locale);


--
-- Name: svcart_article_i18ns_svcart_article_i18ns_title; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_article_i18ns_svcart_article_i18ns_title ON svcart_article_i18ns USING btree (title);


--
-- Name: svcart_articles_svcart_articles_store_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_articles_svcart_articles_store_id ON svcart_articles USING btree (store_id);


--
-- Name: svcart_articles_svcart_articles_type; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_articles_svcart_articles_type ON svcart_articles USING btree (type);


--
-- Name: svcart_booking_products_svcart_booking_products_user_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_booking_products_svcart_booking_products_user_id ON svcart_booking_products USING btree (user_id);


--
-- Name: svcart_brand_i18ns_svcart_brand_i18ns_description; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_brand_i18ns_svcart_brand_i18ns_description ON svcart_brand_i18ns USING btree (description);


--
-- Name: svcart_brand_i18ns_svcart_brand_i18ns_name; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_brand_i18ns_svcart_brand_i18ns_name ON svcart_brand_i18ns USING btree (name);


--
-- Name: svcart_brands_svcart_brands_status; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_brands_svcart_brands_status ON svcart_brands USING btree (status);


--
-- Name: svcart_card_i18ns_svcart_card_i18ns_description; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_card_i18ns_svcart_card_i18ns_description ON svcart_card_i18ns USING btree (description);


--
-- Name: svcart_card_i18ns_svcart_card_i18ns_locale; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_card_i18ns_svcart_card_i18ns_locale ON svcart_card_i18ns USING btree (locale, card_id);


--
-- Name: svcart_card_i18ns_svcart_card_i18ns_name; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_card_i18ns_svcart_card_i18ns_name ON svcart_card_i18ns USING btree (name);


--
-- Name: svcart_cards_svcart_cards_status; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_cards_svcart_cards_status ON svcart_cards USING btree (status);


--
-- Name: svcart_carts_svcart_carts_store_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_carts_svcart_carts_store_id ON svcart_carts USING btree (store_id);


--
-- Name: svcart_categories_svcart_categories_parent_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_categories_svcart_categories_parent_id ON svcart_categories USING btree (parent_id, status);


--
-- Name: svcart_comments_svcart_comments_content; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_comments_svcart_comments_content ON svcart_comments USING btree (content);


--
-- Name: svcart_comments_svcart_comments_title; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_comments_svcart_comments_title ON svcart_comments USING btree (title);


--
-- Name: svcart_comments_svcart_comments_type; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_comments_svcart_comments_type ON svcart_comments USING btree (type);


--
-- Name: svcart_comments_svcart_comments_user_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_comments_svcart_comments_user_id ON svcart_comments USING btree (user_id);


--
-- Name: svcart_config_i18ns_svcart_config_i18ns_locale; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_config_i18ns_svcart_config_i18ns_locale ON svcart_config_i18ns USING btree (locale);


--
-- Name: svcart_config_i18ns_svcart_config_i18ns_locale_2; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_config_i18ns_svcart_config_i18ns_locale_2 ON svcart_config_i18ns USING btree (locale, config_id);


--
-- Name: svcart_configs_svcart_configs_store_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_configs_svcart_configs_store_id ON svcart_configs USING btree (store_id);


--
-- Name: svcart_configs_svcart_configs_type; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_configs_svcart_configs_type ON svcart_configs USING btree (type);


--
-- Name: svcart_coupon_type_i18ns_svcart_coupon_type_i18ns_locale; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_coupon_type_i18ns_svcart_coupon_type_i18ns_locale ON svcart_coupon_type_i18ns USING btree (locale);


--
-- Name: svcart_coupons_svcart_coupons_user_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_coupons_svcart_coupons_user_id ON svcart_coupons USING btree (user_id);


--
-- Name: svcart_departments_svcart_departments_status; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_departments_svcart_departments_status ON svcart_departments USING btree (status);


--
-- Name: svcart_flash_images_svcart_flash_images_flash_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_flash_images_svcart_flash_images_flash_id ON svcart_flash_images USING btree (flash_id);


--
-- Name: svcart_flash_images_svcart_flash_images_locale; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_flash_images_svcart_flash_images_locale ON svcart_flash_images USING btree (locale);


--
-- Name: svcart_flash_images_svcart_flash_images_locale_2; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_flash_images_svcart_flash_images_locale_2 ON svcart_flash_images USING btree (locale, flash_id);


--
-- Name: svcart_flash_images_svcart_flash_images_status; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_flash_images_svcart_flash_images_status ON svcart_flash_images USING btree (status);


--
-- Name: svcart_flashes_svcart_flashes_type; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_flashes_svcart_flashes_type ON svcart_flashes USING btree (type, type_id);


--
-- Name: svcart_languages_svcart_languages_backend; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_languages_svcart_languages_backend ON svcart_languages USING btree (backend);


--
-- Name: svcart_languages_svcart_languages_front; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_languages_svcart_languages_front ON svcart_languages USING btree (front);


--
-- Name: svcart_link_i18ns_svcart_link_i18ns_description; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_link_i18ns_svcart_link_i18ns_description ON svcart_link_i18ns USING btree (description);


--
-- Name: svcart_link_i18ns_svcart_link_i18ns_name; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_link_i18ns_svcart_link_i18ns_name ON svcart_link_i18ns USING btree (name);


--
-- Name: svcart_links_svcart_links_status; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_links_svcart_links_status ON svcart_links USING btree (status);


--
-- Name: svcart_mail_templates_svcart_mail_templates_status; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_mail_templates_svcart_mail_templates_status ON svcart_mail_templates USING btree (status);


--
-- Name: svcart_navigation_i18ns_svcart_navigation_i18ns_locale; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_navigation_i18ns_svcart_navigation_i18ns_locale ON svcart_navigation_i18ns USING btree (locale);


--
-- Name: svcart_navigations_svcart_navigations_type; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_navigations_svcart_navigations_type ON svcart_navigations USING btree (type, status);


--
-- Name: svcart_operator_action_i18ns_svcart_operator_action_i18ns_local; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_operator_action_i18ns_svcart_operator_action_i18ns_local ON svcart_operator_action_i18ns USING btree (locale);


--
-- Name: svcart_operator_actions_svcart_operator_actions_level; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_operator_actions_svcart_operator_actions_level ON svcart_operator_actions USING btree (level);


--
-- Name: svcart_operator_actions_svcart_operator_actions_parent_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_operator_actions_svcart_operator_actions_parent_id ON svcart_operator_actions USING btree (parent_id);


--
-- Name: svcart_operator_actions_svcart_operator_actions_status; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_operator_actions_svcart_operator_actions_status ON svcart_operator_actions USING btree (status);


--
-- Name: svcart_operator_logs_svcart_operator_logs_admin_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_operator_logs_svcart_operator_logs_admin_id ON svcart_operator_logs USING btree (operator_id);


--
-- Name: svcart_operator_menus_svcart_operator_menus_parent_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_operator_menus_svcart_operator_menus_parent_id ON svcart_operator_menus USING btree (parent_id);


--
-- Name: svcart_operator_menus_svcart_operator_menus_status; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_operator_menus_svcart_operator_menus_status ON svcart_operator_menus USING btree (status);


--
-- Name: svcart_operator_role_i18ns_svcart_operator_role_i18ns_locale; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_operator_role_i18ns_svcart_operator_role_i18ns_locale ON svcart_operator_role_i18ns USING btree (locale);


--
-- Name: svcart_operator_roles_svcart_operator_roles_store_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_operator_roles_svcart_operator_roles_store_id ON svcart_operator_roles USING btree (store_id);


--
-- Name: svcart_operators_svcart_operators_status; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_operators_svcart_operators_status ON svcart_operators USING btree (status);


--
-- Name: svcart_operators_svcart_operators_store_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_operators_svcart_operators_store_id ON svcart_operators USING btree (store_id);


--
-- Name: svcart_order_actions_svcart_order_actions_order_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_order_actions_svcart_order_actions_order_id ON svcart_order_actions USING btree (order_id);


--
-- Name: svcart_order_cards_svcart_order_cards_card_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_order_cards_svcart_order_cards_card_id ON svcart_order_cards USING btree (card_id);


--
-- Name: svcart_order_cards_svcart_order_cards_order_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_order_cards_svcart_order_cards_order_id ON svcart_order_cards USING btree (order_id);


--
-- Name: svcart_order_packagings_svcart_order_packagings_order_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_order_packagings_svcart_order_packagings_order_id ON svcart_order_packagings USING btree (order_id);


--
-- Name: svcart_order_packagings_svcart_order_packagings_packaging_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_order_packagings_svcart_order_packagings_packaging_id ON svcart_order_packagings USING btree (packaging_id);


--
-- Name: svcart_order_products_svcart_order_products_order_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_order_products_svcart_order_products_order_id ON svcart_order_products USING btree (order_id);


--
-- Name: svcart_order_products_svcart_order_products_product_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_order_products_svcart_order_products_product_id ON svcart_order_products USING btree (product_id);


--
-- Name: svcart_orders_svcart_orders_user_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_orders_svcart_orders_user_id ON svcart_orders USING btree (user_id);


--
-- Name: svcart_packaging_i18ns_svcart_packaging_i18ns_description; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_packaging_i18ns_svcart_packaging_i18ns_description ON svcart_packaging_i18ns USING btree (description);


--
-- Name: svcart_packaging_i18ns_svcart_packaging_i18ns_name; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_packaging_i18ns_svcart_packaging_i18ns_name ON svcart_packaging_i18ns USING btree (name);


--
-- Name: svcart_packagings_svcart_packagings_status; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_packagings_svcart_packagings_status ON svcart_packagings USING btree (status);


--
-- Name: svcart_payment_api_logs_svcart_payment_api_logs_payment_code; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_payment_api_logs_svcart_payment_api_logs_payment_code ON svcart_payment_api_logs USING btree (payment_code);


--
-- Name: svcart_payment_api_logs_svcart_payment_api_logs_type; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_payment_api_logs_svcart_payment_api_logs_type ON svcart_payment_api_logs USING btree (type);


--
-- Name: svcart_payment_i18ns_svcart_payment_i18ns_status; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_payment_i18ns_svcart_payment_i18ns_status ON svcart_payment_i18ns USING btree (status);


--
-- Name: svcart_payments_svcart_payments_store_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_payments_svcart_payments_store_id ON svcart_payments USING btree (store_id);


--
-- Name: svcart_product_articles_svcart_product_articles_article_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_product_articles_svcart_product_articles_article_id ON svcart_product_articles USING btree (article_id);


--
-- Name: svcart_product_articles_svcart_product_articles_product_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_product_articles_svcart_product_articles_product_id ON svcart_product_articles USING btree (product_id);


--
-- Name: svcart_product_attributes_svcart_product_attributes_attr_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_product_attributes_svcart_product_attributes_attr_id ON svcart_product_attributes USING btree (product_type_attribute_id);


--
-- Name: svcart_product_attributes_svcart_product_attributes_goods_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_product_attributes_svcart_product_attributes_goods_id ON svcart_product_attributes USING btree (product_id);


--
-- Name: svcart_product_galleries_svcart_product_galleries_product_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_product_galleries_svcart_product_galleries_product_id ON svcart_product_galleries USING btree (product_id, status);


--
-- Name: svcart_product_i18ns_svcart_product_i18ns_description; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_product_i18ns_svcart_product_i18ns_description ON svcart_product_i18ns USING btree (description);


--
-- Name: svcart_product_i18ns_svcart_product_i18ns_locale; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_product_i18ns_svcart_product_i18ns_locale ON svcart_product_i18ns USING btree (locale);


--
-- Name: svcart_product_i18ns_svcart_product_i18ns_name; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_product_i18ns_svcart_product_i18ns_name ON svcart_product_i18ns USING btree (name);


--
-- Name: svcart_product_ranks_svcart_product_ranks_product_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_product_ranks_svcart_product_ranks_product_id ON svcart_product_ranks USING btree (product_id);


--
-- Name: svcart_product_ranks_svcart_product_ranks_rank_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_product_ranks_svcart_product_ranks_rank_id ON svcart_product_ranks USING btree (rank_id);


--
-- Name: svcart_product_relations_svcart_product_relations_product_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_product_relations_svcart_product_relations_product_id ON svcart_product_relations USING btree (product_id);


--
-- Name: svcart_product_type_attributes_svcart_product_type_attributes_c; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_product_type_attributes_svcart_product_type_attributes_c ON svcart_product_type_attributes USING btree (status);


--
-- Name: svcart_product_types_svcart_product_types_cat_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_product_types_svcart_product_types_cat_id ON svcart_product_types USING btree (status);


--
-- Name: svcart_products_categories_svcart_products_categories_category_; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_products_categories_svcart_products_categories_category_ ON svcart_products_categories USING btree (category_id);


--
-- Name: svcart_products_categories_svcart_products_categories_product_i; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_products_categories_svcart_products_categories_product_i ON svcart_products_categories USING btree (product_id);


--
-- Name: svcart_products_svcart_products_brand_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_products_svcart_products_brand_id ON svcart_products USING btree (brand_id);


--
-- Name: svcart_products_svcart_products_category_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_products_svcart_products_category_id ON svcart_products USING btree (category_id);


--
-- Name: svcart_products_svcart_products_forsale; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_products_svcart_products_forsale ON svcart_products USING btree (forsale);


--
-- Name: svcart_products_svcart_products_provider_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_products_svcart_products_provider_id ON svcart_products USING btree (provider_id);


--
-- Name: svcart_products_svcart_products_recommand_flag; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_products_svcart_products_recommand_flag ON svcart_products USING btree (recommand_flag);


--
-- Name: svcart_products_svcart_products_status; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_products_svcart_products_status ON svcart_products USING btree (status);


--
-- Name: svcart_promotion_i18ns_svcart_promotion_i18ns_locale; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_promotion_i18ns_svcart_promotion_i18ns_locale ON svcart_promotion_i18ns USING btree (locale);


--
-- Name: svcart_promotion_i18ns_svcart_promotion_i18ns_title; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_promotion_i18ns_svcart_promotion_i18ns_title ON svcart_promotion_i18ns USING btree (title);


--
-- Name: svcart_promotion_products_svcart_promotion_products_store_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_promotion_products_svcart_promotion_products_store_id ON svcart_promotion_products USING btree (store_id);


--
-- Name: svcart_promotions_svcart_promotions_store_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_promotions_svcart_promotions_store_id ON svcart_promotions USING btree (store_id);


--
-- Name: svcart_promotions_svcart_promotions_type; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_promotions_svcart_promotions_type ON svcart_promotions USING btree (type);


--
-- Name: svcart_providers_svcart_providers_status; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_providers_svcart_providers_status ON svcart_providers USING btree (status);


--
-- Name: svcart_providers_svcart_providers_store_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_providers_svcart_providers_store_id ON svcart_providers USING btree (store_id);


--
-- Name: svcart_region_i18ns_svcart_region_i18ns_locale; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_region_i18ns_svcart_region_i18ns_locale ON svcart_region_i18ns USING btree (locale);


--
-- Name: svcart_regions_svcart_regions_agency_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_regions_svcart_regions_agency_id ON svcart_regions USING btree (agency_id);


--
-- Name: svcart_regions_svcart_regions_level; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_regions_svcart_regions_level ON svcart_regions USING btree (level);


--
-- Name: svcart_regions_svcart_regions_parent_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_regions_svcart_regions_parent_id ON svcart_regions USING btree (parent_id);


--
-- Name: svcart_shipping_area_regions_svcart_shipping_area_regions_shipp; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_shipping_area_regions_svcart_shipping_area_regions_shipp ON svcart_shipping_area_regions USING btree (shipping_area_id);


--
-- Name: svcart_shipping_areas_svcart_shipping_areas_shipping_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_shipping_areas_svcart_shipping_areas_shipping_id ON svcart_shipping_areas USING btree (shipping_id);


--
-- Name: svcart_shipping_areas_svcart_shipping_areas_store_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_shipping_areas_svcart_shipping_areas_store_id ON svcart_shipping_areas USING btree (store_id);


--
-- Name: svcart_shipping_i18ns_svcart_shipping_i18ns_locale; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_shipping_i18ns_svcart_shipping_i18ns_locale ON svcart_shipping_i18ns USING btree (locale, shipping_id);


--
-- Name: svcart_shippings_svcart_shippings_store_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_shippings_svcart_shippings_store_id ON svcart_shippings USING btree (store_id);


--
-- Name: svcart_store_i18ns_svcart_store_i18ns_locale; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_store_i18ns_svcart_store_i18ns_locale ON svcart_store_i18ns USING btree (locale);


--
-- Name: svcart_store_i18ns_svcart_store_i18ns_locale_2; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_store_i18ns_svcart_store_i18ns_locale_2 ON svcart_store_i18ns USING btree (locale, store_id);


--
-- Name: svcart_store_products_svcart_store_products_product_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_store_products_svcart_store_products_product_id ON svcart_store_products USING btree (product_id);


--
-- Name: svcart_store_products_svcart_store_products_store_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_store_products_svcart_store_products_store_id ON svcart_store_products USING btree (store_id);


--
-- Name: svcart_stores_svcart_stores_status; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_stores_svcart_stores_status ON svcart_stores USING btree (status);


--
-- Name: svcart_topic_i18ns_svcart_topic_i18ns_locale; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_topic_i18ns_svcart_topic_i18ns_locale ON svcart_topic_i18ns USING btree (locale);


--
-- Name: svcart_topic_products_svcart_topic_products_store_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_topic_products_svcart_topic_products_store_id ON svcart_topic_products USING btree (store_id);


--
-- Name: svcart_topic_products_svcart_topic_products_store_id_3; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_topic_products_svcart_topic_products_store_id_3 ON svcart_topic_products USING btree (store_id, topic_id);


--
-- Name: svcart_topic_products_svcart_topic_products_topic_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_topic_products_svcart_topic_products_topic_id ON svcart_topic_products USING btree (topic_id);


--
-- Name: svcart_topics_svcart_topics_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_topics_svcart_topics_id ON svcart_topics USING btree (id);


--
-- Name: svcart_user_accounts_svcart_user_accounts_user_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_user_accounts_svcart_user_accounts_user_id ON svcart_user_accounts USING btree (user_id);


--
-- Name: svcart_user_addresses_svcart_user_addresses_user_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_user_addresses_svcart_user_addresses_user_id ON svcart_user_addresses USING btree (user_id);


--
-- Name: svcart_user_balance_logs_svcart_user_balance_logs_user_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_user_balance_logs_svcart_user_balance_logs_user_id ON svcart_user_balance_logs USING btree (user_id);


--
-- Name: svcart_user_config_i18ns_svcart_user_config_i18ns_locale; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_user_config_i18ns_svcart_user_config_i18ns_locale ON svcart_user_config_i18ns USING btree (locale);


--
-- Name: svcart_user_configs_svcart_user_configs_user_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_user_configs_svcart_user_configs_user_id ON svcart_user_configs USING btree (user_id);


--
-- Name: svcart_user_configs_svcart_user_configs_user_rank; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_user_configs_svcart_user_configs_user_rank ON svcart_user_configs USING btree (user_rank);


--
-- Name: svcart_user_favorites_svcart_user_favorites_type; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_user_favorites_svcart_user_favorites_type ON svcart_user_favorites USING btree (type);


--
-- Name: svcart_user_favorites_svcart_user_favorites_type_2; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_user_favorites_svcart_user_favorites_type_2 ON svcart_user_favorites USING btree (type, type_id);


--
-- Name: svcart_user_friends_svcart_user_friends_user_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_user_friends_svcart_user_friends_user_id ON svcart_user_friends USING btree (user_id);


--
-- Name: svcart_user_info_i18ns_svcart_user_info_i18ns_locale; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_user_info_i18ns_svcart_user_info_i18ns_locale ON svcart_user_info_i18ns USING btree (locale);


--
-- Name: svcart_user_info_values_svcart_user_info_values_user_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_user_info_values_svcart_user_info_values_user_id ON svcart_user_info_values USING btree (user_id);


--
-- Name: svcart_user_infos_svcart_user_infos_type; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_user_infos_svcart_user_infos_type ON svcart_user_infos USING btree (type);


--
-- Name: svcart_user_messages_svcart_user_messages_user_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_user_messages_svcart_user_messages_user_id ON svcart_user_messages USING btree (user_id);


--
-- Name: svcart_user_point_logs_svcart_user_point_logs_user_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_user_point_logs_svcart_user_point_logs_user_id ON svcart_user_point_logs USING btree (user_id);


--
-- Name: svcart_user_rank_i18ns_svcart_user_rank_i18ns_locale; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_user_rank_i18ns_svcart_user_rank_i18ns_locale ON svcart_user_rank_i18ns USING btree (locale);


--
-- Name: svcart_user_rank_i18ns_svcart_user_rank_i18ns_user_rank_id; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_user_rank_i18ns_svcart_user_rank_i18ns_user_rank_id ON svcart_user_rank_i18ns USING btree (user_rank_id);


--
-- Name: svcart_users_svcart_users_status; Type: INDEX; Schema: public; Owner: seevia; Tablespace: 
--

CREATE INDEX svcart_users_svcart_users_status ON svcart_users USING btree (status);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--


ALTER SEQUENCE svcart_articles_id_seq RESTART WITH 6;

ALTER SEQUENCE svcart_article_categories_id_seq RESTART WITH 5;

ALTER SEQUENCE svcart_article_i18ns_id_seq RESTART WITH 9;

ALTER SEQUENCE svcart_categories_id_seq RESTART WITH 4;

ALTER SEQUENCE svcart_category_i18ns_id_seq RESTART WITH 7;

ALTER SEQUENCE svcart_configs_id_seq RESTART WITH 428;

ALTER SEQUENCE svcart_config_i18ns_id_seq RESTART WITH 309;

ALTER SEQUENCE svcart_flashes_id_seq RESTART WITH 2;

ALTER SEQUENCE svcart_flash_images_id_seq RESTART WITH 3;

ALTER SEQUENCE svcart_languages_id_seq RESTART WITH 3;

ALTER SEQUENCE svcart_language_dictionaries_id_seq RESTART WITH 903;

ALTER SEQUENCE svcart_links_id_seq RESTART WITH 86;

ALTER SEQUENCE svcart_link_i18ns_id_seq RESTART WITH 3;

ALTER SEQUENCE svcart_mail_templates_id_seq RESTART WITH 43;

ALTER SEQUENCE svcart_mail_template_i18ns_id_seq RESTART WITH 21;

ALTER SEQUENCE svcart_navigations_id_seq RESTART WITH 9;

ALTER SEQUENCE svcart_navigation_i18ns_id_seq RESTART WITH 13;

ALTER SEQUENCE svcart_operator_actions_id_seq RESTART WITH 194;

ALTER SEQUENCE svcart_operator_action_i18ns_id_seq RESTART WITH 972;

ALTER SEQUENCE svcart_operator_menu_i18ns_id_seq RESTART WITH 129;

ALTER SEQUENCE svcart_payments_id_seq RESTART WITH 10;

ALTER SEQUENCE svcart_payment_i18ns_id_seq RESTART WITH 15;

ALTER SEQUENCE svcart_regions_id_seq RESTART WITH 426;

ALTER SEQUENCE svcart_region_i18ns_id_seq RESTART WITH 839;

ALTER SEQUENCE svcart_shippings_id_seq RESTART WITH 3;

ALTER SEQUENCE svcart_shipping_i18ns_id_seq RESTART WITH 5;

ALTER SEQUENCE svcart_templates_id_seq RESTART WITH 2;



ALTER SEQUENCE svcart_brands_id_seq RESTART WITH 2;

ALTER SEQUENCE svcart_brand_i18ns_id_seq RESTART WITH 3;

ALTER SEQUENCE svcart_categories_id_seq RESTART WITH 2;

ALTER SEQUENCE svcart_products_id_seq RESTART WITH 11;

ALTER SEQUENCE svcart_product_galleries_id_seq RESTART WITH 11;

ALTER SEQUENCE svcart_product_i18ns_id_seq RESTART WITH 21;

ALTER SEQUENCE svcart_shipping_areas_id_seq RESTART WITH 1002;

ALTER SEQUENCE svcart_shipping_area_i18ns_id_seq RESTART WITH 5;

ALTER SEQUENCE svcart_shipping_area_regions_id_seq RESTART WITH 3;






