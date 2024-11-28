<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Uid\Uuid;

class MovieFixtures extends Fixture
{
    private ObjectManager $manager;

    public function __construct()
    {
    }

    public function load(ObjectManager $manager): void
    {
        $time = microtime(true);

        $this->manager = $manager;
        $this->manager->getConnection()->executeStatement('TRUNCATE movie');

        echo 'Truncated in ' . (microtime(true) - $time) . PHP_EOL;

        $totalCount = 100000;
        $batchSize = 10000;

        if ($totalCount % $batchSize !== 0) {
            throw new \InvalidArgumentException('Total count must be divisible by batch size');
        }

        echo 'Creating batches...' . PHP_EOL;

        for ($i = 0; $i < $totalCount / $batchSize; $i++) {
            $batches[$i] = $this->createBatchSQL($batchSize);
        }

        echo 'Batches created in ' . (microtime(true) - $time) . PHP_EOL;


        echo 'Inserting batches...' . PHP_EOL;

        $this->manager->getConnection()->beginTransaction();
        for ($i = 0; $i < $totalCount / $batchSize; $i++) {
            $this->manager->getConnection()->executeStatement($batches[$i]);
            $this->manager->flush();
        }
        $this->manager->getConnection()->commit();

        echo 'Batches inserted in ' . (microtime(true) - $time) . PHP_EOL;
    }

    public function createBatchSQL(int $count): string
    {
        if ($count < 1) {
            throw new \InvalidArgumentException('Count must be greater than 0');
        }

        $sql = <<<SQL
                INSERT INTO movie (
                                   id, 
                                   title, 
                                   rating, 
                                   release_date,
                                   description
                                   ) VALUES
        SQL;

        $wordList = [
            'Adventure', 'Comedy', 'Drama', 'Horror', 'Thriller', 'Fantasy', 'Action', 'Romance', 'SciFi', 'Mystery',
            'Family', 'Animation', 'Documentary', 'Biography', 'Crime', 'History', 'War', 'Musical', 'Western', 'Music'
        ];

        $randomTitle = function ($wordCount = 3) use ($wordList) {
            $words = [];
            for ($i = 0; $i < $wordCount; $i++) {
                $words[] = $wordList[array_rand($wordList)];
            }
            return implode(' ', $words);
        };

        $generateRandomDate = function ($startDate = '1900-01-01', $endDate = 'now') {
            $startTimestamp = strtotime($startDate);
            $endTimestamp = strtotime($endDate);
            $randomTimestamp = mt_rand($startTimestamp, $endTimestamp);
            return date('Y-m-d H:i:s', $randomTimestamp);
        };

        for ($i = 0; $i < $count; $i++) {
            $ids[] = Uuid::v7()->toRfc4122();
            $titles[] = $randomTitle(2);
            $ratings[] = rand(1, 5);
            $releaseDates[] = $generateRandomDate('-100 years', 'now');
            $descriptions[] = $randomTitle(10);
        }

        $values = [];
        for ($i = 0; $i < $count; $i++) {
            $values[] = sprintf(
                <<<SQL
                ('%s', -- id
                 '%s', -- title
                  %d, -- rating
                 '%s', -- release_date
                 '%s' -- description
                )
            SQL,
                $ids[$i],
                str_replace('\'', '\'\'', $titles[$i]),
                $ratings[$i],
                $releaseDates[$i],
                $descriptions[$i]
            );
        }

        return $sql . implode(",\n", $values);
    }
}
