import React, {Component} from 'react';
import { Link } from "react-router-dom";

class Account extends Component {

    render() {
        return (
            <div>
                <div className={"Bandeau"}>
                    <h1>Mon compte</h1>
                </div>
                <Link to='/posts'>
                    <button className={"btn btn-white"}>
                        Créer mon compte
                        <i className="far fa-caret-square-right"></i>
                    </button>
                </Link>
            </div>
        )
    }
}

export default Account;
