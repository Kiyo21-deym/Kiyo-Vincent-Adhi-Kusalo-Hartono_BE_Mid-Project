# Sistem Manajemen Perpustakaan

## 📚 Informasi Pribadi

**Nama    :** Kiyo Vincent Adhi Kusalo Hartono
**NIM     :** 2902574990
**Jurusan :** Computer Science

---

## 📖 Deskripsi Project

Sistem Manajemen Perpustakaan berbasis web menggunakan **Laravel 11** untuk mengelola data buku, kategori, anggota, dan transaksi peminjaman. Project ini dibuat sebagai Mid Project untuk mata kuliah Back-End Development.

---

## ✨ Fitur Utama

- ✅ **Authentication** - Login & Register
- ✅ **CRUD Kategori Buku** - Kelola kategori buku
- ✅ **CRUD Buku** - Dengan upload cover image
- ✅ **CRUD Anggota** - Auto-generate kode anggota
- ✅ **Manajemen Peminjaman** - Peminjaman multi-buku
- ✅ **Pengembalian Buku** - Update stok otomatis
- ✅ **Dashboard** - Statistik real-time
- ✅ **Filter & Search** - Pencarian buku
- ✅ **Validasi Form** - Form validation
- ✅ **Relational Database** - One-to-Many, Many-to-Many

---

## 🛠️ Teknologi

- **Framework:** Laravel 11
- **Database:** MySQL
- **Frontend:** Bootstrap 5
- **PHP Version:** 8.2+
- **Node.js:** 18+

---

## 📦 Cara Instalasi

### 1️⃣ Clone Repository
```bash
git clone https://github.com/username/library-manager.git
cd library-manager
```

### 2️⃣ Install Dependencies
```bash
composer install
npm install
```

### 3️⃣ Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4️⃣ Konfigurasi Database

Edit file `.env`:
```env
DB_DATABASE=librarymanager
DB_USERNAME=root
DB_PASSWORD=
```

Buat database di MySQL:
```sql
CREATE DATABASE librarymanager;
```

### 5️⃣ Migrasi & Seeder
```bash
php artisan migrate --seed
```

### 6️⃣ Link Storage
```bash
php artisan storage:link
```

### 7️⃣ Compile Assets
```bash
npm run build
```

### 8️⃣ Jalankan Server
```bash
php artisan serve
```

Akses aplikasi di: **http://localhost:8000**

---

## 👤 Default Login

Setelah seeding, login dengan:

- **Email:** admin@library.com
- **Password:** password

---

## 🗄️ Database Schema

### **Tables:**

#### 1. categories
- id
- name
- description
- timestamps

#### 2. books
- id
- category_id (FK)
- title
- author
- isbn (unique)
- publisher
- publication_year
- stock
- cover_image
- description
- timestamps

#### 3. members
- id
- member_code (unique)
- name
- email (unique)
- phone
- address
- join_date
- timestamps

#### 4. borrowings
- id
- member_id (FK)
- borrow_date
- return_date
- status (borrowed/returned)
- timestamps

#### 5. borrowing_details
- id
- borrowing_id (FK)
- book_id (FK)
- quantity
- timestamps

#### 6. users
- id
- name
- email (unique)
- password
- timestamps

---

## 📸 Screenshot

*(Opsional: tambahkan screenshot aplikasi)*

---

## 👥 Kontribusi Anggota

- **Member 1:** Database design, Models, Migration, Seeder
- **Member 2:** Controllers, Views (Categories, Books)
- **Member 3:** Views (Members, Borrowings), Authentication, Styling

---

## 📝 Lisensi

MIT License

---

## 📞 Contact

Jika ada pertanyaan, hubungi:
- Email: [email@anda.com]
- GitHub: [@username](https://github.com/username)

---

**BNCC - Back-End Development Mid Project 2026**

#VIVABNCC 🚀