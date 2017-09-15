<?php


function provjeriRecaptha()
{

    $input  = $_POST['g-recaptcha-response'];
    $secret = '6Leb7h4TAAAAACI_e0b9MEJhqIzBsLrLHFkz-Kqn';

    $url  = 'https://www.google.com/recaptcha/api/siteverify';
    $data = ['secret' => $secret, 'response' => $input];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    $context = stream_context_create($options);
    $result  = file_get_contents($url, false, $context);

    if ($result === false) {
        echo 'Greska!';
    }

    $odgovor = json_decode($result);
    if ($odgovor->success == 'true') {
        return true;
    }

    return false;
}

