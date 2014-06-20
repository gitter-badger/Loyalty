<?php

/**
 * This is the "base controller class". All other "real" controllers extend this class.
 */
class Model
{
    /**
     * @var null Database Connection
     */
    public $db = null;

    /**
     * Whenever a controller is created, open a database connection too. The idea behind is to have ONE connection
     * that can be used by multiple models (there are frameworks that open one connection per model).
     */
    function __construct()
    {
        $this->db = Registry::get('db');
    }
}