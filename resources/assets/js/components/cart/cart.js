class Cart {
    static isInCart(id) {
        const cart = JSON.parse(localStorage.getItem('cart'));

        if (!cart) {
            localStorage.setItem('cart', '[]');
            return false;
        }

        return !!cart.find(idd => idd === id);
    }

    static onClickOnCart(id) {

        if (!this.isInCart(id)) {
            if (localStorage.getItem('cart')) {
                const oldCart = JSON.parse(localStorage.getItem('cart'));

                if (!oldCart.find(idd => idd === id)) {
                    localStorage.setItem('cart', JSON.stringify([...oldCart, id]));
                }

            } else {

                localStorage.setItem('cart', JSON.stringify([id]));

            }


        } else {
            const cart = JSON.parse(localStorage.getItem('cart'));

            const newCart = cart.filter(idd => idd !== id);

            localStorage.setItem('cart', JSON.stringify(newCart));
        }

    }


}

export default Cart;