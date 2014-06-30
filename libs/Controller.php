<?php

/**
 * This is the "base controller class". All other "real" controllers extend this class.
 */
class Controller
{
    /**
     * @var
     */
    public $db = null;
    public $auth;
    public $params;

    /**
     * Whenever a controller is created, open a database connection too. The idea behind is to have ONE connection
     * that can be used by multiple models (there are frameworks that open one connection per model).
     */
    function __construct()
    {
        $this->auth = Registry::get('auth');
        if(!$this->auth->read) header('location: ' . URL . '403');
    }

    /**
     * loads the model with the given name.
     * @param $name string name of the model
     */
    public function loadModel($name)
    {
        $path = MODELS_PATH.strtolower($name).'Model.php';

        if (file_exists($path)) {
            require $path;
            // The "Model" has a capital letter as this is the second part of the model class name,
            // all models have names like "LoginModel"
            $modelName = $name.'Model';
            // return the new model object while passing the database connection to the model
            return new $modelName($this->db);
        }
    }

    public function render($data_array = array())
    {
        // load Twig, the template engine
        // @see http://twig.sensiolabs.org
        $twig_loader = new Twig_Loader_Filesystem(PATH_VIEWS);
        $twig = new Twig_Environment($twig_loader);
        $twig->addGlobal('_page', Registry::get('pageArray'));
        $twig->addGlobal('_view', Registry::get('pageArray')['view'].PATH_VIEW_FILE_TYPE);
        //$twig->addGlobal('_siteMap', Registry::get('siteArray'));
        $twig->addGlobal('_siteTree', Registry::get('siteTree'));
        $twig->addGlobal('_user', $this->auth);

        // render a view while passing the to-be-rendered data
        echo $twig->render('_templates/'.Registry::get('pageArray')['layout'].PATH_VIEW_FILE_TYPE, $data_array);
    }
}
