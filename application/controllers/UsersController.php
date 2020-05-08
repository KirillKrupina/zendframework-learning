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

    public function listAction()
    {
        //$profiler = $this->usersModel->getDefaultAdapter()->getProfiler()->setEnabled(true);
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $id_param = $this->getRequest()->getParam('id');
        $fullname_param = $this->getRequest()->getParam('fullname');

        if ($id_param != null) {
            $this->usersModel->whereUserId($id_param);
        }
        if ($fullname_param != null) {
            $this->usersModel->whereFullnameLike($fullname_param);
        }

        $users = $this->usersModel->fetchAll();

        return $this->_helper->json->sendJson(array(
            'success' => true,
            'rows' => $users,
            'count' => sizeof($users),
            'params' => array(
                'id' => $id_param,
                'fullname' => $fullname_param
            )
        ));




//        $jsonString = json_encode($jsonArray);
//        echo $jsonString;
      // $this->view->users = $this->usersModel->getAllUsers();
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

