<?php

namespace JayI\Stretch\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class ElasticPaginator
 */
class ElasticPaginator extends LengthAwarePaginator
{
    /**
     * Create a new paginator instance.
     *
     * @param  mixed  $items
     * @param  int  $total
     * @param  int  $perPage
     * @param  int|null  $currentPage
     * @param  array  $options  (path, query, fragment, pageName)
     * @return void
     */
    public function __construct($items, $total, $perPage, $currentPage = null, array $options = [])
    {
        parent::__construct($items, $total, $perPage, $currentPage, $options);
    }

    /**
     * Get the base path for paginator generated URLs.
     *
     * @return string|null
     */
    public function path()
    {
        $this->setPath(url(request()->path()));

        return $this->path;
    }

    public static function fromResults(array $results, int $perPage, ?int $currentPage = null, array $options = []): self
    {
        return new self(
            items: data_get($results, 'hits.hits', []),
            total: data_get($results, 'hits.total.value', 0),
            perPage: $perPage,
            currentPage: $currentPage,
            options: $options
        );
    }
}
