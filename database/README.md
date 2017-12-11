USE:

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
