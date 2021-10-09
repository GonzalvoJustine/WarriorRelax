import React, {Component} from 'react';
import { Link } from "react-router-dom";
import timer from '../../images/home/timer.svg';
import warrior from '../../images/home/warrior.svg';
import entre_nous from '../../images/home/entre_nous.svg';
import warrior_man from '../../images/home/warrior_man.svg';

class Home extends Component {

    render() {
        return (
            <div>
                <div className={"Bandeau"}>
                    <h1>Accueil</h1>
                </div>
                <div className={"blockOne"}>
                    <h2>Titre :</h2>
                    <p>Morbi mollis tellus ac sapien. Morbi
                        mattis ullamcorper velit. Nulla porta
                        dolor. Praesent venenatis metus at
                        tortor pulvinar varius.
                    </p>
                    <p>Morbi mollis tellus ac sapien. Morbi
                        mattis ullamcorper velit. Nulla porta
                        dolor. Praesent venenatis metus at
                        tortor pulvinar varius.
                    </p>
                </div>
                <div>
                    <img src={ timer } alt="timer" width={150}/>
                    <p>Morbi mollis tellus ac sapien. Morbi
                        mattis ullamcorper velit. Nulla porta
                        dolor. Praesent venenatis metus at
                        tortor pulvinar varius.
                    </p>
                </div>
                <div className={"blockTwo"}>
                    <p>Morbi mollis tellus ac
                        sapien. Morbi mattis
                        ullamcorper velit. Nulla
                        porta dolor. Praesent
                        venenatis metus
                        at tortor pulvinar varius.
                        porta dolor. Praesent
                        venenatis metus
                        at tortor pulvinar varius.
                    </p>
                    <img src={ warrior } alt="warrior" width={150}/>
                </div>
                <Link to='/posts'>
                    <button className={"btn btn-white"}>
                        Tenter l'aventure
                        <i className="far fa-caret-square-right"></i>
                    </button>
                </Link>
                <div>
                    <img src={ entre_nous } alt="entre_nous" width={350}/>
                    <div className={"blockOne"}>
                        <p>Morbi mollis tellus ac sapien. Morbi
                            mattis ullamcorper velit. Nulla porta
                            dolor. Praesent venenatis metus at
                            tortor pulvinar varius.
                        </p>
                    </div>
                </div>
                <Link to='/posts'>
                    <button className={"btn btn-white"}>
                        Découvrez l'univers
                        <i className="far fa-caret-square-right"></i>
                    </button>
                </Link>
                <div className={"blockTwo"}>
                    <img src={ warrior_man } alt="warrior_man" width={150}/>
                    <p>Morbi mollis tellus ac sapien. Morbi
                        mattis ullamcorper velit. Nulla porta
                        dolor. Praesent venenatis metus at
                        tortor pulvinar varius.
                    </p>
                </div>
                <Link to='/mon-compte'>
                    <button className={"btn btn-white"}>
                        Créer mon compte
                        <i className="far fa-caret-square-right"></i>
                    </button>
                </Link>
            </div>
        )
    }
}

export default Home;
