<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <title><?php echo $this->pageTitle; ?></title>
    </head>
    <body>
	<form method="post">
<label for="Name">Name:</label><br>
<input type="text" id="name" name="name" value= '<?php echo $name ?>'><br>
<label for="Style">Style:</label><br>
<select name="style" id="style">
<?php foreach($styles as $s){
	$id = $s->styleId;
	$n = $s->name;
?>  
	<option value='<?php echo $id; ?>' <?php if($id==$style) { echo " selected";} ?>><?php echo $n; ?></option>
<?php
	}
?>
</select>
<input type="submit" value="Add">
</form>


<?php echo "$message"; ?>
    </body>
</html>
