class Wishlist {
    static onClick(id) {

        if (! this.isIn(id)) {
            if (localStorage.getItem('wishlist')) {
                const oldWishlist = JSON.parse(localStorage.getItem('wishlist'));

                if (! oldWishlist.find(idd => idd === id)) {
                    localStorage.setItem('wishlist', JSON.stringify([...oldWishlist, id]));
                }

            } else {

                localStorage.setItem('wishlist', JSON.stringify([id]));

            }

        } else {
            const wishlist = JSON.parse(localStorage.getItem('wishlist'));

            const newWishlist = wishlist.filter(idd => idd !== id);

            localStorage.setItem('wishlist', JSON.stringify(newWishlist));

        }
    }

    static isIn(id) {
        const items = JSON.parse(localStorage.getItem('wishlist'));

        /**
         * Якщо не створено,
         */
        if (! items) {
            localStorage.setItem('wishlist', '[]');

            return false;
        }

        return !!items.find(idd => id === idd);
    }
}

export default Wishlist;