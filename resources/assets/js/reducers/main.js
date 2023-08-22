const initialState = {
    loading: true,
    error: false,
    items: [],
    catalogPage: 1,
    catalogOrderBy: '',
    selectedCategory: '',
    categories: [],
    price: {
        from: '', to: ''
    },
    item: null,
    // Часом треба відререндерити клас, і тоді воно пригодиться
    rerender: true,
    total: 0,
    sliders: [],
    // Оскільки на одній сторінці рендериться 2 компоненти, що використовують items, для уникнення конфлікту використаємо нову змінну
    mainPageCategories: [],
    mainPageProducts: [],
    menuCategories: [],
    cartProducts: [],
    wishlistProducts: [],
    orderSended: false,
    cachedProducts: []
};

const reducer = (state = initialState, action) => {
    switch (action.type) {
        case 'CATALOG_MENU_REQUESTED':
            return {
                ...state, loading: true, rerender: !state.rerender
            };
        case 'CATALOG_MENU_LOADED':
            return {
                ...state, loading: false, items: [...state.items, ...action.payload], catalogPage: state.catalogPage + 1, cachedProducts: [...state.cachedProducts, ...action.payload]
            };
        case 'CATEGORY_SELECTED':
            return {
                ...state, selectedCategory: action.payload,
                catalogPage: 1, loading: false
            };
        case 'CATEGORY_CHANGED':
            return {
                ...state, items: [], catalogPage: 1, loading: true, selectedCategory: action.payload
            };
        case 'CATEGORY_REQUESTED':
            return {
                ...state, loading: true
            };
        case 'CATEGORIES_LOADED':
            return {
                ...state, categories: action.payload, loading: false
            };
        case 'CATALOG_FILTER_PRICE':
            return {
                ...state, items: [], loading: true, price: action.payload
            };
        case 'MENU_SELECTED':
            return {
                ...state,
                loading: true,
                price: initialState.price,
                catalogPage: initialState.catalogPage,
                selectedCategory: '',
                items: [],
                orderSended: false
            };
        case 'PRODUCT_DETAILS_LOADING':
            return {
                ...state, loading: true
            };
        case 'PRODUCT_DETAILS_LOADED':
            return {
                ...state, loading: false, item: action.payload, cachedProducts: [...state.cachedProducts, action.payload]
            };
        case 'PRODUCT_ADDED_TO_CART':
            return {
                ...state, rerender: !state.rerender
            };
        case "CART_PRODUCTS_REQUESTED":
            return {
                ...state, loading: true
            };
        case 'CART_PRODUCTS_LOADED':
            return {
                ...state, loading: false, cartProducts: action.payload.items, total: action.payload.total, cachedProducts: [...state.cachedProducts, ...action.payload.items]
            };
        case 'CLEAR_ITEMS':
            return {
                ...state, items: [], loading: true, catalogPage: 1, cartProducts: [], wishlistProducts: []
            };
        case 'WISHLIST_REQUESTED':
            return {
                ...state, loading: true
            };
        case 'WISHLIST_LOADED':
            return {
                ...state, loading: false, wishlistProducts: action.payload, cachedProducts: [...state.cachedProducts, ...action.payload]
            };

        case 'WISHLIST_ADDED':
            return {
                ...state, rerender: !state.rerender, loading: false,
            }
        case 'WISHLIST_EMPTY':
            return {
                ...state, items: [], rerender: !state.rerender, loading: false
            };
        case 'SET_TOTAL_VALUE':
            return {
                ...state, total: action.payload
            };
        case 'SLIDERS_REQUESTED':
            return {
                ...state, loading: true
            };
        case 'SLIDERS_LOADED':
            return {
                ...state, sliders: action.payload, loading: false
            };

        case 'MAIN_PAGE_PRODUCTS_REQUESTED':
            return {
                ...state, loading: true
            };
        case 'MAIN_PAGE_PRODUCTS_LOADED':
            return {
                ...state, loading: false, mainPageProducts: action.payload, cachedProducts: [...state.cachedProducts, ...action.payload]
            }
        case 'MAIN_PAGE_CATEGORIES_REQUESTED':
            return {
                ...state, loading: true
            };

        case 'MAIN_PAGE_CATEGORIES_LOADED':
            return {
                ...state, loading: false, mainPageCategories: action.payload
            };

        case 'MENU_CATEGORIES_LOADED':
            return {
                ...state, menuCategories: action.payload
            };
        case 'ORDER_PRODUCTS_REQUESTED':
            return {
                ...state, loading: true
            };
        case 'ORDER_PRODUCTS_LOADED':
            return {
                ...state, items: action.payload, loading: false,
            };
        case 'ORDER_SENDED':
            return {
                ...state, orderSended: true
            };
        case 'CATALOG_UPDATE_ITEMS':
            return {
                ...state, items: action.payload, loading: false, catalogPage: 2
            };
        case 'CATALOG_SET_ORDER_BY':
            return {
                ...state, catalogOrderBy: action.payload,
            };
        default:
            return state;
    }
};

export default reducer;