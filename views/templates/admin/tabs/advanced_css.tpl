{*
* 2007-2018 PrestaShop
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
* @author    PrestaShop SA <contact@prestashop.com>
* @copyright 2007-2018 PrestaShop SA
* @license   http://addons.prestashop.com/en/content/12-terms-and-conditions-of-use
* International Registered Trademark & Property of PrestaShop SA
*}

<div class="panel col-lg-12">
    <div class="panel-heading">
        {l s='Advanced CSS customisation' mod='psthemecusto'}
    </div>
    <div>
        <p>{l s='You can edit your theme\'s CSS style sheet by using the Parent/Child theme feature' mod='psthemecusto'}:</p>
        <div class="col-lg-3">
            <h4>1 - {l s='Download a child theme' mod='psthemecusto'}</h4>
            <div class="col-lg-12">
                {l s='A child theme allows you to change small aspects of your site\'s appearance yet still preserve your theme\'s look and functionnality' mod='psthemecusto'}.
                <span class="btn btn-primary btn-lg btn-block" rel="noopener" id="download_child_theme">{l s='Download child theme' mod='psthemecusto'}</span>
            </div>
        </div>
        <div class="col-lg-3 col-md-offset-1">
            <h4>2 - {l s='Edit child theme CSS style sheet' mod='psthemecusto'}</h4>
            <div class="col-lg-12">
                {l s='A child theme allows you to change small aspects of your site\'s appearance yet still preserve your theme\'s look and functionnality' mod='psthemecusto'}.
                <a href="#" class="btn btn-primary btn-lg btn-block" rel="noopener">{l s='How to use parents/child themes' mod='psthemecusto'}</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-offset-1">
            <h4>3 - {l s='Upload child theme' mod='psthemecusto'}</h4>
            <div class="col-lg-12">
                {l s='Using a child theme lets you upgrade the parent theme without affecting the customizations you\'ve made to your site' mod='psthemecusto'}.
                <a href="#" class="btn btn-primary btn-lg btn-block" rel="noopener" data-toggle="modal" data-target="#upload-child-modal">{l s='Upload child theme' mod='psthemecusto'}</a>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="upload-child-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title module-modal-title" id="exampleModalLongTitle">{l s='Upload child theme' mod='psthemecusto'}</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="#" class="dropzone dz-clickable" id="importDropzone">
                                        <div class="module-import-start">
                                            <i class="module-import-start-icon material-icons">cloud_upload</i><br>
                                            <p class="module-import-start-main-text">
                                                Drop your module archive here or <a href="#" class="module-import-start-select-manual">select file</a>
                                            </p>
                                            <p class="module-import-start-footer-text">
                                                Please upload one file at a time, .zip or tarball format (.tar, .tar.gz or .tgz).
                                                Your module will be installed right after that.
                                            </p>
                                        </div>
                                        <input type="hidden" name="action" value="UploadChildTheme" />
                                        <div class="dz-default dz-message"><span></span></div><input name="childthemefile" type="file" multiple="multiple" class="dz-hidden-input" accept=".zip, .tar" style="visibility: hidden; position: absolute; top: 0px; left: 0px; height: 0px; width: 0px;">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

