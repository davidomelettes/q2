<?php

$statement = "
	CREATE TABLE locales (
		code varchar PRIMARY KEY,
		name varchar NOT NULL,
		date_format varchar NOT NULL,
	);
";

$statement = "
	CREATE TABLE locale_date_format (
		locale_code varchar PRIMARY KEY REFERENCES locales(code),
		date_format varchar NOT NULL
	);
";

$statement = "INSERT INTO locales (code, name, date_format) VALUES ('en-GB', 'English - United Kingdom', 'd/m/Y');";
$statement = "INSERT INTO locales (code, name, date_format) VALUES ('en-US', 'English - United States', 'm/d/Y');";

$statment = "INSERT INTO user_preference_defaults (name, default_varchar) VALUES ('locale', 'en-GB')";
