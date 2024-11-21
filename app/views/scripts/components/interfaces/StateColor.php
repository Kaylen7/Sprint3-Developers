<?php

class StateColor implements ColorInterface {
    
    public function setColor(string $state): string{
        return match($state){
            'pending' => 'bg-gray',
            'ongoing' => 'bg-orange',
            'done' => 'bg-green',
            default => ''
        };
    }
}