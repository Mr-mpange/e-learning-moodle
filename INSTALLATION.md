# IAA Moodle Installation Guide

Complete step-by-step installation guide for the IAA E-Learning Platform.

## System Requirements

### Minimum Requirements
- **PHP**: 8.1 or higher
- **Database**: PostgreSQL 18+ OR MariaDB 10.11+
- **Web Server**: Apache 2.4+ / Nginx / PHP built-in server
- **RAM**: 512MB minimum (2GB+ recommended)
- **Disk Space**: 200MB for code + space for user data

### Required PHP Extensions
```
pgsql (or mysqli for MariaDB)
curl
zip
gd
mbstring
xml
intl
soap
opcache (recommended)
```

## Installation Steps

### Step 1: System Preparation

#### Windows (XAMPP)
1. Install XAMPP from https://www.apachefriends.org/
2. Install PostgreSQL from https://www.postgresql.org/download/
3. Start Apache and PostgreSQL services

#### Linux
```bash
# Ubuntu/Debian
sudo apt update
sudo apt install php8.1 php8.1-pgsql php8.1-curl php8.1-zip php8.1-gd \
                 php8.1-mbstring php8.1-xml php8.1-intl php8.1-soap \
                 postgresql composer nodejs npm

# Start PostgreSQL
sudo systemctl start postgresql
```

### Step 2: Clone Repository

```bash
git clone https://github.com/Mr-mpange/e-learning-moodle.git
cd e-learning-moodle
```

### Step 3: Install Dependencies

```bash
# PHP dependencies
composer install --no-dev --optimize-autoloader

# Frontend dependencies
npm install
```

### Step 4: Database Setup

#### PostgreSQL
```bash
# Login as postgres user
sudo -u postgres psql

# Create database and user
CREATE DATABASE moodle;
CREATE USER moodleuser WITH PASSWORD 'SecurePassword123!';
GRANT ALL PRIVILEGES ON DATABASE moodle TO moodleuser;
\q
```

#### MariaDB (Alternative)
```bash
mysql -u root -p

CREATE DATABASE moodle DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'moodleuser'@'localhost' IDENTIFIED BY 'SecurePassword123!';
GRANT ALL PRIVILEGES ON moodle.* TO 'moodleuser'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Step 5: Configure Moodle

```bash
# Copy sample config
cp config-sample.php config.php

# Edit config.php with your settings
nano config.php  # or use any text editor
```

**Update these values:**
- `$CFG->dbname` - Your database name
- `$CFG->dbuser` - Your database username
- `$CFG->dbpass` - Your database password
- `$CFG->wwwroot` - Your site URL
- Email settings (optional but recommended)

### Step 6: Create Data Directory

```bash
# Create directory
mkdir moodledata

# Set permissions
chmod 777 moodledata  # Linux/Mac
# Windows: Right-click → Properties → Security → Give full control
```

### Step 7: Start Web Server

#### Option A: PHP Built-in Server (Development)
```bash
php -S localhost:8000 -t public
```

#### Option B: Apache
```apache
# Add to Apache config or .htaccess
<VirtualHost *:80>
    DocumentRoot "/path/to/moodle/public"
    ServerName moodle.local
    
    <Directory "/path/to/moodle/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### Option C: Nginx
```nginx
server {
    listen 80;
    server_name moodle.local;
    root /path/to/moodle/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
    }
}
```

### Step 8: Web Installation

1. Open browser and navigate to your Moodle URL (e.g., http://localhost:8000)
2. Select language → Click "Next"
3. Confirm paths → Click "Next"
4. Choose database driver (PostgreSQL or MariaDB) → Click "Next"
5. Database settings (already configured) → Click "Next"
6. Accept license agreement → Click "Continue"
7. Wait for environment checks to pass
8. Click "Continue" to install database tables
9. Create admin account:
   - Username: admin
   - Password: (strong password)
   - Email: your-email@domain.com
   - First/Last name
10. Configure site settings:
    - Site name: IAA E-Learning Platform
    - Short name: IAA
    - Front page summary: (optional)
11. Click "Save changes"

## Post-Installation Configuration

### 1. Test Email Configuration

```bash
# Via CLI
php admin/cli/test_outgoing_mail_configuration.php

# Via Web
# Navigate to: Site administration → Server → Test outgoing mail configuration
```

### 2. Set Up Cron Job

#### Linux (crontab)
```bash
crontab -e
# Add this line:
*/5 * * * * php /path/to/moodle/admin/cli/cron.php
```

#### Windows (Task Scheduler)
1. Open Task Scheduler
2. Create Basic Task
3. Trigger: Daily, repeat every 5 minutes
4. Action: Start a program
5. Program: `C:\xampp\php\php.exe`
6. Arguments: `C:\path\to\moodle\admin\cli\cron.php`

### 3. Configure Backup

Site administration → Courses → Backups → Automated backup setup

### 4. Set Up User Roles

Site administration → Users → Permissions → Define roles

### 5. Configure Theme

Site administration → Appearance → Themes → Boost

## Troubleshooting

### Database Connection Error
```bash
# Check PostgreSQL is running
sudo systemctl status postgresql

# Test connection
psql -U moodleuser -d moodle -h localhost
```

### Permission Denied Errors
```bash
# Fix moodledata permissions
chmod -R 777 moodledata

# Fix file ownership (Linux)
sudo chown -R www-data:www-data moodledata
```

### Email Not Sending
1. Verify SMTP credentials in config.php
2. Check firewall allows outbound connections on port 587/465
3. Test with: Site administration → Server → Test outgoing mail configuration

### White Screen / 500 Error
```bash
# Enable debug mode in config.php
$CFG->debug = 32767;
$CFG->debugdisplay = 1;

# Check error logs
tail -f /var/log/apache2/error.log  # Linux
# or check moodledata/error.log
```

### Performance Issues
```bash
# Enable OPcache in php.ini
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=10000

# Purge Moodle caches
php admin/cli/purge_caches.php
```

## Security Checklist

- [ ] Change default admin password
- [ ] Disable debug mode in production
- [ ] Set proper file permissions (755 for directories, 644 for files)
- [ ] Enable HTTPS (SSL certificate)
- [ ] Configure firewall rules
- [ ] Regular backups scheduled
- [ ] Keep Moodle updated
- [ ] Use strong database passwords
- [ ] Restrict access to config.php

## Maintenance Commands

```bash
# Purge all caches
php admin/cli/purge_caches.php

# Run cron manually
php admin/cli/cron.php

# Check for updates
php admin/cli/upgrade.php

# Backup database
pg_dump moodle > backup_$(date +%Y%m%d).sql

# Restore database
psql moodle < backup_20240101.sql
```

## Getting Help

- **Moodle Docs**: https://docs.moodle.org/
- **Developer Docs**: https://moodledev.io
- **Community Forums**: https://moodle.org/community
- **IAA Support**: Contact your system administrator

## Next Steps

After installation:
1. Create courses
2. Add users (manual or bulk upload)
3. Assign roles
4. Configure plugins
5. Customize theme
6. Set up categories
7. Configure gradebook

Refer to `CUSTOMIZATION_GUIDE.md` for branding and customization options.
