DROP TABLE IF EXISTS divisions;
CREATE TABLE divisions (
  division bigint(12),
  yHeaven int(2),
  yZodiac int(2),
  mHeaven int(2),
  mZodiac int(2)
);
LOAD DATA LOCAL INFILE '/docker-entrypoint-initdb.d/divis.csv'
INTO TABLE divisions
FIELDS TERMINATED BY ',';
