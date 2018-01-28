<?php

namespace App\Services\IoBrokerStateResolver;

use App\IoBroker\Client\IobrokerClientInterface;
use App\Transfers\ResolverResult;

class HttpStateResolver extends StateResolver
{
    /**
     * @var IoBrokerClientInterface
     */
    private $client;

    /**
     * @param IoBrokerClientInterface $client
     * @param int $priority
     */
    public function __construct(IoBrokerClientInterface $client, int $priority)
    {
        parent::__construct($priority);
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(array $states): ResolverResult
    {
        $results = $this->client->getStatesById($states);

        return $this->computeResults($states, $results);
    }

    /**
     * @param array $states
     * @param array $results
     *
     * @return ResolverResult
     */
    private function computeResults(array $states, array $results): ResolverResult
    {
        $result = new ResolverResult();

        if (count($states) === count($results)) {
            foreach ($results as $index => $data) {
                if (isset($data['val'])) {
                    $result->addResolved($states[$index], $data['val']);
                } else {
                    $result->addUnresolved($states[$index]);
                }
            }
        }

        return $result;
    }
}
