<?php

class DeleteController extends ApplicationController
{

	public function deleteAction(){
        if ($this->getRequest()->isPost()) {
            $this->deleteTasksAction();
        } else {
            $tasks = $this->database->getAll();
		    $this->view->tasks = $tasks;
        }
	}

	public function deleteTasksAction() {
    if ($this->getRequest()->isPost()) {
        header('Content-Type: application/json');
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        $ids = $data['ids'] ?? [];

        if (!empty($ids) && is_array($ids)) {
            $tasks = $this->database->removeTasks($ids);
            echo json_encode(['status' => 'success', 'tasks' => $tasks]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No IDs provided']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    }
    exit();
    }
}
