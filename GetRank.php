SELECT  uo.*,
    (
    SELECT  COUNT(*)
    FROM    Scores ui
    WHERE   (ui.score, -ui.ts) >= (uo.score, -uo.ts)
    ) AS rank
FROM    Scores uo
WHERE   name = '$name';
echo $row['rank']
