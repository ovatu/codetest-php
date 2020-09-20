<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <title><?php echo $this->pageTitle; ?></title>
    </head>
    <body>
        <table>
        <thead>
                <tr>
                    <th>Beer</th>
                    <th>Style</th>
                    <th>Hops</th>
                    <th>Yeasts</th>
                    <th>Malts</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($beers as $beer) { ?>
                    <tr>
                        <td><?php echo $beer->name; ?></td>
                        <td><?php if ($beer->style) echo $beer->style->name; ?></td>
                        <td>
                            <?php foreach ($beer->hops as $hop) { ?>
                                <?php echo $hop->name; ?>,
                            <?php } ?>
                        </td>
                        <td>
                            <?php foreach ($beer->yeasts as $yeast) { ?>
                                <?php echo $yeast->name; ?>,
                            <?php } ?>
                        </td>
                        <td>
                            <?php foreach ($beer->malts as $malt) { ?>
                                <?php echo $malt->name; ?>,
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </body>
</html>