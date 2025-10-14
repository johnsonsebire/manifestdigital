<?php

namespace App\View\Components;

use App\Models\Form as FormModel;
use Illuminate\View\Component;
use Illuminate\View\View;

class Form extends Component
{
    /**
     * The form instance.
     */
    public FormModel $form;

    /**
     * The component to render.
     */
    public string $component = 'forms.partials.form';

    /**
     * Create a new component instance.
     */
    public function __construct($id = null, $slug = null)
    {
        // Find the form by ID or slug
        if ($id) {
            $this->form = FormModel::with('fields')->findOrFail($id);
        } elseif ($slug) {
            $this->form = FormModel::with('fields')->where('slug', $slug)->firstOrFail();
        } else {
            throw new \InvalidArgumentException('Either id or slug must be provided');
        }
        
        // Check if the form is active
        if (!$this->form->isActive()) {
            throw new \Exception('Form is not active');
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.form', [
            'form' => $this->form,
        ]);
    }
}