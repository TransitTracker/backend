self.addEventListener('install', () => self.skipWaiting());

self.addEventListener('activate', () => {
  caches.keys().then(function (names) {
    for (let name of names) {
      caches.delete(name);
    }
  });
  self.registration.unregister();
});
