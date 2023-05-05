define([
    'jquery',
    'mage/url'
], function ($, url) {
    'use strict';

    $.widget('ultraplugin.leftQty', {
        options: {
            leftQtyLabelSelector: '#left-qty-label',
            leftQtyBlockSelector: '#left-qty-block'
        },

        _create: function () {
            if (this.options.isLeftQtyEnabled) {
                this._callAjax();
            }
        },

        _callAjax: function () {
            var self = this;
            $.ajax({
                url: url.build('up_solqty/index/leftQty'),
                type: 'POST',
                data: {
                    sku: self.options.sku,
                    typeId: self.options.typeId
                },
                showLoader: false,
                success: function(response) {
                    if (response.display == true) {
                        $(self.options.leftQtyLabelSelector).html(response.label);
                        $(self.options.leftQtyBlockSelector).show();
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    });

    return $.ultraplugin.leftQty;
});
