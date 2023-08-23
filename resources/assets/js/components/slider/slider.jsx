import React, {Component} from 'react';
import RenderSliders from "./renderSliders";

import WithRequestManager from "../withRequestManager";
import {connect} from 'react-redux';

import Loader from "../loader";

import {slidersRequested, slidersLoaded} from "../../actions/actions";

import OwlCarousel from 'react-owl-carousel';


class Slider extends Component {
    componentDidMount() {
        if (this.props.sliders.length === 0) {

            this.props.slidersRequested();

            this.props.Request.getSliders().then(json => {
                this.props.slidersLoaded(json);
            });
        } else {
            // Для уникнення безкінечної загрузки
            this.props.slidersLoaded(this.props.sliders);
        }
    }

    render() {
        const {loading, sliders} = this.props;

        const sliderStyle = {
            transform: 'translate3d(-4736px, 0px, 0px)',
            transition: 'all 1.2s ease 0s',
            width: '9473px'
        };


        if (loading) {
            return <Loader/>;
        }

        if (this.props.sliders.length === 0) {return null}

        return (
            <section className="hero">
                <OwlCarousel className="hero__slider owl-loaded"
                             loop
                             items={1}
                             touchDrag={false}
                             mouseDrag={false}
                             nav>
                    <div className="owl-stage-outer">
                        <div className="owl-stage"
                             style={sliderStyle}>

                            <RenderSliders sliders={sliders}/>

                        </div>
                    </div>

                    <div className="owl-dots disabled"></div>
                </OwlCarousel>

            </section>
        );
    }
}

const mapStateToProps = (state) => {
    return {
        loading: state.loading,
        sliders: state.sliders,
    };
};

export default WithRequestManager()(connect(mapStateToProps, {slidersRequested, slidersLoaded})(Slider));