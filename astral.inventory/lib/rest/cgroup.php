<?php

namespace Astral\Inventory\Rest;

class CGroup
{
    // Возвращает описание доступных API методов
    public static function getDescription(): array
    {
        $methods = [];

        // Имя методов может быть произвольным но принято использовать следующий формат "имя_разрешения.имя_типа.действие"
        $methods['astral:inventory.cgroup.getlist'] = [];

        // Обработчик метода PHP псевдо-тип callback. Анонимные функции пока не поддерживаются.
        $methods['astral:inventory.cgroup.getlist']['callback'] = [static::class, 'GetList'];

        // Не совсем понятно что это и для чего используется
        // Смог найти только что если передать ключ "private" => true то вроде как метод будет считаться приватным
        $methods['astral:inventory.cgroup.getlist']['options'] = [];
        
        return $methods;
    }
    
    // Получение списка групп. 
    public static function GetList(array $query, int $start, \CRestServer $server)
    {
      $arGroups = [];
      $group = true;
      
      if (empty($query['by']))
        $query['by'] = 'id';
        
      if (empty($query['order']))
        $query['order'] = 'asc';
        
      if (empty($query['SHOW_USERS_AMOUNT ']))
        $query['SHOW_USERS_AMOUNT '] = 'N';
      
      $groupList = \CGroup::GetList($query['by'],$query['order'],$query['filter'],$query['SHOW_USERS_AMOUNT ']);
      
      while ($group) {
        $group = $groupList->Fetch();
        if ($group)
          $arGroups[] = $group;
      }
      
      return $arGroups;
    }
}