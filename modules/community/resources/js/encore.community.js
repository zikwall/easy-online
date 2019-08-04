encore.module('community', function (module, require, $) {
    var client = require('client');
    var additions = require('ui.additions');
    var event = require('event');
    
    // Current community options (guid, image)
    var options;
    
    var isCommunityPage = function() {
        return $('.community-layout-container').length > 0;
    };
    
    var setCommunity = function(communityOptions, pjax) {
        if(!module.options || module.options.guid !== communityOptions.guid) {
            module.options = communityOptions;
            if(pjax) {
                event.trigger('encore:community:changed', $.extend({}, module.options));
            }
        }
    };
    
    var guid = function() {
        return (options) ? options.guid : null;
    };
    
    var archive = function(evt) {
        client.post(evt).then(function(response) {
            if(response.success) {
                additions.switchButtons(evt.$trigger, evt.$trigger.siblings('.unarchive'));
                module.log.success('success.archived');
                event.trigger('encore:community:archived', response.community);
            }
        }).catch(function(err) {
            module.log.error(err, true);
        });
    };
    
    var unarchive = function(evt) {
        client.post(evt).then(function(response) {
            if(response.success) {
                additions.switchButtons(evt.$trigger, evt.$trigger.siblings('.archive'));
                module.log.success('success.unarchived');

                event.trigger('encore:community:unarchived', response.community);
            }
        }).catch(function(err) {
            module.log.error(err, true);
        });
    };
    
    var init = function() {
        if(!module.isCommunityPage()) {
            module.options = undefined;
        }
    };

    module.export({
        init: init,
        initOnPjaxLoad: true,
        guid: guid,
        archive : archive,
        unarchive : unarchive,
        isCommunityPage: isCommunityPage,
        setCommunity: setCommunity
    });
});