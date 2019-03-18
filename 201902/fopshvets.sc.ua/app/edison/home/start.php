<?

	if (empty($_COOKIE['user']) ) 
	{
		header('Location: http://polza.com/app/edison');
		die();
	}

?>

<div class="container">
<!-- <h1>Навигация</h1> -->


<div class="grid-padded">
				<div class="grid">

					

					<div class="col">
						<p class="sub-header" style="font-size: 18px;padding-left: 5px;color: grey;">Управление</p>
						<ul style="padding-left:0px;">
							<li class="item ajax btn" onclick="aajax('database/article-list', 0)" >🗄 &nbsp; &nbsp;База знаний</li>
							<li class="item ajax btn" onclick="aajax('control/page-list', 0)">🖥 &nbsp; &nbsp;Страницы</li>
							<li class="item ajax btn" onclick="aajax('control/funnelitems-list', 0)">🔩 &nbsp; &nbsp;Елементы воронки</li>
							<li class="item ajax btn" onclick="aajax('control/client-search', 0)">👥 &nbsp; &nbsp;Пользователи</li>
							<li class="item ajax btn" onclick="aajax('control/bot-list', 0)">🤖 &nbsp; &nbsp;Боты</li>
							
							<!-- <li class="notactive">Пользователи</li> -->
							<!-- <li onclick="aajax('control/vk-foodhacking', 0)">ВК Фудхакинг</li> -->
							<!-- <li class="notactive">Счета</li> -->
							<ul>
								<!-- <li class="notactive">– Новый</li> -->
							</ul>
						</ul>
					</div>
					<div class="col">
						<p class="sub-header" style="font-size: 18px;padding-left: 5px;color: grey;">Аналитика</p>
						<ul style="padding-left:0px;">
							<!-- <li onclick="aajax('metrics/dashboard', 0)">Дашборды</li> -->
								<!-- <ul>
									<li onclick="aajax('metrics/dashboard', 'fsd_3')">– ФСД-3</li>
									<li onclick="aajax('metrics/dashboard', 'code_deneg')">– Код Денег</li>
									<li onclick="aajax('metrics/dashboard', 'web_online')">– Вебинар 17</li>
								</ul> -->
							<li class="item ajax btn" onclick="aajax('metrics/product-list', 0)">🎓 &nbsp; &nbsp;События в курсах</li>
							<li class="item ajax btn" onclick="aajax('metrics/rates-list', 1)">📝 &nbsp; &nbsp;Отчеты в курсах</li>
							<li class="item ajax btn" onclick="aajax('metrics/system-list', 0)">📡 &nbsp; &nbsp;Все события</li>
							<li class="item ajax btn" onclick="aajax('metrics/system-report', 0)">📊 &nbsp; &nbsp;Состояние работы</li>
							<li class="item ajax btn" onclick="aajax('metrics/user_search', 0)">👁 &nbsp; &nbsp;Большой брат</li>
						</ul>
					</div>
					<div class="col">
						<p class="sub-header" style="font-size: 18px;padding-left: 5px;color: grey;">Финансы</p>
						<ul style="padding-left:0px;">
							<li class="item ajax btn" onclick="aajax('finance/balance', 0)">💰 &nbsp; &nbsp;Баланс</li>
							<li class="item ajax btn" onclick="aajax('finance/payments', 0)">🗃 &nbsp; &nbsp;Все платежи</li>
							<li class="item ajax btn" onclick="aajax('finance/affilate-payments', 1)">📈 &nbsp; &nbsp;Партнерские платежи</li>
							<li class="item ajax btn" onclick="aajax('finance/invoice', 0)">💸 &nbsp; &nbsp;Выставить счет</li>
							<li class="item ajax btn" onclick="aajax('finance/config-list', 0)">🏦 &nbsp; &nbsp;Фин. системы</li>
						</ul>
					</div>
				</div>
			</div>


</div>

<style type="text/css">
	.btn{display: block;margin-bottom: 10px;}
</style>