<?php

namespace App\Modules\Core\ORM\Traits;

use App\Modules\Core\ORM\Observers\ElasticSearchObserver;

trait Searchable
{
    /**
     * @return void
     */
    public static function bootSearchable(): void
    {
        if (config('services.search.enabled')) {
            static::observe(ElasticSearchObserver::class);
        }
    }

    /**
     * @return mixed
     */
    public function getSearchIndex()
    {
        return static::getSearchIndexStatic();
    }

    /**
     * @return mixed
     */
    public function getSearchType()
    {
        if (property_exists($this, 'useSearchType')) {
            return $this->useSearchType;
        }
        return $this->getTable();
    }

    /**
     * @return array
     */
    public function toSearchArray(): array
    {
        if (method_exists($this, 'toSearchIndex')) {
            return $this->toSearchIndex();
        }

        return $this->toArray();
    }
}
