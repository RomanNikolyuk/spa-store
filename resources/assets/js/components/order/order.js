import React, {Component} from 'react';

import {connect} from 'react-redux';

import {orderProductsLoaded, orderProductsRequested, orderSended} from "../../actions/actions";
import WithRequestManager from "../withRequestManager";
import {Helmet} from "react-helmet";

import checkMark from './checkMark.png';

class Order extends Component {
    constructor(props) {
        super(props);

        this.sendOrder = this.sendOrder.bind(this);
    }

    async componentDidMount() {
        this.props.orderProductsRequested();

        const cart = JSON.parse(localStorage.getItem('cart'));

        const productArr = [];


        for (let idd of cart) {
            let product = {};
            const cachedProduct = this.props.cachedProducts.find(({id}) => id === idd);

            if (cachedProduct) {
                product = cachedProduct;
            } else {
                product = await this.props.Request.getProduct(idd);
            }

            productArr.push(product);
        }


        this.props.orderProductsLoaded(productArr);

    }

    renderOrderCart() {
        const {items, loading} = this.props;

        let sum = 0;

        if (!loading && items.length > 0) {
            return (
                <div className="col-lg-4 col-md-6">
                    <div className="checkout__order">
                        <h4 className="order__title">Ваше замовлення</h4>
                        <div className="checkout__order__products">Продукт <span>Сума</span></div>
                        <ul className="checkout__total__products">

                            {
                                items.map(item => {
                                    sum += item.price;
                                    return (
                                        <li key={item.id}>{item.title} <span>₴ {item.price}</span></li>
                                    );
                                })
                            }
                        </ul>

                        <ul className="checkout__total__all">
                            <li>Всього <span>₴ {sum}</span></li>
                        </ul>


                        <button type="submit" className="site-btn">ЗРОБИТИ ЗАМОВЛЕННЯ</button>
                    </div>
                </div>
            );
        }


    }

    // Згенерувати url для requestManager, скасувати стандартну поведінку
    sendOrder(event) {
        event.preventDefault();

        const formData = new FormData(document.querySelector('form'));

        let url = '?';

        for (let [name, value] of formData.entries()) {
            url += name + '=' + value + '&';
        }

        const products = localStorage.getItem('cart');

        url += 'products=' + products;

        this.props.Request.sendOrder(url);

        this.props.orderSended();
    }

    render() {
        if (!this.props.orderSendedd) {
            return (
                <>
                    <Helmet>
                        <title>Зробити замовлення | Магазин церковних товарів в Україні Дзвін</title>

                        <meta name='description' content='Зробити замовлення у Інтернет-магазині Дзвін' />
                        <meta name='keywords' content='зробити замовлення Магазин церковних товарів в Україні Дзвін'/>
                        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

                    </Helmet>

                    <section className="checkout spad">
                        <div className="container">
                            <div className="checkout__form">
                                <form action="#" onSubmit={this.sendOrder}>
                                    <div className="row">
                                        <div className="col-lg-8 col-md-6">
                                            <h6 className="checkout__title">Оформлення замовлення</h6>
                                            <div className="row">
                                                <div className="col-lg-6">
                                                    <div className="checkout__input">
                                                        <p>Ім'я<span>*</span></p>
                                                        <input type="text" name='first_name' required minLength='3'/>
                                                    </div>
                                                </div>
                                                <div className="col-lg-6">
                                                    <div className="checkout__input">
                                                        <p>Прізвище<span>*</span></p>
                                                        <input type="text" name='last_name' required minLength='3'/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div className="checkout__input">
                                                <p>Адреса доставки<span>*</span></p>
                                                <input type="text" placeholder="м. Київ, відділення Нової Пошти №1"
                                                       name="delivery_address" required minLength='5'/>
                                            </div>
                                            <div className="row">
                                                <div className="col-lg-6">
                                                    <div className="checkout__input">
                                                        <p>Телефон<span>*</span></p>
                                                        <input type="tel" name='telephone' required/>
                                                    </div>
                                                </div>
                                                <div className="col-lg-6">
                                                    <div className="checkout__input">
                                                        <p>Емейл<span>*</span></p>
                                                        <input type="email" name='email'/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {
                                            this.renderOrderCart()
                                        }

                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </>
            );
        } else {
            return (
                <div style={{margin: '8% 0'}}>
                    <img src={checkMark} style={{width: '30%', display: 'block', margin: '0 auto 15px'}} alt='Замовлення виконано'/>
                    <p style={{margin: '0 auto 25px', width: '40%', color: 'grey', 'font-size': '25px'}}>Дякуємо! Замовлення буде оброблено</p>
                </div>
            );
        }

    }
}

const mapStateToProps = (state) => {
    return {
        loading: state.loading,
        items: state.items,
        orderSendedd: state.orderSended,
        cachedProducts: state.cachedProducts
    };
};

export default WithRequestManager()(connect(mapStateToProps, {
    orderProductsRequested,
    orderProductsLoaded,
    orderSended
})(Order));