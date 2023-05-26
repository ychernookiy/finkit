<?php

$servername = "localhost";
$username = "u0661739_urauser";
$password = "nH7yS7jW5yhX5fI0";
$dbname = "u0661739_ura";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $user = $result->fetch_assoc();
  if (password_verify($password, $user['password'])) {
    session_start();
    $_SESSION['user_id'] = $user['id'];
    echo json_encode(['success' => true, 'user' => $user]);
  } else {
    echo json_encode(['error' => 'Invalid password']);
  }
} else {
  echo json_encode(['error' => 'User not found']);
}

$stmt->close();
$conn->close();
?>