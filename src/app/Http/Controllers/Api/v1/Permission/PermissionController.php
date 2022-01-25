<?php

namespace App\Http\Controllers\Api\v1\Permission;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionCollection;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        return new PermissionCollection(Permission::all());
    }
}
