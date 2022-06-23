<?php

/* Библиотека для создания консольных команд */
class LibApp
{
   /* Функция вывода списка всех зарегистрированных 
   команд и их описания */
    function showFullHelpList()
    {
        $list_command = file_get_contents('list_commands.txt');
        $list_command_array = explode(PHP_EOL, $list_command);
        
        if(count($list_command_array) == 1)
        {
           echo '***Empty command list. Add new command***' . PHP_EOL; 
        }
        else
        {
           foreach($list_command_array as $one_command)
           {
               $one_command_array = explode(' ', $one_command);
               $this->showOneCommandHelpList($one_command_array[0]);
           }
        }
        return true;
    }

   /* Функция вывода описания одной команды.
      На вход - название команды */
    function showOneCommandHelpList($command_name)
    {
        $list_command = file_get_contents('list_commands.txt');
        $list_command_array = explode(PHP_EOL, $list_command);

        $arguments = array();
        $options = array();

        foreach($list_command_array as $one_command)
        {
           /* Поиск команды в списке list_commands.txt*/
            if(strpos($one_command, $command_name) !== false)
            {
               /* Парсин элементов команды */
                $items = explode(' ', $one_command);

                foreach($items as $item)
                {
                     $item = str_replace('}}', '}', $item);
                     $item = str_replace('{{', '{', $item);
                    if(strpos($item, '{') == 0 and strpos($item, '}') == strlen($item) - 1)
                    {
                        //это аргумент
                        $item = str_replace('}', '', $item);
                        $item = str_replace('{', '', $item);
                        $arguments[] = $item;
                    }
                    else if(strpos($item, '[') == 0 and strpos($item, ']') == strlen($item) - 1)
                    {
                        //это опция
                        $item = str_replace('[', '', $item);
                        $item = str_replace(']', '', $item);
                        $item_arr = explode('=', $item);
                        $key = $item_arr[0];
                        $value = $item_arr[1];
                        $options[$key][] = $value; 
                    }
                }
                break;
            }
        }

        /* Вывод описания команды */
        echo 'Called command: ' . $command_name . PHP_EOL;
        echo 'Arguments:' . PHP_EOL;
        foreach($arguments as $one_argument) { echo '   ' . '- ' . $one_argument . PHP_EOL; }
        echo PHP_EOL;
        echo 'Options:' . PHP_EOL;
        foreach($options as $key => $one_option)
        {
            echo '   ' . '- ' . $key . PHP_EOL;
            foreach($one_option as $one_param) 
            { 
               echo '      ' . '- ' . $one_param . PHP_EOL; 
            }
        }
        
        return true;
    }

   /* Функция регистрации команды */
    function save($argv)
    {
       /* Проверка наличия команды в списке команд */
        if($this->check_exist($argv) === true)
        {
           echo 'Command exists. Rename it.'.PHP_EOL;
        }
        else
        {
           /* Если команда не найдена - добавить в список */
           $str_argv = '';
           foreach($argv as $key => $one_argv)
           {
               if($key == 0) { continue; }
               else if($key == 1) { $str_argv = $str_argv . $one_argv . ' '; }
               else if($key > 1 and strpos($one_argv, '[') === false and strpos($one_argv, ']') === false) { $str_argv = $str_argv . '{' . $one_argv .'}' . ' '; }
               else { $str_argv = $str_argv . $one_argv . ' '; }
           }
           $str_argv = substr($str_argv, 0, -1) . PHP_EOL;
           file_put_contents('list_commands.txt', $str_argv, FILE_APPEND);
           echo 'Command saved!'.PHP_EOL;
        }
        return true;
    }
    
    /* Функция проверки наличия команды в списке */
    function check_exist($argv)
    {
        $list_command = file_get_contents('list_commands.txt');
        $list_command_array = explode(PHP_EOL, $list_command);

        foreach($list_command_array as $one_command)
        {
            if(strpos($one_command, $argv[1]) !== false)
            {
               return true;
            }
        }
        return false;
    }
}