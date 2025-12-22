# MySQL Database Migration for CONQ

Salin dan jalankan perintah SQL berikut di dalam **phpMyAdmin** (tab SQL) atau tool database client lainnya.

## 1. Setup Database
Membuat database baru jika belum ada dan menggunakannya.

```sql
CREATE DATABASE IF NOT EXISTS `laravel-conq`;
USE `laravel-conq`;
```

## 2. Tabel Users
Menyimpan data pengguna, kredensial login, dan saldo kredit.

```sql
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    plan ENUM('Free', 'Pro', 'Enterprise') DEFAULT 'Free',
    credits INT DEFAULT 100,
    avatar VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## 3. Tabel Conversations (History Chat)
Menyimpan riwayat sesi percakapan untuk Sidebar.

```sql
CREATE TABLE IF NOT EXISTS conversations (
    id VARCHAR(255) PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    agent_id VARCHAR(50) NOT NULL,
    messages JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## 4. Tabel Messages (Detail Pesan Individual)
Menyimpan setiap pesan secara individual untuk granular control.

```sql
CREATE TABLE IF NOT EXISTS messages (
    id VARCHAR(255) PRIMARY KEY,
    conversation_id VARCHAR(255) NOT NULL,
    role ENUM('user', 'model') NOT NULL,
    content TEXT NOT NULL,
    timestamp BIGINT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (conversation_id) REFERENCES conversations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## 5. Tabel Migrations (Laravel System)
Menyimpan riwayat migrasi database Laravel.

```sql
CREATE TABLE IF NOT EXISTS migrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    batch INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## 6. Indexes untuk Optimasi
Menambahkan index untuk performa query.

```sql
-- Index untuk conversations
CREATE INDEX idx_conversations_user_id ON conversations(user_id);
CREATE INDEX idx_conversations_agent_id ON conversations(agent_id);

-- Index untuk messages
CREATE INDEX idx_messages_conversation_id ON messages(conversation_id);
CREATE INDEX idx_messages_role ON messages(role);
CREATE INDEX idx_messages_timestamp ON messages(timestamp);
```

## 7. Insert Data Awal (Opsional)
Data awal untuk testing.

```sql
-- Insert user demo (password: password)
INSERT INTO users (name, email, password, plan, credits) VALUES 
('Demo User', 'demo@conq.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Free', 100)
ON DUPLICATE KEY UPDATE name = VALUES(name);
```

## Catatan:
- Database name: `laravel-conq` (sesuai dengan .env configuration)
- Conversations menggunakan UUID sebagai primary key
- Messages tersimpan dalam 2 format: JSON (di conversations) dan individual (di messages)
- Semua foreign key memiliki ON DELETE CASCADE untuk data consistency
- Timestamp menggunakan format Unix (bigint) untuk messages dan MySQL timestamp untuk created_at
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    agent_id VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_conversations_user 
        FOREIGN KEY (user_id) REFERENCES users(id) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## 4. Tabel Messages (Opsional)
Menyimpan detail isi pesan per percakapan (jika ingin menyimpan isi chat penuh di database, bukan hanya local storage).

```sql
CREATE TABLE IF NOT EXISTS messages (
    id VARCHAR(255) PRIMARY KEY,
    conversation_id VARCHAR(255) NOT NULL,
    role ENUM('user', 'model') NOT NULL,
    content TEXT NOT NULL,
    timestamp BIGINT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_messages_conversation 
        FOREIGN KEY (conversation_id) REFERENCES conversations(id) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## 5. (Opsional) Data Dummy untuk Testing
Jika Anda ingin langsung mencoba dengan data awal tanpa register manual.

```sql
-- Insert Dummy User (Password: 'password123')
INSERT INTO users (name, email, password, plan, credits) 
VALUES 
('Demo User', 'demo@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Free', 100);
```