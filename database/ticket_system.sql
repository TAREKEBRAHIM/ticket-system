CREATE DATABASE IF NOT EXISTS ticket_system
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE ticket_system;


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created DATETIME NULL,
    modified DATETIME NULL
);


CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created DATETIME NULL,
    modified DATETIME NULL
);


INSERT INTO projects (name, created, modified) VALUES
('Website Project', NOW(), NOW()),
('Mobile Application', NOW(), NOW()),
('Internal System', NOW(), NOW());


CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NULL,
    subject VARCHAR(255) NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    priority VARCHAR(20) NOT NULL,
    status VARCHAR(30) NOT NULL,
    attachment VARCHAR(255) NULL,
    created DATETIME NULL,
    modified DATETIME NULL,

    CONSTRAINT fk_tickets_project
        FOREIGN KEY (project_id)
        REFERENCES projects(id)
        ON DELETE SET NULL
);


CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT NOT NULL,
    note TEXT NOT NULL,
    created DATETIME NULL,
    modified DATETIME NULL,

    CONSTRAINT fk_notes_ticket
        FOREIGN KEY (ticket_id)
        REFERENCES tickets(id)
        ON DELETE CASCADE
);