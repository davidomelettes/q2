<?php

$statement = "CREATE EXTENSION uuid-ossp";
$statement = "CREATE EXTENSION pgcrypto";

$statement = "CREATE OR REPLACE FUNCTION sha256(bytea) returns text AS $$
	SELECT encode(digest($1, 'sha256'), 'hex')
	$$ LANGUAGE SQL STRICT IMMUTABLE";
$statement = "CREATE OR REPLACE FUNCTION sha256(text) returns text AS $$
	SELECT encode(digest($1, 'sha256'), 'hex')
	$$ LANGUAGE SQL STRICT IMMUTABLE";

$statement = "
	CREATE TABLE schemas (
		key uuid NOT NULL default uuid_generate_v4(),
		version varchar NOT NULL,
		name varchar NOT NULL
	);
";

$statement = "
	CREATE TABLE users (
		key uuid NOT NULL default uuid_generate_v4(),
		username varchar NOT NULL,
		password_hash varchar NOT NULL,
		salt varchar NOT NULL default uuid_generate_v4(),
		enabled boolean NOT NULL default true
	);
";

