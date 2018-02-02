<?php

namespace App\Services\IoBrokerStateResolver;

use App\Events\IoBrokerStateFound;
use App\IoBroker\Client\IobrokerClientInterface;
use App\Transfers\ResolverResult;
use Illuminate\Events\Dispatcher;

class HttpStateResolver extends StateResolver
{
    /**
     * @var IoBrokerClientInterface
     */
    private $client;

    /**
     * @var Dispatcher
     */
    private $eventDispatcher;

    /**
     * @param IoBrokerClientInterface $client
     * @param Dispatcher $eventDispatcher
     * @param int $priority
     */
    public function __construct(IoBrokerClientInterface $client, Dispatcher $eventDispatcher, int $priority)
    {
        parent::__construct($priority);
        $this->client = $client;
        $this->eventDispatcher = $eventDispatcher;
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
                    $this->eventDispatcher->dispatch(new IoBrokerStateFound($states[$index], $data['val']));
                } else {
                    $result->addUnresolved($states[$index]);
                }
            }
        }

        return $result;
    }
}
