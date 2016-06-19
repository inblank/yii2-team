<?php
/** @var array $messages default messages*/
$messages = [
    'Create' => 'Создать',
    'Update' => 'Изменить',
    'Delete' => 'Удалить',
    'Search' => 'Поиск',
    'Reset' => 'Сброс',

    'Team Roles' => 'Командные роли',
    'Create Role' => 'Создать роль',
    'Update Role' => 'Изменить роль',

    'Member Specialities' => 'Специализации участников',
    'Create Speciality' => 'Создать специализацию',
    'Update Speciality' => 'Изменить специализацию',

    'Team role not found' => 'Командная роль не найдена',
    'Member speciality not found' => 'Специализация участника не найдена',

    'Are you sure you want to delete this role?' => 'Вы действительно хотите удалить эту роль?',
    'Are you sure you want to delete this speciality?' => 'Вы действительно хотите удалить эту специализацию?',


    'Usage' => 'Использование',
    'Action canceled' => 'Действие отменено',
    'Error' => 'Ошибка',
];

/** @var array $sport messages for sport mode */
$sport = [
    'Member Specialities' => 'Специализации игроков',
    'Member speciality not found' => 'Специализация игрока не найдена',
];

if(Yii::$app->getModule('team')->mode==\inblank\team\Module::MODE_SPORT){
    return array_merge($messages, $sport);
}
return $messages;
