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

<div class="content-div">
    <div class="grid">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            {if $enable}
                {include file="./controllers/$configure_type/index.tpl"}
            {else}
                <div class="panel col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h4>{l s='The module %s has been disabled' sprintf=$moduleName mod='ps_themecusto'}</h4>
                </div>
            {/if}
        </div>
    </div>
</div>
