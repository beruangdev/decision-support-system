<?php

namespace App\View\Components;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $data = [];
        if (Route::input("project") || Route::input("project_id")) {
            $project_id = Route::input("project");
            $data["project_id"] = $project_id;
        }
        return view('layouts.app', $data);
    }
}
