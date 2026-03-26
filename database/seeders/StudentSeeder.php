<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            ['name' => 'Ahmad Fariz bin Zulkifli', 'email' => 'ahmad.fariz@student.edu.my', 'phone' => '011-2345 6789', 'gender' => 'male', 'date_of_birth' => '2002-03-14'],
            ['name' => 'Nurul Ain binti Rashid', 'email' => 'nurul.ain@student.edu.my', 'phone' => '012-3456 7890', 'gender' => 'female', 'date_of_birth' => '2001-07-22'],
            ['name' => 'Muhammad Haziq bin Ismail', 'email' => 'haziq.ismail@student.edu.my', 'phone' => '013-4567 8901', 'gender' => 'male', 'date_of_birth' => '2002-11-05'],
            ['name' => 'Siti Zulaikha binti Hamdan', 'email' => 'siti.zulaikha@student.edu.my', 'phone' => '014-5678 9012', 'gender' => 'female', 'date_of_birth' => '2001-04-18'],
            ['name' => 'Arjun a/l Subramaniam', 'email' => 'arjun.sub@student.edu.my', 'phone' => '016-6789 0123', 'gender' => 'male', 'date_of_birth' => '2002-08-30'],
            ['name' => 'Priya a/p Krishnamurthy', 'email' => 'priya.krishna@student.edu.my', 'phone' => '017-7890 1234', 'gender' => 'female', 'date_of_birth' => '2001-12-09'],
            ['name' => 'Lim Wei Jie', 'email' => 'weijie.lim@student.edu.my', 'phone' => '018-8901 2345', 'gender' => 'male', 'date_of_birth' => '2002-02-27'],
            ['name' => 'Tan Xin Ying', 'email' => 'xinying.tan@student.edu.my', 'phone' => '019-9012 3456', 'gender' => 'female', 'date_of_birth' => '2001-06-15'],
            ['name' => 'Mohd Syafiq bin Abdullah', 'email' => 'syafiq.abd@student.edu.my', 'phone' => '011-0123 4567', 'gender' => 'male', 'date_of_birth' => '2003-01-11'],
            ['name' => 'Kavitha a/p Selvam', 'email' => 'kavitha.selvam@student.edu.my', 'phone' => '012-1234 5678', 'gender' => 'female', 'date_of_birth' => '2002-09-03'],
            ['name' => 'Zainuddin bin Othman', 'email' => 'zainuddin.o@student.edu.my', 'phone' => '013-2345 6789', 'gender' => 'male', 'date_of_birth' => '2001-05-20'],
            ['name' => 'Lee Hui Shan', 'email' => 'huishan.lee@student.edu.my', 'phone' => '014-3456 7890', 'gender' => 'female', 'date_of_birth' => '2002-10-08'],
        ];

        foreach ($students as $index => $data) {
            Student::create([
                ...$data,
                'student_id' => 'STU-' . date('Y') . '-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'enrolled_at' => now()->subMonths(rand(1, 18))->toDateString(),
            ]);
        }
    }
}
