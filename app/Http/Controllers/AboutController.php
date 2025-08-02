<?php
// app/Http/Controllers/AboutController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $teamMembers = [
            [
                'name' => 'Sarah Mwangi',
                'position' => 'Executive Director',
                'position_sw' => 'Mkurugenzi Mtendaji',
                'bio' => 'Passionate about youth empowerment with over 10 years of experience in community development.',
                'bio_sw' => 'Ana shauku ya kuongoza vijana na uzoefu wa zaidi ya miaka 10 katika maendeleo ya kijamii.',
                'image' => 'sarah.jpg'
            ],
            [
                'name' => 'David Ochieng',
                'position' => 'Programs Manager',
                'position_sw' => 'Meneja wa Mipango',
                'bio' => 'Dedicated to creating sustainable programs that make lasting impact in communities.',
                'bio_sw' => 'Amejitolea kuunda mipango endelevu inayofanya athari ya kudumu katika jamii.',
                'image' => 'david.jpg'
            ]
        ];

        return view('about', compact('teamMembers'));
    }
}

