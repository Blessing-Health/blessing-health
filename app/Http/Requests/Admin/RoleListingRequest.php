<?php

namespace App\Http\Requests\Admin;

use App\Traits\DatatableRequest;
use Illuminate\Foundation\Http\FormRequest;

class RoleListingRequest extends FormRequest
{
    use DatatableRequest;

    public function rules()
    {
        return $this->datatableRules();
    }

    public function applyListingFilters($builder)
    {
        if ($this->quicksearch) {
            return $builder;
        }

        return $builder;
    }
}
