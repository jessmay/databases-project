<?php

function distanceCalc ($lat1, $lng1, $lat2, $lng2) {

    $earthRadius = 3958.75;

    $dLat = deg2rad($lat2-$lat1);
    $dLng = deg2rad($lng2-$lng1);


    $a = sin($dLat/2) * sin($dLat/2) +
       cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
       sin($dLng/2) * sin($dLng/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    $dist = $earthRadius * $c;

    return $dist;
}

function lookup($string){
    $street_number = ' ';
    $street_name = ' ';
    $city = ' ';
    $county = ' ';
    $state = ' ';
    $state_short = ' ';
    $country = ' ';
    $country_short = ' ';
    $p_code = ' ';

    $string = str_replace (" ", "+", urlencode($string));
    $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$string."&components=country:US&sensor=false";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $details_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = json_decode(curl_exec($ch), true);

    // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
    if ($response['status'] != 'OK') {
        return array('latitude' => ($str = 'failed'));
    }

    $geometry = $response['results'][0]['geometry'];
    $address_components = $response['results'][0]['address_components'];
    $formatted_address = $response['results'][0]['formatted_address'];

    for($i = 1, $size = count($address_components); $i < $size; $i++){

        if($address_components[$i]['types'][0] == 'street_number')
            $street_number = $address_components[$i]['long_name'];

        else if ($address_components[$i]['types'][0] == 'route')
            $street_name = $address_components[$i]['long_name'];

        else if ($address_components[$i]['types'][0] == 'locality')
            $city =  $address_components[$i]['long_name'];

        else if ($address_components[$i]['types'][0] == 'administrative_area_level_2')
            $county = $address_components[$i]['long_name'];

        else if ($address_components[$i]['types'][0] == 'administrative_area_level_1'){
            $state = $address_components[$i]['long_name'];
            $state_short = $address_components[$i]['short_name'];
        }

        else if ($address_components[$i]['types'][0] == 'country'){
            $country = $address_components[$i]['long_name'];
            $country_short  = $address_components[$i]['short_name'];
        }

        else if ($address_components[$i]['types'][0] == 'postal_code')
            $p_code = $address_components[$i]['long_name'];


    }

    $longitude = $geometry['location']['lng'];
    $latitude = $geometry['location']['lat'];

    $array = array(
        'latitude' => $geometry['location']['lat'],
        'longitude' => $geometry['location']['lng'],
        'location_type' => $geometry['location_type'],
        'name' => $address_components[0]['long_name'],
        'street_number' => $street_number,
        'street_name' => $street_name,
        'city' => $city,
        'county' => $county,
        'state' => $state,
        'state_short' => $state_short,
        'country' => $country,
        'country_short' => $country_short,
        'postal_code' => $p_code,
        'full_address' => $formatted_address,
        
    ); 
    return $array;
}