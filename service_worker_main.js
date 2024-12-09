'use strict';

const cacheName = 'dERM-0.0.9';
const startPage = 'https://derm.theusamarble.com';
const offlinePage = 'https://derm.theusamarble.com/assets/maintinancemode/index.html';
const filesToCache = [startPage, offlinePage, 'assets/media/favicon/android-chrome-192x192.png'];
const neverCacheUrls = [/\/wp-admin/,/\/wp-login/,/preview=true/];

// Install
self.addEventListener('install', function(e) {
  console.log('dERM service worker installation');
  e.waitUntil(
      caches.open(cacheName).then(function(cache) {
        console.log('dERM service worker caching dependencies');
        filesToCache.map(function(url) {
          return cache.add(url).catch(function (reason) {
            return console.log('dERM: ' + String(reason) + ' ' + url);
          });
        });
      })
  );
});

// Activate
self.addEventListener('activate', function(e) {
  console.log('dERM service worker activation');
  e.waitUntil(
      caches.keys().then(function(keyList) {
        return Promise.all(keyList.map(function(key) {
          if ( key !== cacheName ) {
            console.log('dERM old cache removed', key);
            return caches.delete(key);
          }
        }));
      })
  );
  return self.clients.claim();
});

// Fetch
self.addEventListener('fetch', function(e) {

  // Return if the current request url is in the never cache list
  if ( ! neverCacheUrls.every(checkNeverCacheList, e.request.url) ) {
    console.log( 'dERM: Current request is excluded from cache.' );
    return;
  }

  // Return if request url protocal isn't http or https
  if ( ! e.request.url.match(/^(http|https):\/\//i) )
    return;

  // Return if request url is from an external domain.
  if ( new URL(e.request.url).origin !== location.origin )
    return;

  // For POST requests, do not use the cache. Serve offline page if offline.
  if ( e.request.method !== 'GET' ) {
    e.respondWith(
        fetch(e.request).catch( function() {
          return caches.match(offlinePage);
        })
    );
    return;
  }

  // Revving strategy
  if ( e.request.mode === 'navigate' && navigator.onLine ) {
    e.respondWith(
        fetch(e.request).then(function(response) {
          return caches.open(cacheName).then(function(cache) {
            cache.put(e.request, response.clone());
            return response;
          });
        })
    );
    return;
  }

  e.respondWith(
      caches.match(e.request).then(function(response) {
        return response || fetch(e.request).then(function(response) {
          return caches.open(cacheName).then(function(cache) {
            cache.put(e.request, response.clone());
            return response;
          });
        });
      }).catch(function() {
        return caches.match(offlinePage);
      })
  );
});

// Check if current url is in the neverCacheUrls list
function checkNeverCacheList(url) {
  if ( this.match(url) ) {
    return false;
  }
  return true;
}