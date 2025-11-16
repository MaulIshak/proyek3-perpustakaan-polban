import { ref } from "vue";

const isOpen = ref(false);
const title = ref("");
const message = ref("");
const payload = ref(null); // data yang akan ditampilkan
const actionLabel = ref("Konfirmasi");
const onConfirm = ref<null | (() => void)>(null);

export function useConfirmModal() {
    function open(options: {
        title: string;
        message?: string;
        actionLabel?: string;
        payload?: any;
        onConfirm: () => void;
    }) {
        title.value = options.title;
        message.value = options.message ?? "";
        actionLabel.value = options.actionLabel ?? "Konfirmasi";
        payload.value = options.payload ?? null;
        onConfirm.value = options.onConfirm;
        isOpen.value = true;
    }

    function close() {
        isOpen.value = false;
    }

    function confirm() {
        if (onConfirm.value) onConfirm.value();
        close();
    }

    return {
        isOpen,
        title,
        message,
        payload,
        actionLabel,
        open,
        close,
        confirm,
    };
}
