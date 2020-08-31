<?php
return array(
    'name' =>   "Test Application",
    'routes'=>  [
        '\system\DefaultRouter'
    ],
    'component'=> [
        'db'   =>   require(__DIR__ . '/db.php'),
        'mailer'=> [
            'class'=>"\\component\\Mailer",
            'from' =>   "admin@test.com"
        ],
    ]
    
);