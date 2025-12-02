# AdventOfCode2025

Running the container and puzzle for each day.

You can omit the part in the command which will execute both parts of the puzzle.

```
docker compose up -d
docker exec -it adventofcode2025-php-1 php bin/console puzzle --day 01
docker exec -it adventofcode2025-php-1 php bin/console puzzle --day 01 --part 2
```
