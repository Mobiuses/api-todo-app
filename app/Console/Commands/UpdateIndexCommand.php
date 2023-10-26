<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Modules\Core\ORM\Repositories\Contracts\TaskRepositoryContract;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Illuminate\Console\Command;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class UpdateIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:update-index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Tasks index in Elasticsearch';

    /**
     * Execute the console command.
     */
    public function handle(Client $elasticsearch, TaskRepositoryContract $taskRepository)
    {
        $this->info('Updating index. This might take a while...');

        $ids = $taskRepository->getAllIdsFromElastic();
        dd($ids);
        $updated = 0;
        foreach (Task::whereNotIn('id', $ids)->cursor() as $task) {
            $elasticsearch->index([
                'index' => Task::getSearchIndexStatic(),
                'type'  => $task->getSearchType(),
                'id'    => $task->getKey(),
                'body'  => $task->toSearchArray(),
            ]);
            $this->output->write('.');
            $updated++;
        }

        $this->info(PHP_EOL . 'Added rows: ' . $updated);
        $this->info('Done!');
    }

    /**
     * @param  Client  $elasticsearch
     *
     * @return void
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    private function deleteOldIndex(Client $elasticsearch): void
    {
        $this->info('Check if index exists...');

        $params = ['index' => Task::getSearchIndexStatic()];
        $response = $elasticsearch->indices()->exists($params);
        /** @var Elasticsearch $response */
        if (Response::HTTP_OK === $response->getStatusCode()) {
            $this->info('Deleting index...');

            $response = $elasticsearch->indices()->delete($params);

            if (Response::HTTP_OK !== $response->getStatusCode()) {
                dd($response);
            }

            $this->info('Deleted successfully!');
        }

        $this->info('Index doesn\'t exist...');
    }

    /**
     * @param  Client  $client
     *
     * @return void
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    private function createNewIndex(Client $client): void
    {
        $this->info('Creating new index...');

        $params = [
            'index' => Task::getSearchIndexStatic()
        ];

        $response = $client->indices()->create($params);

        if (Response::HTTP_OK !== $response->getStatusCode()) {
            dd($response);
        }

        $this->info('Created successfully!');
    }
}
