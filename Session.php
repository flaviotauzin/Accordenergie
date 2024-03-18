<?php

namespace App;

class Session
{
    function __construct()
    {
        session_start();
    }

    public function add(string $key, $data)
    {
        $_SESSION[$key] = $data;
    }

    public function get(string $key, $data)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
    }

    public function destroy()
    {
        unset($_SESSION);
        session_destroy();
    }

    public function isConnected()
    {
        return isset($_SESSION['user']);
    }

    public function hasRole(string $role)
    {
        if (!$this->isConnected()) {
            return false;
        }
       // return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == $role;

         return $_SESSION['user']['role'] == $role ? true : false;
    }
}