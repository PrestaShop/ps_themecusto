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

class ps_themecusto extends Module
{
    public $author_address;
    public $bootstrap;
    public $controller_name;
    public $front_controller = [];
    public $template_dir;
    public $js_path;
    public $css_path;
    public $img_path;
    public $logo_path;
    public $module_path;
    public $ps_uri;

    public function __construct()
    {
        $this->name = 'ps_themecusto';
        $this->tab = 'front_office_features';
        $this->version = '1.2.2';
        $this->author = 'PrestaShop';
        $this->module_key = 'af0983815ad8c8a193b5dc9168e8372e';
        $this->author_address = '0x64aa3c1e4034d07015f639b0e171b0d7b27d01aa';
        $this->bootstrap = true;

        parent::__construct();
        $this->controller_name = ['AdminPsThemeCustoAdvanced', 'AdminPsThemeCustoConfiguration'];
        if (!defined('PS_INSTALLATION_IN_PROGRESS')) {
            if (!$this->context instanceof Context) {
                throw new PrestaShopException('Undefined context');
            }
            $this->front_controller = [
                $this->context->link->getAdminLink($this->controller_name[0]),
                $this->context->link->getAdminLink($this->controller_name[1]),
            ];
        }

        $this->ps_versions_compliancy = ['min' => '1.7', 'max' => _PS_VERSION_];

        $this->displayName = $this->l('Theme Customization');
        $this->description = $this->l('Easily build your homepage: access the main front office modules and quickly configure them. Feature available on Design > Theme & Logo page.');
        $this->template_dir = '../../../../modules/' . $this->name . '/views/templates/admin/';
        $this->ps_uri = (Tools::usingSecureMode() ? Tools::getShopDomainSsl(true) : Tools::getShopDomain(true)) . __PS_BASE_URI__;

        // Settings paths
        $this->js_path = $this->_path . 'views/js/';
        $this->css_path = $this->_path . 'views/css/';
        $this->img_path = $this->_path . 'views/img/';
        $this->logo_path = $this->_path . 'logo.png';
        $this->module_path = $this->local_path;
    }

    /**
     * @return bool
     */
    public function install()
    {
        if (parent::install() && $this->installTabList()) {
            return true;
        }

        $this->_errors[] = $this->l('There was an error during the installation. Please contact us through Addons website');

        return false;
    }

    /**
     * @return bool
     */
    public function uninstall()
    {
        // unregister hook
        if (parent::uninstall() && $this->uninstallTabList()) {
            return true;
        }

        $this->_errors[] = $this->l('There was an error during the uninstall. Please contact us through Addons website');

        return false;
    }

    /**
     * Assign all sub menu on Admin tab variable
     */
    public function assignTabList()
    {
        $themesTab = Tab::getInstanceFromClassName('AdminThemes');

        return [
            [
                'class' => $this->controller_name[1],
                'active' => true,
                'position' => 2,
                'id_parent' => $themesTab->id_parent,
                'module' => $this->name,
            ],
            [
                'class' => $this->controller_name[0],
                'active' => true,
                'position' => 3,
                'id_parent' => $themesTab->id_parent,
                'module' => $this->name,
            ],
        ];
    }

    /**
     * Get all tab names by lang ISO
     */
    public function getTabNameByLangISO()
    {
        return [
            $this->controller_name[1] => [
                'fr' => 'Pages Configuration',
                'en' => 'Pages Configuration',
                'es' => 'Paginas configuracion',
                'it' => 'Pagine configurazione',
            ],
            $this->controller_name[0] => [
                'fr' => 'Personnalisation avancée',
                'en' => 'Advanced Customization',
                'es' => 'Personalización avanzada',
                'it' => 'Personalizzazione avanzata',
            ],
        ];
    }

    /**
     * Install all admin tab
     *
     * @return bool
     */
    public function installTabList()
    {
        /* First, we clone the tab "Theme & Logo" to redefined it correctly
            Without that, we can't have tabs in this section */
        $themesTab = Tab::getInstanceFromClassName('AdminThemes');
        $newTab = clone $themesTab;
        $newTab->id = 0;
        $newTab->id_parent = $themesTab->id_parent;
        $newTab->class_name = $themesTab->class_name . 'Parent';
        $newTab->save();
        // Second save in order to get the proper position (add() resets it)
        $newTab->position = 0;
        $newTab->save();
        $themesTab->id_parent = $newTab->id;
        $themesTab->save();

        /* We install all the tabs from this module */
        $tab = new Tab();
        $aTabs = $this->assignTabList();
        $aTabsNameByLang = $this->getTabNameByLangISO();
        $result = false;

        foreach ($aTabs as $aValue) {
            $tab->active = true;
            $tab->class_name = $aValue['class'];
            $tab->name = [];

            foreach (Language::getLanguages(true) as $lang) {
                if (isset($aTabsNameByLang[$aValue['class']][$lang['iso_code']])) {
                    $sIsoCode = $lang['iso_code'];
                } else {
                    $sIsoCode = 'en';
                }
                $tab->name[$lang['id_lang']] = $aTabsNameByLang[$aValue['class']][$sIsoCode];
            }

            $tab->id_parent = $aValue['id_parent'];
            $tab->module = $aValue['module'];
            $tab->position = $aValue['position'];
            $result = $tab->add();
            if (!$result) {
                return false;
            }
        }

        return $result;
    }

    /**
     * uninstall tab
     *
     * @return bool
     */
    public function uninstallTabList()
    {
        $aTabs = $this->assignTabList();
        $result = false;

        foreach ($aTabs as $aValue) {
            $id_tab = (int) Tab::getIdFromClassName($aValue['class']);
            if ($id_tab) {
                $tab = new Tab($id_tab);
                if (Validate::isLoadedObject($tab)) {
                    $result = $tab->delete();
                } else {
                    return false;
                }
            }
        }
        // Duplicate existing Theme tab for sub tree
        $themesTabParent = Tab::getInstanceFromClassName('AdminThemesParent');
        $themesTab = Tab::getInstanceFromClassName('AdminThemes');
        $themesTab->id_parent = $themesTabParent->id_parent;
        $themesTabParent->delete();
        $themesTab->save();
        /* saving again for changing position to 0 */
        $themesTab->position = 0;
        $themesTab->save();

        return $result;
    }

    /**
     * set JS and CSS media
     */
    public function setMedia($aJsDef, $aJs, $aCss)
    {
        Media::addJsDef($aJsDef);

        array_push($aCss, $this->css_path . 'general.css');
        array_push($aJs, $this->js_path . 'general.js');
        $this->context->controller->addCSS($aCss);
        $this->context->controller->addJS($aJs);
    }

    /**
     * check if the employee has the right to use this admin controller
     *
     * @return bool
     */
    public function hasEditRight()
    {
        /** @var array|bool $result */
        $result = Profile::getProfileAccess(
            (int) Context::getContext()->cookie->profile,
            (int) Tab::getIdFromClassName($this->controller_name[0])
        );
        if (!is_array($result) || !isset($result['edit'])) {
            return false;
        }

        return (bool) $result['edit'];
    }
}
