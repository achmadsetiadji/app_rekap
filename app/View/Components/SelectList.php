<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectList extends Component
{
    /**
     *
     * @var mixed
     */
    public $isInline;

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
    public $labelRequired;

    /**
     *
     * @var mixed
     */
    public $url;

    /**
     * Create a new component instance.
     *
     * @param bool $isInline
     * @param string $label
     * @param string $value
     * @param string $name
     * @param string $id
     * @param bool $labelRequired
     * @param string $url
     * 
     * @return void
     */
    public function __construct(
        $isInline = false,
        $label = '',
        $value = "",
        $name = '',
        $id = '',
        $labelRequired = true,
        $url = ''
    ) {
        $this->isInline = $isInline;
        $this->label = $label;
        $this->value = $value;
        $this->name = $name;
        $this->id = $id;
        $this->labelRequired = $labelRequired;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select-list');
    }
}
