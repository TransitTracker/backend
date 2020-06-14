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
    "revision": "d33e1f004f4773510d59e63169225dd2"
  }, {
    "url": "home.js",
    "revision": "560bcf86c0fc2f6532eb786d2f3c0048"
  }, {
    "url": "map.js",
    "revision": "f601a4c39685ffcae174d1bdefcce864"
  }, {
    "url": "settings.js",
    "revision": "516245f288e75d594c8ae369b411f224"
  }, {
    "url": "table.js",
    "revision": "25c643d272ee2146447653af33e852db"
  }, {
    "url": "vendors~home.js",
    "revision": "a8ee184fa6c853344c7e814d1b27e79b"
  }, {
    "url": "vendors~home~map~table.js",
    "revision": "7484a8784ccc65329f06ea8ccdbb752d"
  }, {
    "url": "vendors~map.js",
    "revision": "b4f7c61393af4e7983cc5aa45039a73a"
  }, {
    "url": "vendors~table.js",
    "revision": "ecef772b0add5bafbe4ef0d09cff11d4"
  }], {});

});
