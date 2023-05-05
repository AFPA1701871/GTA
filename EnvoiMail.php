#!/usr/local/bin/php
<?php

$url = 'https://www.afpadunkerque.fr/GTA/index.php?page=ActionMail';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch);
curl_close($ch);
exit;
