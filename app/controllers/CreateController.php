<?php
class CreateController extends ApplicationController
{
	public function createAction()
	{

			if ($this->getRequest()->isPost()) {
				$title = $_POST['title'] ?? null;
				$description = $_POST['description'] ?? null;
				$tags = $_POST['tags'] ?? null;
				$start_time = $_POST['start_time'] ?? null;
				$end_time = $_POST['end_time'] ?? null;
				$created_by = $_POST['created_by'] ?? null;
				$state = $_POST['state'] ?? null;

				// Validación de campos
				if (!$title || !$start_time || !$end_time || !$created_by || !$state) {
						$this->view->modal = $this->showModal('Error!', 'Falten dades', 'Torna');
						return;
				};

				if($start_time > $end_time){
					
					$this->view->modal = $this->showModal('Error!', 'La data de inici no pot ser posterior a la data de final', 'Torna');
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

				$this->view->modal = $this->showModal('¡Tasca creada!', '¡Tasca creada correctament!', 'Veure','/view/'.$this->database->addTask($task));
			}
	}
	
}
