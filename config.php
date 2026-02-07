<?php
unset($CFG);
global $CFG;
$CFG = new stdClass();

// Database configuration - Using PostgreSQL 18
$CFG->dbtype    = 'pgsql';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'moodle';
$CFG->dbuser    = 'postgres';
$CFG->dbpass    = 'moodle123';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = [
    'dbpersist' => 0,
    'dbport' => '5432',
];

// Web address
$CFG->wwwroot   = 'http://localhost:8000';

// Data directory (needs to be created and writable)
$CFG->dataroot  = __DIR__ . '/moodledata';

// Router configuration
$CFG->routerconfigured = false;

// Directory permissions
$CFG->directorypermissions = 02777;

// Admin directory
$CFG->admin = 'admin';

// Email configuration - Hostinger SMTP
$CFG->smtphosts = 'smtp.hostinger.com:587';
$CFG->smtpsecure = 'tls';
$CFG->smtpuser = 'info@mpanges.com';
$CFG->smtppass = 'Said@1697';
$CFG->noreplyaddress = 'info@mpanges.com';  // Use actual email account
$CFG->smtpmaxbulk = 1;

// Fix SSL certificate path issue
ini_set('openssl.cafile', 'C:/xampp/apache/bin/curl-ca-bundle.crt');
ini_set('curl.cainfo', 'C:/xampp/apache/bin/curl-ca-bundle.crt');

// Alternative: Use Gmail if Hostinger doesn't work
// $CFG->smtphosts = 'smtp.gmail.com:587';
// $CFG->smtpsecure = 'tls';
// $CFG->smtpuser = 'your-gmail@gmail.com';
// $CFG->smtppass = 'your-app-password';

$CFG->debug = 0; // Disable debug
$CFG->debugdisplay = 0;

require_once(__DIR__ . '/lib/setup.php');
