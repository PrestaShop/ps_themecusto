{**
 * 2007-2020 PrestaShop SA and Contributors
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
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
<div class="loader src_loader_{$module.name}"></div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 btn-group form-action-button-container src_parent_{$module.name}" data-id_module="{$module.id_module}" >
    {if $module.url_active != 'install'}
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 no-padding general-action" data-module_name="{$module.name}" data-action="{$module.url_active }" data-module_displayname="{$module.displayName}">
            {if $module.url_active == 'configure'}
            <a class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-radius-right btn btn-primary-reverse btn-outline-primary light-button module_action_menu_{$module.url_active}" href="{$module.actions_url.configure}">
                {l s='Configure' mod='ps_themecusto'}
            </a>
            {elseif $module.url_active == 'disable' }
            <button type="button" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-radius-right btn btn-primary-reverse btn-outline-primary light-button module_action_menu_{$module.url_active}" data-confirm_modal="module-modal-confirm-{$module.name}-{$module.url_active}" data-toggle="modal" data-target="#moduleActionModal">
                {l s='Disable' mod='ps_themecusto'}
            </button>
            {else}
            <button type="button" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-radius-right btn btn-primary-reverse btn-outline-primary light-button module_action_menu_{$module.url_active}" data-confirm_modal="module-modal-confirm-{$module.name}-{$module.url_active}" >
                {l s='Enable' mod='ps_themecusto'}
            </button>
            {/if}
        </div>

        <input type="hidden" class="btn">

        <button type="button" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 btn btn-outline-primary dropdown-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">keyboard_arrow_down</i>
        </button>
        <div class="dropdown-menu">
            {foreach from=$moduleActions item=action key=key}
                {if ($action != $module.url_active)
                    && !($module.url_active eq 'configure' && $action eq 'enable')
                    && !($module.url_active eq 'enable' && $action eq 'disable')
                    && !($module.url_active eq 'disable' && $action eq 'enable')
                    && !($module.url_active eq 'disable' && $action eq 'configure')
                    && !(!$module.can_configure && $action eq 'configure')
                    && !(($module.active eq 3 || $module.active eq 0) && $action eq 'disable_mobile')
                    && !(($module.active eq 7 || $module.active eq 1 || $module.active eq 0) && $action eq 'enable_mobile')
                    && !($action eq 'install')
                    && !($action eq 'uninstall' && $is_ps_ready)
                    && !($action eq 'install' && $is_ps_ready)
                }
                <li>
                    <div data-action="{$action}" data-module_name="{$module.name}" data-module_displayname="{$module.displayName}">
                        {if $action eq 'uninstall' || $action eq 'disable' || $action eq 'reset'}
                        <button type="button" class="dropdown-item module_action_menu_{$action}" data-confirm_modal="module-modal-confirm-{$module.name}-{$action}" data-toggle="modal" data-target="#moduleActionModal">
                            {if $action eq 'uninstall'}
                                {l s='Uninstall' mod='ps_themecusto'}
                            {elseif $action eq 'disable'}
                                {l s='Disable' mod='ps_themecusto'}
                            {elseif $action eq 'reset'}
                                {l s='Reset' mod='ps_themecusto'}
                            {/if}
                        </button>
                        {else if $action eq 'configure'}
                        <a class="dropdown-item module_action_menu_configure" href="{$module.actions_url.configure}">
                            {l s='Configure' mod='ps_themecusto'}
                        </a>
                        {else}
                        <button type="button" class="dropdown-item module_action_menu_{$action}">
                            {if $action eq 'enable'}
                                {l s='Enable' mod='ps_themecusto'}
                            {elseif $action eq 'enable_mobile'}
                                {l s='Enable mobile' mod='ps_themecusto'}
                            {elseif $action eq 'disable_mobile'}
                                {l s='Disable mobile' mod='ps_themecusto'}
                            {/if}
                        </button>
                        {/if}

                    </div>
                </li>
                {/if}
            {/foreach}
        </div>
    {else}
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding general-action" data-module_name="{$module.name}" data-action="{$module.url_active }" data-module_displayname="{$module.displayName}">
            <button type="button" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-radius-right btn btn-primary-reverse btn-outline-primary light-button module_action_menu_{$module.url_active}" data-confirm_modal="module-modal-confirm-{$module.name}-{$module.url_active}" >
                {l s='Install' mod='ps_themecusto'}
            </button>
        </div>
    {/if}
</div>
