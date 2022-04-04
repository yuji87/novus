-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2022-03-09 20:18:17
-- サーバのバージョン： 10.4.22-MariaDB
-- PHP のバージョン: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `qandasite`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `article_likes`
--

CREATE TABLE `article_likes` (
  `a_like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `like_flg` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `article_posts`
--

CREATE TABLE `article_posts` (
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `message` text NOT NULL,
  `post_date` datetime NOT NULL DEFAULT current_timestamp(),
  `upd_date` datetime DEFAULT NULL,
  `cate_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `categories`
--

CREATE TABLE `categories` (
  `cate_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
insert into categories values
(1, '国語'),
(2, '数学'),
(3, '英語'),
(4, '地理'),
(5, '歴史'),
(6, '公民'),
(7, '化学'),
(8, '物理'),
(9, 'その他');

-- --------------------------------------------------------

--
-- テーブルの構造 `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `contents` text NOT NULL,
  `contact_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `private_answers`
--

CREATE TABLE `private_answers` (
  `pri_a_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pri_q_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `pri_a_date` datetime NOT NULL DEFAULT current_timestamp(),
  `upd_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `private_questions`
--

CREATE TABLE `private_questions` (
  `pri_q_id` int(11) NOT NULL,
  `questioner_id` int(11) NOT NULL,
  `solver_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `message` text NOT NULL,
  `post_date` datetime NOT NULL DEFAULT current_timestamp(),
  `upd_date` datetime DEFAULT NULL,
  `cate_id` int(11) NOT NULL,
  `status_flg` int(11) NOT NULL DEFAULT 0,
  `evaluation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `letterss`
--

CREATE TABLE `letters` (
  `letter_id` int(11) NOT NULL,
  `pri_q_id` int(11) NOT NULL,
  `questioner_id` int(11) NOT NULL,
  `solver_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `message` text NOT NULL,
  `letter_date` datetime NOT NULL DEFAULT current_timestamp(),
  `upd_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `question_answers`
--

CREATE TABLE `question_answers` (
  `answer_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_date` datetime NOT NULL DEFAULT current_timestamp(),
  `upd_date` datetime DEFAULT NULL,
  `best_flg` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `question_likes`
--

CREATE TABLE `question_likes` (
  `q_like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `like_flg` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `question_posts`
--

CREATE TABLE `question_posts` (
  `question_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `message` text NOT NULL,
  `post_date` datetime NOT NULL DEFAULT current_timestamp(),
  `upd_date` datetime DEFAULT NULL,
  `cate_id` int(11) NOT NULL,
  `best_select_flg` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `question_replies`
--

CREATE TABLE `question_replies` (
  `reply_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `reply_date` datetime NOT NULL DEFAULT current_timestamp(),
  `upd_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `todo`
--

CREATE TABLE `todo` (
  `todo_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `remind_date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`todo_id`),
  KEY `todo_ix1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------


--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `q_disp_flg` int(11) NOT NULL DEFAULT 0,
  `level` int(11) NOT NULL DEFAULT 1,
  `exp` int(11) NOT NULL DEFAULT 0,
  `comment` text DEFAULT NULL,
  `pre_level` int(11) NOT NULL DEFAULT 1,
  `pre_exp` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------


--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `article_likes`
--
ALTER TABLE `article_likes`
  ADD PRIMARY KEY (`a_like_id`);

--
-- テーブルのインデックス `article_posts`
--
ALTER TABLE `article_posts`
  ADD PRIMARY KEY (`article_id`);

--
-- テーブルのインデックス `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cate_id`);

--
-- テーブルのインデックス `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- テーブルのインデックス `private_answers`
--
ALTER TABLE `private_answers`
  ADD PRIMARY KEY (`pri_a_id`);

--
-- テーブルのインデックス `private_questions`
--
ALTER TABLE `private_questions`
  ADD PRIMARY KEY (`pri_q_id`);

--
-- テーブルのインデックス `letters`
--
ALTER TABLE `letters`
  ADD PRIMARY KEY (`letter_id`);

--
-- テーブルのインデックス `question_answers`
--
ALTER TABLE `question_answers`
  ADD PRIMARY KEY (`answer_id`);

--
-- テーブルのインデックス `question_likes`
--
ALTER TABLE `question_likes`
  ADD PRIMARY KEY (`q_like_id`);

--
-- テーブルのインデックス `question_posts`
--
ALTER TABLE `question_posts`
  ADD PRIMARY KEY (`question_id`);

--
-- テーブルのインデックス `question_replies`
--
ALTER TABLE `question_replies`
  ADD PRIMARY KEY (`reply_id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);




--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `article_likes`
--
ALTER TABLE `article_likes`
  MODIFY `a_like_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `article_posts`
--
ALTER TABLE `article_posts`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `categories`
--
ALTER TABLE `categories`
  MODIFY `cate_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `caontacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `private_answers`
--
ALTER TABLE `private_answers`
  MODIFY `pri_a_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `private_questions`
--
ALTER TABLE `private_questions`
  MODIFY `pri_q_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `letters`
--
ALTER TABLE `letters`
  MODIFY `letter_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `question_answers`
--
ALTER TABLE `question_answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `question_likes`
--
ALTER TABLE `question_likes`
  MODIFY `q_like_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `question_posts`
--
ALTER TABLE `question_posts`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `question_replies`
--
ALTER TABLE `question_replies`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `todo`
--
ALTER TABLE `todo`
  MODIFY `todo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;


--
-- ダンプしたテーブルの FOREIGN KEY
--

--
-- ダンプしたテーブルの FOREIGN KEY `article_likes`
--
ALTER TABLE `article_likes`
  ADD FOREIGN KEY(`user_id`) REFERENCES `users`(`user_id`),
  ADD FOREIGN KEY(`article_id`) REFERENCES `article_posts`(`article_id`);

--
-- ダンプしたテーブルの FOREIGN KEY `article_posts`
--
ALTER TABLE `article_posts`
  ADD FOREIGN KEY(`user_id`) REFERENCES `users`(`user_id`),
  ADD FOREIGN KEY(`cate_id`) REFERENCES `categories`(`cate_id`);

--
-- ダンプしたテーブルの FOREIGN KEY `private_answers`
--
ALTER TABLE `private_answers`
  ADD FOREIGN KEY(`user_id`) REFERENCES `users`(`user_id`),
  ADD FOREIGN KEY(`pri_q_id`) REFERENCES `private_questions`(`pri_q_id`);

--
-- ダンプしたテーブルの FOREIGN KEY `private_questions`
--
ALTER TABLE `private_questions`
  ADD FOREIGN KEY(`questioner_id`) REFERENCES `users`(`user_id`),
  ADD FOREIGN KEY(`solver_id`) REFERENCES `users`(`user_id`),
  ADD FOREIGN KEY(`cate_id`) REFERENCES `categories`(`cate_id`);

--
-- ダンプしたテーブルの FOREIGN KEY `letters`
--
ALTER TABLE `letters`
  ADD FOREIGN KEY(`pri_q_id`) REFERENCES `private_questions`(`pri_q_id`),
  ADD FOREIGN KEY(`questioner_id`) REFERENCES `users`(`user_id`),
  ADD FOREIGN KEY(`solver_id`) REFERENCES `users`(`user_id`);

--
-- ダンプしたテーブルの FOREIGN KEY `question_answers`
--
ALTER TABLE `question_answers`
  ADD FOREIGN KEY(`user_id`) REFERENCES `users`(`user_id`),
  ADD FOREIGN KEY(`question_id`) REFERENCES `question_posts`(`question_id`);

--
-- ダンプしたテーブルのFOREIGN KEY `question_likes`
--
ALTER TABLE `question_likes`
  ADD FOREIGN KEY(`user_id`) REFERENCES `users`(`user_id`),
  ADD FOREIGN KEY(`answer_id`) REFERENCES `question_answers`(`answer_id`);

--
-- ダンプしたテーブルのFOREIGN KEY `question_posts`
--
ALTER TABLE `question_posts`
  ADD FOREIGN KEY(`user_id`) REFERENCES `users`(`user_id`),
  ADD FOREIGN KEY(`cate_id`) REFERENCES `categories`(`cate_id`);

--
-- ダンプしたテーブルのFOREIGN KEY `question_replies`
--
ALTER TABLE `question_replies`
  ADD FOREIGN KEY(`user_id`) REFERENCES `users`(`user_id`),
  ADD FOREIGN KEY(`question_id`) REFERENCES `question_posts`(`question_id`);

--
-- ダンプしたテーブルのFOREIGN KEY `todo`
--
ALTER TABLE `todo`
  ADD FOREIGN KEY(`user_id`) REFERENCES `users`(`user_id`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
