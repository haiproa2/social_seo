<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth, View;

class AdminController extends Controller
{
    protected $prefix = '';
    protected $action = '';
    protected $title = '';
    protected $description = '';
    protected $disabled = false;
    protected $updateForm = false;

    public function __construct(Request $request){
        $this->prefix = ($request->segment(2))?$request->segment(2):'index';
        $this->action = ($request->segment(3))?(($request->segment(4))?'edit':'add'):'list';
        if($request->segment(3) == 'add' || $request->segment(4) == 'edit')
            $this->updateForm = true;

        view::share([
            'prefix' => $this->prefix, 
            'action' => $this->action,
            'title' => $this->title,
        	'description' => $this->description,
            'disabled' => $this->disabled,
            'updateForm' => $this->updateForm,
        ]);
    }
}
