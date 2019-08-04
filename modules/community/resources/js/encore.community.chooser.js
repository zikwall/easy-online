encore.module('community.chooser', function (module, require, $) {
    var event = require('event');
    var community = require('community');
    var client = require('client');
    var ui = require('ui');
    var Widget = ui.widget.Widget;
    var object = require('util').object;
    var pjax = require('client.pjax');
    var additions = require('ui.additions');
    var user = require('user');
    var view = require('ui.view');

    var SELECTOR_ITEM = '[data-community-chooser-item]';
    var SELECTOR_ITEM_REMOTE = '[data-community-none],[data-community-archived]';

    var CommunityChooser = function (node, options) {
        Widget.call(this, node, options);
    };

    object.inherits(CommunityChooser, Widget);

    CommunityChooser.prototype.init = function () {
        this.$menu = $('#community-menu');
        this.$chooser = $('#community-menu-communitys');
        this.$search = $('#community-menu-search');
        this.$remoteSearch = $('#community-menu-remote-search');

        // set niceScroll to CommunityChooser menu
        this.$chooser.niceScroll({
            cursorwidth: "7",
            cursorborder: "",
            cursorcolor: "#555",
            cursoropacitymax: "0.2",
            nativeparentscrolling: false,
            railpadding: {top: 0, right: 3, left: 0, bottom: 0}
        });

        this.$chooser.on('touchmove', function (evt) {
            evt.preventDefault();
        });

        this.initEvents();
        this.initCommunitySearch();
    };

    CommunityChooser.prototype.initEvents = function () {
        var that = this;

        $('[data-community-guid]').find('[data-message-count]').each(function () {
            var $this = $(this);
            if ($this.data('message-count') > 0) {
                $this.show();
            }
        });

        // Forward click events to actual link
        this.$.on('click', SELECTOR_ITEM, function (evt) {
            if (this === evt.target) {
                $(this).find('a')[0].click();
            }
        });

        // Focus on search on open and clear item selection when closed
        this.$menu.parent().on('shown.bs.dropdown', function () {
            if (!view.isSmall()) {
                that.$search.focus();
            }
        }).on('hidden.bs.dropdown', function () {
            that.clearSelection();
        });

        if (!pjax.isActive()) {
            return;
        }

        // Set no community icon for non community views and set community icon for community views.
        event.on('encore:ready', function () {
            if (!community.isCommunityPage()) {
                that.setNoCommunity();
            }
        }).on('encore:community:changed', function (evt, options) {
            that.setCommunity(options);
        }).on('encore:community:archived', function (evt, community) {
            that.removeItem(community);
        }).on('encore:community:unarchived', function (evt, community) {
            that.prependItem(community);
        }).on('encore:modules:content:live:NewContent', function (evt, liveEvents) {
            that.handleNewContent(liveEvents);
        });
    };

    CommunityChooser.prototype.handleNewContent = function (liveEvents) {
        var that = this;
        var increments = {};

        liveEvents.forEach(function (event) {
            if (event.data.uguid || event.data.originator === user.guid() ||  event.data.silent) {
                return;
            }

            if (increments[event.data.sguid]) {
                increments[event.data.sguid]++;
            } else {
                increments[event.data.sguid] = 1;
            }
        });

        $.each(increments, function (guid, count) {
            that.incrementMessageCount(guid, count);
        });
    };

    CommunityChooser.prototype.incrementMessageCount = function (guid, count) {
        var $messageCount = $('[data-community-guid="' + guid + '"]').find('[data-message-count]');
        var newCount = $messageCount.data('message-count') + count;

        $messageCount.hide().text(newCount).data('message-count', newCount);
        setTimeout(function () {
            $messageCount.show();
        }, 100);
    };

    CommunityChooser.prototype.prependItem = function (community) {
        if (!this.findItem(community).length) {
            var $community = $(community.output);
            this.$chooser.prepend($community);
            additions.applyTo($community);
        }
    };

    CommunityChooser.prototype.appendItem = function (community) {
        if (!this.findItem(community).length) {
            var $community = $(community.output);
            this.$chooser.append($community);
            additions.applyTo($community);
        }
    };

    CommunityChooser.prototype.findItem = function (community) {
        var guid = object.isString(community) ? community : community.guid;
        return this.$.find('[data-community-guid="' + guid + '"]');
    };

    CommunityChooser.prototype.removeItem = function (community) {
        var guid = object.isString(community) ? community : community.guid;
        this.getItems().filter('[data-community-guid="' + guid + '"]').remove();
    };

    CommunityChooser.prototype.initCommunitySearch = function () {
        var that = this;

        $('#community-search-reset').click(function () {
            that.resetSearch();
        });

        $('#community-directory-link').on('click', function () {
            that.$menu.trigger('click');
        });

        this.$search.on('keyup', function (event) {
            var $selection = that.getSelectedItem();
            switch (event.keyCode) {
                case 40: // Down -> select next
                    if (!$selection.length) {
                        CommunityChooser.selectItem(that.getFirstItem());
                    } else if ($selection.nextAll(SELECTOR_ITEM + ':visible').length) {
                        CommunityChooser.deselectItem($selection)
                                .selectItem($selection.nextAll(SELECTOR_ITEM + ':visible').first());
                    }
                    break;
                case 38: // Up -> select previous
                    if ($selection.prevAll(SELECTOR_ITEM + ':visible').length) {
                        CommunityChooser.deselectItem($selection)
                                .selectItem($selection.prevAll(SELECTOR_ITEM + ':visible').first());
                    }
                    break;
                case 13: // Enter
                    if ($selection.length) {
                        $selection.find('a')[0].click();
                    }
                    break;
                default:
                    that.triggerSearch();
                    break;
            }
        }).on('keydown', function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
            }
        }).on('focus', function () {
            $('#community-directory-link').addClass('focus');
        }).on('blur', function () {
            $('#community-directory-link').removeClass('focus');
        });
    };

    CommunityChooser.prototype.triggerSearch = function () {
        var input = this.$search.val().toLowerCase();

        // Don't repeat the search querys
        if (this.$search.data('last-search') === input) {
            return;
        }

        // Reset search if no input is given, else fade in search reset
        if (!input.length) {
            this.resetSearch();
            return;
        } else {
            $('#community-search-reset').fadeIn('fast');
        }

        // Filter all existing items and highlight text
        this.filterItems(input);
        this.highlight(input);

        this.triggerRemoteSearch(input);
    };

    CommunityChooser.prototype.filterItems = function (input) {
        this.clearSelection();
        this.$search.data('last-search', input);

        // remove max-height property to hide the nicescroll scrollbar in case of search input
        this.$chooser.css('max-height', ((input) ? 'none' : '400px'));

        this.getItems().each(function () {
            var $item = $(this);
            var itemText = $item.text().toLowerCase();

            // Select the first item if search was successful
            if (itemText.search(input) >= 0) {
                $item.show();
            } else {
                $item.hide();
            }
        });

        CommunityChooser.selectItem(this.getFirstItem());
    };

    CommunityChooser.prototype.highlight = function (input, selector) {
        selector = selector || SELECTOR_ITEM;
        this.$chooser.find(SELECTOR_ITEM).removeHighlight().highlight(input);
    };

    CommunityChooser.prototype.triggerRemoteSearch = function (input) {
        var that = this;

        this.remoteSearch(input).then(function (data) {
            if (data === true) { //Outdated result, just ignore this...
                return;
            } else if (!data) {
                that.onChange(input);
                return;
            }

            $.each(data, function (index, community) {
                that.appendItem(community);
            });

            that.highlight(input, SELECTOR_ITEM_REMOTE);
            that.onChange(input);
        }).catch(function (e) {
            if (!e.textStatus === "abort") {
                module.log.error(e, true);
            }
        });
    };

    CommunityChooser.prototype.remoteSearch = function (input) {
        var that = this;
        return new Promise(function (resolve, reject) {
            if (that.currentXhr) {
                that.currentXhr.abort();
            }

            // Clear all current remote results not matching the current search
            that.clearRemoteSearch(input);
            var url = module.config.remoteSearchUrl;

            if (!url) {
                reject('Could not execute community remote search, set data-community-search-url in your community search input');
                return;
            } else if (input.length < 2) {
                resolve(false);
                return;
            }

            var searchTs = Date.now();
            var options = {data: {keyword: input, target: 'chooser'},
                beforeSend: function (xhr) {
                    that.currentXhr = xhr;
                }};

            ui.loader.set(that.$remoteSearch, {'wrapper': '<li>', 'css': {padding: '5px'}});

            client.get(url, options).then(function (response) {
                that.currentXhr = undefined;
                var lastSearchTs = that.$remoteSearch.data('last-search-ts');
                var isOutDated = lastSearchTs && lastSearchTs > searchTs;
                var hastData = response.data && response.data.length;

                if (!isOutDated) {
                    that.$remoteSearch.empty();
                }

                // If we got no result we return
                if (!hastData || isOutDated) {
                    resolve(isOutDated);
                } else {
                    that.$remoteSearch.data('last-search-ts', searchTs);
                    resolve(response.data);
                }
            }).catch(reject);
        });
    };

    /**
     * Clears all remote results which do not match with the input search.
     * If no input is given, all remote results will be removed.
     * 
     * @param {string} input search filter 
     * @returns {undefined}
     */
    CommunityChooser.prototype.clearRemoteSearch = function (input) {
        // Clear all non member and non following communitys
        this.$chooser.find(SELECTOR_ITEM_REMOTE).each(function () {
            var $this = $(this);
            if (!input || !input.length || $this.find('.community-name').text().toLowerCase().search(input) < 0) {
                $this.remove();
            }
        });
    };

    CommunityChooser.prototype.resetSearch = function () {
        $('#community-search-reset').fadeOut('fast');
        this.clearRemoteSearch();

        if (!view.isSmall()) {
            this.$search.val('').focus();
        }
        this.$search.removeData('last-search');
        this.getItems().show().removeHighlight().removeClass('selected');
        this.$chooser.css('max-height', '400px');
        this.$remoteSearch.empty();
    };

    CommunityChooser.prototype.onChange = function (input) {
        var emptyResult = !this.getFirstItem().length;
        var atLeastTwo = input && input.length > 1;

        if (emptyResult && atLeastTwo) {
            this.$remoteSearch.html('<li><div class="help-block">' + module.text('info.emptyResult') + '</div></li>');
        } else if (emptyResult) {
            this.$remoteSearch.html('<li><div class="help-block">' + module.text('info.emptyOwnResult') + '<br/>' + module.text('info.remoteAtLeastInput') + '</div></li>');
        } else if (!atLeastTwo) {
            this.$remoteSearch.html('<li><div class="help-block">' + module.text('info.remoteAtLeastInput') + '</div></li>');
        }
    };

    CommunityChooser.prototype.clearSelection = function () {
        return this.getSelectedItem().removeClass('selected');
    };

    CommunityChooser.prototype.getFirstItem = function () {
        return this.$chooser.find('[data-community-chooser-item]:visible').first();
    };

    CommunityChooser.selectItem = function ($item) {
        $item.addClass('selected');
        return CommunityChooser;
    };

    CommunityChooser.deselectItem = function ($item) {
        $item.removeClass('selected');
        return CommunityChooser;
    };

    /**
     * Resets the community chooser icon, if no community view is set.
     * 
     * @returns {undefined}
     */
    CommunityChooser.prototype.setNoCommunity = function () {
        if (!this.$menu.find('.no-community').length) {
            this._changeMenuButton(module.config.noCommunity);
        }
    };

    /**
     * Changes the community chooser icon, for the given community options.
     * 
     * @param {type} communityOptions
     * @returns {undefined}
     */
    CommunityChooser.prototype.setCommunity = function (community) {
        this.setCommunityMessageCount(community, 0);
        this._changeMenuButton(community.image + ' <b class="caret"></b>');
    };

    CommunityChooser.prototype.setCommunityMessageCount = function (community, count) {
        var guid = object.isString(community) ? community : community.guid;
        var $messageCount = $('[data-community-guid="' + guid + '"]').find('[data-message-count]');
        if ($messageCount.length) {
            if (count) {
                $messageCount.text(count);
            } else {
                $messageCount.fadeOut('fast');
            }
        }
    };

    CommunityChooser.prototype._changeMenuButton = function (newButton) {
        var $newTitle = (newButton instanceof $) ? newButton : $(newButton);
        var $oldTitle = this.$menu.children();
        this.$menu.append($newTitle.hide());
        ui.additions.switchButtons($oldTitle, $newTitle, {remove: true});
    };

    CommunityChooser.prototype.getSelectedItem = function () {
        return this.$.find('[data-community-chooser-item].selected');
    };

    CommunityChooser.prototype.getItems = function () {
        return this.$.find('[data-community-chooser-item]');
    };

    module.export({
        CommunityChooser: CommunityChooser,
        init: function () {
            CommunityChooser.instance($('#community-menu-dropdown'));
        }
    });
});