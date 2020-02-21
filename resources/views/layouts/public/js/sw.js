importScripts('../js/node_modules/workbox-sw/build/workbox-sw.js');
const staticAssets = [
   './'
];


//workbox.precaching.precacheAndRoute(staticAssets);
workbox.routing.registerRoute(
  new RegExp('https://veniceindia.com/(.*)'),
  new workbox.strategies.NetworkFirst()
);
