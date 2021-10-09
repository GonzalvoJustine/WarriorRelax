import React, { Component } from 'react';
import logo_mobile from "../../images/logo/logo_mobile.svg";

class Header extends Component {

    render() {
        return (
            <div>
                <img src={ logo_mobile } alt="logo_mobile" width={100}/>
            </div>
        )
    }
}

export default Header;