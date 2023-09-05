import RemoveFromWishlistImage from '@images/heart-filled.webp';
import AddToWishlistImage from '@images/heart.webp';
import { connect } from 'react-redux';
import { useNavigate } from 'react-router-dom';

import { productDetailsLoading } from '../../actions/actions';

const Product = ({ item, productDetailsLoading, onAddToCart, isInCart, onAddToWishlist, isInWishlist }) => {
    const { id, title, price, image } = item;

    const itemBgStyle = {
        backgroundImage: `url(${ image })`
    };

    const navigate = useNavigate();

    const viewItem = () => {
        productDetailsLoading();

        window.scrollTo(0, 0);
        return navigate('/item/' + id);
    };

    return (
        <div
            className="product__item"
            key={ id }
        >
            <div
                className="product__item__pic set-bg" data-setbg={ image }
                style={ itemBgStyle } onClick={ viewItem }
            >
                <ul className="product__hover">
                    <li>
                        <a href="#">
                            <img
                                src={ isInWishlist ? RemoveFromWishlistImage : AddToWishlistImage }
                                alt="В список бажань"
                                onClick={ event => onAddToWishlist(id, event) }
                            /></a>
                    </li>
                </ul>
            </div>
            <div className="product__item__text">
                <h6>{ title }</h6>
                <a
                    href="#"
                    className="add-cart"
                    onClick={ event => onAddToCart(id, event) }
                >{
                        isInCart ? '- З корзини' : '+ В корзину'
                    }</a>
                { /*<div className="rating">
                    <i className="fa fa-star" />
                    <i className="fa fa-star" />
                    <i className="fa fa-star" />
                    <i className="fa fa-star" />
                    <i className="fa fa-star-o" />
                </div>*/ }
                <h5>₴{ price }</h5>
            </div>
        </div>
    );

};

const mapStateToProps = state => {
    return {

    };
};

export default connect(mapStateToProps, { productDetailsLoading })(Product);
