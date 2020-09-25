<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <title><?php echo $this->pageTitle; ?></title>
    </head>
    <body>
	<form>
<label for="Name">Name:</label><br>
<input type="text" id="name" name="name" value= '<?php echo $name ?>'><br>
<label for="Name">Style:</label><br>
<input type="text" id="style" name="style" value= '<?php echo $style ?>'><br>
<label for="Name">Hop:</label><br>
<input type="text" id="hop" name="hop" value= '<?php echo $hop ?>'><br>
<label for="Name">Yeast:</label><br>
<input type="text" id="yeast" name="yeast" value= '<?php echo $yeast ?>'><br>
<label for="Name">Malt:</label><br>
<input type="text" id="malt" name="malt" value= '<?php echo $malt ?>'><br>
<input type="submit" value="Submit">
</form>


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
                        <td><?php echo $beer['name']; ?></td>
                        <td><?php if ($beer['style']) echo $beer['style']; ?></td>
                        <td>
                            <?php foreach ($beer['hops'] as $h) { ?>
                                <?php echo $h; ?>,
                            <?php } ?>
                        </td>
                        <td>
                            <?php foreach ($beer['yeasts'] as $y) { ?>
                                <?php echo $y; ?>,
                            <?php } ?>
                        </td>
                        <td>
                            <?php foreach ($beer['malts'] as $m) { ?>
                                <?php echo $m; ?>,
                            <?php } ?>
                        </td>
                    </tr>
                <?php $lastBeerId = $beer['beerId']; } ?>
            </tbody>
        </table>
	<form>
<input type="hidden" id="lastBeerId" name="lastBeerId" value= '<?php echo $lastBeerId ?>'>
<input type="hidden" id="name" name="name" value= '<?php echo $name ?>'>
<input type="hidden" id="style" name="style" value= '<?php echo $style ?>'>
<input type="hidden" id="hop" name="hop" value= '<?php echo $hop ?>'>
<input type="hidden" id="yeast" name="yeast" value= '<?php echo $yeast ?>'>
<input type="hidden" id="malt" name="malt" value= '<?php echo $malt ?>'>
<input type="submit" value="Next">
</form>
    </body>
</html>
