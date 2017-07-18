<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth, View;

class AdminController extends Controller
{
    protected $prefix = '';
    protected $action = '';

    public function __construct(Request $request){
        $this->prefix = ($request->segment(2))?$request->segment(2):'index';
        $this->action = ($request->segment(4))?$request->segment(4):'list';

        view::share([
        	'title_bar' => '', 
        	'prefix' => ($request->segment(2))?$request->segment(2):'index', 
        	'action' => ($request->segment(4))?$request->segment(4):'list'
        ]);
    }
}
