<?php

declare(strict_types=1);

namespace App\Modules\Api\Tasks\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    /**
     * @var int
     */
    protected int $page = 1;

    /**
     * @var int
     */
    protected int $perPage = 10;

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Builder
     */
    protected Builder $builder;

    /**
     * @param  Request|null  $request
     */
    public function __construct(Request $request = null)
    {
        if ($request) {
            $this->request = $request;
            if ($request->get('page')) {
                $this->page = (int) $request->get('page');
            }
            if ($request->get('per_page')) {
                $this->perPage = (int) $request->get('per_page');
            }
        }
    }
}
