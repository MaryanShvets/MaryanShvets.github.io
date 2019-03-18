<?

	// Отображение ошибок (1 – показывать, 0 – скрывать)
	ini_set('display_errors', 0);

	class Telegram {

		// Этот режим отправляет сообщение на всех, ко указан в списке получателей
		function say($t){

			// Такие эмоджи мы используем
			// ✅ заявка
			// 📬 подписка
			// 💰 оплата или предоплата

			// Токен бота
			$botToken = "290789282:AAFGGv9AFqh4TVYh6I36zjHTcqG68UXNPfQ";
			$website = "https://api.telegram.org/bot".$botToken;

			// Список получателей
			// Номер чата можно получить отправив любое сообщение боту
			// И через функцию getUpdates прочесть его
			// Где брать функцию ищи в документации Telegram
			$chats = array(
					array('name'=>'Виктор', 'id'=>'95557762'),
					array('name'=>'Кир', 'id'=>'71468462')
				);

			// Отправляем сообщеие каждому с получаетелей
			// foreach ($chats as $key => $value) {
			// 	$chat_id = $value['id'];
			// 	file_get_contents($website."/sendmessage?chat_id=".$chat_id."&text=".$t.'&parse_mode=markdown');
			// }

			$token = 'xoxp-3571134136-155894242546-162821923761-0e482cad18ca5fc86532325509a784e5';

			$text_slack = str_replace (' ','%20', $t);
			$url = 'https://slack.com/api/chat.postMessage?token='.$token.'&channel=reports_all&text='.$text_slack;

			file_get_contents($url);
		}
		// Этот режим отправляет сообщение только на админа
		function say_test($t){

			// Токен бота
			$botToken = "236375979:AAHC4W5jL2EuZzlFNGtwAdR0-V_pCcBS0jo";
			$website = "https://api.telegram.org/bot".$botToken;

			// Перед каждым сообщение добавляется эмоджи
			$tp = '🛠 '.$t;

			// Получатель один. Можно поставить, сколько нужно.
			// Как получить номер чата смотри сверху
			$chats = array(
					array('name'=>'Виктор', 'id'=>'95557762')
				);

			// Отправляем сообщеие каждому с получаетелей
			// foreach ($chats as $key => $value) {
			// 	$chat_id = $value['id'];
			// 	file_get_contents($website."/sendmessage?chat_id=".$chat_id."&text=".$tp.'&parse_mode=markdown');
			// }

			$token = 'xoxp-3571134136-155894242546-162821923761-0e482cad18ca5fc86532325509a784e5';

			$text_slack = str_replace (' ','%20', $t);
			$url = 'https://slack.com/api/chat.postMessage?token='.$token.'&channel=reports_debug&text='.$text_slack;

			file_get_contents($url);
		}
		// Этот режим отправляет сообщение только на админа
		function say_pers($n,$t){

			$n = '@'.$n;

			$token = 'xoxp-3571134136-155894242546-162821923761-0e482cad18ca5fc86532325509a784e5';

			$text_slack = str_replace (' ','%20', $t);
			$url = 'https://slack.com/api/chat.postMessage?token='.$token.'&channel='.$n.'&text='.$text_slack;

			file_get_contents($url);
		}
	}

?>