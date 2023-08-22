import React, {Component} from 'react';
import {Link} from "react-router-dom";
import Loader from "../loader";

import {clearItems, wishlistEmpty, wishlistLoaded, wishlistRequested} from "../../actions/actions";

import {connect} from 'react-redux';

import WithRequestManager from "../withRequestManager";
import Wishlist from "../wishlist";
import Cart from "../cart";

import {Helmet} from "react-helmet";
import ViewProductDetails from "../viewProductDetails/viewProductDetails";

class WishlistRenderer extends Component {
    constructor(props) {
        super(props);

        this.removeFromWishlist = this.removeFromWishlist.bind(this);
    }

    async componentDidMount() {
        this.props.wishlistRequested();

        const wishlistProductIds = JSON.parse(localStorage.getItem('wishlist'));

        const productsArr = [];

        if (wishlistProductIds) {

            for (const idd of wishlistProductIds) {
                let product = {};
                const cachedProduct = this.props.cachedProducts.find(({id}) => id === idd);

                if (cachedProduct) {
                    product = cachedProduct;
                } else {
                    product = await this.props.Request.getProduct(idd);
                }

                productsArr.push(product);
            }

            this.props.wishlistLoaded(productsArr)


        } else {
            this.props.wishlistEmpty();
        }


    }

    removeFromWishlist(id) {
        Wishlist.onClick(id);

        const {wishlistProducts} = this.props;

        const newItems = wishlistProducts.filter(item => item.id !== id);

        this.props.wishlistLoaded(newItems);
    }

    renderProducts() {
        const {wishlistProducts} = this.props;

        if (wishlistProducts.length > 0) {
            return (
                wishlistProducts.map(product => {
                    const {img, title, price, id} = product;
                    if (!product.id) {
                        return;
                    }
                    return (
                        <tr key={id}>
                            <td className="product__cart__item">
                                <div className="product__cart__item__pic">
                                    <img src={img} alt=""/>
                                </div>
                                <div className="product__cart__item__text">
                                    <h6><Link to={`/item/${id}`}>{title}</Link></h6>
                                    <h5>₴ {price}</h5>
                                </div>
                            </td>
                            <td className="cart__price">₴ {price}</td>
                            <td className="cart__close">
                                <i className="fa fa-close"
                                   style={{cursor: 'pointer'}}
                                   onClick={() => this.removeFromWishlist(id)}/>

                                {
                                    () => {
                                        if (!Cart.isInCart(id)) {
                                            return (
                                                <i className='fa fa-shopping-cart'
                                                   onClick={() => Cart.onClickOnCart(id)}
                                                   style={{cursor: 'pointer'}}/>
                                            );
                                        }
                                    }
                                }

                            </td>
                        </tr>
                    );
                })
            );
        } else {
            return (
                <h3 className='product__cart__item'>Хмм... здається список бажань пустий. Але це ніколи не пізно
                    виправити 😉</h3>
            );
        }
    }

    render() {
        const {loading} = this.props;

        if (loading) {
            return <Loader/>;
        }

        return (
            <>

                <Helmet>
                    <title>Список бажань | Магазин церковних товарів в Україні Дзвін</title>

                    <meta name='description' content='Список бажань ♥ у Інтернет-магазині Дзвін'/>
                    <meta name='keywords' content='список бажань магазин дзвін'/>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>


                </Helmet>

                <section className="shopping-cart spad">
                    <div className="container">
                        <div className="row">
                            <div className="col-lg-8">
                                <div className="shopping__cart__table">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th>Продукт</th>
                                            <th>Ціна</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        {
                                            this.renderProducts()
                                        }


                                        </tbody>
                                    </table>
                                </div>
                                <div className="row">
                                    <div className="col-lg-6 col-md-6 col-sm-6">
                                        <div className="continue__btn">
                                            <Link to='/catalog' onClick={this.props.clearItems}>Продовжити
                                                перегляд</Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </>
        );
    }
}


const mapStateToProps = (state) => {
    return {
        loading: state.loading,
        wishlistProducts: state.wishlistProducts,
        rerender: state.rerender,
        cachedProducts: state.cachedProducts
    };
};

export default WithRequestManager()(connect(mapStateToProps, {
    wishlistRequested,
    wishlistLoaded,
    wishlistEmpty,
    clearItems
})(WishlistRenderer));