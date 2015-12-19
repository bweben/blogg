<?php

// make the views on the page like the mainpage because without that
// the user can't see anything
// imported from an older project
class View
{
    private $viewfile = null;
    private $properties = array();

    /**
     * View constructor.
     * @param $viewfile
     * @param array $properties
     * creates a View
     */
    public function __construct($viewfile, $properties = array())
    {
        $this->properties = $properties;

        $viewfile = "./view/$viewfile.php";
        if (file_exists($viewfile)) {
            $this->viewfile = $viewfile;
        }
    }

    /**
     * @param $key
     * @param $value
     * add a param to the view file
     */
    public function __set($key, $value)
    {

        if (!isset($this->$key)) {
            $this->properties[$key] = $value;
        }
    }

    /**
     * @param $key
     * @return mixed
     * returns a param from the view file
     */
    public function __get($key)
    {

        if (isset($this->properties[$key])) {
            return $this->properties[$key];
        }
    }

    /**
     * displays the view
     */
    public function display()
    {

        extract($this->properties);
        include_once($this->viewfile);
    }
}
