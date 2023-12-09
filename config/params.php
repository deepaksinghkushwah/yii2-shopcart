<?php

return [    
    'user.passwordResetTokenExpire' => 3600,  
    
    'productPhotoPathOs' => str_replace("\\", "/", realpath(dirname('../'))) . "/images/products/",
    'productPhotoPathWeb' => '/images/products/',
    'discountTypes' => [
        '1' => 'Flat',
        '2' => 'Percentage',
        '3' => 'Free Shipping'
    ],
    'status' => [
        '1' => 'Active',
        '0' => 'Inactive'
    ],
];
