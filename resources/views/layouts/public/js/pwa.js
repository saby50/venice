window.addEventListener('load', e => {
  if ('serviceWorker' in navigator) {
    try {
       navigator.serviceWorker.register('./sw.js');
    }catch(error) {
    
    }
  }
});
