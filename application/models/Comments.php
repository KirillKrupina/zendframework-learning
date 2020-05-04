<?php

class Application_Model_Comments{

    public function getAllComments() {
        return array(
            array('id' => 1, 'text' => 'Lorem ipsum 1'),
            array('id' => 2, 'text' => 'Lorem ipsum 2'),
            array('id' => 3, 'text' => 'Lorem ipsum 3'),
        );
    }

}