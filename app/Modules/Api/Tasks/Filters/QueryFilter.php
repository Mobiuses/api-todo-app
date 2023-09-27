<?php

declare(strict_types=1);

namespace App\Modules\Api\Tasks\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
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
        }
    }
}
