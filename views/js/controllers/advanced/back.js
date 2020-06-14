/**
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
                $('.download_child_theme_error').hide();
                if (!data) {
                    $('.download_child_theme_error').show();
                } else {
                    window.location = data;
                }
            }
        });
    });

    $('body').on('click', '.module-import-start-select-manual', function(event, manual_select) {
        event.preventDefault();
        $('#importDropzone').trigger('click');
    });

    $('body').on('click', '.module-import-failure-details-action', function() {
        event.preventDefault();
        $('.module-import-failure-details').slideDown();
    });

    $('body').on('click', '.module-import-failure-retry', function() {
        event.preventDefault();
        $('.module-import-start').show();
        $('.module-import-failure').hide();
    });

    $("#upload-child-modal").on("hidden.bs.modal", function () {
        $('.module-import-start').show();
        $('.module-import-failure').hide();
        $('.module-import-success').hide();
    });
});

Dropzone.options.importDropzone = {
    acceptedFiles: 'application/zip,application/x-zip-compressed,application/x-zip',
    maxFiles: 1,
    maxFilesize: 50, // File size in Mb
    dictDefaultMessage: '',
    hiddenInputContainer: '#importDropzone',
    init: function() {
        var self = this;
        self.on("addedfile", function(file) {
            $('.module-import-start').hide();
            $('.module-import-failure-details').html(file_not_valid);
        });
    },

    sending: function sending() {
        $('.modal .loader').show();
        $('.module-import-start').hide();
        $('.module-import-failure').hide();
        $('.module-import-success').hide();
    },
    success: function(file, response){
        if (response.length == 0) {
            response = '{"state":0, "message":"'+default_error_upload+'"}';
        }
        let treatment = JSON.parse(response);

        $('.modal .loader').hide();
        $('.modal .module-import-failure-details').hide();
        switch (treatment.state) {
            case 0:
                $('.module-import-failure').show();
                $('.module-import-failure-details').html(treatment.message);
                break;
            case 1:
                $('.module-import-success').show();
                $('.module-import-success-msg').html(treatment.message);
                break;
        }
        this.removeAllFiles();
    },
    error: function(file, response){
        $('.modal .loader').hide();
        $('.module-import-failure').show();
    }
};
