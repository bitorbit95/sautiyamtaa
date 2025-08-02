<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        // Sample data - replace with actual data from your models
        $stats = [
            'youth_empowered' => 2500,
            'programs_running' => 12,
            'communities_served' => 15,
            'years_of_service' => now()->year - 2018,
        ];

        $featuredPrograms = [
            [
                'id' => 1,
                'title' => 'Youth Leadership Program',
                'title_sw' => 'Mradi wa Uongozi wa Vijana',
                'description' => 'Developing future leaders through mentorship and skills training.',
                'description_sw' => 'Kuendeleza viongozi wa kesho kupitia uongozaji na mafunzo ya ujuzi.',
                'image' => 'leadership.jpg',
                'participants' => 150,
            ],
            [
                'id' => 2,
                'title' => 'Skills Development Initiative',
                'title_sw' => 'Mradi wa Maendeleo ya Ujuzi',
                'description' => 'Providing vocational training and entrepreneurship skills.',
                'description_sw' => 'Kutoa mafunzo ya ufundi na ujuzi wa uongozi wa biashara.',
                'image' => 'skills.jpg',
                'participants' => 200,
            ],
            [
                'id' => 3,
                'title' => 'Community Outreach',
                'title_sw' => 'Huduma za Kijamii',
                'description' => 'Supporting vulnerable families and disabled individuals.',
                'description_sw' => 'Kusaidia familia zilizo hatarini na watu wenye ulemavu.',
                'image' => 'outreach.jpg',
                'participants' => 300,
            ]
        ];

        $testimonials = [
            [
                'name' => 'Mary Wanjiku',
                'role' => 'Program Graduate',
                'role_sw' => 'Mhitimu wa Mradi',
                'quote' => 'Sauti ya Mtaa changed my life. Through their mentorship program, I gained confidence and skills that helped me start my own business.',
                'quote_sw' => 'Sauti ya Mtaa ilibadilisha maisha yangu. Kupitia mradi wao wa uongozaji, nilipata ujasiri na ujuzi ambao ulinisaidia kuanza biashara yangu.',
                'image' => 'mary.jpg'
            ],
            [
                'name' => 'John Kiprotich',
                'role' => 'Youth Leader',
                'role_sw' => 'Kiongozi wa Vijana',
                'quote' => 'The organization gave me a platform to voice the concerns of my community and work towards positive change.',
                'quote_sw' => 'Shirika lilinitia jukwaa la kusema wasiwasi wa jamii yangu na kufanya kazi kuelekea mabadiliko mazuri.',
                'image' => 'john.jpg'
            ]
        ];

        return view('home', compact('stats', 'featuredPrograms', 'testimonials'));
    }
}