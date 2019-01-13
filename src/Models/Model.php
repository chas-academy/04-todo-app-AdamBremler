<?php

namespace Todo;

abstract class Model
{
    protected static $db;

    public static function initialize()
    {
        if (!self::$db) {
            self::$db = Database::getInstance();
        } else {
            return self::$db;
        }
    }

    /**
     * Magic method that get's the static constant TABLENAME from any model class
     * that inherits this abstract model
     */
    public static function getConstants()
    {
        $oClass = new \ReflectionClass(get_called_class());
        return $oClass->getConstants();
    }

    /** 
     * Generic model method for selecting everything from a model class
     * that inhertis this abstract model
     */
    public static function findAll()
    {
        try {
            $query = "SELECT * FROM " . static::TABLENAME . " ORDER BY created DESC";
            self::$db->query($query);
            $results = self::$db->resultset();

            if (!empty($results)) {
                return $results;
            } else {
                return [];
            }
        } catch (PDOException $err) {
            return $err->getMessage();
        }
    }

    /** 
     * Generic model method for selecting a specific item from a model class
     * that inhertis this abstract model
     */
    public static function findOne($id)
    {
        try {
            $query = "SELECT * FROM " . static::TABLENAME . " WHERE id = :id";
            self::$db->query($query);
            self::$db->bind(':id', $id);

            $result = self::$db->result();

            if (!empty($result)) {
                return $result;
            } else {
                throw new \Exception("Error occured when trying to fetch result.");
            }
        } catch (PDOException $err) {
            return $err->getMessage();
        }
    }
}

Model::initialize();
