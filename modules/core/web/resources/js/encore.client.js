encore.module('client', function (module, require, $) {
    var object = require('util').object;
    var event = require('event');
    var action = require('action');

    class Response
    {
        constructor(xhr, url, textStatus, dataType)
        {
            this.url = url;
            this.status = xhr.status;
            this.response = xhr.responseJSON || xhr.responseText;
            this.dataType = dataType;
            this.xhr = xhr;

            var responseType = this.header('content-type');

            if ((!dataType || dataType === 'json') && responseType && responseType.indexOf('json') > -1) {
                $.extend(this, this.response);
            } else if (dataType) {
                this[dataType] = this.response;
            }
        }

        header(key)
        {
            return this.xhr.getResponseHeader(key);
        }

        setSuccess(data)
        {
            this.data = data;
            return this;
        }

        setError(errorThrown)
        {
            try {
                this.error = JSON.parse(this.response);
            } catch (e) {/* Nothing todo... */
            }

            this.error = this.error || {};
            this.errorThrown = errorThrown;
            this.validationError = (this.status === 400);
            return this;
        }

        isError()
        {
            return this.status >= 400;
        }

        getLog()
        {
            var result = $.extend({}, this);

            if (this.response && object.isString(this.response)) {
                result.response = this.response.substr(0, 500)
                result.response += (this.response.length > 500) ? '...' : '';
            }

            if (this.html && object.isString(this.html)) {
                result.html = this.html.substr(0, 500)
                result.html += (this.html.length > 500) ? '...' : '';
            }

            return result;
        }
    }
    
    var reload = function (preventPjax) {
        if (!preventPjax && module.pjax.config.active) {
            module.pjax.reload();
        } else {
            location.reload(true);
        }
    };

    var submit = function ($form, cfg, originalEvent) {
        if ($form instanceof $.Event && $form.$form && $form.length) {
            originalEvent = $form;
            $form = $form.$form;
        } else if ($form instanceof $.Event && $form.$trigger) {
            originalEvent = $form;
            $form = $form.$trigger.closest('form');
        } else if (cfg instanceof $.Event) {
            originalEvent = cfg;
            cfg = {};
        }

        cfg = cfg || {};
        $form = object.isString($form) ? $($form) : $form;

        if (!$form || !$form.length) {
            return Promise.reject('Could not determine form for submit action.');
        }

        cfg.type = $form.attr('method') || 'post';
        cfg.data = $form.serialize();
        var url = cfg.url || originalEvent.url || $form.attr('action');
        return ajax(url, cfg, originalEvent);
    };
    
    var actionPost = function (evt) {
        post(evt).catch(function(e) {
            module.log.error(e, true);
        });
    };

    var post = function (url, cfg, originalEvent) {
        if (url instanceof $.Event) {
            originalEvent = url;
            url = originalEvent.url || cfg.url;
        } else if (cfg instanceof $.Event) {
            originalEvent = cfg;
            cfg = {};
        } else if (!object.isString(url)) {
            cfg = url;
            url = cfg.url;
        }

        cfg = cfg || {};
        cfg.type = cfg.method = 'POST';
        return ajax(url, cfg, originalEvent);
    };

    var html = function (url, cfg, originalEvent) {
        if (url instanceof $.Event) {
            originalEvent = url;
            url = originalEvent.url || cfg.url;
        } else if (cfg instanceof $.Event) {
            originalEvent = cfg;
            cfg = {};
        } else if (!object.isString(url)) {
            cfg = url;
            url = cfg.url;
        }

        cfg = cfg || {};
        cfg.type = cfg.method = 'GET';
        cfg.dataType = 'html';
        return get(url, cfg, originalEvent);
    };

    var get = function (url, cfg, originalEvent) {
        if (url instanceof $.Event) {
            originalEvent = url;
            url = originalEvent.url || cfg.url;
        } else if (cfg instanceof $.Event) {
            originalEvent = cfg;
            cfg = {};
        } else if (!object.isString(url)) {
            cfg = url;
            url = cfg.url;
        }

        cfg = cfg || {};
        cfg.type = cfg.method = 'GET';
        return ajax(url, cfg, originalEvent);
    };

    var ajax = function (url, cfg, originalEvent) {

        if (cfg instanceof $.Event) {
            originalEvent = cfg;
            cfg = {};
        } else if (object.isFunction(cfg)) {
            cfg = {'success': cfg};
        }

        var promise = new Promise(function (resolve, reject) {
            cfg = cfg || {};

            if(originalEvent && object.isFunction(originalEvent.data)) {
                cfg.dataType = originalEvent.data('data-type', cfg.dataType);
            }

            var errorHandler = cfg.error;
            var error = function (xhr, textStatus, errorThrown) {
                var response = new Response(xhr, url, textStatus, cfg.dataType).setError(errorThrown);

                if (response.status == 302) {
                    _redirect(xhr);
                }

                if (errorHandler && object.isFunction(errorHandler)) {
                    errorHandler(response);
                }

                finish(originalEvent);
                reject(response);
            };

            var successHandler = cfg.success;
            var success = function (data, textStatus, xhr) {
                var response = new Response(xhr, url, textStatus, cfg.dataType).setSuccess(data);
                if (successHandler) {
                    successHandler(response);
                }

                finish(originalEvent);
                resolve(response);

                if (response.type) {
                    event.trigger('encore:modules:client:response:' + response.type);
                }
            };

            cfg.success = success;
            cfg.error = error;
            cfg.url = url;
            cfg.dataType = cfg.dataType || "json";
            $.ajax(cfg);
        });

        promise.status = function (setting) {
            return new Promise(function (resolve, reject) {
                promise.then(function (response) {
                    try {
                        if (setting[response.status]) {
                            setting[response.status](response);
                        }
                        resolve(response);
                    } catch (e) {
                        reject(e);
                    }
                }).catch(function (response) {
                    try {
                        if (setting[response.status]) {
                            setting[response.status](response);
                            resolve(response);
                        } else {
                            reject(response);
                        }
                    } catch (e) {
                        reject(e);
                    }
                });
            });
        };

        return promise;
    };

    var _redirect = function (xhr) {
        var url = null;
        if (xhr.getResponseHeader('X-Pjax-Url')) {
            url = xhr.getResponseHeader('X-Pjax-Url');
        } else {
            url = xhr.getResponseHeader('X-Redirect');
        }

        if (url !== null) {
            if(module.pjax && module.pjax.config.active) {
                module.pjax.redirect(url);
            } else {
                document.location = url;
            }
            return;
        }
    };

    var finish = function (originalEvent) {
        if (originalEvent && object.isFunction(originalEvent.finish) && originalEvent.block !== 'manual') {
            originalEvent.finish();
        }
    };
    
    var back = function() {
        history.back();
    };

    var init = function (isPjax) {
        if (!isPjax) {
            action.registerHandler('post', function (evt) {
                evt.block = 'manual';
                module.post(evt).then(function (resp) {
                    module.log.debug('post success', resp, true);
                }).catch(function (err) {
                    evt.finish();
                    module.log.error(err, true);
                });
            });
        }
    };

    module.export({
        ajax: ajax,
        back: back,
        actionPost: actionPost,
        post: post,
        get: get,
        html: html,
        reload: reload,
        submit: submit,
        init: init,
        //upload: upload,
        Response: Response
    });
});