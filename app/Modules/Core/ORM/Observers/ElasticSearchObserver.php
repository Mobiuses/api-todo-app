<?php

namespace App\Modules\Core\ORM\Observers;

use App\Models\Task;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class ElasticSearchObserver
{
    /**
     * @param  Client  $elasticsearch
     */
    public function __construct(private Client $elasticsearch)
    {
    }

    /**
     * @param  Task  $model
     *
     * @return void
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function saved(Task $model): void
    {
        $this->elasticsearch->index([
            'index' => $model::getSearchIndexStatic(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
            'body' => $model->toSearchArray(),
        ]);
    }

    /**
     * @param  Task  $model
     *
     * @return void
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function deleted(Task $model): void
    {
        $this->elasticsearch->delete([
            'index' => $model::getSearchIndexStatic(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
        ]);
    }
}
