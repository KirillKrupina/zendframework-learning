<?php

class Application_Model_Users
{

    public function getAllUsers() {
        return array(
            array('id' => 1, 'login' => 'user1', 'email' => 'user1@mail.com'),
            array('id' => 2, 'login' => 'user2', 'email' => 'user2@mail.com'),
            array('id' => 3, 'login' => 'user3', 'email' => 'user3@mail.com'),
        );
    }

}

