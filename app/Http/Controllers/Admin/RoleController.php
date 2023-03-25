<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DatatableBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserListingRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(UserListingRequest $request)
    {
        return new DatatableBuilder(
            $request->applyListingFilters(Role::query())
        );
    }
}
