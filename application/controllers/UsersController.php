<?php

class UsersController extends Zend_Controller_Action
{
    /**
     * @type Application_Model_DbTable_Users
     */
    protected $usersModel;

    public function init()
    {
        $this->usersModel = new Application_Model_DbTable_Users();
    }

    public function indexAction()
    {
       $this->view->users = $this->usersModel->getAllUsers();
    }


    public function addUserAction(){
        $insertData = array(
            'fullname' => 'New User',
            'email' => 'newuser@mail.com'
        );

        $this->view->lastId = $this->usersModel->addUser($insertData);
    }

    public function editUserAction() {
        $updateData = array(
            'fullname' => 'Updated User',
            'email' => 'updateduser@mail.com'
        );
        $this->usersModel->updateUserById($updateData, 1);
    }

    public function deleteUserAction(){
        $this->usersModel->deleteUserWithMaxId();
    }

}

