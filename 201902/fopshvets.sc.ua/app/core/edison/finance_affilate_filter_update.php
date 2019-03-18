<?

if (!empty($_POST['partner_id'])) 
{
	setcookie('filter_affilatepayment', $_POST['partner_id'],time()+36000, '/');
}
else
{
	setcookie('filter_affilatepayment', '0',time()+10, '/');
}

?>