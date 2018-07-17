<!--
To use:
    <confirmable title="Title"
        message="Confirmation message">
        <button @click="confirm($event)" slot-scope="{confirm}">
            Show confirmation
        </button>
    </confirmable>
-->

<template>
    <div>
        <slot :confirm="confirm">
            Componente vazio
        </slot>
    </div>
</template>

<script>
export default {
    name: "confirmable",

    props: {
        title: {
            type: String,
            required: false,
            default () {
                return 'Confirmação';
            },
        },
        message: {
            type: String,
            required: false,
            default () {
                return '';
            },
        },
    },

    data: () => {
        return {
            confirmed: false,
        }
    },

    methods: {
        confirm(event) {
            if (this.confirmed) {
                this.confirmed = false;
                return;
            } else {
                event.preventDefault();
            }

            this.$snotify.confirm(this.message, this.title, {
                timeout: 5000,
                showProgressBar: false,
                closeOnClick: true,
                pauseOnHover: false,
                buttons: [{
                        text: 'Sim',
                        action: () => {
                            this.confirmed = true;
                            event.target.click();
                        }
                    },
                    {
                        text: 'Não',
                        action: () => {
                            this.confirmed = false;
                        }
                    },
                ],
            });
        }
    },
}
</script>
