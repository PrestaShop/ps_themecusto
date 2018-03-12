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
<div class="loader src_loader_{$module.name}"></div>
<div class="col-lg-12 btn-group form-action-button-container src_parent_{$module.name}" data-id_module="{$module.id_module}" >
	<div class="col-lg-9 no-padding" data-module_name="{$module.name}" data-action="{$module.url_active }" data-module_displayname="{$module.displayName}">
		{if $module.url_active == 'configure'}
		<a class="col-lg-12 no-radius-right btn btn-primary-reverse btn-outline-primary light-button module_action_menu_{$module.url_active}" href="{$module.actions_url.configure}">
			{$module.url_active|capitalize}
		</a>
		{else}
		<button type="button" class="col-lg-12 no-radius-right btn btn-primary-reverse btn-outline-primary light-button module_action_menu_{$module.url_active}" data-confirm_modal="module-modal-confirm-{$module.name}-{$module.url_active}" >
			{$module.url_active|capitalize}
		</button>
		{/if}
	</div>
	<input type="hidden" class="btn">
	<button type="button" class="col-lg-3 btn btn-outline-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<span class="caret"></span>
		<span class="sr-only">Toggle Dropdown</span>
	</button>
	<div class="dropdown-menu">
		{foreach from=$moduleActions item=action key=key}
			{if ($action != $module.url_active)
				&& !($module.url_active eq 'configure' && $action eq 'enable')
				&& !($module.url_active eq 'enable' && $action eq 'disable')
				&& !(($module.active eq 3 || $module.active eq 0) && $action eq 'disable_mobile')
				&& !(($module.active eq 7 || $module.active eq 0)  && $action eq 'enable_mobile')
				&& !($action eq 'install')
			}
			<li>
				<div data-action="{$action}" data-module_name="{$module.name}" data-module_displayname="{$module.displayName}">
					{if $action eq 'uninstall' || $action eq 'disable' || $action eq 'reset'}
					<button type="button" class="dropdown-item module_action_menu_{$action}" data-confirm_modal="module-modal-confirm-{$module.name}-{$action}" data-toggle="modal" data-target="#moduleActionModal">
					{else}
					<button type="button" class="dropdown-item module_action_menu_{$action}">
					{/if}
						{$moduleActionsNames.$key|capitalize}
					</button>
				</div>
			</li>
			{/if}
		{/foreach}
	</div>
</div>
