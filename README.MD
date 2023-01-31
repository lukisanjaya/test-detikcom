# Interview Test

Aplikasi untuk check status tiket dan update tiket, serta genereate tiket.

## Installation

Jika composer telah ter-install, ketik perintah dibawah ini :

```bash
composer dump-autoload
```

## Folder Logs
Buat folder `logs` di root project, jika ada error akan ke generate file log di folder tersebut.

## Database
Database yang digunakan yaitu MySQL, buat database dengan nama `tiket_test` atau sesuaikan dengan keinginan.

Setelah membuat database konfigurasi pengaturan database di `src/Config/DB.php`

```php
    private const DB_HOST = "localhost";
    private const DB_USER = "root";
    private const DB_PASS = "root";
    private const DB_NAME = "tiket_test";
```

## Database Migration & Dummy Data
Generate table dengan menjalankan perintah berikut :
```bash
php migration.php
```
Silahkan check database, jika telah ter-generate table users, events, dan tickets maka proses migrasi database telah berhasil.

## Generate Ticket
untuk men-generate ticket jalankan perintah berikut :
```bash
php ticket.php 1 300
```
Ganti angka 1 dengan EventID dan 300 sebagai Total Tiket yang ingin di generate.

Untuk mengetahui perintah program bisa jalankan :
```bash
php ticket.php -h
```

## Running Program
Untuk menjalankan aplikasi API ticket, jalankan perintah berikut pada terminal :
```bash
php -S localhost:8000 public/index.php
```
## Security
Untuk Api ticket ini diproteksi menggunakan `Basic Auth`, jadi tambahkan di header auth basic 

username : `admin`
password : `rahasia`

Contoh Pemanggilan API via curl

#### Get Status Ticket
```curl
curl -u "admin:rahasia" \
--location --request GET "http://localhost:8000/check-ticket?event_id=1&ticket_code=DTK9zKXCowpWx"
```

#### Update Status Ticket
```curl
curl -u "admin:rahasia" \
--location --request POST 'http://localhost:8000/update-ticket' \
--form 'event_id="1"' \
--form 'ticket_code="DTK9zKXCowpWx"' \
--form 'status="claimed"'
```
## Dokumentasi API
Untuk menjalankan testing API bisa via dokumentasi API (Swagger UI) bisa jalankan url ini di browser : [http://localhost:8000/doc](http://localhost:8000/doc)
