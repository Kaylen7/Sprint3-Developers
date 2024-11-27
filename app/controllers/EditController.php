<?php

class EditController extends ApplicationController {
    public function updateAction(){
        $id = $this->_namedParameters['id'];
        $task = $this->database->getTask($id);
        $this->view->task = $task;
        if(!$task){
            throw new Exception('La tasca no existeix.');
        }

        if($this->getRequest()->isPost()){
            $request = $this->getRequest();
            $task = $request->getAllParams();

            $task['start_time'] = strtotime($request->getParam('start_time'));
            $task['end_time'] = strtotime($request->getParam('end_time'));

            if($task['start_time'] > $task['end_time']){
                echo $this->showModal('Error!', 'La data de inici no pot ser posterior a la data de final', 'Torna');
                return;
            }

            $update = $this->database->updateTask($this->_namedParameters['id'], $task);
            if(!$update){
                echo $this->showModal('Ep!', 'No hi ha canvis', 'Torna');
                return;
            }
            echo $this->showModal('Tasca editada!', 'S\'ha editat correctament!', 'Veure','/view' . '/' . $this->_namedParameters['id']);
            return;
            
        }
    }
}