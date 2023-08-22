import React from 'react';
import Menu from "../layouts/menu";
import Footer from "../layouts/footer";

import {BrowserRouter as Router, Route} from "react-router-dom";

import './css2.css';
import './bootstrap.min.css+font-awesome.min.css+elegant-icons.css+magnific-popup.css+nice-select.css+owl.carousel.min.css+slicknav.min.css+style.css.pagespeed.cc.BU1uaYcpbk.css';

import MainPage from "../mainPage";
import Catalog from "../catalog";
import {Provider} from "react-redux";
import store from "../../store";
import ViewProductDetails from "../viewProductDetails";
import CartRenderer from "../cartRenderer";
import WishlistRenderer from "../wishlistRenderer";
import Order from "../order";

const App = () => {
    return (
        <Provider store={store}>
            <Router>
                <Menu/>

                <Route path='/' component={MainPage} exact={true}/>

                <Route path='/catalog/:megaCategory?/:smallCategory?' component={({match}) => {

                    return <Catalog categories={match.params} />

                }} exact={true}/>

                <Route path='/item/:id' component={({match}) => {

                    return <ViewProductDetails productId={match.params.id}/>;

                }} exact={true}/>

                <Route path='/cart' component={CartRenderer}/>

                <Route path='/wishlist' component={WishlistRenderer}/>

                <Route path='/order' component={Order}/>

                <Footer/>
            </Router>


        </Provider>
    );
};

export default App;