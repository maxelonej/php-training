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
      'name' => $validTask,
      'status' => 'Незавершенный'
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

if (isset($_POST['toggle_task_id'])) {
  $taskId = (int) $_POST['toggle_task_id'];
  if (isset($_SESSION['tasks'][$taskId])) {
    $currentStatus = $_SESSION['tasks'][$taskId]['status'];
    $newStatus = ($currentStatus === 'Незавершенный') ? 'Завершенный' : 'Незавершенный';

    $_SESSION['tasks'][$taskId]['status'] = $newStatus;

    echo json_encode(['success' => true, 'new_status' => $newStatus]);
    exit;
  }
}

?>