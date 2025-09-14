--
-- This script sets up the necessary tables for the Quiz App features,
-- including quizzes, content feedback, and analytics.
--

-- --------------------------------------------------------
-- Users Table
-- This table is assumed to already exist from the initial setup.
-- The `id` and `user_type` columns are crucial for linking other tables.
-- --------------------------------------------------------
-- CREATE TABLE IF NOT EXISTS `users` (
--   `id` INT AUTO_INCREMENT PRIMARY KEY,
--   `full_name` VARCHAR(255) NOT NULL,
--   `username` VARCHAR(255) NOT NULL UNIQUE,
--   `email` VARCHAR(255) NOT NULL UNIQUE,
--   `password_hash` VARCHAR(255) NOT NULL,
--   `user_type` ENUM('admin', 'quiz_author', 'student') NOT NULL DEFAULT 'student',
--   `gender` ENUM('Male', 'Female'),
--   `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );

-- --------------------------------------------------------
-- Quizzes Table
-- This table stores information about each quiz created by a Quiz Author.
-- It links to the `users` table to identify the author.
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `quizzes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `author_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- Questions Table
-- Stores the individual questions for each quiz.
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `questions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `quiz_id` INT NOT NULL,
  `question_text` TEXT NOT NULL,
  `question_type` ENUM('MCQ', 'True/False') NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- Answers Table
-- Stores the possible answers for each question.
-- The `is_correct` field is used to determine the right answer.
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `answers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `question_id` INT NOT NULL,
  `answer_text` VARCHAR(255) NOT NULL,
  `is_correct` TINYINT(1) NOT NULL DEFAULT 0,
  FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- Quiz Feedback Table
-- Stores feedback from students for a specific quiz.
-- It links to both `quizzes` and `users` tables.
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `quiz_feedback` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `quiz_id` INT NOT NULL,
  `student_id` INT NOT NULL,
  `feedback_text` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- Quiz Attempts Table
-- Used for the analytics feature to track student performance.
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `quiz_attempts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_id` INT NOT NULL,
  `quiz_id` INT NOT NULL,
  `score` DECIMAL(5, 2) NOT NULL,
  `attempted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE
);
