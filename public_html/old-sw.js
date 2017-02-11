importScripts('./scripts/serviceworker-cache-polyfill.js');

var CACHE_NAME = 'my-site-cache-v1';
var urlsToCache = [
  './css/style.css',
  './scripts/admin.js',
  './scripts/admin.min.js',
  './scripts/signin.js',
  './scripts/signin.min.js',
  './developers',
  './signin',
  './admin',
  './projects',
  './downloads',
  './robocon',
  './team',
  './home',
  'https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/paper/bootstrap.min.css',
  'https://cdn.materialdesignicons.com/1.7.22/css/materialdesignicons.min.css',
  'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js',
  'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'
];

self.addEventListener('install', function(event) {
  // Perform install steps
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
});

self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request).then(function(resp) {
      return resp || fetch(event.request).then(function(response) {
        return caches.open(CACHE_NAME).then(function(cache) {
          cache.put(event.request, response.clone());
          return response;
        });  
      });
    })
  );
});