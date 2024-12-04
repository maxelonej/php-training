<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <title>To-Do App</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css" />
</head>

<body>
  <div class="container">
    <h1 class="title">Список дел / To-Do List</h1>
    <p class="emojis">✍️ 📋 📝 ✔️ 🕒</p>
    <form class="form" action="index.php" method="post">
      <input type="text" name="task" class="task_name" id="task" placeholder="Название задачи"
        oninvalid="this.setCustomValidity('Введите название задачи')" oninput="this.setCustomValidity('')" required />
      <button class="add_task" type="submit">Добавить задачу</button>
    </form>
    <div class="tasks">
      <?php
      if (isset($_SESSION['tasks'])) {
        foreach ($_SESSION['tasks'] as $index => $task) {
          echo '<div class="task" data-task-id="' . $index . '">';
          echo '<img class="checkmark" src="img/checkbox.svg" alt="checkmark" />';
          echo "<p class='task_text'>{$task['name']}</p>";
          echo "<div class='delete-container'><p class='delete'>❌</p></div>";
          echo '</div>';
        }
      }
      ?>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const deleteContainers = document.querySelectorAll('.delete-container');

      deleteContainers.forEach(container => {
        container.addEventListener('click', (event) => {
          const taskElement = event.target.closest('.task');
          const taskId = taskElement.getAttribute('data-task-id');
          taskElement.style.animation = 'fadeOut 0.4s forwards';

          const formData = new FormData();
          formData.append('delete_task_id', taskId);

          setTimeout(() => {
            fetch('form.php', {
              method: 'POST',
              body: formData
            })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  taskElement.remove();
                } else {
                  // console.error('Ошибка при удалении задачи');
                }
              })
              .catch(error => {
                // console.error('Ошибка: ', error);
              });
          }, 400);
        });
      });
    });

    const tasks = document.querySelectorAll('.task');
    if (tasks) {
      tasks.forEach(task => {
        task.addEventListener('click', () => {
          const checkbox = task.querySelector('.checkmark');
          const taskText = task.querySelector('.task_text');
          const deleteContainer = task.querySelector('.delete_container');
          if (checkbox && taskText) {
            if (checkbox.src.includes('checkbox.svg')) {
              taskText.style.textDecoration = "line-through";
              checkbox.src = "img/checkmark.svg";
              task.style.background = "var(--primary-darker)";
            } else {
              taskText.style.textDecoration = "none";
              checkbox.src = "img/checkbox.svg";
              task.style.background = "var(--primary)";
            }
          }
        });
      });
    }
  </script>
</body>

</html>