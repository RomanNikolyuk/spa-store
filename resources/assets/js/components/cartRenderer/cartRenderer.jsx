import React, {Component} from 'react';

import WithRequestManager from "../withRequestManager";

import {cartProductsLoaded, cartProductsRequested, clearItems} from "../../actions/actions";
import {connect} from 'react-redux';
import Loader from "../loader";
import Cart from "../cart";
import {Link} from "react-router-dom";

import {Helmet} from "react-helmet";

class CartRenderer extends Component {
    constructor(props) {
        super(props);

        this.clearItems = this.clearItems.bind(this);
    }


    async getItems() {

        const items = JSON.parse(localStorage.getItem('cart'));

        const productArray = [];
        let sum = 0;

        for (const idd of items) {
            let product = {};

            const cachedProduct = this.props.cachedProducts.find(({id}) => id === idd);

            if (cachedProduct) {
                product = cachedProduct;
            } else {
                product = await this.props.Request.getProduct(idd);
            }

            if (product) {
                sum += product.price;
                productArray.push(product);
            }

        }

        return {
            items: productArray,
            total: sum
        };
    }

    async componentDidMount() {
        this.props.cartProductsRequested();

        const result = await this.getItems();

        this.props.cartProductsLoaded(result);
    }

    removeFromCart(id) {
        this.props.cartProductsRequested();

        Cart.onClickOnCart(id);

        const {items, total} = this.props;

        this.props.Request.getProduct(id).then(json => {

            this.props.cartProductsLoaded({
                items: items.filter(product => product.id !== id),
                total: total - json.price
            });

        });

    }

    clearItems() {
        window.scrollTo(0, 0);

        this.props.clearItems();
    }

    productRenderer() {
        const {items} = this.props;

        if (items.length > 0) {
            return (
                items.map(product => {
                    if (+Object.keys(product).length === 0) {
                        return;
                    }
                    const {img, title, price, id} = product;

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
                            <td className="cart__close"><i className="fa fa-close"
                                                           style={{cursor: 'pointer'}}
                                                           onClick={() => this.removeFromCart(id)}></i>
                            </td>
                        </tr>
                    );
                })
            );
        } else {
            return (
                <h3 className='product__cart__item'>Хмм... здається кошик пустий. Але це ніколи не пізно виправити
                    😉</h3>
            );
        }
    }

    render() {
        const {loading, total, items} = this.props;

        if (loading) {
            return <Loader/>;
        }

        return (
            <>
                <Helmet>
                    <title>Кошик | Магазин церковних товарів в Україні Дзвін</title>

                    <meta name='description'
                          content='Магазин Дзвін із офісом у Луцьку, <strong>доставкою по Україні</strong> та з великим досвідом роботи запрошує Вас'/>
                    <meta name='keywords' content={`корзина дзвін, кошик дзвін`}/>
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
                                            this.productRenderer()
                                        }


                                        </tbody>
                                    </table>
                                </div>
                                <div className="row">
                                    <div className="col-lg-6 col-md-6 col-sm-6">
                                        <div className="continue__btn">
                                            <Link to='/catalog' onClick={this.clearItems}>Продовжити покупки</Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {
                                (() => {
                                    if (items.length > 0) {
                                        return (
                                            <div className="col-lg-4">
                                                <div className="cart__total">
                                                    <h6>Рахунок</h6>
                                                    <ul>
                                                        <li>Сума: <span>₴ {total}</span></li>
                                                    </ul>
                                                    <Link className='primary-btn' to='/order'>Перейти на сторінку
                                                        оплати</Link>

                                                </div>
                                            </div>
                                        );
                                    }
                                })()
                            }

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
        items: state.cartProducts,
        total: state.total,
        cachedProducts: state.cachedProducts
    };
};


export default WithRequestManager()(connect(mapStateToProps, {
    cartProductsRequested,
    cartProductsLoaded,
    clearItems
})(CartRenderer));