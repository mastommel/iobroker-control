<?php

namespace App\IoBroker\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class IoBrokerClient implements IoBrokerClientInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param string $host
     * @param string $port
     */
    public function __construct(string $host, string $port)
    {
        $this->client = new Client([
            'base_uri' => $host . ':' . $port
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getObjects(string $pattern): array
    {
        try {
            $response = $this->client->get('/objects', [
                'query' => ['pattern' => $pattern]
            ]);

            return json_decode((string) $response->getBody(), true);
        } catch (RequestException $exception) {
            Log::error('Exception while requesting /objects. Exception: ' . $exception);
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getStatesByPattern(string $pattern): array
    {
        try {
            $response = $this->client->get('/states', [
                'query' => ['pattern' => $pattern]
            ]);

            return json_decode((string) $response->getBody(), true);
        } catch (RequestException $exception) {
            Log::error('Exception while requesting /states. Exception: ' . $exception);
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getStatesById(array $ids): array
    {
        try {
            $response = $this->client->get('/getBulk/' . join(',', $ids));

            return json_decode((string) $response->getBody(), true);
        } catch (RequestException $exception) {
            Log::error('Exception while requesting /getBulk. Exception: ' . $exception);
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function setStates(array $keyValuePairs): bool
    {
        try {
            $this->client->get('/setBulk', [
                'query' => $keyValuePairs
            ]);

            return true;
        } catch (RequestException $exception) {
            Log::error('Exception while requesting /setBulk. Exception: ' . $exception);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function toggle(string $stateId): bool
    {
        try {
            $this->client->get('/setBulk/' . $stateId);

            return true;
        } catch (RequestException $exception) {
            Log::error('Exception while requesting /toggle. Exception: ' . $exception);
        }

        return false;
    }
}
