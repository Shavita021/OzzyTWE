<?php
/* Program name: form_date.inc
* Description: Code displays a selection list that
*
customers can use to select a date.
*/
echo "<html><head><title>Select a date</title></head><body>";
$monthName = array(1 => "January", "February", "March",
"April", "May", "June", "July","August", "September", "October","November", "December");
$today = time();
//stores today’s date
$f_today = date("M-d-Y",$today);
//formats today’s date
echo "<div style = ‘text-align: center’>\n";
echo "<h3>Today is $f_today</h3><hr />\n";
echo "<form action='test.php' method=’POST’>\n";
/* build selection list for the month */
$todayMO = date("n",$today); //get the month from $today
echo "<select name='dateMonth'>\n";
for ($n=1;$n<=12;$n++)
{
echo " <option value=$n";
if ($todayMO == $n)
{
echo " selected";
}
echo " > $monthName[$n]\n</option>";
}
echo "</select>\n";
/* build selection list for the day */
$todayDay= date("d",$today);
//get the day from $today
echo "<select name='dateDay'>\n";
for ($n=1;$n<=31;$n++)
{
echo " <option value=$n";
if ($todayDay == $n )
{
echo " selected";
}
echo " > $n</option>\n";
}

echo "</select>\n";
/* build selection list for the year */
$startYr = date("Y", $today); //get the year from $today
echo "<select name='dateYear'>\n";
for ($n=$startYr;$n<=$startYr+3;$n++)
{
	echo " <option value=$n";
	if ($startYr == $n )
	{
	echo " selected";
}
echo " > $n</option>\n";
}
echo "</select>\n";
echo "</form></div>\n";
?>
</body></html>
