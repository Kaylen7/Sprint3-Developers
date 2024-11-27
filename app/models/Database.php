<?php

class Database extends Model {

    private array $tasks;
    private string $fullPath;

    public function __construct(){
        $dbFile = 'config/database.json';

        $this->fullPath = dirname(__DIR__, 2) . '/config/database.json';

        if(file_exists($this->fullPath)){
            $data = file_get_contents($this->fullPath);
            $this->tasks = json_decode($data, true)['tasks'];
        } else {
            throw new Exception("Error retrieving file.");
        }
    }

    public function getAll(): array{
        return $this->tasks;
    }

    public function getTask(string $id): array{
        $ids = [];
        foreach($this->tasks as $task){
            array_push($ids, $task["id"]);
        }
        if(in_array($id, $ids)){
            $idx = array_search($id, $ids);
            $task = $this->tasks[$idx];
        } else {
            $task = [];
        }
        return $task;
    }

    public function updateTask(string $id, array $changes): bool{
        $countChanges = 0;
        $oldTask = $this->getTask($id);
        foreach($changes as $param=>$content){
            if($this->isAcceptedParameter($param) && $this->isValidContent($param, $content) && $this->isDifferent($oldTask[$param], $content)){
                $this->updateInnerTasks($id, $param, $content);
                $countChanges++;
            }
        }
        if($countChanges > 0){
            $this->updateDatabase();
            return true;
        } else {
            return false;
        }
    }

    private function isAcceptedParameter(string $param): bool{
        return in_array($param, ["title", "description", "start_time", "end_time", "created_by", "state"]);
    }

    public function isValidContent(string $param, mixed $content): bool {
        return match($param) {
            'title' => !empty($content),
            'description' => !empty($content),
            'start_time' => is_int($content),
            'end_time' => is_int($content),
            'created_by' => !empty($content),
            'status' => !empty($content),
            default => false
        };
    }

    private function isDifferent(string $oldContent, string $newContent): bool {
        return $oldContent != $newContent;
    }

    private function updateInnerTasks(string $id, string $parameter, mixed $input): void{
        $task = $this->getTask($id);
        $task[$parameter] = $input;
        $updated_tasks = [];
        foreach($this->tasks as $t){
            if ($t["id"] === $id){
                array_push($updated_tasks, $task);
            } else {
                array_push($updated_tasks, $t);
            }
        }
        $this->tasks = $updated_tasks;
    }

    public function removeTasks(array $ids): array {
        foreach ($this->tasks as $key => $task) {
            if (in_array($task['id'], $ids, true)) { 
                unset($this->tasks[$key]);
            }
        }
        $this->updateDatabase();
        return $this->tasks;
    }

    public function addTask(array $newTask) {
        $newTask['id'] = uniqid('');
        do {
            $taskExists = false;
            foreach ($this->tasks as $task) {
                if ($task['id'] === $newTask['id']) {
                    $taskExists = true;
                    $newTask['id'] = uniqid('');
                    break;
                }
            }
        } while ($taskExists);
    
        array_push($this->tasks, $newTask);
        $this->updateDatabase();
        return $this->tasks;
    }

    private function updateDatabase(){
        $this->tasks = array_values($this->tasks);
        $baseDB = [];
        $baseDB["tasks"] = $this->tasks;

        try {
            $json = json_encode($baseDB, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
            file_put_contents($this->fullPath, $json);
        } catch (Exception $e){
            echo "Error " . $e->getMessage();
        }
    }
}