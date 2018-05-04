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

class AdminPsThemeCustoAdvancedController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->sandbox_path = _PS_CACHE_DIR_.'sandbox/';
        $this->controller_quick_name = 'advanced';
        $this->theme_manager = (new ThemeManagerBuilder($this->context, Db::getInstance()))->build();
        $this->theme_repository = (new ThemeManagerBuilder($this->context, Db::getInstance()))->buildRepository();
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

        $this->context->smarty->assign(array(
            'enable'            => $this->module->active,
            'moduleName'        => $this->module->displayName,
            'bootstrap'         => 1,
            'configure_type'    => $this->controller_quick_name,
            'images'            => $this->module->img_path."/controllers/advanced/",
            'is_ps_ready'       => $this->module->ready,
        ));
        $aJsDef = array(
            'admin_module_controller_psthemecusto'  => $this->module->controller_name[0],
            'admin_module_ajax_url_psthemecusto'    => $this->module->front_controller[0],
            'default_error_upload'                  => $this->l('An error occured, please check your zip file'),
            'file_not_valid'                        => $this->l('The file must be a ZIP file (.zip)'),
        );
        $aJs = array(
            $this->module->js_path.'/controllers/'.$this->controller_quick_name.'/back.js',
            $this->module->js_path.'/controllers/'.$this->controller_quick_name.'/dropzone.js'
        );
        $aCss = array($this->module->css_path.'/controllers/'.$this->controller_quick_name.'/back.css');
        $this->module->setMedia($aJsDef, $aJs, $aCss);

        $this->setTemplate($this->module->template_dir.'page.tpl');
    }

    /**
     * Clone a theme and modify the config to set the parent theme
     *
     * @param none
     * @return bool
    */
    public function ajaxProcessDownloadChildTheme()
    {
        global $kernel;

        if (!$this->module->hasEditRight()) {
            return $this->l("You do not have permission to edit this.");
        }

        $exporter = $kernel->getContainer()->get('prestashop.core.addon.theme.exporter');
        $path = $exporter->export($this->context->shop->theme);
        $aPath = array_reverse(explode('/', $path));
        $sThemeZipPath = $this->module->ps_uri.'/themes/'.$aPath[0];

        die($sThemeZipPath);
    }

    /**
     * AJAX getting a file attachment and will upload the file, install it, check if there's modules in it ...
     *
     * @param none
     * @return string
     */
    public function ajaxProcessUploadChildTheme()
    {
        $aChildThemeReturned = Tools::fileAttachment('file');
        $sZipPath = self::processUploadFileChild($aChildThemeReturned, $this->sandbox_path.$aChildThemeReturned['rename']);
        $bZipFormat = self::processCheckZipFormat($sZipPath);
        if (!$bZipFormat) {
            $aReturn = array(
                'state'     => 0,
                'message'   => $this->l('Make sure you zip your edited theme files directly to the root of your child theme\'s folder before uploading it.')
            );
            die(Tools::jsonEncode($aReturn));
        }

        $bUploadIsClean = self::processCheckFiles($sZipPath, $this->sandbox_path.rand());

        if (!$bUploadIsClean) {
            $aReturn = array(
                'state'     => 0,
                'message'   => $this->l('There is some PHP files in your ZIP')
            );
            die(Tools::jsonEncode($aReturn));
        }

        $sFolderPath = self::postProcessInstall($sZipPath);
        $aReturn = array();

        if ($sFolderPath === false) {
            @unlink($sZipPath);
            $aReturn = array(
                'state'     => 0,
                'message'   => $this->l('The theme already exists or the parent name in the config file is wrong')
            );
            die(Tools::jsonEncode($aReturn));
        }

        if (!self::checkIfIsChildTheme($sFolderPath)) {
            self::recursiveDelete($sFolderPath);
            $aReturn = array(
                'state'     => 0,
                'message'   => $this->l('You must enter the parent theme name in the theme.yml file. Furthermore, the parent name must be the current parent theme.')
            );
            die(Tools::jsonEncode($aReturn));
        }

        $aReturn = array(
            'state'         => 1,
            'message'       => $this->l('The child theme has been added successfully.')
        );

        die(Tools::jsonEncode($aReturn));
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

        $mimeType = self::processCheckMimeType($tmp_name);

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

    /**
     * Get the mime type of the file
     *
     * @param string $tmp_name
     * @return string $mimeType
     */
    public function processCheckMimeType($tmp_name)
    {
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

        return $mimeType;
    }

    /**
     * We check if the Zip is valid. The root folder must have all the theme element, we check it with the folder Config.
     *
     * @param string $sZipPath
     * @return bool $bZipIsValid
     */
    public function processCheckZipFormat($sZipPath)
    {
        $oZip = new ZipArchive;
        $oZip->open($sZipPath);

        for($i = 0; $i < $oZip->numFiles; $i++)
        {
            $aZipElement  = array_filter(explode('/', $oZip->getNameIndex($i)));
            if (count($aZipElement) == 1) {
                $aRootFilesAndFolders[] = $aZipElement[0];
            }
        }

        $oZip->close();

        if (in_array('config', $aRootFilesAndFolders)) {
            $bZipIsValid = true;
        } else {
            $bZipIsValid = false;
            @unlink($sZipPath);
        }

        return $bZipIsValid;
    }

    /**
     * We unzip the child theme zip in a sandbox to check it
     *
     * @param string $sZipSource
     * @param string $sSandboxPath
     * @return bool $bCleanFiles
     */
    public function processCheckFiles($sZipSource, $sSandboxPath)
    {
        if (!$this->module->hasEditRight()) {
            return $this->l("You do not have permission to edit this.");
        }

        Tools::ZipExtract($sZipSource, $sSandboxPath);
        $bCleanFiles = self::getDirPhpContents($sZipSource, $sSandboxPath);
        self::recursiveDelete($sSandboxPath);

        return $bCleanFiles;
    }

    /**
     * We check if there is some PHP files
     *
     * @param string $sSandboxPath
     * @param reference array $sSandboxPath
     * @return bool
    */
    public function getDirPhpContents($sZipSource, $sSandboxPath)
    {
        $files = scandir($sSandboxPath);
        $sPattern = '#[.\-\/](php)#';
        $sIndexPhpFile = Tools::getDefaultIndexContent();

        $zip = new ZipArchive;
        $it = new RecursiveDirectoryIterator($sSandboxPath, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($files as $file) {
            if (!$file->isDir()) {
                $sSubject = $file->getFilename().self::processCheckMimeType($file->getRealPath());
                if ($file->getFilename() === 'index.php') {
                    if ($zip->open($sZipSource)) {
                        $sRealPathFile = str_replace($sSandboxPath."/", '', $file->getRealPath());
                        $zip->deleteName($sRealPathFile);
                        $zip->addFromString($sRealPathFile, $sIndexPhpFile);
                    }
                } elseif (preg_match($sPattern, $sSubject)){
                    $zip->close();
                    return false;
                }
            }
        }

        $zip->close();
        return true;
    }

    /**
     * We install the child theme and we return the folder child theme's name
     *
     * @param string
     * @return string
    */
    public function postProcessInstall($dest)
    {
        if (!$this->module->hasEditRight()) {
            return $this->l("You do not have permission to edit this.");
        }

        try {
            $this->theme_manager->install($dest);
            @unlink($dest);
            $aFolderScan = @scandir(_PS_ALL_THEMES_DIR_);

            foreach ($aFolderScan as $key => $sObject) {
                $sDirThemeFolder = _PS_ALL_THEMES_DIR_.$sObject;
                if (is_dir($sDirThemeFolder) && !in_array($sObject,array('.', '..'))) {
                    $aFolder[filemtime($sDirThemeFolder)] = $sDirThemeFolder;
                }
            }

            krsort($aFolder);
            $aChildthemeFolder = array_values($aFolder);
            return $aChildthemeFolder[0];
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * We check in theme.yml if this theme is a child theme of the current main theme.
     *
     * @param string
     * @return bool
    */
    public function checkIfIsChildTheme($sFolderPath)
    {
        $sFile = "theme.yml";
        $aLines = file($sFolderPath.'/config/'.$sFile);
        $sSearchString = "parent:";
        $bIsChildTheme = false;

        foreach ($aLines as $line) {
            if (strpos($line, $sSearchString) !== false) {
                $aParentThemeName = explode(":", $line);
                $sParentThemeName = trim($aParentThemeName[1]);
                if ($sParentThemeName == _THEME_NAME_) {
                    $bIsChildTheme = true;
                }
                break;
            }
        }

        return $bIsChildTheme;
    }

    /**
     * the child theme has modules. We can't keep it.
     *
     * @param string
     * @return bool
     */
    public function recursiveDelete($sFolderPath)
    {
        $it = new RecursiveDirectoryIterator($sFolderPath, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->isDir()) {
                @rmdir($file->getRealPath());
            } else {
                @unlink($file->getRealPath());
            }
        }
        return @rmdir($sFolderPath);
    }

}
