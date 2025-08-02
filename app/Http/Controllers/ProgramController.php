<?php
// app/Http/Controllers/ProgramController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = [
            [
                'id' => 1,
                'title' => 'Youth Leadership Development',
                'title_sw' => 'Maendeleo ya Uongozi wa Vijana',
                'slug' => 'youth-leadership',
                'description' => 'Comprehensive program designed to develop leadership skills among young people aged 18-25.',
                'description_sw' => 'Mradi mkamilifu uliobuniwa kuendeleza ujuzi wa uongozi miongoni mwa vijana wa umri wa miaka 18-25.',
                'duration' => '6 months',
                'duration_sw' => 'Miezi 6',
                'participants' => 150,
                'image' => 'leadership-program.jpg'
            ],
            [
                'id' => 2,
                'title' => 'Skills Training Initiative',
                'title_sw' => 'Mradi wa Mafunzo ya Ujuzi',
                'slug' => 'skills-training',
                'description' => 'Vocational training in carpentry, tailoring, computer skills, and entrepreneurship.',
                'description_sw' => 'Mafunzo ya ufundi katika useremala, kushona, ujuzi wa kompyuta, na uongozi wa biashara.',
                'duration' => '3-12 months',
                'duration_sw' => 'Miezi 3-12',
                'participants' => 200,
                'image' => 'skills-training.jpg'
            ],
            [
                'id' => 3,
                'title' => 'Community Support Program',
                'title_sw' => 'Mradi wa Kusaidia Jamii',
                'slug' => 'community-support',
                'description' => 'Direct support for vulnerable families, orphans, and people with disabilities.',
                'description_sw' => 'Msaada wa moja kwa moja kwa familia zilizo hatarini, yatima, na watu wenye ulemavu.',
                'duration' => 'Ongoing',
                'duration_sw' => 'Inaendelea',
                'participants' => 300,
                'image' => 'community-support.jpg'
            ]
        ];

        return view('programs.index', compact('programs'));
    }

    public function show($slug)
    {
        // Sample program details - replace with actual database query
        $programs = [
            'youth-leadership' => [
                'title' => 'Youth Leadership Development',
                'title_sw' => 'Maendeleo ya Uongozi wa Vijana',
                'description' => 'Our flagship program that transforms young people into confident leaders.',
                'description_sw' => 'Mradi wetu mkuu unaobadilisha vijana kuwa viongozi wenye ujasiri.',
                'objectives' => [
                    'Develop leadership and communication skills',
                    'Build confidence and self-esteem',
                    'Create networking opportunities',
                    'Provide mentorship and guidance'
                ],
                'objectives_sw' => [
                    'Kuendeleza ujuzi wa uongozi na mawasiliano',
                    'Kujenga ujasiri na kujithamini',
                    'Kuunda fursa za kuwasiliana',
                    'Kutoa uongozaji na mwongozo'
                ]
            ]
        ];

        $program = $programs[$slug] ?? abort(404);
        
        return view('programs.show', compact('program', 'slug'));
    }
}

