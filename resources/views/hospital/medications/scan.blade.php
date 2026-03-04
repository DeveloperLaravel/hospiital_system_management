<x-app-layout>
<div class="p-6">

<h1 class="text-2xl font-bold mb-6 text-blue-700">
    Medicine QR Scanner
</h1>

<div id="reader" class="w-full max-w-md mx-auto"></div>

<div id="result" class="mt-6"></div>

</div>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
function onScanSuccess(decodedText) {

    fetch(`/api/medicines/scan`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ qr: decodedText })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('result').innerHTML = `
            <div class="bg-green-100 p-4 rounded">
                <h2 class="font-bold">${data.name}</h2>
                <p>Current Quantity: ${data.quantity}</p>
            </div>
        `;
    });
}

let scanner = new Html5QrcodeScanner("reader", {
    fps: 10,
    qrbox: 250
});

scanner.render(onScanSuccess);
</script>

</x-app-layout>
