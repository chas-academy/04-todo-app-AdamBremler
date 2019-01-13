<section class="todo-section">
  <ul class="todo-list">
    <?php foreach($todos as $todo): ?>
      <?= includeWith('/partials/todo.php', compact('todo', $todo)) ?>
    <?php endforeach; ?>
  </ul>
</section>