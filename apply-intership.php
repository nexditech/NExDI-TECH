<?php
// DB connection
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "nexdi_hub";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data
$name = $_POST['name'];
$email = $_POST['email'];
$motivation = $_POST['motivation'];
$track = "internship"; // fixed track

// File upload
$targetDir = "uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}
$cvName = basename($_FILES["cv"]["name"]);
$targetFile = $targetDir . time() . "_" . $cvName;

if (move_uploaded_file($_FILES["cv"]["tmp_name"], $targetFile)) {
    $stmt = $conn->prepare("INSERT INTO internship_applications (name, email, track, cv, motivation) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $track, $targetFile, $motivation);

    if ($stmt->execute()) {
        echo "<h2>✅ Internship Application Submitted!</h2>";
        echo "<p>Thank you, $name. Our team will review your application and contact you soon.</p>";
    } else {
        echo "❌ Database error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "❌ Error uploading CV.";
}

$conn->close();
?>