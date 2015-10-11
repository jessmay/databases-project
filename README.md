# databases-project
---
### Notes
- I get an warning / error about date()
  - Set the timezone in your php.ini (e.g. to "UTC")

- I can't connect to the database
  - Install MySQL Community Server (e.g. http://dev.mysql.com/downloads/file.php?id=459309)
    - Just the MySQL Server and the MySQL Workbench are required
  - Set up a database user with username 'db_user' and password 'db_user_password'
  - Create a database with name 'database_project_db'
  - Import create_tables.sql
  - Rename php.ini-production to php.ini (if you do not have a php.ini)
  - In php.ini, uncomment the following lines (remove the leading semicolon):
    - extension_dir = "ext"
    - extension=php_pdo_mysql.dll