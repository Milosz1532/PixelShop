<?php
    class Session
    {
        public function start()
        {
            session_start();
        }

        public function get($key)
        {
            return $_SESSION[$key] ?? null;
        }

        public function set($key, $value)
        {
            $_SESSION[$key] = $value;
        }

        public function delete($key)
        {
            unset($_SESSION[$key]);
        }

        public function isLoggedIn()
        {
            return isset($_SESSION['userData']);
        }


        public function logout()
        {
            session_destroy();
        }
    }

?>
