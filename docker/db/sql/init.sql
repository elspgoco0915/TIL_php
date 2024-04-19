-- users
CREATE TABLE IF NOT EXISTS `users` (
    id int AUTO_INCREMENT,
    name varchar(10),
    INDEX(id)
);

-- player_statuses
-- TODO: 外部キーでusersとリンクさせる
CREATE TABLE IF NOT EXISTS `player_statuses` (
    user_id INT UNSIGNED PRIMARY KEY,
    status TINYINT UNSIGNED DEFAULT 0
);