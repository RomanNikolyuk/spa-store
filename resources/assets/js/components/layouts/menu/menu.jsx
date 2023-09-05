import CartImg from '@images/cart.webp';
import HeartImg from '@images/heart.webp';
import LogoImg from '@images/logo.png';
import { Component } from 'react';
import { connect } from 'react-redux';
import { Link } from 'react-router-dom';

import { clearItems, menuCategoriesLoaded, menuSelected, setTotalValue } from '../../../actions/actions';
import WithRequestManager from '../../withRequestManager';

class Menu extends Component {
    constructor(props) {
        super(props);

        this.menuSelected = this.menuSelected.bind(this);
    }

    async componentDidUpdate(prevProps, prevState, snapshot) {
        const cart = JSON.parse(localStorage.getItem('cart'));

        let sum = 0;

        for (const idd of cart) {
            let product = {};
            const cachedProduct = this.props.cachedProducts.find(({ id }) => id === idd);

            if (cachedProduct) {
                product = cachedProduct;
            } else {
                product = await this.props.Request.getProduct(idd);
            }
            if (product.id) {
                sum += product.price;
            }
        }

        this.props.setTotalValue(sum);
    }

    async componentDidMount() {
        const cart = JSON.parse(localStorage.getItem('cart'));

        let sum = 0;

        if (cart) {

            for (const idd of cart) {
                let product = {};
                const cachedProduct = this.props.cachedProducts.find(({ id }) => id === idd);

                if (cachedProduct) {
                    product = cachedProduct;
                } else {
                    product = await this.props.Request.getProduct(idd);
                }

                if (product.id) {
                    sum += product.price;
                }

            }

            this.props.setTotalValue(sum);
        }

        this.menuMobile();
    }

    menuSelected({ target }) {

        const allowedNodeNames = [ 'A', 'IMG', 'SPAN' ];

        if (allowedNodeNames.includes(target.nodeName)) {
            this.props.menuSelected();
        }

    }

    menuMobile() {
        const openButton = document.querySelector('.canvas__open'),
            menuWrapper = document.querySelector('.offcanvas-menu-wrapper'),
            menuOverlay = document.querySelector('.offcanvas-menu-overlay'),
            menuLinks = document.querySelector('.offcanvas__links');

        openButton.addEventListener('click', event => {
            menuWrapper.classList.add('active');
            menuOverlay.classList.add('active');
        });

        menuOverlay.addEventListener('click', event => {
            menuWrapper.classList.remove('active');
            menuOverlay.classList.remove('active');
        });

        menuLinks.addEventListener('click', event => {
            menuWrapper.classList.remove('active');
            menuOverlay.classList.remove('active');
        });
    }

    render() {
        const { total, cachedProducts } = this.props;
        let cart = JSON.parse(localStorage.getItem('cart'));

        if (!cart) {
            localStorage.setItem('cart', '[]');
            cart = [];
        }

        const cartCount = cart ? cart.length : 0;

        const RenderCartButtons = () => {

            return (
                <>
                    <Link to="/cart">
                        <img
                            src={ CartImg }
                            alt="Корзина"
                        />
                        <span>{ cartCount }</span>
                    </Link>

                    <div className="price">₴{ total }</div>

                </>
            );

        };

        const currentRoute = window.location.pathname.split('/')[ 1 ];

        return (
            <>
                { /* Потрібно для нормальної роботи */ }
                <div className="offcanvas-menu-overlay" />

                <div className="offcanvas-menu-wrapper">

                    <div className="offcanvas__option">
                        <div className="offcanvas__links">
                            <Link to="/">Домашня</Link>
                            <Link to="/catalog">Каталог</Link>
                            { /*<Link to="/about_us">Про нас </Link>*/ }
                        </div>

                    </div>

                    <div className="offcanvas__nav__option">
                        <Link to="/wishlist">
                            <img
                                src={ HeartImg }
                                alt="Список бажань"
                            />
                        </Link>

                        <Link to="/cart"><img
                            src={ CartImg }
                            alt="Кошик"
                        /> <span>{ cartCount }</span></Link>

                        <div className="price">₴{ total }</div>
                    </div>

                    <div id="mobile-menu-wrap" />

                </div>

                <header
                    className="header"
                    onClick={ this.menuSelected }
                >
                    <div className="container">
                        <div className="row">
                            <div className="col-lg-3 col-md-3">

                                <div className="header__logo">
                                    <a href="/"><img
                                        src={ LogoImg }
                                        alt="На головну"
                                        height="50px"
                                    />
                                    </a>
                                </div>
                            </div>
                            <div className="col-lg-6 col-md-6">
                                <nav className="header__menu mobile-menu">
                                    <ul>
                                        <li className={ currentRoute === '' ? 'active' : '' }>
                                            <Link to="/">Домашня</Link>
                                        </li>
                                        <li className={ currentRoute === 'catalog' ? 'active' : '' }>
                                            <Link to="/catalog">Каталог</Link>
                                        </li>
                                        { /*<li><a href="#">Про нас</a></li>*/ }
                                    </ul>
                                </nav>
                            </div>
                            <div className="col-lg-3 col-md-3">
                                <div className="header__nav__option">

                                    { /*<a href="#" className="search-switch"><img src={SearchImg} alt="Пошук"/></a>*/ }

                                    <Link to="/wishlist"><img
                                        src={ HeartImg }
                                        alt="Список бажань"
                                    />
                                    </Link>

                                    <RenderCartButtons />

                                </div>
                            </div>
                        </div>
                        <div className="canvas__open"><i className="fa fa-bars" /></div>
                    </div>
                </header>

            </>
        );
    }
}

const mapStateToProps = state => {
    return {
        total: state.total,
        rerender: state.rerender,
        loading: state.loading,
        item: state.item,
        sliders: state.sliders,
        menuCategories: state.menuCategories,
        cachedProducts: state.cachedProducts
    };
};

export default WithRequestManager()(connect(mapStateToProps, {
    menuSelected,
    setTotalValue,
    menuCategoriesLoaded,
    clearItems
})(Menu));
