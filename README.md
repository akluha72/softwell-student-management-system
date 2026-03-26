# Student Management System (SMS)

A web-based student management system built with Laravel 12. Manage students, courses, and exam marks — with reports, CSV export, and PDF report cards.

---

## Features

### Core Modules
- **Students** — full CRUD with soft deletes, auto-generated student IDs, course enrollment management
- **Courses** — full CRUD with credit hours and descriptions
- **Exam Marks** — record marks with auto-calculated grade letters (A+ to F)

### Smart Behaviors
- **Auto-generated Student ID** — format `STU-2026-001`, generated on creation, never editable
- **Auto grade calculation** — grade letter updates automatically whenever a mark is saved
- **Auto enrollment** — students are enrolled in `course_student` pivot when a mark is recorded (`syncWithoutDetaching`)
- **Soft deletes** — students and courses are never permanently deleted unless explicitly forced

### Reports
- **Student averages report** — average mark per student across all courses, with grade distribution chart
- **Course averages report** — average mark per course, with highest and lowest mark columns
- **CSV export** — both reports exportable as UTF-8 CSV (BOM included for Excel compatibility)
- **PDF report card** — per-student printable result slip with mark breakdown, grade badges, and mini progress bars

### Dashboard
- Summary stat cards (total students, courses, marks, overall average)
- Top 5 students leaderboard with gold/silver/bronze ranking
- Grade distribution horizontal bar chart
- Quick action shortcuts
- Recent exam marks feed

### UX Details
- Searchable dropdowns on exam mark form (Tom Select) — no more scrolling through long lists
- Search bar on Students and Courses index pages (filters by name, email, ID, code)
- Live grade preview badge inside the mark input — shows grade as you type
- Empty state views on every index page
- Auto-dismiss flash messages after 4 seconds
- Pre-selected student/course when navigating from a profile page
- Smart redirect back to student profile after adding a mark from that page

---

## Tech Stack

- **Framework** — Laravel 12
- **Frontend** — Blade + Tailwind CSS + Vite
- **Database** — SQLite (zero config) or MySQL
- **Auth** — Laravel Breeze
- **PDF** — barryvdh/laravel-dompdf
- **Searchable select** — Tom Select (via cdnjs, no npm install needed)

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

Open `.env` and ensure:

```env
DB_CONNECTION=sqlite
```

Then create the SQLite file:

```bash
touch database/database.sqlite
```

> To use MySQL instead, update `.env` with your `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`.

### 5. Run migrations and seed

```bash
php artisan migrate --seed
```

This creates all tables and seeds:
- 12 Malaysian students (Malay, Chinese, and Indian naming conventions)
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
│   │   ├── StudentController.php     # includes reportCard() for PDF
│   │   ├── CourseController.php
│   │   ├── ExamMarkController.php    # auto-enrolls student on mark save
│   │   └── ReportController.php
│   └── Requests/
│       ├── StoreStudentRequest.php
│       ├── UpdateStudentRequest.php
│       ├── StoreCourseRequest.php
│       ├── UpdateCourseRequest.php
│       ├── StoreExamMarkRequest.php
│       └── UpdateExamMarkRequest.php
├── Models/
│   ├── Student.php                   # SoftDeletes, average_mark accessor
│   ├── Course.php                    # SoftDeletes, average_mark accessor
│   └── ExamMark.php                  # boot() auto-calculates grade on save
└── Services/
    └── ReportService.php             # all report query logic

database/
├── migrations/
│   ├── ..._create_students_table.php
│   ├── ..._create_courses_table.php
│   ├── ..._create_course_student_table.php
│   └── ..._create_exam_marks_table.php
└── seeders/
    ├── DatabaseSeeder.php
    ├── StudentSeeder.php
    ├── CourseSeeder.php
    └── ExamMarkSeeder.php

resources/views/
├── layouts/
│   └── app.blade.php
├── students/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   ├── show.blade.php
│   ├── _form.blade.php
│   └── report-card.blade.php        # dompdf PDF template
├── courses/
├── exam-marks/
├── reports/
│   ├── students.blade.php
│   └── courses.blade.php
└── dashboard.blade.php
```

---

## Grade Scale

| Mark     | Grade |
|----------|-------|
| 90 – 100 | A+    |
| 80 – 89  | A     |
| 75 – 79  | B+    |
| 70 – 74  | B     |
| 65 – 69  | C+    |
| 60 – 64  | C     |
| 55 – 59  | D     |
| 0 – 54   | F     |

---

## Key Design Decisions

**Soft Deletes** — Students and courses use `SoftDeletes`. Deleted records are hidden from the UI but retained in the database. To restore a record via Tinker:

```bash
php artisan tinker
>>> App\Models\Student::withTrashed()->find(1)->restore();
```

**Auto-generated Student ID** — Generated in `StudentController@store` using `withTrashed()->count()` to prevent duplicate IDs even after deletions. Never exposed as an editable field.

**Auto Enrollment** — When an exam mark is recorded, the student is automatically enrolled in that course via `syncWithoutDetaching()` on the `course_student` pivot. This prevents duplicates and never removes existing enrollments.

**Grade Auto-Calculation** — `ExamMark` uses a `saving` hook in `boot()` to auto-calculate the grade letter on every create and update. `gradeFromMark()` is a `public static` method — used by the model, the seeders, the report service, and the Blade views as a single source of truth.

**ReportService** — All report query logic is isolated in `app/Services/ReportService.php` and injected into `ReportController` via the constructor. Keeps the controller thin and the logic independently testable.

**CSV UTF-8 BOM** — Both CSV exports write `\xEF\xBB\xBF` at the start of the stream. Without this, Microsoft Excel on Windows misreads UTF-8 and Malaysian names with special characters render as garbled symbols.

**PDF Report Card** — Uses `barryvdh/laravel-dompdf` with a standalone Blade template (no Tailwind — inline CSS only, as dompdf does not process external stylesheets). Font set to `DejaVu Sans` for full UTF-8 support.

**Searchable Dropdowns** — Tom Select is loaded from cdnjs (no npm install needed) and applied to the student and course selects on the exam mark form. Prevents UX issues when the student list grows long.

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
GET    /students/{student}/report-card      ← downloads PDF

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
GET    /reports/students/export             ← downloads CSV
GET    /reports/courses/export              ← downloads CSV
```

---

## Possible Extensions

- Restore soft-deleted records via a Trash UI
- Multiple exam types per course (midterm, final, quiz)
- Student login portal to view own marks and download their own report card
- Email notification when a mark is recorded
- Bulk CSV import for students and marks

---

## License

MIT