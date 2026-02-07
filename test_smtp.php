<?php
// Test SMTP connection
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Testing SMTP Connection to Hostinger...\n\n";

// SMTP settings
$smtp_host = 'smtp.hostinger.com';
$smtp_port = 587;
$smtp_user = 'info@mpanges.com';
$smtp_pass = 'Said@1697';

echo "Host: $smtp_host\n";
echo "Port: $smtp_port\n";
echo "User: $smtp_user\n\n";

// Test 1: Check if we can connect
echo "Test 1: Checking connection...\n";
$socket = @fsockopen($smtp_host, $smtp_port, $errno, $errstr, 30);
if ($socket) {
    echo "✓ Connection successful!\n";
    $response = fgets($socket, 515);
    echo "Server response: $response\n";
    fclose($socket);
} else {
    echo "✗ Connection failed: $errstr ($errno)\n";
    exit(1);
}

echo "\n";

// Test 2: Try with PHPMailer-like approach
echo "Test 2: Testing SMTP authentication...\n";

$socket = fsockopen($smtp_host, $smtp_port, $errno, $errstr, 30);
if (!$socket) {
    echo "✗ Cannot connect\n";
    exit(1);
}

// Read greeting
$response = fgets($socket, 515);
echo "Server: $response";

// Send EHLO
fputs($socket, "EHLO localhost\r\n");
$response = '';
while ($line = fgets($socket, 515)) {
    $response .= $line;
    if (substr($line, 3, 1) == ' ') break;
}
echo "EHLO response:\n$response\n";

// Start TLS
fputs($socket, "STARTTLS\r\n");
$response = fgets($socket, 515);
echo "STARTTLS: $response";

if (strpos($response, '220') === 0) {
    echo "✓ TLS available\n";
    
    // Enable crypto
    if (stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
        echo "✓ TLS enabled\n";
        
        // Send EHLO again after TLS
        fputs($socket, "EHLO localhost\r\n");
        $response = '';
        while ($line = fgets($socket, 515)) {
            $response .= $line;
            if (substr($line, 3, 1) == ' ') break;
        }
        
        // Try AUTH LOGIN
        fputs($socket, "AUTH LOGIN\r\n");
        $response = fgets($socket, 515);
        echo "AUTH LOGIN: $response";
        
        if (strpos($response, '334') === 0) {
            // Send username
            fputs($socket, base64_encode($smtp_user) . "\r\n");
            $response = fgets($socket, 515);
            echo "Username: $response";
            
            // Send password
            fputs($socket, base64_encode($smtp_pass) . "\r\n");
            $response = fgets($socket, 515);
            echo "Password: $response";
            
            if (strpos($response, '235') === 0) {
                echo "✓ Authentication successful!\n";
            } else {
                echo "✗ Authentication failed!\n";
            }
        }
    } else {
        echo "✗ TLS failed\n";
    }
} else {
    echo "✗ TLS not available\n";
}

fclose($socket);

echo "\n=== Test Complete ===\n";
