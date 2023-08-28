import { Provider } from 'react-redux';
import { Route, BrowserRouter as Router, Routes, useParams } from 'react-router-dom';

import store from '../../store';
import CartRenderer from '../cartRenderer';
import Catalog from '../catalog';
import Footer from '../layouts/footer';
import Menu from '../layouts/menu';
import MainPage from '../mainPage';
import Order from '../order';
import ViewProductDetails from '../viewProductDetails';
import WishlistRenderer from '../wishlistRenderer';

function CatalogWrapper() {
    const { megaCategory, smallCategory } = useParams();
    return <Catalog categories={ { megaCategory, smallCategory } } />;
}

function ViewProductDetailsWrapper() {
    const { id } = useParams();
    return <ViewProductDetails productId={ id } />;
}

const App = () => {
    return (
        <Provider store={ store }>
            <Router>
                <Menu />
                <Routes>
                    <Route
                        path="/"
                        element={ <MainPage /> }
                    />
                    <Route
                        path="/catalog/:megaCategory?/:smallCategory?"
                        element={ <CatalogWrapper /> }
                    />
                    <Route
                        path="/item/:id"
                        element={ <ViewProductDetailsWrapper /> }
                    />
                    <Route
                        path="/cart"
                        element={ <CartRenderer /> }
                    />
                    <Route
                        path="/wishlist"
                        element={ <WishlistRenderer /> }
                    />
                    <Route
                        path="/order"
                        element={ <Order /> }
                    />
                </Routes>
                <Footer />
            </Router>
        </Provider>
    );
};

export default App;
