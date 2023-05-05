define([
    'jquery',
    'mage/url'
], function ($, url) {
    'use strict';

    $.widget('ultraplugin.soldQty', {
        options: {
            soldQtyLabelSelector: '#sold-qty-label',
            soldQtyBlockSelector: '#sold-qty-block'
        },

        _create: function () {
            if (this.options.isSoldQtyEnabled) {
                this._callAjax();
            }
        },

        _callAjax: function () {
            var self = this;
            $.ajax({
                url: url.build('up_solqty/index/soldqty'),
                type: 'POST',
                data: {
                    productId: self.options.productId
                },
                showLoader: false,
                success: function(response) {
                    if (response.display == true) {
                        $(self.options.soldQtyLabelSelector).html(response.label);
                        $(self.options.soldQtyBlockSelector).show();
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    });

    return $.ultraplugin.soldQty;
});
