<?php
function logMessage($message) {
    $timestamp = date("Y-m-d H:i:s");
    file_put_contents("logs/execution_log.txt", "[$timestamp] $message\n", FILE_APPEND);
}

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $text = trim($_POST["text"]);

    if (empty($text)) {
        echo "<script>alert('Please enter text.'); window.history.back();</script>";
        exit();
    }

    // Simulated sentiment prediction
    $confidence = mt_rand(40, 100) / 100; // random 0.40 - 1.00
    $label = (stripos($text, "bad") !== false || stripos($text, "poor") !== false) ? "NEGATIVE" : "POSITIVE";

    logMessage("Predicted: $label | Confidence: " . number_format($confidence, 2));

    if ($confidence >= 0.7) {
        logMessage("Accepted classification.");
        $finalLabel = $label;
    } else {
        logMessage("Low confidence. Triggering fallback.");
        // Fallback via confirm popup simulation (in web, fallback through user confirmation page)
        echo "<script>
            var fallback = confirm('System is unsure. Is this a NEGATIVE sentiment? OK = Yes, Cancel = No.');
            if(fallback) {
                window.location.href = 'classify.php?fallback=NEGATIVE';
            } else {
                window.location.href = 'classify.php?fallback=POSITIVE';
            }
        </script>";
        exit();
    }

    // Show result page
    echo "<html><head><link rel='stylesheet' href='style.css'></head><body><div class='container'>";
    echo "<h1>Classification Result</h1>";
    echo "<div class='result'>✅ Final Classification: <strong>$finalLabel</strong></div>";
    echo "<a href='index.php'><button style='margin-top:15px;'>Classify Again</button></a>";
    echo "</div></body></html>";
}

// Handle fallback result
if (isset($_GET['fallback'])) {
    $fallbackLabel = $_GET['fallback'];
    logMessage("User clarified: $fallbackLabel");

    echo "<html><head><link rel='stylesheet' href='style.css'></head><body><div class='container'>";
    echo "<h1>Fallback Classification</h1>";
    echo "<div class='result'>📝 User Clarification: <strong>$fallbackLabel</strong></div>";
    echo "<a href='index.php'><button style='margin-top:15px;'>Classify Again</button></a>";
    echo "</div></body></html>";
}
?>
