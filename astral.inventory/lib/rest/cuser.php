<?php

namespace Astral\Inventory\Rest;

use Bitrix\Main\UserTable;

class CUser
{
    // Возвращает описание доступных API методов
    public static function getDescription(): array
    {
        $methods = [];

        // Имя методов может быть произвольным но принято использовать следующий формат "имя_разрешения.имя_типа.действие"
        $methods['astral:inventory.cuser.get'] = [];

        // Обработчик метода PHP псевдо-тип callback. Анонимные функции пока не поддерживаются.
        $methods['astral:inventory.cuser.get']['callback'] = [static::class, 'get'];

        // Не совсем понятно что это и для чего используется
        // Смог найти только что если передать ключ "private" => true то вроде как метод будет считаться приватным
        $methods['astral:inventory.cuser.get']['options'] = [];

        $methods['astral:inventory.cuser.test'] = [
            'callback' => [static::class, 'test'],
            'options' => [],
        ];
        
        $methods['astral:inventory.cuser.getlist'] = [
            'callback' => [static::class, 'getList'],
            'options' => [],
        ];
        
        $methods['astral:inventory.cuser.getbyid'] = [
            'callback' => [static::class, 'getByID'],
            'options' => [],
        ];
        
        $methods['astral:inventory.cuser.getusergroup'] = [
            'callback' => [static::class, 'GetUserGroup'],
            'options' => [],
        ];
        
        $methods['astral:inventory.cuser.setusergroup'] = [
            'callback' => [static::class, 'SetUserGroup'],
            'options' => [],
        ];
        
        $methods['astral:inventory.cuser.add'] = [
            'callback' => [static::class, 'add'],
            'options' => [],
        ];
        
        $methods['astral:inventory.cuser.update'] = [
            'callback' => [static::class, 'Update'],
            'options' => [],
        ];
        
        return $methods;
    }
    
    // Возвращает случайное число
    public static function get(array $query, int $start, \CRestServer $server)
    {
        $res = 'test';
        if ($query['data'] != '') {
            $user = new CUser;

            $ID = $user->Add($arFields);
            if (intval($ID) > 0)
                $res = $ID;
            else
                $res = $user->LAST_ERROR;
          return $res;
        }

        // Если произошла ошибка можно бросить исключение
        // Исключение будет перехвачено и отображено в виде рест ощибки
        throw new \Bitrix\Main\ArgumentException(
            'Не корректное значение параметра "type", используйте разрешенные значения "'.implode('", "', static::getAllowedTypes()).'"',
            'type'
        );

        // Если нужно указать собственный код ошибки можно использовать класс \Bitrix\Rest\RestException
        // При этом если до этого в коде было сгенерировано исключение через старое API ($APPLICATION->ThrowException()) то оно перезапишет ошибку в ответе
        // throw new \Bitrix\Rest\RestException(
        //     'Не корректное значение параметра "type", используйте разрешенные значения "'.implode('", "', static::getAllowedTypes()).'"',
        //     'INCORRECT_PARAMETR_TYPE'
        // );
    }

    // Возвращает несколько случайных чисел
    public static function test(array $query, int $start, \CRestServer $server): string
    {
      $user     = new \CUser;
        $arFields = array(
            "NAME" => 'Test',
            "LOGIN" => 'test',
            "EMAIL" => 'test@test.com',
            "PHONE_NUMBER" => '+71234567890',
            "LID" => "ru",
            "ACTIVE" => "Y",
            "PASSWORD" => 'test',
            "CONFIRM_PASSWORD" => 'pass',
            "GROUP_ID" => array(10, 11)
        );
        $new_user_ID = $user->Add($arFields);
        
        return $new_user_ID;
        //return 'Test Passed';
    }

    // Создание пользователя
    public static function add(array $query, int $start, \CRestServer $server)
    {
        $user = new \CUser;

        $ID = $user->Add($query['fields']);
        if (intval($ID) > 0)
            return $ID;
        else
            return $user->LAST_ERROR;
    }
    
    // Изменение пользователя
    
    public static function update(array $query, int $start, \CRestServer $server)
    {
      $user = new \CUser;
      $user->Update($query['ID'], $query['fields']);
      Return $user->LAST_ERROR;
    }
    
    // Получение списка пользователей. 
    public static function getList(array $query, int $start, \CRestServer $server)
    {
      $arUsers = [];
      $user = true;
      
      if (empty($query['by']))
        $query['by'] = 'ID';
        
      if (empty($query['order']))
        $query['order'] = 'asc';
      
      $userList = \CUser::GetList($query['by'],$query['order'],$query['filter'],$query['arParams']);
      
      while ($user) {
        $user = $userList->Fetch();
        if ($user)
          $arUsers[] = $user;
        
      }
      
      return $arUsers;
    }
    
    // Получение пользователя по ID
    public static function getByID(array $query, int $start, \CRestServer $server)
    {
      return \CUser::GetByID($query['id'])->fetch();
    }
    
    // Получение массив из ID групп пользователя пользователя по ID пользователя
    public static function GetUserGroup(array $query, int $start, \CRestServer $server)
    {
      return \CUser::GetUserGroup($query['id']);
    }
    
    // Установка массив из ID групп пользователя пользователя по ID пользователя
    public static function SetUserGroup(array $query, int $start, \CRestServer $server)
    {
      return \CUser::SetUserGroup($query['user_id'], $query['groups']);
    }
}