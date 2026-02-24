document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('registrationForm');
    const message = document.getElementById('RegistrationMessage');
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);

            try {
                const response = await axios.post('/registration-ajax', formData);
                if (response.data.success) {
                    message.innerHTML = `<span class="text-success">${response.data.message}</span>`;
                   
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {

                    

                    const errors = error.response.data.errors;
                    let html = '<ul class="ErrorsListeRegistration">';

                    for (const field in errors) {
                        errors[field].forEach(msg => {
                            html += `<li class="text-danger">${msg}</li>`;
                        });
                    }

                    html += '</ul>';

                    
                    message.innerHTML = html;
                    message.classList.remove('d-none');


                } else {
                    message.innerHTML = `<span class="text-danger">Server error</span>`;
                }
            }
        });
    }


    const ResendLinkForm = document.getElementById('ResendLinkForm');
    const ResendLinkMessage = document.getElementById('ResendLinkMessage');

    if (ResendLinkForm) {
        ResendLinkForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(ResendLinkForm);

            try {
                const response = await axios.post('/email/verification-notification', formData);

                if (response.data.success) {
                    ResendLinkMessage.innerHTML = `<span class="text-success">${response.data.message}</span>`;
                    
                }
                else {
                    
                    ResendLinkMessage.innerHTML = `<span class="text-warning">${response.data.message}</span>`;
                }

            } catch (error) {
                if (error.response && error.response.status === 422) {

                    const errors = error.response.data.errors;
                    let html = '<ul class="ErrorsListeRegistration">';

                    for (const field in errors) {
                        errors[field].forEach(msg => {
                            html += `<li class="text-danger">${msg}</li>`;
                        });
                    }

                    html += '</ul>';

                    
                    ResendLinkMessage.innerHTML = html;
                    ResendLinkMessage.classList.remove('d-none');


                } else if (error.response?.status === 404) {

                    ResendLinkMessage.innerHTML = `<span class="text-danger">${error.response.data.message}</span>`;

                } else {
                    ResendLinkMessage.innerHTML = `<span class="text-danger">Server error</span>`;
                }
            }
        });
    }

});