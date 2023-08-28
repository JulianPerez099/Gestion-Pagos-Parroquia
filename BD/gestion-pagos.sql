CREATE TABLE
  `courses` (
    `id` int (30) NOT NULL,
    `course` varchar(100) NOT NULL,
    `description` text NOT NULL,
    `total_amount` float NOT NULL,
    `date_created` datetime NOT NULL DEFAULT current_timestamp()
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
  `fees` (
    `id` int (30) NOT NULL,
    `course_id` int (30) NOT NULL,
    `description` varchar(200) NOT NULL,
    `amount` float NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
  `payments` (
    `id` int (30) NOT NULL,
    `ef_id` int (30) NOT NULL,
    `amount` float NOT NULL,
    `remarks` text NOT NULL,
    `date_created` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
  `student` (
    `id` int (30) NOT NULL,
    `id_no` varchar(100) NOT NULL,
    `name` text NOT NULL,
    `num_iden` varchar(20) NOT NULL,
    `contact` varchar(100) NOT NULL,
    `address` text NOT NULL,
    `email` varchar(200) NOT NULL,
    `date_created` datetime NOT NULL DEFAULT current_timestamp()
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
  `student_ef_list` (
    `id` int (30) NOT NULL,
    `ef_no` varchar(200) NOT NULL,
    `student_id` int (30) NOT NULL,
    `course_id` int (30) NOT NULL,
    `total_fee` float NOT NULL,
    `date_created` datetime NOT NULL DEFAULT current_timestamp()
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
  `system_settings` (
    `id` int (30) NOT NULL,
    `name` text NOT NULL,
    `email` varchar(200) NOT NULL,
    `contact` varchar(20) NOT NULL,
    `cover_img` text NOT NULL,
    `about_content` text NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
  `users` (
    `id` int (30) NOT NULL,
    `name` text NOT NULL,
    `username` varchar(200) NOT NULL,
    `password` text NOT NULL,
    `type` tinyint (1) NOT NULL DEFAULT 3
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

INSERT INTO
  `users` (`id`, `name`, `username`, `password`, `type`)
VALUES
  (
    1,
    'administrador',
    'administrador',
    'bab003f3bd6e5563aa7a28956ee9442a',
    1
  ),
  (
    2,
    'Auxiliar',
    'auxiliar',
    '73d7ccacf86d8c2d8e8e9d80c7ef7340',
    2
  );

ALTER TABLE `courses` ADD PRIMARY KEY (`id`);

ALTER TABLE `fees` ADD PRIMARY KEY (`id`),
ADD KEY `course_id` (`course_id`);

ALTER TABLE `payments` ADD PRIMARY KEY (`id`),
ADD KEY `ef_id` (`ef_id`);

ALTER TABLE `student` ADD PRIMARY KEY (`id`),
ADD KEY `id_no` (`id_no`);

ALTER TABLE `student_ef_list` ADD PRIMARY KEY (`id`),
ADD KEY `course_id` (`course_id`),
ADD KEY `student_id` (`student_id`);

ALTER TABLE `system_settings` ADD PRIMARY KEY (`id`);

ALTER TABLE `users` ADD PRIMARY KEY (`id`);

ALTER TABLE `courses` MODIFY `id` int (30) NOT NULL AUTO_INCREMENT;

ALTER TABLE `fees` MODIFY `id` int (30) NOT NULL AUTO_INCREMENT;

ALTER TABLE `payments` MODIFY `id` int (30) NOT NULL AUTO_INCREMENT;

ALTER TABLE `student` MODIFY `id` int (30) NOT NULL AUTO_INCREMENT;

ALTER TABLE `student_ef_list` MODIFY `id` int (30) NOT NULL AUTO_INCREMENT;

ALTER TABLE `system_settings` MODIFY `id` int (30) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users` MODIFY `id` int (30) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 2;

ALTER TABLE `fees` ADD CONSTRAINT `fees_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `payments` ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`ef_id`) REFERENCES `student_ef_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `student_ef_list` ADD CONSTRAINT `student_ef_list_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `student_ef_list_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;