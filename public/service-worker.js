/**
 * Copyright 2018 Google Inc. All Rights Reserved.
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *     http://www.apache.org/licenses/LICENSE-2.0
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

// If the loader is already loaded, just stop.
if (!self.define) {
  const singleRequire = name => {
    if (name !== 'require') {
      name = name + '.js';
    }
    let promise = Promise.resolve();
    if (!registry[name]) {
      
        promise = new Promise(async resolve => {
          if ("document" in self) {
            const script = document.createElement("script");
            script.src = name;
            document.head.appendChild(script);
            script.onload = resolve;
          } else {
            importScripts(name);
            resolve();
          }
        });
      
    }
    return promise.then(() => {
      if (!registry[name]) {
        throw new Error(`Module ${name} didn’t register its module`);
      }
      return registry[name];
    });
  };

  const require = (names, resolve) => {
    Promise.all(names.map(singleRequire))
      .then(modules => resolve(modules.length === 1 ? modules[0] : modules));
  };
  
  const registry = {
    require: Promise.resolve(require)
  };

  self.define = (moduleName, depsNames, factory) => {
    if (registry[moduleName]) {
      // Module is already loading or loaded.
      return;
    }
    registry[moduleName] = Promise.resolve().then(() => {
      let exports = {};
      const module = {
        uri: location.origin + moduleName.slice(1)
      };
      return Promise.all(
        depsNames.map(depName => {
          switch(depName) {
            case "exports":
              return exports;
            case "module":
              return module;
            default:
              return singleRequire(depName);
          }
        })
      ).then(deps => {
        const facValue = factory(...deps);
        if(!exports.default) {
          exports.default = facValue;
        }
        return exports;
      });
    });
  };
}
define("./service-worker.js",['./workbox-64f1e998'], function (workbox) { 'use strict';

  /**
  * Welcome to your Workbox-powered service worker!
  *
  * You'll need to register this file in your web app.
  * See https://goo.gl/nhQhGp
  *
  * The rest of the code is auto-generated. Please don't update this file
  * directly; instead, make changes to your Workbox build configuration
  * and re-run your build process.
  * See https://goo.gl/2aRDsh
  */

  self.addEventListener('message', event => {
    if (event.data && event.data.type === 'SKIP_WAITING') {
      self.skipWaiting();
    }
  });
  /**
   * The precacheAndRoute() method efficiently caches and responds to
   * requests for URLs in the manifest.
   * See https://goo.gl/S9QRab
   */

  workbox.precacheAndRoute([{
    "url": "/css/app.css",
    "revision": "d41d8cd98f00b204e9800998ecf8427e"
  }, {
    "url": "/js/manifest.js",
    "revision": "3c22ec977d52c291f0ee8d21c20ecbe6"
  }, {
    "url": "alert.js",
    "revision": "b495b78342f2a8bcda425ca7fe8a5f77"
  }, {
    "url": "configuration.js",
    "revision": "12da307104da7ec701924391b5c803a9"
  }, {
    "url": "home.js",
    "revision": "ea7a9b9ab27dad09f62272f781925897"
  }, {
    "url": "map.js",
    "revision": "e35e0b7854979993d6b2e16f9ea85c42"
  }, {
    "url": "settings.js",
    "revision": "09acbf6f249aa2f57c98edf45091306d"
  }, {
    "url": "table.js",
    "revision": "db7a7a930a8de2a611ba1eac88b37af8"
  }, {
    "url": "vendors~home.js",
    "revision": "a8ee184fa6c853344c7e814d1b27e79b"
  }, {
    "url": "vendors~home~map~table.js",
    "revision": "e5ce7cd8279bd8e5b9f609905b19ee67"
  }, {
    "url": "vendors~map.js",
    "revision": "4c1800a7f5cc2652a41a0f2ec76bfcb3"
  }, {
    "url": "vendors~table.js",
    "revision": "ecef772b0add5bafbe4ef0d09cff11d4"
  }], {});

});
