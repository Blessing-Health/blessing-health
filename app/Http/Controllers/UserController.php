<?php

namespace App\Http\Controllers;

use App\Helpers\DatatableBuilder;
use App\Http\Requests\Admin\UserListingRequest;
use App\Models\User;

class UserController extends Controller
{
    public function index(UserListingRequest $request)
    {
        return new DatatableBuilder(
            $request->applyListingFilters(User::listing())
        );
    }
}
