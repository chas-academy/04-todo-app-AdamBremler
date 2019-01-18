<li data-id=<?= $todo['id'] ?> <?= $todo['completed'] === "true" ? 'class="completed"' : "" ?>>
  <form class="view" method="POST" action="/todos/<?= $todo['id'] ?>">
    <input type="hidden" name="_METHOD" value="PATCH"/>
    <input type="hidden" name="title" value="<?= $todo['title']; ?>"/>
    <input name="status" class="toggle" type="checkbox" <?= $todo['completed'] === "true" ? 'checked="true"' : "" ?> onChange="submit();">
    <label id=<?= $todo['id'] ?>><?= $todo['title']; ?></label>
    <input type="radio" class="hidden" id="moveUp<?= $todo['id'] ?>" name="move" value="up" onclick="submit();">
    <label for="moveUp<?= $todo['id'] ?>" style="font-size: 20px; position: absolute; top: 4px; right: 60px; padding: 0; cursor: pointer;">▲</label>
    <input type="radio" class="hidden" id="moveDown<?= $todo['id'] ?>" name="move" value="down" onclick="submit();">
    <label for="moveDown<?= $todo['id'] ?>" style="font-size: 20px; position: absolute; bottom: 4px; right: 60px; padding: 0; cursor: pointer;">▼</label>
    <a class="button destroy" href="/todos/<?= $todo['id'] ?>/delete" name="remove"></a>
  </form>
</li>