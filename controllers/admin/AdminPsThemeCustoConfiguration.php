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
if (file_exists(_PS_MODULE_DIR_ . 'ps_themecusto/vendor/autoload.php')) {
    require_once _PS_MODULE_DIR_ . 'ps_themecusto/vendor/autoload.php';
}

class AdminPsThemeCustoConfigurationController extends ModuleAdminController
{
    public $isPsVersion174Plus;
    public $controller_quick_name;
    public $aModuleActions;
    public $moduleActionsNames;
    public $categoryList;

    public function __construct()
    {
        parent::__construct();

        $this->isPsVersion174Plus = (bool) version_compare(_PS_VERSION_, '1.7.4', '>=');
        $this->controller_quick_name = 'configuration';
        $this->aModuleActions = ['uninstall', 'install', 'configure', 'enable', 'disable', 'disable_mobile', 'enable_mobile', 'reset'];
        $this->moduleActionsNames = [
            $this->l('Uninstall'),
            $this->l('Install'),
            $this->l('Configure'),
            $this->l('Enable'),
            $this->l('Disable'),
            $this->l('Disable Mobile'),
            $this->l('Enable Mobile'),
            $this->l('Reset'),
        ];

        $this->categoryList = [
            'menu' => $this->l('Menu'),
            'slider' => $this->l('Slider'),
            'home_products' => $this->l('Home Products'),
            'block_text' => $this->l('Text block'),
            'banner' => $this->l('Banner'),
            'social_newsletter' => $this->l('Social & Newsletter'),
            'footer' => $this->l('Footer'),
            'content' => $this->l('content'),
            'categories' => $this->l('Categories'),
            'navigation_column' => $this->l('Navigation column'),
            'product_management' => $this->l('Product management'),
            'product_detail' => $this->l('Product detail'),
            'product_block' => $this->l('Product block'),
        ];
    }

    /**
     * Get homepage list of modules to show
     *
     * @return array
     */
    public function getHomepageListConfiguration()
    {
        if ($this->isPsVersion174Plus) {
            $footerModules = [
                'blockreassurance' => 22312,
                'ps_linklist' => 24360,
            ];
        } else {
            $footerModules = [
                'ps_linklist' => 24360,
            ];
        }

        return [
            'menu' => [
                'pages' => [
                    'AdminCategories' => [
                        $this->l('Categories'),
                        $this->l('Create here a full range of categories and subcategories to classify your products and manage your catalog easily.'),
                    ],
                    'AdminCmsContent' => [
                        $this->l('Content pages'),
                        $this->l('Add and manage your content pages to make your store interesting and trustworthy.'),
                    ],
                    'AdminManufacturers' => [
                        $this->l('Brands and Suppliers'),
                        $this->l('Manage both your brands and suppliers at the same place !'),
                    ],
                ],
                'modules' => [
                    'ps_mainmenu' => 22321,
                ],
            ],
            'slider' => [
                'modules' => [
                    'ps_imageslider' => 22320,
                ],
            ],
            'home_products' => [
                'modules' => [
                    'ps_featuredproducts' => 22319,
                    'ps_bestsellers' => 24566,
                    'ps_newproducts' => 24671,
                    'ps_specials' => 24672,
                ],
            ],
            'block_text' => [
                'modules' => [
                    'ps_customtext' => 22317,
                ],
            ],
            'banner' => [
                'modules' => [
                    'ps_banner' => 22313,
                ],
            ],
            'social_newsletter' => [
                'modules' => [
                    'ps_emailsubscription' => 22318,
                    'ps_socialfollow' => 22323,
                ],
            ],
            'footer' => [
                'modules' => $footerModules,
                'pages' => [
                    'AdminStores' => [
                        $this->l('Shop details'),
                        $this->l('Display additional information about your store or how to contact you to make it easy for your customers to reach you.'),
                    ],
                ],
            ],
        ];
    }

    /**
     * Get category list of modules to show
     *
     * @return array
     */
    public function getCategoryListConfiguration()
    {
        if ($this->isPsVersion174Plus) {
            $category = [
                'sfRoutePages' => [
                    'admin_product_preferences' => [
                        $this->l('Pagination'),
                        $this->l('Set the numbers of products you want to display per page and how.'),
                    ],
                ],
            ];
            $footerModules = [
                'blockreassurance' => 22312,
                'ps_linklist' => 24360,
            ];

            $menu = [
                'pages' => [
                    'AdminCmsContent' => [
                        $this->l('Content pages'),
                        $this->l('Add and manage your content pages to make your store interesting and trustworthy.'),
                    ],
                    'AdminManufacturers' => [
                        $this->l('Brands and Suppliers'),
                        $this->l('Manage both your brands and suppliers at the same place !'),
                    ],
                ],
                'modules' => [
                    'ps_mainmenu' => 22321,
                ],
            ];
        } else {
            $category = [
                'pages' => [
                    'AdminPPreferences' => [
                        $this->l('Pagination'),
                        $this->l('Set the numbers of products you want to display per page and how.'),
                    ],
                ],
            ];
            $footerModules = [
                'ps_linklist' => 24360,
            ];

            $menu = [
                'pages' => [
                    'AdminCmsContent' => [
                        $this->l('Content pages'),
                        $this->l('Add and manage your content pages to make your store interesting and trustworthy.'),
                    ],
                    'AdminManufacturers' => [
                        $this->l('Brands and Suppliers'),
                        $this->l('Manage both your brands and suppliers at the same place !'),
                    ],
                ],
                'modules' => [
                    'ps_mainmenu' => 22321,
                ],
            ];
        }

        return [
            'menu' => $menu,
            'categories' => [
                'pages' => [
                    'AdminCategories' => [
                        $this->l('Categories'),
                        $this->l('Create a full range of Categories and Subcategories to classify your products, add categoryies desciptions and manage your catalog easily.'),
                    ],
                ],
            ],
            'navigation_column' => [
                'modules' => [
                    'ps_categorytree' => 22314,
                    'ps_facetedsearch' => 23867,
                ],
            ],
            'content' => $category,
            'social_newsletter' => [
                'modules' => [
                    'ps_emailsubscription' => 22318,
                    'ps_socialfollow' => 22323,
                ],
            ],
            'footer' => [
                'modules' => $footerModules,
                'pages' => [
                    'AdminStores' => [
                        $this->l('Shop details'),
                        $this->l('Display additional information about your store or how to contact you to make it easy for your customers to reach you.'),
                    ],
                ],
            ],
        ];
    }

    /**
     * Get product list of modules to show
     *
     * @return array
     */
    public function getProductListConfiguration()
    {
        if ($this->isPsVersion174Plus) {
            $productManagement = [
                'sfRoutePages' => [
                    'admin_product_catalog' => [
                        $this->l('Catalog'),
                        $this->l('Access your list of products to manage your catalog efficiently.'),
                    ],
                    'admin_stock_overview' => [
                        $this->l('Stock'),
                        $this->l('Manage your stock and edit product quantities right here.'),
                    ],
                ],
                'pages' => [
                    'AdminAttributesGroups' => [
                        $this->l('Product attributes'),
                        $this->l('Create or manage your attributes : colors, sizes, materials, ...'),
                    ],
                ],
            ];
            $productDetailsModules = [
                'blockreassurance' => 22312,
                'ps_sharebuttons' => 22322,
            ];
            if (version_compare(_PS_VERSION_, '1.7.6', '>=')) {
                $productDetailsModules['productcomments'] = 9144;
            }
        } else {
            $productManagement = [
                'sfRoutePages' => [
                    'admin_product_catalog' => [
                        $this->l('Catalog'),
                        $this->l('Access your list of products to manage your catalog efficiently.'),
                    ],
                ],
                'pages' => [
                    'AdminAttributesGroups' => [
                        $this->l('Product attributes'),
                        $this->l('Create or manage your attributes : colors, sizes, materials, ...'),
                    ],
                    'AdminPPreferences' => [
                        $this->l('Quantities and stock availability'),
                        $this->l('Choose the way you display quantities and stock availability on your product page.'),
                    ],
                    'AdminStockManagement' => [
                        $this->l('Stock'),
                        $this->l('Manage your stock and edit product quantities right here.'),
                    ],
                ],
            ];
            $productDetailsModules = [
                'ps_sharebuttons' => 22322,
            ];
        }

        return [
            'menu' => [
                'pages' => [
                    'AdminCategories' => [
                        $this->l('Categories'),
                        $this->l('Create here a full range of categories and subcategories to classify your products and manage your catalog easily.'),
                    ],
                    'AdminCmsContent' => [
                        $this->l('Content pages'),
                        $this->l('Add and manage your content pages to make your store interesting and trustworthy.'),
                    ],
                    'AdminManufacturers' => [
                        $this->l('Brands and Suppliers'),
                        $this->l('Manage both your brands and suppliers at the same place !'),
                    ],
                ],
                'modules' => [
                    'ps_mainmenu' => 22321,
                ],
            ],
            'product_management' => $productManagement,
            'product_detail' => [
                'modules' => $productDetailsModules,
            ],
            'product_block' => [
                'modules' => [
                    'ps_categoryproducts' => 24588,
                    'ps_viewedproduct' => 24674,
                    'ps_crossselling' => 24696,
                ],
            ],
            'social_newsletter' => [
                'modules' => [
                    'ps_emailsubscription' => 22318,
                    'ps_socialfollow' => 22323,
                ],
            ],
            'footer' => [
                'pages' => [
                    'AdminStores' => [
                        $this->l('Shop details'),
                        $this->l('Display additional information about your store or how to contact you to make it easy for your customers to reach you.'),
                    ],
                ],
                'modules' => [
                    'ps_linklist' => 24360,
                ],
            ],
        ];
    }

    /**
     * Initialize the content by adding Boostrap and loading the TPL
     */
    public function initContent()
    {
        parent::initContent();

        if (Module::isInstalled('ps_mbo')) {
            $selectionModulePage = $this->context->link->getAdminLink('AdminPsMboModule');
        } else {
            $selectionModulePage = $this->context->link->getAdminLink('AdminModulesCatalog');
        }
        $installedModulePage = $this->context->link->getAdminLink('AdminModulesManage');

        $homepageListToConfigure = $this->getHomepageListConfiguration();
        $categoryListToConfigure = $this->getCategoryListConfiguration();
        $productListToConfigure = $this->getProductListConfiguration();

        $this->context->smarty->assign([
            'enable' => $this->getModule()->active,
            'moduleName' => $this->getModule()->displayName,
            'bootstrap' => 1,
            'configure_type' => $this->controller_quick_name,
            'iconConfiguration' => $this->getModule()->img_path . '/controllers/configuration/icon_configurator.png',
            'listCategories' => $this->categoryList,
            'homePageList' => $this->setFinalList($homepageListToConfigure),
            'categoryPageList' => $this->setFinalList($categoryListToConfigure),
            'productPageList' => $this->setFinalList($productListToConfigure),
            'selectionModulePage' => $selectionModulePage,
            'installedModulePage' => $installedModulePage,
            'moduleImgUri' => $this->getModule()->img_path . '/controllers/configuration/',
            'moduleActions' => $this->aModuleActions,
            'moduleActionsNames' => $this->moduleActionsNames,
            'themeConfiguratorUrl' => $this->context->link->getAdminLink(
                'AdminModules',
                true,
                [],
                ['configure' => 'ps_themeconfigurator']
            ),
            'ps_uri' => $this->getModule()->ps_uri,
        ]);

        $aJsDef = [
            'admin_module_controller_psthemecusto' => $this->getModule()->controller_name[1],
            'admin_module_ajax_url_psthemecusto' => $this->getModule()->front_controller[1],
            'module_action_sucess' => $this->l('Action on the module successfully completed'),
            'module_action_failed' => $this->l('Action on module failed'),
        ];
        $jsPath = [$this->getModule()->js_path . '/controllers/' . $this->controller_quick_name . '/back.js'];
        $cssPath = [$this->getModule()->css_path . '/controllers/' . $this->controller_quick_name . '/back.css'];

        $this->getModule()->setMedia($aJsDef, $jsPath, $cssPath);
        $this->setTemplate($this->getModule()->template_dir . 'page.tpl');
    }

    /**
     * AJAX : Do a module action like Install, disable, enable ...
     *
     * @return mixed
     */
    public function ajaxProcessUpdateModule()
    {
        if (!$this->getModule()->hasEditRight()) {
            exit($this->l('You do not have permission to edit this.'));
        }

        $sModuleName = pSQL(Tools::getValue('module_name'));
        $sModuleAction = pSQL(Tools::getValue('action_module'));
        $oModule = Module::getInstanceByName($sModuleName);
        $sUrlActive = $oModule->isEnabled($oModule->name) ? 'configure' : 'enable';

        switch ($sModuleAction) {
            case 'uninstall':
                $oModule->uninstall();
                $sUrlActive = 'install';
            break;
            case 'install':
                $oModule->install();
                $sUrlActive = method_exists($oModule, 'getContent') ? 'configure' : 'disable';
            break;
            case 'enable':
                $oModule->enable();
                $sUrlActive = method_exists($oModule, 'getContent') ? 'configure' : 'disable';
            break;
            case 'disable':
                $oModule->disable();
                $sUrlActive = 'enable';
            break;
            case 'disable_mobile':
                $oModule->disableDevice(Context::DEVICE_MOBILE);
                $sUrlActive = method_exists($oModule, 'getContent') ? 'configure' : 'disable';
            break;
            case 'enable_mobile':
                $oModule->enableDevice(Context::DEVICE_MOBILE);
                $sUrlActive = method_exists($oModule, 'getContent') ? 'configure' : 'disable';
            break;
            case 'reset':
                $oModule->uninstall();
                $oModule->install();
                $sUrlActive = method_exists($oModule, 'getContent') ? 'configure' : 'disable';
            break;
            default:
                exit(0);
        }

        $aModule['id_module'] = $oModule->id;
        $aModule['name'] = $oModule->name;
        $aModule['displayName'] = $oModule->displayName;
        $aModule['url_active'] = $sUrlActive;
        $aModule['active'] = ThemeCustoRequests::getModuleDeviceStatus($oModule->id);
        $aModule['actions_url']['configure'] = $this->context->link->getAdminLink('AdminModules', true, [], ['configure' => $oModule->name]);
        $aModule['can_configure'] = method_exists($oModule, 'getContent') ? true : false;
        $aModule['enable_mobile'] = (int) Db::getInstance()->getValue('SELECT enable_device FROM ' . _DB_PREFIX_ . 'module_shop WHERE id_module = ' . (int) $oModule->id);

        $this->context->smarty->assign([
            'module' => $aModule,
            'moduleActions' => $this->aModuleActions,
            'moduleActionsNames' => $this->moduleActionsNames,
        ]);

        $this->ajaxDie($this->context->smarty->fetch(__DIR__ . '/../../views/templates/admin/controllers/' . $this->controller_quick_name . '/elem/module_actions.tpl'));
    }

    /**
     * get list to show
     *
     * @param array $aList
     *
     * @return array
     */
    public function setFinalList($aList)
    {
        $modulesOnDisk = Module::getModulesDirOnDisk();
        $aModuleFinalList = [];

        foreach ($aList as $sSegmentName => $aElementListByType) {
            foreach ($aElementListByType as $sType => $aElementsList) {
                if ($sType == 'pages') {
                    foreach ($aElementsList as $sController => $aPage) {
                        $aModuleFinalList[$sSegmentName][$sType][$sController]['name'] = $sController;
                        $aModuleFinalList[$sSegmentName][$sType][$sController]['displayName'] = $this->l($aPage[0]);
                        $aModuleFinalList[$sSegmentName][$sType][$sController]['url'] = $this->context->link->getAdminLink($sController);
                        $aModuleFinalList[$sSegmentName][$sType][$sController]['description'] = $this->l($aPage[1]);
                        $aModuleFinalList[$sSegmentName][$sType][$sController]['action'] = $this->l('Configure');
                    }
                } elseif ($sType == 'sfRoutePages') {
                    $container = PrestaShop\PrestaShop\Adapter\SymfonyContainer::getInstance();
                    foreach ($aElementsList as $sController => $aPage) {
                        $aModuleFinalList[$sSegmentName][$sType][$sController]['name'] = $sController;
                        $aModuleFinalList[$sSegmentName][$sType][$sController]['displayName'] = $this->l($aPage[0]);
                        $aModuleFinalList[$sSegmentName][$sType][$sController]['url'] = $container->get('router')->generate($sController);
                        $aModuleFinalList[$sSegmentName][$sType][$sController]['description'] = $this->l($aPage[1]);
                        $aModuleFinalList[$sSegmentName][$sType][$sController]['action'] = $this->l('Configure');
                    }
                } else {
                    foreach ($aElementsList as $sModuleName => $iModuleId) {
                        if (!in_array($sModuleName, $modulesOnDisk)) {
                            continue;
                        }
                        $module = Module::getInstanceByName($sModuleName);
                        if (!($module instanceof Module)) {
                            continue;
                        }

                        $aModuleFinalList[$sSegmentName][$sType][$sModuleName] = $this->setModuleFinalList($module, Module::isInstalled($sModuleName));
                    }
                }
            }
            if (!isset($aModuleFinalList[$sSegmentName])) {
                $aModuleFinalList[$sSegmentName] = null;
            }
            if (isset($aModuleFinalList[$sSegmentName]['modules'])
                && is_array($aModuleFinalList[$sSegmentName]['modules'])
                && is_callable([$this, 'sortArrayInstalledModulesFirst'])) {
                uasort($aModuleFinalList[$sSegmentName]['modules'], [$this, 'sortArrayInstalledModulesFirst']);
            }
        }

        return $aModuleFinalList;
    }

    /**
     * Render final list of modules
     *
     * @param Module $oModuleInstance
     * @param bool $bIsInstalled
     *
     * @return array
     */
    public function setModuleFinalList($oModuleInstance, $bIsInstalled)
    {
        $aModule = [];

        $aModule['id_module'] = $oModuleInstance->id;
        $aModule['active'] = $oModuleInstance->active;

        if ($bIsInstalled === true) {
            $aModule['can_configure'] = (method_exists($oModuleInstance, 'getContent')) ? true : false;
            if (method_exists($oModuleInstance, 'getContent')) {
                $aModule['url_active'] = $this->l(($oModuleInstance->active ? 'configure' : 'enable'));
            } else {
                $aModule['url_active'] = $this->l(($oModuleInstance->active ? 'disable' : 'enable'));
            }
            $aModule['installed'] = 1;
        } else {
            $aModule['can_configure'] = false;
            $aModule['url_active'] = 'install';
            $aModule['installed'] = 0;
        }

        $aModule['enable_mobile'] = (int) Db::getInstance()->getValue('SELECT enable_device FROM ' . _DB_PREFIX_ . 'module_shop WHERE id_module = ' . (int) $oModuleInstance->id);
        $aModule['name'] = $oModuleInstance->name;
        $aModule['displayName'] = $oModuleInstance->displayName;
        $aModule['description'] = $oModuleInstance->description;
        $aModule['controller_name'] = (isset($oModuleInstance->controller_name) ? $oModuleInstance->controller_name : '');
        $aModule['logo'] = '/modules/' . $oModuleInstance->name . '/logo.png';
        $aModule['actions_url']['configure'] = $this->context->link->getAdminLink('AdminModules', true, [], ['configure' => $oModuleInstance->name]);

        return $aModule;
    }

    /**
     * Order Final array for having installed module first
     *
     * @param array $a
     * @param array $b
     *
     * @return int
     */
    public function sortArrayInstalledModulesFirst($a, $b)
    {
        return strcmp($b['installed'], $a['installed']);
    }

    /**
     * @return ps_themecusto
     */
    private function getModule()
    {
        /* @phpstan-ignore-next-line */
        return $this->module;
    }
}
