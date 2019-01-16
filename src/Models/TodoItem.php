<?php

namespace Todo;

class TodoItem extends Model
{
    const TABLENAME = 'todos'; // This is used by the abstract model, don't touch

    public static function createTodo($title)
    {
        try {
            $query = "INSERT INTO " . static::TABLENAME . " (title, created, completed) VALUES (:title, NOW(), 'false')";
            self::$db->query($query);
            self::$db->bind(':title', $title);
            return self::$db->execute();

        } catch (PDOException $err) {
            return $err->getMessage();
        }
    }

    public static function updateTodo($todoId, $title, $completed = null)
    {
        try {
            $query = "UPDATE " . static::TABLENAME . " SET title = :title, completed = :completed WHERE id = :id";
            self::$db->query($query);
            self::$db->bind(':title', $title);
            self::$db->bind(':completed', $completed);
            self::$db->bind(':id', $todoId);
            return self::$db->execute();

        } catch (PDOException $err) {
            return $err->getMessage();
        }
    }

    public static function deleteTodo($todoId)
    {
        try {
            $query = "DELETE FROM " . static::TABLENAME . " WHERE id = :id";
            self::$db->query($query);
            self::$db->bind(':id', $todoId);
            return self::$db->execute();

        } catch (PDOException $err) {
            return $err->getMessage();
        }
    }
    
    // (Optional bonus methods below)
    // public static function toggleTodos($completed)
    // {
    //     // TODO: Implement me!
    //     // This is to toggle all todos either as completed or not completed
    // }

    // public static function clearCompletedTodos()
    // {
    //     // TODO: Implement me!
    //     // This is to delete all the completed todos from the database
    // }

}
