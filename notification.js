Notification.requestPermission(function(status) {
   console.log('Notification permission status:', status);
});
navigator.serviceWorker.ready.then(function(reg) {
  reg.pushManager.getSubscription().then(function(sub) {
     if (sub==undefined) {

     }else {

     }
  });
});
var options = {
     body: 'Here is a notification body',
     icon: 'public/images/icons/icon-72x72.png',
     vibrate: [100, 50, 100],
     data: {primaryKey: 1}
};
function displayNotification() {
  if (Notification.permission==='granted') {
    navigator.serviceWorker.getRegistration()
    .then(function(reg) {
     reg.showNotification('Hello World!',options);
    });
  }
}