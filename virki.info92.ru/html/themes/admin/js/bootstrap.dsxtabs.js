/*!
 * bootstrap-tabs-x v1.3.3
 * http://plugins.krajee.com/tabs-x
 *
 * Krajee jQuery plugin for bootstrap-tabs-x.
 *
 * Author: Kartik Visweswaran
 * Copyright: 2014 - 2021, Kartik Visweswaran, Krajee.com
 *
 * Licensed under the BSD 3-Clause
 * https://github.com/kartik-v/bootstrap-tabs-x/blob/master/LICENSE.md
 */
(function (factory) {
    "use strict";
    //noinspection JSUnresolvedVariable
    if (typeof define === 'function' && define.amd) { // jshint ignore:line
        define(['jquery'], factory); // jshint ignore:line
    } else { // noinspection JSUnresolvedVariable
        if (typeof module === 'object' && module.exports) { // jshint ignore:line
            // noinspection JSUnresolvedVariable
            module.exports = factory(require('jquery')); // jshint ignore:line
        } else {
            factory(window.jQuery);
        }
    }
}(function ($) {
    "use strict";
    var isEmpty = function (value, trim) {
            return value === null || value === undefined || value.length === 0 || (trim && $.trim(value) === '');
        },
        TabsX = function (element, options) {
            var self = this;
            self.$element = $(element);
            self.init(options);
            self.listen();
        };

    //noinspection JSUnusedGlobalSymbols
    TabsX.prototype = {
        constructor: TabsX,
        init: function (options) {
            var self = this, $el = self.$element;
            $.each(options, function (key, val) {
                self[key] = val;
            });
            self.initCache();
            self.enableCache = !!self.enableCache;
            if (!isEmpty(self.addCss) && !$el.hasClass(self.addCss)) {
                $el.addClass(self.addCss);
            }
            self.$pane = $el.find('.tab-pane.active');
            self.$content = $el.find('.tab-content');
            self.$tabs = $el.find('.nav-tabs');
            self.isVertical = ($el.hasClass('tabs-left') || $el.hasClass('tabs-right'));
            self.isVerticalSide = self.isVertical && $el.hasClass('tab-sideways');
            if (self.isVertical) {
                self.$content.css('min-height', self.$tabs.outerHeight() + 1 + 'px');
            }
        },
        setTitle: function ($el) {
            var self = this, txt = $.trim($el.text()), isVertical = self.isVertical,
                maxLen = isEmpty($el.data('maxTitleLength')) ? self.maxTitleLength : $el.data('maxTitleLength');
            if (isVertical && txt.length > maxLen - 2 && isEmpty($el.attr('title'))) {
                $el.attr('title', txt);
            }
        },
        listen: function () {
            var self = this, $element = self.$element;
            $element.find('.nav-tabs li.disabled').each(function () {
                $(this).find('[data-toggle="tab"]').removeAttr('data-toggle');
            });
            $element.find('.nav-tabs li [data-toggle="dropdown"]').each(function () {
                self.setTitle($(this));
            });
            $element.find('.nav-tabs li [data-toggle="tab"]').each(function () {
                var $el = $(this), $item = $el.closest('li');
                $item.removeAttr('data-toggle');
                self.setTitle($el);
                $el.on('click', function (e) {
                    if ($item.hasClass('disabled')) {
                        e.preventDefault();
                        return;
                    }
                    var vUrl = $(this).attr("data-url"), vHash = this.hash, cacheKey = vUrl + vHash, settings;
                    if (isEmpty(vUrl) || (self.enableCache && self.cache.exist(cacheKey))) {
                        $el.trigger('tabsX:click');
                        return;
                    }
                    e.preventDefault();
                    self.reload(e, this, $el);
                });
            });
        },
        initCache: function () {
            var self = this, t = parseFloat(self.cacheTimeout);
            if (isNaN(t)) {
                t = 0;
            }
            self.cache = {
                data: {},
                create: function () {
                    return (new Date().getTime());
                },
                exist: function (key) {
                    return !!self.cache.data[key] && ((self.cache.create() - self.cache.data[key]) < t);
                },
                set: function (key) {
                    self.cache.data[key] = self.cache.create();
                }
            };
        },
        flushCache: function (tabIds) {
            var self = this;
            if (typeof tabIds === 'string') {
                tabIds = [tabIds];
            }
            if (typeof tabIds === 'object' && !isEmpty(tabIds)) {
                Object.values(tabIds).forEach(function (tabId) {
                    Object.keys(self.cache.data).forEach(function (key) {
                        if (key.endsWith(tabId)) {
                            delete self.cache.data[key];
                        }
                    });
                });
            } else {
                self.cache.data = {};
            }
        },
        add: function (url, label, cached= true) {
            var self = this, $element = self.$element;
            var lastElementIndex = $element.last('.nav-tabs li').index();
            var newPanelId =  $element.attr('id') + '-tablist-tab-'+(lastElementIndex+1);
            var newTabElement = $('<li role="presentation">'+self.tabTemplate+'</li>') //panelId url label
                 .replace(/\{panelId\}/g, newPanelId)
                 .replace(/\{url\}/g, url)
                 .replace(/\{label\}/g, label);
            var newPanelElement = $('div id="'+newPanelId+'" role="tabpanel" class="tab-panel-content-wrapper tab-pane"></div>');
            $element.first('.nav-tabs').append(newTabElement);
            $element.first('.tab-content').append(newPanelElement);
            self.listen();
            newTabElement.trigger('click');
//            this._trigger('add', null, this._ui(this.anchors[index], this.panels[index]));
            return [newTabElement,newPanelElement];
        },
        getActive: function() {
            var self = this, $element = self.$element;
               var activeTab = $element.first('.nav-tabs li.active');
               var activePane = $element.first('tab-content .tab-pane.active');
               return [activeTab,activePane];


        },
        reload: function (e, panel, tab) {
            var self = this;
            var vUrl = $(panel).attr("data-url"), vHash = panel.hash, cacheKey = vUrl + vHash, settings;
            if (isEmpty(vUrl) || (self.enableCache && self.cache.exist(cacheKey))) {
                return;
            }
            e.preventDefault();
            var $tab = $(vHash), $pane = $(panel), $paneHeader = $pane,
                css = $(panel).attr("data-loading-class") || 'kv-tab-loading',
                $element = $pane.closest('.dropdown'),
                cbSuccess = self.successCallback[vHash] || null,
                cbError = self.errorCallback[vHash] || null;
            if (!isEmpty($element.attr('class'))) {
                $paneHeader = $element.find('.dropdown-toggle');
            }
            settings = $.extend(true, {}, {
                type: 'get',
                xhrFields: {
                    withCredentials: true
                },
                url: vUrl,
                beforeSend: function (jqXHR, settings) {
                    $tab.html('<br><br><br>');
                    $paneHeader.removeClass(css).addClass(css);
                    tab.trigger('tabsX:beforeSend', [jqXHR, settings]);
                },
                success: function (data, status, jqXHR) {
                    setTimeout(function () {
                        $tab.html(data);
                        $pane.tab('show');
                        $paneHeader.removeClass(css);
                        if (self.enableCache) {
                            self.cache.set(cacheKey);
                        }
                        if (cbSuccess && typeof cbSuccess === "function") {
                            cbSuccess(data, status, jqXHR);
                        }
                        tab.trigger('tabsX:success', [data, status, jqXHR]);
                    }, 300);
                },
                error: function (jqXHR, status, message) {
                    if (cbError && typeof cbError === "function") {
                        cbError(jqXHR, status, message);
                    }
                    tab.trigger('tabsX:error', [jqXHR, status, message]);
                },
                complete: function (jqXHR, status) {
                    tab.trigger('tabsX:click', [jqXHR, status]);
                }
            }, self.ajaxSettings);
            $.ajax(settings);
//            var self = this, $element = self.$element;
//            var panel = e;
/*            var lastElementIndex = $element.last('.nav-tabs li').index();
            var newPanelId =  $element.attr('id') + '-tablist-tab-'+(lastElementIndex+1);
            var newTabElement = $('<li role="presentation">'+self.tabTemplate+'</li>') //panelId url label
                .replace(/\{panelId\}/g, newPanelId)
                .replace(/\{url\}/g, url)
                .replace(/\{label\}/g, label);
            var newPanelElement = $('div id="'+newPanelId+'" role="tabpanel" class="tab-panel-content-wrapper tab-pane"></div>');
            $element.firstChild('.nav-tabs').append(newTabElement);
            $element.firstChild('.tab-content').append(newPanelElement);
            self.listen();
            newTabElement.trigger('click');
//            this._trigger('add', null, this._ui(this.anchors[index], this.panels[index]));
            return [newTabElement,newPanelElement];
 */
        },
    };

    $.fn.tabsX = function (option) {
        var args = Array.apply(null, arguments), retvals = [];
        args.shift();
        this.each(function () {
            var self = $(this), data = self.data('tabsX'), options = typeof option === 'object' && option;
            if (!data) {
                data = new TabsX(this, $.extend(true, {}, $.fn.tabsX.defaults, options, $(this).data()));
                self.data('tabsX', data);
            }
            if (typeof option === 'string') {
                retvals.push(data[option].apply(data, args));
            }
        });
        switch (retvals.length) {
            case 0:
                return this;
            case 1:
                return retvals[0];
            default:
                return retvals;
        }
    };

    $.fn.tabsX.defaults = {
        enableCache: true,
        cacheTimeout: 300000,
        maxTitleLength: 9,
        ajaxSettings: {},
        successCallback: {},
        errorCallback: {},
        addCss: 'tabs-krajee',
        tabTemplate:'<a href="#{panelId}" aria-controls="{panelId}" role="tab" data-toggle="tab" data-url="{url}">\n' +
            '<span>{label}</span>\n' +
            '<span class="dsx-tab-button" role="tabRefresh" onclick="reloadSelectedTab(event);return true;">\n' +
            '<i class="fa fa-refresh"></i><i class="fa fa-spinner fa-spin hidden"></i></span>' +
            '<span class="dsx-tab-button" role="tabClose" href="#"><i class="fa fa-close"></i></span></a>'
    };

    $.fn.tabsX.Constructor = TabsX;
}));