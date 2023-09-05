import LogoImg from '@images/logo-white.png';
import { Link } from 'react-router-dom';

const Footer = () => {

    return (

        <footer className="footer">
            <div className="container">
                <div className="row">
                    <div className="col-md-6 col-sm-6">
                        <div className="footer__about">
                            <div className="footer__logo">
                                <a href="#"><img
                                    src={ LogoImg } alt="Логотип"
                                    height="50px"
                                /></a>
                            </div>
                            <p>Магазин церковних товарів у місті Луцьк</p>

                        </div>
                    </div>
                    <div className="col-lg-2 offset-lg-1 col-md-3 col-sm-6">
                        <div className="footer__widget">
                            <h6>Магазин</h6>
                            <ul>
                                <li><Link to="/cart">Корзина</Link></li>
                                <li><Link to="/wishlist">Список бажань</Link></li>
                            </ul>
                        </div>
                    </div>
                    <div className="col-lg-2 col-md-3 col-sm-6">
                        <div className="footer__widget">
                            <h6>Деталі</h6>
                            <ul>
                                <li><a href="#">Контакти</a></li>
                                <li><a href="#">Про нас</a></li>
                            </ul>
                        </div>
                    </div>
                    <div />
                </div>
                <div className="row">
                    <div className="col-lg-12 text-center">
                        <div className="footer__copyright__text">
                            <p>Copyright © { new Date().getFullYear() } |
                                Всі права захищено | Site created by <a
                                href="https://t.me/vl_st1"
                                target="_blank" rel="noreferrer"
                                >Roman</a>
                            </p>
                        </div>
                    </div>
                    <div />
                </div>

            </div>
        </footer>
    );
};

export default Footer;
