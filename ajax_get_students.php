<?php
$dom = new DOMDocument("1.0");
$node = $dom->createElement("students");
$parnode = $dom->appendChild($node);
header("Content-type: text/xml");
$connection = new mysqli("localhost","root","","kidsapp");
$sql = "select name, surname
        from student";
if (!($stmt=$connection->prepare($sql))) {
    echo "Prepare failed: (" . $connection->errno . ") " . $connection->error;
}
$stmt->execute();
$stmt->bind_result(
       $name, $surname            
);
while($stmt->fetch()) {
    $node = $dom->createElement("student");
    $newnode = $parnode->appendChild($node);
    $newnode->setAttribute("name", $name);
    $newnode->setAttribute("surname", $surname);
}
$stmt->close();
$connection->close();      
echo $dom->saveXML();
?>
