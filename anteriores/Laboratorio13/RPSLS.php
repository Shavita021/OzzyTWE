<?php 

$Human=$_GET["user"];
$computadora = rand (1, 5);

	switch($computadora)
	{
	case 1: echo "rock";
	break;
	case 2: echo "paper" ;
	break;
	case 3: echo"scissors";
	break;
	case 4: echo "lizard";
	break;
	case 5: echo"spock";
	break;
	}

if ($Human==1){
	switch($computadora)
	{
	case 1: echo "-0-Its a tie!";
	break;
	case 2: echo "-2-Paper covers rock";
	break;
	case 3: echo "-1-Rock crushes scissors";
	break;
	case 4: echo "-1-Rock crushes lizard";
	break;
	case 5: echo "-2-Spock vaporizes rock" ;
	break;
	}
}
else if($Human==2){
	switch($computadora)
	{
	case 1: echo"-1-Paper covers rock";
	break;
	case 2: echo"-0-Its a tie!";
	break;
	case 3: echo"-2-Scissors cuts paper";
	break;
	case 4: echo"-2-Lizard eats paper";
	break;
	case 5: echo "-1-Paper disproves Spock";
	break;
	}
}
else if($Human==3){
	switch($computadora)
	{
	case 1: echo "-2-Rock crushes scissors";
	break;
	case 2: echo "-1-Scissors cuts paper";
	break;
	case 3: echo "-0-Its a tie!";
	break;
	case 4: echo "-1-Scissors decapitates lizard";
	break;
	case 5: echo "-2-Spock smashes scissors";
	break;
	}
}
else if($Human==4){
	switch($computadora)
	{
	case 1: echo "-2-Rock crushes lizard";
	break;
	case 2: echo "-1-Lizard eats paper";
	break;
	case 3: echo "-2-Scissors decapitates lizard";
	break;
	case 4: echo "-0-Its a tie!";
	break;
	case 5: echo "-1-Lizard poisons Spock";
	break;
	}
}
else if($Human==5){
	switch($computadora)
	{
	case 1: echo "-1-Spock vaporizes rock" ;
	break;
	case 2: echo "-2-Paper disproves Spock" ;
	break;
	case 3: echo "-1-Spock smashes scissors" ;
	break;
	case 4: echo "-2-Lizard poisons Spock" ;
	break;
	case 5: echo "-0-Its a tie!" ;
	break;
	}
}
else echo "Nope." ;

?>