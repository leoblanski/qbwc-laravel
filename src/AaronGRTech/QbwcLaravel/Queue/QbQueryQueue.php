<?php

namespace AaronGRTech\QbwcLaravel\Queue;

class QbQueryQueue
{
    protected $queries = [];

    public function __construct()
    {
        $this->loadQueriesFromConfig();
    }

    protected function loadQueriesFromConfig()
    {
        $configuredQueries = config('qbwc.queue.queries', []);
        foreach ($configuredQueries as $queryConfig) {
            $this->addQuery(new $queryConfig['class']($queryConfig['params']));
        }
    }

    public function addQuery($query)
    {
        $this->queries[] = $query;
    }

    public function popQuery()
    {
        return array_shift($this->queries);
    }

    public function hasQueries()
    {
        return !empty($this->queries);
    }

    public function queriesLeft()
    {
        return count($this->queries);
    }
}
