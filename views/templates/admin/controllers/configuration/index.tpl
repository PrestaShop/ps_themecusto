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
<div id="psthemecusto">
    <div class="panel col-lg-12">
        <div class="panel-heading">
            {l s='Change the color, the typo and the place of the logo' mod='psthemecusto'}
        </div>
        <div class="row">
            <div class="col-lg-1">
                <i class="process-icon-edit" aria-hidden="true"></i>
            </div>
            <div class="col-lg-9">
                <p>
                    {l s='Use the Theme Configurator module to customize the main graphic elements of your site' mod='psthemecusto'}:<br/>
                    {l s='colors, buttons, typography and position of your logo.' mod='psthemecusto'}.
                </p>
            </div>
            <div class="col-lg-2">
                <a href="#" class="btn btn-primary btn-lg btn-block" rel="noopener">{l s='Configure' mod='psthemecusto'}</a>
            </div>
        </div>
    </div>

    <div class="panel col-lg-12">
        <div class="panel-heading">
            {l s='Modules place\'s' mod='psthemecusto'}
        </div>
        <div class="row">
            <div class="col-lg-5 wireframe">
                <img src="/modules/psthemecusto/views/img/wireframe/wireframe_base.jpg">
            </div>
            <div class="col-lg-7 module-list">
                {foreach from=$modulesList item=module}
                <div class="row configuration-rectangle">
                    <div class="col-lg-12 js-module-name" data-module_name="{$module.name}">
                        {$module.displayName}
                    </div>
                    <div class="col-lg-12 module-informations">
                        <div class="col-lg-1">
                            <img class="module-logo" src="{$module.logo}"/>
                        </div>
                        <div class="col-lg-9">
                            {$module.description}
                        </div>
                        <div class="col-lg-2">
                            <a class="btn btn-primary btn-lg btn-block" href="{$module.url}">{l s='Configure' mod='psthemecusto'}</a>
                        </div>
                    </div>
                </div>
                {/foreach}
                <div class="row">
                    <div class="col-lg-4 col-lg-offset-8">
                        <a class="btn btn-primary btn-lg btn-block" href="{$modulesPage}">{l s='See all theme\'s modules' mod='psthemecusto'}</a>
                    </div>
                </div>
            </div
        </div>
    </div>
</div>
