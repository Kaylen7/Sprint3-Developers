<?php

class CrudController extends ApplicationController
{
  public function indexAction()
	{

		echo "<br/><br/>Obtener todas<br/><br/>";
		$tasks = $this->database->getAll();
		var_dump($tasks);

		echo "<br/><br/>Obtener tarea con id '0'<br/><br/>";
		$task = $this->database->getTask("1");
		var_dump($task);

		echo "<br/><br/>Editar tarea con id '2'<br/><br/>";
		$task = $this->database->updateTask("2", ["start_time" => "😨", "description" => "Texto nuevo"]);
		$task = $this->database->getTask("2");
		var_dump($task);

		echo "<br/><br/>Eliminar tarea con id '1'<br/><br/>";
		$task = $this->database->removeTask("1");
		var_dump($task);
	
		echo "<br/><br/>Añadir tarea<br/><br/>";
		$task = $this->database->addTask($task = [
			"title" => "",
			"description" => "",
			"tags" => [
					"work",
					"report",
					"urgent"
			],
			//TO DO
			"start_time" => 1700391600,
			
			//TO DO
			"end_time" => 1700398800,
			"created_by" => "",
			"state" => "ongoing",
			//TO DO
			"id" => "9"
	]);
		var_dump($task);
	}

  public function checkAction()
	{
		echo "hello from test::check";
	}
}