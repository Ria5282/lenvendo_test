<?php

/* Подключение библиотеки для создания консольных команд */
include_once('LibApp.php');
$libApp = new LibApp();

/* При запуске приложения без указания конкретной команды необходимо выводить список всех зарегистрированных в нём 
команд и их описания. */
if (count($argv) == 1) 
{
   echo '***Show full helplist***' . PHP_EOL;
   $libApp->showFullHelpList();
} 

/* При запуске любой из команд с аргументом {help} 
необходимо выводить описание команды */
else if (count($argv) == 3 and $argv[2] == '{help}') 
{
   $libApp->showOneCommandHelpList($argv[1]);
}

/* Регистрация команды */
else 
{
   /* При вводе в консоль команды, которой нет в списке, она автоматически регистрируется (сохраняется в файл list_commands.txt)*/
   $libApp->save($argv);
}





