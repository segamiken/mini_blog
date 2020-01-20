<?php

class MiniBlogApplication extends Application
{
    protected $login_action = array('account', 'signin');

    public function getRootDir()
    {
        return dirname(__FILE__);
    }

    protected function registerRoutes()
    {
        return array(
            '/account'
                => array('controller' => 'account', 'action' => 'index'),
            '/acount/:action'
                => array('controller' => 'account'),
            
        );
    }

    protected function configure()
    {
        $this->db_manager->connect('master', array(
            'dsn' => 'mysql:host=127.0.0.1;port=3306;dbname=mini_blog',
            'user' => 'root',
            'password' => 'pass',
        ));
    }


}
