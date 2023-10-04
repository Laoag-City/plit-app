<?php

namespace App\Livewire;

use Livewire\Component;

class TextWithSearchSelectionField extends Component
{
    public $dropdownLabelId;
    public $results = [];
    public $label;
	public $type = 'text';
	public $name;
	public $value;
	public $placeholder = '';
	public $error = '';
	public $buttonText;

    public function render()
    {
        return view('livewire.text-with-search-selection-field');
    }
}
