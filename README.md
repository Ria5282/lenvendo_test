# README

Для запуска программы необходимо иметь установленный PHP 7.4 и выше на ВМ с ОС Linux.
Склонировать репозиторий командой git clone https://github.com/Ria5282/lendovo_test.
Команды выполняются из директории приложения.

Пример добавления команды:
php app.php write {log,verbose} [profile={id,role,email}] {pos,len} [set=unicod] {mod}

Пример вывода описания команды:
php app.php write {help}
Called command: write
Arguments:
   - log
   - verbose
   - pos
   - len
   - mod

Options:
   - profile
      - id
      - role
      - email
   - set
      - unicod
