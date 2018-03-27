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

require_once(dirname(__FILE__).'../../../classes/ThemeCustoRequests.php');

class AdminPsThemeCustoConfigurationController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->controller_quick_name = 'configuration';
        $this->aModuleActions = array('uninstall', 'install', 'configure', 'enable', 'disable', 'disable_mobile', 'enable_mobile', 'reset' );
        $this->moduleActionsNames = array('Uninstall', 'Install', 'Configure', 'Enable', 'Disable', 'Disable Mobile', 'Enable Mobile' ,'Reset');
        $this->categoryList = array('Menu', 'Slider', 'Home Products', 'Text bloc', 'Banner', 'Social &  Newsletter', 'Footer');
    }

    /**
     * Get modules list to show for Ready
     *
     * @param none
     * @return array $aModulesList
    */
    public function getListToConfigure()
    {
        $aList = array(
            'menu' => array(
                'pages' => array(
                    'AdminCategories' => array('Create product categories', 'Ma description de catégorie !'),
                    'AdminCmsContent' => array('Create content pages', 'Ma description de CMS !'),
                    'AdminManufacturers' => array('Create Brands & Suppliers', 'Ma descriptions des marques et fournisseurs!'),
                ),
                'modules' => array(
                    'ps_mainmenu', //22321
                ),
            ),
            'slider' => array(
                'modules' => array(
                    'ps_imageslider', //22320
                ),
            ),
            'home_products' => array(
                'modules' => array(
                    'ps_featuredproducts', //22319
                    'statsbestproducts', //21165
                    'ps_newproducts', //24671
                ),
            ),
            'bloc_text' => array(
                'modules' => array(
                    'ps_customtext', //22317
                ),
            ),
            'banner' => array(
                'modules' => array(
                    'ps_banner', //22313
                ),
            ),
            'social_newsletter' => array(
                'modules' => array(
                    'ps_emailsubscription', //22318
                    'ps_socialfollow', //22323
                ),
            ),
            'footer' => array(
                'modules' => array(
                    'ps_linklist', //24360
                    'ps_socialfollow', //22323
                ),
            ),
        );

        return $aList;
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

        $aListToConfigure = $this->getListToConfigure();
        $this->context->smarty->assign(array(
            'bootstrap'             =>  1,
            'configure_type'        => $this->controller_quick_name,
            'iconConfiguration'     => $this->module->img_path.'icon_configurator.png',
            'listCategories'        => $this->categoryList,
            'elementsList'          => $this->setFinalList($aListToConfigure),
            'modulesPage'           => $this->context->link->getAdminLink('AdminModules'),
            'moduleImgUri'          => $this->module->module_path.'views/img',
            'moduleActions'         => $this->aModuleActions,
            'moduleActionsNames'    => $this->moduleActionsNames,
            'themeConfiguratorUrl'  => $this->context->link->getAdminLink('AdminModules', true, false, array('configure' => 'ps_themeconfigurator')),
        ));

        $aJsDef = array(
            'admin_module_controller_psthemecusto'  => $this->module->controller_name[1],
            'admin_module_ajax_url_psthemecusto'    => $this->module->front_controller[1],
            'module_action_sucess'                  => $this->l('Action on the module successfully completed'),
            'module_action_failed'                  => $this->l('Action on module failed'),
        );
        $aJs = array($this->module->js_path.'/controllers/'.$this->controller_quick_name.'/back.js');
        $aCss = array($this->module->css_path.'/controllers/'.$this->controller_quick_name.'/back.css');

        $this->module->setMedia($aJsDef, $aJs, $aCss);
        $this->setTemplate( $this->module->template_dir.'page.tpl');
    }


    /**
     * AJAX : Do a module action like Install, disable, enable ...
     *
     * @param null
     * @return mixed int | tpl
    */
    public function ajaxProcessUpdateModule()
    {
        $iModuleId      = (int)Tools::getValue('id_module');
        $sModuleName    = pSQL(Tools::getValue('module_name'));
        $sModuleAction  = pSQL(Tools::getValue('action_module'));
        $oModule        = Module::getInstanceByName($sModuleName);
        $bReturn        = false;
        $sUrlActive     = false;

        switch ($sModuleAction) {
            case 'uninstall':
                $bReturn = $oModule->uninstall();
                $sUrlActive = 'install';
            break;
            case 'install':
                $bReturn = $oModule->install();
                $sUrlActive = 'configure';
            break;
            case 'enable':
                $bReturn = $oModule->enable();
            break;
            case 'disable':
                $bReturn = $oModule->disable();
            break;
            case 'disable_mobile':
                $bReturn = $oModule->disableDevice(Context::DEVICE_MOBILE);
            break;
            case 'enable_mobile':
                $bReturn = $oModule->enableDevice(Context::DEVICE_MOBILE);
            break;
            case 'reset':
                $bReturn = $oModule->uninstall();
                $bReturn = $oModule->install();
            break;
            default:
                die(0);
            break;
        }

        if ($sUrlActive === false) {
            $sUrlActive = (($oModule->isEnabled($oModule->name) || $sUrlActive) ? 'configure' : 'enable');
        }

        $aModule['id_module'] = $oModule->id;
        $aModule['name'] = $oModule->name;
        $aModule['displayName'] = $oModule->displayName;
        $aModule['url_active'] = $sUrlActive;
        $aModule['active'] = ThemeCustoRequests::getModuleDeviceStatus($oModule->id);
        $aModule['actions_url']['configure'] = $this->context->link->getAdminLink('AdminModules', true, false, array('configure' => $oModule->name));
        unset($oModule);

        $this->context->smarty->assign(array(
            'module'                => $aModule,
            'moduleActions'         => $this->aModuleActions,
            'moduleActionsNames'    => $this->moduleActionsNames,
            )
        );

        die($this->context->smarty->fetch(dirname(__FILE__).'/../../views/templates/admin/controllers/'.$this->controller_quick_name.'/elem/module_actions.tpl'));
    }

    /**
     * Get modules by hook name to create an array with all modules informations to do actions on it
     * For PrestaShop Download
     *
     * @param string $sHookName
     * @return array $aModulesList
    */
    public function getModulesByHook($sHookName)
    {
        $aModuleFinalList = array();
        $aModulesList = ThemeCustoRequests::getModulesListByHook($sHookName);

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

    /**
     * get list to show for Ready
     * For PrestaShop Ready
     *
     * @param array $aList
     * @return none
    */
    public function setFinalList($aList)
    {
        $aModuleFinalList = array();

        foreach ($aList as $sSegmentName => $aElementListByType) {
            foreach ($aElementListByType as $sType => $aElementsList) {
                if ($sType == 'pages') {
                    foreach ($aElementsList as $sController => $aPage) {
                        $aModuleFinalList[$sSegmentName][$sType][$sController]['displayName'] = $aPage[0];
                        $aModuleFinalList[$sSegmentName][$sType][$sController]['url'] = $this->context->link->getAdminLink($sController);
                        $aModuleFinalList[$sSegmentName][$sType][$sController]['description'] = $aPage[1];
                        $aModuleFinalList[$sSegmentName][$sType][$sController]['action'] = 'Configure';
                    }
                } else {
                    foreach ($aElementsList as $sModule) {
                        if (Module::isInstalled($sModule)) {
                            $aModuleInstance = Module::getInstanceByName($sModule);
                            $aModuleFinalList[$sSegmentName][$sType][$sModule]['id_module'] = $aModuleInstance->id;
                            $aModuleFinalList[$sSegmentName][$sType][$sModule]['active'] = $aModuleInstance->active;
                            $aModuleFinalList[$sSegmentName][$sType][$sModule]['url_active'] = ($aModuleInstance->active? 'configure' : 'enable');
                            $aModuleFinalList[$sSegmentName][$sType][$sModule]['name'] = $aModuleInstance->name;
                            $aModuleFinalList[$sSegmentName][$sType][$sModule]['displayName'] = $aModuleInstance->displayName;
                            $aModuleFinalList[$sSegmentName][$sType][$sModule]['description'] = $aModuleInstance->description;
                            $aModuleFinalList[$sSegmentName][$sType][$sModule]['controller_name'] = (isset($aModuleInstance->controller_name)? $aModuleInstance->controller_name : '');
                            $aModuleFinalList[$sSegmentName][$sType][$sModule]['logo'] = '/modules/'.$aModuleInstance->name.'/logo.png';
                            $aModuleFinalList[$sSegmentName][$sType][$sModule]['actions_url']['configure'] = $this->context->link->getAdminLink('AdminModules', true, false, array('configure' => $aModuleInstance->name));
                            unset($aModuleInstance);
                        } else {
                            try {
                                include_once(_PS_MODULE_DIR_.$sModule.'/'.$sModule.'.php');
                                $oModule = new $sModule();
                                $aModuleFinalList[$sSegmentName][$sType][$sModule]['id_module'] = $oModule->id;
                                $aModuleFinalList[$sSegmentName][$sType][$sModule]['active'] = $oModule->active;
                                $aModuleFinalList[$sSegmentName][$sType][$sModule]['url_active'] = 'install';
                                $aModuleFinalList[$sSegmentName][$sType][$sModule]['name'] = $oModule->name;
                                $aModuleFinalList[$sSegmentName][$sType][$sModule]['displayName'] = $oModule->displayName;
                                $aModuleFinalList[$sSegmentName][$sType][$sModule]['description'] = $oModule->description;
                                $aModuleFinalList[$sSegmentName][$sType][$sModule]['controller_name'] = (isset($oModule->controller_name)? $oModule->controller_name : '');
                                $aModuleFinalList[$sSegmentName][$sType][$sModule]['logo'] = '/modules/'.$oModule->name.'/logo.png';
                                $aModuleFinalList[$sSegmentName][$sType][$sModule]['actions_url']['configure'] = $this->context->link->getAdminLink('AdminModules', true, false, array('install' => $oModule->name));
                                unset($oModule);
                            } catch (Exception $e) {
                            /* For a module coming from outside. It will be downloaded and installed */
                            }
                        }
                    }
                }
            }

        }

        return $aModuleFinalList;
    }
}
