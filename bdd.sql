-- USER & DATABASE CREDENTIALS

-- CREATE USER 'codybrains_andy'@'localhost' IDENTIFIED BY '1234';
-- create database codybrains_andy;
-- GRANT ALL PRIVILEGES ON codybrains_andy.* TO 'codybrains_andy'@'localhost';
-- ALTER USER 'codybrains_andy'@'localhost' IDENTIFIED WITH mysql_native_password BY '1234';



CREATE TABLE gender (
                        id                   INT  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
                        name                 VARCHAR(50)  NOT NULL    ,
                        CONSTRAINT idx_gender UNIQUE ( name )
);

CREATE TABLE job (
                     id                   INT  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
                     name                 VARCHAR(100)  NOT NULL    ,
                     CONSTRAINT idx_job UNIQUE ( name )
);

CREATE TABLE employee (
                          id                   INT  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
                          first_name           VARCHAR(250)  NOT NULL    ,
                          last_name            VARCHAR(250)  NOT NULL    ,
                          hiring_date          DATE  NOT NULL DEFAULT (curdate())   ,
                          gender_id            INT  NOT NULL    ,
                          job_id               INT  NOT NULL    ,
                          email                VARCHAR(250)  NOT NULL    ,
                          access_code          VARCHAR(250)  NOT NULL    ,
                          registration_number  VARCHAR(250)  NOT NULL    ,
                          is_active            BOOLEAN  NOT NULL DEFAULT (true)   ,
                          modification_date    DATETIME  NOT NULL DEFAULT (now())   ,
                          CONSTRAINT unq_employee UNIQUE ( registration_number )
);

CREATE INDEX fk_employee_gender ON employee ( gender_id );

CREATE INDEX fk_employee_job ON employee ( job_id );

ALTER TABLE employee ADD CONSTRAINT fk_employee_gender FOREIGN KEY ( gender_id ) REFERENCES gender( id ) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE employee ADD CONSTRAINT fk_employee_job FOREIGN KEY ( job_id ) REFERENCES job( id ) ON DELETE RESTRICT ON UPDATE RESTRICT;



create or replace view v_employee as
select
    e.*, g.name gender, j.name job
from employee e
         join gender g on e.gender_id = g.id
         join job j on e.job_id = j.id;


INSERT INTO gender(name) values
('Male'),
('Female'),
('Other');

INSERT INTO job(name) values ('Admin');
UPDATE job SET id = 0;

INSERT INTO employee(first_name, last_name, gender_id, job_id, email, access_code, registration_number) values
('Andy', 'Garcia', 1, 0, 'admin@gmail.com', '123456', 'EMP0000001');