/**
 * Register the OTP timer as an Alpine.js component.
 *
 * The component is registered immediately when Alpine is already available,
 * or through the `alpine:init` event when Alpine has not been initialized yet.
 */
function registerTimerComponent() {
    if (window.Alpine) {
        window.Alpine.data('timer', () => ({
            ttl: 0,
            secondsOnly: false,

            /**
             * Initialize the timer component using the element's data attributes.
             */
            init() {
                this.ttl = Number(this.$el.dataset.ttl);
                this.secondsOnly = this.$el.hasAttribute('secondsOnly');

                const timer = setInterval(() => {
                    this.updateTimerText();
                    this.$el.dataset.ttl = this.ttl;

                    if (this.ttl <= 0) {
                        clearInterval(timer);
                        this.$el.textContent = '';
                        return;
                    }

                    this.ttl--;
                }, 1000);
            },

            /**
             * Update the timer display based on the remaining time.
             */
            updateTimerText() {
                const minutes = Math.floor(this.ttl / 60);
                const seconds = this.ttl % 60;

                this.$el.textContent = this.secondsOnly
                                     ? this.ttl
                                     : String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
            }
        }));
    }
}

// Register the component when Alpine is initialized.
document.addEventListener('alpine:init', registerTimerComponent);

// Register immediately if Alpine has already been initialized.
if (window.Alpine) {
    registerTimerComponent();
}