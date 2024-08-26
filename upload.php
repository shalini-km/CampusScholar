<?php
// MySQL connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uni";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// File upload handling
if(isset($_POST['submit'])){
    $files = $_FILES['file'];

    foreach($files['tmp_name'] as $key => $tmp_name){
        $file_name = $files['name'][$key];
        $file_type = $files['type'][$key];
        $file_data = file_get_contents($tmp_name);
        
        $stmt = $conn->prepare("INSERT INTO certificate_student (file_name, file_type, file_data) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $file_name, $file_type, $file_data);
        $stmt->execute();
        $stmt->close();
    }

    echo "Files uploaded successfully.";
}

$conn->close();
?>
