# IAA Moodle E-Learning Platform

Institute of Aeronautical Engineering (IAA) Learning Management System built on Moodle.

## Prerequisites

Before installation, ensure you have:

- **PHP 8.1+** with required extensions:
  - pgsql, curl, zip, gd, mbstring, xml, intl, soap
- **PostgreSQL 18+** (or MariaDB 10.11+)
- **Web Server** (Apache/Nginx or PHP built-in server)
- **Composer** (for PHP dependencies)
- **Node.js & npm** (for frontend assets)

## Quick Start

### 1. Clone Repository
```bash
git clone https://github.com/Mr-mpange/e-learning-moodle.git
cd e-learning-moodle
```

### 2. Install Dependencies
```bash
composer install --no-dev
npm install
```

### 3. Database Setup

**PostgreSQL:**
```sql
CREATE DATABASE moodle;
CREATE USER moodleuser WITH PASSWORD 'your_password';
GRANT ALL PRIVILEGES ON DATABASE moodle TO moodleuser;
```

### 4. Configure Moodle

Create `config.php` in the root directory:

```php
<?php
unset($CFG);
global $CFG;
$CFG = new stdClass();

// Database
$CFG->dbtype    = 'pgsql';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'moodle';
$CFG->dbuser    = 'moodleuser';
$CFG->dbpass    = 'your_password';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = [
    'dbpersist' => 0,
    'dbport' => '5432',
];

// Web address
$CFG->wwwroot   = 'http://localhost:8000';

// Data directory (must be writable)
$CFG->dataroot  = __DIR__ . '/moodledata';

// Email configuration (optional)
$CFG->smtphosts = 'smtp.your-provider.com:587';
$CFG->smtpsecure = 'tls';
$CFG->smtpuser = 'your-email@domain.com';
$CFG->smtppass = 'your-password';
$CFG->noreplyaddress = 'your-email@domain.com';

$CFG->admin = 'admin';
$CFG->directorypermissions = 02777;

require_once(__DIR__ . '/lib/setup.php');
```

### 5. Create Data Directory
```bash
mkdir moodledata
chmod 777 moodledata
```

### 6. Run Installation

**Option A: PHP Built-in Server**
```bash
php -S localhost:8000 -t public
```

**Option B: Apache/Nginx**
Point document root to `public/` directory

### 7. Complete Web Installation

Visit `http://localhost:8000` and follow the installation wizard:
1. Choose language
2. Confirm paths
3. Database setup (already configured)
4. License agreement
5. Environment checks
6. Create admin account

## Post-Installation

### Admin Access
- URL: `http://localhost:8000/admin`
- Default username: admin
- Password: (set during installation)

### Essential Configuration

1. **Site Settings**: Site administration → Appearance → Themes
2. **User Roles**: Site administration → Users → Permissions
3. **Email Settings**: Site administration → Server → Email
4. **Backup Settings**: Site administration → Courses → Backups

### Test Email Configuration
```bash
php admin/cli/test_outgoing_mail_configuration.php
```

## User Roles

- **Manager**: Full site administration
- **Course Creator**: Create and manage courses
- **Teacher**: Full course control
- **Non-editing Teacher**: View and grade
- **Student**: Course participant
- **Guest**: Limited read-only access

## Maintenance

### Purge Caches
```bash
php admin/cli/purge_caches.php
```

### Run Cron
```bash
php admin/cli/cron.php
```

### Backup Database
```bash
pg_dump moodle > backup_$(date +%Y%m%d).sql
```

## Troubleshooting

### Email Not Working
- Check SMTP credentials in `config.php`
- Verify firewall allows port 587/465
- Test: Site administration → Server → Test outgoing mail configuration

### Database Connection Failed
- Verify PostgreSQL is running
- Check credentials in `config.php`
- Ensure database exists

### Permission Errors
```bash
chmod -R 777 moodledata
```

## Development

### Enable Debug Mode
Add to `config.php`:
```php
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
```

### Build Frontend Assets
```bash
npm run build
```

## Support

- **Moodle Documentation**: https://docs.moodle.org/
- **Developer Docs**: https://moodledev.io
- **Community Forums**: https://moodle.org/community

## License

Moodle is provided freely as open source software under the GNU General Public License v3.0.

## Project Information

- **Institution**: Institute of Aeronautical Engineering (IAA)
- **Repository**: https://github.com/Mr-mpange/e-learning-moodle
- **Moodle Version**: Latest stable release
