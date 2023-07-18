CREATE USER 'codybrains_andy'@'localhost' IDENTIFIED BY '1234';
create database codybrains_andy;
GRANT ALL PRIVILEGES ON codybrains_andy.* TO 'codybrains_andy'@'localhost';
ALTER USER 'codybrains_andy'@'localhost' IDENTIFIED WITH mysql_native_password BY '1234';


create or replace view v_employee as
select
    e.*, g.name gender, j.name job
from employee e
         join gender g on e.gender_id = g.id
         join job j on e.job_id = j.id;