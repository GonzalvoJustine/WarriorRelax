import React, { Component } from 'react';
import { Route, Switch, Link } from 'react-router-dom';
import Users from './Users';
import Posts from './Posts';
import Home from "./Home";
import Account from "./Account";

class Nav extends Component {

    render() {
        return (
            <div>
                <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
                    <ul className="navbar-nav mr-auto">
                        <li className="nav-item">
                            <Link className={"nav-link"} to={"/"}>
                                <i className="fas fa-home"></i>
                                Accueil
                            </Link>
                        </li>
                        <li className="nav-item">
                            <Link className={"nav-link"} to={"/posts"}>
                                <i className="fas fa-child"></i>
                                Catégories
                            </Link>
                        </li>
                        <li className="nav-item">
                            <Link className={"nav-link"} to={"/users"}>
                                <i className="fas fa-heartbeat"></i>
                                Catégories2
                            </Link>
                        </li>
                        <li className="nav-item">
                            <Link className={"nav-link"} to={"/mon-compte"}>
                                <i className="fas fa-user-cog"></i>
                                Mon compte
                            </Link>
                        </li>
                    </ul>
                </nav>
                <Switch>
                    <Route path="/" component={Home} exact />
                    <Route path="/users" component={Users} />
                    <Route path="/posts" component={Posts} />
                    <Route path="/mon-compte" component={Account} />
                </Switch>
            </div>
        )
    }
}

export default Nav;