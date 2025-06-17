<?php
session_start();

// Example login check (replace with real logic)
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Example mock data
$lastConnected = date("Y-m-d H:i:s");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Health Doctor</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Your CSS here (from your file, omitted for brevity) -->
    <style>
        /* ... Paste your CSS from paste.txt here ... */

         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .main-content {
            padding: 40px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
        }

        .card-title i {
            font-size: 1.5rem;
            color: #4CAF50;
        }

        video, canvas {
            width: 100%;
            border-radius: 12px;
            margin-bottom: 15px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .map-container {
            height: 300px;
            border-radius: 12px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            border: 2px dashed #ddd;
            position: relative;
            overflow: hidden;
        }

        .map-placeholder {
            text-align: center;
            color: #666;
        }

        #map {
            width: 100%;
            height: 100%;
            border-radius: 12px;
            background: linear-gradient(45deg, #e8f5e8, #c8e6c9);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #2e7d32;
            text-align: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-right: 10px;
            margin-bottom: 10px;
            text-decoration: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(76, 175, 80, 0.3);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #5a6268);
        }

        .btn-secondary:hover {
            box-shadow: 0 8px 24px rgba(108, 117, 125, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }

        .btn-danger:hover {
            box-shadow: 0 8px 24px rgba(220, 53, 69, 0.3);
        }

        .btn-submit {
            background: linear-gradient(135deg, #28a745, #218838);
            padding: 15px 30px;
            font-size: 1.1rem;
            width: 100%;
            margin-top: 20px;
        }

        .btn-submit:hover {
            box-shadow: 0 8px 24px rgba(40, 167, 69, 0.3);
        }

        .sensor-display {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-top: 15px;
        }

        .sensor-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .sensor-item:last-child {
            border-bottom: none;
        }

        .sensor-label {
            font-weight: 600;
            color: #555;
        }

        .sensor-value {
            font-family: 'Courier New', monospace;
            background: #e9ecef;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 0.9rem;
        }

        .diagnosis-panel {
            grid-column: 1 / -1;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-left: 5px solid #4CAF50;
        }

        .diagnosis-result {
            padding: 20px;
            border-radius: 12px;
            margin-top: 15px;
            display: none;
        }

        .diagnosis-healthy {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border-left: 5px solid #28a745;
        }

        .diagnosis-sick {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            border-left: 5px solid #dc3545;
        }

        .diagnosis-warning {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            border-left: 5px solid #ffc107;
        }

        .plant-info {
            margin-top: 15px;
            padding: 15px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .audio-controls {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .recording-indicator {
            display: none;
            align-items: center;
            gap: 8px;
            color: #dc3545;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .recording-indicator.active {
            display: flex;
        }

        .pulse {
            width: 10px;
            height: 10px;
            background: #dc3545;
            border-radius: 50%;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        audio {
            width: 100%;
            margin-top: 15px;
        }

        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .status-success {
            background: #d4edda;
            color: #155724;
        }

        .status-error {
            background: #f8d7da;
            color: #721c24;
        }

        .status-warning {
            background: #fff3cd;
            color: #856404;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .main-content {
                padding: 20px;
            }
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #4CAF50;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
 .refreshBtn {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 20px;
        }

        .refreshBtn:hover {
            background-color: #218838;
        }
        .captured-image {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 12px;
            margin-top: 10px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1><i class="fas fa-leaf"></i> Plant Health Doctor</h1>
        <p>AI-Powered Plant Disease Detection & Environmental Monitoring</p>
    </div>
    <div class="main-content">
        <form method="POST" id="plantHealthForm">
            <div class="grid">
                <!-- Camera Section -->
                <div class="card">
                    <div class="card-title">
                        <i class="fas fa-camera"></i>
                        Plant Image Capture
                    </div>
                    <video id="camera" autoplay playsinline></video>
                    <div class="status-indicator status-error" id="cameraStatus" style="display: none;">
                        <i class="fas fa-exclamation-circle"></i>
                        Camera access required
                    </div>
                    <img id="capturedImage" class="captured-image" style="display: none;" alt="Captured plant image">
                    <button type="button" class="btn" id="captureBtn">
                        <i class="fas fa-camera"></i> Capture Plant Image
                    </button>
                    <button type="button" class="btn btn-secondary" id="analyzeBtn" disabled>
                        <i class="fas fa-search"></i> Analyze Plant Health
                    </button>
                    <canvas id="snapshot" style="display:none;"></canvas>
                </div>
                <!-- GPS & Map Section -->
                <div class="card">
                    <div class="card-title">
                        <i class="fas fa-map-marker-alt"></i>
                        Location & Environmental Data
                    </div>
                    <div class="map-container">
                        <div class="map-placeholder" id="mapPlaceholder">
                            <i class="fas fa-map-marked-alt" style="font-size: 3rem; color: #ccc; margin-bottom: 10px;"></i>
                            <p>Click "Get Location" to show map</p>
                        </div>
                        <div id="map" style="display: none;"></div>
                    </div>
                    <button type="button" class="btn" id="locationBtn">
                        <i class="fas fa-crosshairs"></i> Get Current Location
                    </button>
                    <div class="sensor-display">
                        <div class="sensor-item">
                            <span class="sensor-label"><i class="fas fa-map-pin"></i> GPS Coordinates:</span>
                            <span class="sensor-value" id="gpsDisplay">Not available</span>
                        </div>
                        <div class="sensor-item">
                            <span class="sensor-label"><i class="fas fa-thermometer-half"></i> Temperature:</span>
                            <span class="sensor-value" id="tempDisplay">--°C</span>
                        </div>
                        <div class="sensor-item">
                            <span class="sensor-label"><i class="fas fa-eye"></i> Humidity:</span>
                            <span class="sensor-value" id="humidityDisplay">--%</span>
                        </div>
                    </div>
                </div>
                <!-- Audio Recording Section -->
                <div class="card">
                    <div class="card-title">
                        <i class="fas fa-microphone"></i>
                        Audio Notes
                    </div>
                    <div class="recording-indicator" id="recordingIndicator">
                        <div class="pulse"></div>
                        Recording in progress...
                    </div>
                    <div class="audio-controls">
                        <button type="button" class="btn" id="startRecordBtn">
                            <i class="fas fa-microphone"></i> Start Recording
                        </button>
                        <button type="button" class="btn btn-danger" id="stopRecordBtn" disabled>
                            <i class="fas fa-stop"></i> Stop Recording
                        </button>
                    </div>
                    <audio id="audioPreview" controls style="display: none;"></audio>
                </div>
                <!-- Accelerometer Section -->
                <div class="card">
                    <div class="card-title">
                        <i class="fas fa-mobile-alt"></i>
                        Device Motion Data
                    </div>
                    <div class="sensor-display">
                        <div class="sensor-item">
                            <span class="sensor-label"><i class="fas fa-arrows-alt"></i> X-Axis:</span>
                            <span class="sensor-value" id="accelX">0.00 m/s²</span>
                        </div>
                        <div class="sensor-item">
                            <span class="sensor-label"><i class="fas fa-arrows-alt-v"></i> Y-Axis:</span>
                            <span class="sensor-value" id="accelY">0.00 m/s²</span>
                        </div>
                        <div class="sensor-item">
                            <span class="sensor-label"><i class="fas fa-arrows-alt"></i> Z-Axis:</span>
                            <span class="sensor-value" id="accelZ">0.00 m/s²</span>
                        </div>
                        <div class="sensor-item">
                            <span class="sensor-label"><i class="fas fa-compass"></i> Movement:</span>
                            <span class="sensor-value" id="accelStatus">Stationary</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- You can add diagnosis/result panel here if needed -->
      <div class="plant analysis"></div>



        </form>

    </div>
    
    <button class="refreshBtn" onclick="location.reload()">Refresh Dashboard</button>
   <div style="text-align:center;">
         <a href="privacy.php">
             <button style=" margin-top: 10px; padding: 10px 15px; border: none; background-color:hsl(350, 100.00%, 50.00%); color: white; border-radius: 20px;">
                 Check Our Privacy Policy
             </button>
         </a>
     </div>
</div>
<script>
/* ========== Camera ========== */
let video = document.getElementById('camera');
let canvas = document.getElementById('snapshot');
let captureBtn = document.getElementById('captureBtn');
let analyzeBtn = document.getElementById('analyzeBtn');
let cameraStatus = document.getElementById('cameraStatus');
let capturedImage = document.getElementById('capturedImage');
let stream = null;

async function startCamera() {
    try {
        stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;
        cameraStatus.style.display = 'none';
        captureBtn.disabled = false;
    } catch (err) {
        cameraStatus.style.display = '';
        captureBtn.disabled = true;
    }
}
startCamera();

captureBtn.onclick = function() {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);
    let dataURL = canvas.toDataURL('image/png');
    capturedImage.src = dataURL;
    capturedImage.style.display = 'block';
    analyzeBtn.disabled = false;
};

analyzeBtn.onclick = function() {
    alert('Plant health analysis is not implemented in here yet.');


};

/* ========== Location & Map ========== */

    let locationBtn = document.getElementById('locationBtn');
    let gpsDisplay = document.getElementById('gpsDisplay');
    let mapPlaceholder = document.getElementById('mapPlaceholder');
    let mapDiv = document.getElementById('map');

    locationBtn.onclick = function() {
        if (!navigator.geolocation) {
            gpsDisplay.textContent = "Geolocation is not supported by your browser.";
            return;
        }

        gpsDisplay.textContent = "Getting your location...";

        navigator.geolocation.getCurrentPosition(function(pos) {
            let lat = pos.coords.latitude.toFixed(6);
            let lon = pos.coords.longitude.toFixed(6);

            gpsDisplay.textContent = `Latitude: ${lat}, Longitude: ${lon}`;

            mapPlaceholder.style.display = 'none';
            mapDiv.style.display = 'block';

            let bbox = [
                (Number(lon) - 0.005).toFixed(6),
                (Number(lat) - 0.005).toFixed(6),
                (Number(lon) + 0.005).toFixed(6),
                (Number(lat) + 0.005).toFixed(6)
            ];

            mapDiv.innerHTML = `
                <iframe width="100%" height="100%" frameborder="0" style="border:0"
                    src="https://www.openstreetmap.org/export/embed.html?bbox=${bbox[0]},${bbox[1]},${bbox[2]},${bbox[3]}&layer=mapnik&marker=${lat},${lon}" allowfullscreen>
                </iframe>
                <small>
                    <a href="https://www.openstreetmap.org/?mlat=${lat}&mlon=${lon}#map=15/${lat}/${lon}" target="_blank">
                        View Larger Map
                    </a>
                </small>`;
        }, function(err) {
            switch(err.code) {
                case err.PERMISSION_DENIED:
                    gpsDisplay.textContent = "Permission denied.";
                    break;
                case err.POSITION_UNAVAILABLE:
                    gpsDisplay.textContent = "Location unavailable.";
                    break;
                case err.TIMEOUT:
                    gpsDisplay.textContent = "Request timed out.";
                    break;
                default:
                    gpsDisplay.textContent = "An unknown error occurred.";
                    break;
            }
        });
    };



/* ========== Environmental Data ========== */
// Web APIs for temperature/humidity are not standard; use "--" as fallback
document.getElementById('tempDisplay').textContent = '--°C';
document.getElementById('humidityDisplay').textContent = '--%';

/* ========== Audio Recording ========== */
let startRecordBtn = document.getElementById('startRecordBtn');
let stopRecordBtn = document.getElementById('stopRecordBtn');
let audioPreview = document.getElementById('audioPreview');
let recordingIndicator = document.getElementById('recordingIndicator');
let mediaRecorder;
let audioChunks = [];

startRecordBtn.onclick = async function() {
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        alert('Audio recording not supported');
        return;
    }
    try {
        let stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        mediaRecorder = new MediaRecorder(stream);
        audioChunks = [];
        mediaRecorder.ondataavailable = e => audioChunks.push(e.data);
        mediaRecorder.onstop = e => {
            let blob = new Blob(audioChunks, { type: 'audio/webm' });
            audioPreview.src = URL.createObjectURL(blob);
            audioPreview.style.display = 'block';
        };
        mediaRecorder.start();
        startRecordBtn.disabled = true;
        stopRecordBtn.disabled = false;
        recordingIndicator.classList.add('active');
    } catch (err) {
        alert('Microphone access denied.');
    }
};

stopRecordBtn.onclick = function() {
    if (mediaRecorder && mediaRecorder.state !== 'inactive') {
        mediaRecorder.stop();
        startRecordBtn.disabled = false;
        stopRecordBtn.disabled = true;
        recordingIndicator.classList.remove('active');
    }
};

/* ========== Accelerometer ========== */
let accelX = document.getElementById('accelX');
let accelY = document.getElementById('accelY');
let accelZ = document.getElementById('accelZ');
let accelStatus = document.getElementById('accelStatus');
if (window.DeviceMotionEvent) {
    window.addEventListener('devicemotion', function(event) {
        let x = event.accelerationIncludingGravity.x || 0;
        let y = event.accelerationIncludingGravity.y || 0;
        let z = event.accelerationIncludingGravity.z || 0;
        accelX.textContent = x.toFixed(2) + " m/s²";
        accelY.textContent = y.toFixed(2) + " m/s²";
        accelZ.textContent = z.toFixed(2) + " m/s²";
        let movement = (Math.abs(x) + Math.abs(y) + Math.abs(z)) > 2 ? 'Moving' : 'Stationary';
        accelStatus.textContent = movement;
    });
} else {
    accelX.textContent = accelY.textContent = accelZ.textContent = 'N/A';
    accelStatus.textContent = 'Not supported';
}
</script>
</body>
</html>
