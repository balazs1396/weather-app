
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
                <th>Country</th>
                <th>Zip</th>
                <th>City</th>
                <th>Longitude</th>
                <th>Latitude</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cities as $city) { ?>
                <tr>
                    <td><?php echo $city['country'] ?></td>
                    <td><?php echo $city['zip'] ?></td>
                    <td><?php echo $city['city'] ?></td>
                    <td><?php echo $city['longitude'] ?></td>
                    <td><?php echo $city['latitude'] ?></td>
                </tr>
            <?php }  ?>
            </tbody>
        </table>

    </body>
</html>
