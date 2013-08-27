<?php

$statement = "CREATE EXTENSION uuid-ossp";
$statement = "CREATE EXTENSION pgcrypto";

$statement = "CREATE OR REPLACE FUNCTION sha256(text) returns text AS $$
	SELECT encode(digest($1, 'sha256'), 'hex')
	$$ LANGUAGE SQL STRICT IMMUTABLE";

$statement = "
	CREATE TABLE sessions (
		id char(32),
		name char(32),
		modified int,
		lifetime int,
		data text,
		primary key (id, name)
	);
";

$statement = "
	CREATE TABLE schemas (
		key uuid NOT NULL default uuid_generate_v4(),
		version varchar NOT NULL,
		name varchar NOT NULL,
		created timestamp NOT NULL default now(),
		updated timestamp NOT NULL default now(),
		PRIMARY KEY (key)
	);
";

$statement = "
	CREATE TABLE account_plans (
		key uuid NOT NULL default uuid_generate_v4(),
		name varchar NOT NULL,
		created timestamp NOT NULL default now(),
		updated timestamp NOT NULL default now(),
		PRIMARY KEY (key)
	);
";

$statement = "
	INSERT into account_plans (key, name) VALUES ('', 'Free');
";

$statement = "
	CREATE TABLE accounts (
		key uuid NOT NULL default uuid_generate_v4(),
		PRIMARY KEY (key)
	);
";

$statement = "
	CREATE TABLE users (
		key uuid NOT NULL default uuid_generate_v4(),
		name varchar NOT NULL,
		full_name varchar NOT NULL,
		password_hash varchar NOT NULL,
		salt varchar NOT NULL default uuid_generate_v4(),
		enabled boolean NOT NULL default true,
		admin boolean NOT NULL default true,
		created timestamp NOT NULL default now(),
		updated timestamp NOT NULL default now(),
		acl_role varchar NOT NULL default 'user',
		account_key uuid REFERENCES accounts(key),
		PRIMARY KEY (key)
	);
";

$statement = "
	INSERT INTO users (key, name, full_name, password_hash, acl_role) values ('', 'SYSTEM_SIGNUP', '', '', 'system');
";

