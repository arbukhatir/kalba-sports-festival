<?php
/* Content ported from the original app.js — single source of truth for the
   server-rendered pages. Edit here to change sports, schedule, forms, etc. */

$GALLERY = [
  [
    'src' => 'gallery/opening-ceremony.webp',
    'cap' => [
      'ar' => 'حفل افتتاح دورة كلباء للألعاب الشاطئية',
      'en' => 'Kalba Beach Games opening ceremony'
    ]
  ],
  [
    'src' => 'gallery/officials.webp',
    'cap' => [
      'ar' => 'حضور رسمي رفيع للفعاليات',
      'en' => 'Official dignitaries attending the events'
    ]
  ],
  [
    'src' => 'gallery/beach-challenges.webp',
    'cap' => [
      'ar' => 'تحديات رياضية على شاطئ كلباء',
      'en' => 'Beach challenges on the Kalba shore'
    ]
  ],
  [
    'src' => 'gallery/beach-football.webp',
    'cap' => [
      'ar' => 'فرحة التسجيل — كرة القدم الشاطئية',
      'en' => 'Beach football — goal celebrations'
    ]
  ],
  [
    'src' => 'gallery/sand-action.webp',
    'cap' => [
      'ar' => 'منافسات قوية على الرمال',
      'en' => 'Fierce action on the sand'
    ]
  ]
];

/* Official contact channels. Fill these in with the festival's real details;
   any line left empty is simply not rendered, so nothing shows a dead link. */
$CONTACT = [
  'email'    => '',            // e.g. info@kalbasports.ae
  'phone'    => '',            // international format, e.g. +97165551234
  'whatsapp' => '',            // digits only, e.g. 97150XXXXXXX
  'address'  => ['ar' => 'كورنيش كلباء، مدينة كلباء، إمارة الشارقة', 'en' => 'Kalba Corniche, Kalba, Sharjah'],
  'hours'    => ['ar' => 'خلال أيام المهرجان: 4:00 مساءً – 11:00 مساءً', 'en' => 'During the festival: 4:00 PM – 11:00 PM'],
];

$CHAMP_CATS = [
  [
    'k' => 'team',
    'ar' => 'الألعاب الجماعية',
    'en' => 'Team Sports'
  ],
  [
    'k' => 'solo',
    'ar' => 'الألعاب الفردية',
    'en' => 'Individual Sports'
  ],
  [
    'k' => 'marine',
    'ar' => 'الألعاب البحرية',
    'en' => 'Marine Sports'
  ],
  [
    'k' => 'esport',
    'ar' => 'الألعاب الإلكترونية',
    'en' => 'Esports'
  ]
];

$ROUNDS = [
  'm4' => [
    'ar' => '4 مباريات',
    'en' => '4 matches'
  ],
  'gr' => [
    'ar' => 'دور المجموعات',
    'en' => 'Group stage'
  ],
  'qf' => [
    'ar' => 'دور ربع النهائي',
    'en' => 'Quarter-finals'
  ],
  'sf' => [
    'ar' => 'دور نصف النهائي',
    'en' => 'Semi-finals'
  ],
  'fin' => [
    'ar' => 'الأدوار النهائية',
    'en' => 'Finals'
  ],
  'wch' => [
    'ar' => 'نهائيات الكراسي المتحركة',
    'en' => 'Wheelchair finals'
  ],
  'wom' => [
    'ar' => 'منافسات السيدات',
    'en' => 'Women\'s competition'
  ],
  'men' => [
    'ar' => 'نهائيات الرجال',
    'en' => 'Men\'s finals'
  ],
  'sco' => [
    'ar' => 'نهائيات المدارس',
    'en' => 'Schools finals'
  ]
];

$CHAMPS = [
  [
    's' => 'boxing',
    'zone' => 'boxing',
    'c' => 'solo',
    'ic' => '🥊',
    'ar' => 'الملاكمة',
    'en' => 'Boxing',
    'f' => '',
    'img' => 'champs/ai-boxing.webp',
    'sch' => [
      [
        '12/11',
        '16:00–22:00',
        'gr'
      ],
      [
        '13/11',
        '16:00–22:00',
        'fin'
      ]
    ]
  ],
  [
    's' => 'jiujitsu',
    'zone' => 'jiujitsu',
    'c' => 'solo',
    'ic' => '🥋',
    'ar' => 'الجيوجيستو',
    'en' => 'Jiu-Jitsu',
    'f' => '',
    'img' => 'champs/ai-jiujitsu.webp',
    'sch' => [
      [
        '12/11',
        '16:00–22:00',
        'gr'
      ],
      [
        '13/11',
        '16:00–22:00',
        'fin'
      ]
    ]
  ],
  [
    's' => 'taekwondo',
    'zone' => 'taekwondo',
    'c' => 'solo',
    'ic' => '🥋',
    'ar' => 'التايكوندو',
    'en' => 'Taekwondo',
    'f' => '',
    'img' => 'champs/ai-taekwondo.webp',
    'sch' => [
      [
        '12/11',
        '16:00–22:00',
        'gr'
      ],
      [
        '13/11',
        '16:00–22:00',
        'fin'
      ]
    ]
  ],
  [
    's' => 'running',
    'c' => 'solo',
    'ic' => '🏃',
    'ar' => 'سباق مهرجان كلباء للجري',
    'en' => 'Kalba Festival Running Race',
    'f' => '',
    'img' => 'champs/ai-running.webp',
    'sch' => [
      [
        '07/11',
        '16:00–22:00',
        'fin'
      ]
    ]
  ],
  [
    's' => 'cycling',
    'c' => 'solo',
    'ic' => '🚴',
    'ar' => 'سباق مهرجان كلباء للدراجات',
    'en' => 'Kalba Festival Cycling Race',
    'f' => '',
    'img' => 'champs/ai-cycling.webp',
    'sch' => [
      [
        '08/11',
        '16:00–22:00',
        'fin'
      ]
    ]
  ],
  [
    's' => 'obstacles',
    'zone' => 'barriers',
    'c' => 'solo',
    'ic' => '🧗',
    'ar' => 'الحواجز والمانع',
    'en' => 'Obstacle Course',
    'f' => '',
    'img' => 'champs/ai-obstacles.webp',
    'sch' => [
      [
        '13/11',
        '16:00–22:00',
        'fin'
      ]
    ]
  ],
  [
    's' => 'football',
    'zone' => 'football',
    'team' => ['min' => 7, 'max' => 12],
    'c' => 'team',
    'ic' => '<img src="portals/BeachSoccer.png" class="sport-icon" alt="">',
    'ar' => 'كرة القدم',
    'en' => 'Football',
    'f' => '',
    'img' => 'champs/ai-football.webp',
    'sch' => [
      [
        '06/11',
        '16:00–21:00',
        'm4'
      ],
      [
        '07/11',
        '16:00–21:00',
        'm4'
      ],
      [
        '08/11',
        '16:00–21:00',
        'm4'
      ],
      [
        '09/11',
        '16:00–21:00',
        'm4'
      ],
      [
        '10/11',
        '16:00–21:00',
        'm4'
      ],
      [
        '11/11',
        '16:00–21:00',
        'm4'
      ],
      [
        '12/11',
        '16:00–22:00',
        'qf'
      ],
      [
        '13/11',
        '16:00–22:00',
        'sf'
      ]
    ]
  ],
  [
    's' => 'basketball',
    'zone' => 'basketball-stands',
    'team' => ['min' => 3, 'max' => 5],
    'c' => 'team',
    'ic' => '<img src="portals/Basketball.png" class="sport-icon" alt="">',
    'ar' => 'كرة السلة',
    'en' => 'Basketball',
    'f' => '',
    'img' => 'champs/ai-basketball-3x3.webp',
    'sch' => [
      [
        '07/11',
        '16:00',
        'wch'
      ],
      [
        '08/11',
        '16:00–22:00',
        'wom'
      ],
      [
        '09/11',
        '16:00–22:00',
        'men'
      ],
      [
        '10/11',
        '16:00–22:00',
        'sco'
      ]
    ]
  ],
  [
    's' => 'community-volleyball',
    'zone' => 'community-volleyball',
    'team' => ['min' => 6, 'max' => 12],
    'c' => 'team',
    'ic' => '<img src="portals/BeachVolleyball.png" class="sport-icon" alt="">',
    'ar' => 'كرة الطائرة المجتمعية',
    'en' => 'Community Volleyball',
    'f' => '',
    'img' => 'champs/ai-volleyball-community.webp',
    'sch' => [
      [
        '06/11',
        '16:00–21:00',
        'm4'
      ],
      [
        '07/11',
        '16:00–21:00',
        'm4'
      ],
      [
        '08/11',
        '16:00–21:00',
        'm4'
      ],
      [
        '09/11',
        '16:00–21:00',
        'm4'
      ],
      [
        '10/11',
        '16:00–21:00',
        'm4'
      ],
      [
        '11/11',
        '16:00–21:00',
        'm4'
      ],
      [
        '12/11',
        '16:00–22:00',
        'qf'
      ],
      [
        '13/11',
        '16:00–22:00',
        'sf'
      ]
    ]
  ],
  [
    's' => 'padel',
    'zone' => 'tennis',
    'team' => ['min' => 2, 'max' => 4],
    'c' => 'team',
    'ic' => '🎾',
    'ar' => 'البادل',
    'en' => 'Padel',
    'f' => '',
    'img' => 'champs/ai-padel.webp',
    'sch' => [
      [
        '07/11',
        '16:00–22:00',
        'gr'
      ],
      [
        '08/11',
        '16:00–22:00',
        'gr'
      ],
      [
        '09/11',
        '16:00–22:00',
        'fin'
      ]
    ]
  ],
  [
    's' => 'airsoft',
    'zone' => 'airsoft',
    'team' => ['min' => 5, 'max' => 10],
    'c' => 'team',
    'ic' => '🎯',
    'ar' => 'ايرسويفت',
    'en' => 'Airsoft',
    'f' => '',
    'img' => 'champs/ai-airsoft.webp',
    'sch' => [
      [
        '11/11',
        '16:00–22:00',
        'gr'
      ],
      [
        '12/11',
        '16:00–22:00',
        'gr'
      ],
      [
        '13/11',
        '16:00–22:00',
        'fin'
      ]
    ]
  ],
  [
    's' => 'kayak',
    'c' => 'marine',
    'ic' => '🛶',
    'ar' => 'الكاياك',
    'en' => 'Kayak',
    'f' => '',
    'img' => 'champs/ai-kayak.webp',
    'sch' => [
      [
        '12/11',
        '16:00–22:00',
        'fin'
      ]
    ]
  ],
  [
    's' => 'schools-esports',
    'zone' => 'egames',
    'c' => 'esport',
    'ic' => '🎮',
    'ar' => 'تحدي المدارس الإلكترونية',
    'en' => 'Schools Esports Challenge',
    'f' => '',
    'img' => 'champs/ai-schools-esports.webp',
    'sch' => [
      [
        '09/11',
        '16:00–22:00',
        'gr'
      ],
      [
        '10/11',
        '16:00–22:00',
        'gr'
      ],
      [
        '11/11',
        '16:00–22:00',
        'fin'
      ]
    ]
  ]
];

$FORMS = [
  'food' => [
    'ic' => '🍽️',
    't' => [
      'ar' => 'المطاعم وعربات الطعام',
      'en' => 'Restaurants & Food Trucks'
    ],
    'd' => [
      'ar' => 'الاسم التجاري، نوع المأكولات، الرخصة، المساحة، الكهرباء/المياه، أيام الحضور',
      'en' => 'Trade name, food type, license, area, utilities, attendance days'
    ],
    'fields' => [
      [
        'n' => 'trade',
        't' => 'text',
        'r' => 1,
        'l' => [
          'ar' => 'الاسم التجاري',
          'en' => 'Trade name'
        ]
      ],
      [
        'n' => 'ftype',
        't' => 'select',
        'r' => 1,
        'l' => [
          'ar' => 'نوع المأكولات',
          'en' => 'Food type'
        ],
        'o' => [
          [
            'ar' => 'مطعم',
            'en' => 'Restaurant'
          ],
          [
            'ar' => 'عربة طعام',
            'en' => 'Food truck'
          ],
          [
            'ar' => 'مقهى',
            'en' => 'Café'
          ],
          [
            'ar' => 'حلويات',
            'en' => 'Sweets'
          ]
        ]
      ],
      [
        'n' => 'lic',
        't' => 'text',
        'r' => 1,
        'l' => [
          'ar' => 'رقم الرخصة التجارية',
          'en' => 'Trade license no.'
        ]
      ],
      [
        'n' => 'area',
        't' => 'number',
        'r' => 1,
        'l' => [
          'ar' => 'المساحة المطلوبة (م²)',
          'en' => 'Required area (m²)'
        ]
      ],
      [
        'n' => 'util',
        't' => 'checks',
        'r' => 0,
        'l' => [
          'ar' => 'الاحتياجات',
          'en' => 'Utilities'
        ],
        'o' => [
          [
            'ar' => 'كهرباء',
            'en' => 'Electricity'
          ],
          [
            'ar' => 'مياه',
            'en' => 'Water'
          ]
        ]
      ],
      [
        'n' => 'days',
        't' => 'days',
        'r' => 1,
        'l' => [
          'ar' => 'أيام الحضور',
          'en' => 'Attendance days'
        ]
      ]
    ]
  ],
  'games' => [
    'ic' => '🎠',
    't' => [
      'ar' => 'موردو الألعاب (منطقة الأطفال)',
      'en' => 'Games Suppliers (Kids Zone)'
    ],
    'd' => [
      'ar' => 'شهادة السلامة ووثيقة التأمين إلزامية وترفع عبر النموذج مباشرة',
      'en' => 'Safety certificate & accident insurance are mandatory uploads'
    ],
    'fields' => [
      [
        'n' => 'gname',
        't' => 'text',
        'r' => 1,
        'l' => [
          'ar' => 'اسم اللعبة',
          'en' => 'Game name'
        ]
      ],
      [
        'n' => 'gtype',
        't' => 'select',
        'r' => 1,
        'l' => [
          'ar' => 'نوع الألعاب',
          'en' => 'Games type'
        ],
        'o' => [
          [
            'ar' => 'ألعاب هوائية',
            'en' => 'Inflatables'
          ],
          [
            'ar' => 'كهربائية',
            'en' => 'Electric rides'
          ],
          [
            'ar' => 'مهارات',
            'en' => 'Skill games'
          ],
          [
            'ar' => 'تعليمية',
            'en' => 'Educational'
          ]
        ]
      ],
      [
        'n' => 'ages',
        't' => 'checks',
        'r' => 1,
        'l' => [
          'ar' => 'الفئة العمرية',
          'en' => 'Age category'
        ],
        'o' => [
          [
            'ar' => '3–6',
            'en' => '3–6'
          ],
          [
            'ar' => '7–12',
            'en' => '7–12'
          ],
          [
            'ar' => '+13',
            'en' => '13+'
          ]
        ]
      ],
      [
        'n' => 'area',
        't' => 'number',
        'r' => 1,
        'l' => [
          'ar' => 'المساحة (م²)',
          'en' => 'Area (m²)'
        ]
      ],
      [
        'n' => 'sup',
        't' => 'number',
        'r' => 1,
        'l' => [
          'ar' => 'عدد المشرفين',
          'en' => 'Supervisors count'
        ]
      ],
      [
        'n' => 'elec',
        't' => 'textarea',
        'r' => 0,
        'l' => [
          'ar' => 'متطلبات الكهرباء',
          'en' => 'Electricity requirements'
        ]
      ],
      [
        'n' => 'safety',
        't' => 'file',
        'r' => 1,
        'l' => [
          'ar' => 'شهادة السلامة (إلزامي)',
          'en' => 'Safety certificate (mandatory)'
        ]
      ],
      [
        'n' => 'insur',
        't' => 'file',
        'r' => 1,
        'l' => [
          'ar' => 'وثيقة التأمين ضد الحوادث (إلزامي)',
          'en' => 'Accident insurance (mandatory)'
        ]
      ]
    ]
  ],
  'exhibitor' => [
    'ic' => '🛍️',
    't' => [
      'ar' => 'العارضون والأكشاك',
      'en' => 'Exhibitors & Kiosks'
    ],
    'd' => [
      'ar' => 'حِرف يدوية ومنتجات محلية',
      'en' => 'Crafts & local products'
    ],
    'fields' => [
      [
        'n' => 'atype',
        't' => 'select',
        'r' => 1,
        'l' => [
          'ar' => 'نوع النشاط',
          'en' => 'Activity type'
        ],
        'o' => [
          [
            'ar' => 'حِرف يدوية',
            'en' => 'Handicrafts'
          ],
          [
            'ar' => 'منتجات محلية',
            'en' => 'Local products'
          ],
          [
            'ar' => 'أخرى',
            'en' => 'Other'
          ]
        ]
      ],
      [
        'n' => 'products',
        't' => 'textarea',
        'r' => 1,
        'l' => [
          'ar' => 'المنتجات / الخدمات',
          'en' => 'Products / services'
        ]
      ],
      [
        'n' => 'area',
        't' => 'number',
        'r' => 1,
        'l' => [
          'ar' => 'المساحة (م²)',
          'en' => 'Area (m²)'
        ]
      ],
      [
        'n' => 'reqs',
        't' => 'textarea',
        'r' => 0,
        'l' => [
          'ar' => 'متطلبات المساحة والكهرباء',
          'en' => 'Area & electricity requirements'
        ]
      ]
    ]
  ],
  'sponsor' => [
    'ic' => '🤝',
    't' => [
      'ar' => 'الرعاة والشركاء',
      'en' => 'Sponsors & Partners'
    ],
    'd' => [
      'ar' => 'اسم الجهة وفئة الرعاية وجهة الاتصال',
      'en' => 'Entity, category & contact'
    ],
    'fields' => [
      [
        'n' => 'entity',
        't' => 'text',
        'r' => 1,
        'l' => [
          'ar' => 'اسم الجهة',
          'en' => 'Entity name'
        ]
      ],
      [
        'n' => 'cat',
        't' => 'select',
        'r' => 1,
        'l' => [
          'ar' => 'فئة الرعاية / حزمة الشراكة',
          'en' => 'Category / package'
        ],
        'o' => [
          [
            'ar' => 'بلاتيني',
            'en' => 'Platinum'
          ],
          [
            'ar' => 'ذهبي',
            'en' => 'Gold'
          ],
          [
            'ar' => 'فضي',
            'en' => 'Silver'
          ],
          [
            'ar' => 'شريك دعم',
            'en' => 'Partner'
          ]
        ]
      ],
      [
        'n' => 'auth',
        't' => 'textarea',
        'r' => 0,
        'l' => [
          'ar' => 'الأشخاص المخولون بالتواصل',
          'en' => 'Authorized contacts'
        ]
      ]
    ]
  ],
  'volunteer' => [
    'ic' => '🙌',
    't' => [
      'ar' => 'المتطوعون',
      'en' => 'Volunteers'
    ],
    'd' => [
      'ar' => 'الاسم والعمر والمهارات وأيام التوفر',
      'en' => 'Name, age, skills & availability'
    ],
    'fields' => [
      [
        'n' => 'age',
        't' => 'number',
        'r' => 1,
        'l' => [
          'ar' => 'العمر',
          'en' => 'Age'
        ]
      ],
      [
        'n' => 'gender',
        't' => 'select',
        'r' => 1,
        'l' => [
          'ar' => 'الجنس',
          'en' => 'Gender'
        ],
        'o' => [
          [
            'ar' => 'ذكر',
            'en' => 'Male'
          ],
          [
            'ar' => 'أنثى',
            'en' => 'Female'
          ]
        ]
      ],
      [
        'n' => 'exp',
        't' => 'textarea',
        'r' => 0,
        'l' => [
          'ar' => 'خبرات سابقة',
          'en' => 'Previous experience'
        ]
      ],
      [
        'n' => 'skills',
        't' => 'checks',
        'r' => 1,
        'l' => [
          'ar' => 'المهارات',
          'en' => 'Skills'
        ],
        'o' => [
          [
            'ar' => 'تنظيم',
            'en' => 'Organizing'
          ],
          [
            'ar' => 'استقبال',
            'en' => 'Reception'
          ],
          [
            'ar' => 'إسعافات أولية',
            'en' => 'First aid'
          ],
          [
            'ar' => 'ترجمة',
            'en' => 'Translation'
          ],
          [
            'ar' => 'تصوير وإعلام',
            'en' => 'Media'
          ]
        ]
      ],
      [
        'n' => 'days',
        't' => 'days',
        'r' => 1,
        'l' => [
          'ar' => 'أيام التوفر',
          'en' => 'Availability days'
        ]
      ]
    ]
  ],
  'talent' => [
    'ic' => '🎭',
    't' => [
      'ar' => 'المواهب ومقدمو العروض',
      'en' => 'Talents & Performers'
    ],
    'd' => [
      'ar' => 'نوع العرض والمدة والمتطلبات الفنية',
      'en' => 'Show type, duration & tech needs'
    ],
    'fields' => [
      [
        'n' => 'stype',
        't' => 'select',
        'r' => 1,
        'l' => [
          'ar' => 'نوع العرض',
          'en' => 'Show type'
        ],
        'o' => [
          [
            'ar' => 'فني',
            'en' => 'Artistic'
          ],
          [
            'ar' => 'موسيقي',
            'en' => 'Musical'
          ],
          [
            'ar' => 'رياضي',
            'en' => 'Sports'
          ],
          [
            'ar' => 'تراثي',
            'en' => 'Heritage'
          ]
        ]
      ],
      [
        'n' => 'dur',
        't' => 'number',
        'r' => 1,
        'l' => [
          'ar' => 'المدة (دقائق)',
          'en' => 'Duration (min)'
        ]
      ],
      [
        'n' => 'tech',
        't' => 'textarea',
        'r' => 0,
        'l' => [
          'ar' => 'المتطلبات الفنية',
          'en' => 'Technical requirements'
        ]
      ],
      [
        'n' => 'avail',
        't' => 'days',
        'r' => 1,
        'l' => [
          'ar' => 'جدول التوفر',
          'en' => 'Availability schedule'
        ]
      ],
      [
        'n' => 'port',
        't' => 'file',
        'r' => 0,
        'l' => [
          'ar' => 'مرفقات الأعمال',
          'en' => 'Portfolio'
        ]
      ]
    ]
  ],
  'sports' => [
    'ic' => '🏅',
    't' => [
      'ar' => 'المسابقات الرياضية',
      'en' => 'Sports Competitions'
    ],
    'd' => [
      'ar' => 'يُنشأ حسابك تلقائياً بعد التسجيل — يصلك الرقم السري PIN ورمز QR على بريدك ويُمسح الرمز عند كل مباراة',
      'en' => 'Your account is created automatically — PIN + QR arrive by email; the QR is scanned at each game'
    ],
    'fields' => [
      [
        'n' => 'act',
        't' => 'select',
        'r' => 1,
        'l' => [
          'ar' => 'المسابقة',
          'en' => 'Competition'
        ],
        'o' => [
          [
            'ar' => 'تحدي القوة',
            'en' => 'Strength'
          ],
          [
            'ar' => 'الكاياك',
            'en' => 'Kayak'
          ],
          [
            'ar' => 'الجري',
            'en' => 'Running'
          ],
          [
            'ar' => 'السباحة',
            'en' => 'Swimming'
          ],
          [
            'ar' => 'كرة القدم الشاطئية',
            'en' => 'Beach football'
          ]
        ]
      ],
      [
        'n' => 'acat',
        't' => 'select',
        'r' => 1,
        'l' => [
          'ar' => 'الفئة العمرية',
          'en' => 'Age category'
        ],
        'o' => [
          [
            'ar' => 'أطفال',
            'en' => 'Children'
          ],
          [
            'ar' => 'ناشئون',
            'en' => 'Teens'
          ],
          [
            'ar' => 'كبار',
            'en' => 'Adults'
          ]
        ]
      ],
      [
        'n' => 'team',
        't' => 'text',
        'r' => 0,
        'l' => [
          'ar' => 'اسم الفريق',
          'en' => 'Team name'
        ]
      ],
      [
        'n' => 'iban',
        't' => 'file',
        'r' => 1,
        'l' => [
          'ar' => 'شهادة الآيبان IBAN من البنك (لصرف الجوائز)',
          'en' => 'IBAN certificate from the bank (for prize payouts)'
        ]
      ]
    ]
  ],
  'media' => [
    'ic' => '📸',
    't' => [
      'ar' => 'الإعلام والصحافة',
      'en' => 'Media & Press'
    ],
    'd' => [
      'ar' => 'الجهة ونوع التغطية وتواريخ الحضور',
      'en' => 'Outlet, coverage type & dates'
    ],
    'fields' => [
      [
        'n' => 'entity',
        't' => 'text',
        'r' => 1,
        'l' => [
          'ar' => 'الجهة الإعلامية',
          'en' => 'Media outlet'
        ]
      ],
      [
        'n' => 'ctype',
        't' => 'select',
        'r' => 1,
        'l' => [
          'ar' => 'نوع التغطية',
          'en' => 'Coverage'
        ],
        'o' => [
          [
            'ar' => 'تلفزيونية',
            'en' => 'TV'
          ],
          [
            'ar' => 'صحفية',
            'en' => 'Press'
          ],
          [
            'ar' => 'رقمية',
            'en' => 'Digital'
          ],
          [
            'ar' => 'إذاعية',
            'en' => 'Radio'
          ]
        ]
      ],
      [
        'n' => 'equip',
        't' => 'textarea',
        'r' => 0,
        'l' => [
          'ar' => 'المعدات المطلوبة',
          'en' => 'Required equipment'
        ]
      ],
      [
        'n' => 'days',
        't' => 'days',
        'r' => 1,
        'l' => [
          'ar' => 'تواريخ الحضور',
          'en' => 'Attendance dates'
        ]
      ]
    ]
  ]
];

$NEWS = [
  [
    'u' => 1,
    'ar' => 'افتتاح باب التسجيل في الرياضات الـ15 المعتمدة',
    'en' => 'Registration opens for the 15 approved sports'
  ],
  [
    'u' => 0,
    'ar' => 'الكشف عن مسار سباق الجري على الكورنيش',
    'en' => 'Running race route revealed along the Corniche'
  ],
  [
    'u' => 0,
    'ar' => 'ورش صحية مجانية بمقاعد محدودة — احجز مبكراً',
    'en' => 'Free health workshops, limited seats — book early'
  ]
];

$FAQ_CATS = [
  [
    'k' => 'reg',
    'ar' => 'التسجيل والمشاركة',
    'en' => 'Registration'
  ],
  [
    'k' => 'pass',
    'ar' => 'التصاريح والدخول',
    'en' => 'Passes & entry'
  ],
  [
    'k' => 'points',
    'ar' => 'النقاط والجوائز',
    'en' => 'Points & prizes'
  ],
  [
    'k' => 'events',
    'ar' => 'الورش والفعاليات',
    'en' => 'Workshops & events'
  ]
];

$FAQS = [
  [
    'c' => 'reg',
    'q' => [
      'ar' => 'كيف أسجل للمشاركة في البطولات؟',
      'en' => 'How do I register for a championship?'
    ],
    'a' => [
      'ar' => 'اختر بطولتك من صفحة البطولات واضغط «سجّل الآن» — تحصل فوراً على رقم تسجيل ورمز QR وتتابع حالة طلبك من نفس الصفحة.',
      'en' => 'Pick your championship, press Register Now — you instantly get a reg number and QR and can track your status.'
    ]
  ],
  [
    'c' => 'reg',
    'q' => [
      'ar' => 'ما المستندات المطلوبة؟',
      'en' => 'What documents are required?'
    ],
    'a' => [
      'ar' => 'صورة الهوية للمشاركين الرياضيين وشهادة طبية عند الحاجة، وشهادة السلامة والتأمين لموردي ألعاب الأطفال.',
      'en' => 'ID for athletes and a medical certificate when required; safety certificate and insurance for kids-zone suppliers.'
    ]
  ],
  [
    'c' => 'reg',
    'q' => [
      'ar' => 'هل يمكن للمدارس المشاركة؟',
      'en' => 'Can schools take part?'
    ],
    'a' => [
      'ar' => 'نعم — تحدي مدارس كلباء يمتد خمسة أيام بتحديات معرفية ورياضية وإبداعية، مع لوحات متصدرين يومية وكأس للمدرسة الأعلى نقاطاً.',
      'en' => 'Yes — the Kalba Schools Challenge runs five days of knowledge, sports and creative challenges, with daily leaderboards and a cup for the top school.'
    ]
  ],
  [
    'c' => 'pass',
    'q' => [
      'ar' => 'ما هو تصريح الزيارة؟',
      'en' => 'What is the visitor pass?'
    ],
    'a' => [
      'ar' => 'تصريح رقمي مجاني برمز QR يُمسح عند الدخول ويجمع نقاطك، مع خيار عائلي موحد حتى 12 فرداً.',
      'en' => 'A free digital QR pass scanned at entry that also collects your points, with a family option up to 12 people.'
    ]
  ],
  [
    'c' => 'pass',
    'q' => [
      'ar' => 'متى وأين يقام المهرجان؟',
      'en' => 'When and where is the festival?'
    ],
    'a' => [
      'ar' => 'من 6 إلى 13 نوفمبر 2026 على كورنيش كلباء بإمارة الشارقة، وتمتد الفعاليات إلى مواقع أخرى في المدينة.',
      'en' => 'From 6 to 13 November 2026 on the Kalba Corniche, Emirate of Sharjah, with events extending to other sites across the city.'
    ]
  ],
  [
    'c' => 'points',
    'q' => [
      'ar' => 'كيف يعمل نظام النقاط؟',
      'en' => 'How do points work?'
    ],
    'a' => [
      'ar' => 'يمسح المنظم رمز QR الخاص بك بعد كل نشاط فتضاف النقاط فوراً وتظهر على لوحة المتصدرين وشاشات المهرجان.',
      'en' => 'An organizer scans your QR after each activity; points appear instantly on the leaderboard and screens.'
    ]
  ],
  [
    'c' => 'points',
    'q' => [
      'ar' => 'أين أجد النتائج والجوائز؟',
      'en' => 'Where are results and prizes?'
    ],
    'a' => [
      'ar' => 'صفحة النتائج تعرض النتائج الفورية وترتيب البطولات والأبطال. الجوائز كؤوس وميداليات للمراكز الثلاثة الأولى.',
      'en' => 'The Results page shows live scores, standings and champions. Cups and medals for the top three.'
    ]
  ],
  [
    'c' => 'events',
    'q' => [
      'ar' => 'كيف أحجز مقعد ورشة؟',
      'en' => 'How do I book a workshop seat?'
    ],
    'a' => [
      'ar' => 'من صفحة المجتمع والورش — المقاعد محدودة والحجز المسبق يضمن مقعدك.',
      'en' => 'From the Community page — seats are limited and pre-registration guarantees yours.'
    ]
  ]
];

return compact('CONTACT', 'GALLERY', 'CHAMP_CATS', 'ROUNDS', 'CHAMPS', 'FORMS', 'NEWS', 'FAQ_CATS', 'FAQS');
