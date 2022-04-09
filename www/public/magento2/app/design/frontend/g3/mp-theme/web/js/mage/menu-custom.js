define([
    'jquery',
    'jquery/ui',
    'mage/menu'],
    function($){
        $.widget('inchoo.menu', $.mage.menu, {
            _assignControls: function () {
                this.controls = {
                    toggleBtn: $('[data-action="toggle-nav"]'),
                    swipeArea: $('.blowmymind')
                };
    
                return this;
            },
    
            //_toggleMobileMode: function () {
            //    $(this.element).off('mouseenter mouseleave');
            //    this._on({
            //        "click .ui-menu-item:has(a)": function (event) {
            //            event.preventDefault();
    //
            //            var target = $(event.target).closest(".ui-menu-item");
    //
            //            if (!target.hasClass('level-top') || !target.has(".ui-menu").length) {
            //                window.location.href = target.find('> a').attr('href');
            //            }
            //        }
            //    });
    //
            //    var subMenus = this.element.find('.level-top');
            //    $.each(subMenus, $.proxy(function (index, item) {
            //        var category = $(item).find('> a span').not('.ui-menu-icon').text(),
            //            categoryUrl = $(item).find('> a').attr('href'),
            //            menu = $(item).find('> .ui-menu');
    //
            //        this.categoryLink = $('<a>')
            //            .attr('href', categoryUrl)
            //            .text($.mage.__('Boah ey ') + category);
    //
            //        this.categoryParent = $('<li>')
            //            .addClass('ui-menu-item all-category')
            //            .html(this.categoryLink);
    //
            //        if (menu.find('.all-category').length === 0) {
            //            menu.prepend(this.categoryParent);
            //        }
    //
            //    }, this));
            //}
        });
    return $.inchoo.menu;
});