<div class="space-y-4" x-data="{ copied: false }">
    <div class="flex items-center justify-between mb-4">
        <span class="text-sm text-gray-600 dark:text-gray-400">Preview (click button below to copy)</span>
        <span x-show="copied" x-transition class="text-sm text-success-600 dark:text-success-400 font-medium">✓ Copied!</span>
    </div>
    <br/>
    <div class="rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-4">
        <pre class="text-sm font-mono text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $message }}</pre>
    </div>

    <div class="flex justify-center mt-6">
        <button
            type="button"
            @click="
                navigator.clipboard.writeText({{ json_encode($message) }}).then(() => {
                    copied = true;
                    setTimeout(() => copied = false, 2000);
                    new FilamentNotification()
                        .title('Copied to clipboard!')
                        .success()
                        .send();
                })
            "
            class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors shadow-sm w-48"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
            </svg>
            <span x-show="!copied" class="inline-block">Copy for WhatsApp</span>
            <span x-show="copied" x-cloak class="inline-block">Copied!</span>
        </button>
    </div>
</div>

