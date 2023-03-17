<?php

namespace App\Interfaces;
/**
 * Add this interface to any model that needs to be searched
 */
interface SearchableModel
{
    /**
     * Model should implents this scope search to searchable
     */
    public function scopeSearch($q, ?string $term, ?int $officeId = null);
}
