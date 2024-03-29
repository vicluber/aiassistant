CREATE TABLE tx_aiassistant_domain_model_message (
	user_prompt text NOT NULL DEFAULT '',
	assistant_answer text NOT NULL DEFAULT '',
	file_citation text NOT NULL DEFAULT '',
	thread varchar(255) NOT NULL DEFAULT '',
	prompt_tokens int(11) NOT NULL DEFAULT '0',
	completion_tokens int(11) NOT NULL DEFAULT '0',
	file_id varchar(255) NOT NULL DEFAULT '',
	assistant int(11) unsigned DEFAULT '0'
);

CREATE TABLE tx_aiassistant_domain_model_assistant (
	assistant_id varchar(255) NOT NULL DEFAULT '',
	name varchar(255) NOT NULL DEFAULT '',
	instructions LONGTEXT NOT NULL,
	model varchar(255) NOT NULL DEFAULT '',
	retrieval TINYINT(1) NOT NULL DEFAULT 0
);

CREATE TABLE tx_aiassistant_domain_model_files (
	file_id varchar(255) NOT NULL DEFAULT '',
	assistant int(11) unsigned DEFAULT '0'
);
