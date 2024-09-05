DROP TABLE IF EXISTS adm_project;
CREATE TABLE adm_project
(
    project_id        BIGINT AUTO_INCREMENT NOT NULL,
    name              VARCHAR(100)          NOT NULL,
    description       VARCHAR(250)          NOT NULL,
    start_date        DATE                  NOT NULL,
    estimate_end_date DATE                  NOT NULL,
    PRIMARY KEY (project_id)
);

DROP TABLE IF EXISTS project_task_status;
CREATE TABLE project_task_status
(
    project_task_status BIGINT AUTO_INCREMENT NOT NULL,
    name                VARCHAR(100)          NOT NULL,
    description         VARCHAR(250)          NOT NULL,
    end_status          BOOLEAN DEFAULT false NOT NULL,
    status_order        BIGINT                NOT NULL,
    PRIMARY KEY (project_task_status)
);

DROP TABLE IF EXISTS adm_permission;
CREATE TABLE adm_permission
(
    permission_id BIGINT AUTO_INCREMENT NOT NULL,
    action        VARCHAR(50)           NOT NULL,
    entity        VARCHAR(50)           NOT NULL,
    active        BOOLEAN DEFAULT true  NOT NULL,
    PRIMARY KEY (permission_id)
);

DROP TABLE IF EXISTS adm_role;
CREATE TABLE adm_role
(
    role_id     BIGINT AUTO_INCREMENT NOT NULL,
    name        VARCHAR(100)          NOT NULL,
    description VARCHAR(250)          NOT NULL,
    active      BOOLEAN DEFAULT true  NOT NULL,
    PRIMARY KEY (role_id)
);

DROP TABLE IF EXISTS adm_role_permission;
CREATE TABLE adm_role_permission
(
    role_id       BIGINT NOT NULL,
    permission_id BIGINT NOT NULL,
    PRIMARY KEY (role_id, permission_id)
);

DROP TABLE IF EXISTS adm_user;
CREATE TABLE adm_user
(
    user_id      BIGINT AUTO_INCREMENT NOT NULL,
    username     VARCHAR(50)           NOT NULL,
    password     VARCHAR(100)          NOT NULL,
    email        VARCHAR(150)          NOT NULL,
    first_name   VARCHAR(50)           NOT NULL,
    last_name    VARCHAR(50)           NOT NULL,
    birthday     DATE                  NOT NULL,
    phone_number VARCHAR(25)           NOT NULL,
    active       BOOLEAN DEFAULT true  NOT NULL,
    UNIQUE KEY (email),
    PRIMARY KEY (user_id)
);

DROP TABLE IF EXISTS adm_task;
CREATE TABLE adm_task
(
    task_id             BIGINT AUTO_INCREMENT NOT NULL,
    name                VARCHAR(100)          NOT NULL,
    description         TEXT                  NOT NULL,
    project_id          BIGINT                NOT NULL,
    assigned_user_id    BIGINT,
    parent_id           BIGINT,
    project_task_status BIGINT                NOT NULL,
    start_date          DATE,
    due_date            DATE,
    PRIMARY KEY (task_id)
);

DROP TABLE IF EXISTS time_tracking;
CREATE TABLE time_tracking
(
    time_tracking_id BIGINT AUTO_INCREMENT NOT NULL,
    time_tracked     BIGINT                NOT NULL,
    tacked_on        DATETIME              NOT NULL,
    user_id          BIGINT                NOT NULL,
    task_id          BIGINT                NOT NULL,
    PRIMARY KEY (time_tracking_id)
);

DROP TABLE IF EXISTS task_status_log;
CREATE TABLE task_status_log
(
    task_status_log_id BIGINT AUTO_INCREMENT NOT NULL,
    changed_on         DATETIME              NOT NULL,
    task_id            BIGINT                NOT NULL,
    previous_status_id BIGINT                NOT NULL,
    new_status_id      BIGINT                NOT NULL,
    PRIMARY KEY (task_status_log_id)
);

DROP TABLE IF EXISTS adm_project_user_role;
CREATE TABLE adm_project_user_role
(
    user_id    BIGINT NOT NULL,
    project_id BIGINT NOT NULL,
    role_id    BIGINT NOT NULL,
    PRIMARY KEY (user_id, project_id)
);


ALTER TABLE adm_task
    ADD CONSTRAINT adm_project_adm_task_fk
        FOREIGN KEY (project_id)
            REFERENCES adm_project (project_id)
            ON DELETE CASCADE
            ON UPDATE CASCADE;

ALTER TABLE adm_project_user_role
    ADD CONSTRAINT adm_project_adm_project_user_role_fk
        FOREIGN KEY (project_id)
            REFERENCES adm_project (project_id)
            ON DELETE CASCADE
            ON UPDATE NO ACTION;

ALTER TABLE adm_task
    ADD CONSTRAINT project_task_status_adm_task_fk
        FOREIGN KEY (project_task_status)
            REFERENCES project_task_status (project_task_status)
            ON DELETE RESTRICT
            ON UPDATE NO ACTION;

ALTER TABLE task_status_log
    ADD CONSTRAINT project_task_status_task_status_log_fk
        FOREIGN KEY (previous_status_id)
            REFERENCES project_task_status (project_task_status)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION;

ALTER TABLE task_status_log
    ADD CONSTRAINT project_task_status_task_status_log_fk1
        FOREIGN KEY (new_status_id)
            REFERENCES project_task_status (project_task_status)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION;

ALTER TABLE adm_role_permission
    ADD CONSTRAINT adm_permission_adm_role_permission_fk
        FOREIGN KEY (permission_id)
            REFERENCES adm_permission (permission_id)
            ON DELETE CASCADE
            ON UPDATE NO ACTION;

ALTER TABLE adm_role_permission
    ADD CONSTRAINT adm_role_adm_role_permission_fk
        FOREIGN KEY (role_id)
            REFERENCES adm_role (role_id)
            ON DELETE CASCADE
            ON UPDATE NO ACTION;

ALTER TABLE adm_project_user_role
    ADD CONSTRAINT adm_role_adm_project_user_role_fk
        FOREIGN KEY (role_id)
            REFERENCES adm_role (role_id)
            ON DELETE CASCADE
            ON UPDATE NO ACTION;

ALTER TABLE adm_project_user_role
    ADD CONSTRAINT adm_user_adm_project_user_role_fk
        FOREIGN KEY (user_id)
            REFERENCES adm_user (user_id)
            ON DELETE CASCADE
            ON UPDATE NO ACTION;

ALTER TABLE adm_task
    ADD CONSTRAINT adm_user_adm_task_fk
        FOREIGN KEY (assigned_user_id)
            REFERENCES adm_user (user_id)
            ON DELETE SET NULL
            ON UPDATE NO ACTION;

ALTER TABLE time_tracking
    ADD CONSTRAINT adm_user_time_tracking_fk
        FOREIGN KEY (user_id)
            REFERENCES adm_user (user_id)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION;

ALTER TABLE adm_task
    ADD CONSTRAINT adm_task_adm_task_fk
        FOREIGN KEY (parent_id)
            REFERENCES adm_task (task_id)
            ON DELETE SET NULL
            ON UPDATE NO ACTION;

ALTER TABLE task_status_log
    ADD CONSTRAINT adm_task_task_status_log_fk
        FOREIGN KEY (task_id)
            REFERENCES adm_task (task_id)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION;

ALTER TABLE time_tracking
    ADD CONSTRAINT adm_task_time_tracking_fk
        FOREIGN KEY (task_id)
            REFERENCES adm_task (task_id)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION;

INSERT INTO `adm_user` (`user_id`, `username`, `password`, `email`, `first_name`, `last_name`, `birthday`,
                        `phone_number`, `active`)
VALUES (1, 'achess', '$2y$10$/xhzocwOKjO7/GsSKMSN4OdU3cgQryZoE8nvgXxBnYTOx90VXd0me', 'jealtzo26@gmail.com', 'Alexander',
        'Tzoc', '2001-03-26', '47047359', 1),
       (2, 'achess2', '$2y$10$/xhzocwOKjO7/GsSKMSN4OdU3cgQryZoE8nvgXxBnYTOx90VXd0me', 'achess@gmail.com', 'Alexander2',
        'Tzoc', '2001-03-26', '47047359', 1);


INSERT INTO `adm_permission` (`permission_id`, `action`, `entity`, `active`)
VALUES (1, 'update', 'project', 1),
       (2, 'read', 'project', 1),
       (3, 'delete', 'project', 1),
       (4, 'create', 'task', 1),
       (5, 'update', 'task', 1),
       (6, 'read', 'task', 1),
       (7, 'delete', 'task', 1);

INSERT INTO `adm_project` (`project_id`, `name`, `description`, `start_date`, `estimate_end_date`)
VALUES (1, 'Practica 1 Teoria de Sistemas', 'Este es un ejemplo de proyecto que puede manejarse en el sistema',
        '2024-08-30', '2024-09-05'),
       (2, 'Proyecto generico 2', 'Este es un proyecto generico para probar el funcionamiento de los roles y permisos',
        '2024-08-14', '2024-10-16');


INSERT INTO `adm_role` (`role_id`, `name`, `description`, `active`)
VALUES (1, 'pm', 'Project Manager de un proyecto. Puede editar, leer y eliminar un proyecto', 1),
       (2, 'member',
        'El miembro de un proyecto puede ver el proyecto. También puede crear, editar, ver y eliminar tareas', 1),
       (3, 'viewer', 'Solo puede ver el proyecto y sus tareas', 1);


INSERT INTO `adm_project_user_role` (`user_id`, `project_id`, `role_id`)
VALUES (1, 1, 1),
       (1, 2, 2),
       (2, 1, 3),
       (2, 2, 1);


INSERT INTO `adm_role_permission` (`role_id`, `permission_id`)
VALUES (1, 1),
       (1, 2),
       (3, 2),
       (1, 3),
       (1, 4),
       (2, 4),
       (1, 5),
       (2, 5),
       (1, 6),
       (2, 6),
       (3, 6),
       (1, 7),
       (2, 2),
       (2, 7);


INSERT INTO `project_task_status` (`project_task_status`, `name`, `description`, `end_status`,
                                   `status_order`)
VALUES (1, 'TODO', 'Tareas por hacer', 0, 1),
       (2, 'EN PROGRESO', 'Tareas en progreso', 0, 2),
       (3, 'REVIEW', 'Tareas en revisión', 0, 3),
       (4, 'DONE', 'Tareas terminadas', 1, 4);