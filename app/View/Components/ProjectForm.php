<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProjectForm extends Component
{
    public $project;
    public $buttonText;

    public function __construct($project = null, $buttonText = 'Submit')
    {
        $this->project = $project;
        $this->buttonText = $buttonText;
    }

    public function render()
    {
        return view('components.project-form');
    }
}
