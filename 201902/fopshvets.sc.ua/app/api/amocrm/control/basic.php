<?

ini_set('display_errors', 0);
ini_set('date.timezone', 'Europe/Kiev');

include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Entity.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Company.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Contact.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Handler.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Lead.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Note.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Request.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Task.php');

function amo_add_lead($name, $phone, $email, $lead_name, $tags, $budget, $utm){
	
	$api = new Handler('samoilov', 'info.polza.com@gmail.com');

    /* Создаем сделку,
    $api->config содержит в себе массив конфига,
    который вы создавали в начале */
    $lead = new Lead();
    $lead
        /* Название сделки */
        ->setName($lead_name) 
        ->setPrice($budget)
        ->setCustomField(
            $api->config['LeadFieldUTM'],
            $utm // UTM-метки
        )
        /* Назначаем ответственного менеджера */
        ->setResponsibleUserId($api->config['ResponsibleUserId'])
        /* Кастомное поле */
        ->setCustomField(
            $api->config['LeadFieldCustom'], // ID поля
            $api->config['LeadFieldCustomValue1'] // ID значения поля
        )
        /* Теги. Строка - если один тег, массив - если несколько */
        ->setTags($tags)
        /* Статус сделки */
        ->setStatusId($api->config['LeadStatusId']);

    /* Отправляем данные в AmoCRM
    В случае успешного добавления в результате
    будет объект новой сделки */
    $api->request(new Request(Request::SET, $lead));

    /* Сохраняем ID новой сделки для использования в дальнейшем */
    $lead = $api->last_insert_id;


    /* Создаем контакт */
    $contact = new Contact();
    $contact
        /* Имя */
        ->setName($name)
        /* Назначаем ответственного менеджера */
        ->setResponsibleUserId($api->config['ResponsibleUserId'])
        /* Привязка созданной сделки к контакту */
        ->setLinkedLeadsId($lead)
        /* Кастомные поля */
        ->setCustomField(
            $api->config['ContactFieldPhone'],
            $phone, // Номер телефона
            'MOB' // MOB - это ENUM для этого поля, список доступных значений смотрите в информации об аккаунте
        ) 
        ->setCustomField(
            $api->config['ContactFieldEmail'],
            $email, // Email
            'WORK' // WORK - это ENUM для этого поля, список доступных значений смотрите в информации об аккаунте
        ) 
        /* Теги. Строка - если один тег, массив - если несколько */
        ->setTags(['тег контакта 1', 'тег контакта 2']);

    /* Проверяем по емейлу, есть ли пользователь в нашей базе */
    $api->request(new Request(Request::GET, ['query' => $email], ['contacts', 'list']));

    /* Если пользователя нет, вернется false, если есть - объект пользователя */
    $contact_exists = ($api->result) ? $api->result->contacts[0] : false;

    /* Если такой пользователь уже есть - мержим поля */
    if ($contact_exists) {
        $contact
            /* Указываем, что пользователь будет обновлен */
            ->setUpdate($contact_exists->id, $contact_exists->last_modified + 1)
            /* Ответственного менеджера оставляем кто был */
            ->setResponsibleUserId($contact_exists->responsible_user_id)
            /* Старые привязанные сделки тоже сохраняем */
            ->setLinkedLeadsId($contact_exists->linked_leads_id);
    }


    /* Отправляем все в AmoCRM */
    $api->request(new Request(Request::SET, $contact));

    

    return $lead;
}


function amo_add_note($type_parent, $type_note, $note_from_amo, $parent_id)
{
    $api_amo = new Handler('samoilov', 'info.polza.com@gmail.com', true);
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

function amo_add_task($id, $text)
{

    $api_amo = new Handler('samoilov', 'info.polza.com@gmail.com', true);
    $pre_result = $api_amo->request(new Request(Request::GET, ['id' => $id], ['leads', 'list']));

    if(!empty($pre_result->result->leads[0])){


        $manager = $pre_result->result->leads[0]->responsible_user_id;
    
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

}

?>