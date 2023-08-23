import React from 'react';

const RenderSliders = ({sliders}) => {
    const slideStyle = {
        width: '1578.75px'
    };

    return sliders.map((slider) => {

        const {id, small_text_1, big_text, small_text_2, url, button_text, image} = slider;

        return (
            <div className='owl-item' style={slideStyle} key={id}>
                <div className="hero__items set-bg" data-setbg={image}
                     style={{backgroundImage: `url(${image})`}}>
                    <div className="container">
                        <div className="row">
                            <div className="col-xl-5 col-lg-7 col-md-8">
                                <div className="hero__text">
                                    <h6>{small_text_1}</h6>
                                    <h2>{big_text}</h2>
                                    <p>{small_text_2}</p>
                                    <a href={url}
                                       className="primary-btn">{button_text} <span
                                        className="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    });
};

export default RenderSliders;
