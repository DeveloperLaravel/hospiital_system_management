<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserForm extends Component
{
    public $user;

    public $roles;

    public $permissions;

    /**
     * Create a new component instance.
     */
    public function __construct($user = null, $roles = [], $permissions = [])
    {
        $this->user = $user;
        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-form');
    }
}
