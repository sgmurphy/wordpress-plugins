import {Controller} from "@hotwired/stimulus"
import MicroModal from "micromodal"

document.addEventListener("DOMContentLoaded", () => MicroModal.init())

export default class extends Controller {
    static values = {
        confirmation: String
    }
    static targets = ["submit", "input"]

    isValidConfirmation(confirmationValue) {
        return confirmationValue.toLowerCase() === "reset analytics"
    }

    confirmationValueChanged(confirmationValue) {
        this.inputTarget.value = confirmationValue
        const disable = !this.isValidConfirmation(confirmationValue)
        this.submitTarget.toggleAttribute("disabled", disable)
    }

    updateConfirmation(e) {
        this.confirmationValue = e.target.value
    }

    open() {
        this.confirmationValue = ""
        MicroModal.show("reset-analytics-modal")
    }

    close(e) {
        if(e.target !== e.currentTarget) {
            return
        }

        MicroModal.close("reset-analytics-modal")
    }

    submit(e) {
        e.preventDefault()

        if (!this.isValidConfirmation(this.confirmationValue)) {
            return
        }

        const data = {
            ...iawpActions.reset_analytics,
            confirmation: this.confirmationValue
        }

        this.submitTarget.setAttribute('disabled', 'disabled')
        this.submitTarget.classList.add('sending')

        jQuery.post(ajaxurl, data, (response) => {
            this.submitTarget.classList.remove('sending')
            this.submitTarget.classList.add('sent')
            setTimeout(() => {
                MicroModal.close("reset-analytics-modal")
            }, 1000)
        })
    }
}