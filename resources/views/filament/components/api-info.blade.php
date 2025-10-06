{{-- resources/views/filament/components/api-info.blade.php --}}
<div class="p-4 bg-blue-50 dark:bg-blue-950 rounded-lg border border-blue-200 dark:border-blue-800">
    <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-3">📡 Format Request API</h4>

    <div class="space-y-3 text-sm">
        <div>
            <p class="font-medium text-blue-800 dark:text-blue-200 mb-1">Endpoint:</p>
            <code class="block p-2 bg-white dark:bg-gray-900 rounded border text-xs">
                POST /functions/v1/add-siswa
            </code>
        </div>

        <div>
            <p class="font-medium text-blue-800 dark:text-blue-200 mb-1">Headers:</p>
            <code class="block p-2 bg-white dark:bg-gray-900 rounded border text-xs whitespace-pre">Authorization: Bearer &lt;TOKEN_ANDA&gt;
Content-Type: application/json</code>
        </div>

        <div>
            <p class="font-medium text-blue-800 dark:text-blue-200 mb-1">Request Body:</p>
            <code class="block p-2 bg-white dark:bg-gray-900 rounded border text-xs whitespace-pre">{
  "email": "siswa@example.com",
  "password": "temporary_password",
  "name": "Nama Siswa",
  "class": "Kelas 10A"
}</code>
        </div>

        <div>
            <p class="font-medium text-blue-800 dark:text-blue-200 mb-1">Expected Response (Success):</p>
            <code class="block p-2 bg-white dark:bg-gray-900 rounded border text-xs whitespace-pre">{
  "message": "Siswa berhasil dibuat.",
  "userId": "user-id-123",
  "email": "siswa@example.com"
}</code>
        </div>
    </div>

    <div class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-950 rounded border border-yellow-200 dark:border-yellow-800">
        <p class="text-xs text-yellow-800 dark:text-yellow-200">
            <strong>⚠️ Catatan:</strong> API akan dipanggil otomatis setelah pembayaran berhasil.
            Password temporary akan digenerate dan dikirim ke email siswa.
        </p>
    </div>
</div>
