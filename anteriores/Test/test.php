<html>
<body>


<?php
echo "<head><title>Form Fields</title></head><body>";
echo "<ol>";
foreach($_POST as $field => $value)
{
echo "<li> $field = $value</li>";
}
echo "</ol>";
?>

</body>
</html> 