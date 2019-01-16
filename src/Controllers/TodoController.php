<?php

use Todo\Controller;
use Todo\Database;
use Todo\TodoItem;

class TodoController extends Controller {
    
    public function get()
    {
        $todos = TodoItem::findAll();
        return $this->view('index', ['todos' => $todos]);
    }

    public function add()
    {
        $body = filter_body(); 
        $result = TodoItem::createTodo($body['title']);

        if ($result) {
            $this->redirect('/');
        }

        else {
            throw new Exception("Could not add item.");
        }
    }

    public function update($urlParams)
    {
        $body = filter_body(); // gives you the body of the request (the "envelope" contents)
        $todoId = $urlParams['id']; // the id of the todo we're trying to update
        $todoTitle = $body['title'];
        $completed = isset($body['status']) ? 'true' : 'false'; // whether or not the todo has been checked or not

        $result = TodoItem::updateTodo($todoId, $todoTitle, $completed);

        if ($result) {
            $this->redirect('/');
        }

        else {
            throw new Exception("Could not update item.");
        }
    }

    public function delete($urlParams)
    {
        $todoId = $urlParams['id'];

        $result = TodoItem::deleteTodo($todoId);

        if ($result) {
            $this->redirect('/');
        }

        else {
            throw new Exception("Could not delete item.");
        }
    }

    /**
     * OPTIONAL Bonus round!
     * 
     * The two methods below are optional, feel free to try and complete them
     * if you're aiming for a higher grade.
     */
    public function toggle()
    {
      // (OPTIONAL) TODO: This action should toggle all todos to completed, or not completed.
    }

    public function clear()
    {
      // (OPTIONAL) TODO: This action should remove all completed todos from the table.
    }

}
