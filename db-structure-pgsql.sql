CREATE TABLE data (
  id bigserial PRIMARY KEY,
  ip bigint NOT NULL DEFAULT '0',
  port_id integer NOT NULL DEFAULT '0',
  scanned_ts timestamp,
  protocol char(3) NOT NULL DEFAULT '',
  state varchar(10) NOT NULL DEFAULT '',
  reason varchar(255) NOT NULL DEFAULT '',
  reason_ttl bigint NOT NULL DEFAULT '0',
  service varchar(100) NOT NULL DEFAULT '',
  banner text NOT NULL,
  title text NOT NULL
);
ALTER TABLE data ADD COLUMN searchtext TSVECTOR;