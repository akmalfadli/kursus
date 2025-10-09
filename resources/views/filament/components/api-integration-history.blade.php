{{-- resources/views/filament/components/api-integration-history.blade.php --}}
<div class="space-y-4">
    @php
        $notes = $getRecord()->notes ?? '';
        // Parse API Integration entries
        $apiEntries = [];
        if (str_contains($notes, 'API Integration')) {
            $parts = explode('API Integration:', $notes);
            array_shift($parts); // Remove first empty element

            foreach ($parts as $part) {
                $lines = explode("\n", trim($part));
                $entry = [];

                foreach ($lines as $line) {
                    $line = trim($line);
                    if (empty($line)) continue;

                    if (str_starts_with($line, 'Status:')) {
                        $entry['status'] = trim(str_replace('Status:', '', $line));
                    } elseif (str_starts_with($line, 'Response:')) {
                        $jsonStart = strpos($part, '{');
                        if ($jsonStart !== false) {
                            $jsonStr = substr($part, $jsonStart);
                            $entry['response'] = json_decode($jsonStr, true);
                        }
                    } elseif (preg_match('/^\d{4}-\d{2}-\d{2}/', $line)) {
                        $entry['timestamp'] = $line;
                    }
                }

                if (!empty($entry)) {
                    $apiEntries[] = $entry;
                }
            }
        }
    @endphp

    @if(count($apiEntries) > 0)
        @foreach($apiEntries as $index => $entry)
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                {{-- Header --}}
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                            {{ $entry['timestamp'] ?? 'N/A' }}
                        </span>
                        @if(isset($entry['status']))
                            @php
                                $isSuccess = str_contains($entry['status'], 'Success');
                                $statusBadgeClass = $isSuccess
                                    ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                    : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusBadgeClass }}">
                                @if($isSuccess)
                                    ✓ {{ $entry['status'] }}
                                @else
                                    ✗ {{ $entry['status'] }}
                                @endif
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Response Data --}}
                @if(isset($entry['response']) && is_array($entry['response']))
                    <div class="mt-3">
                        <h4 class="text-xs font-semibold text-gray-600 dark:text-gray-400 mb-2">API Response:</h4>
                        <div class="bg-gray-50 dark:bg-gray-900 rounded border border-gray-200 dark:border-gray-700 p-3">
                            <dl class="space-y-2">
                                @foreach($entry['response'] as $key => $value)
                                    <div class="flex items-start gap-2">
                                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 min-w-[100px]">
                                            {{ ucfirst(str_replace('_', ' ', $key)) }}:
                                        </dt>
                                        <dd class="text-xs text-gray-900 dark:text-gray-100 font-mono">
                                            @if(is_array($value) || is_object($value))
                                                <pre class="text-xs">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </dd>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm">Belum ada riwayat API Integration</p>
        </div>
    @endif
</div>
