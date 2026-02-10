<?php
// includes/config.php

declare(strict_types=1);

require __DIR__ . '/helpers.php';

/**
 * ============================================================
 * Site identity (single source of truth)
 * ============================================================
 */
$SITE = [
  'name'        => '1st Anytown Scout Group',
  'short_name'  => '1st Anytown Scouts',
  'subheading'  => 'Leicestershire',
  'tagline'     => 'Skills for life in Anytown, Beanotown, Ceevillage, Delta, Echo and Foxtrot for 4-18 year olds.',
  'url'         => 'https://1stanytown.org.uk',
  'email'       => 'hello@1stanytown.org.uk',
  'phone'       => '01234 123456',

  // Charity (optional, but required for full footer statement if enabled)
  'charity' => [
    'number'            => '123456',
    'jurisdiction'      => 'England and Wales',
    'registered_name'   => '1st Anytown Scout Group',
    'registered_office' => '1st Anytown Scout Centre, Main Street, Anytown Postal DE12 7PX',
    'register_url'      => 'https://register-of-charities.charitycommission.gov.uk/en/charity-search/-/charity-details/1234567',
  ],
];

/**
 * ============================================================
 * Social media links (displayed in footer "Follow us")
 * Key = platform slug (for icon class/filename)
 * Value = array with 'url' and optional 'label'
 * ============================================================
 */
$SOCIAL = [
  'x' => [
    'url' => 'https://x.com/1stAnytown',
    'label' => 'Follow us on X',
    'handle' => '1stAnytown',
  ],
  'facebook' => [
    'url' => 'https://www.facebook.com/1stAnytown',
    'label' => 'Follow us on Facebook',
  ],
  'instagram' => [
    'url' => 'https://www.instagram.com/1stAnytown',
    'label' => 'Follow us on Instagram',
  ],
  'youtube' => [
    'url' => 'https://www.youtube.com/@1stAnytown',
    'label' => 'Subscribe on YouTube',
  ],
  'pinterest' => [
    'url' => 'https://www.pinterest.com/1stAnytown/',
    'label' => 'Follow us on Pinterest',
  ],
  'linkedin' => [
    'url' => 'https://www.linkedin.com/company/1stAnytown/',
    'label' => 'Follow us on LinkedIn',
  ],
];

/**
 * Social sharing / Open Graph defaults
 */
$SOCIAL_SHARING = [
    'default_image'      => '/assets/img/og-default.jpg',   // 1200×630 recommended
    'default_image_alt'  => $SITE['name'] . ' - Scout for everyone',
    'twitter_handle'     => '1stAnytown',                     // without @
    'image_width'        => 1200,
    'image_height'       => 630,
];

/**
 * ============================================================
 * Primary calls to action
 * ============================================================
 */
$CTA = [
  'join_url' => 'https://www.onlinescoutmanager.co.uk/waiting-list/1st-anytown/apply',
  'volunteer_url' => 'https://volunteeringopportunities.scouts.org.uk/',
  'donate_url' => '',
];

/**
 * ============================================================
 * Venue / area wording (homepage)
 * ============================================================
 */
$SITE['venue'] = [
  'name' => '1st Anytown Centre',
  'area' => 'Anytown and nearby villages',
  'town' => 'Anytown',
];

/**
 * ============================================================
 * Brand / styling hooks
 * ============================================================
 */
$BRAND = [
  'logo_path' => '/assets/img/scouts-logo.svg',
  'logo_alt' => $SITE['name'],
  'accent_class' => 'brand-accent',
];

/**
 * ============================================================
 * Sections (age groups)
 * ============================================================
 */
$SECTIONS = [
  [
    'slug' => 'squirrels',
    'name' => 'Squirrels',
    'age' => '4–6 years',
    'colour' => '#ed3f23',
    'enabled' => true,
    'kind' => 'group',
    'url' => '/section.php?slug=squirrels',
    'logo' => __DIR__ . '/../assets/img/sections/squirrels.svg',
  ],
  [
    'slug' => 'beavers',
    'name' => 'Beavers',
    'age' => '6–8 years',
    'colour' => '#006ddf',
    'enabled' => true,
    'kind' => 'group',
    'url' => '/section.php?slug=beavers',
    'logo' => __DIR__ . '/../assets/img/sections/beavers.svg',
  ],
  [
    'slug' => 'cubs',
    'name' => 'Cubs',
    'age' => '8–10½ years',
    'colour' => '#23a950',
    'enabled' => true,
    'kind' => 'group',
    'url' => '/section.php?slug=cubs',
    'logo' => __DIR__ . '/../assets/img/sections/cubs.svg',
  ],
  [
    'slug' => 'scouts',
    'name' => 'Scouts',
    'age' => '10½–14 years',
    'colour' => '#004851',
    'enabled' => true,
    'kind' => 'group',
    'url' => '/section.php?slug=scouts',
    'logo' => __DIR__ . '/../assets/img/sections/scouts.svg',
  ],
  [
    'slug' => 'explorers',
    'name' => 'Explorers',
    'age' => '14–18 years',
    'colour' => '#003982',
    'enabled' => true,
    'kind' => 'district',
    'url' => '/section.php?slug=explorers',
    'logo' => __DIR__ . '/../assets/img/sections/explorers.svg',
  ],
  [
    'slug' => 'network',
    'name' => 'Network',
    'age' => '18–25 years',
    'colour' => '#7413dc',
    'enabled' => true,
    'kind' => 'district',
    'url' => '/section.php?slug=network',
    'logo' => __DIR__ . '/../assets/img/sections/network.svg',
  ],
];

/**
 * ============================================================
 * Icons / app icons (config-driven)
 * ============================================================
 */
$ICONS = [
  'favicon_ico' => '/assets/icons/favicon.ico',
  'favicon_16' => '/assets/icons/favicon-16x16.png',
  'favicon_32' => '/assets/icons/favicon-32x32.png',
  'favicon_96' => '/assets/icons/favicon-96x96.png',
  'apple_180' => '/assets/icons/apple-icon-180x180.png',
  'apple_152' => '/assets/icons/apple-icon-152x152.png',
  'apple_144' => '/assets/icons/apple-icon-144x144.png',
  'apple_120' => '/assets/icons/apple-icon-120x120.png',
  'apple_114' => '/assets/icons/apple-icon-114x114.png',
  'ms_tile_color' => '#ffffff',
  'ms_tile_image' => '/assets/icons/ms-icon-144x144.png',
  'theme_color' => '#ffffff',
];

/**
 * ============================================================
 * Navigation
 * ============================================================
 */
$NAV = [
  [
    'label' => 'About',
    'href'  => '/about.php',
    'children' => [
      ['label' => 'Policies', 'href' => '/policies.php'],
      ['label' => 'Annual reports', 'href' => '/annual-reports.php'],
    ],
  ],

  ['label' => 'Volunteering', 'href' => '/volunteer.php'],

  [
    'label' => 'Members',
    'href'  => '/members.php',
    'children' => [
      ['label' => 'Calendar', 'href' => '/calendar.php'],
      ['label' => 'Where we meet', 'href' => '/where-we-meet.php'],
      ['label' => 'Roll of honour', 'href' => '/roll-of-honour.php'],
      // later: ['label' => 'Gallery', 'href' => '/gallery.php'],
    ],
  ],

  ['label' => 'News', 'href' => '/news.php'],

  ['label' => 'Contact', 'href' => '/contact.php'],

  [
    'label' => 'Scout Centre Hire',
    'href'  => '/dsc.php',
    'show_in_nav' => false, // hide for now
  ],

  [
    'label' => 'Join',
    'href'  => '/join.php',
    'cta'   => true,
  ],
];


/**
 * ============================================================
 * Footer (fully config-driven; references $SITE/$CTA to avoid duplication)
 * ============================================================
 */
$FOOTER = [
  // Address line shown at bottom of footer (correspondence if different from charity registered_office)
  'address_line' => '1st Anytown Scouts PO Box 123',
  // Full charity statement (rendered in footer.php using $SITE['charity'] directly)
  'show_charity_statement' => true,
  // Footer columns - each with 'title', 'type' ('sections' or 'links'), 'items' (arrays with 'label', optional 'href', 'slug', 'times')
  'columns' => [
    [
      'title' => 'Sections',
      'type' => 'sections',
      'items' => [
        ['label' => 'Squirrels', 'slug' => 'squirrels', 'times' => ['Mondays - 16:00 to 17:00', 'Wednesdays - 16:00 to 17:00']],
        ['label' => 'Beavers', 'slug' => 'beavers', 'times' => ['Tuesdays - 17:00 to 18:00', 'Thursdays - 17:00 to 18:00', 'Fridays - 17:00 to 18:00']],
        ['label' => 'Cubs', 'slug' => 'cubs', 'times' => ['Tuesdays - 18:00 to 19:30', 'Thursdays - 18:00 to 19:30']],
        ['label' => 'Scouts', 'slug' => 'scouts', 'times' => ['Tuesdays - 19:30 to 21:15', 'Thursdays - 19:30 to 21:15']],
        ['label' => 'Explorers', 'slug' => 'explorers', 'times' => ['Mondays - 19:30 to 21:15']],
      ],
    ],
    [
      'title' => 'Look Wider',
      'type' => 'links',
      'items' => [
        ['label' => 'The Scouts', 'href' => 'https://www.scouts.org.uk/'],
        ['label' => 'Leicestershire Scouts', 'href' => 'https://www.leicestershirescouts.org.uk'],
        ['label' => 'Ashby & Coalville Scouts', 'href' => 'https://www.ashbyandcoalvillescouts.org.uk'],
        ['label' => 'Willesley Scout Campsite', 'href' => 'https://www.willesley.org.uk'],
      ],
    ],
    [
      'title' => 'Contact us',
      'type' => 'links',
      'items' => [
        ['label' => 'Contact Us', 'href' => '/contact.php'],
        ['label' => 'Join Us', 'href' => $CTA['join_url']],
        ['label' => 'Volunteer', 'href' => $CTA['volunteer_url']],
      ],
    ],
  ],
];

/**
 * ============================================================
 * Scout Centre / venue hire settings
 * ============================================================
 */
$HIRE = [
  'name' => '1st Anytown Scout Centre',
  'address' => 'Not specified',
  'rates' => [
    ['label' => 'Half day', 'price' => 50],
    ['label' => 'Full day', 'price' => 85],
    ['label' => 'Evening', 'price' => 120],
    ['label' => 'Overnight', 'price' => 180],
    ['label' => 'Weekend', 'price' => 400],
  ],
  'deposit_note' => '50% deposit required to secure a booking (unless waived by the Group).',
];

/**
 * ============================================================
 * Calendar settings
 * ============================================================
 */
$CALENDAR = [
  'db_path' => __DIR__ . '/../data/calendar.sqlite',
  'sources' => [
    ['name' => 'OSM Feed 123456', 'url' => 'https://www.onlinescoutmanager.co.uk/ext/cal/?f=1231321321321'],
  ],
  'public_keywords' => ['open evening', 'agm', 'fundraiser', 'fete', 'coffee', 'car wash'],
  'public_uids' => [],
];

/**
 * ============================================================
 * Supporters / funders logos (homepage)
 * ============================================================
 */
$SUPPORTERS = [
  'items' => [
    // ['name' => 'Supporter Name', 'logo' => '/assets/img/supporters/example.svg', 'url' => 'https://example.org' - remove if not used],
    ['name' => 'Ashby Lions Club', 'logo' => '/assets/img/supporters/ashby-lions-club.svg',],
    ['name' => 'Leicestershire Scouts Forward 5 fund', 'logo' => '/assets/img/supporters/leicestershire-scouts-forward5.svg', 'url' => 'https://leicestershirescouts.org.uk'],
    ['name' => 'Ashby Rotary Clubs', 'logo' => '/assets/img/supporters/ashby-rotary-club.svg', 'url' => 'https://rotary-ribi.org/clubs/homepage.php?ClubID=401'],
    ['name' => 'LCC Choose How You Move', 'logo' => '/assets/img/supporters/chym.svg', 'url' => 'https://www.choosehowyoumove.co.uk/'],
    ['name' => 'Donisthorpe Reunion Band', 'logo' => '/assets/img/supporters/donisthorpe-reunion-band.svg',],
    ['name' => 'North West Leicestershire District Council', 'logo' => '/assets/img/supporters/nwldc.svg', 'url' => 'https://nwleics.gov.uk'],
    ['name' => 'The National Forest Company', 'logo' => '/assets/img/supporters/the-national-forest-company.svg', 'url' => 'https://www.nationalforest.org/']
    
  ],
  'max' => 0,
];
