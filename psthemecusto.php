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
    public function __construct()
    {
        $this->name = 'psthemecusto';
        $this->version = '0.1.0';
        $this->author = 'PrestaShop';

        $this->module_key = '7c707e5791af499b0fb5983803599bb3';
        $this->author_address = '0x64aa3c1e4034d07015f639b0e171b0d7b27d01aa';
        $this->controller_name = array( 'AdminPsThemeCustoAdvanced',
                                        'AdminPsThemeCustoConfiguration');
        $this->front_controller =  array('index.php?controller='.$this->controller_name[0].'&token='.Tools::getAdminTokenLite($this->controller_name[0]),
                                        'index.php?controller='.$this->controller_name[1].'&token='.Tools::getAdminTokenLite($this->controller_name[1])
                                        );
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l('Theme Customization');
        $this->description = $this->l('Configure and Customize your theme !');
        $this->template_dir = '../../../../modules/'.$this->name.'/views/templates/admin/';
        $this->ps_uri = (Tools::usingSecureMode() ? Tools::getShopDomainSsl(true) : Tools::getShopDomain(true)).__PS_BASE_URI__;

        // Settings paths
        $this->js_path  = $this->_path.'views/js/';
        $this->css_path = $this->_path.'views/css/';
        $this->img_path = $this->_path.'views/img/';
        $this->logo_path = $this->_path.'logo.png';
        $this->module_path = $this->_path;
    }

    /**
     * install()
     *
     * @param none
     * @return bool
     */
    public function install()
    {
        if (parent::install() &&
            $this->installTabList()) {
            return true;
        } else {
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
        // unregister hook
        if (parent::uninstall() &&
            $this->uninstallTabList()) {
            return true;
        } else {
            $this->_errors[] = $this->l('There was an error during the uninstall. Please contact us through Addons website');
            return false;
        }
        return parent::uninstall();
    }

    /**
     * Assign all sub menu on Admin tab variable
     */
    public function assignTabList()
    {
        $themesTab = Tab::getInstanceFromClassName('AdminThemes');
        return array(
            array(
                'class'     => $this->controller_name[1],
                'active'    => true,
                'position'  => 2,
                'name'      => 'Homepage Configuration',
                'id_parent' => $themesTab->id_parent,
                'module'    => $this->name,
            ),
            array(
                'class'     => $this->controller_name[0],
                'active'    => true,
                'position'  => 3,
                'name'      => 'Advanced customisation',
                'id_parent' => $themesTab->id_parent,
                'module'    => $this->name,
            )
        );
    }

    /**
     * Install all admin tab
     * @return boolean
     */
    public function installTabList()
    {
        /* First, we clone the tab "Theme & Logo" to redefined it correctly
            Without that, we can't have tabs in this section */
        $themesTab = Tab::getInstanceFromClassName('AdminThemes');
        $newTab = clone($themesTab);
        $newTab->id = 0;
        $newTab->id_parent = $themesTab->id_parent;
        $newTab->class_name = $themesTab->class_name.'Parent';
        $newTab->save();
        // Second save in order to get the proper position (add() resets it)
        // $newTab->position = $themesTab->position;
        $newTab->position = 0;
        $newTab->save();
        $themesTab->id_parent = $newTab->id;
        $themesTab->save();

        /* We install all the tabs from this module */
        $tab = new tab();
        $aTabs = $this->assignTabList();
        foreach ($aTabs as $aValue) {
            $tab->active = 1;
            $tab->class_name = $aValue['class'];
            $tab->name = array();

            foreach (Language::getLanguages(true) as $lang) {
                $tab->name[$lang['id_lang']] =  $aValue['name'];
            }

            $tab->id_parent = $aValue['id_parent'];
            $tab->module = $aValue['module'];
            $tab->position = $aValue['position'];
            $result = $tab->add();
            if (!$result) {
                return false;
            }
        }

        return ($result);
    }

    /**
     * uninstall tab
     *
     * @param none
     * @return bool
     */
    public function uninstallTabList()
    {
        $aTabs = $this->assignTabList();
        foreach ($aTabs as $aValue) {
            $id_tab = (int)Tab::getIdFromClassName($aValue['class']);
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
        if (!$themesTabParent || !$themesTab) {
            return false;
        }
        $themesTab->position = $themesTabParent->position;
        $themesTab->id_parent = $themesTabParent->id_parent;
        $themesTabParent->delete();
        $themesTab->save();
        return $result;
    }

    /**
     * set JS and CSS media
     *
     * @param none
     * @return none
     */
    public function setMedia($aJsDef, $aJs, $aCss)
    {
        Media::addJsDef($aJsDef);

        array_push($aCss, $this->css_path."general.css");
        array_push($aJs, $this->js_path."general.js");
        $this->context->controller->addCSS($aCss);
        $this->context->controller->addJS($aJs);
    }

    /**
    * check if the employee has the right to use this admin controller
    * @return bool
    */
    public function hasEditRight()
    {
        $result = Profile::getProfileAccess(
            (int)Context::getContext()->cookie->profile,
            (int)Tab::getIdFromClassName($this->controller_name[0])
        );
        return (bool)$result['edit'];
    }

}
