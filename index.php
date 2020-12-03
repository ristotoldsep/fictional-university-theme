<?php
$count = 0;

$names = array('Rico', 'Rainer', 'Rix', 'Renx', 'Sjemir', 'Madis');

function greet($name, $color){
    echo "<p>Hi! My name is $name and my favourite color is $color.</p>";
}

greet("Riho", "green");


?>

<h1><?php bloginfo("name");?></h1>
<p><?php bloginfo("description");?></p>

<p>Tsau, testin veel, nimeks mul <?php echo $names[1];?></p>

    <?php echo "<p>Prindin välja array</p>"; ?>
<?php while($count < count($names)) {
    
    echo "<li>$names[$count]</li>";
    $count++;
} ?>
