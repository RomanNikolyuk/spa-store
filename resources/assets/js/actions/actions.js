const catalogMenuRequested = () => {
    return {
        type: 'CATALOG_MENU_REQUESTED',
    };
};

const catalogMenuLoaded = (items) => {
    return {
        type: 'CATALOG_MENU_LOADED',
        payload: items
    };
};

const categorySelected = (categories) => {
    return {
        type: 'CATEGORY_SELECTED',
        payload: categories,
    }
};

const categoryRequested = () => {
    return {
        type: "CATEGORY_REQUESTED",
    };
};

const categoriesLoaded = (categories) => {
    return {
        type: "CATEGORIES_LOADED",
        payload: categories
    };
};

const filterPriceSelected = (filters) => {
    return {
        type: 'CATALOG_FILTER_PRICE',
        payload: filters
    };
}

const menuSelected = () => {
    return {
        type: 'MENU_SELECTED',
    }
};

/*** Тут саме Loading, не Requested, адже цей action викликається при переході на компонент ***/
const productDetailsLoading = () => {
    return {
        type: 'PRODUCT_DETAILS_LOADING'
    };
}

const productDetailsLoaded = (product) => {
    return {
        type: 'PRODUCT_DETAILS_LOADED',
        payload: product
    };
};

const productAddedToCart = () => {
    return {
        type: 'PRODUCT_ADDED_TO_CART',
    };
};

const cartProductsRequested = () => {
    return {
        type: 'CART_PRODUCTS_REQUESTED'
    };
}

const cartProductsLoaded = (products) => {
    return {
        type: 'CART_PRODUCTS_LOADED',
        payload: products
    };
};

const clearItems = () => {
    return {
        type: 'CLEAR_ITEMS'
    };
};

const wishlistRequested = () => {
    return {
        type: 'WISHLIST_REQUESTED'
    };
};

const wishlistLoaded = (products) => {
    return {
        type: 'WISHLIST_LOADED',
        payload: products
    };
};

const wishlistEmpty = () => {
    return {
        type: 'WISHLIST_EMPTY'
    };
};

const wishlistAdded = () => {
    return {
        type: 'WISHLIST_ADDED'
    };
};

const setTotalValue = (total) => {
    return {
        type: 'SET_TOTAL_VALUE',
        payload: total
    };
};

const slidersRequested = () => {
    return {
        type: 'SLIDERS_REQUESTED'
    };
};

const slidersLoaded = (payload) => {
    return {
        type: 'SLIDERS_LOADED',
        payload
    };
};

const mainPageProductsRequested = () => {
    return {
        type: 'MAIN_PAGE_PRODUCTS_REQUESTED'
    };
};

const mainPageProductsLoaded = (json) => {
    return {
        type: 'MAIN_PAGE_PRODUCTS_LOADED',
        payload: json
    };
};

const mainPageCategoriesRequested = () => {
    return {
        type: 'MAIN_PAGE_CATEGORIES_REQUESTED'
    };
};

const mainPageCategoriesLoaded = (json) => {
    return {
        type: 'MAIN_PAGE_CATEGORIES_LOADED',
        payload: json
    };
};


const menuCategoriesLoaded = (json) => {
    return {
        type: 'MENU_CATEGORIES_LOADED',
        payload: json
    };
};

const orderProductsRequested = () => {
    return {
        type: 'ORDER_PRODUCTS_REQUESTED',
    };
};

const orderProductsLoaded = (json) => {
    return {
        type: 'ORDER_PRODUCTS_LOADED',
        payload: json
    };
};

const orderSended = () => {
    return {
        type: 'ORDER_SENDED'
    };
};

const catalogUpdateItems = (json) => {
    return {
        type: 'CATALOG_UPDATE_ITEMS',
        payload: json
    };
};

const catalogSetOrderBy = (orderBy) => {
    return {
        type: 'CATALOG_SET_ORDER_BY',
        payload: orderBy
    };
};

const categoryChanged = (payload) => {
    return {
        type: 'CATEGORY_CHANGED',
        payload
    };
};

export {
    catalogMenuRequested,
    catalogMenuLoaded,
    categorySelected,
    categoryRequested,
    categoriesLoaded,
    filterPriceSelected,
    menuSelected,
    productDetailsLoading,
    productDetailsLoaded,
    productAddedToCart,
    cartProductsRequested,
    cartProductsLoaded,
    clearItems,
    wishlistRequested,
    wishlistLoaded,
    wishlistEmpty,
    wishlistAdded,
    setTotalValue,
    slidersRequested,
    slidersLoaded,
    mainPageProductsLoaded,
    mainPageProductsRequested,
    mainPageCategoriesLoaded,
    mainPageCategoriesRequested,
    menuCategoriesLoaded,
    orderProductsLoaded,
    orderProductsRequested,
    orderSended,
    catalogUpdateItems,
    catalogSetOrderBy,
    categoryChanged
};