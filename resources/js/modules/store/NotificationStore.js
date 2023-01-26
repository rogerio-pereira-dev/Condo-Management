import { defineStore } from 'pinia'

// You can name the return value of `defineStore()` anything you want, 
// but it's best to use the name of the store and surround it with `use` 
// and `Store` (e.g. `useUserStore`, `useCartStore`, `useProductStore`)
// the first argument is a unique id of the store across your application
export const useNotificationStore = defineStore('notification', {
    //State
    state: () => {
        return {
            active: false,
            timeout: 3000,
            color: 'secondary',
            text: '',
        }
    },

    //Getters

    //Actions
    actions: {
        show(text, timeout = 3000, color = 'secondary') {
            this.text = text
            this.timeout = timeout
            this.color = color

            this.active = true
        },

        hide()
        {
            this.active = false
        }
    }
})