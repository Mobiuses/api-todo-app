<?php

namespace App\Console\Commands;

use App\Models\Task;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Illuminate\Console\Command;
use Illuminate\Http\Response;

class ReindexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all Tasks to Elasticsearch';

    /**
     * Execute the console command.
     */
    public function handle(Client $elasticsearch)
    {
        $this->deleteOldIndex($elasticsearch);
        $this->createNewIndex($elasticsearch);

        $this->info('Indexing all Tasks. This might take a while...');

        foreach (Task::cursor() as $task) {
            $elasticsearch->index([
                'index' => Task::getSearchIndexStatic(),
                'type'  => $task->getSearchType(),
                'id'    => $task->getKey(),
                'body'  => $task->toSearchArray(),
            ]);
            $this->output->write('.');
        }
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
