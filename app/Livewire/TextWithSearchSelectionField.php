<?php

namespace App\Livewire;

use App\Models\Owner;
use Livewire\Component;
use Spatie\Searchable\Search;

class TextWithSearchSelectionField extends Component
{
    public $label;
	public $type = 'text';
	public $name;
	public $value;
	public $placeholder = '';
    public $readOnly;
	public $error = '';

	public $buttonText;
    public $dropdownLabelId;
    public $minSearchChars = 5;
    public $hiddenIdSuffix = '_selection_id';
    public $hiddenIdValue;
    public $results = [];
    public $search; //array index in searchBy(). Vague variable name for security reasons.

    public function render()
    {
        return view('livewire.text-with-search-selection-field');
    }

    public function mount()
    {
        $this->setAndGetReadOnly();
    }

    public function searchKeyword($keyword)
    {
        $criterion = $this->getSearchCriterion($this->search);
        
        $this->results = (new Search())
                    ->registerModel($criterion[0], $criterion[1])
                    ->limitAspectResults(10)
                    ->search($keyword)
                    ->transform(fn($item, $key) => [
                        'id' => $item->searchable->owner_id,
                        'text' => $item->searchable->name
                    ]);
    }

    public function makeSelection($id, $text)
    {
        $this->value = $text;
        $this->hiddenIdValue = $id;
        $this->setAndGetReadOnly();
        $this->reset('results');
    }

    /*public function resetOnTypingBelowMinSearchChars()
    {
        $this->reset(['results', 'hidden_id_value']);
    }*/

    public function removeSelection()
    {
        $this->reset(['value', 'hiddenIdValue', 'results']);
        $this->setAndGetReadOnly();
    }

    private function setAndGetReadOnly()
    {
        if($this->hiddenIdValue != null)
            $this->readOnly = true;
        
        else
            $this->readOnly = false;

        return $this->readOnly;
    }

    private function getSearchCriterion($index)
    {
        $searchCriterion = [
            [Owner::class, 'name']
        ];

        return $searchCriterion[$index];
    }
}
