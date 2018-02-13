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


if (!defined('_PS_VERSION_')) {
    exit;
}

class psthemecusto extends Module
{
    protected $front_controller = null;

    public function __construct()
    {
        // Settings
        $this->name = 'psthemecusto';
        $this->tab = '';
        $this->version = '0.0.1';
        $this->author = 'PrestaShop';
        $this->need_instance = 0;

        $this->module_key = '7c707e5791af499b0fb5983803599bb3';
        $this->author_address = '0x64aa3c1e4034d07015f639b0e171b0d7b27d01aa';

        // Controllers
        $this->controller_name = 'AdminPsThemeCusto';
        $this->front_controller =  'index.php?controller='.$this->controller_name.'&token='.Tools::getAdminTokenLite($this->controller_name);
        // bootstrap -> always set to true
        $this->bootstrap = true;

        parent::__construct();

        $this->output = '';

        $this->displayName = $this->l('Theme Customization');
        $this->description = $this->l('Configure and Customize your theme !');
        $this->template_dir = '../../../../modules/'.$this->name.'/views/templates/admin/';

        // Settings paths
        $this->js_path  = $this->_path.'views/js/';
        $this->css_path = $this->_path.'views/css/';
        $this->img_path = $this->_path.'views/img/';
        $this->docs_path = $this->_path.'docs/';
        $this->logo_path = $this->_path.'logo.png';
        $this->module_path = $this->_path;

        // Confirm uninstall
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall this module?');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * install()
     *
     * @param none
     * @return bool
     */
    public function install()
    {
        // some stuff
        //Configuration::updateValue('OLAF', 'LET IT GO');

        // register hook used by the module
        if (parent::install() &&
            $this->installTab() &&
            $this->registerHook('header')) {
            return true;
        } else { // if something wrong return false
            $this->_errors[] = $this->l('There was an error during the installation. Please contact us through Addons website');
            return false;
        }
    }

    /**
     * uninstall()
     *
     * @param none
     * @return bool
     */
    public function uninstall()
    {
        // some stuff
        // Configuration::deleteByName('OLAF');

        // unregister hook
        if (parent::uninstall() &&
            $this->uninstallTab() &&
            $this->unregisterHook('header')) {
            return true;
        } else {
            $this->_errors[] = $this->l('There was an error during the desinstallation. Please contact us through Addons website');
            return false;
        }
        return parent::uninstall();
    }

    /**
     * This method is often use to create an ajax controller
     *
     * @param none
     * @return bool
     */
    public function installTab()
    {
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = $this->controller_name;
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = $this->displayName;
        }
        $tab->id_parent = (int) Tab::getIdFromClassName("AdminParentThemes");
        $tab->module = $this->name;
        $tab->position = 1;
        $result = $tab->add();

        return ($result);
    }

    /**
     * uninstall tab
     *
     * @param none
     * @return bool
     */
    public function uninstallTab()
    {
        $id_tab = (int)Tab::getIdFromClassName($this->controller_name);
        if ($id_tab) {
            $tab = new Tab($id_tab);
            if (Validate::isLoadedObject($tab)) {
                return ($tab->delete());
            } else {
                $return = false;
            }
        } else {
            $return = true;
        }

        return ($return);
    }

    /**
     * set JS and CSS media
     *
     * @param none
     * @return none
     */
    public function setMedia()
    {
        Media::addJsDef(array(
            'admin_module_controller_psthemecusto'  => $this->controller_name,
            'admin_module_ajax_url_psthemecusto'    => $this->front_controller,
        ));
        $js = array(
            $this->js_path.'back.js',
        );
        $this->context->controller->addJS($js);
    }

    /**
    * check if the employee has the right to use this admin controller
    * @return bool
    */
    public function hasEditRight()
    {
        $result = Profile::getProfileAccess(
            (int)Context::getContext()->cookie->profile,
            (int)Tab::getIdFromClassName($this->controller_name)
        );
        return (bool)$result['edit'];
    }

    /**
     * Clone a theme and modify the config to set the parent theme
     *
     * @param none
     * @return bool
     */
    public function createChildTheme()
    {
        global $kernel;

        if (!$this->hasEditRight()) {
            return $this->l("You do not have permission to edit this.");
        }

        $exporter = $kernel->getContainer()->get('prestashop.core.addon.theme.exporter');
        $path = $exporter->export($this->context->shop->theme);
        $aPath = array_reverse(explode("/", $path));
        $sThemeZipPath = "/themes/".$aPath[0];

        return $sThemeZipPath;
    }


}
