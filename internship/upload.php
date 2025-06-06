<?php
$conn = new mysqli("localhost", "root", "", "video_streaming");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $video = $_FILES['video'];

    if (!is_dir('uploads')) {
        mkdir('uploads', 0755, true);
    }

    $fileName = basename($video["name"]);
    $targetPath = "uploads/" . time() . "_" . $fileName;
    $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));

    $allowed = ['mp4', 'webm', 'ogg'];
    if (!in_array($fileType, $allowed)) {
        echo "❌ Only MP4, WebM, or OGG videos are allowed.";
        exit;
    }

    if (move_uploaded_file($video["tmp_name"], $targetPath)) {
        $stmt = $conn->prepare("INSERT INTO videos (title, filepath) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $targetPath);
        $stmt->execute();
        echo "✅ Video uploaded successfully! <a href='watch.php?id={$conn->insert_id}'>Watch Now</a>";
    } else {
        echo "❌ Failed to upload video.";
    }
}
?>
