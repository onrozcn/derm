if("serviceWorker" in navigator) {
  navigator.serviceWorker.register('/service_worker_main.js').then(function() {
    console.log("Service Worker registered!");
  });
} else {
  console.log("Browser not supported!");
}