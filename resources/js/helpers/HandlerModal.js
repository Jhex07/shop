import { ref } from 'vue'



export default function handlermodal() {
    const modal = ref(null)
    const load_modal = ref(false)


    const mountedModal = async (status = true) => {
        return await new Promise((resolve, reject) => {
            load_modal.value = status
            setTimeout(() => resolve(), 200)
        })
    }


    const openModal = async modal_id => {
        await mountedModal()
        modal.value = new bootstrap.Modal(`#${modal_id}`)
        modal.value.show()
    }


    const closeModal = async() => {
        modal.value.hide()
        await mountedModal(false)
    }


    return {
        load_modal,
        closeModal,
        openModal
    }
}
