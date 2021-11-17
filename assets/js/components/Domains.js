import React, {useEffect, useState} from 'react';
import axios from "axios";
import Slider from "react-slick";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import ReactDOM, {render} from "react-dom";

// slider component
export default function Domains() {

    const [reponses, setReponses] = useState([]);

    const params = {
        slidesToShow: 3,
        className: "end",
        centerMode: true,
        infinite: true,
        speed: 500,
        centerPadding: "0",
        responsive: [
            {
                breakpoint: 1440,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    initialSlide: 3,
                    vertical: true,
                    verticalSwiping: true,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    vertical: true,
                    verticalSwiping: true
                }
            }
        ]
    };

    useEffect(() => {
        axios.get('/api/domains')
            .then((response) => {
                setReponses(response.data['hydra:member']);
            });
    }, []);

    return (
        <>
            <h1 className="bandeau desktop">Choissisez votre domaine</h1>
            <div className="container">
                <div className="row">
                    <div className="col-12">
                        <Slider {...params}>
                            {reponses.map((domain, index) => (
                                <div className="slider" key={index}>
                                    <a href={domain.id}>
                                        <div id="slider-img">
                                            <img src={domain.image} alt={domain.title} width="300" height="235"/>
                                        </div>
                                        <div className="text-center content bandeau-title-slider">
                                            <h2 className="text-white">{domain.title}</h2>
                                        </div>
                                    </a>
                                </div>
                            ))}
                        </Slider>
                    </div>
                </div>
            </div>
        </>
    );
};

render(<Domains />, document.getElementById("domains"));