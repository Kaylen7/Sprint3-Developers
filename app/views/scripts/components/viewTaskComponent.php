<?php

class viewTaskComponent {

    private string $component;
    private string $htmlPath;
    private string $type;

    const PLACEHOLDER_LITERALS = [
        'title' => "Introdueix un titol per a la tasca",
        'description' => "Introdueix una descripció per a la tasca",
        'created_by' => "Introdueix el teu nom",
        'tags' => "separats,per,comes",
        'state' => 'ongoing'
    ];

    const STATIC_PLACEHOLDERS = [
        '#view_title',
        '#view_button',
    ];

    const ACTION_PLACEHOLDER = '#form_action';

    public function __construct(
        private array $task = []
    ){
        $this->htmlPath = dirname(__FILE__, 2) . "/components/html/";
        $this->type = count($this->task) > 0 ? 'edit' : 'create';
        $this->setComponent();
        $this->render();
    }

    private function render(){
        echo $this->component;
    }

    private function setComponent(): void {
        $file = $this->htmlPath . "mainTaskView.phtml";
        if(file_exists($file)){
          $this->component = file_get_contents($file);

          $this->setPlaceholderOrValue(); //change placeholder_value
          $this->setDynamicContent(); //fill dynamic content
          $this->setStaticContent(); //fill title and button content
          $this->setFormAction(); //set form action path
        } else {
            echo "file does not exist";
        }
    }

    private function setPlaceholderOrValue(): void{
        $value = match($this->type){
            'edit' => 'value',
            default => 'placeholder'
        };
        $this->updateComponent('placeholder_value', $value);
    }

    private function updateComponent(string $call, string $input): void {
        $this->component = str_replace($call, $input, $this->component);
    }

    private function setDynamicContent(): void{
        $info = $this->type === 'edit' ? $this->task : self::PLACEHOLDER_LITERALS;
        
        foreach($info as $key=>$value){
            $content = match($key){
                'tags' => $this->type === 'edit' ? implode(', ', $value) : self::PLACEHOLDER_LITERALS['tags'],
                'start_time', 'end_time' => date('Y-m-d\TH:i:s', $value),
                'description' => $this->setDescription(),
                'state' => $this->setState(),
                default => $value
            };
            $this->updateComponent('#task_' . $key, $content);
        }
    }

    private function setStaticContent(): void{
        $title = $this->type === 'edit' ? 'Editar' : 'Crear';
        foreach(self::STATIC_PLACEHOLDERS as $key){
            $this->updateComponent($key, $title);
        }
    }

    private function setDescription(): string{
        return match($this->type){
            'edit' => '<textarea id="description" name="description" maxlength="200" class="bg-gray-200 rounded-[20px] h-[100px] px-[15px] py-[10px]" rows="4">' . $this->task['description'] . '</textarea>',
            default => '<textarea id="description" name="description" maxlength="200" class="bg-gray-200 rounded-[20px] h-[100px] px-[15px] py-[10px]" rows="4" placeholder="' . self::PLACEHOLDER_LITERALS['description'] . '"></textarea>'
        };
    }

    private function setState(): string{
        return match($this->type){
            'edit' => '<option value="ongoing"' . ($this->task['state'] === 'ongoing' ? 'selected' : '') . '>En curs</option>
        <option value="done"' . ($this->task['state'] === 'done' ? 'selected' : '') . '>Complet</option>
        <option value="pending"' . ($this->task['state'] === 'pending' ? 'selected' : '') . '>Pendent</option>',
            default => '<option value="ongoing"' . (self::PLACEHOLDER_LITERALS['state'] === 'ongoing' ? 'selected' : '') . '>En curs</option>
        <option value="done"' . (self::PLACEHOLDER_LITERALS['state'] === 'done' ? 'selected' : '') . '>Complet</option>
        <option value="pending"' . (self::PLACEHOLDER_LITERALS['state'] === 'pending' ? 'selected' : '') . '>Pendent</option>'
        };
    }

    private function setFormAction(): void{
       $action = match($this->type){
            'edit' => '/edit' . '/' . $this->task['id'],
            'create' => '/create',
            default => '/'
        };
        $this->updateComponent(self::ACTION_PLACEHOLDER, $action);
    }
}