<?php
class Actiane_Acl extends Zend_Acl
{
    public function __construct()
    {
        // Add a new role called "guest"
        $this->addRole(new Zend_Acl_Role('guest'));
        // Add a role called collaborateur, which inherits from guest
        $this->addRole(new Zend_Acl_Role('collaborateur'), 'guest');
        // Add a role called admin, which inherits from collaborateur
        $this->addRole(new Zend_Acl_Role('admin'), 'collaborateur');

        // Add some resources in the form controller::action
        $this->add(new Zend_Acl_Resource('error::error'));
        $this->add(new Zend_Acl_Resource('auth::login'));
        $this->add(new Zend_Acl_Resource('auth::logout'));
        $this->add(new Zend_Acl_Resource('index::index'));

        // Allow guests to see the error, login and index pages
        $this->allow('guest', 'error::error');
        $this->allow('guest', 'auth::login');
        $this->allow('guest', 'index::index');

        // Allow collaborateurs to access logout and the index action from the collaborateur controller
        $this->allow('collaborateur', 'auth::logout');
        $this->allow('collaborateur', 'client::list');
        $this->allow('collaborateur', 'conges::saisir');
        $this->allow('collaborateur', 'cra::saisir');
        $this->allow('collaborateur', 'collaborateur::list');

        // Allow admin to access admin controller, index action
        $this->allow('collaborateur', 'admin::index');
        $this->allow('collaborateur', 'client::ajout');
        $this->allow('collaborateur', 'client::update');
        $this->allow('collaborateur', 'client::modif');
        $this->allow('collaborateur', 'client::suppr');

        $this->allow('collaborateur', 'collaborateur::relier');
        $this->allow('collaborateur', 'collaborateur::ajout');
        $this->allow('collaborateur', 'collaborateur::update');
        $this->allow('collaborateur', 'collaborateur::modif');
        $this->allow('collaborateur', 'collaborateur::suppr');

        // You will add here roles, resources and authorization specific to your application, the above are some examples
    }
}
