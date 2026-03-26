<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'name' => 'Introduction to Programming',
                'code' => 'CS101',
                'credit_hours' => 3,
                'description' => 'Fundamentals of programming using Python. Covers variables, loops, functions, and basic data structures.',
            ],
            [
                'name' => 'Data Structures & Algorithms',
                'code' => 'CS201',
                'credit_hours' => 3,
                'description' => 'Study of arrays, linked lists, trees, graphs, and algorithm complexity analysis.',
            ],
            [
                'name' => 'Database Systems',
                'code' => 'CS301',
                'credit_hours' => 3,
                'description' => 'Relational databases, SQL, normalisation, and transaction management.',
            ],
            [
                'name' => 'Web Application Development',
                'code' => 'CS302',
                'credit_hours' => 3,
                'description' => 'Full-stack web development covering HTML, CSS, JavaScript, and a server-side framework.',
            ],
            [
                'name' => 'Calculus I',
                'code' => 'MTH101',
                'credit_hours' => 4,
                'description' => 'Limits, derivatives, integrals, and their applications in engineering and science.',
            ],
            [
                'name' => 'Discrete Mathematics',
                'code' => 'MTH201',
                'credit_hours' => 3,
                'description' => 'Logic, sets, relations, graph theory, and combinatorics for computer science.',
            ],
            [
                'name' => 'Technical Communication',
                'code' => 'ENG101',
                'credit_hours' => 2,
                'description' => 'Writing technical reports, documentation, and effective oral presentations.',
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
