<script>
  export default {
    el: '#app',

    props: ['flashMessages'],

    data() {
      return {
        handledFlashMessages: false,
      }
    },

    mounted() {
      this._handleFlashMessages();
      this._setupAxiosInterceptors();
    },

    methods: {
      throwFlashMessage(type, message) {
        this.$snotify[type](message);
      },

      _handleFlashMessages() {
        const flashMessages = document.querySelectorAll('#flash-messages-container > span');
        for (let i = 0; i < flashMessages.length; i++) {
          const flashNode = flashMessages[i];
          const type = flashNode.className;
          const message = flashNode.innerHTML;
          this.throwFlashMessage(type, message);
        }
        this.handledFlashMessages = true;
      },

      _setupAxiosInterceptors() {
        window.axios.interceptors.response.use(function (response) {
          if (response && response.data && response.data.redirect) {
            window.location.href = response.data.redirect;
          }

          return response;
        }, (error) => {
          return this._handleCommonAjaxErrors(error);
        });
      },

      _handleCommonAjaxErrors(error) {
        if (!error.response) {
          this.throwFlashMessage('error', 'Falha interna na rede');
          return Promise.reject(error);
        }

        if (error.response.status === 401 || error.response.status == 419) {
          this._showExpiredSessionMessageAndRedirect();
          return Promise.reject(error);
        }

        if (error.response.status === 403) {
          this.throwFlashMessage('error', 'Permissão negada');
          return Promise.reject(error);
        }

        if (error.response.status === 500) {
          this.throwFlashMessage('error', 'Falha interna do servidor');
          return Promise.reject(error);
        }

        throw error;
      },
    },
  }
</script>