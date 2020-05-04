<?php

class UsersController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $usersModel = new Application_Model_Users();
        $this->view->assign('users', $usersModel->getAllUsers());
    }

    public function viewAction() {

    }

    public function addUserAction(){

    }

    public function editUserSettings() {

    }


}

