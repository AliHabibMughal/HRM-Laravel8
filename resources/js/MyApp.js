import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Dashboard from './components/Dashboard';
import Footer from './components/Footer';
import Login from './components/Login';
import Navbar from './components/Navbar';
import Register from './components/Register';


function MyApp() {
    return (
        <>
            <Navbar />

            <Routes>
                <Route path="/dashboard" element={<Dashboard />} />
                <Route path="/register" element={<Register />} />
                <Route path="/login" element={<Login />} />
            </Routes>

            {/* <Footer/> */}
        </>
    );
}

export default MyApp;

const container = document.getElementById('app');
if (container) {
    const root = ReactDOM.createRoot(container);
    root.render(
        <React.StrictMode>
            <BrowserRouter>
                <MyApp/>
            </BrowserRouter>
        </React.StrictMode>
    );
}
