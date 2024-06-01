<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TaskForm extends Component
{
    public $projects;
    public $task;
    public $buttonText;

    public function __construct($projects, $task = null, $buttonText = 'Submit')
    {
        $this->projects = $projects;
        $this->task = $task;
        $this->buttonText = $buttonText;
    }

    public function render()
    {
        return view('components.task-form');
    }
}
