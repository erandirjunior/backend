CREATE DATABASE IF NOT EXISTS restaurant;

use restaurant;

CREATE TABLE IF NOT EXISTS client
(
    id         INT AUTO_INCREMENT
        PRIMARY KEY,
    name       VARCHAR(255)                       NOT NULL,
    identifier VARCHAR(14)                        NOT NULL,
    type       ENUM ('1', '2')                    NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP NULL,
    updated_at DATETIME                           NULL,
    deleted_at DATETIME                           NULL
);

CREATE TABLE IF NOT EXISTS contact
(
    id         INT AUTO_INCREMENT
        PRIMARY KEY,
    client_id  INT                                NOT NULL,
    type       ENUM ('1', '2', '3')               NOT NULL COMMENT '1 - telefone 2 - e-mail 3 - celular',
    contact    VARCHAR(255)                       NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP NULL,
    updated_at DATETIME                           NULL,
    deleted_at DATETIME                           NULL,
    CONSTRAINT contact_client_id_fk
        FOREIGN KEY (client_id) REFERENCES client (id)
);