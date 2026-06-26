<div x-data="{ isOpen: false, deleteUrl: '', itemName: '' }"
     x-on:open-delete-modal.window="isOpen = true; deleteUrl = $event.detail.url; itemName = $event.detail.name;"
     x-show="isOpen"
     class="modal modal-open"
     x-transition
     style="display: none;"
     x-cloak>
    <div class="modal-box max-w-md bg-base-100 border border-base-300">
        <h3 class="font-bold text-lg text-error flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            Konfirmasi Hapus
        </h3>
        <p class="py-4 text-sm text-base-content/85">
            Apakah Anda yakin ingin menghapus <span class="font-semibold text-base-content" x-text="itemName"></span>? Tindakan ini tidak dapat dibatalkan.
        </p>
        <div class="modal-action">
            <button class="btn btn-ghost" x-on:click="isOpen = false">Batal</button>
            <form x-bind:action="deleteUrl" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error text-white">Hapus</button>
            </form>
        </div>
    </div>
    <div class="modal-backdrop bg-neutral/40" x-on:click="isOpen = false"></div>
</div>
