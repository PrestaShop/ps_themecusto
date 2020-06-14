<?php
/**
 * 2007-2020 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */
class ThemeCustoRequests
{
    /**
     * Get all the modules by name
     *
     * @param string $moduleName
     *
     * @return array|false|PDOStatement|resource|null
     */
    public static function getModulesListByName($moduleName)
    {
        $sqlQuery = '   SELECT m.id_module, m.name, ms.enable_device as active
                    FROM `' . _DB_PREFIX_ . 'module` m
                    LEFT JOIN `' . _DB_PREFIX_ . 'module_shop` ms ON m.id_module = ms.id_module
                    WHERE m.name = "' . pSQL($moduleName) . '"';

        return Db::getInstance()->executeS($sqlQuery);
    }

    /**
     * Get the device status of a module
     *
     * @param int $moduleId
     *
     * @return string|false|null
     */
    public static function getModuleDeviceStatus($moduleId)
    {
        $sqlQuery = '   SELECT ms.enable_device as active
                        FROM `' . _DB_PREFIX_ . 'module_shop` ms
                        WHERE ms.id_module = ' . (int) $moduleId;

        return Db::getInstance()->getValue($sqlQuery);
    }
}
