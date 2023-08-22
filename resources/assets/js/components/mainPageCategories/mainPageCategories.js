import React, {Component} from 'react';
import RenderCategories from "./renderCategories";

import WithRequestManager from "../withRequestManager";
import {connect} from 'react-redux';

import {mainPageCategoriesLoaded, mainPageCategoriesRequested} from "../../actions/actions";
import Loader from "../loader";

class MainPageCategories extends Component {

    componentDidMount() {
        if (this.props.mainPageCategories.length === 0) {
            this.props.mainPageCategoriesRequested();

            this.props.Request.getMainPageCategories().then(json => {
                this.props.mainPageCategoriesLoaded(json);
            });
        }
    }

    render() {
        const {loading, mainPageCategories} = this.props;

        if (loading) {
            return <Loader/>;
        }

        return (
            <section className="categories spad">

                <RenderCategories categories={mainPageCategories}/>

            </section>
        );
    }


}

const mapStateToProps = (state) => {
    return {
        loading: state.state,
        mainPageCategories: state.mainPageCategories
    };
};

export default WithRequestManager()(connect(mapStateToProps, {mainPageCategoriesLoaded, mainPageCategoriesRequested})(MainPageCategories));