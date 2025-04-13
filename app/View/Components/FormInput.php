<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormInput extends Component
{
    /**
     *
     * @var mixed
     */
    public $label;
    
    /**
     *
     * @var mixed
     */
    public $value;

    /**
     *
     * @var mixed
     */
    public $type;

    /**
     *
     * @var mixed
     */
    public $name;

    /**
     *
     * @var mixed
     */
    public $id;

    /**
     *
     * @var mixed
     */
    public $class;

    /**
     *
     * @var mixed
     */
    public $listOption;

    /**
     *
     * @var mixed
     */
    public $labelRequired;

    /**
     * Create a new component instance.
     *
     * @param string $label
     * @param string $value
     * @param string $type
     * @param string $name
     * @param string $id
     * @param string $class
     * @param array<mixed> $listOption
     * @param bool $labelRequired
     * 
     * @return void
     */
    public function __construct(
        $label = 'Form label',
        $value = '',
        $type = 'text',
        $name = 'form_name',
        $id = 'form_id',
        $class = '',
        $listOption  = ['' => ''],
        $labelRequired = true,
    ) {
        $this->label = $label;
        $this->value = $value;
        $this->type = $type;
        $this->name = $name;
        $this->id = $id;
        $this->class = $class;
        $this->listOption = $listOption;
        $this->labelRequired = $labelRequired;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-input');
    }
}
