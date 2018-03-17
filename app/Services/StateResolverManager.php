<?php

namespace App\Services;

class StateResolverManager implements StateResolverManagerInterface
{
    /**
     * @var IoBrokerStateResolverInterface[]
     */
    private $resolvers = [];

    /**
     * {@inheritdoc}
     */
    public function addResolver(IoBrokerStateResolverInterface $resolver)
    {
        if (!in_array($resolver, $this->resolvers, true)) {
            $this->resolvers[] = $resolver;
            usort($this->resolvers, function (IoBrokerStateResolverInterface $a, IoBrokerStateResolverInterface $b) {
                if ($a->getPriority() === $b->getPriority())  {
                    return 0;
                }

                return $a->getPriority() < $b->getPriority() ? -1 : 1;
            });
        }
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(array $states): array
    {
        $results = [];
        foreach ($this->resolvers as $resolver) {
            if (count($states)) {
                $resolved = $resolver->resolve($states);
                $results = array_merge($results, $resolved->getResolved());
                $states = $resolved->getUnresolved();
            }
        }

        return $results;
    }
}
