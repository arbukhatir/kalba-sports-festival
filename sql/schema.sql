-- Kalba Sports Festival 2026 — MySQL schema
-- Import in cPanel > phpMyAdmin into your festival database, then set config.php.
-- Passwords are stored as PHP password_hash() bcrypt strings.

SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS applications (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  ref          VARCHAR(32) NOT NULL UNIQUE,
  type         VARCHAR(40) NOT NULL,            -- FORMS key or sport slug
  name         VARCHAR(160) NOT NULL,
  email        VARCHAR(160) NULL,
  phone        VARCHAR(40) NULL,
  payload      JSON NULL,                       -- the rest of the submitted fields
  status       ENUM('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS matches (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  sport        VARCHAR(40) NOT NULL,            -- CHAMPS slug ('football'), not the array position:
                                                 -- reordering the sports list must never reassign results
  day          VARCHAR(8) NOT NULL,             -- '06/11'
  side_a_ar    VARCHAR(120) NULL, side_a_en VARCHAR(120) NULL,
  side_b_ar    VARCHAR(120) NULL, side_b_en VARCHAR(120) NULL,
  score_a      INT NULL, score_b INT NULL,
  status       ENUM('upcoming','live','finished') NOT NULL DEFAULT 'upcoming',
  updated_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_matches_sport (sport)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS activities (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  name_ar      VARCHAR(120) NOT NULL, name_en VARCHAR(120) NOT NULL,
  zone         VARCHAR(40) NOT NULL,
  points       INT NOT NULL DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS visitors (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  code         VARCHAR(16) NOT NULL UNIQUE,
  name         VARCHAR(160) NOT NULL,
  age_group    VARCHAR(24) NULL,
  points       INT NOT NULL DEFAULT 0,
  created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS messages (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  name         VARCHAR(160) NULL,
  email        VARCHAR(160) NULL,
  body         TEXT NOT NULL,
  created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS subscribers (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  email        VARCHAR(160) NOT NULL UNIQUE,
  created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS survey_responses (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  survey       VARCHAR(40) NOT NULL,
  payload      JSON NULL,
  created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS audit_log (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  event        VARCHAR(40) NOT NULL,
  actor        VARCHAR(80) NULL,
  detail       VARCHAR(255) NULL,
  created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS admin_users (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  username     VARCHAR(60) NOT NULL UNIQUE,
  pass_hash    VARCHAR(255) NOT NULL,
  role         ENUM('admin','organizer','results') NOT NULL,
  sport        INT NULL,                        -- CHAMPS index for a per-sport results account
  created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- After importing this schema, run `php tools/seed.php` once on the server to
-- create the operator accounts (with real password hashes) and the activity
-- points. See DEPLOY.md.
