# Elastic Finder

Elastic Finder is Domain driven Symfony app with Elasticsearch integration 🎉

## About

This project serves primarily as a task to validate and reinforce my skills in setting up Docker environments and Elasticsearch. It showcases practical applications and solutions, emphasizing hands-on experience and proficiency in these technologies.

## Features

- **Dockerized Environments**: Demonstrates the use of Docker for creating and managing isolated environments.
- **Elasticsearch Integration**: Implements Elasticsearch for efficient search capabilities and data management.
- **Practical Examples**: Contains practical examples and configurations to illustrate the integration of Docker and Elasticsearch.
- **Kibana ready**: The Kibana is included in compose.override.dist.yml

## Getting started

1. Set up configs: `.env.local`, `compose.override` (Aditionally, Uncomment kibana)
2. `docker-compose up -d`
3. Use `docker-compose exec php-fpm php bin/console` for migrations, fixtures
4. Sync indexes `docker-compose exec php-fpm php bin/console fos:elastica:populate` use `php -d memory_limit=-1` if need more memory


5. Pick between Elasticsearch or Doctrine pagination provider (services.yaml)
```yaml
    App\Movie\Domain\Provider\PaginationProviderInterface:
        alias: 'App\Movie\Infrastructure\Provider\ElasticsearchPaginationProvider'
    #   alias: 'App\Movie\Infrastructure\Provider\DoctrinePaginationProvider'
```

5. Try the implementation
```bash
curl --location 'localhost/api/movies?page=1&limit=3000&description=Thriller&title=Music&rating=5&releaseDate=1962-08-05'
```
```json
{
    "data": [
        {
            "id": [],
            "description": "Family Biography Crime Comedy Fantasy Western Musical Comedy Romance Thriller",
            "title": "Music Music",
            "rating": 5,
            "releaseDate": "1962-08-05T00:00:00+00:00",
            "domainEvents": []
        },
        ...
    ],
    "paginationData": {
        "total": 110,
        "limit": 3000,
        "currentPage": 1,
        "lastPage": 1
    }
}
