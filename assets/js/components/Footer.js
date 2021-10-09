import React, { Component } from 'react';
import { Route, Switch, Link } from 'react-router-dom';
import LegalNotices from "./LegalNotices";
import Contact from "./Contact";
import TermsAndConditions from "./TermsAndConditions";

class Footer extends Component {

    render() {
        return (
            <div>
                <Switch>
                    <Route path="/mentions-legales" component={LegalNotices} />
                    <Route path="/contact" component={Contact} />
                    <Route path="/conditions-generales-d-utilisation" component={TermsAndConditions} />
                </Switch>
                <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
                    <ul className="navbar-nav mr-auto">
                        <li className="nav-item">
                            <Link className={"nav-link"} to={"/mentions-legales"}>
                                <i className="fas fa-home"></i>
                                Mentions Légales
                            </Link>
                        </li>
                        <li className="nav-item">
                            <Link className={"nav-link"} to={"/contact"}>
                                <i className="fas fa-child"></i>
                                Contact
                            </Link>
                        </li>
                        <li className="nav-item">
                            <Link className={"nav-link"} to={"/conditions-generales-d-utilisation"}>
                                <i className="fas fa-heartbeat"></i>
                                Conditions générales d'utilisation
                            </Link>
                        </li>
                    </ul>
                </nav>
            </div>
        )
    }
}

export default Footer;