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

<div class="btn-group form-action-button-container" id="module-actions">
	<form class="btn-group form-action-button" method="post" action="{$module.url}" data-module_name="{$module.name}">
		<button type="button" class="btn btn-primary-reverse btn-outline-primary light-button module_action_menu_{$module.url_active}"
				data-confirm_modal="module-modal-confirm-{$module.name}-{$module.url_active}">
			{$module.url_active|capitalize}
		</button>
	</form>
	<input type="hidden" class="btn">
	<button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<span class="caret"></span>
		<span class="sr-only">Toggle Dropdown</span>
	</button>
	<div class="dropdown-menu">
		{foreach from=$moduleActions item=action key=key}
			{if $action != $module.url_active}
			<li>
				<form method="post" action="{$module.actions_url.$action}" data-action="{$action}" data-module_name="{$module.name}" data-module_displayname="{$module.displayName}">
					{if $action eq 'uninstall' || $action eq 'disable'}
					<button type="button" class="dropdown-item module_action_menu_{$action}" data-confirm_modal="module-modal-confirm-{$module.name}-{$action}" data-toggle="modal" data-target="#moduleActionModal">
					{else}
					<button type="button" class="dropdown-item module_action_menu_{$action}">
					{/if}
						{$moduleActionsNames.$key|capitalize}
					</button>
				</form>
			</li>
			{/if}
		{/foreach}
	</div>
</div>
