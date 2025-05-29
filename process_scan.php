<?php

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php'; // Composer autoloader

use Dotenv\Dotenv;

// Load .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Get API key from .env
$apiKey = $_ENV['VIRUSTOTAL_API_KEY'];

// Check if the API key is set
if (!isset($apiKey)) {
    die('API key is not set in the .env file!');
}

// Set header to JSON
header('Content-Type: application/json');

// Check if URL is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
    $url = $_POST['url'];
    
    // Validate URL
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        echo json_encode(['error' => 'Invalid URL format. Please enter a valid URL.']);
        exit;
    }
    
    try {
        // Step 1: Get URL ID by submitting the URL
        $urlId = urlScan($url, $apiKey);
        
        // Step 2: Get analysis report using the URL ID
        $analysisData = getAnalysisReport($urlId, $apiKey);
        
        // Return the result
        echo json_encode($analysisData);
        
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'No URL provided. Please enter a URL to scan.']);
}

/**
 * Submit URL for scanning to VirusTotal API
 * 
 * @param string $url The URL to scan
 * @param string $apiKey VirusTotal API key
 * @return string The URL ID for report retrieval
 */
function urlScan($url, $apiKey) {
    // Initialize cURL
    $ch = curl_init();
    
    // URL'yi Base64 URL formatında kodla
    $encodedUrl = base64UrlEncode($url);

    // Set cURL options for URL submission
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://www.virustotal.com/api/v3/urls',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'x-apikey: ' . $apiKey,
            'Content-Type: application/x-www-form-urlencoded'
        ],
        CURLOPT_POSTFIELDS => 'url=' . urlencode($encodedUrl) // Base64 URL formatında kodlanmış URL
    ]);
    
    // Execute cURL request
    $response = curl_exec($ch);
    
    // Check for errors
    if (curl_errno($ch)) {
        throw new Exception('cURL Error: ' . curl_error($ch));
    }
    
    // Check if response is empty or invalid
    if (empty($response)) {
        throw new Exception('No response from VirusTotal API.');
    }
    
    // Close cURL connection
    curl_close($ch);
    
    // Parse response
    $responseData = json_decode($response, true);
    
    // Check if response is valid
    if (!isset($responseData['data']['id'])) {
        throw new Exception('Failed to submit URL for scanning. Please try again later.');
    }
    
    $analysisId = $responseData['data']['id'];
    
    $urlId = substr($analysisId, 2); // Remove "u-" prefix
    $urlId = substr($urlId, 0, strpos($urlId, '-')); // Get everything before the timestamp
    
    return $urlId;
}

/**
 * 
 * @param string $urlId The URL ID to get report for
 * @param string $apiKey VirusTotal API key
 * @return array The analysis data
 */
function getAnalysisReport($urlId, $apiKey) {
    // Initialize cURL
    $ch = curl_init();
    
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://www.virustotal.com/api/v3/urls/' . $urlId,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'x-apikey: ' . $apiKey
        ]
    ]);
    
    // Execute cURL request
    $response = curl_exec($ch);
    
    // Check for errors
    if (curl_errno($ch)) {
        throw new Exception('cURL Error: ' . curl_error($ch));
    }
    
    if (empty($response)) {
        throw new Exception('No response from VirusTotal API.');
    }
    
    curl_close($ch);
    
    $responseData = json_decode($response, true);
    
    if (!isset($responseData['data']) || !isset($responseData['data']['attributes'])) {
        throw new Exception('Failed to retrieve analysis results. Please try again later.');
    }
    
    return $responseData;
}

/**
 * 
 * @param string 
 * @return string 
 */
function base64UrlEncode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
