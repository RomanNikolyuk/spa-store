import React, {Component} from 'react';
import WithRequestManager from "../withRequestManager";
import {connect} from 'react-redux';
import {catalogMenuLoaded, catalogMenuRequested, productAddedToCart, wishlistAdded, catalogUpdateItems, catalogSetOrderBy} from "../../actions/actions";
import Loader from "../loader";
import RenderProductCard from "../renderProductCard";
import Cart from "../cart";
import Wishlist from "../wishlist";
import order from "../order/order";

class CatalogRenderProducts extends Component {
    constructor(props) {
        super(props);

        this.scrollEvent = this.scrollEvent.bind(this);

        this.onAddToCart = this.onAddToCart.bind(this);
        this.onAddToWishlist = this.onAddToWishlist.bind(this);
        this.orderBy = this.orderBy.bind(this);
        this.getAllProducts = this.getAllProducts.bind(this);
    }

    getAllProducts() {
        let {catalogPage, selectedCategory, from, to, catalogOrderBy} = this.props;

        if (!selectedCategory) {
            selectedCategory = ''
        }

        if (!from || !to) {
            from = 0;
            to = 999999;
        }


        return this.props.Request.getAllProducts(catalogPage, selectedCategory, catalogOrderBy);
    }

    async scrollEvent() {
        const body = document.body,
            html = document.documentElement;

        const clientHeight = Math.max(body.scrollHeight, body.offsetHeight,
            html.clientHeight, html.scrollHeight, html.offsetHeight);

        let scrollPercent = Math.floor(100 * window.pageYOffset / clientHeight);


        if (scrollPercent > 65 && !this.props.loading) {
            this.props.catalogMenuRequested();

            const json = await this.getAllProducts();

            if (json.length > 0) {
                this.props.catalogMenuLoaded(json);
            }
        }
    }

    // Після кожного ререндерингу
    componentDidUpdate(prevProps, prevState, snapshot) {

        if (prevProps.selectedCategory !== this.props.selectedCategory && this.props.loading) {
            this.props.catalogMenuRequested();

            this.getAllProducts().then(json => {

                this.props.catalogMenuLoaded(json);

            });
        }

        window.addEventListener('scroll', this.scrollEvent);
    }


    componentWillUnmount() {
        window.removeEventListener('scroll', this.scrollEvent);
    }

    componentDidMount() {
        if (this.props.items.length === 0) {
            this.props.catalogMenuRequested();

            this.getAllProducts().then(json => {

                this.props.catalogMenuLoaded(json);

            });
        } else {
            this.props.productAddedToCart();
        }

        window.addEventListener('scroll', this.scrollEvent);

    }


    onAddToCart(id, event) {
        event.preventDefault();

        Cart.onClickOnCart(id);

        this.props.productAddedToCart();
    }

    onAddToWishlist(id, event) {
        event.preventDefault();
        event.stopPropagation();

        Wishlist.onClick(id);

        this.props.wishlistAdded();
    }

    orderBy({target}) {
        const {selectedCategory} = this.props;

        const orderBy = target.value;

        this.props.catalogSetOrderBy(orderBy);

        this.props.Request.getAllProducts(1, selectedCategory, orderBy).then(json => {
            this.props.catalogUpdateItems(json);
        });
    }

    render() {
        const {loading, items} = this.props;

        if (items.length === 0) {
            return <Loader/>;
        }


        return (
            <div className="col-lg-9">
                <div className="shop__product__option">
                    <div className="row">
                        <div className="col-lg-6 col-md-6 col-sm-6">
                            <div className="shop__product__option__left">
                                <p>Показуємо Вам стільки варіантів: {items.length}</p>
                            </div>
                        </div>
                        <div className="col-lg-6 col-md-6 col-sm-6">
                            <div className="shop__product__option__right">
                                <p>Сортування:</p>
                                <select onChange={this.orderBy}>
                                    <option value="">Рекомендовані</option>
                                    <option value="asc">Від дешевих до дорогих</option>
                                    <option value="desc">Від дорогих до дешевих</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="row">

                    {
                        items.map((product) => {
                            return (
                                <div className="col-lg-4 col-md-6 col-sm-6" key={product.id}>
                                    <RenderProductCard item={product} onAddToCart={this.onAddToCart}
                                                       isInCart={Cart.isInCart(product.id)}
                                                       onAddToWishlist={this.onAddToWishlist}
                                                       isInWishlist={Wishlist.isIn(product.id)}/>
                                </div>
                            );
                        })
                    }

                </div>

                <p>Це все. Проте Ви можете переглянути іншу категорію 😉. Кількість відображених товарів: {items.length}</p>
            </div>
        );
    }
}

const mapStateToProps = (state) => {
    return {
        loading: state.loading,
        items: state.items,
        catalogPage: state.catalogPage,
        selectedCategory: state.selectedCategory,
        to: state.price.to,
        from: state.price.from,
        rerender: state.rerender,
        catalogOrderBy: state.catalogOrderBy
    };
};

export default WithRequestManager()(connect(mapStateToProps, {
    catalogMenuRequested,
    catalogMenuLoaded,
    productAddedToCart,
    wishlistAdded,
    catalogUpdateItems,
    catalogSetOrderBy
})(CatalogRenderProducts));