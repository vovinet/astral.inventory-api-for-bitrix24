<?php

class astral_inventory extends \CModule
{
    public $MODULE_ID = 'astral.inventory';
    public $MODULE_VERSION = '0.0.1';
    public $MODULE_VERSION_DATE = '2020-01-26 16:00:00';
    public $MODULE_NAME = 'Astral.Inventory API';
    public $MODULE_DESCRIPTION = 'API для интеграции с ПАК Астрал.Имущество';

    public function __construct()
    {
        // Это тут чтобы можно было разместить модуль в Маркетплейс Битрикс
        $this->PARTNER_NAME = '@страл';
        $this->PARTNER_URI = 'https://astral.ru';
    }

    // Установка модуля
    public function doInstall()
    {
        // Регистрация модуля в системе
        \Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);
        
        // Регистрация обработчика события "OnRestServiceBuildDescription" модуля "rest"
        \Bitrix\Main\EventManager::getInstance()->registerEventHandler(
          'rest',
          'OnRestServiceBuildDescription',
          'astral.inventory',
          '\Astral\Inventory\Rest\Service',
          'getDescription'
        );
    }

    // Деинсталяция модуля
    public function doUninstall()
    {
        // Отмена регистрации модуля в системе
        \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);
        
        // Отмена регистрации обработчика события "onFindMethodDescription" модуля "rest"
        \Bitrix\Main\EventManager::getInstance()->unRegisterEventHandler(
          'rest',
          'onFindMethodDescription',
          'astral.inventory',
          '\Astral\Inventory\Rest\Service',
          'findMethodDescription'
        );
    }
    
    // Чтобы была возможность включить у модуля демо период
    public function InstallDB()
    {

    }
}