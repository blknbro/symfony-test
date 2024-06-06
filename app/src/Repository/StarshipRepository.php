<?php

namespace App\Repository;

use App\Model\Starship;
use App\Model\StarshipStatusEnum;
use Psr\Log\LoggerInterface;

class StarshipRepository
{

    public function __construct(private LoggerInterface $logger)
    {

    }

    public function findAll(): array
    {
        $this->logger->info('Starship');

        return [
            new Starship(1, 'USS LeafyCruiser (NCC-0001)', 'Garden', 'Jean-Luc Pickles', StarshipStatusEnum::COMPLETED),
            new Starship(2, 'USS Leavfy (NCC-0021)', 'Garden', 'Jean Pierre', StarshipStatusEnum::IN_PROGRESS),
            new Starship(3, 'USS Leafy (NCC-0201)', 'Garden', 'John Doe', StarshipStatusEnum::WAITING),
        ];
    }

    public function find(int $id) : ?Starship
    {
        foreach ($this->findAll() as $starship){
            if($starship->getId() === $id)
                return $starship;
        }

        return null;

    }

}