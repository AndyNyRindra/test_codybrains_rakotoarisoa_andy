CREATE USER 'codybrains_andy'@'localhost' IDENTIFIED BY '1234';
create database codybrains_andy;
GRANT ALL PRIVILEGES ON codybrains_andy.* TO 'codybrains_andy'@'localhost';
ALTER USER 'codybrains_andy'@'localhost' IDENTIFIED WITH mysql_native_password BY '1234';