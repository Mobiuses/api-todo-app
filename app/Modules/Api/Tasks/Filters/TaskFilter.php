<?php

declare(strict_types=1);

namespace App\Modules\Api\Tasks\Filters;

use App\Models\Task;
use App\Modules\Core\ORM\Repositories\Contracts\TaskRepositoryContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class TaskFilter extends QueryFilter
{
    /**
     * @var TaskRepositoryContract
     */
    private readonly TaskRepositoryContract $taskRepository;

    /**
     * @param  Request|null  $request
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);

        $this->taskRepository = App::make(TaskRepositoryContract::class);
    }

    /**
     * @param  string  $status
     *
     * @return void
     */
    public function status(string $status): void
    {
        $this->builder->where('status', strtolower($status));
    }

    /**
     * @param  string  $text
     *
     * @return void
     */
    public function search(string $text): void
    {
        $ids = $this->taskRepository->search($text, $this->page, $this->perPage);

        $this->builder->whereIn('id', $ids);
    }

    /**
     * @param  int  $priority
     *
     * @return void
     */
    public function priorityAfter(int $priority): void
    {
        $this->builder->where('priority','>=', $priority);
    }

    /**
     * @param  int  $priority
     *
     * @return void
     */
    public function priorityBefore(int $priority): void
    {
        $this->builder->where('priority','<=', $priority);
    }

    /**
     * @param  string  $sortBy
     * @param  string  $order
     *
     * @return void
     */
    public function sortBy(string $sortBy, string $order = 'asc'): void
    {
        $this->builder->orderBy($sortBy, $order);
    }

    /**
     * @param  Builder|null  $builder
     * @param  array  $data
     *
     * @return Builder
     */
    public function getQuery(Builder $builder = null, array $data = []): Builder
    {
        $this->builder = $builder ?: Task::query();

        if (isset($this->request)) {
            $data          = $this->request->all();
            $this->page    = ((int) $this->request->get('page')) ?: $this->page;
            $this->perPage = ((int) $this->request->get('per_page')) ?: $this->perPage;
        }

        foreach ($data as $field => $value) {
            $method = Str::camel($field);
            if (method_exists($this, $method)) {
                call_user_func_array([$this, $method], (array) $value);
            }
        }

        $sql = $this->builder->toSql();

        return $this->builder;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }
}
