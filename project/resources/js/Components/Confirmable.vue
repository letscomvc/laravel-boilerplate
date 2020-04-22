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

    type: {
      type: String,
      default: () =>{
        return 'confirm';
      }
    },

    timeout: {
      type: Number,
      default: () =>{
        return 5000;
      }
    }
  },

  data: () => {
    return {
      confirmed: false,
    }
  },

  methods: {
    confirm(event, callbackOnYes, callbackOnNo) {
      if (this.confirmed) {
        this.confirmed = false;
        return;
      } else {
        event.preventDefault();
      }

      const vm = this;
      const type = this.validateSnotifyType();

      this.$snotify[type](this.message, this.title, {
        timeout: this.timeout,
        showProgressBar: false,
        closeOnClick: true,
        pauseOnHover: false,
        buttons: [
          {
            text: 'Sim',
            action: (toast) => {
              this.confirmed = true;
              event.target.click();
              vm.$snotify.remove(toast.id);
              if (callbackOnYes) {
                callbackOnYes();
              }
            }
          },
          {
            text: 'Não',
            action: (toast) => {
              this.confirmed = false;
              vm.$snotify.remove(toast.id);
              if (callbackOnNo) {
                callbackOnNo();
              }
            }
          },
        ],
      });
    },

    validateSnotifyType() {
      const validTypes = [
        'simple',
        'success',
        'info',
        'warning',
        'error',
        'async',
        'confirm',
        'prompt',
      ];

      return (_.indexOf(validTypes, this.type) == -1) ? 'confirm' : this.type;
    }
  },
}
</script>

