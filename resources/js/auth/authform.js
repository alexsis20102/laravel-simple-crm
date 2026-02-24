document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');
    const message = document.getElementById('loginMessage');

    if(form)
    {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);

            try {
                const response = await axios.post('/login', formData);
                if (response.data.success) {
                    
                    window.location.href = response.data.redirect;
                }


            } catch (error) {
                if (error.response && error.response.status === 422) 
                {

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


                } 
                else if (error.response?.status === 404) 
                {

                    message.innerHTML = `<span class="text-danger">${error.response.data.message}</span>`;

                } 
                else 
                {
                    message.innerHTML = `<span class="text-danger">Server error</span>`;
                }
            }
        });

    }

    const PasswordRecoveryForm = document.getElementById('PasswordRecoveryForm');
    const PasswordRecoveryMessage = document.getElementById('PasswordRecoveryMessage');
    
    if(PasswordRecoveryForm)
    {
        PasswordRecoveryForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(PasswordRecoveryForm);

            try {
                const response = await axios.post('/recovery-pass', formData);
                if (response.data.success) 
                {
                    PasswordRecoveryMessage.innerHTML = `<span class="text-success">${response.data.message}</span>`;
                    
                }
                else 
                {
                    
                    PasswordRecoveryMessage.innerHTML = `<span class="text-warning">${response.data.message}</span>`;
                }

            } catch (error) {
                if (error.response && error.response.status === 422) 
                {

                    const errors = error.response.data.errors;
                    let html = '<ul class="ErrorsListeRegistration">';

                    for (const field in errors) {
                        errors[field].forEach(msg => {
                            html += `<li class="text-danger">${msg}</li>`;
                        });
                    }

                    html += '</ul>';

                    
                    PasswordRecoveryMessage.innerHTML = html;
                    PasswordRecoveryMessage.classList.remove('d-none');


                } 
                else if (error.response?.status === 404) 
                {

                    PasswordRecoveryMessage.innerHTML = `<span class="text-danger">${error.response.data.message}</span>`;

                } 
                else 
                {
                    PasswordRecoveryMessage.innerHTML = `<span class="text-danger">Server error</span>`;
                }
            }
        });

    }

    const NewPasswordForm = document.getElementById('NewPasswordForm');
    const NewPasswordMessage = document.getElementById('NewPasswordMessage');
    
    if(NewPasswordForm)
    {
        NewPasswordForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(NewPasswordForm);

            try {
                const response = await axios.post('/password/reset', formData);
                if (response.data.success) 
                {
                    NewPasswordMessage.innerHTML = `<span class="text-success">${response.data.message}</span>`;
                   
                }
                else 
                {
                    
                    NewPasswordMessage.innerHTML = `<span class="text-warning">${response.data.message}</span>`;
                }

            } catch (error) {
                if (error.response && error.response.status === 422) 
                {

                    const errors = error.response.data.errors;
                    let html = '<ul class="ErrorsListeRegistration">';

                    for (const field in errors) {
                        errors[field].forEach(msg => {
                            html += `<li class="text-danger">${msg}</li>`;
                        });
                    }

                    html += '</ul>';

                    
                    NewPasswordMessage.innerHTML = html;
                    NewPasswordMessage.classList.remove('d-none');


                } 
                else if (error.response?.status === 404) 
                {

                    NewPasswordMessage.innerHTML = `<span class="text-danger">${error.response.data.message}</span>`;

                } 
                else 
                {
                    NewPasswordMessage.innerHTML = `<span class="text-danger">Server error</span>`;
                }
            }
        });

    }


   const logoutBtn = document.getElementById('logoutBtn');

   if(logoutBtn)
   {
        logoutBtn.addEventListener('click', async () => {
            try {
                const response = await axios.post('/logout', {}, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.data.success) {
                    window.location.href = response.data.redirect;
                }
            } catch (error) {
                console.error('Logout error:', error);
            }
        });
   }
    



    

});