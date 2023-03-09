<?php
$currentDir = dirname(__FILE__);
chdir($currentDir);
$currentDir = getcwd();
$token = file_get_contents("$currentDir/token.txt");
$open = file_get_contents("$currentDir/open.txt");
$tklen = strlen($token);
$oplen = strlen($open);
if ($tklen == 32) {
    $postData = array(
        "refresh_token" => $token,
        "grant_type" => "refresh_token"
    );
    $postData = json_encode($postData);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://auth.aliyundrive.com/v2/account/token",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPHEADER => array(
            "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.83 Safari/537.36",
            "Rererer: https://www.aliyundrive.com/",
            "Content-Type: application/json"
        ),
    ));
    $ntokenResult = curl_exec($curl);
    $ntokenResult = explode(",", $ntokenResult);
    $ntoken = "";
    foreach ($ntokenResult as $key => $value) {
        if (strpos($value, "refresh_token") !== false) {
            $ntoken = str_replace('"', "", explode(":", $value)[1]);
            break;
        }
    }
    curl_close($curl);
} else {
    $ntoken = '';
}
if ($oplen == 280) {
    $postData = array(
        "refresh_token" => $open,
        "grant_type" => "refresh_token"
    );
    $postData = json_encode($postData);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.nn.ci/alist/ali_open/token",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPHEADER => array(
            "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.83 Safari/537.36",
            "Rererer: https://www.aliyundrive.com/",
            "Content-Type: application/json"
        ),
    ));
    $nopenResult = curl_exec($curl);
    $nopenResult = explode(",", $nopenResult);
    $nopen = "";
    foreach ($nopenResult as $key => $value) {
        if (strpos($value, "refresh_token") !== false) {
            $nopen = str_replace('"', "", explode(":", $value)[1]);
            break;
        }
    }
    curl_close($curl);
} else {
    $nopen = '';
}
file_put_contents("$currentDir/token.txt", $ntoken);
file_put_contents("$currentDir/open.txt", $nopen);
file_put_contents("$currentDir/alltok.txt", $ntoken . ";" . $nopen);
?>
