<?

	// Отображение ошибок (1 – показывать, 0 – скрывать)
	ini_set('display_errors', 0);

	class Slack {

		// Этот режим отправляет сообщение на всех, ко указан в списке получателей
		function say($t){

			// Такие эмоджи мы используем
			// ✅ заявка
			// 📬 подписка
			// 💰 оплата или предоплата

			// Токен бота
			$botToken = "290789282:AAFGGv9AFqh4TVYh6I36zjHTcqG68UXNPfQ";
			$website = "https://api.telegram.org/bot".$botToken;


			$token = 'xoxp-3571134136-155894242546-162821923761-0e482cad18ca5fc86532325509a784e5';

			$text_slack = str_replace (' ','%20', $t);
			$url = 'https://slack.com/api/chat.postMessage?token='.$token.'&channel=reports_all&text='.$text_slack;

			file_get_contents($url);
		}
		// Этот режим отправляет сообщение только на админа
		function say_test($t){

			$token = 'xoxp-3571134136-155894242546-162821923761-0e482cad18ca5fc86532325509a784e5';

			$text_slack = str_replace (' ','%20', $t);
			$url = 'https://slack.com/api/chat.postMessage?token='.$token.'&channel=reports_debug&text='.$text_slack;

			file_get_contents($url);
		}
		// Этот режим отправляет сообщение только на админа
		function say_general($t){

			$token = 'xoxp-3571134136-155894242546-162821923761-0e482cad18ca5fc86532325509a784e5';

			$text_slack = str_replace (' ','%20', $t);
			$url = 'https://slack.com/api/chat.postMessage?token='.$token.'&channel=1general&text='.$text_slack;

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