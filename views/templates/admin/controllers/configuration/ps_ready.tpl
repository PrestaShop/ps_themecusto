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
<div class="panel col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="panel-heading">
        {l s='Change colors, typography and your logo position' mod='ps_themecusto'}
    </div>
    <div class="row">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <img src="{$iconConfiguration}"/>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
            <p>
                {l s='Use the Theme configurator module to customize the main graphic elements of your website : colors, buttons, typography, logo position.' mod='ps_themecusto'}:
                <br/>
            </p>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <a href="{$themeConfiguratorUrl}" class="btn btn-primary btn-lg btn-block" rel="noopener">
                {l s='Configure' mod='ps_themecusto'}
            </a>
        </div>
    </div>
</div>
