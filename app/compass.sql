CREATE DATABASE IF NOT EXISTS compass;
USE compass;

CREATE TABLE IF NOT EXISTS `compass`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `given` VARCHAR(50) NOT NULL,
  `surname` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC));

-- CREATE TABLE IF NOT EXISTS `compass`.`trips` (
--   `id` INT NOT NULL AUTO_INCREMENT,
--   `name` VARCHAR(45) NOT NULL,
--   `description` TEXT NOT NULL,
--   `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
--   `user_id` INT NOT NULL,
--   PRIMARY KEY (`id`),
--   INDEX `fk_projects_users1_idx` (`user_id` ASC),
--   CONSTRAINT `fk_projects_users1`
--     FOREIGN KEY (`user_id`)
--     REFERENCES `compass`.`users` (`id`)
--     ON DELETE NO ACTION
--     ON UPDATE NO ACTION
-- );