<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('📷 Scan QR Code Presensi') }}
        </h2>
    </x-slot>

    <!-- Library CDN HTML5 QR Code Scanner -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <h3 class="text-lg font-bold text-gray-700 mb-2">Arahkan Kamera ke QR Code</h3>
                <p class="text-xs text-gray-500 mb-4">Pastikeun méré izin (allow) aksés kamera dina browser anjeun.</p>

                <!-- Box Preview Kamera -->
                <div id="reader" class="w-full rounded-lg overflow-hidden border bg-gray-50"></div>

                <!-- Notifikasi Hasil Scan -->
                <div id="result-message" class="mt-4 p-3 text-sm rounded hidden"></div>
            </div>
        </div>
    </div>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Pas QR kabaca, stop scan saheulaanan ambeh teu mepende request
            html5QrcodeScanner.clear();

            // Kirim data QR via AJAX POST ka Controller
            fetch("{{ route('siswa.scan.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ qr_code: decodedText })
            })
            .then(response => response.json())
            .then(data => {
                let msgDiv = document.getElementById('result-message');
                msgDiv.classList.remove('hidden');

                if(data.success) {
                    msgDiv.className = "mt-4 p-3 text-sm rounded bg-green-100 text-green-800 font-bold";
                    msgDiv.innerText = "✅ " + data.message;
                } else {
                    msgDiv.className = "mt-4 p-3 text-sm rounded bg-red-100 text-red-800 font-bold";
                    msgDiv.innerText = "❌ " + data.message;
                }
            })
            .catch(error => {
                alert("Aya kasalahan jaringan atawa server!");
            });
        }

        // Render Kamera Scanner
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: {width: 250, height: 250} }, false);
        html5QrcodeScanner.render(onScanSuccess);
    </script>
</x-app-layout>