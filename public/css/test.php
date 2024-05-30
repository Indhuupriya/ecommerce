// Amazon product URL
$url = 'https://www.amazon.com/product-url-here';

// Initialize cURL session
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36');

// Execute cURL session and store the response
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'cURL Error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Parse HTML response
$doc = new DOMDocument();
$doc->loadHTML($response);

// Extract product details using XPath
$xpath = new DOMXPath($doc);
$productName = $xpath->query('//span[@id="productTitle"]')->item(0)->textContent;
$productPrice = $xpath->query('//span[@id="priceblock_ourprice"]')->item(0)->textContent;

// Display product details
echo 'Product Name: ' . $productName . '<br>';
echo 'Product Price: ' . $productPrice;
