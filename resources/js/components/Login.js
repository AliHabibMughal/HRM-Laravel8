import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import { redirect } from 'react-router-dom';

export default function Login() {
    const [inputEmail, setInputEmail] = useState('');
    const [inputPassword, setInputPassword] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault();
        axios.post('http://localhost:8000/api/login', {
            email: inputEmail,
            password: inputPassword,
           })
            .then((response) => {
                response => alert(JSON.stringify(response.data))
                console.log(response)
                // localStorage.setItem('usertoken', response.data.token)
                // redirect('/dashboard')

            })
            .catch(error => {
                console.log("ERROR:: ", error.response.data);

        });
    }

    // const token = localStorage.getItem('usertoken');
    // const submitForm = ()=> {
    //     const form=this.event
    //     this.showModalOne=false,
    //     axios.post('http://localhost:8000/api/dashboard', form, { headers: { Accept: 'application/json', Authorization: `Bearer ${token}` } })
    //       .then((res) => {
    //         console.log(res);
    //         location.reload(true)
    //       })
    //       .catch((err) => {
    //         console.log(err);
    //       });
    // }


    return (
        <>
            <div className="container mt-3">
                <div className="container register-form">
                    <form className="form" onSubmit={handleSubmit}>
                        <div className="bg-primary text-center text-light">
                            <h1>Login</h1>
                        </div>

                        <div className="form-content">
                            <div className="row">
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <input type="email" className="form-control" name='email' placeholder="Email *" value={inputEmail} onChange={e => setInputEmail(e.target.value)} required />
                                    </div>
                                    <div className="form-group">
                                        <input type="password" className="form-control" name='password' placeholder="Password *" value={inputPassword} onChange={e => setInputPassword(e.target.value)} required />
                                    </div>
                                </div>
                            </div>
                            <button type="submit" className="btn btn-primary mt-3">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </>
    )
}

