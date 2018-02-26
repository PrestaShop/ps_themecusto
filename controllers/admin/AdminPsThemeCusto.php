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

use PrestaShop\PrestaShop\Core\Addon\Theme\ThemeManagerBuilder;


class AdminPsThemeCustoController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->theme_manager = (new ThemeManagerBuilder($this->context, Db::getInstance()))->build();
        $this->theme_repository = (new ThemeManagerBuilder($this->context, Db::getInstance()))->buildRepository();
    }

    public function initContent()
    {
        /* VOIR https://gitlab.com/ps-addons/psgiftcards/blob/master/controllers/front/Giftcards.php */
        parent::initContent();
        $this->context->smarty->assign(array(
            'bootstrap'         =>  1,
            'configure_type'    => 'advanced_css'
        ));
        $this->module->setMedia();
        $this->setTemplate( $this->module->template_dir.'page.tpl');
    }

    public function ajaxProcessDownloadChildTheme()
    {
        die($this->module->createChildTheme());   
    }

    public function ajaxProcessUploadChildTheme()
    {
        $aChildThemeReturned = Tools::fileAttachment('file');
        self::processUploadFileChild( $aChildThemeReturned, _PS_ALL_THEMES_DIR_.$aChildThemeReturned['rename']);
        self::postProcessInstall(_PS_ALL_THEMES_DIR_.$aChildThemeReturned['rename']);
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

        if (!$this->module->hasEditRight()) {
            return $this->l("You do not have permission to edit this.");
        }

        $exporter = $kernel->getContainer()->get('prestashop.core.addon.theme.exporter');
        $path = $exporter->export($this->context->shop->theme);
        $aPath = array_reverse(explode("/", $path));
        $sThemeZipPath = "/themes/".$aPath[0];

        return $sThemeZipPath;
    }

    public function processUploadFileChild($aChildThemeReturned, $dest)
    {
        if (!$this->module->hasEditRight()) {
            return $this->l("You do not have permission to edit this.");
        }

        switch ($aChildThemeReturned['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $this->errors[] = $this->trans('The uploaded file is too large.', array(), 'Admin.Design.Notification');
                return false;
            default:
                $this->errors[] = $this->trans('Unknown error.', array(), 'Admin.Notifications.Error');
                return false;
        }

        $tmp_name = $aChildThemeReturned['tmp_name'];
        $mimeType = false;
        $goodMimeType = false;

        if (function_exists('finfo_open')) {
            $finfo = @finfo_open(FILEINFO_MIME);
            $mimeType = @finfo_file($finfo, $tmp_name);
            @finfo_close($finfo);
        } elseif (function_exists('mime_content_type')) {
            $mimeType = @mime_content_type($tmp_name);
        } elseif (function_exists('exec')) {
            $mimeType = trim(@exec('file -b --mime-type '.escapeshellarg($tmp_name)));
            if (!$mimeType) {
                $mimeType = trim(@exec('file --mime '.escapeshellarg($tmp_name)));
            }
            if (!$mimeType) {
                $mimeType = trim(@exec('file -bi '.escapeshellarg($tmp_name)));
            }
        }

        if (!empty($mimeType)) {
            preg_match('#application/zip#', $mimeType, $matches);
            if (!empty($matches)) {
                $goodMimeType = true;
            }
        }

        if (false === $goodMimeType) {
            $this->errors[] = $this->trans('Invalid file format.', array(), 'Admin.Design.Notification');
            return false;
        }

        $name = $aChildThemeReturned['name'];
        if (!Validate::isFileName($name)) {
            $dest = _PS_ALL_THEMES_DIR_.sha1_file($tmp_name).'.zip';
        }

        if (!move_uploaded_file(
            $aChildThemeReturned['tmp_name'],
            $dest
        )) {
            $this->errors[] = $this->trans('Failed to move uploaded file.', array(), 'Admin.Design.Notification');
            return false;
        }

        return $dest;
    }

    public function postProcessInstall($dest)
    {
        if (!$this->module->hasEditRight()) {
            return $this->l("You do not have permission to edit this.");
        }

        $this->theme_manager->install($dest);
        @unlink($dest);
        $aFolderScan = @scandir(_PS_ALL_THEMES_DIR_);
        // var_dump($aFolderScan);
        foreach ($aFolderScan as $key => $sObject) {
            $sDirThemeFolder = _PS_ALL_THEMES_DIR_.$sObject;
            if (is_dir($sDirThemeFolder) && !in_array($sObject,array('.','..'))) {
                $aFolder[$sDirThemeFolder] = filemtime($sDirThemeFolder);
            }
        }
        arsort($aFolder);
        // $sChildThemeFolder = array_keys($aFolder[0]);
        var_dump($sChildThemeFolder);
    }

}
