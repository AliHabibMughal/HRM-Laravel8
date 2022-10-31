import axios from 'axios';
import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import { redirect } from 'react-router-dom';

export default function Register() {
    const [inputName, setInputName] = useState('');
    const [inputEmail, setInputEmail] = useState('');
    const [inputPassword, setInputPassword] = useState('');
    const [inputDOB, setInputDOB] = useState('');
    const [inputAddress, setInputAddress] = useState('');
    const [inputPhone, setInputPhone] = useState('');
    const [inputDesignation, setInputDesignation] = useState('');
    const [inputRole, setInputRole] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault();
        axios.post('http://localhost:8000/api/register', {
            email: inputEmail,
            password: inputPassword,
            DOB: inputDOB,
            address: inputAddress,
            phone: inputPhone,
            designation: inputDesignation,
            roles: inputRole,
           })
            .then((response) => {
                // response => alert(JSON.stringify(response.data))
                console.log(response)
                // localStorage.setItem('usertoken', response.data.token)
                // redirect('/dashboard')

            })
            .catch(error => {
                console.log("ERROR:: ", error.response.data);

        });
    }

    return (
        <>
            <div className="container mt-3">
                <div className="container register-form">
                    <form className="form" onSubmit={handleSubmit}>
                        <div className="bg-primary text-center text-light">
                            <h1>Register</h1>
                        </div>

                        <div className="form-content">
                            <div className="row">
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <input type="text" className="form-control" name='name' placeholder="Your Name *" value={inputName} onInput={(event)=> setInputName(event.target.value)} required/>
                                    </div>
                                    <div className="form-group">
                                        <input type="email" className="form-control" name='email' placeholder="Email *" value={inputEmail} onInput={(e)=> setInputEmail(e.target.value)} required/>
                                    </div>
                                    <div className="form-group">
                                        <input type="password" className="form-control" name='password' placeholder="Password *" value={inputPassword} onInput={(e)=> setInputPassword(e.target.value)} required/>
                                    </div>
                                    <div className="form-group">
                                        <input type="date" className="form-control" name='DOB' placeholder="Date Of Birth (YYYY/MM/DD) *" value={inputDOB} onInput={(e)=> setInputDOB(e.target.value)} required/>
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <input type="text" className="form-control" name='address' placeholder="Address *" value={inputAddress} onInput={(e)=> setInputAddress(e.target.value)} required/>
                                    </div>
                                    <div className="form-group">
                                        <input type="phone" className="form-control" name='phone' placeholder="Phone Number *" value={inputPhone} onInput={(e)=> setInputPhone(e.target.value)} required/>
                                    </div>
                                    <div className="form-group">
                                        <input type="text" className="form-control" name='designation' placeholder="Designation *" value={inputDesignation} onInput={(e)=> setInputDesignation(e.target.value)} required/>
                                    </div>
                                    <div className="form-group">
                                        <input type="text" className="form-control" name='roles' placeholder="Role *" value={inputRole} onInput={(e)=> setInputRole(e.target.value)} required/>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" className="btn btn-primary mt-3">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </>

    )
}

