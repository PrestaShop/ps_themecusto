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

<div id="psthemecusto" class="panel col-lg-12">
    <div class="panel-heading">
        {l s='Advanced CSS customisation' mod='psthemecusto'}
    </div>
    <div class="row">
        <div class="col-ld-12">
            <p>{l s='You can edit your theme\'s CSS style sheet by using the Parent/Child theme feature' mod='psthemecusto'}:</p>
        </div>
        <div class="col-ld-12">
            <div class="col-lg-3">
                <h4>1 - {l s='Download a child theme' mod='psthemecusto'}</h4>
                <div class="col-lg-12">
                    <p>{l s='A child theme allows you to change small aspects of your site\'s appearance yet still preserve your theme\'s look and functionnality' mod='psthemecusto'}.</p>
                    <div class="btn btn-primary btn-lg btn-block" rel="noopener" id="download_child_theme">
                        {l s='Download child theme' mod='psthemecusto'}
                    </div>
                    <div class="btn btn-primary btn-lg btn-block js-loader" rel="noopener" >
                        {l s='Downloading' mod='psthemecusto'}<div class="loader"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-lg-push-1">
                <h4>2 - {l s='Edit child theme CSS style sheet' mod='psthemecusto'}</h4>
                <div class="col-lg-12">
                    <p>{l s='A child theme allows you to change small aspects of your site\'s appearance yet still preserve your theme\'s look and functionnality' mod='psthemecusto'}.</p>
                    <a href="https://developers.prestashop.com/themes/smarty/parent-child-feature.html" class="btn btn-outline-secondary btn-lg btn-block" rel="noopener" target="_blank">{l s='How to use parents/child themes' mod='psthemecusto'}</a>
                </div>
            </div>
            <div class="col-lg-3 col-lg-push-2">
                <h4>3 - {l s='Upload child theme' mod='psthemecusto'}</h4>
                <div class="col-lg-12">
                    <p>{l s='Using a child theme lets you upgrade the parent theme without affecting the customizations you\'ve made to your site' mod='psthemecusto'}.</p>
                    <a href="#" class="btn btn-primary btn-lg btn-block" rel="noopener" data-toggle="modal" data-target="#upload-child-modal">{l s='Upload child theme' mod='psthemecusto'}</a>
                </div>
                {include file="./elem/modal.tpl"}
            </div>
        </div>
    </div>
</div>

