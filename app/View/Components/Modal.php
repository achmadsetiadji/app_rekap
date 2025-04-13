<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    /**
     *
     * @var mixed
     */
    public $size;

    /**
     * Create a new component instance.
     *
     * @param string $size
     * 
     * @return void
     */
    public function __construct($size = 'modal-lg')
    {
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
