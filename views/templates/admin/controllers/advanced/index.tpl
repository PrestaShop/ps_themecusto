{**
 * 2007-2020 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}

<div id="psthemecusto">
    <div class="panel col-lg-12">
        <div class="panel-heading">
            {l s='Advanced Customization' mod='ps_themecusto'}
        </div>
        <div class="row">
            <div class="col-ld-12">
                <p>{l s='You can edit your theme sheet by using the Parent/Child theme feature' mod='ps_themecusto'}:</p>
            </div>
            {if $isPsReady}
            <div class="alert alert-warning" role="alert">
                <b>{l s='Advanced use only.' mod='ps_themecusto'}</b>
                <p class="alert-text">
                    {l s='Support team might not be able to assist you on issues created by your own child theme.' mod='ps_themecusto'}
                </p>
            </div>
            {/if}
            <div class="col-ld-12 steps">
                <div class="col-lg-3">
                    <div class="col-lg-12 center-img">
                        <img src="{$images}download.png"/>
                    </div>
                    <b>1 - {l s='Download your current theme' mod='ps_themecusto'}</b>
                    <div class="col-lg-12">
                        <p>{l s='You picked a theme but still want to bring some specific adjustments? Get a child theme, it will allow you to keep the parts you want and customize the others!' mod='ps_themecusto'}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-lg-push-1">
                    <div class="col-lg-12 center-img">
                        <img src="{$images}edit.png"/>
                    </div>
                    <b>2 - {l s='Edit your child theme' mod='ps_themecusto'}</b>
                    <div class="col-lg-12">
                        <p>{l s='Once the child theme created, next step is simple: apply the changes you want within the desired files, it will handle the customization part while keeping the parent theme’s look and functionality.' mod='ps_themecusto'}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-lg-push-2">
                    <div class="col-lg-12 center-img">
                        <img src="{$images}reupload.png"/>
                    </div>
                    <b>3 - {l s='Upload your child theme' mod='ps_themecusto'}</b>
                    <div class="col-lg-12">
                        <p>{l s='As you only bring modification to the child theme, you can upgrade the parent theme easily, without losing your customization.' mod='ps_themecusto'}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-buttons">
            <div class="col-lg-3">
                <div class="alert alert-danger download_child_theme_error" role="alert">
                    <b>{l s='An error occurred' mod='ps_themecusto'}</b>
                    <p class="alert-text">{l s='Please check that you have the rights to write to the folders /app/cache/ and /themes/' mod='ps_themecusto'}</p>
                </div>
                <div class="btn btn-primary btn-lg btn-block" rel="noopener" id="download_child_theme">
                    {l s='Download theme' mod='ps_themecusto'}
                </div>
                <div class="btn btn-primary btn-lg btn-block js-loader" rel="noopener" >
                    {l s='Downloading' mod='ps_themecusto'}<div class="loader"></div>
                </div>
            </div>
            <div class="col-lg-3 col-lg-push-1">
                <a href="https://devdocs.prestashop.com/1.7/themes/reference/template_inheritance/parent_child_feature/" class="link-child btn btn-outline-secondary btn-lg btn-block" rel="noopener" target="_blank">{l s='How to use parents/child themes' mod='ps_themecusto'} <i class="icon-external-link"></i></a>
            </div>
            <div class="col-lg-3 col-lg-push-2">
                <a href="#" class="btn btn-primary btn-lg btn-block" rel="noopener" data-toggle="modal" data-target="#upload-child-modal" >{l s='Upload child theme' mod='ps_themecusto'}</a>
            </div>
        </div>
        <div class="alert alert-info col-lg-12" role="alert">
            <b>{l s='Information' mod='ps_themecusto'}</b>
            {if $isPsReady}
                <p class="alert-text">{l s='By using this method you can only override the CSS of your theme.' mod='ps_themecusto'}</p>
            {else}
                <p class="alert-text">{l s='By using this method you can override the CSS and html of your theme, and add analytics tags.' mod='ps_themecusto'}</p>
            {/if}
            <p class="alert-text">{l s='Once uploaded, the child theme will be available in your Theme & Logo section' mod='ps_themecusto'}</p>
        </div>
        {include file="./elem/modal.tpl"}
    </div>
</div>
