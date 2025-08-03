<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'title' => 'Youth Empowerment Program',
                'title_sw' => 'Mpango wa Kuwapa Nguvu Vijana',
                'slug' => 'youth-empowerment-program',
                'description' => 'Empowering young people with skills, knowledge, and opportunities to become leaders in their communities.',
                'description_sw' => 'Kuwapa nguvu vijana kupitia ujuzi, maarifa, na fursa za kuwa viongozi katika jamii zao.',
                'full_description' => 'Our Youth Empowerment Program is designed to provide young people aged 16-25 with the tools they need to succeed in life. Through workshops, mentorship, and hands-on activities, participants develop leadership skills, entrepreneurship knowledge, and social awareness. The program covers topics such as financial literacy, communication skills, career planning, and community engagement.',
                'full_description_sw' => 'Mpango wetu wa Kuwapa Nguvu Vijana umeundwa ili kuwapa vijana wa umri wa miaka 16-25 zana wanazohitaji ili kufanikiwa maishani. Kupitia warsha, uongozaji, na shughuli za vitendo, washiriki hupata ujuzi wa uongozi, maarifa ya ujasiriamali, na uelewa wa kijamii.',
                'duration' => '6 months',
                'duration_sw' => 'miezi 6',
                'participants' => 150,
                'status' => 'active',
                'sort_order' => 1,
                'objectives' => [
                    'Develop leadership and communication skills',
                    'Provide entrepreneurship training',
                    'Foster community engagement',
                    'Build financial literacy',
                    'Create networking opportunities'
                ],
                'requirements' => [
                    'Age between 16-25 years',
                    'Commitment to attend all sessions',
                    'Basic literacy skills',
                    'Community recommendation letter'
                ],
                'location' => 'Nairobi Community Center',
                'location_sw' => 'Kituo cha Jamii Nairobi',
                'cost' => null,
                'start_date' => now()->addMonth(),
                'end_date' => now()->addMonths(7),
                'is_featured' => true,
            ],
            [
                'title' => 'Women\'s Economic Empowerment',
                'title_sw' => 'Uwezeshaji wa Kiuchumi wa Wanawake',
                'slug' => 'womens-economic-empowerment',
                'description' => 'Supporting women to start and grow sustainable businesses while building financial independence.',
                'description_sw' => 'Kusaidia wanawake kuanza na kukuza biashara endelevu huku wakijenga uhuru wa kifedha.',
                'full_description' => 'This comprehensive program focuses on empowering women through economic opportunities. Participants receive training in business development, financial management, and market access. The program includes seed funding opportunities, mentorship from successful businesswomen, and ongoing support for business growth.',
                'full_description_sw' => 'Mpango huu wa kina unalenga kuwapa nguvu wanawake kupitia fursa za kiuchumi. Washiriki hupokea mafunzo katika maendeleo ya biashara, usimamizi wa fedha, na upatikanaji wa masoko.',
                'duration' => '9 months',
                'duration_sw' => 'miezi 9',
                'participants' => 200,
                'status' => 'active',
                'sort_order' => 2,
                'objectives' => [
                    'Develop business and entrepreneurial skills',
                    'Provide access to microfinance',
                    'Create women\'s support networks',
                    'Increase household income',
                    'Promote gender equality'
                ],
                'requirements' => [
                    'Women aged 18 and above',
                    'Valid identification document',
                    'Business idea or existing small business',
                    'Willingness to participate in group activities'
                ],
                'location' => 'Multiple locations across Nairobi',
                'location_sw' => 'Maeneo mbalimbali Nairobi',
                'cost' => 50.00,
                'start_date' => now()->subMonths(2),
                'end_date' => now()->addMonths(7),
                'is_featured' => true,
            ],
            [
                'title' => 'Community Health Education',
                'title_sw' => 'Elimu ya Afya ya Jamii',
                'slug' => 'community-health-education',
                'description' => 'Promoting health awareness and preventive care practices in underserved communities.',
                'description_sw' => 'Kukuza uelewa wa afya na mazoea ya kinga katika jamii zisizopata huduma za kutosha.',
                'full_description' => 'Our Community Health Education program aims to improve health outcomes by educating community members about preventive care, nutrition, hygiene, and common health conditions. The program trains community health volunteers who then conduct outreach activities in their neighborhoods.',
                'full_description_sw' => 'Mpango wetu wa Elimu ya Afya ya Jamii unalenga kuboresha matokeo ya afya kwa kuelimisha wanajamii kuhusu huduma za kinga, lishe, usafi, na hali za kawaida za afya.',
                'duration' => '3 months',
                'duration_sw' => 'miezi 3',
                'participants' => 500,
                'status' => 'active',
                'sort_order' => 3,
                'objectives' => [
                    'Increase health awareness in communities',
                    'Train community health volunteers',
                    'Reduce preventable diseases',
                    'Improve nutrition practices',
                    'Strengthen healthcare access'
                ],
                'requirements' => [
                    'Community members of all ages',
                    'Basic literacy preferred but not required',
                    'Commitment to sharing knowledge',
                    'Regular attendance at sessions'
                ],
                'location' => 'Various community centers',
                'location_sw' => 'Vituo mbalimbali vya jamii',
                'cost' => null,
                'start_date' => now()->subMonth(),
                'end_date' => now()->addMonths(2),
                'is_featured' => false,
            ],
            [
                'title' => 'Digital Literacy Program',
                'title_sw' => 'Mpango wa Ujuzi wa Kidijitali',
                'slug' => 'digital-literacy-program',
                'description' => 'Teaching essential computer and internet skills to bridge the digital divide.',
                'description_sw' => 'Kufundisha ujuzi muhimu wa kompyuta na mtandao ili kuunganisha pengo la kidijitali.',
                'full_description' => 'In today\'s digital world, computer literacy is essential for education, employment, and civic participation. This program provides basic computer training, internet navigation skills, and digital communication tools to help participants access opportunities in the digital economy.',
                'full_description_sw' => 'Katika ulimwengu wa kidijitali wa leo, ujuzi wa kompyuta ni muhimu kwa elimu, ajira, na ushiriki wa kiraia. Mpango huu hutoa mafunzo ya msingi ya kompyuta, ujuzi wa kutumia mtandao, na zana za mawasiliano ya kidijitali.',
                'duration' => '4 months',
                'duration_sw' => 'miezi 4',
                'participants' => 80,
                'status' => 'active',
                'sort_order' => 4,
                'objectives' => [
                    'Provide basic computer skills training',
                    'Teach internet navigation and safety',
                    'Introduce digital communication tools',
                    'Enable access to online opportunities',
                    'Reduce digital inequality'
                ],
                'requirements' => [
                    'Basic literacy skills',
                    'Age 16 and above',
                    'Commitment to complete the course',
                    'No prior computer experience required'
                ],
                'location' => 'Digital Learning Center',
                'location_sw' => 'Kituo cha Kujifunzia Kidijitali',
                'cost' => 25.00,
                'start_date' => now()->addWeeks(2),
                'end_date' => now()->addMonths(5),
                'is_featured' => false,
            ],
            [
                'title' => 'Environmental Conservation Initiative',
                'title_sw' => 'Mpango wa Uhifadhi wa Mazingira',
                'slug' => 'environmental-conservation-initiative',
                'description' => 'Engaging communities in environmental protection and sustainable development practices.',
                'description_sw' => 'Kushirikisha jamii katika ulinzi wa mazingira na mazoea ya maendeleo endelevu.',
                'full_description' => 'Our Environmental Conservation Initiative focuses on educating communities about climate change, promoting renewable energy, waste management, and tree planting activities. The program empowers participants to become environmental champions in their communities.',
                'full_description_sw' => 'Mpango wetu wa Uhifadhi wa Mazingira unazingatia kuelimisha jamii kuhusu mabadiliko ya hali ya anga, kukuza nishati mbadala, usimamizi wa taka, na shughuli za kupanda miti.',
                'duration' => '12 months',
                'duration_sw' => 'miezi 12',
                'participants' => 300,
                'status' => 'active',
                'sort_order' => 5,
                'objectives' => [
                    'Raise environmental awareness',
                    'Promote sustainable practices',
                    'Conduct tree planting activities',
                    'Improve waste management',
                    'Support renewable energy adoption'
                ],
                'requirements' => [
                    'Interest in environmental conservation',
                    'Community member or leader',
                    'Willingness to participate in outdoor activities',
                    'Commitment to long-term engagement'
                ],
                'location' => 'Multiple sites across Kenya',
                'location_sw' => 'Maeneo mbalimbali nchini Kenya',
                'cost' => null,
                'start_date' => now()->subMonths(3),
                'end_date' => now()->addMonths(9),
                'is_featured' => true,
            ],
            [
                'title' => 'Elderly Care Support Program',
                'title_sw' => 'Mpango wa Msaada wa Huduma za Wazee',
                'slug' => 'elderly-care-support-program',
                'description' => 'Providing comprehensive support and care services for elderly community members.',
                'description_sw' => 'Kutoa msaada mkuu na huduma za utunzaji kwa wazee wa jamii.',
                'full_description' => 'This program addresses the needs of elderly community members through healthcare support, social activities, and assistance with daily living activities. Volunteers are trained to provide companionship and basic care while connecting seniors with essential services.',
                'full_description_sw' => 'Mpango huu unashughulikia mahitaji ya wazee wa jamii kupitia msaada wa huduma za afya, shughuli za kijamii, na msaada katika shughuli za kila siku.',
                'duration' => 'Ongoing',
                'duration_sw' => 'Inaendelea',
                'participants' => 120,
                'status' => 'active',
                'sort_order' => 6,
                'objectives' => [
                    'Improve quality of life for seniors',
                    'Provide companionship and social support',
                    'Connect elderly with healthcare services',
                    'Train caregivers and volunteers',
                    'Promote intergenerational connections'
                ],
                'requirements' => [
                    'Compassionate and patient personality',
                    'Background check clearance',
                    'Basic first aid training preferred',
                    'Regular availability for visits'
                ],
                'location' => 'Home visits and community centers',
                'location_sw' => 'Ziara za nyumbani na vituo vya jamii',
                'cost' => null,
                'start_date' => null,
                'end_date' => null,
                'is_featured' => false,
            ]
        ];

        foreach ($programs as $programData) {
            Program::create($programData);
        }
    }
}