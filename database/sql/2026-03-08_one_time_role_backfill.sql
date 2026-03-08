-- One-time role/profile backfill for existing MySQL database
-- Safe defaults:
-- 1) Create missing user_profiles rows from users table.
-- 2) Normalize invalid/empty roles to 'student'.
-- 3) Keep existing teacher/admin roles.
-- 4) Promote forced teacher aliases ('dogu', 'dogu2') to teacher.

START TRANSACTION;

INSERT INTO user_profiles (
  user_id,
  username,
  role,
  xp,
  total_time_seconds,
  selected_avatar_id,
  class_name,
  section,
  meta,
  created_at,
  updated_at
)
SELECT
  u.id,
  NULLIF(TRIM(u.name), ''),
  CASE
    WHEN LOWER(TRIM(u.name)) IN ('dogu', 'dogu2') THEN 'teacher'
    WHEN LOWER(SUBSTRING_INDEX(TRIM(u.email), '@', 1)) IN ('dogu', 'dogu2') THEN 'teacher'
    ELSE 'student'
  END,
  0,
  0,
  NULL,
  NULL,
  NULL,
  JSON_OBJECT(),
  NOW(),
  NOW()
FROM users u
LEFT JOIN user_profiles up ON up.user_id = u.id
WHERE up.user_id IS NULL;

UPDATE user_profiles up
JOIN users u ON u.id = up.user_id
SET
  up.username = COALESCE(NULLIF(TRIM(up.username), ''), NULLIF(TRIM(u.name), ''), up.username),
  up.role = CASE
    WHEN LOWER(TRIM(COALESCE(up.role, ''))) IN ('teacher', 'admin', 'administrator', 'ogretmen') THEN 'teacher'
    WHEN LOWER(TRIM(COALESCE(up.role, ''))) IN ('student', 'ogrenci') THEN 'student'
    WHEN LOWER(TRIM(u.name)) IN ('dogu', 'dogu2') THEN 'teacher'
    WHEN LOWER(SUBSTRING_INDEX(TRIM(u.email), '@', 1)) IN ('dogu', 'dogu2') THEN 'teacher'
    ELSE 'student'
  END,
  up.updated_at = NOW();

COMMIT;
