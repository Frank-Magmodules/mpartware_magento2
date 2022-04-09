/**
 *  Amasty swatch render mixin. Hiding simple product price that is part of configurable product
 */

 define([
    'jquery',
    'underscore',
], function ($, _) {
    'use strict';

    return function (widget) {
        $.widget('mage.SwatchRenderer', widget, {
            options: {
                selectors: {
                    buttons: '.box-tocart, .tocart',
                    optionSelected: 'data-option-selected',
                    attributeId: 'data-attribute-id'
                }
            },

            _UpdatePrice: function () {
                var $widget = this,
                    $selectors = $widget.options.selectors,
                    $product = $widget.element.parents($widget.options.selectorProduct),
                    $productPrice = $product.find($widget.options.selectorProductPrice),
                    $productButton = $product.find($selectors.buttons),
                    options = _.object(_.keys($widget.optionsMap), {}),
                    selectedValues = [],
                    result,
                    isNotAllSelected;

                $widget.element
                    .find('.' + $widget.options.classes.attributeClass + '[' + $selectors.optionSelected + ']')
                    .each(function () {
                        options[$(this).attr($selectors.attributeId)] = $(this).attr($selectors.optionSelected);
                    });

                for (const property in options) {
                    selectedValues.push(options[property]);
                }

                isNotAllSelected = selectedValues.some(function (element) {
                    return typeof element === 'undefined';
                });

                result = $widget._getNewPrices();

                if (!isNotAllSelected) {
                    this._super();
                }

                if (result && result.finalPrice && result.finalPrice.amount === 0 && !isNotAllSelected) {
                    $productPrice.hide();
                    $productButton.hide();
                } else {
                    $productPrice.show();
                    $productButton.show();
                }
            },

            _RenderSwatchOptions: function (config, controlId) {
                var optionConfig = this.options.jsonSwatchConfig[config.id],
                    optionClass = this.options.classes.optionClass,
                    moreLimit = parseInt(this.options.numberToShow, 10),
                    moreClass = this.options.classes.moreButton,
                    moreText = this.options.moreButtonText,
                    countAttributes = 0,
                    html = '';

                if (!this.options.jsonSwatchConfig.hasOwnProperty(config.id)) {
                    return '';
                }

                $.each(config.options, function (index) {
                    var id,
                        type,
                        value,
                        thumb,
                        label,
                        width,
                        height,
                        attr;

                    if (!optionConfig.hasOwnProperty(this.id)) {
                        return '';
                    }

                    // Add more button
                    if (moreLimit === countAttributes++) {
                        html += '<a href="#" class="' + moreClass + '"><span>' + moreText + '</span></a>';
                    }

                    id = this.id;

                    let dataProductId = '';
                    if (config.options[index].id === id) {
                        dataProductId = config.options[index].products[0];
                    }

                    index = index + 1;
                    type = parseInt(optionConfig[id].type, 10);
                    value = optionConfig[id].hasOwnProperty('value') ?
                        $('<i></i>').text(optionConfig[id].value).html() : '';
                    thumb = optionConfig[id].hasOwnProperty('thumb') ? optionConfig[id].thumb : '';
                    width = 125;
                    height = 115;
                    label = this.label ? $('<i></i>').text(this.label).html() : '';
                    attr =
                        ' id="' + controlId + '-item-' + id + '"' +
                        ' index="' + index + '"' +
                        ' aria-checked="false"' +
                        ' aria-describedby="' + controlId + '"' +
                        ' tabindex="0"' +
                        ' data-option-type="' + type + '"' +
                        ' data-option-id="' + id + '"' +
                        ' data-option-label="' + label + '"' +
                        ' data-product-id="' + dataProductId + '"' +
                        ' aria-label="' + label + '"' +
                        ' role="option"' +
                        ' data-thumb-width="' + width + '"' +
                        ' data-thumb-height="' + height + '"';

                    attr += thumb !== '' ? ' data-option-tooltip-thumb="' + thumb + '"' : '';
                    attr += value !== '' ? ' data-option-tooltip-value="' + value + '"' : '';

                    if (!this.hasOwnProperty('products') || this.products.length <= 0) {
                        attr += ' data-option-empty="true"';
                    }

                    if (type === 0) {
                        // Text
                        html += '<div class="' + optionClass + ' text" ' + attr + '>' + (value ? value : label) +
                            '</div>';
                    } else if (type === 1) {
                        // Color
                        html += '<div class="' + optionClass + ' color" ' + attr +
                            ' style="background: ' + value +
                            ' no-repeat center; background-size: initial;">' + '' +
                            '</div>';
                    } else if (type === 2) {
                        // Image            
                        html += '<div class="opt-class-container"><div class="' + optionClass + ' image" ' + attr +
                            ' style="background: url(' + value + ') no-repeat center; background-size: initial;width:' +
                            width + 'px; height:' + height + 'px">' + '' +
                            '</div><span>' + label + '</span></div>';
                    } else if (type === 3) {
                        // Clear
                        html += '<div class="' + optionClass + '" ' + attr + '></div>';
                    } else {
                        // Default
                        html += '<div class="' + optionClass + '" ' + attr + '>' + label + '</div>';
                    }
                });

                return html;
            },
            _OnClick: function ($this, $widget) {

                var $parent = $this.parents('.' + $widget.options.classes.attributeClass),
                    $wrapper = $this.parents('.' + $widget.options.classes.attributeOptionsWrapper),
                    $label = $parent.find('.' + $widget.options.classes.attributeSelectedOptionLabelClass),
                    attributeId = $parent.data('attribute-id'),
                    $input = $parent.find('.' + $widget.options.classes.attributeInput),
                    checkAdditionalData = JSON.parse(this.options.jsonSwatchConfig[attributeId]['additional_data']),
                    $priceBox = $widget.element.parents($widget.options.selectorProduct)
                        .find(this.options.selectorProductPrice);

                if ($widget.inProductList) {
                    $input = $widget.productForm.find(
                        '.' + $widget.options.classes.attributeInput + '[name="super_attribute[' + attributeId + ']"]'
                    );
                }


                if ($this.hasClass('disabled')) {
                    return;
                }

                if ($this.hasClass('selected')) {
                    $parent.removeAttr('data-option-selected').find('.selected').removeClass('selected');
                    $input.val('');
                    $label.text('');
                    $this.attr('aria-checked', false);
                } else {
                    $parent.attr('data-option-selected', $this.data('option-id')).find('.selected').removeClass('selected');
                    $label.text($this.data('option-label'));
                    $input.val($this.data('option-id'));
                    $input.attr('data-attr-name', this._getAttributeCodeById(attributeId));
                    $this.addClass('selected');
                    $widget._toggleCheckedAttributes($this, $wrapper);
                }

                $widget._Rebuild();

                if ($priceBox.is(':data(mage-priceBox)')) {
                    $widget._UpdatePrice();
                }

                $(document).trigger('updateMsrpPriceBlock',
                    [
                        this._getSelectedOptionPriceIndex(),
                        $widget.options.jsonConfig.optionPrices,
                        $priceBox
                    ]);

                if (parseInt(checkAdditionalData['update_product_preview_image'], 10) === 1) {
                    $widget._loadMedia();
                }

                $input.trigger('change');

                let selectedId = $this.attr('data-product-id'),
                    pSub1de = $widget.options.jsonConfig.dynamic.sub1de[selectedId].value,
                    pSub2de = $widget.options.jsonConfig.dynamic.sub2de[selectedId].value,
                    pSku = $widget.options.jsonConfig.dynamic.sku[selectedId].value,
                    pPrice = $widget.options.jsonConfig.dynamic.price[selectedId].value,
                    pSubline = pSub1de + ' ' + pSub2de,
                    swatchLabel = $('.swatch-attribute-label').text() + ':',
                    swatchTitle = $widget.options.jsonConfig.dynamic.name[selectedId].value,
                    $additionalInfoArticle = $('.additional-info');

                    console.log($widget.options.jsonConfig.dynamic);

                $('.attribute-list').find('.sub2').text(pSubline)

                if ($('.items .item.product').length > 0) {
                    $('.items .item.product').attr('title', swatchTitle).text(swatchTitle);
                }

                $('.addinfo > p').html('<span><strong>Art.Nr.:</strong> '+ pSku +'</span>');
                $('.price').text(parseFloat(pPrice).toFixed(2) + ' €');


                $additionalInfoArticle.find('.p-label').attr('title', swatchLabel).text(swatchLabel);
                $additionalInfoArticle.find('.p-title').attr('title', swatchTitle).text(swatchTitle);
                $additionalInfoArticle.find('.p-sub').text(pSubline);

                $('.page-title .base').text(swatchTitle);
            },
        });

        return $.mage.SwatchRenderer;
    }
});
