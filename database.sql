# MySQL Database Migration for CONQ

Salin dan jalankan perintah SQL berikut di dalam **phpMyAdmin** (tab SQL) atau tool database client lainnya.

## 1. Setup Database
Membuat database baru jika belum ada dan menggunakannya.

```sql
CREATE DATABASE IF NOT EXISTS db_conq;
USE db_conq;
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

-- Insert Dummy Conversation untuk user tersebut
-- Pastikan ID user sesuai (biasanya 1 jika database baru)
INSERT INTO conversations (id, user_id, title, agent_id)
VALUES 
('chat_123456789', 1, 'Belajar MySQL Dasar', 'thinking_ai');
```