import React, {Component} from 'react';
import RenderProductCard from "../renderProductCard";
import Cart from "../cart";

import {connect} from 'react-redux';

import {productAddedToCart, wishlistAdded, mainPageProductsRequested, mainPageProductsLoaded} from "../../actions/actions";
import Wishlist from "../wishlist";

import WithRequestManager from "../withRequestManager";

import mixitup from 'mixitup';

class MainPageProducts extends Component {

    componentDidUpdate(prevProps, prevState, snapshot) {
        mixitup('.product > .container');
    }

    componentDidMount() {
        if (this.props.mainPageProducts.length === 0) {
            this.props.mainPageProductsRequested();

            this.props.Request.getMainPageProducts().then(json => {
                this.props.mainPageProductsLoaded(json);

                mixitup('.product > .container');
            });
        }
    }

    render() {
        const {productAddedToCart, wishlistAdded, mainPageProducts} = this.props;

        const onAddToCart = (id, event) => {
            event.preventDefault();

            Cart.onClickOnCart(id);

            productAddedToCart();
        };


        const onAddToWishlist = (id, event) => {
            event.preventDefault(); event.stopPropagation();

            Wishlist.onClick(id);

            wishlistAdded();
        };



        return (
            <section className="product spad">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-12">
                            <ul className="filter__controls">
                                <li data-filter=".recommended">Рекомендовані</li>
                                <li data-filter=".new" className="">Нові</li>
                            </ul>
                        </div>
                    </div>

                    <div className="row product__filter" id="MixItUp4D838E">

                        {
                            mainPageProducts.map(item => {
                                let clazz = 'col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix ' + item.type;

                                return (
                                    <div className={clazz}>

                                        <RenderProductCard item={item} onAddToCart={onAddToCart} onAddToWishlist={onAddToWishlist} isInCart={Cart.isInCart(item.id)} isInWishlist={Wishlist.isIn(item.id)}/>

                                    </div>
                                );
                            })

                        }

                    </div>
                </div>
            </section>
        );
    }
}

const mapStateToProps = (state) => {
    return {
        rerender: state.rerender,
        mainPageProducts: state.mainPageProducts,
    };
};

export default WithRequestManager()(connect(mapStateToProps, {productAddedToCart, wishlistAdded, mainPageProductsRequested, mainPageProductsLoaded})(MainPageProducts));