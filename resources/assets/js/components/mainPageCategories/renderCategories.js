import React from 'react';
import {Link} from "react-router-dom";

import {connect} from 'react-redux';

import {clearItems} from "../../actions/actions";

const RenderCategories = ({categories, clearItems}) => {
    return (
        <div className="container">
            <div className="row">

                {
                    categories.map(category => {
                        const {title, url, id, img} = category;

                        const styled = {
                            backgroundImage: `url(${img})`
                        };

                        return (
                            <div className="col category-block" style={styled} key={id}>
                                <a href={url}>{title}</a>
                            </div>
                        );
                    })
                }


            </div>
        </div>
    );
};

const mapStateToProps = (state) => {
    return {

    };
};

export default connect(mapStateToProps, {clearItems})(RenderCategories);