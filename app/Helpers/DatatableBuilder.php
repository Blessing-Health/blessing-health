<?php

namespace App\Helpers;

use App\Interfaces\SearchableModel;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class DatatableBuilder implements Responsable
{
    protected $mappingCallback = null;
    public function __construct(protected EloquentBuilder|Builder|HasMany $sourceBuilder)
    {
    }

    public function toResponse($request)
    {
        $this->applyQuicksearch($request);

        $totalResults = $this->sourceBuilder->count();

        $this->applySorting($request);
        $results = (clone $this->sourceBuilder)
            ->take($request->take)
            ->skip($request->skip)
            ->get();

        // Caller wants to map the returned results?
        if ($this->mappingCallback) {
            $results = $results->map($this->mappingCallback);
        }

        return [
            'data' => $results,
            'total' => $totalResults
        ];
    }

    /**
     * Apply a function to map over the returned results
     */
    public function map(callable $mappingCallback): self
    {
        $this->mappingCallback = $mappingCallback;
        return $this;
    }

    private function applyQuicksearch(Request $request)
    {
        if(!$request->quicksear) return;
        // Throw a more friendly exception for us devs to fix (incorrectly configured model)
        throw_unless(
            AppHelpers::classDoesImplement(get_class($this->sourceBuilder->getModel()), SearchableModel::class),
            'RuntimeException',
            'Your model needs to implement App\Interfaces\SearchableModel for datatable searching to work'
        );

        $this->sourceBuilder->search($request->quicksearch);
    }

    private function applySorting(Request $request)
    {
        // Apply custom sort?
        if ($request->sort_by) {
            $this->sourceBuilder->orderByRaw(
                sprintf('%s %s NULLS LAST', $request->sort_by, $request->descending ? 'desc' : 'asc')
            );
        }

        // Always sort by ID to avoid any potential duplicate sort results
        // Ensures that sorting for pagination is consistent
        if ($request->sort_by != 'id') {
            $this->sourceBuilder->orderBy('id', $request->descending ? 'desc' : 'asc');
        }
    }
}
