<?php

class EditController extends ApplicationController {
    public function updateAction(){
        $id = $this->_namedParameters['id'];
        $task = $this->database->getTask($id);
    }
}