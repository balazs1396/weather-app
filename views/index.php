
<!DOCTYPE html>
<html lang="html">

    <head>
        <link rel="stylesheet" type="text/css" href="views/style/index.css">
        <title>Weather app</title>
    </head>

    <body>
        <table class="table">
            <thead><!DOCTYPE html>
            <tr>
                <th>City name</th>
                <th>Min temperature</th>
                <th>Max temperature</th>
                <th>Distance to the entered coordinates</th>
                <th>Weather description</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cities as $city) { ?>
                <tr>
                    <td><span><?php echo $city['city'] ?></span></td>
                    <td><span><?php echo $city['tempMin'] . '°'  ?></span></td>
                    <td><span><?php echo $city['tempMax'] . '°' ?></span></td>
                    <td><span><?php echo 'todo - distance' ?></span></td>
                    <td>
                        <div class="description">
                            <img src="<?php echo $city['iconUrl'] ?>">
                            <span><?php echo $city['description'] ?></span>
                        </div>

                    </td>
                </tr>
            <?php }  ?>
            </tbody>
        </table>

    </body>
</html>
