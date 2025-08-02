<?php
// app/Http/Controllers/DonationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        $donationOptions = [
            [
                'amount' => 1000,
                'title' => 'Support a Youth',
                'title_sw' => 'Msaada kwa Kijana',
                'description' => 'Help provide basic needs for one youth for a month',
                'description_sw' => 'Saidia kutoa mahitaji ya msingi kwa kijana mmoja kwa mwezi'
            ],
            [
                'amount' => 5000,
                'title' => 'Skills Training',
                'title_sw' => 'Mafunzo ya Ujuzi',
                'description' => 'Fund vocational training for one person',
                'description_sw' => 'Gharama za mafunzo ya ufundi kwa mtu mmoja'
            ],
            [
                'amount' => 10000,
                'title' => 'Leadership Program',
                'title_sw' => 'Mradi wa Uongozi',
                'description' => 'Sponsor a youth through our leadership program',
                'description_sw' => 'Dhamini kijana kupitia mradi wetu wa uongozi'
            ]
        ];

        return view('donate', compact('donationOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'nullable|string|max:1000'
        ]);

        // Here you would integrate with payment gateway (M-Pesa, PayPal, etc.)
        // For now, we'll just flash a success message
        
        return redirect()->route('donate')->with('success', __('Thank you for your donation! We will contact you shortly with payment details.'));
    }
}