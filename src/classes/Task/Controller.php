<?php
namespace Task;
 
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class Controller implements ControllerProviderInterface {
 
    public function connect(Application $app) {
        $factory = $app['controllers_factory'];

        // Routes are defined here
        $factory->get('/', 'Task\Controller::home');
        
        return $factory;  
    }

    public function home()
    {
        return 'These are my tasks';
    }
 
}