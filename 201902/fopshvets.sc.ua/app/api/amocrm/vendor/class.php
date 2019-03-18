<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Entity.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Company.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Contact.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Handler.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Lead.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Note.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Request.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Task.php');
    
function login($subdomain)
{
    // підключаємось до амо и витягуємо данні про контакт
    $subdomain = 'samoilov';

    $user = array(
        'USER_LOGIN' => 'victoriia.moskalenko@gmail.com', 
        'USER_HASH' => 'b60d7c54f5bee6dc0195c32acebb4cab' 
    );
                
    function AmoReturnError($code) {
      $code = (int)$code;
      $errors = array(
        301 => 'Moved permanently',
        400 => 'Bad request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not found',
        500 => 'Internal server error',
        502 => 'Bad gateway',
        503 => 'Service unavailable'
      );
      try {
        #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
        if ($code != 200 && $code != 204)
          throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
      } catch (Exception $E) {
        return 'Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode();
      }
      return false;
    }   
        
    $link = 'https://' . $subdomain . '.amocrm.ru/private/api/auth.php?type=json';
    $curl = curl_init(); #Сохраняем дескриптор сеанса cURL
    #Устанавливаем необходимые опции для сеанса cURL
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($user));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_COOKIEFILE, '/home/kirgkybv/public_html/polza.com/app/api/amocrm/config/cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEJAR, '/home/kirgkybv/public_html/polza.com/app/api/amocrm/config/cookie.txt');
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
      
    $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
    curl_close($curl); #Завершаем сеанс cURL
      
    $amoError = AmoReturnError($code);
    if ($amoError) {
      sendMessage($amoError,$post);
      return -1;
    }
        
    /**
     * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
     * нам придётся перевести ответ в формат, понятный PHP
     */
    $Response = json_decode($out, true);
    $Response = $Response['response'];
    return $Response;
}

function add_note($type_parent, $type_note, $note_from_amo, $parent_id)
{
    $api_amo = new Handler('samoilov', 'victoriia.moskalenko@gmail.com', true);
    /* Создаем заметку с сообщением из формы */
    $note = new Note();
    $note
        /* Привязка к созданной сделке*/
        ->setElementId($parent_id)
        /* Тип привязки (к сделке или к контакту). Смотрите комментарии в Note.php */
        //->setElementType(eval('Note::'.$type_parent))
        ->setElementType(($type_parent == 'TYPE_LEAD' ? Note::TYPE_LEAD : Note::TYPE_CONTACT))
        /* Тип заметки (здесь - обычная текстовая). Смотрите комментарии в Note.php */
        //->setNoteType(eval('Note::'.$type_note))
        ->setNoteType(($type_note == 'COMMON' ? Note::COMMON : Note::COMMON))
        /* Текст заметки*/
        ->setText($note_from_amo);

    $api_amo->request(new Request(Request::SET, $note));
}
function getCouse_lesons($id, $text)
{
    add_note(
        'TYPE_LEAD',
        'COMMON',
        $text,
        $id
    );
}
function amo_add_task($id, $product, $manager)
{
    // опредимяем на какое время ставить задачу
    $date_task = date("M-d-Y 9:30");
    $date = date("H");
    if ($date >= '00' && $date <= '08') 
    {
        $complete_till = strtotime($date_task);
    } 
    elseif ($date >= '18' && $date <= '23')
    {
        $date_task = strtotime($date_task);
        $complete_till = strtotime("+1 day", $date_task);
    } 
    elseif ($date >= '09' && $date <= '18')
    {
        $complete_till = strtotime("+30 minute");
    }

    $api_amo = new Handler('samoilov', 'victoriia.moskalenko@gmail.com', true);
    /* Создаем заметку с сообщением из формы */
    $task = new Task();
    $task
        ->setElementId($id)
        ->setElementType(('TYPE_LEAD' == 'TYPE_LEAD' ? Task::TYPE_LEAD : Task::TYPE_CONTACT))
        ->setTaskType(('CALL' == 'CALL' ? Task::CALL : Task::LETTER))
        ->setText('Еще раз подала заявку на '.$product)
        ->setResponsibleUserId($manager)
        ->setCompleteTill($complete_till);

    $api_amo->request(new Request(Request::SET, $task));
}

function amo_add_task_pay_translation($id, $text, $manager)
{
    // опредимяем на какое время ставить задачу
    $date_task = date("M-d-Y 9:30");
    $date = date("H");
    if ($date >= '00' && $date <= '08') 
    {
        $complete_till = strtotime($date_task);
    } 
    elseif ($date >= '18' && $date <= '23')
    {
        $date_task = strtotime($date_task);
        $complete_till = strtotime("+1 day", $date_task);
    } 
    elseif ($date >= '09' && $date <= '18')
    {
        $complete_till = strtotime("+30 minute");
    }

    $api_amo = new Handler('samoilov', 'victoriia.moskalenko@gmail.com', true);
    /* Создаем заметку с сообщением из формы */
    $task = new Task();
    $task
        ->setElementId($id)
        ->setElementType(('TYPE_LEAD' == 'TYPE_LEAD' ? Task::TYPE_LEAD : Task::TYPE_CONTACT))
        ->setTaskType(('CALL' == 'CALL' ? Task::CALL : Task::LETTER))
        ->setText($text)
        ->setResponsibleUserId($manager)
        ->setCompleteTill($complete_till);

    $api_amo->request(new Request(Request::SET, $task));
}


function amo_add_task_pay($id, $product, $manager)
{
    // опредимяем на какое время ставить задачу
    $date_task = date("M-d-Y 9:30");
    $date = date("H");
    if ($date >= '00' && $date <= '08') 
    {
        $complete_till = strtotime($date_task);
    } 
    elseif ($date >= '18' && $date <= '23')
    {
        $date_task = strtotime($date_task);
        $complete_till = strtotime("+1 day", $date_task);
    } 
    elseif ($date >= '09' && $date <= '18')
    {
        $complete_till = strtotime("+30 minute");
    }

    $api_amo = new Handler('samoilov', 'victoriia.moskalenko@gmail.com', true);
    /* Создаем заметку с сообщением из формы */
    $task = new Task();
    $task
        ->setElementId($id)
        ->setElementType(('TYPE_LEAD' == 'TYPE_LEAD' ? Task::TYPE_LEAD : Task::TYPE_CONTACT))
        ->setTaskType(('CALL' == 'CALL' ? Task::CALL : Task::LETTER))
        ->setText('Пришла вторая оплата, наверно берет подругу на '.$product)
        ->setResponsibleUserId($manager)
        ->setCompleteTill($complete_till);

    $api_amo->request(new Request(Request::SET, $task));
}

function amo_move_lead($id)
{

    $apiAMO = new Handler('samoilov', 'victoriia.moskalenko@gmail.com', true);

    $request_get_lead = new Request(Request::GET, ['id' => $id], ['leads', 'list']);
    $apiAMO->request($request_get_lead)->result;
    /* Если пользователя нет, вернется false, если есть - объект пользователя */
    $lead_exists = ($apiAMO->result) ? $apiAMO->result->leads[0] : false;

    /* Если такой пользователь уже есть - мержим поля */
    if ($lead_exists) {
        $lead = new Lead();
        $lead
            /* Указываем, что лид будет обновлен */
            ->setUpdate($lead_exists->id, $lead_exists->last_modified + 1)
            /* Ответственного менеджера оставляем кто был */
            ->setResponsibleUserId($lead_exists->responsible_user_id)
            ->setPrice($lead_exists->price)
            ->setName($lead_exists->name)
            ->setStatusId($apiAMO->config['LeadStatusFullPayed']);
    }
    $apiAMO->request(new Request(Request::SET, $lead));
}

function amo_add_lead($lead_from_landing)
{
    $api_amo = new Handler('samoilov', 'victoriia.moskalenko@gmail.com', true);
    /* Создаем сделку */
    $lead = new Lead();
    $lead
        ->setName($lead_from_landing['name'])
        ->setPrice($lead_from_landing['price'])
        ->setResponsibleUserId($api_amo->config['ResponsibleUserId'])
        ->setTags($lead_from_landing['tags'])
        ->setStatusId($api_amo->config['LeadStatusLead'])
        ->setCustomField(
            $api_amo->config['LeadFieldUTM'],
            $lead_from_landing['utm'] // UTM-метки
        )
        ->setCustomField(
            1276894,
            $lead_from_landing['metric']
        )
        ->setCustomField(
            1275886,
            $lead_from_landing['city'] // Город
        );

    /* Отправляем данные в AmoCRM */
    $api_amo->request(new Request(Request::SET, $lead));

    /* Сохраняем ID новой сделки для использования в дальнейшем */
    return $api_amo->last_insert_id;
}

function amo_fos_lead($lead_from_landing)
{
    $api_amo = new Handler('samoilov', 'victoriia.moskalenko@gmail.com', true);
    /* Создаем сделку */
    $lead = new Lead();
    $lead
        ->setName($lead_from_landing['name'])
        ->setPrice($lead_from_landing['price'])
        ->setResponsibleUserId($api_amo->config['ResponsibleUserId'])
        ->setTags($lead_from_landing['tags'])
        ->setStatusId($api_amo->config['LeadStatusLead'])
        ->setCustomField(
            $api_amo->config['LeadFieldUTM'],
            $lead_from_landing['utm'] // UTM-метки
        );

    /* Отправляем данные в AmoCRM */
    $api_amo->request(new Request(Request::SET, $lead));

    /* Сохраняем ID новой сделки для использования в дальнейшем */
    return $api_amo->last_insert_id;
}

function amo_add_contact($contact_from_landing, $lead_id)
{
    $api_amo = new Handler('samoilov', 'victoriia.moskalenko@gmail.com', true);
    /* Создаем контакт */
    $contact = new Contact();
    $contact
        ->setName($contact_from_landing['name'])
        ->setResponsibleUserId($api_amo->config['ResponsibleUserId'])
        ->setLinkedLeadsId($lead_id)
        ->setCustomField(
            $api_amo->config['ContactFieldPhone'],
            $contact_from_landing['phone'], // Номер телефона
            'MOB' // MOB - это ENUM для этого поля, список доступных значений смотрите в информации об аккаунте
        )
        ->setCustomField(
            $api_amo->config['ContactFieldEmail'],
            $contact_from_landing['email'], // Email
            'WORK' // WORK - это ENUM для этого поля, список доступных значений смотрите в информации об аккаунте
        );
        // ->setTags([$contact_from_landing['tags']]);

    /* Проверяем по емейлу, есть ли пользователь в нашей базе */
    $api_amo->request(new Request(Request::GET, ['query' => $contact_from_landing['email']], ['contacts', 'list']));

    /* Если пользователя нет, вернется false, если есть - объект пользователя */
    $contact_exists = ($api_amo->result) ? $api_amo->result->contacts[0] : false;

    /* Если такой контакт уже есть - мержим поля */
    if ($contact_exists) {
        $contact
            /* Указываем, что контакт будет обновлен */
            ->setUpdate($contact_exists->id, $contact_exists->last_modified + 1)
            /* Ответственного менеджера оставляем кто был */
            ->setResponsibleUserId($contact_exists->responsible_user_id)
            /* Старые привязанные сделки тоже сохраняем */
            ->setLinkedLeadsId($contact_exists->linked_leads_id)
        ;
        // теперь займемся примечанием - если уже были примечания, то сохраним их и добавим вместе с новым примечанием
        $api_amo_note = new Handler('samoilov', 'victoriia.moskalenko@gmail.com', true);
        $api_amo_note->request(
            new Request(Request::GET,
                [
                    'type' => 'contact',
                    'query' => $contact_from_landing['email'],
                    'element_id' => $contact_exists->id
                ],
                ['notes', 'list'])
        );
        // после того, как сделали запрос с поиском примечаний по текушему контакту, посмотрим что получили
        $note_exists = ($api_amo_note->result) ? $api_amo_note->result->notes[0] : false;
        // и обработаем, если что-то получили, отправив примечание с записанными старыми данными клиента
        if ($note_exists) {
            add_note(
                'TYPE_CONTACT',
                'COMMON',
                "Старое название контакта: ".$contact_exists->name."\n".
                "ID контакта: ".$contact_exists->id."\n".
                "Старое имя контакта: ".$contact_exists->name."\n".
                "Старый телефон контакта: ".$contact_exists->custom_fields[1]->values[0]->value."\n",
                $contact_exists->id
            );
        }
    }

    /* отправляем все это дело в AmoCRM */
    $api_amo->request(new Request(Request::SET, $contact));

    /* Сохраняем ID нового контакта для использования в дальнейшем */
    return $api_amo->last_insert_id;
}

?>