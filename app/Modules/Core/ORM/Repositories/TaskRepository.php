<?php

declare(strict_types=1);

namespace App\Modules\Core\ORM\Repositories;

use App\Models\Task;
use App\Modules\Api\Tasks\Filters\TaskFilter;
use App\Modules\Core\ORM\Repositories\Contracts\TaskRepositoryContract;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class TaskRepository implements TaskRepositoryContract
{

    /**
     * @param  Client  $elasticsearch
     */
    public function __construct(
        readonly private Client $elasticsearch
    ) {
    }

    /**
     * @param  int  $userId
     * @param  TaskFilter  $filter
     *
     * @return LengthAwarePaginator
     */
    public function getList(int $userId, TaskFilter $filter): LengthAwarePaginator
    {
        return $filter->getQuery()
                      ->where('user_id', $userId)
                      ->paginate(perPage: $filter->getPerPage(), page: $filter->getPage());
    }

    /**
     * @param  string  $query
     * @param  int  $page
     * @param  int  $perPage
     *
     * @return array
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function search(string $query, int $page, int $perPage): array
    {
        $model = new Task;

        $responseItems = $this->elasticsearch->search([
            'index' => $model::getSearchIndexStatic(),
            'type'  => $model->getSearchType(),
            'body'  => [
                'from'  => $page === 1 ? 0 : ($page - 1) * $perPage,
                'size'  => 1000,
                'query' => [
                    'multi_match' => [
                        'fields'    => ['title^5', 'description'],
                        'query'     => $query,
                        "fuzziness" => "AUTO",
                    ],
                ],
            ],
        ]);

        return $this->getIds($responseItems->asArray());
    }

    /**
     * @return array
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function getAllIdsFromElastic(): array
    {
        $model = new Task;

        $responseItems = $this->elasticsearch->search([
            'index' => $model::getSearchIndexStatic(),
            'type'  => $model->getSearchType(),
            'size'  => $this->getIndexCount(Task::getSearchIndexStatic()),
            'body'  => [
//                'query' => [
//                    'match_all' => new \stdClass(),
//                ],
            ],
        ]);

        return $this->getIds($responseItems->asArray());
    }

    /**
     * @param  array  $items
     *
     * @return Collection
     */
    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return Task::findMany($ids)
                   ->sortBy(function ($article) use ($ids) {
                       return array_search($article->getKey(), $ids);
                   });
    }

    /**
     * @param  array  $items
     *
     * @return array
     */
    private function getIds(array $items): array
    {
        return Arr::pluck($items['hits']['hits'], '_id');
    }

    /**
     * @param  string  $index
     *
     * @return int
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    private function getIndexCount(string $index): int
    {
        $responseItems = $this->elasticsearch->count(['index' => $index]);

        return $responseItems->asArray()['count'];
    }
}
