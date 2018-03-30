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
    {if $is_ps_ready}
    <div class="panel col-lg-12">
        <div class="panel-heading">
            {l s='Change the color, the typo and the place of the logo' mod='psthemecusto'}
        </div>
        <div class="row">
            <div class="col-lg-1">
                {* <i class="process-icon-edit" aria-hidden="true"></i> *}
                <img src="{$iconConfiguration}"/>
            </div>
            <div class="col-lg-9">
                <p>
                    {l s='Use the Theme Configurator module to customize the main graphic elements of your site' mod='psthemecusto'}:<br/>
                    {l s='colors, buttons, typography and position of your logo.' mod='psthemecusto'}.
                </p>
            </div>
            <div class="col-lg-2">
                <a href="{$themeConfiguratorUrl}" target="_blank" class="btn btn-primary btn-lg btn-block" rel="noopener">{l s='Configure' mod='psthemecusto'}</a>
            </div>
        </div>
    </div>
    {/if}
    <div class="panel col-lg-12">
        <div class="panel-heading">
            {l s='Modules place\'s' mod='psthemecusto'}
        </div>
        <div class="row">
            <div class="col-lg-5">
                {include file="./elem/wireframe.tpl"}
            </div>
            <div class="col-lg-7 module-list">
                {foreach from=$elementsList key=categoryname item=categories name=cat}
                <div class="row configuration-rectangle">
                    <div class="col-lg-12 js-module-name js-title-{$categoryname}" data-module_name="{$categoryname}">
                        <span class="col-lg-11">
                            {l s=$listCategories[$categoryname] mod='psthemecusto'}
                        </span>
                        <span class="col-lg-1 configuration-rectangle-caret">
                            <i class="material-icons down">keyboard_arrow_down</i>
                            <i class="material-icons up">keyboard_arrow_up</i>
                        </span>
                    </div>
                    {foreach from=$categories key=type item=elements}
                        {if $type == 'pages'}
                            {foreach from=$elements item=page}
                                <div class="col-lg-12 module-informations">
                                    <div class="col-lg-12">
                                        <div class="col-lg-1">
                                            <i class="icon-cogs"></i>
                                        </div>
                                        <div class="col-lg-11">
                                            <b>{l s=$page.displayName mod='psthemecusto'}</b>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="col-lg-8 col-lg-offset-1">
                                            {l s=$page.description mod='psthemecusto'}
                                        </div>
                                        <div class="col-lg-3 general-action">
                                            <a class="col-lg-12 no-radius-right btn btn-primary-reverse btn-outline-primary light-button" href="{$page.url}" target="_blank">
                                                {l s=$page.action|capitalize mod='psthemecusto'}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            {/foreach}
                        {else}
                            {foreach from=$elements item=module name=mods}
                                <div class="col-lg-12 module-informations">
                                    <div class="col-lg-12">
                                        <div class="col-lg-1">
                                            <img class="module-logo" src="{$module.logo}"/>
                                        </div>
                                        <div class="col-lg-11">
                                            <b>{$module.displayName}</b>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="col-lg-8 col-lg-offset-1">
                                            {$module.description}
                                        </div>
                                        <div class="col-lg-3">
                                            {include file="./elem/module_actions.tpl"}
                                        </div>
                                    </div>
                                </div>
                            {/foreach}
                        {/if}
                    {foreachelse}
                        <div class="col-lg-12 module-informations">
                            <div class="col-lg-12">
                                <div class="col-lg-1">
                                    <i class="material-icons hidden-xs">extension</i>
                                </div>
                                <div class="col-lg-11">
                                    <b>{l s='There is no module for this section' mod='psthemecusto'}</b>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="col-lg-8 col-lg-offset-1">
                                    {l s='You can install a module for this section from our Modules Selection' mod='psthemecusto'}
                                </div>
                                <div class="col-lg-3 general-action">
                                    <a class="col-lg-12 no-radius-right btn btn-primary-reverse btn-outline-primary light-button" href="{$modulesPage}" target="_blank">
                                        {l s='See modules selection' mod='psthemecusto'}
                                    </a>
                                </div>
                            </div>
                        </div>
                    {/foreach}
                </div>
                {/foreach}
                <div class="row">
                    <div class="col-lg-4 col-lg-offset-8">
                        <a class="btn btn-primary btn-lg btn-block" href="{$modulesPage}#built-in_modules">{l s='See all theme\'s modules' mod='psthemecusto'}</a>
                    </div>
                </div>
            </div
        </div>
    </div>
    {include file="./elem/modal.tpl"}
</div>

