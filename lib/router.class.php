<?php

    class Router
    {
        protected $url;

        protected $controller;

        protected $action;

        protected $params;

        protected $route;

        protected $method_prefix;

        protected $languages;

        /**
         * @return mixed
         */
        public function getUrl()
        {
            return $this->url();
        }

        /**
         * @return mixed
         */
        public function getController()
        {
            return $this->controller;
        }

        /**
         * @return mixed
         */
        public function getAction()
        {
            return $this->action;
        }

        /**
         * @return mixed
         */
        public function getParams()
        {
            return $this->params;
        }

        /**
         * @return mixed
         */
        public function getRoute()
        {
            return $this->route;
        }

        /**
         * @param mixed $method_prefix
         */
        public function getMethodPrefix()
        {
           return $this->method_prefix;
        }

        /**
         * @param mixed $languages
         */
        public function getLanguage()
        {
           return $this->languages;
        }

        public function __construct($url)
        {
            $this->url= urldecode(trim($url, '/'));

            $routes = Config::get('routes');

            $this->route = Config::get('default_route');

            $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';

            $this->languages = Config::get('default_languages');

            $this->controller = Config::get('default_controller');

            $this->action = Config::get('default_action');

            $url_parts = explode('?', $this->url);

            $path = $url_parts[0];

            $path_parts = explode('/', $path);

            if (count($path_parts)) {

                if (in_array(strtolower(current($path_parts)), array_keys($routes))) {
                    $this->route = strtolower(current($path_parts));
                    $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : null;
                    array_shift($path_parts);
                } elseif (in_array(strtolower(current($path_parts)), Config::get('languages'))) {
                    $this->languages = strtolower(current($path_parts));
                    array_shift($path_parts);
                }
                if (current($path_parts)) {
                    $this->controller = strtolower(current($path_parts));
                    array_shift($path_parts);
                }
                if (current($path_parts)) {
                    $this->action = strtolower(current($path_parts));
                    array_shift($path_parts);
                }
                    $this->params = $path_parts;
            }
        }

        public static function redirect($location)
        {
            header("Location: $location");
        }
    }

