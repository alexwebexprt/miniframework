<?php
return array(
    'class'=>"\\component\\DbSqlite",
    'path'=> dirname(__DIR__).DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR."site.db",
    'sql'=>[
        "CREATE TABLE IF NOT EXISTS users ( 
            id        integer PRIMARY KEY AUTOINCREMENT,
            email     varchar(255) NOT NULL UNIQUE,
            password  varchar(100),
            name      varchar(255),
            status    integer DEFAULT 0,
            token     varchar(255) UNIQUE,
            code      varchar(50)
        )
        ",
        "CREATE INDEX IF NOT EXISTS users_index_status   ON users  (status)",
        "CREATE UNIQUE INDEX IF NOT EXISTS users_index_token  ON users  (token)",
    ]
);