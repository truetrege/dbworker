<?php

    namespace app\src;

    class Container
    {
        private static array $elements =[];


        public static function get($name)
        {
            if (!empty(self::$elements[$name])) {
                return self::$elements[$name];
            }
            return null;
        }


        public static function set($name,$element): void
        {
            self::$elements[$name] = $element;
        }

    }