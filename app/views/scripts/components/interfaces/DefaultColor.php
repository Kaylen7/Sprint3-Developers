<?php

class DefaultColor implements ColorInterface {

    public function setColor(string $state): string{
        return match($state){
            'active' => 'bg-black text-white',
            default => 'bg-white border-black border-2'
        };
    }
}