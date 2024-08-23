# SQL Commands to use

## To create the database

```sql 
CREATE DATABASE contactsbook;
```

## To use any database

```sql
USE contactsbook;
```

## To create `user` table

```sql
CREATE TABLE user(
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(20) NOT NULL,
    last_name VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    is_admin ENUM("1","0") DEFAULT "0" NOT NULL,
    is_active ENUM("1", "0") DEFAULT "0" NOT NULL,
);
```

## To create `contacts` table

```sql
CREATE TABLE user(
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(20) NOT NULL,
    last_name VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL,
    photo VARCHAR(100) NOT NULL,
    status ENUM("1","0") DEFAULT "1" NOT NULL,
    owner_id NOT NULL,
);
```
