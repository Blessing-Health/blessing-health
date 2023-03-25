<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DatatableBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserListingRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(UserListingRequest $request)
    {
        return new DatatableBuilder(
            $request->applyListingFilters(Permission::query())
        );
    }
}
