# Postgres Timescale support
Bowhead supports the Postgres Timescale (http://timescale.com) extension.

After you have installed Timescale and verify it is installed by running
```
SELECT * FROM pg_available_extensions where name ='timescaledb';
```
and you should see one row returned with timescaledb, if you do not see that then you may need to restart postgres.

Now:

Run
```
php artisan migrate:reset
php artisan migrate
```
and before you run the seeder, run the following in Postgres:
see how the configurator does this:
https://github.com/joeldg/bowhead/blob/master/app/Http/Controllers/Controller.php#L50-L66

Then to set up the initial data state for Bowhead
```
php artisan db:seed
```

---
## older junk
A query from the older tables...
USE:
```
SELECT 
sum(`return`)/100000000 AS `profit`
, strategy
, direction
, count(*) AS cnt
, count(CASE WHEN `return` < 0 THEN 1 END) AS neg
, count(CASE WHEN `return` > 0 THEN 1 END) AS pos  
FROM orca_turbo
WHERE pair IS NOT NULL
GROUP BY direction, strategy
ORDER BY `profit` DESC
```
