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
            success : function(data) {
                window.location = data;
            }
        });
    });

    $('body').on('click', '.module-import-start-select-manual', function(event, manual_select) {
        $('.dz-hidden-input').trigger( "click" );
    });
   
    $('.dz-hidden-input').on('change', function(){
        var isUploadStarted = false;
        Dropzone.options.importDropzone = {
            acceptedFiles: '.zip',
            maxFiles: 1,
            maxFilesize: 10, // File size in Mb
            dictDefaultMessage: '',
            hiddenInputContainer: '#importDropzone', 
            addedfile: function() {
                // State that we start module upload
                isUploadStarted = true;
                $('.module-import-start').hide(0);
                dropzone.css('border', 'none');
                $('.module-import-processing').fadeIn();
            },
            processing: function () {
                // Leave it empty since we don't require anything while processing upload
            },
            error: function (file, message) {
                $('.module-import-processing').finish().fadeOut(function() {
                    $('.module-import-failure-details').html(message);
                    $('.module-import-failure').fadeIn();
                });
            },
            complete: function (file) {
                if (file.status !== 'error') {
                    var responseObject = jQuery.parseJSON(file.xhr.response);
                    if (typeof responseObject.is_configurable === 'undefined') responseObject.is_configurable = null;
                    if (typeof responseObject.module_name === 'undefined') responseObject.module_name = null;

                    $('.module-import-processing').finish().fadeOut(function() {
                        if (responseObject.status === true) {
                            if (responseObject.is_configurable === true) {
                                var configureLink = self.baseAdminDir + 'module/manage/action/configure/' + responseObject.module_name + window.location.search;
                                $('.module-import-success-configure').attr('href', configureLink);
                                $('.module-import-success-configure').show();
                            }
                            $('.module-import-success').fadeIn();
                        } else {
                            $('.module-import-failure-details').html(responseObject.msg);
                            $('.module-import-failure').fadeIn();
                        }
                    });
                }
                // State that we have finish the process to unlock some actions
                isUploadStarted = false;
            }
        }

    });

});

