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
define("./service-worker.js",['./workbox-c39032a0'], function (workbox) { 'use strict';

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
    "url": "/js/app.js",
    "revision": "35a49e11b099edd70fb2795236958e2f"
  }, {
    "url": "/js/manifest.js",
    "revision": "ec7aeda6b1fffba1f7fb6751ee3aced9"
  }, {
    "url": "fonts/vendor/@mdi/materialdesignicons-webfont.eot?2d0a0d8f5f173be15a67aa084db94fe6",
    "revision": "2d0a0d8f5f173be15a67aa084db94fe6"
  }, {
    "url": "fonts/vendor/@mdi/materialdesignicons-webfont.ttf?f51112347be6b44f9ef46151a971430d",
    "revision": "f51112347be6b44f9ef46151a971430d"
  }, {
    "url": "fonts/vendor/@mdi/materialdesignicons-webfont.woff2?d0066537ab6a4c6f8285a5aeb3ba5f09",
    "revision": "d0066537ab6a4c6f8285a5aeb3ba5f09"
  }, {
    "url": "fonts/vendor/@mdi/materialdesignicons-webfont.woff?b4917be25082eb793b5363f2fdb5f282",
    "revision": "b4917be25082eb793b5363f2fdb5f282"
  }, {
    "url": "home.js",
    "revision": "ab043bba1226982ca30e7c4b13bdd389"
  }, {
    "url": "map.js",
    "revision": "1e936c4f9cb1ef237e39f3fd74631f96"
  }, {
    "url": "settings.js",
    "revision": "7120baab1194146534bb0fdea2e6bf84"
  }, {
    "url": "table.js",
    "revision": "e4864f7cf22f80522b3db089febd4211"
  }, {
    "url": "vendors~home.js",
    "revision": "a8ee184fa6c853344c7e814d1b27e79b"
  }, {
    "url": "vendors~home~map~table.js",
    "revision": "804f819bf91cb258718eadc3d8d3e3b0"
  }, {
    "url": "vendors~map.js",
    "revision": "d4baac1e1ae8e627aa9425c38f3af189"
  }, {
    "url": "vendors~table.js",
    "revision": "43f32f5d39419121e33278cbef7763f5"
  }], {});

});
