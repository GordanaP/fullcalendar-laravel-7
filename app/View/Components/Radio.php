<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Radio extends Component
{
    public $radio;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($radio)
    {
        $this->radio = $radio;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.radio');
    }
}
