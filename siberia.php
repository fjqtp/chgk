<!DOCTYPE html>
<html lang="en">
<head>
    <title>Весна 2019</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="shortcut icon" type="image/x-icon"
          href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACMAAAAjCAYAAAAe2bNZAAACBklEQVRYR+3XS6iNURQH8N9NckMxUTLRvchASpQZJY/uvVOJgfKceEWkSIwoM4qUrlcREQkDRJQkiZIpSQwQA4/ySKFV+9y2zzk653Ru96pvj85ee621/2ut/17rfG0G0WobRFiUYGpVo8xMmZlGX2rJmZIzJWcazcB/y5kRGNqqaOvw8xOfQq/YZzZhXx0OWq1yFT05mHa8xuhW31SHv+9oz8EswZlkuBof0++p2IU9eJw5Dv2FWIt3mXwLxmJrJov9ARzFtUzehVX4C8xNzMVdzMoM5uEGuguOdmMHOvAi0z+PiZiWyWL/FBtwMJOvTyD/ANOJZ4lDK3BiIMFUovycUvxloMAMwUuMw2lsLBBuNi5gMW5lZ9uxGdPxKpMfS6Wbk8milA+wLfGmchR82ZtzZgGu18H4/lTp40z+ivrzwn/5LsHUyk7NzARZYyR8w7BEsLzvNFrKr6lpRv+KVxqE349RmaOqYK7gFI5jeHpli3AIMxpFgV+pkS7FymR/MQV7G/GSY/WBiagrB/NxKQGp3H0vRXKuCTDR1XtxtmAbnTg6ek8RTOwnpMNHiMvz9R4xQx42AeZkym6MjXwdwQ+sScIYJx3FvxAj8RxjMstI6zJMaQLMB0zC5YLtcjzB+FTK+3hb7btpZuLIZNxJU/VNE0Byk5j669LsO4yd1fyVH3G1svwbAWB3JCKLL60AAAAASUVORK5CYII=">

    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif
        }

        a {
            color: inherit;
            user-select: none;
        }
        table td {
            padding: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="page-header">
         <h3><strong>Сибирь</strong></h3>
    </div>
    <div>
        <?php
            $tournament_id = (int)$_GET['tournament_id'];
            if ($tournament_id){
                $regions = [
                    7,
                    8,
                    50,
                    60,
                    70,
                    98,
                    107,
                    109,
                    144,
                    146,
                    152,
                    9,
                    22,
                    39,
                    42,
                    56,
                    79,
                    118,
                    166,
                    130,
                    151,
                    163
                ];

                $results = [];
                foreach ($regions as $region_id){
                    $f = curl_init("https://prestable.rating.chgk.net/api/tournaments/{$tournament_id}/list/region/{$region_id}.json");
                    curl_setopt_array($f, [
                        CURLOPT_RETURNTRANSFER  => true
                    ]);
                    $json = curl_exec($f);
                    curl_close($f);

                    $res = json_decode($json, true);
                    foreach ($res as $team){
                        $results[] = [
                            'name'  => $team['current_name'] == $team['base_name'] ? $team['current_name'] : "{$team['current_name']} ({$team['base_name']})",
                            'total' => $team['questions_total'],
                            'mask'  => str_split($team['mask'])
                        ];
                    }
                }

                usort($results, function(array $element1, array $element2){
                    //reverse sorting
                    return ($element1['total'] <=> $element2['total']) * -1;
                });

                echo '<table>';
                foreach ($results as $result){
                    echo '<tr>';
                    echo "<td>{$result['name']}</td>";
                    echo "<td>{$result['total']}</td>";
                    foreach ($result['mask'] as $question){
                        echo "<td>{$question}</td>";
                    }
                    echo '</tr>';
                }

                echo '</table>';

            }
        ?>
    </div>
</div>
</body>
</html>



