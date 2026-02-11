#include <WiFi.h>
#include <HTTPClient.h>
#include <WiFiClientSecure.h>
#include <ArduinoJson.h>
#include <time.h>
#include <LittleFS.h>
#include <Preferences.h>
#include <vector>
#include <WebServer.h>
//  ====================================================
//     BloomFields - IOT (V1.0)
//     Enhanced with Production Safety Features
//     Location: Singosari, Malang, Jawa Timur
//     Copyright (c) 2026 BloomFields.id
//     All rights reserved.
//     
//     Website   : https://bloomfields.id
//     Contact   : +62 813 5701 6423
// =====================================================
// =====================================================
// 1. KONFIGURASI WIFI & SERVER
// =====================================================
const char* ssid     = "Roleplay Meeting";
const char* password = "selamatberdiskusi";
const char* dataUrl  = "https://bloomfields.cloud/data.json";

// --- STATIC IP ---
IPAddress local_IP(192, 168, 110, 213);
IPAddress gateway(192, 168, 110, 1);
IPAddress subnet(255, 255, 255, 0);
IPAddress primaryDNS(8, 8, 8, 8);
IPAddress secondaryDNS(8, 8, 4, 4);
WebServer server(80);

// --- RELAY ---
#define RELAY_PIN 27   // ACTIVE LOW

// =====================================================
// 2. STRUKTUR DATA (SYNC DENGAN WEB V5)
// =====================================================
struct Schedule {
  String time;    // HH:MM
  int duration;   // menit
};

std::vector<Schedule> currentSchedules;
Preferences pref;
String systemLog = "";
int currentHST = 1;
bool timeValid = false;
bool manualMode = false;
unsigned long manualStartTime = 0;
int manualTimer = 30; // Default 30 menit
int manualPumpCount = 0;
String lastManualDate = "";
bool parameterLock = false;
String pumpStatus = "OFF";

// =====================================================
// 3. ENHANCED LOGGING (V5 COMPATIBLE)
// =====================================================
void addLog(const String& msg, const String& type = "INFO") {
  struct tm ti;
  char buf[20] = "??:??:??";

  if (getLocalTime(&ti)) {
    strftime(buf, sizeof(buf), "%Y-%m-%d %H:%M:%S", &ti);
  }

  String entry = "[" + String(buf) + "] [" + type + "] " + msg;
  systemLog = entry + "\n" + systemLog;
  
  // Keep last 50 entries
  int count = 0;
  int lastNewline = 0;
  for (int i = 0; i < systemLog.length(); i++) {
    if (systemLog[i] == '\n') {
      count++;
      if (count > 50) {
        systemLog = systemLog.substring(0, i);
        break;
      }
    }
  }

  Serial.println(entry);
}

// =====================================================
// 4. ENHANCED STATUS JSON (V5 FORMAT)
// =====================================================
String getStatusJSON() {
  struct tm ti;
  char timeBuf[20] = "N/A";
  char dateBuf[12] = "N/A";
  
  if (getLocalTime(&ti)) {
    strftime(timeBuf, sizeof(timeBuf), "%H:%M:%S", &ti);
    strftime(dateBuf, sizeof(dateBuf), "%Y-%m-%d", &ti);
  }

  String json = "{";
  json += "\"wifi\":\"" + String(WiFi.status() == WL_CONNECTED ? "CONNECTED" : "DISCONNECTED") + "\",";
  json += "\"rssi\":" + String(WiFi.RSSI()) + ",";
  json += "\"ip\":\"" + WiFi.localIP().toString() + "\",";
  json += "\"time\":\"" + String(timeBuf) + "\",";
  json += "\"date\":\"" + String(dateBuf) + "\",";
  json += "\"hst\":" + String(currentHST) + ",";
  json += "\"schedule_count\":" + String(currentSchedules.size()) + ",";
  json += "\"relay\":\"" + pumpStatus + "\",";
  json += "\"manual_mode\":" + String(manualMode ? "true" : "false") + ",";
  json += "\"manual_timer\":" + String(manualTimer) + ",";
  json += "\"manual_count\":" + String(manualPumpCount) + ",";
  json += "\"parameter_lock\":" + String(parameterLock ? "true" : "false") + ",";
  json += "\"uptime\":" + String(millis() / 1000) + ",";
  json += "\"free_heap\":" + String(ESP.getFreeHeap());
  json += "}";

  return json;
}

// =====================================================
// 5. ENHANCED WEB DASHBOARD (V5 STYLE)
// =====================================================
String dashboardHTML() {
  return R"rawliteral(
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>ESP32 BloomFields V5</title>
<style>
:root {
  --bg: #0b0f1a; --card: #161e2d; --accent: #10b981; 
  --text: #f1f5f9; --dim: #94a3b8; --danger: #ef4444; --blue: #38bdf8;
}
* { margin:0; padding:0; box-sizing:border-box; }
body { 
  font-family: 'Segoe UI', sans-serif; 
  background: var(--bg); 
  color: var(--text); 
  padding: 15px;
}
.header {
  background: #020617;
  padding: 20px;
  border-radius: 12px;
  margin-bottom: 20px;
  border: 1px solid #1e293b;
}
.title {
  font-size: 1.5rem;
  font-weight: 800;
  color: var(--accent);
  letter-spacing: -1px;
}
.subtitle {
  font-size: 0.8rem;
  color: var(--dim);
  margin-top: 5px;
}
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 15px;
  margin-bottom: 20px;
}
.card {
  background: var(--card);
  border: 1px solid #2d3748;
  border-radius: 12px;
  padding: 20px;
}
.stat-label {
  font-size: 0.7rem;
  color: var(--dim);
  text-transform: uppercase;
  letter-spacing: 1px;
}
.stat-value {
  font-size: 1.5rem;
  font-weight: 800;
  color: var(--accent);
  margin-top: 5px;
}
.badge {
  display: inline-block;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 0.7rem;
  font-weight: 800;
}
.badge-on {
  background: rgba(16, 185, 129, 0.2);
  color: var(--accent);
  border: 1px solid var(--accent);
}
.badge-off {
  background: rgba(239, 68, 68, 0.2);
  color: var(--danger);
  border: 1px solid var(--danger);
}
.log-box {
  background: #0b0f1a;
  border-radius: 8px;
  padding: 12px;
  font-family: 'Courier New', monospace;
  font-size: 0.7rem;
  color: var(--accent);
  height: 300px;
  overflow-y: auto;
  white-space: pre-wrap;
  word-wrap: break-word;
}
.schedule-item {
  background: rgba(56, 189, 248, 0.1);
  padding: 10px;
  margin: 5px 0;
  border-radius: 6px;
  border-left: 3px solid var(--blue);
  display: flex;
  justify-content: space-between;
}
button {
  width: 100%;
  padding: 12px;
  border: none;
  border-radius: 8px;
  font-weight: 700;
  cursor: pointer;
  margin-top: 10px;
  transition: 0.2s;
}
.btn-on {
  background: #065f46;
  color: white;
}
.btn-off {
  background: var(--danger);
  color: white;
}
.btn-sync {
  background: var(--blue);
  color: white;
}
button:hover { opacity: 0.8; }
button:disabled { opacity: 0.4; cursor: not-allowed; }
.warning {
  background: rgba(245, 158, 11, 0.15);
  border-left: 3px solid #f59e0b;
  padding: 12px;
  margin: 10px 0;
  border-radius: 6px;
  font-size: 0.85rem;
}
</style>
</head>
<body>

<div class="header">
  <div class="title">🌱 BLOOMFIELDS ESP32 V5</div>
  <div class="subtitle">Industrial IoT Controller - Singosari, Malang</div>
</div>

<div class="grid">
  <div class="card">
    <div class="stat-label">Status Koneksi</div>
    <div class="stat-value" id="wifi-status">...</div>
    <div style="margin-top:10px; font-size:0.75rem; color:var(--dim)">
      IP: <span id="ip">...</span><br>
      Signal: <span id="rssi">...</span> dBm
    </div>
  </div>

  <div class="card">
    <div class="stat-label">Waktu Sistem</div>
    <div class="stat-value" style="font-size:1.2rem" id="time">...</div>
    <div style="margin-top:5px; font-size:0.8rem; color:var(--dim)" id="date">...</div>
  </div>

  <div class="card">
    <div class="stat-label">HST Aktif</div>
    <div class="stat-value" id="hst">...</div>
  </div>

  <div class="card">
    <div class="stat-label">Status Pompa</div>
    <div style="margin-top:10px">
      <span class="badge" id="pump-badge">...</span>
      <div id="manual-timer" style="margin-top:8px; font-size:0.75rem; color:var(--dim)"></div>
    </div>
  </div>
</div>

<div class="card" style="margin-bottom:20px">
  <div class="stat-label">Jadwal Hari Ini (<span id="sched-count">0</span> sesi)</div>
  <div id="schedule-list" style="margin-top:10px">
    <div style="color:var(--dim); text-align:center; padding:20px">Memuat jadwal...</div>
  </div>
</div>

<div class="grid">
  <div class="card">
    <div class="stat-label">Kontrol Manual</div>
    <div class="warning">
      Manual: <span id="manual-count">0</span> kali hari ini<br>
      Auto OFF: <span id="manual-max">30</span> menit
    </div>
    <button class="btn-on" onclick="pumpControl('ON')" id="btn-on">NYALAKAN POMPA</button>
    <button class="btn-off" onclick="pumpControl('OFF')" id="btn-off">MATIKAN POMPA</button>
  </div>

  <div class="card">
    <div class="stat-label">Aksi Sistem</div>
    <button class="btn-sync" onclick="syncNow()">🔄 SYNC CLOUD</button>
    <button class="btn-sync" onclick="location.reload()">🔃 REFRESH DASHBOARD</button>
    <div style="margin-top:15px; font-size:0.7rem; color:var(--dim)">
      Uptime: <span id="uptime">0</span>s | RAM: <span id="ram">0</span> bytes
    </div>
  </div>
</div>

<div class="card">
  <div class="stat-label">📜 System Log (Real-time)</div>
  <div class="log-box" id="log">Loading...</div>
</div>

<script>
let schedules = [];

function updateUI() {
  fetch('/status')
    .then(r => r.json())
    .then(d => {
      // WiFi
      document.getElementById('wifi-status').textContent = d.wifi;
      document.getElementById('wifi-status').style.color = 
        d.wifi === 'CONNECTED' ? 'var(--accent)' : 'var(--danger)';
      document.getElementById('ip').textContent = d.ip;
      document.getElementById('rssi').textContent = d.rssi;

      // Time
      document.getElementById('time').textContent = d.time;
      document.getElementById('date').textContent = d.date;

      // HST
      document.getElementById('hst').textContent = d.hst;

      // Pump
      const pumpBadge = document.getElementById('pump-badge');
      pumpBadge.textContent = 'POMPA: ' + d.relay;
      pumpBadge.className = d.relay === 'ON' ? 'badge badge-on' : 'badge badge-off';

      // Manual Timer
      const timerDiv = document.getElementById('manual-timer');
      if (d.manual_mode) {
        timerDiv.innerHTML = '⏱️ Mode Manual Aktif';
        timerDiv.style.color = 'var(--warning)';
      } else {
        timerDiv.innerHTML = '';
      }

      // Manual Count
      document.getElementById('manual-count').textContent = d.manual_count;
      document.getElementById('manual-max').textContent = d.manual_timer;

      // Schedules
      document.getElementById('sched-count').textContent = d.schedule_count;

      // System
      document.getElementById('uptime').textContent = d.uptime;
      document.getElementById('ram').textContent = d.free_heap;

      // Button states
      document.getElementById('btn-on').disabled = (d.relay === 'ON');
      document.getElementById('btn-off').disabled = (d.relay === 'OFF');
    })
    .catch(e => console.error('Status fetch failed:', e));

  // Update log
  fetch('/log')
    .then(r => r.text())
    .then(t => {
      document.getElementById('log').textContent = t || 'Belum ada log';
    })
    .catch(e => console.error('Log fetch failed:', e));

  // Update schedules
  fetch('/schedules')
    .then(r => r.json())
    .then(d => {
      const list = document.getElementById('schedule-list');
      if (d.schedules && d.schedules.length > 0) {
        list.innerHTML = '';
        d.schedules.forEach(s => {
          list.innerHTML += `
            <div class="schedule-item">
              <span>⏰ ${s.time}</span>
              <span>${s.duration} menit</span>
            </div>
          `;
        });
      } else {
        list.innerHTML = '<div style="color:var(--danger); text-align:center; padding:20px">⚠️ Tidak ada jadwal</div>';
      }
    })
    .catch(e => console.error('Schedule fetch failed:', e));
}

function pumpControl(action) {
  fetch('/pump?action=' + action)
    .then(r => r.text())
    .then(msg => {
      alert(msg);
      updateUI();
    })
    .catch(e => alert('Gagal: ' + e));
}

function syncNow() {
  if (confirm('Sync data dari cloud?')) {
    fetch('/sync')
      .then(r => r.text())
      .then(msg => {
        alert(msg);
        updateUI();
      })
      .catch(e => alert('Sync gagal: ' + e));
  }
}

// Auto refresh setiap 2 detik
setInterval(updateUI, 2000);
updateUI();
</script>

</body>
</html>
)rawliteral";
}

// =====================================================
// 6. JSON & STORAGE (V5 FORMAT - ARDUINOJSON V6 COMPATIBLE)
// =====================================================
void parseJsonSchedule(const String& json) {
  DynamicJsonDocument doc(8192); // Bigger size untuk data kompleks
  DeserializationError error = deserializeJson(doc, json);
  
  if (error) {
    addLog("JSON Parse Gagal: " + String(error.c_str()), "ERROR");
    return;
  }

  currentSchedules.clear();

  // PRIORITAS: Ambil hst_aktif langsung dari JSON (paling akurat)
  if (doc.containsKey("hst_aktif")) {
    currentHST = doc["hst_aktif"] | 1;
    pref.putInt("hst", currentHST);
    addLog("HST from Cloud: " + String(currentHST), "SYNC");
  } 
  // Fallback: kalau tidak ada hst_aktif, pakai storage
  else {
    currentHST = pref.getInt("hst", 1);
    addLog("HST from Storage: " + String(currentHST), "WARNING");
  }

  // Parse jadwal dari hst[] ARRAY
  // Format: hst[0] = jadwal HST 0, hst[1] = jadwal HST 1, dst
  if (doc.containsKey("hst")) {
    JsonArray hst_array = doc["hst"];
    
    // Index array dimulai dari 0, jadi HST 1 ada di index 1
    if (currentHST < hst_array.size()) {
      JsonArray jadwal = hst_array[currentHST];
      
      // Iterate jadwal
      for (size_t i = 0; i < jadwal.size(); i++) {
        JsonObject v = jadwal[i];
        
        const char* jam_str = v["jam"];
        int durasi_val = v["durasi"] | 0;
        
        if (jam_str && durasi_val > 0) {
          Schedule s;
          s.time = String(jam_str);
          s.duration = durasi_val;
          currentSchedules.push_back(s);
          addLog("  + " + s.time + " (" + String(s.duration) + "m)", "SCHEDULE");
        }
      }
      
      if (jadwal.size() == 0) {
        addLog("HST " + String(currentHST) + " belum ada jadwal", "INFO");
      }
    } else {
      addLog("HST " + String(currentHST) + " out of range (array size: " + String(hst_array.size()) + ")", "WARNING");
    }
  } else {
    addLog("Field 'hst' tidak ditemukan", "ERROR");
  }

  // Parse manual timer & lock status
  if (doc.containsKey("pompa_manual_timer")) {
    manualTimer = doc["pompa_manual_timer"] | 30;
  }
  
  if (doc.containsKey("parameter_lock")) {
    parameterLock = doc["parameter_lock"] | false;
  }
  
  if (doc.containsKey("manual_pump_count")) {
    manualPumpCount = doc["manual_pump_count"] | 0;
  }

  addLog("Parse OK: HST " + String(currentHST) + " = " + String(currentSchedules.size()) + " schedules", "SYNC");
}

void saveLocal(const String& json) {
  File f = LittleFS.open("/schedule.json", "w");
  if (f) {
    f.print(json);
    f.close();
    addLog("Local Save OK", "STORAGE");
  }
}

void loadLocal() {
  if (!LittleFS.exists("/schedule.json")) {
    addLog("No Local Data", "STORAGE");
    return;
  }
  
  File f = LittleFS.open("/schedule.json", "r");
  if (!f) {
    addLog("Local Load Failed", "ERROR");
    return;
  }

  String content = f.readString();
  f.close();
  
  parseJsonSchedule(content);
  addLog("Mode Offline: Pakai Jadwal Lokal", "STORAGE");
}

// =====================================================
// 7. SYNC CLOUD HTTPS (V5 COMPATIBLE) - PRIORITAS UTAMA
// =====================================================
bool syncCloud() {
  if (WiFi.status() != WL_CONNECTED) {
    addLog("Sync Skip: No WiFi", "WARNING");
    return false;
  }

  addLog("Syncing from Cloud...", "SYNC");

  WiFiClientSecure client;
  client.setInsecure();

  HTTPClient http;
  http.setTimeout(10000); // 10 detik timeout
  
  if (!http.begin(client, dataUrl)) {
    addLog("HTTP Begin Failed", "ERROR");
    return false;
  }

  int code = http.GET();
  
  if (code == HTTP_CODE_OK) {
    String payload = http.getString();
    http.end();
    
    // PENTING: Parse dulu, baru simpan local
    parseJsonSchedule(payload);
    saveLocal(payload);
    
    addLog("✓ Cloud Sync SUCCESS", "SYNC");
    return true;
  } else {
    addLog("Cloud Sync Failed: HTTP " + String(code), "ERROR");
    http.end();
    return false;
  }
}

// =====================================================
// 8. TIME SYNC (ANTI FREEZE)
// =====================================================
void syncTimeSafe() {
  addLog("Syncing NTP...", "TIME");
  
  configTime(
    7 * 3600, 0,
    "pool.ntp.org",
    "time.google.com",
    "time.cloudflare.com"
  );

  struct tm ti;
  for (int i = 0; i < 15; i++) {
    if (getLocalTime(&ti)) {
      timeValid = true;
      time_t now = time(nullptr);
      pref.putULong("epoch", now);
      
      char buf[20];
      strftime(buf, sizeof(buf), "%Y-%m-%d %H:%M:%S", &ti);
      addLog("NTP OK: " + String(buf), "TIME");
      return;
    }
    delay(1000);
  }

  // FALLBACK
  time_t lastEpoch = pref.getULong("epoch", 0);
  if (lastEpoch > 0) {
    struct timeval tv = { lastEpoch, 0 };
    settimeofday(&tv, nullptr);
    timeValid = true;
    addLog("NTP Failed → Using Last Time", "WARNING");
  } else {
    addLog("NTP TOTAL FAILED", "CRITICAL");
  }
}

// =====================================================
// 9. RELAY CONTROL (V5 SAFETY)
// =====================================================
void pumpOn()  { 
  digitalWrite(RELAY_PIN, LOW);
  pumpStatus = "ON";
}

void pumpOff() { 
  digitalWrite(RELAY_PIN, HIGH);
  pumpStatus = "OFF";
}

void runPump(int minutes, bool isManual = false) {
  if (isManual) {
    manualMode = true;
    manualStartTime = millis();
    manualPumpCount++;
    addLog("POMPA ON (Manual #" + String(manualPumpCount) + "): " + String(minutes) + " menit", "PUMP");
  } else {
    addLog("POMPA ON (Scheduled): " + String(minutes) + " menit", "PUMP");
  }
  
  pumpOn();

  unsigned long endMs = millis() + (unsigned long)minutes * 60000UL;
  while (millis() < endMs) {
    delay(500);
    server.handleClient(); // Keep web responsive
  }

  pumpOff();
  manualMode = false;
  addLog("POMPA OFF", "PUMP");
}

// =====================================================
// 10. SCHEDULER (V5 LOGIC)
// =====================================================
void checkSchedule() {
  if (!timeValid) return;

  struct tm ti;
  if (!getLocalTime(&ti)) return;

  char now[6];
  char today[12];
  strftime(now, sizeof(now), "%H:%M", &ti);
  strftime(today, sizeof(today), "%Y-%m-%d", &ti);

  // Reset manual count daily
  if (lastManualDate != String(today)) {
    lastManualDate = String(today);
    manualPumpCount = 0;
    addLog("Daily Reset: Manual Counter = 0", "SYSTEM");
  }

  // Auto-off manual pump if timer exceeded
  if (manualMode && pumpStatus == "ON") {
    unsigned long elapsed = (millis() - manualStartTime) / 60000;
    if (elapsed >= manualTimer) {
      pumpOff();
      manualMode = false;
      addLog("Auto OFF: Manual Timer Expired", "SAFETY");
    }
  }

  // Check scheduled irrigation
  static String lastTrigger = "";
  for (auto& s : currentSchedules) {
    String trigger = String(now) + "_" + String(today);
    if (s.time == String(now) && trigger != lastTrigger) {
      lastTrigger = trigger;
      runPump(s.duration, false);
      delay(61000); // Anti double trigger
    }
  }

  // HST auto-increment (already handled by web, but backup here)
  static int lastDay = ti.tm_mday;
  if (ti.tm_mday != lastDay) {
    lastDay = ti.tm_mday;
    currentHST++;
    pref.putInt("hst", currentHST);
    addLog("New Day → HST " + String(currentHST), "SYSTEM");
  }
}

// =====================================================
// 11. WEB SERVER ENDPOINTS (V1 API)
// =====================================================
void setupWeb() {
  // Dashboard
  server.on("/", []() {
    server.send(200, "text/html", dashboardHTML());
  });

  // Status API
  server.on("/status", []() {
    server.send(200, "application/json", getStatusJSON());
  });

  // Log API
  server.on("/log", []() {
    server.send(200, "text/plain", systemLog);
  });

  // Schedules API
  server.on("/schedules", []() {
    String json = "{\"schedules\":[";
    for (int i = 0; i < currentSchedules.size(); i++) {
      if (i > 0) json += ",";
      json += "{\"time\":\"" + currentSchedules[i].time + "\",";
      json += "\"duration\":" + String(currentSchedules[i].duration) + "}";
    }
    json += "]}";
    server.send(200, "application/json", json);
  });

  // Pump Control API
  server.on("/pump", []() {
    if (!server.hasArg("action")) {
      server.send(400, "text/plain", "Missing action parameter");
      return;
    }

    String action = server.arg("action");
    if (action == "ON") {
      if (pumpStatus == "ON") {
        server.send(200, "text/plain", "Pompa sudah ON");
        return;
      }
      manualMode = true;
      manualStartTime = millis();
      manualPumpCount++;
      pumpOn();
      addLog("Manual PUMP ON #" + String(manualPumpCount), "PUMP");
      server.send(200, "text/plain", "Pompa ON (Auto-off: " + String(manualTimer) + " menit)");
    } 
    else if (action == "OFF") {
      pumpOff();
      manualMode = false;
      addLog("Manual PUMP OFF", "PUMP");
      server.send(200, "text/plain", "Pompa OFF");
    } 
    else {
      server.send(400, "text/plain", "Invalid action");
    }
  });

  // Sync API
  server.on("/sync", []() {
    bool success = syncCloud();
    if (success) {
      server.send(200, "text/plain", "✓ Cloud sync berhasil! HST: " + String(currentHST) + ", Schedules: " + String(currentSchedules.size()));
    } else {
      server.send(500, "text/plain", "✗ Cloud sync gagal. Menggunakan data lokal.");
    }
  });

  server.begin();
  addLog("Web Server Started (Port 80)", "SYSTEM");
}

// =====================================================
// 12. SETUP & LOOP
// =====================================================
void setup() {
  Serial.begin(115200);
  delay(1000);

  pinMode(RELAY_PIN, OUTPUT);
  pumpOff();

  // Init filesystem & preferences
  LittleFS.begin(true);
  pref.begin("irrigation", false);
  lastManualDate = pref.getString("lastDate", "");

  addLog("=== BLOOMFIELDS ESP32 V5 ===", "SYSTEM");
  addLog("Firmware: Build " + String(__DATE__) + " " + String(__TIME__), "SYSTEM");

  // WiFi Setup
  WiFi.config(local_IP, gateway, subnet, primaryDNS, secondaryDNS);
  WiFi.begin(ssid, password);

  addLog("Connecting WiFi [" + String(ssid) + "]...", "WIFI");
  int attempts = 0;
  while (WiFi.status() != WL_CONNECTED && attempts++ < 30) {
    delay(500);
    Serial.print(".");
  }
  Serial.println();

  bool cloudSuccess = false;

  if (WiFi.status() == WL_CONNECTED) {
    addLog("✓ WiFi Connected: " + WiFi.localIP().toString(), "WIFI");
    addLog("  Signal: " + String(WiFi.RSSI()) + " dBm", "WIFI");
    
    delay(2000); // Stabilisasi koneksi
    
    // Sync waktu DULU
    syncTimeSafe();
    
    // PRIORITAS 1: Ambil data dari cloud
    addLog("PRIORITY: Fetching from Cloud...", "SYSTEM");
    cloudSuccess = syncCloud();
    
  } else {
    addLog("X WiFi Failed - Running Offline Mode", "ERROR");
  }

  // FALLBACK: Kalau cloud gagal, pakai data lokal
  if (!cloudSuccess) {
    addLog("FALLBACK: Loading Local Data...", "SYSTEM");
    loadLocal();
    
    // Kalau local juga kosong, set default HST
    if (currentSchedules.size() == 0) {
      currentHST = pref.getInt("hst", 1);
      addLog("No Data Available - HST from storage: " + String(currentHST), "WARNING");
    }
  }

  // Setup web server
  setupWeb();

  // Status summary
  addLog("=== SYSTEM READY ===", "SYSTEM");
  addLog("HST Active: " + String(currentHST), "SYSTEM");
  addLog("Schedules: " + String(currentSchedules.size()), "SYSTEM");
  addLog("Manual Timer: " + String(manualTimer) + " min", "SYSTEM");
  addLog("Dashboard: http://" + WiFi.localIP().toString(), "SYSTEM");
}

void loop() {
  static unsigned long lastCheck = 0;
  static unsigned long lastSync  = 0;

  // Check schedule every 10s
  if (millis() - lastCheck > 10000) {
    lastCheck = millis();
    checkSchedule();
  }

  // Sync cloud every 1 minutes
  if (millis() - lastSync > 100000) {
    lastSync = millis();
    bool success = syncCloud();
    if (!success) {
      addLog("Auto-sync failed, using cached data", "WARNING");
    }
  }

  // Save last date
  struct tm ti;
  if (getLocalTime(&ti)) {
    char today[12];
    strftime(today, sizeof(today), "%Y-%m-%d", &ti);
    if (lastManualDate != String(today)) {
      pref.putString("lastDate", String(today));
    }
  }

  server.handleClient();
  delay(10);
}
