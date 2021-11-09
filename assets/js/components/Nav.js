import React, { Component } from 'react';
import { BrowserRouter as Router, Route, Switch, Link } from 'react-router-dom';
import ReactDOM from "react-dom";

export default function Nav() {

    return (
        <Router>
            <div>
                <nav>
                    <ul>
                        <li>
                            <Link to="/">
                                <i className="fas fa-home"></i>
                                Accueil
                            </Link>
                        </li>
                        <li>
                            <Link to="/seances">
                                <i className="fas fa-child"></i>
                                Catégories
                            </Link>
                        </li>
                        <li>
                            <Link to="/others">
                                <i className="fas fa-heartbeat"></i>
                                Catégories2
                            </Link>
                        </li>
                        <li>
                            <Link to="/mon-compte">
                                <i className="fas fa-user-cog"></i>
                                Mon compte
                            </Link>
                        </li>
                    </ul>
                </nav>
            </div>
        </Router>
    )
}

function Accueil() {
    return <h2>Home</h2>;
}

const containerNav = document.querySelector("#nav");

ReactDOM.render(<Nav />, containerNav);