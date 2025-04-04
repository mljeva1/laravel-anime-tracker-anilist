<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    //
    public function roles () {
        $roles = Role::all();
        return view('info.roles', compact('roles'));
    }
}
