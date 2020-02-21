importScripts('public/js/node_modules/workbox-sw/build/workbox-sw.js');
const staticAssets = [
   'public/css/front/style.css',
   'public/css/front/media.css',
   'public/lib/bootstrap/css/bootstrap.min.css',
   'public/lib/font-awesome/css/font-awesome.min.css',
   'public/js/jquery-2.1.3.js',
   'public/js/bootstrap.min.js',
   'public/js/jquery-ui.js',
   'public/css/jquery.timepicker.min.css',
   'public/js/jquery.timepicker.min.js',
   '/offline',
   'public/images/oops2.png'
];

workbox.precaching.precacheAndRoute(staticAssets);

workbox.routing.registerRoute(
  new RegExp('https://staging.veniceindia.com'),
  new workbox.strategies.NetworkFirst()
);


workbox.routing.setCatchHandler(({event}) => {
  switch (event.request.destination) {
    case 'document':
      return caches.match('https://staging.veniceindia.com/offline');
    break;

    default:
      return Response.error();
  }
});




