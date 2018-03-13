/**
* 2007-2018 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2018 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/
$(document).ready(function() {

    $(document).on('click', '#download_child_theme', function(){
        $.ajax({
            type: 'POST',
            url: admin_module_ajax_url_psthemecusto,
            dataType: 'html',
            data: {
                controller : admin_module_controller_psthemecusto,
                action : 'DownloadChildTheme',
                ajax : true
            },
            beforeSend : function(data) {
                $('#download_child_theme').hide();
                $('.js-loader').fadeIn();
            },
            success : function(data) {
                $('.js-loader').hide();
                $('#download_child_theme').fadeIn();
                window.location = data;
            }
        });
    });

    $('body').on('click', '.module-import-start-select-manual', function(event, manual_select) {
        event.preventDefault();
        $('#importDropzone').trigger( "click" );
    });
    Dropzone.options.importDropzone = {
        acceptedFiles: '.zip',
        maxFiles: 1,
        maxFilesize: 50, // File size in Mb
        dictDefaultMessage: '',
        hiddenInputContainer: '#importDropzone',
        success: function(file, response){
            $('.modal-body .row').html(response);
        },
        error: function(file, response){
            $('.modal-body .row').html('not ok !');
        }
    };
});

