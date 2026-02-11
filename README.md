# 🌱 BLOOMFIELDS IoT V1
**Industrial IoT Irrigation & HST Control System (ESP32 + Web Platform)**

> Sistem smart farming profesional untuk kontrol irigasi & nutrisi berbasis  
> **HST (Hari Setelah Tanam)** dengan sinkronisasi cloud & kontrol lokal ESP32.  
>  
> Dirancang untuk **operasi 24/7**, **aman restart**, dan **siap skala industri**.

---

## 🔒 LICENSE STATUS (IMPORTANT)
🚫 **THIS PROJECT IS NOT OPEN SOURCE**

This repository is **PROPRIETARY / CLOSED SOURCE**  
All rights reserved under **BloomFields Pro**.

Unauthorized use, modification, distribution, or commercial deployment  
is strictly prohibited without written permission.

See full terms in the `LICENSE` file.

---

## 📌 SYSTEM OVERVIEW

BloomFields Pro V5 terdiri dari **2 komponen utama**:

1. **Web Control System (PHP + JSON)**
2. **ESP32 Industrial Controller**

Keduanya terhubung via **HTTPS API** dan berjalan **sinkron berbasis HST**.

---

## 🧠 CORE CONCEPT (HST-BASED LOGIC)

- Semua jadwal irigasi berbasis **Hari Setelah Tanam (HST)**
- HST dihitung otomatis dari `tanggal_mulai`
- Setiap HST memiliki jadwal independen
- ESP32 **tidak mengandalkan input manual**
- Sistem tetap berjalan walau internet mati (offline-safe)

---

## ✨ FEATURES

### 🌐 WEB DASHBOARD (PHP)
- Edit jadwal irigasi per-HST
- Multiple jadwal per hari
- Auto-generate `data.json`
- Manual ON/OFF pompa
- Parameter lock (anti salah sentuh)
- Log sistem dengan timestamp WIB
- API endpoint khusus ESP32
- Industrial-safe (no blocking process)

---

### 🤖 ESP32 CONTROLLER
- Auto cloud sync (boot & interval)
- Fallback ke LittleFS (offline mode)
- Scheduler presisi menit (non-blocking)
- Manual pump dengan auto-timeout
- Web dashboard lokal ESP32
- NTP time sync (WIB)
- Relay / SSR friendly (industrial grade)
- Aman restart listrik

---

## 🧱 SYSTEM ARCHITECTURE
USER
│
▼
Web Dashboard (index.php)
│
▼
data.json ←── Editable via UI
│
▼
api.php (HTTPS)
│
▼
ESP32 Controller
│
├─ Local Cache (LittleFS)
├─ Scheduler Engine
└─ Web Dashboard (Local)
│
▼
Relay / SSR
│
▼
Pompa / Valve

---

## 🔄 ESP32 SYNC BEHAVIOR

ESP32 akan fetch data dari cloud saat:
- 🔌 Boot / restart
- ⏱️ Setiap 10 menit (auto-sync)
- 👆 Manual trigger dari dashboard ESP32

**Prioritas data:**
1. Cloud (`api.php`)
2. Local cache (`/schedule.json` di LittleFS)

---

## 📁 REPOSITORY STRUCTURE
BloomFields-Pro-V5/
├── esp32/
│ └── esp32_bloomfields_v5.ino
│
├── web/
│ ├── index.php
│ ├── api.php
│ ├── data.json
│ └── system.log
│
├── docs/
│ ├── architecture.png
│ └── flow-diagram.png
│
├── LICENSE
└── README.md

---

## 🔧 INSTALLATION GUIDE

### 1️⃣ SERVER SETUP (WEB)

Upload ke hosting:
/public_html/
├── index.php
├── api.php
├── data.json
└── system.log

⚠️ Pastikan:
- PHP aktif
- Folder bisa **write**
- SSL aktif (**HTTPS wajib**)

---

### 2️⃣ ESP32 CONFIGURATION

Edit file `esp32_bloomfields_v5.ino`:

```cpp
// WiFi Credentials
const char* ssid     = "NamaWiFiKamu";
const char* password = "PasswordWiFi";

// Cloud API Endpoint
const char* dataUrl  = "https://domainmu.com/api.php";

// Static IP (Recommended)
IPAddress local_IP(192, 168, 1, 100);
IPAddress gateway(192, 168, 1, 1);
IPAddress subnet(255, 255, 255, 0);
```
3️⃣ REQUIRED LIBRARIES

Install via Arduino Library Manager:

WiFi (built-in)

HTTPClient (built-in)

WebServer (built-in)

ArduinoJson v6.x

LittleFS (ESP32)

4️⃣ UPLOAD TO ESP32

Board: ESP32 Dev Module

Port: sesuai device

Baud Rate: 115200

Upload & reboot

📡 API SPECIFICATION
GET /api.php

Response:
{
  "tanggal_mulai": "2026-02-11",
  "hst_mulai": 1,
  "hst_max": 69,
  "hst_aktif": 1,
  "pompa_status": "OFF",
  "pompa_manual_timer": 30,
  "parameter_lock": false,
  "manual_pump_count": 0,
  "hst": [
    [],
    [
      { "jam": "06:00", "durasi": 5 },
      { "jam": "12:00", "durasi": 7 }
    ]
  ]
}
⏱️ SCHEDULER RULES

Format jam wajib: HH:MM

Durasi dalam menit

Tidak ada overlap (auto-skip jika konflik)

Scheduler non-blocking

Aman restart di tengah jadwal

🧪 TESTING CHECKLIST
✅ WiFi
[WIFI] Connected: 192.168.1.100

✅ Cloud Sync
[SYNC] Fetching cloud data...
[SYNC] SUCCESS

✅ Scheduler
[PUMP] ON (Scheduled) 5 menit
[PUMP] OFF

✅ Restart Safety
[SYSTEM] Boot
[SYSTEM] Cloud sync priority

🐛 TROUBLESHOOTING
Issue	Solution
HTTP -1	SSL / URL salah
JSON error	Validasi JSON
Jadwal tidak jalan	Cek NTP
Pompa terbalik	Invert relay logic
HST salah	Cek tanggal_mulai
🔐 SECURITY NOTES

HTTPS WAJIB

Bisa ditambah IP whitelist

Siap untuk API key / token

Parameter lock mencegah human error

📈 STABILITY & SAFETY

✔ Designed for 24/7 operation
✔ Safe restart (power loss)
✔ Offline capable
✔ Industrial relay / SSR ready

🚀 FUTURE ROADMAP (OPTIONAL)

Telegram / WhatsApp notification

Multi-zone irrigation

EC / pH sensor integration

OTA firmware update

Data export (CSV / PDF)

ESP32-CAM monitoring

👤 INTENDED USE

This system is intended for:

Greenhouse automation

Precision agriculture

Controlled irrigation systems

Internal / commercial farming operations

Not intended for public redistribution.

🏷️ VERSIONING

Current Version: v5.0

Status: Production Stable

Release Type: Internal

❤️ CREDITS

Developed by BloomFields Pro
Industrial Smart Farming Solutions

Happy Growing 🌱

