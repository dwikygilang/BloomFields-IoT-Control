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

BloomFields IoT V1 terdiri dari **2 komponen utama**:

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

### 2️⃣ KONFIGURASI ESP32

Edit file `esp32.ino`:

```cpp
// Ganti dengan WiFi kamu
const char* ssid     = "NamaWiFiKamu";
const char* password = "PasswordWiFi";

// Ganti dengan URL API kamu
const char* dataUrl  = "https://domainmu.com/api.php";

// Ganti IP sesuai network kamu (optional)
IPAddress local_IP(192, 168, 1, 100);  // Sesuaikan!
IPAddress gateway(192, 168, 1, 1);     // Router kamu
```

### 3️⃣ UPLOAD KE ESP32

1. Buka Arduino IDE
2. Install library yang diperlukan:
   - WiFi (built-in)
   - HTTPClient (built-in)
   - ArduinoJson (install via Library Manager)
   - WebServer (built-in)
3. Select Board: **ESP32 Dev Module**
4. Select Port: **(COM port ESP32 kamu)**
5. Upload!

---

## 📊 DATA FLOW DIAGRAM

```
┌─────────────────────────────────────────────────────────┐
│ 1. USER EDIT JADWAL DI WEB (index.php)                 │
│    - Update schedule HST 1: 06:00 (5 menit)            │
│    - Klik "Simpan Jadwal"                              │
└─────────────────┬───────────────────────────────────────┘
                  │
                  ▼
┌─────────────────────────────────────────────────────────┐
│ 2. PHP SAVE TO data.json                                │
│    {                                                     │
│      "hst_aktif": 1,                                    │
│      "hst": [                                           │
│        [],                                              │
│        [{"jam":"06:00", "durasi":5}]                   │
│      ]                                                  │
│    }                                                    │
└─────────────────┬───────────────────────────────────────┘
                  │
                  ▼
┌─────────────────────────────────────────────────────────┐
│ 3. ESP32 FETCH via api.php                             │
│    GET https://domainmu.com/api.php                     │
└─────────────────┬───────────────────────────────────────┘
                  │
                  ▼
┌─────────────────────────────────────────────────────────┐
│ 4. ESP32 PARSE & STORE                                  │
│    - HST aktif: 1                                       │
│    - Jadwal: 06:00 (5 menit)                           │
│    - Save to LittleFS (/schedule.json)                 │
└─────────────────┬───────────────────────────────────────┘
                  │
                  ▼
┌─────────────────────────────────────────────────────────┐
│ 5. ESP32 JALANKAN JADWAL                                │
│    [06:00] POMPA ON → 5 menit → POMPA OFF             │
└─────────────────────────────────────────────────────────┘
```

---

## 🔍 TESTING CHECKLIST

### ✅ Test 1: Koneksi WiFi
1. Upload code ke ESP32
2. Buka Serial Monitor (115200 baud)
3. Lihat log:
   ```
   [WIFI] ✓ WiFi Connected: 192.168.*.*
   ```

### ✅ Test 2: Cloud Sync
Lihat log:
```
[SYNC] Syncing from Cloud...
[SYNC] HST from Cloud: 1
[SCHEDULE]   + 13:08 (1m)
[SCHEDULE]   + 13:12 (1m)
[SYNC] ✓ Cloud Sync SUCCESS
```

### ✅ Test 3: Dashboard ESP32
1. Buka browser
2. Akses: `http://192.168.1.100` (sesuaikan IP)
3. Lihat status real-time

### ✅ Test 4: Manual Control
1. Di dashboard ESP32, klik "NYALAKAN POMPA"
2. Pompa harus ON
3. Auto-off setelah 30 menit (atau sesuai setting)

### ✅ Test 5: Scheduled Irrigation
1. Set jadwal di website: misalnya 14:00 (1 menit)
2. Tunggu jam 14:00
3. ESP32 otomatis jalankan pompa 1 menit
4. Lihat log:
   ```
   [PUMP] POMPA ON (Scheduled): 1 menit
   [PUMP] POMPA OFF
   ```

### ✅ Test 6: Restart Behavior
1. Cabut power ESP32
2. Colok kembali
3. Lihat log - harus fetch cloud dulu:
   ```
   [SYSTEM] PRIORITY: Fetching from Cloud...
   [SYNC] ✓ Cloud Sync SUCCESS
   ```

---

## 🐛 TROUBLESHOOTING

### Problem: "WiFi FAILED"
**Solusi:**
- Cek SSID dan password
- Cek sinyal WiFi di lokasi ESP32
- Pastikan router tidak blokir MAC address ESP32

### Problem: "Cloud Sync Failed: HTTP -1"
**Solusi:**
- Cek URL api.php benar
- Pastikan server support HTTPS
- Test URL di browser dulu: `https://domainmu.com/api.php`
- Harus return JSON valid

### Problem: "JSON Parse Gagal"
**Solusi:**
- Test JSON di https://jsonlint.com
- Pastikan `data.json` ter-generate dengan benar
- Cek file `api.php` sudah di-upload

### Problem: "No schedule for HST X"
**Solusi:**
- HST di ESP32 mungkin berbeda dengan web
- Cek field `hst_aktif` di JSON
- Manual sync: klik "SYNC CLOUD" di dashboard ESP32

### Problem: Pompa tidak ON otomatis
**Solusi:**
- Cek waktu ESP32: harus sync NTP dulu
- Pastikan jadwal sudah tersimpan (lihat dashboard)
- Format jam harus "HH:MM" (contoh: "06:00", bukan "6:0")

---

## 📡 API REFERENCE

### GET /api.php

**Response:**
```json
{
    "tanggal_mulai": "2026-02-11",
    "hst_mulai": 1,
    "hst_max": 69,
    "pompa_status": "OFF",
    "pompa_manual_timer": 30,
    "hst": [
        [],
        [
            {"jam": "06:00", "durasi": 5},
            {"jam": "12:00", "durasi": 7}
        ]
    ],
    "hst_aktif": 1,
    "parameter_lock": false,
    "manual_pump_count": 0
}
```

**Fields:**
- `hst_aktif` (int): HST saat ini (dihitung dari tanggal_mulai)
- `hst` (array): Array jadwal per HST, index 0 = HST 0, dst
- `pompa_manual_timer` (int): Max durasi pompa manual (menit)
- `parameter_lock` (bool): Status lock parameter

---

## 🔐 SECURITY NOTES

1. **HTTPS Required**: Pastikan server pakai HTTPS (SSL certificate)
2. **IP Whitelist (Optional)**: Bisa tambahkan IP ESP32 ke whitelist
3. **API Key (Future)**: Bisa tambahkan authentication header

---

## 📊 MONITORING

### Web Dashboard
- URL: `https://domainmu.com/index.php`
- Fitur: Edit jadwal, lihat logs, kontrol pompa remote

### ESP32 Dashboard
- URL: `http://192.168.*.*` (local network)
- Fitur: Status real-time, manual control, sync trigger

### Serial Monitor
- Baud: 115200
- Fitur: Detail logs, debugging

---

## 🎯 NEXT STEPS

1. ✅ Test semua checklist di atas
2. 🔄 Biarkan run 24 jam, monitor stability
3. 📱 (Optional) Setup Telegram notification
4. 📊 (Optional) Export data ke Excel/PDF
5. 📸 (Optional) Tambahkan camera module

---

## 📞 SUPPORT

Jika ada masalah:
1. Copy semua log dari Serial Monitor
2. Screenshot dashboard (web + ESP32)
3. Check `data.json` content
4. Hubungi saya.

**Happy Growing! 🌱**

