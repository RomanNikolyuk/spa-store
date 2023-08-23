import React, {Component} from 'react';
import Product from "../renderProductCard";
import Loader from "../loader";

import {connect} from 'react-redux';

import {productDetailsLoaded, productDetailsLoading, productAddedToCart} from "../../actions/actions";

import WithRequestManager from "../withRequestManager";
import Cart from "../cart";
import Wishlist from "../wishlist";

import {Helmet} from "react-helmet";

class ViewProductDetails extends Component {
    constructor(props) {
        super(props);

        this.onCartClick = this.onCartClick.bind(this);
        this.onWishlistClick = this.onWishlistClick.bind(this);
    }

    componentDidUpdate(prevProps, prevState) {

        if (prevProps.productId !== this.props.productId) {
            this.props.productDetailsLoading();

            this.props.Request.getProduct(this.props.productId).then(product => {
                this.props.productDetailsLoaded(product);
            });

        }

    }

    componentDidMount() {
        this.props.productDetailsLoading();

        this.props.Request.getProduct(this.props.productId).then(product => {
            this.props.productDetailsLoaded(product);
        });
    }

    onImgSelect({target}) {

        if (target.nodeName === 'DIV') {
            const selectedTab = target.parentNode.dataset.tab;

            document.querySelectorAll('.tab-pane').forEach(tab => {
                tab.classList.remove('active');
            });


            const targetImg = document.querySelector(`.tab-pane[id='${selectedTab}']`);

            targetImg.classList.add('active');

        }

    }

    onTabSelect({target}) {

        if (target.nodeName === 'A') {
            document.querySelectorAll('.js-tab').forEach(a => {
                a.classList.remove('active');
            });

            target.classList.add('active');

            document.querySelectorAll('.js-tab-content').forEach(tab => tab.classList.remove('active'));

            document.querySelector(`.js-tab-content[id='${target.dataset.tab}']`).classList.add('active');
        }
    }


    onCartClick(event) {
        event.preventDefault();

        const {id} = this.props.item;

        Cart.onClickOnCart(id);

        this.props.productAddedToCart();

    }

    onWishlistClick(event) {
        event.preventDefault();

        const {id} = this.props.item;

        Wishlist.onClick(id);

        this.props.productAddedToCart();
    }


    render() {
        const {item, loading} = this.props;

        if (loading) {
            return <Loader/>;
        }


        let tabIndex = 0;

        return (
            <>
                <Helmet>
                    <title>{item.title} | Магазин церковних товарів в Україні Дзвін</title>
                    <meta name='description' content={`Перегляньте <strong>${item.title}</strong> та придбайте із гарантією і доставкою по всій Україні у магазині Дзвін. `}/>
                    <meta name='keywords' content={`${item.title}, Магазин церковних товарів в Україні Дзвін, Луцьк ${item.title}, ${item.small_desc}`}/>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                </Helmet>

                <section className="shop-details">
                    <div className="product__details__pic">
                        <div className="container">
                            <div className="row">
                                <div className="col-lg-12">
                                    <div className="product__details__breadcrumb">
                                        <a href="/">Домашня</a>
                                        <a href="/catalog">Каталог</a>
                                        <span>{item.title}</span>
                                    </div>
                                </div>
                            </div>
                            <div className="row">
                                <div className="col-lg-3 col-md-3">
                                    <ul className="nav nav-tabs" role="tablist">
                                        {
                                            item.images.map(thumb => {
                                                tabIndex++;

                                                return (
                                                    <li className='nav-item' key={tabIndex}>
                                                        <a className='nav-link' data-toggle="tab"
                                                           data-tab={tabIndex}
                                                           role="tab" onClick={this.onImgSelect}>
                                                            <div className="product__thumb__pic set-bg"
                                                                 data-setbg={thumb} style={{backgroundImage: `url(${thumb})`}}>
                                                            </div>
                                                        </a>
                                                    </li>
                                                );
                                            })
                                        }
                                    </ul>
                                </div>

                                <div className="col-lg-6 col-md-9">
                                    <div className="tab-content">
                                        {
                                            (() => {
                                                tabIndex = 0
                                            })()
                                        }

                                        {
                                            item.images.map(img => {
                                                tabIndex++;

                                                let clazz = "tab-pane ";

                                                if (tabIndex === 1) {
                                                    clazz += 'active';
                                                }

                                                return (
                                                    <div className={clazz} id={`${tabIndex}`}
                                                         role="tabpanel">
                                                        <div className="product__details__pic__item">
                                                            <img src={img} alt=""/>
                                                        </div>
                                                    </div>
                                                );
                                            })
                                        }
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="product__details__content">
                        <div className="container">
                            <div className="row d-flex justify-content-center">
                                <div className="col-lg-8">
                                    <div className="product__details__text">
                                        <h4>{item.title}</h4>
                                        <div className="rating">
                                            <i className="fa fa-star"></i>
                                            <i className="fa fa-star"></i>
                                            <i className="fa fa-star"></i>
                                            <i className="fa fa-star"></i>
                                            <i className="fa fa-star"></i>
                                            <span> - {item.reviews.length} відгуків</span>
                                        </div>
                                        <h3>₴{item.price}</h3>
                                        <p dangerouslySetInnerHTML={{__html: item.small_desc}}/>

                                        <div className="product__details__cart__option">
                                            <a href="#" className="primary-btn" onClick={this.onCartClick}>{Cart.isInCart(item.id) ? 'З корзини' : 'У корзину 🛒'}</a>
                                        </div>
                                        <div className="product__details__btns__option">
                                            <a href="#" onClick={this.onWishlistClick}>{!Wishlist.isIn(item.id) && <i className="fa fa-heart"></i>} {Wishlist.isIn(item.id) ? 'Зі списку бажань 💔' : 'У список бажань ❤'}</a>
                                        </div>
                                        <div className="product__details__last__option">
                                            <ul>
                                                <li><span>Категорії:</span> {item.categories}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div className="row">
                                <div className="col-lg-12">
                                    <div className="product__details__tab">
                                        <ul className="nav nav-tabs" role="tablist">
                                            <li className="nav-item" onClick={this.onTabSelect}>
                                                <a className="nav-link active js-tab" data-tab="description" data-toggle="tab"
                                                   role="tab">Опис</a>
                                            </li>
                                            <li className="nav-item"  onClick={this.onTabSelect}>
                                                <a className="nav-link js-tab" data-toggle="tab" data-tab="reviews" role="tab">Відгуки
                                                    користувачів ({item.reviews.length})</a>
                                            </li>

                                        </ul>
                                        <div className="tab-content">
                                            <div className="tab-pane active js-tab-content" id="description" role="tabpanel">
                                                <div className="product__details__tab__content" dangerouslySetInnerHTML={{__html: item.big_desc}}/>
                                            </div>
                                            <div className="tab-pane js-tab-content" id="reviews" role="tabpanel">
                                                <div className="product__details__tab__content">

                                                    {
                                                        item.reviews.length === 0 && <h5>Здається, відгуків ще немає 😪</h5>
                                                    }

                                                    {
                                                        item.reviews.map(review => {
                                                                return (
                                                                    <div className="product__details__tab__content__item"
                                                                         key={review.id}>
                                                                        <h5>{review.customer_name}</h5>
                                                                        <p>{review.desc}</p>
                                                                    </div>
                                                                );
                                                            }
                                                        )
                                                    }
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section className="related spad">
                    <div className="container">
                        <div className="row">
                            <div className="col-lg-12">
                                <h3 className="related-title">Схожі продукти</h3>
                            </div>
                        </div>
                        <div className="row">
                            {
                                item.related.map(product => {
                                        return (
                                            <div className="col-lg-3 col-md-6 col-sm-6 col-sm-6">
                                                {/* УВАГА! ОСКІЛЬКИ СТАНДАРТНІ ФУНКЦІЇ у цьому класі не підходять - передаємо кастомні, що будуть правильно працювати */}
                                                <Product item={product} onAddToCart={(id, event) => {
                                                    event.preventDefault();

                                                    Cart.onClickOnCart(id);

                                                    this.props.productAddedToCart();
                                                }} isInCart={Cart.isInCart(product.id)} onAddToWishlist={(id, event) => {
                                                    event.preventDefault(); event.stopPropagation();

                                                    Wishlist.onClick(id);

                                                    this.props.productAddedToCart();
                                                }} isInWishlist={Wishlist.isIn(product.id)}/>
                                            </div>
                                        );
                                    }
                                )}
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
        item: state.item,
        rerender: state.rerender
    };
}

export default WithRequestManager()(connect(mapStateToProps, {
    productDetailsLoading,
    productDetailsLoaded,
    productAddedToCart
})(ViewProductDetails))