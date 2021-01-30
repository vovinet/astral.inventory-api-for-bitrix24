<?php

namespace Astral\Inventory\Rest;

// Если мы задаем собственное разрешение можно создать языковую фразу "REST_SCOPE_{Имя вашего разрешения}"
// Тогда в списке разрешений приложения будет использоваться языковая фраза
// \Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class Service
{
    // Возвращает описание одного или нескольких разрешений
    public static function getDescription(): array
    {
        $scopes = [];

        // Если нужно добавить методы к уже существующему разрешению просто указываем его
        // $scopes['crm'] = [];

        // Если нужно добавить методы которые не требуют разрешения и доступны всем приложениям
        // $scopes[\CRestUtil::GLOBAL_SCOPE] = [];

        // Если нужно добавить методы которые будут доступны если выдано собственное разрешение
        // Имя разрешения может быть произвольным
        $scopes['astral:inventory'] = [];
        
        // Перечислим доступные методы
        $scopes['astral:inventory'] = array_merge(
          $scopes['astral:inventory'],
          CUser::getDescription(),
          CGroup::getDescription()
        );

        return $scopes;
    }
}