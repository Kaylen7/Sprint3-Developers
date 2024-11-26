<?php

class DeleteController extends ApplicationController
{

	public function deleteAction(){
		$tasks = $this->database->getAll();
		$this->view->tasks = $tasks;
	}

	public function deleteTasksAction() {
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
