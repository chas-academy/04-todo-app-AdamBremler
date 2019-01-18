<footer class="footer">
    <span class="todo-count"><?= count(array_filter($todos, function($todo) { return $todo['completed'] === "false"; })) ?> item<?= "".count($todos) !== 1 ? "s" : "" ?> left</span>
    <form method="post" action="/todos/clear-completed">
        <button type="submit" class="clear-completed">Clear completed</button>
    </form>
    <a href="/todos/filtered/<?= empty($filter) ? 0 : $filter ?>" style="cursor: pointer; position: relative; color: inherit;">Filter</a>
</footer>

</main>

<footer class="site-footer">
    <div class="small-container">
        <p class="text-center">Made by <a href="">Adam Bremler</a></p>
    </div>
</footer>

<script type="module" src="<?= $this->getScript('scripts'); ?>"></script>

</body>

</html>