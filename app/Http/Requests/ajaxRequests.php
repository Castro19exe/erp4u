<?php
header('Access-Control-Allow-Origin: *');
$postalCode = $_REQUEST["p"];

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

//$json = json_decode($response,true); //transforma o JSON num dicionário, primeira solução já não necessária

//$city = $json["results"][$postalCode][0]["city"]; //tratamento de um resultado como um array

    $json = json_decode($response);
    $city = $json->results->$postalCode[0]->city;

    echo $city;
?>
