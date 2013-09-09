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
		PRIMARY KEY (key)
	);
";

$statement = "
	INSERT INTO users (key, name, full_name, password_hash, acl_role) values ('deadbeef-7a69-40e7-8984-8d3de3bedc0b', 'SYSTEM_SYSTEM', 'System Account', 'SYSTEM_SYSTEM', 'system');
";

$statement = "
	INSERT INTO users (key, name, full_name, password_hash, acl_role) values ('feedface-ad3e-4cc6-bd9c-501224e24359', 'SYSTEM_SIGNUP', 'System Signup Account', 'SYSTEM_SIGNUP', 'system');
";

$statement = "
	ALTER TABLE users ADD COLUMN created_by uuid REFERENCES users(key);
";

$statement = "
	UPDATE users SET created_by = 'deadbeef-7a69-40e7-8984-8d3de3bedc0b' WHERE acl_role = 'system';
";

$statement = "
	ALTER TABLE users ALTER COLUMN created_by SET NOT NULL;
";

$statement = "
	ALTER TABLE users ADD COLUMN updated_by uuid REFERENCES users(key);
";

$statement = "
	UPDATE users SET updated_by = 'deadbeef-7a69-40e7-8984-8d3de3bedc0b' WHERE acl_role = 'system';
";

$statement = "
	ALTER TABLE users ALTER COLUMN updated_by SET NOT NULL;
";

$statement = "
	CREATE TABLE account_plans (
		key uuid NOT NULL default uuid_generate_v4(),
		name varchar NOT NULL,
		created timestamp NOT NULL default now(),
		updated timestamp NOT NULL default now(),
		created_by uuid NOT NULL REFERENCES users(key),
		updated_by uuid NOT NULL REFERENCES users(key),
		PRIMARY KEY (key)
	);
";

$statement = "
	INSERT into account_plans (key, name, created_by, updated_by) VALUES ('000afe2f-d65d-4da4-9396-9b086cfa64d3', 'Free', 'deadbeef-7a69-40e7-8984-8d3de3bedc0b', 'deadbeef-7a69-40e7-8984-8d3de3bedc0b');
";

$statement = "
	CREATE TABLE accounts (
		key uuid NOT NULL default uuid_generate_v4(),
		name varchar NOT NULL,
		created timestamp NOT NULL default now(),
		updated timestamp NOT NULL default now(),
		created_by uuid NOT NULL REFERENCES users(key),
		updated_by uuid NOT NULL REFERENCES users(key),
		account_plan_key uuid NOT NULL REFERENCES account_plans(key),
		PRIMARY KEY (key)
	);
";

$statement = "
	ALTER TABLE users ADD COLUMN account_key uuid REFERENCES accounts(key);
";
