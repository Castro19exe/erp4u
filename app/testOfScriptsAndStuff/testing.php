<?php
    $postalCode = "2005";
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);

    $data = [
        "codes" => $postalCode,
        "country" => "pt"
    ];

    curl_setopt($ch, CURLOPT_URL, "https://app.zipcodebase.com/api/v1/search?" . http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "apikey: 6ff48960-6e69-11ed-9a9c-53428c037c56",
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response);

    print_r($json -> results -> $postalCode[0] -> city)

?>
