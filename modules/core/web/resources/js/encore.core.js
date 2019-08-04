var encore = encore || (($) =>
{
    let modules = {};
    let moduleArr = [];
    let initialModules = [];
    let pjaxInitModules = [];

    let module = (id, moduleFunction)  => {
        let instance = resolveNameSpace(id, true);

        if (instance.id) {
            return;
        }

        instance.id = 'encore.modules.' + _cutModulePrefix(id);
        instance.require = require;
        instance.initOnPjaxLoad = false;
        instance.config = require('config').module(instance);
        instance.isModule = true;

        instance.text = $key => {
            let textCfg = instance.config['text'];
            return (textCfg) ? textCfg[$key] : undefined;
        };

        let exportFunc = instance.export = exports => {
            instance = Object.assign(instance, exports);
            //$.extend(instance, exports);
        };

        try {
            moduleFunction(instance, require, $);
            if(exportFunc !== instance.export) {
                _setNameSpace(instance.id, instance.export);
            }
        } catch (err) {
            console.error('Error while creating module: ' + id, err);
        }

        moduleArr.push(instance);

        if (instance.init && instance.initOnPjaxLoad) {
            pjaxInitModules.push(instance);
        }

        if(!encore.initialized) {
            initialModules.push(instance);
        } else {
            addModuleLogger(instance);
            initModule(instance);
        }
    };

    let require = (moduleNS, lazy) => {
        let module = resolveNameSpace(moduleNS, lazy);
        if (!module) {
            console.error('No module found for namespace: ' + moduleNS);
        }
        return module;
    };

    let resolveNameSpace = (typePath, init) => {
        try {
            let moduleSuffix = _cutModulePrefix(typePath);

            let result = modules;

            moduleSuffix.split('.').forEach(subPath => {
                if (subPath in result) {
                    result =  result[subPath];
                } else if (init) {
                    result =  result[subPath] = {};
                } else {
                    result = undefined;
                    return false;
                }
            });

            return result;
        } catch (e) {
            let log = require('log') || console;
            log.error('Error while resolving namespace: ' + typePath, e);
        }
    };

    let _setNameSpace = (path, obj) => {
        try {
            let moduleSuffix = _cutModulePrefix(path);
            let currentPath = modules;
            let parent, last;

            moduleSuffix.split('.').forEach(subPath => {
                if (subPath in currentPath) {
                    last = subPath;
                    parent = currentPath;
                    currentPath = currentPath[subPath];
                } else {
                    return false;
                }
            });

            parent[last] = obj;
        } catch (e) {
            let log = require('log') || console;
            log.error('Error while setting namespace: ' + path, e);
        }
    };

    let config = modules['config'] = {
        id: 'config',
        get: (module, key, defaultVal) => {
            if (arguments.length === 1) {
                return this.module(module);
            } else if (_isDefined(key)) {
                let result = this.module(module)[key];
                return (_isDefined(result)) ? result : defaultVal;
            }
        },
        module: module => {
            module = (module.id) ? module.id : module;
            module = _cutModulePrefix(module);
            if (!this[module]) {
                this[module] = {};
            }
            return this[module];
        },
        is: (module, key, defaultVal) => {
            return this.get(module, key, defaultVal) === true;
        },
        set: function (moduleId, key, value) {
            if (arguments.length === 1) {
                for (moduleKey in moduleId) {
                    this.set(moduleKey, moduleId[moduleKey]);
                }
            } else if (arguments.length === 2) {
                //this.module(moduleId) = {...this.module(moduleId), ...key};
                $.extend(this.module(moduleId), key);
            } else if (arguments.length === 3) {
               /* let mod = this.module(moduleId);
                mod[key] = value;*/
                this.module(moduleId)[key] = value;
            }
        }
    };

    let event = modules['event'] = {
        events: $({}),
        off: function (events, selector, handler) {
            this.events.off(events, selector, handler);
            return this;
        },
        on: function (event, selector, data, handler) {
            this.events.on(event, selector, data, handler);
            return this;
        },
        trigger: function (eventType, extraParameters) {
            this.events.trigger(eventType, extraParameters);
            return this;
        },
        one: function (event, selector, data, handler) {
            this.events.one(event, selector, data, handler);
            return this;
        },
        sub: function (target) {
            target.events = $({});
            target.on = $.proxy(event.on, target);
            target.one = $.proxy(event.one, target);
            target.off = $.proxy(event.off, target);
            target.trigger = $.proxy(event.trigger, target);
            target.triggerCondition = $.proxy(event.triggerCondition, target);
        },
        triggerCondition: function (target, event, extraParameters) {
            let $target;
            /**
             * event.triggerCondition('testevent');
             * event.triggerCondition('testevent', ['asdf']);
             * event.triggerCondition('#test', 'testevent');
             * event.triggerCondition('#test', 'testevent', ['asdf']);
             */
            switch (arguments.length) {
                case 1:
                    $target = this.events;
                    event = target;
                    break;
                case 2:
                    if ($.isArray(event)) {
                        $target = this.events;
                        extraParameters = event;
                    } else {
                        $target = $(target);
                    }
                    break;
                default:
                    $target = $(target);
                    break;
            }

            if (!event) {
                return false;
            }

            let eventObj = $.Event(event);
            $target.trigger(eventObj);
            return eventObj.isDefaultPrevented();
        }
    };

    let _cutModulePrefix = value => {
        return _cutPrefix(_cutPrefix(value, 'encore.'), 'modules.');
    };

    let _cutPrefix = (value, prefix) => {
        if (!_startsWith(value, prefix)) {
            return value;
        }
        return value.substring(prefix.length, value.length);
    };

    let _startsWith = (val, prefix) => {
        if (!val || !prefix) {
            return false;
        }
        return val.indexOf(prefix) === 0;
    };

    let _isDefined = obj => {
        return typeof obj !== 'undefined';
    };

    let addModuleLogger = (module, log) => {
        log = log || require('log');
        module.log = log.module(module);
    };

    document.addEventListener('DOMContentLoaded', original => {
        let log = require('log');

        moduleArr.forEach(module => {
            addModuleLogger(module, log);
        });

        initialModules.forEach(module => {
            initModule(module);
        });

        encore.initialized = true;
        event.trigger('encore:ready');
        $(document).trigger('encore:ready', [false, encore]);
    });

    let initModule = module => {
        let log = require('log');
        event.trigger('encore:beforeInitModule', module);
        if (module.init) {
            try {
                //event.trigger(module.id.replace('.', ':') + ':beforeInit', module);

                event.trigger(module.id.replace(/\./g, ':') + ':beforeInit', module);
                module.init();
                event.trigger(module.id.replace(/\./g, ':') + ':afterInit', module);

                //event.trigger(module.id.replace('.', ':') + ':afterInit', module);
            } catch (err) {
                log.error('Could not initialize module: ' + module.id, err);
            }
        }
        event.trigger('encore:afterInitModule', module);
        log.debug('Module initialized: ' + module.id);
    };

    let unloaded = [];

    event.on('encore:modules:client:pjax:success',  evt => {
        pjaxInitModules.forEach(module => {
            if (module.initOnPjaxLoad && unloaded.indexOf(module.id) > -1) {
                module.init(true);
            }
        });

        event.trigger('encore:ready');
        $(document).trigger('encore:ready', [true, encore]);
    })
        .on('encore:modules:client:pjax:beforeSend', evt =>  {
            unloaded = [];

            moduleArr.forEach(module => {
                if (module.unload) {
                    module.unload();
                }
                unloaded.push(module.id);
            });
        });

    return {
        module: module,
        modules: modules,
        config: config,
        event: event,
        require: require
    };
})(jQuery);
