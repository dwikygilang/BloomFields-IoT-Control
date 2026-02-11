<?php
/* =========================================================
    BloomFields IOT V1 - API ENDPOINT FOR ESP32
    Return JSON data for IoT synchronization
    Copyright (c) 2026 BloomFields.id
    All rights reserved.
    
    Website   : https://bloomfields.id
    Contact   : +62 813 5701 6423
========================================================= */

define("DATA_FILE", __DIR__."/data.json");
date_default_timezone_set("Asia/Jakarta");

// Allow CORS (optional, for testing)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Load data
function loadData(){
    if(!file_exists(DATA_FILE)) {
        http_response_code(404);
        echo json_encode(["error" => "Data file not found"]);
        exit;
    }
    
    $json = file_get_contents(DATA_FILE);
    $data = json_decode($json, true);
    
    if(!$data) {
        http_response_code(500);
        echo json_encode(["error" => "Invalid JSON data"]);
        exit;
    }
    
    return $data;
}

// Calculate HST aktif
function calculateHSTAktif($data) {
    $start = strtotime($data["tanggal_mulai"]);
    $nowDate = strtotime(date("Y-m-d"));
    $selisih = floor(($nowDate - $start) / 86400);
    return max(0, $data["hst_mulai"] + $selisih);
}

// Main logic
$data = loadData();

// Add calculated HST aktif to response
$data["hst_aktif"] = calculateHSTAktif($data);

// Return JSON
echo json_encode($data, JSON_PRETTY_PRINT);
