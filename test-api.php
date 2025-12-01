<?php
// Простой тест API через curl
echo "=== Тест API ===\n\n";

// 1. Тест без аутентификации
echo "1. Тест /api/test (без API ключа):\n";
$ch = curl_init('http://glu_v2.test/api/test');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
echo "Response:\n$response\n\n";

// 2. Тест с аутентификацией
echo "2. Тест /api/categories (с API ключом):\n";
$apiKey = 'ad064f1e19dec7de49426c54c16b439f38795d39cde1da15c848cd0442098dd7';

$ch = curl_init('http://glu_v2.test/api/categories');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'X-API-Key: ' . $apiKey,
    'Accept: application/json'
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
echo "Response:\n$response\n";
