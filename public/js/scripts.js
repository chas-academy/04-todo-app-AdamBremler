import { qs, on, delegate } from "./helpers.js"; // Import of convenience functions

// Constants used instead of keyCodes
const ENTER_KEY = 13;
const ESCAPE_KEY = 27;

// Get's the todo item's id from the DOM and parses it into a number
const itemId = element =>
  parseInt(
    element.parentNode.dataset.id || element.parentNode.parentNode.dataset.id,
    10
  );

class Todo {
  constructor() {
    this.initalize();
  }

  initalize() {
    console.log(`Starting Todo application!`);

    this.listHolder = qs(".todo-list");

    this.editTodo(this.editTodo.bind(this));
    this.editTodoSave(this.editTodoSave.bind(this));
    this.editTodoCancel(this.editTodoCancel.bind(this));
  }

  /** Triggered when double-clicking the label of a todo-item */
  editTodo() {
    delegate(this.listHolder, "label", "dblclick", ({ target } = event) => {
      event.preventDefault();

      const listItem = target.offsetParent;
      listItem.classList.add("editing");

      const input = document.createElement("input");
      input.className = "edit";

      input.value = target.innerText;
      listItem.appendChild(input);
      input.focus();
    });
  }

  /** 
   * Triggered when leaving focus of the edit-input field of a todo item.
   * This triggers an update for that todo item, if the title or completed-status
   * has changed. If it hasn't we simply cancel the editing.
   */
  editTodoSave() {
    delegate(
      this.listHolder,
      "li .edit",
      "blur",
      ({ target: { previousElementSibling }, target } = event) => {
        const id = itemId(target);
        const label = qs(`[id="${id}"]`);

        if (!target.dataset.iscanceled && target.value !== label.textContent) {
          qs('input[name="title"]', target.parentElement).value = target.value;
          previousElementSibling.submit(); // Submits update form. See todo.php
        } else {
          this.editTodoDone(itemId(target));
        }
      },
      true
    );
    /** Hitting enter should be the same as submitting **/
    delegate(this.listHolder, "li .edit", "keypress", ({ target, keyCode }) => {
      if (keyCode === ENTER_KEY) {
        target.blur();
      }
    });
  }

  /** 
   * Triggered when hitting escape or clicking outside an unedited todo item.
   * 
   */
  editTodoCancel() {
    delegate(this.listHolder, "li .edit", "keyup", ({ target, keyCode }) => {
      if (keyCode === ESCAPE_KEY) {
        target.dataset.iscanceled = true;
        target.blur();
      }
    });
  }

  editTodoDone(id, title = null) {
    const listItem = qs(`[data-id="${id}"]`);

    const input = qs("input.edit", listItem);

    if (input) {
      listItem.removeChild(input);
      listItem.classList.remove("editing");

      if (title) {
        qs("label", listItem).textContent = title;
      }
    }
  }
}

on(window, "load", () => new Todo());
