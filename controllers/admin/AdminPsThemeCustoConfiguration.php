<?php
/**
* 2007-2018 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
* @author PrestaShop SA <contact@prestashop.com>
* @copyright 2007-2018 PrestaShop SA
* @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
* International Registered Trademark & Property of PrestaShop SA
**/

class AdminPsThemeCustoConfigurationController extends ModuleAdminController
{
    private $aModuleActions;
    private $aModuleActionsNames;

    public function __construct()
    {
        parent::__construct();

        $this->aModuleActions = array('uninstall', 'install', 'configure', 'enable', 'disable', 'disable_mobile', 'enable_mobile', 'reset' );
        $this->moduleActionsNames = array('Uninstall', 'Install', 'Configure', 'Enable', 'Disable', 'Disable Mobile', 'Enable Mobile' ,'Reset');
    }

    /**
     * Initialize the content by adding Boostrap and loading the TPL
     *
     * @param none
     * @return none
     */
    public function initContent()
    {
        parent::initContent();

        $this->module->setMedia();
        $this->setTemplate( $this->module->template_dir.'page.tpl');
        $this->context->smarty->assign(array(
            'bootstrap'             =>  1,
            'configure_type'        => 'configuration',
            'iconConfiguration'     => $this->module->img_path.'icon_configurator.png',
            'modulesList'           => $this->getModulesByHook('displayHome'),
            'modulesPage'           => $this->context->link->getAdminLink('AdminModules'),
            'moduleImgUri'          => $this->module->module_path.'views/img',
            'moduleActions'         => $this->aModuleActions,
            'moduleActionsNames'    => $this->moduleActionsNames,
            'themeConfiguratorUrl'  => $this->context->link->getAdminLink('AdminModules', true, false, array('configure' => 'ps_themeconfigurator')),
        ));
    }

    /**
     * AJAX : Do a module action like Install, disable, enable ...
     *
     * @param null
     * @return tpl
     */
    public function ajaxProcessUpdateModule()
    {
        if ($this->module->_token === Tools::getValue('_token')) {
            $iModuleId      = (int)Tools::getValue('id_module');
            $sModuleAction  = pSQL(Tools::getValue('action_module'));
            $oModule        = Module::getInstanceById($iModuleId);
            $bReturn        = false;

            switch ($sModuleAction) {
                case 'uninstall':
                    $bReturn = $oModule->uninstall();
                break;
                case 'install':
                    $bReturn = $oModule->install();
                break;
                case 'enable':
                    $bReturn = $oModule->enable();
                break;
                case 'disable':
                    $bReturn = $oModule->disable();
                break;
                case 'disable_mobile':
                    $bReturn = $oModule->enableDevice('mobile');
                break;
                case 'enable_mobile':
                    $bReturn = $oModule->disableDevice('mobile');
                break;
                case 'reset':
                    $bReturn = $oModule->uninstall();
                    $bReturn = $oModule->install();
                break;
                default:
                    die(0);
                break;
            }

            $sUrlActive = ($oModule->isEnabled($oModule->name) ? 'configure' : 'enable');
            $aModule['id_module'] = $oModule->id;
            $aModule['name'] = $oModule->name;
            $aModule['displayName'] = $oModule->displayName;
            $aModule['url_active'] = $sUrlActive;
            $aModule['active'] = $oModule->enable_device;
            $aModule['actions_url']['configure'] = $this->context->link->getAdminLink('AdminModules', true, false, array('configure' => $oModule->name));
            unset($oModule);

            $this->context->smarty->assign(array(
                'module' => $aModule,
                'moduleActions'         => $this->aModuleActions,
                'moduleActionsNames'    => $this->moduleActionsNames
                )
            );
            die($this->context->smarty->fetch(dirname(__FILE__).'/../../views/templates/admin/controllers/configuration/elem/module_actions.tpl'));
        } else {
            die("-1");
        }
    }

    /**
     * Initialize the content by adding Boostrap and loading the TPL
     *
     * @param string $sHookName
     * @return array $aModulesList
     */
    public function getModulesByHook($sHookName)
    {
        $aModuleFinalList = array();

        $sSql = '   SELECT m.id_module, m.name, hm.position, ms.enable_device as active
                    FROM `'._DB_PREFIX_.'hook_module` hm
                    INNER JOIN `'._DB_PREFIX_.'hook` h ON h.id_hook = hm.id_hook
                    INNER JOIN `'._DB_PREFIX_.'module` m ON m.id_module = hm.id_module
                    LEFT JOIN `'._DB_PREFIX_.'module_shop` ms ON m.id_module = ms.id_module
                    WHERE 1
                    AND h.name = "'.pSQL($sHookName).'"
                    ORDER BY hm.position ASC';
        $aModulesList = Db::getInstance()->executeS($sSql);

        foreach ($aModulesList as $aModule) {
            $sUrlActive = ($aModule['active']? 'configure' : 'enable');
            $aModuleInstance = Module::getInstanceByName($aModule['name']);
            $aModuleFinalList[$aModule['position']]['id_module'] = $aModule['id_module'];
            $aModuleFinalList[$aModule['position']]['active'] = $aModule['active'];
            $aModuleFinalList[$aModule['position']]['url_active'] = $sUrlActive;
            $aModuleFinalList[$aModule['position']]['name'] = $aModuleInstance->name;
            $aModuleFinalList[$aModule['position']]['displayName'] = $aModuleInstance->displayName;
            $aModuleFinalList[$aModule['position']]['description'] = $aModuleInstance->description;
            $aModuleFinalList[$aModule['position']]['controller_name'] = (isset($aModuleInstance->controller_name)? $aModuleInstance->controller_name : '');
            $aModuleFinalList[$aModule['position']]['logo'] = '/modules/'.$aModuleInstance->name.'/logo.png';
            $aModuleFinalList[$aModule['position']]['actions_url']['configure'] = $this->context->link->getAdminLink('AdminModules', true, false, array('configure' => $aModuleInstance->name));
            unset($aModuleInstance);
        }
        return $aModuleFinalList;
    }

}
