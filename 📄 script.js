function classifyText() {
  const text = document.getElementById('userText').value.trim();
  const resultDiv = document.getElementById('result');
  const logDiv = document.getElementById('log');

  if (text === "") {
    alert("Please enter some text.");
    return;
  }

  // Simulated classifier result (randomized for demo)
  const confidence = Math.random(); // random confidence between 0 and 1
  const label = text.toLowerCase().includes("bad") || text.toLowerCase().includes("poor") ? "NEGATIVE" : "POSITIVE";

  logMessage(`Predicted: ${label} | Confidence: ${confidence.toFixed(2)}`);

  if (confidence >= 0.7) {
    resultDiv.innerHTML = `✅ Final Classification: <strong>${label}</strong>`;
    logMessage("Accepted classification.");
  } else {
    logMessage("Low confidence. Triggering fallback.");
    const fallback = confirm("System is unsure. Is this a NEGATIVE sentiment? Click OK for YES, Cancel for NO.");
    const fallbackLabel = fallback ? "NEGATIVE" : "POSITIVE";
    resultDiv.innerHTML = `📝 User Clarification: <strong>${fallbackLabel}</strong>`;
    logMessage(`User clarified: ${fallbackLabel}`);
  }
}

function logMessage(message) {
  const logDiv = document.getElementById('log');
  const timestamp = new Date().toLocaleString();
  logDiv.innerHTML += `[${timestamp}] ${message}<br>`;
  console.log(`[${timestamp}] ${message}`);
}
