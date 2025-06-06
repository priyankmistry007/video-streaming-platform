
<?php
$conn = new mysqli("localhost", "root", "", "video_streaming");

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM videos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$video = $result->fetch_assoc();

if (!$video) {
    die("❌ Video not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($video['title']); ?></title>
</head>
<body>
  <h1><?php echo htmlspecialchars($video['title']); ?></h1>
  <video controls width="100%" height="400">
    <source src="<?php echo htmlspecialchars($video['filepath']); ?>" type="video/mp4">
    Your browser does not support the video tag.
  </video>
</body>
</html>

