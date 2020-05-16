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
        $date_param = $this->getRequest()->getParam('date');
        $number_param = $this->getRequest()->getParam('number');

        if ($id_param != null) {
            $this->usersModel->whereUserId($id_param);
        }
        if ($fullname_param != null) {
            $this->usersModel->whereFullnameLike($fullname_param);
        }
        if ($date_param != null) {
            $this->usersModel->whereBirthdayLike($date_param);
        }
        if ($number_param != null) {
            $this->usersModel->whereUserNumber($number_param);
        }

        $users = $this->usersModel->fetchAll();

        return $this->_helper->json->sendJson(array(
            'success' => true,
            'rows' => $users,
            'params' => array(
                'id' => $id_param,
                'fullname' => $fullname_param,
                'date' => $date_param,
                'number' => $number_param
            ),
            'count' => sizeof($users)
        ));

//        $jsonString = json_encode($jsonArray);
//        echo $jsonString;
      // $this->view->users = $this->usersModel->getAllUsers();
    }

    public function getUserFileAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

       $userData = $this->listAction();

        try {
            $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            $e->getMessage();
        }

        try {
            $sheet->setCellValue('B2', "Hello");
            $sheet->getStyle('B2')->applyFromArray([
                'font' => [
                    'name'=>'Arial',
                    'bold' => true,
                    'italic' => false,
                    'underline' => \PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_DOUBLE,
                    'color' => [ 'rgb' => '808080' ]
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => [ 'rgb' => '808080']
                    ]
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'wrapText' => true
                ]
            ]);
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            $e->getMessage();
        }


        try {
            $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="hello world.xlsx"');
            $writer->save("php://output");
        } catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
            $e->getMessage();
        }


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

