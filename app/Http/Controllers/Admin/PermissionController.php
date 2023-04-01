<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DatatableBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionRequest;
use App\Http\Requests\Admin\UserListingRequest;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(UserListingRequest $request): DatatableBuilder
    {
        return new DatatableBuilder(
            $request->applyListingFilters(Permission::query())
        );
    }

    public function store(PermissionRequest $request): mixed
    {
        return $this->handleForm($request, new Permission);
    }

    private function handleForm(PermissionRequest $request, Permission $permission): mixed
    {
        $permission->name = $request->name;
        return $permission->save();
    }
}
