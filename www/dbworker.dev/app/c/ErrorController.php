<?php

    namespace app\c;

    class ErrorController
    {
        public static function notFound()
        {
            return view('404',['error' => 'Not Found Route'], 404);
        }
    }