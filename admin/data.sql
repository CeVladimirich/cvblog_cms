--
-- By CeVladimirich
-- CeBlog CMS, https://github.com/CeVladimirich/cvblog_cms
--
CREATE TABLE posts (
    id int NOT NULL AUTO_INCREMENT,
    date timestamp,
    topicid int,
    postflag int DEFAULT 2,
    title text,
    author text,
    post text,
    url text,
    description text,
    PRIMARY KEY(id)
);
CREATE TABLE config (
    id int NOT NULL AUTO_INCREMENT,
    index_tpc int,
    PRIMARY KEY(id)
);
CREATE TABLE topics (
    id int NOT NULL AUTO_INCREMENT,
    topic text, position int,
    one_page bool,
    PRIMARY KEY (id)
);
CREATE TABLE comments (
    id int NOT NULL AUTO_INCREMENT,
    date timestamp,
    post_id int,
    flag int default 1,
    author text,
    text text, PRIMARY KEY(id)
);
CREATE TABLE admins
(
    id       int NOT NULL AUTO_INCREMENT,
    login    text,
    password text,
    status   int,
    PRIMARY KEY (id)
);
INSERT INTO config (index_tpc) VALUES (1);
INSERT INTO topics (topic, position) VALUES ('статьи', 0), ('заметки', 1), ('новости', 2), ('обо мне', 3);
INSERT INTO admins (login, password, status) VALUES ('admin_cvblog', '21232f297a57a5a743894a0e4a801fc3', 1);