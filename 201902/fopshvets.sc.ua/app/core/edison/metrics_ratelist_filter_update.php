<?

if (!empty($_POST['filter_rates_student'])) 
{
	setcookie('filter_rates_student', $_POST['filter_rates_student'],time()+36000, '/');
}
else
{
	setcookie('filter_rates_student', '0',time()+10, '/');
}

if (!empty($_POST['filter_rates_course']) || $_POST['filter_rates_course'] !== '0') 
{
	setcookie('filter_rates_course', $_POST['filter_rates_course'],time()+36000, '/');
}
else
{
	setcookie('filter_rates_course', '0',time()+10, '/');
}

?>