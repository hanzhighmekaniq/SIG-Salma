<!-- Flowbite CSS dan JS -->
<link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

<!-- CSS Aplikasi -->
@vite('resources/css/app.css')

<!-- Viewport untuk Responsif -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Leaflet CSS dan JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<!-- Leaflet Routing Machine CSS dan JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

@stack('script')
