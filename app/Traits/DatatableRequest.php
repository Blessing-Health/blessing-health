<?php

namespace App\Traits;

/**
 * Parameters required for every type of serverside datatable request
 */
trait DatatableRequest
{
    public function datatableRules()
    {
        return [
            'quicksearch' => 'nullable|string',
            'take' => 'required|integer|min:0',
            'skip' => 'required|integer|min:0',
            'sort_by' => 'nullable|string',
            'descending' => 'nullable|boolean',

            'search_fields' => 'nullable|array',
            'search_fields.*' => 'required|string'
        ];
    }
}
