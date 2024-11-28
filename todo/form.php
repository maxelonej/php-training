<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $task = $_POST['task'] ?? '';
  require_once("validation.php");
  // validation.php ($task)
  $validTask = trim($task);

  if ($validTask) {
    if (!isset($_SESSION['tasks'])) {
      $_SESSION['tasks'] = [];
    }

    $_SESSION['tasks'][] = [
      'name' => $validTask
    ];

    header("Location: index.php");
    exit;
  } else {
    // valid error msg
  }
}

if (isset($_POST['delete_task_id'])) {
  $taskId = (int) $_POST['delete_task_id'];
  if (isset($_SESSION['tasks'][$taskId])) {
    unset($_SESSION['tasks'][$taskId]);
    $_SESSION['tasks'] = array_values($_SESSION['tasks']);
    echo json_encode(['success' => true]);
    exit;
  }
}

?>