# Student Management System (SMS)

A web-based student management system built with Laravel 11. Manage students, courses, and exam marks — with reports and CSV export.

---

## Features

- **Students** — full CRUD with soft deletes, auto-generated student IDs
- **Courses** — full CRUD with credit hours and descriptions
- **Exam Marks** — record marks with auto-calculated grade letters (A+ to F)
- **Course Enrollment** — students are auto-enrolled when a mark is recorded
- **Reports** — average mark per student and per course, with grade distribution
- **CSV Export** — export both reports with UTF-8 BOM for Excel compatibility
- **Dashboard** — summary stats, top students leaderboard, grade distribution chart, recent activity

---

## Tech Stack

- **Framework** — Laravel 11
- **Frontend** — Blade + Tailwind CSS + Vite
- **Database** — SQLite (zero config for local dev)
- **Auth** — Laravel Breeze

---

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+ and npm

---

## Local Setup

### 1. Clone the repository

```bash
git clone https://github.com/your-username/student-management-system.git
cd student-management-system
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure the database

This project uses SQLite by default — no database server needed.

Open `.env` and make sure these lines are set:

```env
DB_CONNECTION=sqlite
```

Then create the SQLite file:

```bash
touch database/database.sqlite
```

### 5. Run migrations and seed

```bash
php artisan migrate --seed
```

This creates all tables and seeds:
- 12 Malaysian students (Malay, Chinese, and Indian names)
- 7 courses across Computer Science, Mathematics, and English
- Realistic exam marks with a bell-curve grade distribution

### 6. Build frontend assets

```bash
npm run dev
```

### 7. Start the server

```bash
php artisan serve
```

Visit [http://localhost:8000](http://localhost:8000)

---

## Login Credentials

After seeding, log in with the default Breeze account:

```
Email:    test@example.com
Password: password
```

> To change these, update `database/seeders/DatabaseSeeder.php` before running migrations.

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── StudentController.php
│   │   ├── CourseController.php
│   │   ├── ExamMarkController.php
│   │   └── ReportController.php
│   └── Requests/
│       ├── StoreStudentRequest.php
│       ├── UpdateStudentRequest.php
│       ├── StoreCourseRequest.php
│       ├── UpdateCourseRequest.php
│       ├── StoreExamMarkRequest.php
│       └── UpdateExamMarkRequest.php
├── Models/
│   ├── Student.php
│   ├── Course.php
│   └── ExamMark.php
└── Services/
    └── ReportService.php

database/
├── migrations/
└── seeders/
    ├── DatabaseSeeder.php
    ├── StudentSeeder.php
    ├── CourseSeeder.php
    └── ExamMarkSeeder.php

resources/views/
├── layouts/
│   └── app.blade.php
├── students/
├── courses/
├── exam-marks/
├── reports/
└── dashboard.blade.php
```

---

## Grade Scale

| Mark | Grade |
|------|-------|
| 90 – 100 | A+ |
| 80 – 89  | A  |
| 75 – 79  | B+ |
| 70 – 74  | B  |
| 65 – 69  | C+ |
| 60 – 64  | C  |
| 55 – 59  | D  |
| 0 – 54   | F  |

---

## Key Design Decisions

**Soft Deletes** — Students and courses use `SoftDeletes`. Deleted records are hidden from the UI but retained in the database. To restore a record via Tinker:

```bash
php artisan tinker
>>> App\Models\Student::withTrashed()->find(1)->restore();
```

**Auto Enrollment** — When an exam mark is recorded for a student, they are automatically enrolled in that course via the `course_student` pivot table (`syncWithoutDetaching`). No separate enrollment step is required.

**Grade Auto-Calculation** — The `ExamMark` model uses a `saving` hook to automatically calculate and store the grade letter whenever a mark is created or updated. The `gradeFromMark()` method is a static helper used across the entire application as a single source of truth.

**CSV UTF-8 BOM** — Both CSV exports include a UTF-8 BOM header so that special characters in Malaysian names render correctly when opened in Microsoft Excel on Windows.

**ReportService** — All report query logic is isolated in `app/Services/ReportService.php` and injected into `ReportController` via the constructor. This keeps the controller thin and the business logic independently testable.

---

## Available Routes

```
GET    /dashboard

GET    /students
GET    /students/create
POST   /students
GET    /students/{student}
GET    /students/{student}/edit
PUT    /students/{student}
DELETE /students/{student}
POST   /students/{student}/enroll
DELETE /students/{student}/unenroll/{course}

GET    /courses
GET    /courses/create
POST   /courses
GET    /courses/{course}
GET    /courses/{course}/edit
PUT    /courses/{course}
DELETE /courses/{course}

GET    /exam-marks
GET    /exam-marks/create
POST   /exam-marks
GET    /exam-marks/{examMark}
GET    /exam-marks/{examMark}/edit
PUT    /exam-marks/{examMark}
DELETE /exam-marks/{examMark}

GET    /reports/students
GET    /reports/courses
GET    /reports/students/export
GET    /reports/courses/export
```

---

## Possible Extensions

- Restore soft-deleted records via a Trash UI
- Multiple exam types per course (midterm, final, quiz)
- Student login portal to view own results
- Email notifications when marks are recorded
- PDF export for individual student report cards

---

## License

MIT