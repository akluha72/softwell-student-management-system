<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\ExamMark;
use App\Models\Student;

class ExamMarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all();
        $courses = Course::all();

        // Each student is enrolled in 4–6 random courses
        foreach ($students as $student) {
            $assignedCourses = $courses->random(rand(4, min(6, $courses->count())));

            // Sync to pivot table
            $student->courses()->sync(
                $assignedCourses->mapWithKeys(fn($course) => [
                    $course->id => [
                        'enrolled_at' => $student->enrolled_at,
                        'status' => 'active',
                    ],
                ])->toArray()
            );

            // Record a mark for each enrolled course
            foreach ($assignedCourses as $course) {
                $mark = $this->realisticMark();

                ExamMark::create([
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                    'mark' => $mark,
                    'grade' => $this->calculateGrade($mark),
                    'exam_date' => now()->subDays(rand(7, 60))->toDateString(),
                    'remarks' => $this->remarks($mark),
                ]);
            }
        }
    }

    /**
     * Generate a realistic bell-curve-ish mark (40–100).
     * Most students score between 55–85 with a few outliers.
     */
    private function realisticMark(): float
    {
        $ranges = [
            [40, 54, 10],  // 10% chance — struggling
            [55, 64, 20],  // 20% chance — below average
            [65, 74, 30],  // 30% chance — average
            [75, 84, 25],  // 25% chance — good
            [85, 100, 15], // 15% chance — excellent
        ];

        $rand = rand(1, 100);
        $cumulative = 0;

        foreach ($ranges as [$min, $max, $weight]) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return round(rand($min * 100, $max * 100) / 100, 2);
            }
        }

        return 65.00;
    }
    private function calculateGrade(float $mark): string
    {
        return match (true) {
            $mark >= 90 => 'A+',
            $mark >= 80 => 'A',
            $mark >= 75 => 'B+',
            $mark >= 70 => 'B',
            $mark >= 65 => 'C+',
            $mark >= 60 => 'C',
            $mark >= 55 => 'D',
            default => 'F',
        };
    }

    private function remarks(float $mark): ?string
    {
        if ($mark >= 85)
            return 'Excellent performance.';
        if ($mark >= 70)
            return 'Good understanding of the subject.';
        if ($mark >= 55)
            return 'Satisfactory. Room for improvement.';
        if ($mark >= 40)
            return 'Needs to put in more effort.';
        return 'Did not meet minimum requirements.';
    }
}
