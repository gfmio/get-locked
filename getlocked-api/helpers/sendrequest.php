<?php

function SendRequest( $url, $method = 'GET', $data = array(), $headers = array('Content-type: application/x-www-form-urlencoded'), $base_url = "https://app.my-opinion.de/live") {
	$url = $base_url.$url;

	if (function_exists('curl_version')) {
		$ch = curl_init();

		if ($method == "GET") {
			curl_setopt($ch, CURLOPT_HTTPGET, true);
		} elseif ($method == "POST") {
			curl_setopt($ch, CURLOPT_POST, true);
		} elseif ($method == "PUT") {
			curl_setopt($ch, CURLOPT_PUT, true);
		} elseif ($method == "DELETE") {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		}

		if (false === array_search("Accept: application/json", $headers)) {
			$headers[] = "Accept: application/json";
		}
		// if (false === array_search("Content-Type: application/json", $headers)) {
		// 	$headers[] = "Content-Type: application/json";
		// }
		if (false === array_search("Content-type: application/x-www-form-urlencoded", $headers)) {
			$headers[] = "Content-type: application/x-www-form-urlencoded";
		}

		// if (is_array($data)) {
		// 	foreach (array_keys($data, NULL, true) as $k) {
		// 		unset($data[$k]);
		// 	}
		// }
		
		$data = (is_array($data)) ? http_build_query($data) : $data; 
		
		// echo $data."<br/>\n";

		if ($method == 'GET') {
			$url.= "?".$data;
		} else {
			$headers[] = 'Content-Length: ' . strlen($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}

		curl_setopt($ch, CURLOPT_PROTOCOLS,  CURLPROTO_HTTPS);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		if (isset($_SESSION["user"])) {
			$cookie_file = dirname(__FILE__) . "/../tmp/".$_SESSION["user"].".txt";
			curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file); 
			curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); 
		}

		if(curl_errno($ch)){
		    echo 'Curl error: ' . curl_error($ch);
		}

		$response = new stdClass();

		$response->body = json_decode(curl_exec($ch));

		$info = curl_getinfo($ch);

		// print_r($info);

		$response->status = $info["http_code"];

		curl_close($ch);

		return $response;
	} else {
		die('cURL has to be installed and enabled.');
	}
}
