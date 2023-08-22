class RequestManager {
    _api = '/api/';

    getAllProducts(page, category, orderBy = '') {
        return this._sendRequest('products?page=' + page + '&category=' + category + '&order_by=' + orderBy);
    }

    getMainPageProducts() {
        return this._sendRequest('main-page-products');
    }

    getCategories(parentCategory) {
        return this._sendRequest('get-children-categories?parent_category=' + parentCategory);
    }

    getProduct(id) {
        return this._sendRequest('product?id=' + id);
    }

    getSliders() {
        return this._sendRequest('sliders');
    }

    getMainPageCategories() {
        return this._sendRequest('main-page-categories');
    }

    searchItems(input) {
        return this._sendRequest('products?q=' + input);
    }

    async _sendRequest(url) {
        const data = await fetch(this._api + url);

        return await data.json();
    }

    sendOrder(url) {
        fetch(this._api + 'order' + url);
    }
}

export default RequestManager;