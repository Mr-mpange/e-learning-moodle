<?php
/**
 * Moodle Configuration File - Sample
 * 
 * Copy this file to config.php and update with your settings
 */

unset($CFG);
global $CFG;
$CFG = new stdClass();

// ============================================
// DATABASE CONFIGURATION
// ============================================

// Database type: 'pgsql' (PostgreSQL) or 'mariadb' (MariaDB/MySQL)
$CFG->dbtype    = 'pgsql';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'moodle';
$CFG->dbuser    = 'moodleuser';
$CFG->dbpass    = 'your_database_password';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = [
    'dbpersist' => 0,
    'dbport' => '5432',  // 5432 for PostgreSQL, 3306 for MariaDB
];

// ============================================
// WEB ADDRESS
// ============================================

// Full URL to your Moodle installation
$CFG->wwwroot   = 'http://localhost:8000';

// ============================================
// DATA DIRECTORY
// ============================================

// Path to moodledata directory (must be writable)
$CFG->dataroot  = __DIR__ . '/moodledata';

// ============================================
// EMAIL CONFIGURATION (Optional)
// ============================================

// SMTP server settings
$CFG->smtphosts = 'smtp.your-provider.com:587';  // Port 587 for TLS, 465 for SSL
$CFG->smtpsecure = 'tls';  // 'tls' or 'ssl'
$CFG->smtpuser = 'your-email@domain.com';
$CFG->smtppass = 'your_email_password';
$CFG->noreplyaddress = 'your-email@domain.com';
$CFG->smtpmaxbulk = 1;

// SSL certificate path (Windows with XAMPP)
// ini_set('openssl.cafile', 'C:/xampp/apache/bin/curl-ca-bundle.crt');
// ini_set('curl.cainfo', 'C:/xampp/apache/bin/curl-ca-bundle.crt');

// ============================================
// SYSTEM SETTINGS
// ============================================

// Router configuration
$CFG->routerconfigured = false;

// Directory permissions
$CFG->directorypermissions = 02777;

// Admin directory
$CFG->admin = 'admin';

// ============================================
// DEBUG SETTINGS (Development only)
// ============================================

// Disable in production!
// $CFG->debug = 32767;  // Show all debug messages
// $CFG->debugdisplay = 1;  // Display errors on screen

// Production settings
$CFG->debug = 0;
$CFG->debugdisplay = 0;

// ============================================
// DO NOT MODIFY BELOW THIS LINE
// ============================================

require_once(__DIR__ . '/lib/setup.php');
