const CACHE_NAME = "la-tavola-fina-v1";
const arquivos = ["/", "/index.php","/reserva.php","/cardapio.php","/sobre.php", "/assets/css/style.css", "/assets/js/script.js", "/assets/imgs/icon.svg"];

self.addEventListener("install", (event) => {
    event.waitUntil(caches.open(CACHE_NAME).then(c => c.addAll(arquivos)));
});

self.addEventListener("fetch", (event) => {
    event.respondWith(caches.match(event.request).then(r => r || fetch(event.request)));
});

/*
self.addEventListener("install", () => {
  console.log("Service Worker instalado");
});

self.addEventListener("activate", () => {
  console.log("Service Worker ativado");
});

self.addEventListener("fetch", (event) => {
  console.log("Interceptando:", event.request.url);
});
*/