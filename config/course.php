<?php
// config/course.php - Enhanced configuration

return [
    'name' => env('COURSE_NAME', 'Kursus Ujian Perangkat Desa'),
    'price' => env('COURSE_PRICE', 299000),
    'currency' => 'IDR',
    'features' => [
        'access_duration' => 'lifetime', // lifetime, 6months, 1year
        'video_quality' => 'hd',
        'download_allowed' => true,
        'certificate_included' => true,
        'mentor_support' => true,
    ],
    'social_proof' => [
        'show_student_count' => true,
        'show_success_rate' => true,
        'testimonials_enabled' => true,
    ]
];
