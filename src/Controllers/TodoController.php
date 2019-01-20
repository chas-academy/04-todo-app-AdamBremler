<?php

use Todo\Controller;
use Todo\Database;
use Todo\TodoItem;

class TodoController extends Controller {
    
    public function get()
    {
        $todos = TodoItem::findAll('list_order', false);

        return $this->view('index', ['todos' => $todos]);
    }

    public function filtered($urlParams)
    {
        $mode = $urlParams['mode'];
        switch ($mode) {
            case 0:
                $todos = TodoItem::findUncompleted();
                break;
            case 1:
                $todos = TodoItem::findCompleted();
                break;
            default:
                $this->redirect('/');
                return;
        }

        return $this->view('index', ['todos' => $todos, 'filter' => $mode + 1]);
    }

    public function search() {
        if (empty($_GET['q'])) {
            return $this->redirect('/');
        }

        $searchTerm = $_GET['q'];

        $todos = TodoItem::findByTitleLike($searchTerm);

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
        $move = !empty($body['move']) ? $body['move'] : false;
        $completed = isset($body['status']) ? 'true' : 'false'; // whether or not the todo has been checked or not

        $result = TodoItem::updateTodo($todoId, $todoTitle, $move, $completed);

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

    public function toggle()
    {
        $result = TodoItem::toggleTodos();

        if ($result) {
            $this->redirect('/');
        }

        else {
            throw new Exception("Could not toggle items.");
        }
    }

    public function clear()
    {
        $result = TodoItem::clearCompletedTodos();

        if ($result) {
            $this->redirect('/');
        }

        else {
            throw new Exception("Could not delete completed items.");
        }
    }
}
