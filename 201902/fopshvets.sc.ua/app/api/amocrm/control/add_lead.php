<?

ini_set('display_errors', 0);

include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Entity.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Company.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Contact.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Handler.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Lead.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Note.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Request.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Task.php');
// include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Webhook.php');


/* Предположим, пользователь ввел какие-то данные в форму на сайте */
$name = $_GET['name'];
$phone = $_GET['phone'];
$email = $_GET['email'];
$lead_name = $_GET['lead'];
$tags = $_GET['tags'];
$budget = $_GET['budget'];
$utm = $_GET['utm'];

/* Оборачиваем в try{} catch(){}, чтобы отлавливать исключения */
try {
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

    $debug_url = 'http://polza.com/app/api/telegram/control/send_message.php?text=AmoAddLeadIs'.$lead;
    file_get_contents($debug_url);

    echo $lead;
    
} catch (\Exception $e) {
    echo $e->getMessage();
}


?>