<?php

return [

    /*
    | Akun admin awal yang dibuat oleh `php artisan db:seed`.
    | Jika ADMIN_PASSWORD kosong, kata sandi acak dibuat dan ditampilkan sekali di konsol.
    */
    'admin' => [
        'name' => env('ADMIN_NAME', 'Administrator'),
        'email' => env('ADMIN_EMAIL', 'admin@example.com'),
        'password' => env('ADMIN_PASSWORD'),
    ],

];
