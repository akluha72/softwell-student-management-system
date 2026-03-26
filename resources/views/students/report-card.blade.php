<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Report Card — {{ $student->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #1a1a1a;
            background: #ffffff;
            padding: 40px;
        }

        .header {
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 20px;
            margin-bottom: 24px;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .institution {
            font-size: 20px;
            font-weight: bold;
            color: #4f46e5;
            letter-spacing: -0.3px;
        }

        .institution-sub {
            font-size: 11px;
            color: #6b7280;
            margin-top: 2px;
        }

        .report-title {
            text-align: right;
        }

        .report-title h2 {
            font-size: 16px;
            font-weight: bold;
            color: #111827;
        }

        .report-title p {
            font-size: 10px;
            color: #9ca3af;
            margin-top: 2px;
        }

        /* ── Student info ── */
        .student-section {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 16px 20px;
            margin-bottom: 20px;
        }

        .student-name {
            font-size: 17px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 10px;
        }

        .info-grid {
            display: table;
            width: 100%;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            color: #6b7280;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 3px 24px 3px 0;
            width: 120px;
        }

        .info-value {
            display: table-cell;
            color: #111827;
            font-size: 11px;
            font-weight: 500;
            padding: 3px 0;
        }

        /* ── Summary stats ── */
        .stats-row {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-collapse: separate;
            border-spacing: 8px 0;
        }

        .stat-box {
            display: table-cell;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 12px 16px;
            text-align: center;
            width: 25%;
        }

        .stat-label {
            font-size: 9px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 22px;
            font-weight: bold;
            color: #111827;
        }

        .stat-value.grade-good {
            color: #16a34a;
        }

        .stat-value.grade-ok {
            color: #d97706;
        }

        .stat-value.grade-poor {
            color: #dc2626;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead tr {
            background: #4f46e5;
        }

        thead th {
            color: #ffffff;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            padding: 8px 12px;
            text-align: left;
        }

        thead th.text-right {
            text-align: right;
        }

        tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        tbody tr {
            border-bottom: 1px solid #f3f4f6;
        }

        tbody td {
            padding: 9px 12px;
            font-size: 11px;
            color: #374151;
        }

        tbody td.text-right {
            text-align: right;
        }

        tbody td.text-center {
            text-align: center;
        }

        .mark-value {
            font-weight: 600;
            color: #111827;
        }

        .grade-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: 700;
        }

        .grade-a {
            background: #dcfce7;
            color: #15803d;
        }

        .grade-b {
            background: #fef9c3;
            color: #a16207;
        }

        .grade-c {
            background: #ffedd5;
            color: #c2410c;
        }

        .grade-f {
            background: #fee2e2;
            color: #b91c1c;
        }

        .bar-wrap {
            background: #e5e7eb;
            border-radius: 3px;
            height: 5px;
            width: 80px;
            display: inline-block;
            vertical-align: middle;
            margin-left: 8px;
        }

        .bar-fill {
            height: 5px;
            border-radius: 3px;
        }

        .bar-good {
            background: #22c55e;
        }

        .bar-ok {
            background: #f59e0b;
        }

        .bar-poor {
            background: #ef4444;
        }

        /* ── Footer ── */
        .footer {
            border-top: 1px solid #e5e7eb;
            padding-top: 14px;
            margin-top: 8px;
            display: table;
            width: 100%;
        }

        .footer-left {
            display: table-cell;
        }

        .footer-right {
            display: table-cell;
            text-align: right;
        }

        .footer p {
            font-size: 9px;
            color: #9ca3af;
            line-height: 1.6;
        }

        .signature-line {
            border-top: 1px solid #d1d5db;
            width: 160px;
            margin-top: 28px;
            margin-bottom: 4px;
        }

        .signature-label {
            font-size: 9px;
            color: #6b7280;
        }

        /* ── No marks state ── */
        .empty-state {
            text-align: center;
            padding: 30px;
            color: #9ca3af;
            font-size: 11px;
            border: 1px dashed #e5e7eb;
            border-radius: 6px;
        }
    </style>
</head>

<body>

    {{-- Header --}}
    <div class="header">
        <div class="header-top">
            <div>
                <div class="institution">Student Management System</div>
                <div class="institution-sub">Academic Performance Report</div>
            </div>
            <div class="report-title">
                <h2>Report Card</h2>
                <p>Generated: {{ now()->format('d M Y, h:i A') }}</p>
            </div>
        </div>
    </div>

    {{-- Student info --}}
    <div class="student-section">
        <div class="student-name">{{ $student->name }}</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Student ID</div>
                <div class="info-value">{{ $student->student_id }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $student->email }}</div>
            </div>
            @if ($student->phone)
                <div class="info-row">
                    <div class="info-label">Phone</div>
                    <div class="info-value">{{ $student->phone }}</div>
                </div>
            @endif
            <div class="info-row">
                <div class="info-label">Enrolled</div>
                <div class="info-value">{{ $student->enrolled_at->format('d M Y') }}</div>
            </div>
        </div>
    </div>

    {{-- Summary stats --}}
    @php
        $totalExams = $student->examMarks->count();
        $avgMark = $totalExams > 0 ? round($student->examMarks->avg('mark'), 1) : null;
        $avgGrade = $avgMark ? \App\Models\ExamMark::gradeFromMark($avgMark) : '—';
        $highest = $totalExams > 0 ? $student->examMarks->max('mark') : null;
        $lowest = $totalExams > 0 ? $student->examMarks->min('mark') : null;

        $gradeClass = $avgMark ? ($avgMark >= 75 ? 'grade-good' : ($avgMark >= 55 ? 'grade-ok' : 'grade-poor')) : '';
    @endphp

    <table class="stats-row" style="margin-bottom: 20px;">
        <tr>
            <td class="stat-box">
                <span class="stat-label">Courses taken</span>
                <span class="stat-value">{{ $totalExams }}</span>
            </td>
            <td class="stat-box">
                <span class="stat-label">Average mark</span>
                <span class="stat-value {{ $gradeClass }}">{{ $avgMark ?? '—' }}</span>
            </td>
            <td class="stat-box">
                <span class="stat-label">Overall grade</span>
                <span class="stat-value {{ $gradeClass }}">{{ $avgGrade }}</span>
            </td>
            <td class="stat-box">
                <span class="stat-label">Highest mark</span>
                <span class="stat-value grade-good">{{ $highest ? number_format($highest, 1) : '—' }}</span>
            </td>
        </tr>
    </table>

    {{-- Marks table --}}
    <div class="section-title">Examination Results</div>

    @if ($student->examMarks->isEmpty())
        <div class="empty-state">No examination records found for this student.</div>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width: 30px;">#</th>
                    <th>Course</th>
                    <th style="width: 60px;">Code</th>
                    <th style="width: 40px;" class="text-center">Credits</th>
                    <th style="width: 80px;" class="text-right">Mark</th>
                    <th style="width: 50px;" class="text-center">Grade</th>
                    <th style="width: 90px;">Exam Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($student->examMarks->sortByDesc('mark') as $i => $mark)
                    @php
                        $barClass = $mark->mark >= 75 ? 'bar-good' : ($mark->mark >= 55 ? 'bar-ok' : 'bar-poor');
                        $badgeClass = in_array($mark->grade, ['A+', 'A', 'B+'])
                            ? 'grade-a'
                            : (in_array($mark->grade, ['B', 'C+', 'C'])
                                ? 'grade-b'
                                : ($mark->grade === 'D'
                                    ? 'grade-c'
                                    : 'grade-f'));
                    @endphp
                    <tr>
                        <td style="color: #9ca3af;">{{ $i + 1 }}</td>
                        <td>{{ $mark->course->name }}</td>
                        <td style="font-family: monospace; font-size: 10px; color: #6b7280;">{{ $mark->course->code }}
                        </td>
                        <td class="text-center" style="color: #6b7280;">{{ $mark->course->credit_hours }}</td>
                        <td class="text-right">
                            <span class="mark-value">{{ number_format($mark->mark, 1) }}</span>
                            <span class="bar-wrap">
                                <span class="bar-fill {{ $barClass }}"
                                    style="width: {{ $mark->mark }}%;"></span>
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="grade-badge {{ $badgeClass }}">{{ $mark->grade }}</span>
                        </td>
                        <td style="color: #6b7280;">{{ $mark->exam_date->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Footer --}}
    <div class="footer">
        <div class="footer-left">
            <div class="signature-line"></div>
            <div class="signature-label">Authorised Signature</div>
        </div>
        <div class="footer-right">
            <p>This is a computer-generated document.</p>
            <p>Student Management System &bull; {{ now()->format('Y') }}</p>
        </div>
    </div>

</body>

</html>
