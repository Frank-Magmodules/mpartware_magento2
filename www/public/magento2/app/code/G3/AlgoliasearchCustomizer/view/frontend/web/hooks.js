requirejs(['jquery',
    'algoliaBundle',
    'Algolia_AlgoliaSearch/autocomplete',
    'jquery-ui-modules/effect',
    'jquery-ui-modules/effect-shake'],
    function ($, algoliaBundle, undefined) {


        algolia.registerHook('beforeAutocompleteSources', function (sources, algoliaClient, algoliaBundle) {

            for (var i = 0; i < sources.length; i++) {

                let productOptions = {
                    hitsPerPage: 0,
                    analyticsTags: 'autocomplete',
                    clickAnalytics: true,
                    facets: ['categories.level0'],
                    numericFilters: ['visibility_search=1'], // add filter options
                    ruleContexts: ['magento_filters', ''] // Empty context to keep BC for already create rules in dashboard
                }

                if (sources[i].name === 'products') {

                    let mainSource = algoliaBundle.autocomplete.sources.hits(algoliaClient.initIndex(algoliaConfig.indexName + '_products'), productOptions);

                    sources[i] = {
                        source: mainSource,
                        name: sources[i].name,
                        templates: {
                            empty: function (query) {

                                var template = '<div class="aa-no-results-products">' +
                                    '<div class="title">' + algoliaConfig.translations.noProducts + ' "' + $("<div>").text(query.query).html() + '"</div>';

                                var suggestions = [];

                                if (algoliaConfig.showSuggestionsOnNoResultsPage && algoliaConfig.popularQueries.length > 0) {
                                    $.each(algoliaConfig.popularQueries.slice(0, Math.min(3, algoliaConfig.popularQueries.length)), function (i, query) {
                                        query = $('<div>').html(query).text(); // Avoid xss
                                        suggestions.push('<a href="' + algoliaConfig.baseUrl + '/catalogsearch/result/?q=' + encodeURIComponent(query) + '">' + query + '</a>');
                                    });

                                    template += '<div class="suggestions"><div>' + algoliaConfig.translations.popularQueries + '</div>';
                                    template += '<div>' + suggestions.join(', ') + '</div>';
                                    template += '</div>';
                                }

                                var productsLink = 'papiere';
                                if (document.documentElement.lang.toLowerCase() === "en") {
                                    productsLink = 'papers';
                                }

                                template += '<div class="see-all">' + (suggestions.length > 0 ? algoliaConfig.translations.or + ' ' : '') + '<a href="' + algoliaConfig.baseUrl + '/' + productsLink + '">' + algoliaConfig.translations.seeAll + '</a></div></div>';

                                return template;
                            },
                            suggestion: function (hit, payload) {
                                hit.__indexName = algoliaConfig.indexName + "_" + section.name;
                                hit.__queryID = payload.queryID;
                                hit.__position = payload.hits.indexOf(hit) + 1;

                                hit = transformHit(hit, algoliaConfig.priceKey);

                                hit.displayKey = hit.displayKey || hit.name;

                                return algoliaConfig.autocomplete.templates[section.name].render(hit);
                            },
                            footer: function (query, content) {
                                var keys = [];
                                for (var i = 0; i < algoliaConfig.facets.length; i++) {
                                    if (algoliaConfig.facets[i].attribute == "categories") {
                                        for (var key in content.facets['categories.level0']) {
                                            var url = algoliaConfig.baseUrl + '/catalogsearch/result/?q=' + encodeURIComponent(query.query) + '#q=' + encodeURIComponent(query.query) + '&hFR[categories.level0][0]=' + encodeURIComponent(key) + '&idx=' + algoliaConfig.indexName + '_products';
                                            keys.push({
                                                key: key,
                                                value: content.facets['categories.level0'][key],
                                                url: url
                                            });
                                        }
                                    }
                                }

                                keys.sort(function (a, b) {
                                    return b.value - a.value;
                                });



                                var ors = '';

                                if (keys.length > 0) {
                                    var orsTab = [];
                                    for (var i = 0; i < keys.length && i < 2; i++) {
                                        orsTab.push('<span><a href="' + keys[i].url + '">' + keys[i].key + '</a></span>');
                                    }
                                    ors = orsTab.join(', ');
                                }

                                var allUrl = algoliaConfig.baseUrl + '/catalogsearch/result/?q=' + encodeURIComponent(query.query);
                                var returnFooter = '<div id="autocomplete-products-footer">' + algoliaConfig.translations.seeIn + ' <span><a href="' + allUrl + '">' + algoliaConfig.translations.allDepartments + '</a></span> (' + content.nbHits + ')';

                                if (ors && algoliaConfig.instant.enabled) {

                                    returnFooter += ' ' + algoliaConfig.translations.orIn + ' ' + ors;
                                }

                                returnFooter += '</div>';

                                return returnFooter;
                            }
                        }
                    }
                } else if (sources[i].name !== "categories" || sources[i].name !== "pages" || sources[i].name !== "suggestions") {
                    /** If is not products, categories, pages or suggestions, it's additional section **/

                    sources[i] = {
                        source: algoliaBundle.autocomplete.sources.hits(algoliaClient.initIndex(algoliaConfig.indexName + "_section_" + sources[i].name), productOptions),
                        displayKey: 'value',
                        name: i,
                        templates: {
                            suggestion: function (hit, payload) {
                                hit.url = algoliaConfig.baseUrl + '/catalogsearch/result/?q=' + hit.value + '&refinement_key=' + encodeURIComponent(section.name);

                                hit.__queryID = payload.queryID;
                                hit.__position = payload.hits.indexOf(hit) + 1;

                                return algoliaConfig.autocomplete.templates.additionalSection.render(hit);
                            }
                        }
                    }
                }
            }

            return sources;
        });
    });

