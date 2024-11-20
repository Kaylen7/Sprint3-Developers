<?php
class CreateController extends ApplicationController
{
	public function createAction()
	{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
					$title = $_POST['title'] ?? null;
					$description = $_POST['description'] ?? null;
					$tags = $_POST['tags'] ?? null;
					$start_time = $_POST['start_time'] ?? null;
					$end_time = $_POST['end_time'] ?? null;
					$created_by = $_POST['created_by'] ?? null;
					$state = $_POST['state'] ?? null;
	
					// Validación de campos
					if (!$title || !$description || !$tags || !$start_time || !$end_time || !$created_by || !$state) {
							echo "Error: Faltan datos.";
							return;
					}
	
					$task = array(
							'title' => $title,
							'description' => $description,
							'tags' => explode(',', $tags),
							'start_time' => strtotime($start_time),
							'end_time' => strtotime($end_time),
							'created_by' => $created_by,
							'state' => $state,
					);
	
					$this->database->addTask($task);
					return;
			}
	}
	
}
