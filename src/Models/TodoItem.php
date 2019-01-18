<?php

namespace Todo;

class TodoItem extends Model
{
    const TABLENAME = 'todos'; // This is used by the abstract model, don't touch

    public static function createTodo($title)
    {
        try {
            $query = "SELECT MAX(list_order) AS list_order FROM " . static::TABLENAME;
            self::$db->query($query);
            $listOrder = self::$db->result()->list_order + 1;

            $query = "INSERT INTO " . static::TABLENAME . " (title, created, completed, list_order) VALUES (:title, NOW(), 'false', :list_order)";
            self::$db->query($query);
            self::$db->bind(':title', $title);
            self::$db->bind(':list_order', $listOrder);
            return self::$db->execute();

        } catch (PDOException $err) {
            return $err->getMessage();
        }
    }

    public static function updateTodo($todoId, $title, $move, $completed = null)
    {
        try {
            if($move) {
                if($move === "up") {
                    $moveQuery = "SELECT id FROM " . static::TABLENAME . " WHERE list_order < (SELECT list_order FROM " . static::TABLENAME . " WHERE id = :id) ORDER BY list_order DESC LIMIT 1";
                }
    
                elseif($move === "down") {
                    $moveQuery = "SELECT id FROM " . static::TABLENAME . " WHERE list_order > (SELECT list_order FROM " . static::TABLENAME . " WHERE id = :id) ORDER BY list_order LIMIT 1";
                }
    
                self::$db->query($moveQuery);
                self::$db->bind(':id', $todoId);
    
                $swapId = self::$db->result();

                if($swapId) {
                    $swapResult = self::swapOrder($todoId, $swapId->id);
                }

                else {
                    return true;
                }
            }

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

    private static function swapOrder($id1, $id2)
    {
        try {
            $query = "UPDATE " . static::TABLENAME . " a INNER JOIN " . static::TABLENAME . " b ON a.id <> b.id SET a.list_order = b.list_order where a.id in (:id1,:id2) and b.id in (:id1,:id2)";
            self::$db->query($query);
            self::$db->bind(':id1', $id1);
            self::$db->bind(':id2', $id2);
            return self::$db->execute();
        } catch (PDOException $err) {
            return $err;
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
    
    public static function toggleTodos()
    {
        try {
            $query = "UPDATE " . static::TABLENAME . " SET completed = IF(completed = 'true', 'false', 'true')";
            self::$db->query($query);
            return self::$db->execute();

        } catch (PDOException $err) {
            return $err->getMessage();
        }
    }

    public static function clearCompletedTodos()
    {
        try {
            $query = "DELETE FROM " . static::TABLENAME . " WHERE completed = 'true'";
            self::$db->query($query);
            return self::$db->execute();

        } catch (PDOException $err) {
            return $err->getMessage();
        }
    }

    public static function findUncompleted() {
        $whereQuery = "WHERE completed = 'false'";
        
        return self::findAll('list_order', false, $whereQuery);
    }

    public static function findCompleted() {
        $whereQuery = "WHERE completed = 'true'";
        
        return self::findAll('list_order', false, $whereQuery);
    }
}
