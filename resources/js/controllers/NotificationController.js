export class NotificationController {

    constructor() {

        this.notifications = document.querySelectorAll('.header-notification');

        if (this.notifications.length > 0)
            this.init()
    }

    init() {

        this.notifications.forEach(notification => {

            notification.addEventListener('click', function () {

                let id = this.getAttribute('data-id');
                let route = this.getAttribute('data-route');
                let url = this.getAttribute('data-url');
                
                let form = new FormData;
                form.append('id', id);
                form.append('route', route);

                axios.post(url, form)
                    .then(response => {

                        if (response.data.status == 'success')
                            window.location.href = route;

                    }).catch(error => {

                    });
            })
        });
    }
}