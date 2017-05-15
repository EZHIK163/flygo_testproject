# flygo_testproject
<b>Тестовое задание для компании FlyGo</b>


Один проект основанный на Codeigniter. Два контроллера взаимодействующие по технологии REST: <b>Client</b> и <b>Server</b>.<br/>
Контроллер по умолчанию - <b>Client</b> - http://site.ru/index.php<br/>
Autoload подключения базы данных<br/>
Проверка данных на правильность и возврат ошибки в виде сообщения с параметрами: status и message<br/>

<b>Server</b> имеет следующий набор запросов:<br/>
http://site.ru/index.php/server/users - GET запрос возвращает всех пользователей и полную информацию о них<br/>
http://site.ru/index.php/server/users/id/1 - GET запрос возвращает пользователя с ID = 1 <br/>
http://site.ru/index.php/server/users/clone_id/1 - GET запрос возвращает клона пользователя с ID = 1, возвращая ID склонированного пользователя<br/>
http://site.ru/index.php/server/users/locations/Samara - GET запрос возвращает массив пользователей проживающих в городе Samara <br/>
http://site.ru/index.php/server/users - DELETE запрос с параметром id, удаляет пользователя с указанным id<br/>
http://site.ru/index.php/server/users - PUT запрос с параметрами: id, name, biography, tel_number, locations, обновляет пользователя с указанным id<br/>
http://site.ru/index.php/server/users - POST запрос с параметрами: name, biography, tel_number, locations, добавляет пользователя с указанным id<br/>

<b>Client</b> имеет следующий набор запросов:<br/>
http://site.ru/index.php/client/get_users/ - получить список всех пользователей<br/>
http://site.ru/index.php/client/get_user_for_id/1 - получить пользователя с ID = 1<br/>
http://site.ru/index.php/client/get_user_for_locations/Samara - получить пользователя с Location = Samara<br/>
http://site.ru/index.php/client/update_user/1/New_name/New_biography/New_tel_number/New_locations - обновить данные пользователя с ID = 1<br/>
http://site.ru/index.php/client/add_user/New_name/New_biography/New_tel_number/New_locations - добавить нового пользователя<br/>
http://site.ru/index.php/client/delete_user/1/ - удалить пользоваться с ID = 1<br/>
