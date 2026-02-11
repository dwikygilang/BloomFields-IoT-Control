<?php
/* =========================================================
    BloomFields - IOT (V1.0)
    Enhanced with Production Safety Features
    Location: Singosari, Malang, Jawa Timur
    Copyright (c) 2026 BloomFields.id
    All rights reserved.
    
    Website   : https://bloomfields.id
    Contact   : +62 813 5701 6423
========================================================= */

define("DATA_FILE", __DIR__."/data.json");
define("LOG_FILE", __DIR__."/system.log");
define("BACKUP_DIR", __DIR__."/backups");
date_default_timezone_set("Asia/Jakarta");

if (!file_exists(BACKUP_DIR)) mkdir(BACKUP_DIR, 0755, true);

$melon_reference = [

/* ================== FASE AWAL ================== */
1  => ["ec"=>1.0, "ppm"=>500,  "vol"=>1000, "ket"=>"Penyiraman sekaligus"],
2  => ["ec"=>1.0, "ppm"=>500,  "vol"=>1071, "ket"=>"Semprot Vitamin B-Complex 1 tablet / 20L"],
3  => ["ec"=>1.5, "ppm"=>750,  "vol"=>1071, "ket"=>"Fase awal vegetatif"],
4  => ["ec"=>1.5, "ppm"=>750,  "vol"=>1071, "ket"=>"Semprot MAP 2gr/L (jika diperlukan)"],
5  => ["ec"=>1.8, "ppm"=>900,  "vol"=>1071, "ket"=>"Vegetatif"],
6  => ["ec"=>1.8, "ppm"=>900,  "vol"=>1071, "ket"=>"Vegetatif"],
7  => ["ec"=>1.8, "ppm"=>900,  "vol"=>1464, "ket"=>"Vegetatif intensif"],
8  => ["ec"=>2.0, "ppm"=>1000, "vol"=>1464, "ket"=>"Semprot MAP 2gr/L"],
9  => ["ec"=>2.0, "ppm"=>1000, "vol"=>1464, "ket"=>"Vegetatif"],
10 => ["ec"=>2.0, "ppm"=>1000, "vol"=>1464, "ket"=>"Vegetatif"],

/* ================== VEGETATIF LANJUT ================== */
11 => ["ec"=>2.0, "ppm"=>1000, "vol"=>1750, "ket"=>"Vegetatif lanjut"],
12 => ["ec"=>2.0, "ppm"=>1100, "vol"=>1750, "ket"=>"Semprot MAP 2gr/L"],
13 => ["ec"=>2.0, "ppm"=>1100, "vol"=>1750, "ket"=>"Vegetatif"],
14 => ["ec"=>2.1, "ppm"=>1100, "vol"=>1750, "ket"=>"Vegetatif"],
15 => ["ec"=>2.1, "ppm"=>1100, "vol"=>1750, "ket"=>"Vegetatif"],
16 => ["ec"=>2.1, "ppm"=>1200, "vol"=>2286, "ket"=>"Semprot MAP 2gr/L"],
17 => ["ec"=>2.1, "ppm"=>1200, "vol"=>2286, "ket"=>"Vegetatif"],
18 => ["ec"=>2.1, "ppm"=>1200, "vol"=>2286, "ket"=>"Vegetatif"],
19 => ["ec"=>2.1, "ppm"=>1200, "vol"=>2286, "ket"=>"Vegetatif"],
20 => ["ec"=>2.2, "ppm"=>1200, "vol"=>2286, "ket"=>"Semprot MAP 2gr/L"],

/* ================== PEMBUNGAAN ================== */
21 => ["ec"=>2.2, "ppm"=>1300, "vol"=>2607, "ket"=>"Awal pembungaan"],
22 => ["ec"=>2.2, "ppm"=>1300, "vol"=>2607, "ket"=>"Pembungaan"],
23 => ["ec"=>2.2, "ppm"=>1300, "vol"=>2607, "ket"=>"Pembungaan"],
24 => ["ec"=>2.2, "ppm"=>1300, "vol"=>2607, "ket"=>"Semprot MAP 2gr/L"],
25 => ["ec"=>2.3, "ppm"=>1300, "vol"=>2607, "ket"=>"Pembesaran awal"],
26 => ["ec"=>2.3, "ppm"=>1300, "vol"=>3143, "ket"=>"Pembesaran buah"],
27 => ["ec"=>2.3, "ppm"=>1300, "vol"=>3143, "ket"=>"Kocor CaNO3 (Calnit) jam 12:00"],
28 => ["ec"=>2.3, "ppm"=>1300, "vol"=>3143, "ket"=>"Pembesaran buah"],
29 => ["ec"=>2.3, "ppm"=>1300, "vol"=>3143, "ket"=>"Pembesaran buah"],
30 => ["ec"=>2.4, "ppm"=>1300, "vol"=>3143, "ket"=>"Semprot Calnit 2gr/L"],

/* ================== PEMBESARAN BUAH ================== */
31 => ["ec"=>2.4, "ppm"=>1300, "vol"=>3464, "ket"=>"Pembesaran buah"],
32 => ["ec"=>2.4, "ppm"=>1300, "vol"=>3464, "ket"=>"Pembesaran buah"],
33 => ["ec"=>2.4, "ppm"=>1300, "vol"=>3464, "ket"=>"Kocor Calnit jam 12:00"],
34 => ["ec"=>2.4, "ppm"=>1300, "vol"=>3464, "ket"=>"Pembesaran buah"],
35 => ["ec"=>2.5, "ppm"=>1300, "vol"=>3464, "ket"=>"Pembesaran maksimal"],
36 => ["ec"=>2.5, "ppm"=>1300, "vol"=>3464, "ket"=>"Semprot Calnit 2gr/L"],
37 => ["ec"=>2.5, "ppm"=>1300, "vol"=>3464, "ket"=>"Pembesaran"],
38 => ["ec"=>2.5, "ppm"=>1300, "vol"=>3464, "ket"=>"Pembesaran"],
39 => ["ec"=>2.5, "ppm"=>1300, "vol"=>3464, "ket"=>"Kocor Calnit jam 12:00"],
40 => ["ec"=>2.5, "ppm"=>1300, "vol"=>3464, "ket"=>"Pembesaran"],

/* ================== PEMATANGAN ================== */
41 => ["ec"=>2.6, "ppm"=>1300, "vol"=>3464, "ket"=>"Pematangan"],
42 => ["ec"=>2.6, "ppm"=>1300, "vol"=>3464, "ket"=>"Semprot Calnit 2gr/L"],
43 => ["ec"=>2.6, "ppm"=>1300, "vol"=>3464, "ket"=>"Pematangan"],
44 => ["ec"=>2.6, "ppm"=>1300, "vol"=>3464, "ket"=>"Pematangan"],
45 => ["ec"=>2.6, "ppm"=>1300, "vol"=>3464, "ket"=>"Kocor Calnit jam 12:00"],
46 => ["ec"=>2.6, "ppm"=>1300, "vol"=>3464, "ket"=>"Pematangan"],
47 => ["ec"=>2.6, "ppm"=>1300, "vol"=>3464, "ket"=>"Pematangan"],
48 => ["ec"=>2.6, "ppm"=>1300, "vol"=>3464, "ket"=>"Semprot Calnit 2gr/L"],
49 => ["ec"=>2.6, "ppm"=>1300, "vol"=>3464, "ket"=>"Pematangan"],
50 => ["ec"=>2.6, "ppm"=>1300, "vol"=>3464, "ket"=>"Pematangan"],

/* ================== MENJELANG PANEN ================== */
51 => ["ec"=>2.5, "ppm"=>1200, "vol"=>3143, "ket"=>"Kocor Calnit jam 12:00"],
52 => ["ec"=>2.5, "ppm"=>1200, "vol"=>3143, "ket"=>"Menjelang panen"],
53 => ["ec"=>2.5, "ppm"=>1200, "vol"=>3143, "ket"=>"Menjelang panen"],
54 => ["ec"=>2.4, "ppm"=>1200, "vol"=>3143, "ket"=>"Semprot MKP 2gr/L"],
55 => ["ec"=>2.4, "ppm"=>1200, "vol"=>3143, "ket"=>"Menjelang panen"],
56 => ["ec"=>2.4, "ppm"=>1200, "vol"=>3143, "ket"=>"Menjelang panen"],
57 => ["ec"=>2.2, "ppm"=>1200, "vol"=>3143, "ket"=>"Kocor SOP jam 12:00"],
58 => ["ec"=>2.2, "ppm"=>1200, "vol"=>3143, "ket"=>"Semprot MKP 2gr/L"],
59 => ["ec"=>2.1, "ppm"=>1100, "vol"=>2607, "ket"=>"Kocor SOP jam 12:00"],
60 => ["ec"=>2.1, "ppm"=>1100, "vol"=>2607, "ket"=>"Menjelang panen"],
61 => ["ec"=>2.0, "ppm"=>1100, "vol"=>2607, "ket"=>"Kocor SOP jam 12:00"],
62 => ["ec"=>2.0, "ppm"=>1100, "vol"=>1750, "ket"=>"Semprot MKP 2gr/L"],
63 => ["ec"=>1.4, "ppm"=>1100, "vol"=>1750, "ket"=>"Kocor SOP"],
64 => ["ec"=>1.8, "ppm"=>1100, "vol"=>1750, "ket"=>"Menjelang panen"],
65 => ["ec"=>1.8, "ppm"=>1100, "vol"=>1750, "ket"=>"Kocor SOP"],
66 => ["ec"=>1.6, "ppm"=>1100, "vol"=>1464, "ket"=>"Semprot MKP"],
67 => ["ec"=>1.8, "ppm"=>1100, "vol"=>1464, "ket"=>"Kocor SOP"],
68 => ["ec"=>1.4, "ppm"=>1100, "vol"=>1464, "ket"=>"Akhir nutrisi"],
69 => ["ec"=>1.6, "ppm"=>1100, "vol"=>1464, "ket"=>"Akhir nutrisi"],
70 => ["ec"=>0.0, "ppm"=>0,    "vol"=>0,    "ket"=>"PANEN 🍈"]

];


$maintenance_checklist = [

/* ================== FASE AWAL ================== */
1  => [
    "Cek kelembaban media",
    "Pastikan drainase lancar",
    "Monitoring kecambah"
],

7  => [
    "Pruning tunas air",
    "Cek drainase",
    "Cek serangan awal hama (thrips, aphid)"
],

/* ================== VEGETATIF ================== */
14 => [
    "Seleksi buah (sisakan 1–2 per tanaman)",
    "Cek hama & penyakit",
    "Penyesuaian ajir / lanjaran"
],

18 => [
    "Monitoring pertumbuhan batang",
    "Cek EC & pH larutan"
],

21 => [
    "Semprot fungisida preventif",
    "Ikat batang utama",
    "Pastikan bunga betina sehat"
],

/* ================== PEMBUNGAAN & BUAH ================== */
27 => [
    "Cek keberhasilan buah jadi",
    "Kocor CaNO3 (sesuai jadwal)",
    "Buang buah abnormal"
],

28 => [
    "Kocor pupuk daun (jika perlu)",
    "Cek pH larutan",
    "Cek kelembaban media"
],

/* ================== PEMBESARAN BUAH ================== */
35 => [
    "Pruning daun tua & rusak",
    "Monitoring netting buah",
    "Putar posisi buah (jika perlu)"
],

40 => [
    "Cek kekerasan buah",
    "Pastikan suplai Ca stabil",
    "Cek gejala busuk ujung buah"
],

42 => [
    "Semprot MKP",
    "Cek kematangan awal buah",
    "Monitoring serangan jamur"
],

/* ================== PEMATANGAN ================== */
50 => [
    "Kurangi volume air bertahap",
    "Cek kadar gula (Brix)",
    "Monitoring aroma buah"
],

55 => [
    "Stop nitrogen",
    "Fokus pematangan buah",
    "Cek warna & jaring (netting)"
],

/* ================== PANEN ================== */
60 => [
    "Persiapan panen",
    "Marking buah siap panen",
    "Cek umur buah (HST buah)"
],

65 => [
    "Panen selektif",
    "Catat hasil panen",
    "Evaluasi kualitas buah"
],

70 => [
    "Panen total 🍈",
    "Pembersihan lahan",
    "Evaluasi siklus tanam"
]

];


/* ---------- CORE LOGIC ---------- */
function defaultData(){
    return [
        "tanggal_mulai" => date("Y-m-d"),
        "hst_mulai" => 0,
        "hst_max" => 70,
        "pompa_status" => "OFF",
        "pompa_manual_start" => null,
        "pompa_manual_timer" => 30, // Max timer manual (menit)
        "nutrisi_target" => "AB Mix Melon",
        "hst" => [ "0" => [] ],
        "logs_harian" => [],
        "checklist_done" => [], // HST => [task1, task2]
        "manual_pump_count" => 0, // Counter pompa manual hari ini
        "parameter_lock" => false, // Lock critical params
        "issue_reports" => [] // Quick issue tracking
    ];
}

function loadData(){
    if(!file_exists(DATA_FILE)) saveData(defaultData());
    $json = file_get_contents(DATA_FILE);
    $data = json_decode($json, true);
    if(!$data) $data = defaultData();
    return array_merge(defaultData(), $data);
}

function saveData($data){
    if(isset($data["hst"])){
        foreach ($data["hst"] as &$j) {
            if(is_array($j)) usort($j, fn($a,$b)=>strcmp($a["jam"],$b["jam"]));
        }
    }
    file_put_contents(DATA_FILE, json_encode($data, JSON_PRETTY_PRINT));
}

function writeLog($msg, $type = "INFO"){
    $time = date("Y-m-d H:i:s");
    $entry = "[$time] [$type] $msg\n";
    file_put_contents(LOG_FILE, $entry, FILE_APPEND);
}

function createBackup(){
    $filename = BACKUP_DIR . "/backup_" . date("Y-m-d_His") . ".json";
    copy(DATA_FILE, $filename);
    writeLog("Backup created: $filename", "BACKUP");
    return basename($filename);
}

function getTodaySchedule($data, $hst){
    if (!isset($data["hst"][$hst])) return [];
    return $data["hst"][$hst];
}

function getWarnings($data, $hstAktif){
    $warnings = [];
    
    // Warning 1: HST aktif tapi tidak ada jadwal
    if ($hstAktif > 0 && empty($data["hst"][$hstAktif])) {
        $warnings[] = ["type" => "danger", "msg" => "⚠️ HST $hstAktif tidak memiliki jadwal siram!"];
    }
    
    // Warning 2: Pompa manual terlalu sering
    if ($data["manual_pump_count"] > 5) {
        $warnings[] = ["type" => "warning", "msg" => "⚠️ Pompa manual sudah {$data['manual_pump_count']}x hari ini. Cek jadwal otomatis!"];
    }
    
    // Warning 3: Tidak ada log pertumbuhan 3 hari terakhir
    $recent_logs = array_filter($data["logs_harian"], fn($k) => $k >= ($hstAktif - 3) && $k <= $hstAktif, ARRAY_FILTER_USE_KEY);
    if (empty($recent_logs) && $hstAktif > 3) {
        $warnings[] = ["type" => "warning", "msg" => "📝 Belum ada log pertumbuhan 3 hari terakhir"];
    }
    
    // Warning 4: EC drastis berubah
    global $melon_reference;
    $prev_ec = null;
    foreach($melon_reference as $h => $ref) {
        if ($h > $hstAktif) break;
        if ($prev_ec !== null && abs($ref['ec'] - $prev_ec) > 0.5) {
            $warnings[] = ["type" => "info", "msg" => "📊 EC target berubah signifikan di HST $h ({$prev_ec} → {$ref['ec']})"];
        }
        $prev_ec = $ref['ec'];
    }
    
    return $warnings;
}

function getPlantStatus($data, $hstAktif){
    // Auto status berdasarkan log
    if (empty($data["logs_harian"])) return ["status" => "neutral", "text" => "Belum ada data"];
    
    $recent = array_slice($data["logs_harian"], -3, 3, true);
    if (count($recent) < 2) return ["status" => "neutral", "text" => "Data belum cukup"];
    
    $keys = array_keys($recent);
    $last = end($recent);
    $prev = $recent[$keys[count($keys)-2]];
    
    $growth_rate = ($last["tinggi"] - $prev["tinggi"]) / max(1, $keys[count($keys)-1] - $keys[count($keys)-2]);
    
    if ($growth_rate > 2) return ["status" => "good", "text" => "Normal", "icon" => "🟢"];
    if ($growth_rate > 1) return ["status" => "ok", "text" => "Perlu Perhatian", "icon" => "🟡"];
    return ["status" => "bad", "text" => "Risiko", "icon" => "🔴"];
}

/* ---------- PERHITUNGAN ---------- */
$data = loadData();
$start = strtotime($data["tanggal_mulai"]);
$nowDate = strtotime(date("Y-m-d"));
$selisih = floor(($nowDate - $start) / 86400);
$hstAktif = max(0, $data["hst_mulai"] + $selisih);

// Auto reset manual pump count di hari baru
$last_reset = $data["last_manual_reset"] ?? date("Y-m-d");
if ($last_reset != date("Y-m-d")) {
    $data["manual_pump_count"] = 0;
    $data["last_manual_reset"] = date("Y-m-d");
    saveData($data);
}

// Auto OFF pompa manual jika sudah lewat timer
if ($data["pompa_status"] == "ON" && $data["pompa_manual_start"]) {
    $elapsed = (time() - strtotime($data["pompa_manual_start"])) / 60;
    if ($elapsed > $data["pompa_manual_timer"]) {
        $data["pompa_status"] = "OFF";
        $data["pompa_manual_start"] = null;
        writeLog("Auto OFF pompa (timer habis)", "SAFETY");
        saveData($data);
    }
}

$current_ref = ["ec" => "--", "ppm" => "--", "vol" => "--", "ket" => "Perawatan Rutin"];
foreach($melon_reference as $h => $val) {
    if($hstAktif >= $h) $current_ref = $val;
}

$fase = "Semaian";
if($hstAktif > 7)  $fase = "Vegetatif";
if($hstAktif > 25) $fase = "Pembungaan/Buah";
if($hstAktif > 50) $fase = "Pematangan (Netting)";
$progress = min(100, round(($hstAktif / $data["hst_max"]) * 100));

$todaySchedule = getTodaySchedule($data, $hstAktif);
$warnings = getWarnings($data, $hstAktif);
$plantStatus = getPlantStatus($data, $hstAktif);

/* ---------- ACTIONS ---------- */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // BACKUP
    if (isset($_POST["create_backup"])) {
        $file = createBackup();
        header("Location: ?backup_success=" . urlencode($file));
        exit;
    }
    
    // TOGGLE LOCK
    if (isset($_POST["toggle_lock"])) {
        $data["parameter_lock"] = !$data["parameter_lock"];
        writeLog($data["parameter_lock"] ? "Parameters LOCKED" : "Parameters UNLOCKED", "SECURITY");
        saveData($data);
        header("Location: ?hst=$hstAktif");
        exit;
    }
    
    // UPDATE CONFIG (dengan lock check)
    if (isset($_POST["update_config"])) {
        if ($data["parameter_lock"]) {
            header("Location: ?error=locked");
            exit;
        }
        $data["tanggal_mulai"] = $_POST["tanggal_mulai"];
        $data["hst_mulai"] = intval($_POST["hst_mulai"]);
        $data["hst_max"] = max(1, intval($_POST["hst_max"]));
        $data["pompa_manual_timer"] = max(5, intval($_POST["pompa_manual_timer"]));
        writeLog("Config updated: HST Max {$data['hst_max']}, Timer {$data['pompa_manual_timer']}m", "CONFIG");
    }
    
    // SAVE SCHEDULE (dengan lock check)
    if (isset($_POST["save_schedule"])) {
        if ($data["parameter_lock"]) {
            header("Location: ?error=locked");
            exit;
        }
        $h_idx = $_POST['target_hst'];
        $jadwal = [];
        foreach ($_POST["jam"] ?? [] as $i=>$jam) {
            $dur = intval($_POST["durasi"][$i]??0);
            if ($jam && $dur > 0) $jadwal[] = ["jam"=>$jam, "durasi"=>$dur];
        }
        $data["hst"][$h_idx] = $jadwal;
        writeLog("Schedule updated for HST $h_idx (" . count($jadwal) . " slots)", "SCHEDULE");
    }
    
    // SAVE DAILY LOG
    if (isset($_POST["save_daily_log"])) {
        $hst_log = intval($_POST["hst_log"]);
        $data["logs_harian"][$hst_log] = [
            "tanggal" => date("Y-m-d"),
            "tinggi" => floatval($_POST["tinggi"]),
            "daun" => intval($_POST["daun"]),
            "batang" => floatval($_POST["batang"]),
            "catatan" => htmlspecialchars($_POST["catatan"]),
            "issue" => $_POST["issue"] ?? "none"
        ];
        writeLog("Growth log HST $hst_log saved (Tinggi: {$_POST['tinggi']}cm)", "GROWTH");
    }
    
    // CHECKLIST UPDATE
    if (isset($_POST["update_checklist"])) {
        $hst_check = intval($_POST["hst_checklist"]);
        $data["checklist_done"][$hst_check] = $_POST["tasks"] ?? [];
        writeLog("Checklist HST $hst_check: " . count($data["checklist_done"][$hst_check]) . " tasks completed", "MAINTENANCE");
    }
    
    // PUMP CONTROL
    if (isset($_POST["pump_action"])) {
        $action = $_POST["pump_action"];
        if ($action === "ON") {
            $data["pompa_status"] = "ON";
            $data["pompa_manual_start"] = date("Y-m-d H:i:s");
            $data["manual_pump_count"]++;
            writeLog("Manual pump ON (#{$data['manual_pump_count']} today)", "PUMP");
        } else {
            $data["pompa_status"] = "OFF";
            $data["pompa_manual_start"] = null;
            writeLog("Manual pump OFF", "PUMP");
        }
    }
    
    // RESET
    if (isset($_POST["reset_system"])) {
        createBackup();
        $data = defaultData();
        writeLog("SYSTEM RESET - Backup created", "CRITICAL");
    }
    
    saveData($data);
    header("Location: ?hst=".($_POST['target_hst'] ?? $hstAktif)); 
    exit;
}

$selectedHST = $_GET["hst"] ?? $hstAktif;
if (!isset($data["hst"][$selectedHST])) $data["hst"][$selectedHST] = [];

// Important logs only
$all_logs = file_exists(LOG_FILE) ? file(LOG_FILE) : [];
$important_logs = array_filter($all_logs, function($line){
    return strpos($line, "[PUMP]") !== false || 
           strpos($line, "[SCHEDULE]") !== false || 
           strpos($line, "[CONFIG]") !== false ||
           strpos($line, "[CRITICAL]") !== false ||
           strpos($line, "[SAFETY]") !== false;
});
$logs = array_reverse(array_slice($important_logs, -8));

// Data untuk Chart Pertumbuhan
$chart_hst = []; $chart_tinggi = []; $chart_daun = [];
ksort($data["logs_harian"]);
foreach($data["logs_harian"] as $h => $v) {
    $chart_hst[] = "HST $h";
    $chart_tinggi[] = $v["tinggi"];
    $chart_daun[] = $v["daun"];
}

// Growth comparison
$prev_log = null;
$growth_delta = ["tinggi" => 0, "daun" => 0];
if (isset($data["logs_harian"][$hstAktif])) {
    $current_log = $data["logs_harian"][$hstAktif];
    $prev_hst = $hstAktif - 1;
    if (isset($data["logs_harian"][$prev_hst])) {
        $prev_log = $data["logs_harian"][$prev_hst];
        $growth_delta["tinggi"] = round($current_log["tinggi"] - $prev_log["tinggi"], 1);
        $growth_delta["daun"] = $current_log["daun"] - $prev_log["daun"];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>BloomFields | IoT</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0b0f1a; --card: #161e2d; --accent: #10b981; 
            --text: #f1f5f9; --text-dim: #94a3b8; --danger: #ef4444; --warning: #f59e0b; --blue: #38bdf8;
        }
        * { box-sizing: border-box; }
        body { margin:0; font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text); padding-bottom: 50px; }
        header { background: #020617; padding: 25px; border-bottom: 1px solid #1e293b; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; }
        .container { max-width: 1400px; margin: auto; padding: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .card { background: var(--card); border-radius: 16px; padding: 25px; border: 1px solid #2d3748; position: relative; }
        .full-width { grid-column: 1 / -1; }
        
        .main-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .stat-card { background: rgba(255,255,255,0.03); padding: 18px; border-radius: 12px; border-left: 4px solid var(--accent); }
        .stat-v { font-size: 1.6rem; font-weight: 800; color: var(--accent); display: block; margin-top: 5px; }
        .stat-l { font-size: 0.7rem; color: var(--text-dim); text-transform: uppercase; letter-spacing: 1px; }

        .insight-box { background: linear-gradient(90deg, rgba(16, 185, 129, 0.1), transparent); border: 1px dashed var(--accent); padding: 15px; border-radius: 10px; margin-bottom: 20px; }
        
        .warning-box { padding: 12px 15px; border-radius: 8px; margin-bottom: 10px; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 10px; }
        .warning-danger { background: rgba(239, 68, 68, 0.15); border-left: 3px solid var(--danger); }
        .warning-warning { background: rgba(245, 158, 11, 0.15); border-left: 3px solid var(--warning); }
        .warning-info { background: rgba(56, 189, 248, 0.15); border-left: 3px solid var(--blue); }

        .pg-container { background: #1e293b; border-radius: 20px; height: 12px; margin: 10px 0; overflow: hidden; }
        .pg-bar { background: linear-gradient(90deg, var(--accent), #34d399); height: 100%; transition: 1s; }

        input, select, textarea { width: 100%; background: #0b0f1a; border: 1px solid #334155; color: #fff; border-radius: 8px; padding: 10px; margin-bottom: 12px; font-family: inherit; }
        button { width: 100%; padding: 12px; border-radius: 8px; border: none; font-weight: 700; cursor: pointer; transition: 0.2s; font-family: inherit; }
        .btn-green { background: var(--accent); color: #fff; }
        .btn-outline { background: transparent; border: 1px solid #334155; color: var(--text); }
        button:hover { opacity: 0.85; }
        button:disabled { opacity: 0.4; cursor: not-allowed; }
        
        table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
        th { text-align: left; color: var(--text-dim); padding: 10px; border-bottom: 1px solid #334155; }
        td { padding: 10px; border-bottom: 1px solid #222; }

        .log-box { background: #0b0f1a; border-radius: 8px; padding: 12px; font-family: 'Courier New', monospace; font-size: 0.72rem; height: 120px; overflow-y: auto; color: var(--accent); }
        .pump-badge { padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 800; }
        .status-on { background: rgba(16, 185, 129, 0.2); color: var(--accent); border: 1px solid var(--accent); }
        .status-off { background: rgba(239, 68, 68, 0.2); color: var(--danger); border: 1px solid var(--danger); }

        .schedule-preview { background: rgba(56, 189, 248, 0.1); padding: 12px; border-radius: 8px; margin: 15px 0; border-left: 3px solid var(--blue); }
        .schedule-item { padding: 8px 0; display: flex; justify-content: space-between; border-bottom: 1px dashed #334155; }
        
        .checklist-item { display: flex; align-items: center; gap: 10px; padding: 8px; margin: 5px 0; background: rgba(255,255,255,0.02); border-radius: 6px; }
        .checklist-item input[type="checkbox"] { width: auto; margin: 0; }
        
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 0.7rem; font-weight: 700; }
        .badge-good { background: rgba(16, 185, 129, 0.2); color: var(--accent); }
        .badge-ok { background: rgba(245, 158, 11, 0.2); color: var(--warning); }
        .badge-bad { background: rgba(239, 68, 68, 0.2); color: var(--danger); }
        
        .lock-indicator { position: absolute; top: 15px; right: 15px; font-size: 1.2rem; }
        
        @media (max-width: 1000px) { .container { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<header>
    <div>
        <div style="font-size: 1.5rem; font-weight: 800; color: var(--accent); letter-spacing: -1px;">
            BLOOMFIELDS <span style="color:var(--text-dim)">IOT</span>
            <?php if($data["parameter_lock"]): ?>
                <span style="font-size: 1rem; color: var(--danger);">🔒</span>
            <?php endif; ?>
        </div>
        <div id="clock" style="color: var(--text-dim); font-size: 0.8rem; margin-top: 4px;">Loading...</div>
    </div>
    <div style="display: flex; gap: 15px; align-items: center;">
        <div style="text-align: right; background: rgba(255,255,255,0.05); padding: 8px 15px; border-radius: 12px; border: 1px solid #334155;">
            <span id="temp" style="font-weight: 700; color: var(--blue);">--°C</span>
            <div id="weather-text" style="font-size: 0.65rem; color: var(--text-dim);">Singosari, ID</div>
        </div>
        <span class="status-badge badge-<?=$plantStatus['status']?>"><?=$plantStatus['icon']?> <?=$plantStatus['text']?></span>
    </div>
</header>

<?php if(isset($_GET["backup_success"])): ?>
<div class="container" style="padding-top: 0;">
    <div class="full-width" style="background: rgba(16, 185, 129, 0.15); padding: 15px; border-radius: 8px; border: 1px solid var(--accent); text-align: center; font-weight: 600;">
        ✅ Backup berhasil: <?=htmlspecialchars($_GET["backup_success"])?>
    </div>
</div>
<?php endif; ?>

<?php if(isset($_GET["error"]) && $_GET["error"] == "locked"): ?>
<div class="container" style="padding-top: 0;">
    <div class="full-width" style="background: rgba(239, 68, 68, 0.15); padding: 15px; border-radius: 8px; border: 1px solid var(--danger); text-align: center; font-weight: 600;">
        🔒 Parameter terkunci! Unlock terlebih dahulu di System Config.
    </div>
</div>
<?php endif; ?>

<div class="container">

    <!-- WARNINGS & TODAY PREVIEW -->
    <div class="card full-width">
        <?php if(!empty($warnings)): ?>
            <?php foreach($warnings as $w): ?>
                <div class="warning-box warning-<?=$w['type']?>">
                    <?=$w['msg']?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <div class="insight-box">
            <div class="stat-l" style="color:var(--accent); font-weight:700">📌 INSTRUKSI HARIAN (HST <?=$hstAktif?>)</div>
            <div style="font-size: 1.1rem; font-weight: 600; margin-top: 5px; color: var(--text);">
                <?=$current_ref['ket']?>
            </div>
        </div>

        <?php if(!empty($todaySchedule)): ?>
        <div class="schedule-preview">
            <div style="font-weight: 700; margin-bottom: 8px; font-size: 0.85rem;">🕐 Jadwal Siram Hari Ini:</div>
            <?php foreach($todaySchedule as $s): ?>
                <div class="schedule-item">
                    <span>⏰ <?=$s['jam']?></span>
                    <span><?=$s['durasi']?> menit</span>
                </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div style="padding: 15px; background: rgba(239, 68, 68, 0.1); border-radius: 8px; text-align: center; color: var(--danger); font-weight: 600;">
            ⚠️ Tidak ada jadwal siram untuk HST <?=$hstAktif?>
        </div>
        <?php endif; ?>

        <div class="main-stats">
            <div class="stat-card">
                <span class="stat-l">Umur Tanaman</span>
                <span class="stat-v">HST <?=$hstAktif?></span>
            </div>
            <div class="stat-card" style="border-left-color: var(--blue);">
                <span class="stat-l">Fase / pH</span>
                <span class="stat-v" style="font-size: 1.1rem; color: var(--blue);"><?=$fase?> <small style="font-size:0.7rem">(pH 5.9-6.2)</small></span>
            </div>
            <div class="stat-card" style="border-left-color: var(--warning);">
                <span class="stat-l">Target Nutrisi</span>
                <span class="stat-v" style="font-size: 1.1rem; color: var(--warning);"><?=$current_ref['ec']?> EC / <?=$current_ref['ppm']?> PPM</span>
            </div>
            <div class="stat-card" style="border-left-color: #a78bfa;">
                <span class="stat-l">Volume Air/Tanaman</span>
                <span class="stat-v" style="font-size: 1.1rem; color: #a78bfa;"><?=$current_ref['vol']?> ml</span>
            </div>
        </div>

        <label class="stat-l">Progress Panen (Target: <?=$data['hst_max']?> HST)</label>
        <div class="pg-container"><div class="pg-bar" style="width: <?=$progress?>%"></div></div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 20px;">
        
        <!-- GROWTH LOG WITH COMPARISON -->
        <div class="card">
            <h3 style="margin-top:0; font-size:1.1rem; color:var(--accent)">🌱 Jurnal Pertumbuhan</h3>
            
            <?php if($prev_log): ?>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 15px; padding: 10px; background: rgba(56, 189, 248, 0.1); border-radius: 8px;">
                <div>
                    <div class="stat-l">Perubahan Tinggi</div>
                    <div style="font-weight: 700; color: <?=$growth_delta['tinggi'] > 0 ? 'var(--accent)' : 'var(--danger)'?>;">
                        <?=$growth_delta['tinggi'] > 0 ? '+' : ''?><?=$growth_delta['tinggi']?> cm
                    </div>
                </div>
                <div>
                    <div class="stat-l">Perubahan Daun</div>
                    <div style="font-weight: 700; color: <?=$growth_delta['daun'] > 0 ? 'var(--accent)' : 'var(--danger)'?>;">
                        <?=$growth_delta['daun'] > 0 ? '+' : ''?><?=$growth_delta['daun']?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <p class="stat-l" style="margin-bottom:15px">Catat perkembangan fisik tanaman hari ini</p>
            <form method="post">
                <input type="hidden" name="save_daily_log">
                <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap:10px">
                    <div>
                        <label class="stat-l">HST Terpilih</label>
                        <input type="number" name="hst_log" value="<?=$hstAktif?>" required>
                    </div>
                    <div>
                        <label class="stat-l">Tinggi (cm)</label>
                        <input type="number" step="0.1" name="tinggi" placeholder="0.0" required>
                    </div>
                    <div>
                        <label class="stat-l">Jumlah Daun</label>
                        <input type="number" name="daun" placeholder="0" required>
                    </div>
                </div>
                <div style="display:grid; grid-template-columns: 1fr 2fr; gap:10px">
                    <div>
                        <label class="stat-l">Batang (mm)</label>
                        <input type="number" step="0.1" name="batang" placeholder="0.0">
                    </div>
                    <div>
                        <label class="stat-l">Masalah (Quick Pick)</label>
                        <select name="issue">
                            <option value="none">✅ Normal</option>
                            <option value="hama">🐛 Hama</option>
                            <option value="layu">💧 Layu</option>
                            <option value="kuning">🟡 Daun Kuning</option>
                            <option value="akar">🌱 Masalah Akar</option>
                        </select>
                    </div>
                </div>
                <label class="stat-l">Catatan Tambahan</label>
                <input type="text" name="catatan" placeholder="Detail kondisi...">
                <button class="btn-green">Simpan Log Harian</button>
            </form>

            <div style="margin-top:20px; max-height: 300px; overflow-y:auto;">
                <table>
                    <thead>
                        <tr><th>HST</th><th>Tinggi</th><th>Daun</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <?php if(empty($data['logs_harian'])): ?>
                            <tr><td colspan="4" style="text-align:center; color:var(--text-dim)">Belum ada data pertumbuhan.</td></tr>
                        <?php else: ?>
                            <?php foreach(array_reverse($data['logs_harian'], true) as $h => $v): ?>
                            <tr>
                                <td><b><?=$h?></b></td>
                                <td><?=$v['tinggi']?> cm</td>
                                <td><?=$v['daun']?></td>
                                <td style="font-size:0.7rem;">
                                    <?php
                                    $icons = ["none" => "✅", "hama" => "🐛", "layu" => "💧", "kuning" => "🟡", "akar" => "🌱"];
                                    echo $icons[$v['issue']] ?? "✅";
                                    ?>
                                    <span style="color:var(--text-dim)"><?=$v['catatan']?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MAINTENANCE CHECKLIST -->
        <?php if(isset($maintenance_checklist[$hstAktif])): ?>
        <div class="card">
            <h3 style="margin-top:0; font-size:1rem; color:var(--warning)">✅ Checklist Perawatan HST <?=$hstAktif?></h3>
            <form method="post">
                <input type="hidden" name="update_checklist">
                <input type="hidden" name="hst_checklist" value="<?=$hstAktif?>">
                <?php 
                $done_tasks = $data["checklist_done"][$hstAktif] ?? [];
                foreach($maintenance_checklist[$hstAktif] as $i => $task): 
                ?>
                    <label class="checklist-item">
                        <input type="checkbox" name="tasks[]" value="<?=$i?>" <?=in_array($i, $done_tasks) ? 'checked' : ''?>>
                        <span><?=$task?></span>
                    </label>
                <?php endforeach; ?>
                <button class="btn-green" style="margin-top: 10px;">Simpan Checklist</button>
            </form>
        </div>
        <?php endif; ?>

        <div class="card">
            <h3 style="margin:0 0 15px 0; font-size:1rem">Grafik Pertumbuhan</h3>
            <canvas id="growthChart" style="max-height: 250px;"></canvas>
        </div>

        <div class="card">
            <h3 style="margin:0 0 15px 0; font-size:1rem">Tren Nutrisi (EC)</h3>
            <canvas id="ecChart" style="max-height: 150px;"></canvas>
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 20px;">
        
        <!-- PUMP CONTROL WITH SAFETY -->
        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px">
                <h3 style="margin:0; font-size:1rem">Pompa & Logs</h3>
                <span class="pump-badge <?= $data['pompa_status'] == 'ON' ? 'status-on' : 'status-off' ?>">
                    POMPA: <?=$data['pompa_status']?>
                    <?php if($data['pompa_status'] == 'ON' && $data['pompa_manual_start']): ?>
                        <?php 
                        $elapsed = round((time() - strtotime($data['pompa_manual_start'])) / 60);
                        $remaining = max(0, $data['pompa_manual_timer'] - $elapsed);
                        ?>
                        <span style="font-size: 0.6rem; color: var(--warning); display: block;">⏱️ <?=$remaining?>m</span>
                    <?php endif; ?>
                </span>
            </div>
            
            <div style="background: rgba(245, 158, 11, 0.1); padding: 10px; border-radius: 6px; margin-bottom: 10px; font-size: 0.75rem; color: var(--warning);">
                ⚠️ Manual: <?=$data['manual_pump_count']?> kali hari ini | Auto OFF: <?=$data['pompa_manual_timer']?> menit
            </div>
            
            <form method="post" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom:15px">
                <button name="pump_action" value="ON" class="btn-green" style="background:#065f46" 
                    <?=$data['pompa_status'] == 'ON' ? 'disabled' : ''?>>
                    NYALAKAN
                </button>
                <button name="pump_action" value="OFF" class="btn-green" style="background:var(--danger)"
                    <?=$data['pompa_status'] == 'OFF' ? 'disabled' : ''?>>
                    MATIKAN
                </button>
            </form>
            
            <div class="stat-l" style="margin-bottom: 5px;">RIWAYAT AKSI PENTING</div>
            <div class="log-box">
                <?php if(empty($logs)): ?>
                    <div style="color: var(--text-dim);">> Belum ada log penting</div>
                <?php else: ?>
                    <?php foreach($logs as $log): ?>
                        <div>> <?=htmlspecialchars($log)?></div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- SCHEDULE EDITOR -->
        <div class="card">
            <?php if($data["parameter_lock"]): ?>
                <div class="lock-indicator" title="Parameters Locked">🔒</div>
            <?php endif; ?>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h3 style="margin:0; font-size:1rem">Jadwal Siram HST <?=$selectedHST?></h3>
                <select id="hst_nav" onchange="location.href='?hst='+this.value" style="width: auto; margin:0;">
                    <?php for($i=0; $i<=$data['hst_max']; $i++): ?>
                        <option value="<?=$i?>" <?=$i == $selectedHST ? 'selected' : ''?>>HST <?=$i?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <form method="post">
                <input type="hidden" name="save_schedule">
                <input type="hidden" name="target_hst" value="<?=$selectedHST?>">
                <table>
                    <tbody id="schedule-rows">
                        <?php foreach($data['hst'][$selectedHST] as $j): ?>
                        <tr>
                            <td><input type="time" name="jam[]" value="<?=$j['jam']?>" required <?=$data["parameter_lock"] ? 'disabled' : ''?>></td>
                            <td width="100"><input type="number" name="durasi[]" value="<?=$j['durasi']?>" placeholder="Menit" required <?=$data["parameter_lock"] ? 'disabled' : ''?>></td>
                            <td width="30" style="color:var(--danger); cursor:pointer; font-size:1.2rem" onclick="<?=$data['parameter_lock'] ? '' : 'this.parentElement.remove()'?>">×</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div style="display: flex; gap: 10px; margin-top: 15px;">
                    <button type="button" class="btn-outline" onclick="addNewRow()" <?=$data["parameter_lock"] ? 'disabled' : ''?>>+ Slot Siram</button>
                    <button class="btn-green" <?=$data["parameter_lock"] ? 'disabled' : ''?>>Simpan Jadwal</button>
                </div>
            </form>
        </div>

        <!-- SYSTEM CONFIG -->
        <div class="card">
            <h3 style="margin:0 0 15px 0; font-size:1rem">System Configuration</h3>
            
            <form method="post" style="margin-bottom: 15px;">
                <button name="toggle_lock" class="btn-outline" style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <?php if($data["parameter_lock"]): ?>
                        🔓 Unlock Parameters
                    <?php else: ?>
                        🔒 Lock Parameters
                    <?php endif; ?>
                </button>
            </form>
            
            <form method="post">
                <input type="hidden" name="update_config">
                <label class="stat-l">Tanggal Tanam</label>
                <input type="date" name="tanggal_mulai" value="<?=$data['tanggal_mulai']?>" <?=$data["parameter_lock"] ? 'disabled' : ''?>>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px">
                    <div>
                        <label class="stat-l">HST Awal</label>
                        <input type="number" name="hst_mulai" value="<?=$data['hst_mulai']?>" <?=$data["parameter_lock"] ? 'disabled' : ''?>>
                    </div>
                    <div>
                        <label class="stat-l">Target Panen</label>
                        <input type="number" name="hst_max" value="<?=$data['hst_max']?>" <?=$data["parameter_lock"] ? 'disabled' : ''?>>
                    </div>
                </div>
                <label class="stat-l">Max Timer Manual (menit)</label>
                <input type="number" name="pompa_manual_timer" value="<?=$data['pompa_manual_timer']?>" min="5" max="120">
                <button class="btn-outline" <?=$data["parameter_lock"] ? 'disabled' : ''?>>Update Parameter</button>
            </form>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 15px;">
                <form method="post">
                    <button name="create_backup" class="btn-green" style="background: var(--blue); font-size: 0.8rem;">
                        💾 Backup Now
                    </button>
                </form>
                <form method="post" onsubmit="return confirm('Reset akan menghapus SEMUA data dan membuat backup otomatis. Lanjutkan?')">
                    <button name="reset_system" style="background:none; color:var(--danger); font-size:0.8rem; border:1px solid var(--danger)">
                        ⚠️ RESET
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    // Clock & Weather
    function updateClock() {
        const now = new Date();
        document.getElementById('clock').innerText = now.toLocaleDateString('id-ID', { 
            weekday: 'long', day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit', second: '2-digit' 
        });
    }
    setInterval(updateClock, 1000); updateClock();

    async function fetchWeather() {
        try {
            const res = await fetch('https://api.open-meteo.com/v1/forecast?latitude=-7.89&longitude=112.66&current_weather=true');
            const d = await res.json();
            document.getElementById('temp').innerText = Math.round(d.current_weather.temperature) + '°C';
            document.getElementById('weather-text').innerText = "Singosari | UV: High";
        } catch (e) { console.error('Weather fetch failed'); }
    }
    fetchWeather();

    function addNewRow() {
        const locked = <?=$data["parameter_lock"] ? 'true' : 'false'?>;
        if (locked) return;
        const html = `<tr>
            <td><input type="time" name="jam[]" required></td>
            <td><input type="number" name="durasi[]" value="5" required></td>
            <td style="color:var(--danger); cursor:pointer; font-size:1.2rem" onclick="this.parentElement.remove()">×</td>
        </tr>`;
        document.getElementById('schedule-rows').insertAdjacentHTML('beforeend', html);
    }

    // Charts
    new Chart(document.getElementById('growthChart'), {
        type: 'line',
        data: {
            labels: <?=json_encode($chart_hst)?>,
            datasets: [
                {
                    label: 'Tinggi (cm)',
                    data: <?=json_encode($chart_tinggi)?>,
                    borderColor: '#38bdf8',
                    backgroundColor: 'rgba(56, 189, 248, 0.1)',
                    yAxisID: 'y',
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Jml Daun',
                    data: <?=json_encode($chart_daun)?>,
                    borderColor: '#fbbf24',
                    yAxisID: 'y1',
                    borderDash: [5, 5],
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: { 
                legend: { labels: { color: '#94a3b8', font: { size: 10 } } },
                tooltip: { mode: 'index' }
            },
            scales: {
                y: { 
                    type: 'linear', 
                    display: true, 
                    position: 'left', 
                    grid: { color: '#222' },
                    ticks: { color: '#94a3b8' }
                },
                y1: { 
                    type: 'linear', 
                    display: true, 
                    position: 'right', 
                    grid: { drawOnChartArea: false },
                    ticks: { color: '#94a3b8' }
                },
                x: { ticks: { color: '#94a3b8' } }
            }
        }
    });

    new Chart(document.getElementById('ecChart'), {
        type: 'line',
        data: {
            labels: [1, 15, 20, 30, 40, 55, 70],
            datasets: [{
                label: 'Target EC',
                data: [1.5, 1.5, 2.0, 2.3, 2.5, 2.4, 1.6],
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            scales: { 
                y: { display: true, ticks: { color: '#94a3b8' } }, 
                x: { ticks: { color: '#94a3b8' } } 
            },
            plugins: { legend: { display: false } }
        }
    });
</script>
</body>
</html>
