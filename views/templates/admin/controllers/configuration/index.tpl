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

<div id="psthemecusto" class="container-fluid clearfix">
    {if $isPsReady}
        {include file="./ps_ready.tpl"}
    {/if}

    <div class="panel row">
        <div class="panel-heading text-center">
            <button class="btn btn-primary btn-lg selected" data-id-modal="homepageModal">{l s='Homepage' mod='ps_themecusto'}</button>
            <button class="btn btn-primary btn-lg" data-id-modal="categoryModal">{l s='Category page' mod='ps_themecusto'}</button>
            <button class="btn btn-primary btn-lg" data-id-modal="productModal">{l s='Product page' mod='ps_themecusto'}</button>
        </div>

        {include file="./dropdownList.tpl" elementsList=$homePageList idModal='homepage' defaultModalClass='' }
        {include file="./dropdownList.tpl" elementsList=$categoryPageList idModal='category' defaultModalClass='hide'}
        {include file="./dropdownList.tpl" elementsList=$productPageList idModal='product' defaultModalClass='hide'}
    </div>

    {include file="./elem/modal.tpl"}
</div>

