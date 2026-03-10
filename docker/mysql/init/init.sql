-- Этот скрипт выполнится при первом запуске контейнера
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON `test`.* TO 'root'@'%';
FLUSH PRIVILEGES;