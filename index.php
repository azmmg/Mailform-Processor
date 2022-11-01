<?php
//$entityBody = file_get_contents('php://input');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
// echo $entityBody;
$errors = [];
$data = [];

if (empty($_POST['name'])) {
    $errors['name'] = 'Bitte geben Sie Ihren Namen ein!';
}

if (empty($_POST['email'])) {
    $errors['email'] = 'Bitte geben Sie eine E-Mailadresse ein!';
}

if (empty($_POST['betreff'])) {
    $errors['betreff'] = 'Bitte geben Sie einen Betreff ein!';
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $data['success'] = true;
    $data['message'] = 'Danke! Ihre Mitteilung wurde weitergeleitet.';
}

echo json_encode($data);

if ($data['success']) {
  		$url = "https://webhook.site/99be3849-42a4-47e4-adba-660ef80e07db";
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		$headers = array(
		   "Accept: application/json",
		   "Content-Type: application/json",
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		
		$data = <<<DATA
		{
		  "name": %s,
		  "email": %s,
		  "betreff": %s
		}
		DATA;
		
		curl_setopt($curl, CURLOPT_POSTFIELDS, sprintf($data,$_POST['name'],$_POST['email'],$_POST['betreff']));
		
		$resp = curl_exec($curl);
		curl_close($curl);
		
		//echo $resp;
};