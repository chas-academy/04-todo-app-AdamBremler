<header class="header">
    <h1><a href="/" style="color: inherit; text-decoration: none;">todos</a></h1>
    <form method="get" action="/todos/search">
        <input name="q" placeholder="Search" type="text" style="width: 93%; padding: 3.5%; font-size: 1.8em; border: 0; box-shadow: 0px 3px 2px #eee">
    </form>
    <form id="create-todo" method="post" action="/todos">
      <input name="title" class="new-todo" placeholder="What needs to be done?" autofocus required>
    </form>
</header>

<section class="main">
    <form method="post" action="/todos/toggle-all">
        <input id="toggle-all" class="toggle-all" type="submit">
        <label for="toggle-all">Mark all as complete</label>
    </form>
</section>