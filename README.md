# AdventOfCode2025

Running the container and puzzle for each day.

You can omit the part in the command which will execute both parts of the puzzle.

```
docker compose up -d
docker exec -it adventofcode2025-php-1 php bin/console puzzle --day 01
docker exec -it adventofcode2025-php-1 php bin/console puzzle --day 01 --part 2
```

For more complex solutions, like day 8, you may need to bump the memory limit

```
docker exec -it adventofcode2025-php-1 php -d memory_limit=-1 bin/console puzzle --day 08
```
