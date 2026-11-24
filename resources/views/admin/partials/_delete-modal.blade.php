<div x-data="{
        isOpen: false,
        deleteUrl: '',
        itemName: '',
        lastFocused: null,
        openModal(detail) {
            this.lastFocused = document.activeElement;
            this.deleteUrl = detail.url;
            this.itemName = detail.name;
            this.isOpen = true;
            this.$nextTick(() => {
                this.$refs.cancelBtn?.focus();
            });
        },
        closeModal() {
            this.isOpen = false;
            this.$nextTick(() => {
                this.lastFocused?.focus();
                this.lastFocused = null;
            });
        },
        trapFocus(event) {
            if (!this.isOpen || event.key !== 'Tab' || !this.$refs.modalBox) return;
            const focusables = Array.from(this.$refs.modalBox.querySelectorAll('button:not([disabled])')).filter(el => el.offsetParent !== null);
            if (!focusables.length) return;
            const first = focusables[0];
            const last = focusables[focusables.length - 1];
            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        }
     }"
     x-on:open-delete-modal.window="openModal($event.detail)"
     x-on:keydown.escape.window="if (isOpen) closeModal()"
     x-on:keydown.tab.window="trapFocus($event)"
     x-show="isOpen"
     role="dialog"
     aria-modal="true"
     aria-labelledby="delete-modal-title"
     class="modal modal-open"
     x-transition
     style="display: none;"
     x-cloak>
    <div x-ref="modalBox" class="modal-box max-w-md bg-base-100 border border-base-300">
        <h3 id="delete-modal-title" class="font-bold text-lg text-error flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            Konfirmasi Hapus
        </h3>
        <p class="py-4 text-sm text-base-content/85">
            Apakah Anda yakin ingin menghapus <span class="font-semibold text-base-content" x-text="itemName"></span>? Tindakan ini tidak dapat dibatalkan.
        </p>
        <div class="modal-action">
            <button type="button" x-ref="cancelBtn" class="btn btn-ghost min-h-[44px] cursor-pointer" x-on:click="closeModal()">Batal</button>
            <form x-bind:action="deleteUrl" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error text-white min-h-[44px] cursor-pointer">Hapus</button>
            </form>
        </div>
    </div>
    <div class="modal-backdrop bg-neutral/40" x-on:click="closeModal()"></div>
</div>
