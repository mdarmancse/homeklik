<?php

namespace App\Database\Seeds;
use \CodeIgniter\I18n\Time;
use CodeIgniter\Database\Seeder;

class SystemOptionSeeder extends Seeder
{
    public function run()
    {
        $data = [
        
            // app - General App Settings
            [
                'id'     => 1,
                'option_name'            => 'Android Version' ,
                'option_slug'          => 'android_version',
                'option_value'     => 2.0,
                'created_at'         => Time::now()
                
            ],
            
            [
                'id'     => 2,
                'option_name'            => 'Ios Version' ,
                'option_slug'          => 'ios_version',
                'option_value'     => 1.0,
                'created_at'         => Time::now()
            ],
            
            [
                'id'     => 3,
                'option_name'            => 'Distance' ,
                'option_slug'          => 'distance',
                'option_value'     => 1000,
                'created_at'         => Time::now()
            ],
            [
                'id'     => 4,
                'option_name'            => 'Price Min Value' ,
                'option_slug'          => 'price_min_value',
                'option_value'     => 1000,
                'created_at'         => Time::now()
            ],
            [
                'id'     => 5,
                'option_name'            => 'Price Max Value' ,
                'option_slug'          => 'price_max_value',
                'option_value'     => 15000,
                'created_at'         => Time::now()
            ],
            [
                'id'     => 6,
                'option_name'            => 'GDS' ,
                'option_slug'          => 'gds',
                'option_value'     => 15000,
                'created_at'         => Time::now()
            ],
            [
                'id'     => 7,
                'option_name'            => 'TDS' ,
                'option_slug'          => 'tds',
                'option_value'     => 15000,
                'created_at'         => Time::now()
            ],
            [
                'id'     => 8,
                'option_name'            => 'About Us' ,
                'option_slug'          => 'about_us',
                'option_value'     => 'Lorem Ipsum is simply dummy text of the printing and 
                                        typesetting industry. Lorem Ipsum has been the industrys standard dummy text
                                        ever since the 1500s, when an unknown printer took a galley of type and
                                        scrambled it to make a type specimen book. It has survived not only five
                                        centuries, but also the leap into electronic typesetting, remaining essentially
                                            unchanged. It was popularised in the 1960s with the release of Letraset sheets
                                            containing Lorem Ipsum passages, and more recently with desktop publishing 
                                            software like Aldus PageMaker including versions of Lorem Ipsum',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 9,
                'option_name'            => 'Contact Us' ,
                'option_slug'          => 'contact_us',
                'option_value'     => 'Lorem Ipsum is simply dummy text of the printing and 
                                    typesetting industry. Lorem Ipsum has been the industrys standard dummy text
                                    ever since the 1500s, when an unknown printer took a galley of type and
                                    scrambled it to make a type specimen book. It has survived not only five
                                    centuries, but also the leap into electronic typesetting, remaining essentially
                                        unchanged. It was popularised in the 1960s with the release of Letraset sheets
                                        containing Lorem Ipsum passages, and more recently with desktop publishing 
                                        software like Aldus PageMaker including versions of Lorem Ipsum',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 10,
                'option_name'            => 'Latitude' ,
                'option_slug'          => 'latitude',
                'option_value'     => '43.653226',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 11,
                'option_name'            => 'Longitude' ,
                'option_slug'          => 'longitude',
                'option_value'     => '-79.3831843',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 12,
                'option_name'            => 'Privacy Policy' ,
                'option_slug'          => 'privacy_policy',
                'option_value'     => 'Last updated April 20, 2017 Our Commitment to Privacy Homeklik is committed to 
                                    respecting and maintaining the security, confidentiality and privacy of your personal information.
                                    This Privacy Policy documents our on-going commitment to you and has been developed in compliance
                                    with the Personal Information Protection and Electronic Documents Act. This Privacy Policy is 
                                    subject to change from time to time. Scope of Privacy Policy • This Policy applies to Homeklik
                                    Inc. and to its website, Homeklik.com. This Privacy Policy addresses personal information about
                                        identifiable individuals and does not apply to the information collected, used or disclosed with
                                        respect to corporate or commercial entities. • This Policy does not impose any limits on the collection,
                                        use or disclosure of your business contact information, and certain publicly available information. •
                                        Homeklik operates the website homeklik.ca, which may hosts public forums, message boards, and other
                                            news groups available to its users. Information that you disclosed in these areas of the website become 
                                            public information and is not governed or protected by this Privacy Policy. • Homeklik may refer
                                            you to third party goods and services providers. These parties will have their own respective privacy
                                            policies independent of Homekliks',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 13,
                'option_name'            => 'Terms & Condition' ,
                'option_slug'          => 'terms_condition',
                'option_value'     => 'Last updated April 20, 2017 Our Commitment to Privacy Homeklik is committed to 
                                    respecting and maintaining the security, confidentiality and privacy of your personal information.
                                    This Privacy Policy documents our on-going commitment to you and has been developed in compliance
                                    with the Personal Information Protection and Electronic Documents Act. This Privacy Policy is 
                                    subject to change from time to time. Scope of Privacy Policy • This Policy applies to Homeklik
                                    Inc. and to its website, Homeklik.com. This Privacy Policy addresses personal information about
                                        identifiable individuals and does not apply to the information collected, used or disclosed with
                                        respect to corporate or commercial entities. • This Policy does not impose any limits on the collection,
                                        use or disclosure of your business contact information, and certain publicly available information. •
                                        Homeklik operates the website homeklik.ca, which may hosts public forums, message boards, and other
                                            news groups available to its users. Information that you disclosed in these areas of the website become 
                                            public information and is not governed or protected by this Privacy Policy. • Homeklik may refer
                                            you to third party goods and services providers. These parties will have their own respective privacy
                                            policies independent of Homekliks',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 14,
                'option_name'            => 'Birthday Greeting Message' ,
                'option_slug'          => 'birthday_greeting',
                'option_value'     => 'Hey ! Happy Birthday!',
                'created_at'         => Time::now()
            ],
        ];
        $this->db->table('system_option')->insertBatch($data);
    }
}
