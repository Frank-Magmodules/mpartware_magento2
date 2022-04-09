/* jshint node: true */
require([
    'jquery',
    'swiper',
    'matchMedia'
], function ($, Swiper, mediaCheck) {
    var lang = navigator.language || navigator.userLanguage;
    //var Swiper = window.Swiper;

    function pfe(selector, callback) {
        var obj = $(selector);
        if (obj.length > 0) {
            callback.call(obj, obj);
        } else {
            window.setTimeout(function () {
                pfe(selector, callback);
            }, 50);
        }
    }

    $(document).ready(function () {
        var headerSwiper = new Swiper('.swiper-container.swiper-1', {
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                type: 'bullets',
                clickable: true,
            },
            autoplay: {
                delay: 8000,
            },
            speed: 1000,
            preloadImages: true,
            lazy: true,
            fadeEffect: {
                crossFade: true
            },
        });

        //startpage testimonials
        var contentSwiper = new Swiper('.testimonial-slider .swiper-container', {
            //direction: 'horizontal',
            loop: true,
            //lazy: true,
            pagination: {
                el: '.testimonial-slider .swiper-pagination',
                type: 'bullets',
                clickable: true,
                renderBullet: function (index, className) {
                    var src = [];
                    $($(this.el).find('.slider_thumb_img').get()).each(function (index) {
                        src[index] = $(this).attr('src');
                    });
                    return '<span class="' + className + '">' + '<img class="bullet-thumb" src="' + src[index + 1] + '"></span>';
                },
            },
            navigation: {
                nextEl: '.testimonial-slider .swiper-button-next',
                prevEl: '.testimonial-slider .swiper-button-prev',
            },
        });

        mediaCheck({
            media: '(min-width: 768px)',
            // Switch to Desktop Version
            entry: function () {
                if ($('.mobile-shop-links .header.links').length > 0) {
                    $('.right-part').append($('.mobile-shop-links .header.links'));
                }
                if ($('body').hasClass('mobile')) {
                    $('body').removeClass('mobile');
                }

                $('body').addClass('desktop');

                pfe('.cms-katalog-bestellen label[for="radio-inlay-0"]', function (obj) {
                    $('.field-anrede, .field-textinput-1611845626212, .field-firstname, .field-lastname, .field-email, .field-textinput-1611846167405, .field-textinput-1611846776329 , .field-textinput-1611846169733, .field-textinput-1611846846012, .field-country-1611846337843').wrapAll('<div class="left-col"></div>');
                    $('.field-checkboxtwo-1611846423254, .field-textinput-1611846479458, .field-textinput-1611846512907, .field-textinput-1611846532434, .field-textinput-1611846564482, .field-textinput-1611846600993').wrapAll('<div class="right-col"></div>');
                    $('.field-textarea-1611846637154, .field-text-1611846689113, .field-text-1611846740418, .field-radio-inlay, .amcform-gdpr, .amcform-toolbar').wrapAll('<div class="full-col"></div>');
                });

                pfe('.cms-order-catalog label[for="radiotwo-1611846920957-0"]', function (obj) {
                    $('.field-dropdown-1611845529131, .field-textinput-1611845626212, .field-textinput-1611845668548, .field-textinput-1611845680427, .field-textinput-1611846017645, .field-textinput-1611846167405, .field-textinput-1611846776329, .field-textinput-1611846169733, .field-textinput-1611846846012, .field-country-1611846337843').wrapAll('<div class="left-col"></div>');
                    $('.field-checkboxtwo-1611846423254, .field-textinput-1611846479458, .field-textinput-1611846512907, .field-textinput-1611846532434, .field-textinput-1611846564482, .field-textinput-1611846600993').wrapAll('<div class="right-col"></div>');
                    $('.field-textarea-1611846637154, .field-text-1611846689113, .field-text-1611846740418, .field-radiotwo-1611846920957, .amcform-gdpr, .amcform-toolbar').wrapAll('<div class="full-col"></div>');
                });
            },
            // Switch to Mobile Version
            exit: function () {
                if ($('.right-part .header.links').length > 0) {
                    $('.mobile-shop-links').append($('.right-part .header.links'));
                }

                if ($('body').hasClass('desktop')) {
                    $('body').removeClass('desktop');
                }

                $('body').addClass('mobile');

                pfe('.cms-katalog-bestellen label[for="radio-inlay-0"]', function (obj) {
                    $('.field-anrede, .field-textinput-1611845626212, .field-firstname, .field-lastname, .field-email, .field-textinput-1611846167405, .field-textinput-1611846776329 , .field-textinput-1611846169733, .field-textinput-1611846846012, .field-country-1611846337843').appendTo('#page-0');
                    $('.field-checkboxtwo-1611846423254, .field-textinput-1611846479458, .field-textinput-1611846512907, .field-textinput-1611846532434, .field-textinput-1611846564482, .field-textinput-1611846600993').appendTo('#page-0');
                    $('.field-textarea-1611846637154, .field-text-1611846689113, .field-text-1611846740418, .field-radio-inlay, .amcform-gdpr, .amcform-toolbar').appendTo('#page-0');
                    $('.left-col, .right-col, .full-col').remove();
                });

                pfe('.cms-order-catalog label[for="radiotwo-1611846920957-1"]', function (obj) {
                    $('.field-dropdown-1611845529131, .field-textinput-1611845626212, .field-textinput-1611845668548, .field-textinput-1611845680427, .field-textinput-1611846017645, .field-textinput-1611846167405, .field-textinput-1611846776329, .field-textinput-1611846169733, .field-textinput-1611846846012, .field-country-1611846337843').appendTo('#page-0');
                    $('.field-checkboxtwo-1611846423254, .field-textinput-1611846479458, .field-textinput-1611846512907, .field-textinput-1611846532434, .field-textinput-1611846564482, .field-textinput-1611846600993').appendTo('#page-0');
                    $('.field-textarea-1611846637154, .field-text-1611846689113, .field-text-1611846740418, .field-radiotwo-1611846920957, .amcform-gdpr, .amcform-toolbar').appendTo('#page-0');
                    $('.left-col, .right-col, .full-col').remove();
                });
            }
        });

        if ($('.form-edit-account').length > 0) {
            if ($('#assistance_allowed_checkbox').length > 0) {
                $('#assistance_allowed_checkbox').parent().remove();
            }
        }

        //$('#search').on('click', function () {
        //    setTimeout(function () {
        //        console.log('sasd');
        //        if ($('.minisearch').hasClass('-opened')) {
        //            $('.block.block-search').addClass('active');
        //        } else {
        //            $('.block.block-search').removeClass('active');
        //        }
        //    }, 50);
        //});

        //$('.account-link').wrapInner('<span class="my-account-text"></span>').prepend('<svg aria-hidden="true" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="icon_account"><path d="M313.6 304c-28.7 0-42.5 16-89.6 16-47.1 0-60.8-16-89.6-16C60.2 304 0 364.2 0 438.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-25.6c0-74.2-60.2-134.4-134.4-134.4zM400 464H48v-25.6c0-47.6 38.8-86.4 86.4-86.4 14.6 0 38.3 16 89.6 16 51.7 0 74.9-16 89.6-16 47.6 0 86.4 38.8 86.4 86.4V464zM224 288c79.5 0 144-64.5 144-144S303.5 0 224 0 80 64.5 80 144s64.5 144 144 144zm0-240c52.9 0 96 43.1 96 96s-43.1 96-96 96-96-43.1-96-96 43.1-96 96-96z" class="icon_account_path"></path></svg>');


        // Mobiel menu push
        //$('.nav-sections-item-switch').on('click', function () {
        //    $('.nav-sections-items').toggleClass('pushed');
        //});
        //
        //$('.back-link').on('click', function (e) {
        //    e.preventDefault();
        //    $(this).parent().parent().toggleClass('pushed');
        //});
        //
        //$('.close-link').on('click', function (e) {
        //    e.preventDefault();
        //    $('span.action.nav-toggle').click();
        //});

        $('.nav-sections-item-switch').on('click', function () {
            $('.nav-sections-items').toggleClass('pushed');
            $('html').toggleClass('menu-pushed');
        });

        $('.back-link').on('click', function (e) {
            e.preventDefault();
            $(this).parent().parent().toggleClass('pushed');
            $('html').toggleClass('menu-pushed');
        });

        $('.close-link').on('click', function (e) {
            e.preventDefault();
            $('span.action.nav-toggle').click();
        });

        // Close all open stuff
        setTimeout(function () {
            $('.nav-toggle').on('click', function () {
                if ($('html').hasClass('menu-pushed')) {
                    $('.nav-sections-items').removeClass('pushed');
                    $('html').removeClass('menu-pushed');
                }
            });
        }, 1500);

        navSectionListener($);
        addTitleTag($);

        if ($('.category-list').length > 0) {
            let $items = $('.category-list').find('.item');

            $items.each(function () {
                addAbbrToElement($, $(this));
            });
        }

        algoliaSearchOvervrite($);

        $(window).on('scroll touchmove mousewheel', function (e) {
            if ($('html').hasClass('nav-open') || $('#algolia-autocomplete-listbox-0').css('display') === 'block') {
                $('html, body').addClass('noscroll');
            } else {
                $('html, body').removeClass('noscroll');
            }
        })

        if ($('.page-header').length > 0) {
            $(window).scroll(function (e) {
                let scroll = $(window).scrollTop(),
                    $pageHeader = $('.page-header');

                if (scroll >= $pageHeader.height()) {
                    $pageHeader.addClass('moved');
                } else {
                    $pageHeader.removeClass('moved');
                }

                if ($('#product_addtocart_form').length > 0) {
                    $productForm = $('#product_addtocart_form');
                    $productAttributes = $('.swatch-attribute-options');
                    $heightToMain = ($productAttributes.height() + 250);
                    let optBarHeight = $('.product-options-bottom').height(),
                        pageFooterHeight = $('.page-footer').height();

                    if (scroll >= ($('#maincontent').height() - $heightToMain)) {
                        $productForm.addClass('fixed');
                        $('.swatch-attribute-selected-option').removeClass('replaced').addClass('fixed').css('bottom', optBarHeight + 'px');
                        $productForm.find('.product-options-bottom').addClass('bg-advanced').css('bottom', optBarHeight + 'px');

                        if (scroll >= ($('#maincontent').height() - $('.page-footer').height())) {
                            $('.swatch-attribute-selected-option').removeClass('replaced').addClass('fixed').css('bottom', (pageFooterHeight + optBarHeight) + 'px');
                            $productForm.find('.product-options-bottom').removeClass('bg-advanced').css('bottom', (pageFooterHeight + optBarHeight) + 'px');
                        }

                    } else {
                        $productForm.find('.product-options-bottom').css('bottom', optBarHeight + 'px');
                        $('.swatch-attribute-selected-option').removeClass('fixed').addClass('replaced');
                        $productForm.removeClass('fixed');
                    }
                }
            });
        }

        $(document).click(function (event) {
            var $target = $(event.target);
            if (!$target.closest('.nav-sections').length && $('html').hasClass('nav-open')) {
                $('span.action.nav-toggle').click();
            }

            setTimeout(function () {
                if ($('#search').is(":focus") || $('.minisearch').hasClass('-opened')) {
                    if (!$('.block-search').hasClass('active')) {
                        $('.block-search').addClass('active');
                    }

                } else if ($('.block-search').hasClass('active')) {
                    $('.block-search').removeClass('active');
                }
            }, 50);
        });

        $('.sidebar-categories .parent-category span').on('click', function (e) {
            e.preventDefault();
            $(this).parent().toggleClass('open');
            //if ($(this).next('ul').is(':hidden')) {
            //    $(this).next('ul').slideToggle();
            //}

            //if (!$(this).parent().hasClass('active')) {
            //    $(this).parent().addClass('active');
            //}
        });

        //$('body').on('click', function () {
        //    setTimeout(function () {
        //        if ($('#search').is(":focus") || $('.minisearch').hasClass('-opened')) {
        //            if (!$('.block-search').hasClass('active')) {
        //                $('.block-search').addClass('active');
        //            }
        //            
        //        } else if ($('.block-search').hasClass('active')) {
        //            $('.block-search').removeClass('active');
        //        }
        //    }, 50);
        //    
        //});



        $('.login-buttons a:eq(0)').on('click', function (e) {
            e.preventDefault();
            $('.trigger-ajax-login').click();
        });


        if ($('#shipping').length > 0) {
            $("#shipping td").each(function () {
                if (isEmpty($(this))) {
                    this.closest('tr').remove();
                }

                if (typeof $(this).attr('bgcolor') !== 'undefined' && $(this).attr('bgcolor') !== false) {
                    $(this).addClass("zone-title").removeAttr('width style bgcolor');
                    $(this).closest('tr').addClass("zone-container");
                }
            });

            tableToGrid($, $('#shipping'));

            let concat = [];
            $.each($('.item-data'), function (i, el) {
                concat[$(el).attr('concat-id')] = $(el).attr('concat-id');
            });

            $.each(concat, function (index) {
                $('.item' + index).wrapAll("<div class='gen-table content-cocncat-" + index + "' />");
            });

            $.each($('.gen-table'), function (index, element) {
                $.each($(element).find('.data-inner'), function (pos, innerData) {
                    $label = $(element).find('.data-label[pos-id=' + pos + ']');
                    $headline = $label.text();
                    $(innerData).append('<h4>' + $headline + '</h4>');
                    $label.remove();
                });
            });

            $('.item-data').unwrap().wrapAll("<div class='gen-table' />");

        }

        // insert break in hide price text
        // if ($('.catalog-product-view').length > 0) {
        //     var splitText = $('span.amasty-hide-price-text').text().split("\n");
        //     $('span.amasty-hide-price-text').html(splitText[0] + '<br>' + splitText[2]);
        // }

        $('.amasty-hide-price-container').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $('.trigger-ajax-login').click();
        });

        if ($('.page-products').length > 0) {
            //$('.page-title-wrapper').insertBefore('.catalog-topnav');
            //$('.filter-options-content').each(function() {
            //    $(this).find('select option:eq(0)').text($(this).prev().text());
            //});
            //var topCategoryText = $('.category-piano .active').text();
            //var topCategoryColor = $('.category-piano .active a').css('background-color');
            //$('.block-subtitle.filter-subtitle').html('<div class="top-category"><span class="top-category-box" style="background-color:' + topCategoryColor + ';">' + topCategoryText + '</span></div>');

            $('#narrow-by-list dt').each(function () {
                $(this).wrap('<div></div>');
                $(this).parent().next().insertAfter($(this));
            });

            //if ($('html[lang="de"]').length > 0) {
            //    $('.search-field input').val('Filter hinzufügen');
            //} else {
            //    $('.search-field input').val('Add filter');
            //}

            var parentCategoryName = $('#parentName').text();
            var count = $('.am-filter-items-attr_category_ids > li').length;

            $('.am-filter-items-attr_category_ids > li').each(function (i) {
                if ($(this).attr('data-label') !== parentCategoryName) {
                    $(this).remove();
                }
                if (i + 1 === count) {
                    $('.filter-options').fadeIn();
                }
            });
        }



        function getEndofAjax() {
            setTimeout(function () {
                if ($('body').hasClass('ajax-loading')) {
                    //$('.filter-options-content select').css({ 'color': 'white' });
                    getEndofAjax();

                } else {
                    parentCategoryName = $('#parentName').text();
                    count = $('.am-filter-items-attr_category_ids > li').length;

                    $('#narrow-by-list dt').each(function () {
                        $(this).wrap('<div></div>');
                        $(this).parent().next().insertAfter($(this));
                    });

                    $('.am-filter-items-attr_category_ids > li').each(function (i) {
                        if ($(this).attr('data-label') !== parentCategoryName) {
                            $(this).remove();
                        }

                        if (i + 1 === count) {
                            $('.filter-options').fadeIn();
                        }
                    });

                    //if ($('html[lang="de"]').length > 0) {
                    //    $('.search-field input').val('Filter hinzufügen');
                    //} else {
                    //    $('.search-field input').val('Add filter');
                    //}
                    //$('.block-subtitle.filter-subtitle').html('<div class="top-category"><span class="top-category-box" style="background-color:' + $('.category-piano .active a').css('background-color') + ';">' + $('.category-piano .active').text() + '</span></div>');
                    //$('.page-title-wrapper').insertBefore('.catalog-topnav');
                    //
                    //$('.filter-options-content').each(function() {
                    //    $(this).find('select option:eq(0)').text($(this).prev().text());
                    //});
                    //$('.filter-options-content select').css({ 'color': '#96694c' });
                }
            }, 10);
        }

        $(document).on('amshopby:submit_filters', function (e, arg) {
            getEndofAjax();
        });



        // Back to category view link
        $('.back-to-category a').on('click', function (e) {
            e.preventDefault();
            if (document.referrer.indexOf($('li.item.category').text().trim().replace(/\s/g, '-').toLowerCase()) !== -1) {
                window.history.back();
            } else {
                window.location = $('li.item.category a').attr('href');
            }
        });

        if ($('body.account').length > 0) {
            $('.account-nav-content li').each(function () {
                if ($(this).text().indexOf('Meine Produkte zum herunterladen') !== -1) {
                    $(this).remove();
                }
            });
        }


        // REGISTER 
        $('.customer-group input[type=radio][name=group_id]').change(function () {
            if (this.value === '3') {
                $('.form-create-account .taxvat').show();
                $('.form-create-account .taxvat input').attr('data-validate', '{required:true}');
                $('.field.taxvat').addClass('required');
                $('.field.company').addClass('required');
                $('.field.company input').attr('aria-required', true);
                $('.field.company input').addClass('required-entry');
            } else if (this.value === '1') {
                $('.form-create-account .taxvat').hide();
                $('.form-create-account .taxvat input').removeAttr('data-validate');
                $('.field.taxvat').removeClass('required');
                $('.field.company').removeClass('required');
                $('.field.company input').removeAttr('aria-required aria-invalid aria-describedby');
                $('.field.company input').removeClass('required-entry mage-error');
                $('.field.company input + div').remove();
            }
        });

        if ($('.customer-account-create').length > 0) {
            var accPage = $('.customer-account-create');
            switch ($('html').attr('lang')) {
                case 'de':
                    $(accPage).find('.field.taxvat label span').text('USt-IdNr.');
                    $(accPage).find('#prefix').prepend('<option disabled="" selected="">Bitte wählen Sie eine Anrede aus</option>');
                    $(accPage).find('#firstname').attr('placeholder', 'Bitte geben Sie Ihren Vornamen ein');
                    $(accPage).find('#lastname').attr('placeholder', 'Bitte geben Sie Ihren Nachnamen ein');
                    $(accPage).find('#taxvat').attr('placeholder', 'Bitte geben Sie Ihre USt-IdNr. ein');
                    $(accPage).find('#company').attr('placeholder', 'Bitte geben Sie Ihre Firma an');
                    $(accPage).find('#telephone').attr('placeholder', 'Bitte geben Sie Ihre Telefonnummer an');
                    $(accPage).find('#street_1').attr('placeholder', 'Bitte geben Sie Ihre Straße ein');
                    $(accPage).find('#city').attr('placeholder', 'Bitte geben Sie Ihre Stadt ein');
                    $(accPage).find('#zip').attr('placeholder', 'Bitte geben Sie Ihre PLZ ein');
                    $(accPage).find('#email_address').attr('placeholder', 'Bitte geben Sie Ihre E-Mail Adresse ein');
                    $(accPage).find('#password').attr('placeholder', 'Bitte geben Sie ein Passwort ein');
                    $(accPage).find('#password-confirmation').attr('placeholder', 'Bitte wiederholen Sie das Passwort');
                    break;
                case 'en':
                    $(accPage).find('#prefix').prepend('<option disabled="" selected="">Please select a salutation</option>');
                    $(accPage).find('#firstname').attr('placeholder', 'Please enter your first name');
                    $(accPage).find('#lastname').attr('placeholder', 'Please enter your last name');
                    $(accPage).find('#taxvat').attr('placeholder', 'Please enter your VAT number');
                    $(accPage).find('#company').attr('placeholder', 'Please enter your company');
                    $(accPage).find('#telephone').attr('placeholder', 'Please enter your phone number');
                    $(accPage).find('#street_1').attr('placeholder', 'Please enter your street');
                    $(accPage).find('#city').attr('placeholder', 'Please enter your city');
                    $(accPage).find('#zip').attr('placeholder', 'Please enter your postcode');
                    $(accPage).find('#email_address').attr('placeholder', 'Please enter your email address');
                    $(accPage).find('#password').attr('placeholder', 'Please enter a password');
                    $(accPage).find('#password-confirmation').attr('placeholder', 'Please repeat your password');
                    break;
                default:
                    break;
            }
        }

        // Katalog bestellen
        if ($('.cms-katalog-bestellen, .cms-order-catalog').length > 0) {
            pfe('.cms-katalog-bestellen label[for="radio-inlay-0"], .cms-order-catalog label[for="radiotwo-1611846920957-0"]', function (obj) {
                obj.prepend('<img src="/static/frontend/g3/mp-theme/de_DE/images/katalog-bestellen.jpg" class="" />');
            });
            // pfe('.cms-katalog-bestellen label[for="radio-inlay-1"], .cms-order-catalog label[for="radiotwo-1611846920957-1"]', function (obj) {
            //     obj.prepend('<img src="/pub/media/theme/katalog-mit-ordner.jpg" class="" />');
            // });
        }


        //startpage our products
        $('.ourproducts .category-list .item').each(function () {
            $(this).on('click', function () {
                var tempselect = $(this).attr('data-num');
                $('.ourproducts .category-list .item').removeClass('active');
                $(this).addClass('active');
                $('.category-content .category-item').each(function () {
                    if ($(this).attr('data-num') !== tempselect) {
                        $(this).slideUp();
                    } else {
                        $(this).slideDown({
                            start: function () {
                                $(this).css({
                                    display: "flex"
                                });
                            }
                        });
                    }
                });
            });
        });


        /*Angedockter Warenkorb*/

        // $.cartFix = function(){ 

        //     pfe('.swatch-wrapper', function(obj) {

        //         var mapStart = $('.product-options-wrapper').waypoint({

        //             handler: function(direction) {
        //                 if (direction === 'down') {
        //                     $('.product-options-bottom').addClass('fixed');
        //                     $('.swatch-attribute-selected-option').addClass('fixed');
        //                 } else {
        //                     $('.product-options-bottom').removeClass('fixed');
        //                     $('.swatch-attribute-selected-option').removeClass('fixed');
        //                 }
        //             },
        //             offset: '800'
        //         });


        //         var mapEnd = $('.product-options-wrapper').waypoint({
        //             handler: function(direction) {
        //                 if (direction === 'down') {
        //                     $('.product-options-bottom').removeClass('fixed');
        //                     $('.swatch-attribute-selected-option').removeClass('fixed');

        //                 } else {
        //                     $('.product-options-bottom').addClass('fixed');
        //                     $('.swatch-attribute-selected-option').addClass('fixed');
        //                 }
        //             },
        //             offset: 'bottom-in-view'

        //         });

        //         if($('.amasty-hide-price-container').length > 0){
        //             $('.swatch-attribute-selected-option').css({'bottom': '160px'});
        //         }
        //     });
        // };

        // $.cartFix();

        pfe('.swatch-wrapper', function (obj) {
            $('.swatch-more').click(function () {
                setTimeout(function () {
                    $.cartFix();
                }, 1);

            });
        });

        pfe('.mage-error', function (obj) {
            $('.product-options-wrapper .mage-error').text('Bitte wählen Sie eine Produkt-Variante');
        });

        pfe('.swatch-wrapper', function (obj) {
            $('.swatch-attribute').prepend('<p style="color: #e02b27;font-size: 1.2rem;">Bitte wählen Sie eine Produkt-Variante</p>');

            $('.page-product-configurable .swatch-wrapper').each(function () {
                $(this).on('click', function (e) {
                    if (!$(e.target).hasClass('selected')) {
                        $(e.target).find('.swatch-option').click();
                    }
                });
            });
        });

        /*Placeholder-Text für Mobile-Suche*/

        if ($('body').hasClass('mobile')) {
            $('.algolia-search-input').attr('placeholder', 'Suchen');

            $('.nav-sections-item-title:first-of-type').clone().appendTo('.panel.header .right-part');

            $('.nav-sections-item-switch').text('Kategorien');

            $('.right-part .nav-sections-item-title').on('click', function () {
                $('.section-items.nav-sections-items').addClass('pushed');
            });
            /*Mobile Akkordeon Produkt-Detail*/

            $('.product-info-main h3:first-child').addClass('accordion-b').prepend('<i class="far fa-arrow-alt-circle-down"></i>');
            $('.product.attribute.description').addClass('panel-b');


            $('.addinfo h3').addClass('accordion-d');
            $('.addinfo h3').removeClass('accordion-b');
            $('.attribute-list').addClass('panel-d');

            $('.accordion-b').click(function () {
                $('.panel-b').slideToggle('slow');
            });

            $('.accordion-d').click(function () {
                $('.panel-d').slideToggle('slow');
            });

            if ($('body').hasClass('catalog-product-view')) {
                $('.columns').prepend($('.page-title-wrapper.product'));
                $('.page-title-wrapper.product').append($('.product-addto-links'));
            }

        } else {
            if($('html').attr('lang') === 'de'){
                $('.algolia-search-input').attr('placeholder', 'Schlagworte/Art.Nr./Teilenummer');
            }else{
                $('.algolia-search-input').attr('placeholder', 'Keywords/item number/part number');
            }
        }

        changeSwatchAttributes($, $('.swatch-opt'));
        if ($('.amasty-catalog-topnav').length > 0) {
            showProductListElementsOnPageLoad($);
        }

        // FARBKARTEN FILTER
            var category = [];
            var checkboxList = [];
            var checkboxBtn = $('input[type="checkbox"]:not(:eq(6))');
            var checkboxBtnAll = $('input[type="checkbox"]:eq(6)');
            var unselected = 0;

            $('.category-box').each(function(index){
                category[index] = $(this);
                checkboxList[index] = $('input[type="checkbox"]');
            });

            function showAllCategory() {
                checkboxBtn.each(function(index) {
                    category[index].show();
                });
            }

            function checkCategory() {
                unselected = 0;
                checkboxBtn.each(function(index) {
                    if ($(this).is(':checked')) {
                        category[index].show();
                    } else {
                        unselected++;
                        category[index].hide();
                        if (category.length === unselected) {
                            showAllCategory();
                            checkboxBtnAll.prop('checked', true);
                        }
                    }
                });
            }

            checkboxBtn.on('click', function(e){
                checkboxBtnAll.prop('checked', false);
                checkCategory();
            });

            checkboxBtnAll.on('click', function(e){
                checkboxBtn.prop('checked', false);
                showAllCategory();
            });

        //Ende Farbkartenfilter

    });

    configurableProductHandler($);
});


function changeSwatchAttributes($, $swatch) {
    if ($swatch.length > 0) {
        if ($('.opt-parent-clone').length > 0) {
            $parentClone = $('.opt-parent-clone').html();
            observeProductFormAdditional($, $('.product-add-form'), $parentClone);
        }
    } else {
        $('.column.main').css('visibility', 'visible');
    }
}

function isEmpty(e) {
    if (e.text == '' || e.text() == ' ' || e.html() == '&nbsp;' || e.is(":not(:visible)")) {
        return true;
    }

    return false;
}

function hasClass(attr) {
    if (typeof attr !== typeof undefined && attr !== false) {
        return true;
    }

    return false;
}


function tableToGrid($, e) {
    e.replaceWith(function () {

        let $th = $(this).find('th');

        $th.closest('tr').remove();

        let $div = $('<div>', {
            'class': 'gen-table-container'
        });

        $('tr', this).each(function (i, tr_el) {
            if (!isEmpty($(tr_el))) {
                if ($(tr_el).find('td').length > 0) {

                    $('td', tr_el).each(function (j, td_el) {
                        if (!isEmpty($(td_el))) {
                            if ($(td_el).find('h4').length > 0) {
                                $('<div>', {
                                    'class': 'item-data data-label item' + (i + 1),
                                    'concat-id': (i + 1),
                                    'pos-id': j,
                                    html: $(td_el).html()
                                }).appendTo($div);
                            }

                            if ($(td_el).find('table').length > 0) {
                                $('<div>', {
                                    'class': 'item-data data-inner item' + i,
                                    'concat-id': i,
                                    html: $(td_el).find('table').html()
                                }).appendTo($div);
                            }
                        }
                    });
                }
            }
        });

        return $div;
    });
}


function addTitleTag($, e) {
    $('a').hover(function () {
        let $ae = $(this),
            title = $ae.text();

        title = title.replace(/\s\s+/g, '');

        if (($ae.attr('title') == undefined || $ae.attr('title') == '') && (!$ae.hasClass('product') || !$ae.hasClass('photo'))) {
            $ae.attr('title', title);
        }
    });
}


function addAbbrToElement($, $elem) {
    let title = $elem.text();
    $elem.wrap('<abbr title="' + title + '"></abbr>');
}

function configurableProductHandler($) {
    if ($('.product-info-price').length > 0) {
        $pInfoPrice = $('.product-info-price');

        $('.product-options-bottom').prepend($pInfoPrice);

        let checkAttrLabelExist = setInterval(function () {
            if ($pInfoPrice.length > 0) {
                if ($pInfoPrice.find('.additional-info').length === 0) {
                    $pInfoPrice.append('<article class="additional-info"><span class="p-label"></span><h3 class="p-title"></h3><span class="p-sub"></span></article>');
                    clearInterval(checkAttrLabelExist);
                }
            }
        }, 100);
    }
}

function algoliaSearchOvervrite($) {
    requirejs(['algoliaBundle'], function (algoliaBundle) {
        algoliaBundle.$(function ($) {

            if (!algoliaConfig.autocomplete.enabled) {
                return;
            }

            algoliaConfig.autocomplete.templates = {
                suggestions: algoliaBundle.Hogan.compile($('#autocomplete_suggestions_template').html()),
                products: algoliaBundle.Hogan.compile($('#autocomplete_products_template').html()),
                categories: algoliaBundle.Hogan.compile($('#autocomplete_categories_template').html()),
                pages: algoliaBundle.Hogan.compile($('#autocomplete_pages_template').html()),
                additionalSection: algoliaBundle.Hogan.compile($('#autocomplete_extra_template').html())
            };

            /**
             * Initialise Algolia client
             * Docs: https://www.algolia.com/doc/api-client/getting-started/instantiate-client-index/
             **/
            var algolia_client = algoliaBundle.algoliasearch(algoliaConfig.applicationId, algoliaConfig.apiKey);
            algolia_client.addAlgoliaAgent('Magento2 integration (' + algoliaConfig.extensionVersion + ')');

            /** Add products and categories that are required sections **/
            /** Add autocomplete menu sections **/
            if (algoliaConfig.autocomplete.nbOfProductsSuggestions > 0) {
                algoliaConfig.autocomplete.sections.unshift({ hitsPerPage: algoliaConfig.autocomplete.nbOfProductsSuggestions, label: algoliaConfig.translations.products, name: "products" });
            }

            if (algoliaConfig.autocomplete.nbOfCategoriesSuggestions > 0) {
                algoliaConfig.autocomplete.sections.unshift({ hitsPerPage: algoliaConfig.autocomplete.nbOfCategoriesSuggestions, label: algoliaConfig.translations.categories, name: "categories" });
            }

            if (algoliaConfig.autocomplete.nbOfQueriesSuggestions > 0) {
                algoliaConfig.autocomplete.sections.unshift({ hitsPerPage: algoliaConfig.autocomplete.nbOfQueriesSuggestions, label: '', name: "suggestions" });
            }

            /** Setup autocomplete data sources **/
            var sources = [],
                i = 0;
            $.each(algoliaConfig.autocomplete.sections, function (name, section) {
                var source = getAutocompleteSource(section, algolia_client, $, i);

                if (source) {
                    sources.push(source);
                }

                /** Those sections have already specific placeholder, so do not use the default aa-dataset-{i} class **/
                if (section.name !== 'suggestions' && section.name !== 'products') {
                    i++;
                }

                // if (section.name === 'products') {
                //     source.templates.footer = '';
                // }
            });

            $(algoliaConfig.autocomplete.selector).each(function (i) {
                var menu = $(this);
                var options = {
                    hint: false,
                    templates: {
                        dropdownMenu: '#menu-template'
                    },
                    dropdownMenuContainer: "#algolia-autocomplete-container",
                    debug: algoliaConfig.autocomplete.isDebugEnabled
                };

                if ($('.footer_algolia').length > 0) {
                    $('.footer_algolia').remove();
                }

                if ($('#algolia-autocomplete-container').length > 0) {
                    $('#algolia-autocomplete-container').insertAfter('.page-header');
                }

                sources = algolia.triggerHooks('beforeAutocompleteSources', sources, algolia_client, algoliaBundle);
                options = algolia.triggerHooks('beforeAutocompleteOptions', options);


                /** Bind autocomplete overvrite */
                var algoliaAutocompleteOvervriteInstance = $(this).autocomplete(options, sources);
                algoliaAutocompleteOvervriteInstance = algolia.triggerHooks('afterAutocompleteStart', algoliaAutocompleteOvervriteInstance);

                algoliaAutocompleteOvervriteInstance
                    .parent()
                    .attr('id', 'algolia-autocomplete-tt')
                    .on('autocomplete:updated', function (e) {

                        if ($('#algolia-autocomplete-listbox-0').css('display') === 'block') {
                            $('html, body').addClass('noscroll');
                        } else {
                            $('html, body').removeClass('noscroll');
                        }
                    });

            });
        });
    });
}

function navSectionListener($) {
    let $html = $('html'),
        $navSection = $('.sections.nav-sections');
    var observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            $navSection.css('top', $('.page-header').height() + 'px');
        });
    });

    observer.observe($html[0], {
        attributes: true,
        attributeFilter: ['class']
    });
}

function observeProductFormAdditional($, $form, $clone) {
    let observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (!mutation.addedNodes) return

            for (let i = 0; i < mutation.addedNodes.length; i++) {
                let $node = $(mutation.addedNodes[i]);
                if ($node.hasClass('swatch-attribute')) {

                    $clone = $clone.replace('curCode', '185').replace('curCode', '185');
                    $attrOptContainer = $node.find('.swatch-attribute-options');
                    $attrOptContainerNewContent = $clone + $attrOptContainer.html();
                    $attrOptContainer.html($attrOptContainerNewContent);
                }
            }
        })
    })

    observer.observe($form[0], {
        childList: true
        , subtree: true
        , attributes: false
        , characterData: false
    })


}

function showProductListElementsOnPageLoad($) {
    $mainContent = $('#maincontent');
    $mainContent.addClass('loading');

    setTimeout(function () {
        $mainContent.removeClass('loading');
    }, 500);
}
