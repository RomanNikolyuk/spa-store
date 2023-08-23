import React, {Component} from 'react';

import {Link} from 'react-router-dom';
import {connect} from 'react-redux';
import WithRequestManager from "../withRequestManager";

import {categoriesLoaded, categoryRequested, filterPriceSelected, catalogUpdateItems, catalogMenuRequested} from "../../actions/actions";

class CatalogSitebar extends Component {
    constructor(props) {
        super(props);

        this.searchItems = this.searchItems.bind(this);
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (this.props.selectedCategory !== prevProps.selectedCategory) {
            this.props.Request.getCategories(this.props.selectedCategory).then(json => {
                this.props.categoriesLoaded(json);
            });
        }
    }


    componentDidMount() {
        this.props.categoryRequested();

        this.props.Request.getCategories(this.props.selectedCategory).then(json => {
            this.props.categoriesLoaded(json);
        });

    }

    searchItems(event) {
        this.props.catalogMenuRequested();

        const input = event.target.value;

        this.props.Request.searchItems(input).then(json => {

            this.props.catalogUpdateItems(json);
        });
    }

    render() {
        const {categories} = this.props;


        return (
            <div className="col-lg-3">
                <div className="shop__sidebar">
                    <div className="shop__sidebar__search">
                        <form>
                            <input type="text" placeholder="Пошук..." onChange={this.searchItems}/>
                        </form>

                    </div>
                    <div className="shop__sidebar__accordion">
                        <div className="accordion" id="accordionExample">

                            <RenderCategoriesCard categories={categories}/>

                            {/*<RenderPriceFilterCard priceFilterSelected={this.priceFilterSelected}/>*/}

                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

const RenderCategoriesCard = ({categories}) => {

    if (categories.length === 0) {
        return null;
    }


    return (
        <div className="card">
            <div className="card-heading">
                <a data-toggle="collapse" data-target="#collapseOne">Категорії</a>
            </div>
            <div id="collapseOne" className="collapse show" data-parent="#accordionExample">
                <div className="card-body">
                    <div className="shop__sidebar__categories">
                        <ul className="nice-scroll">
                            {
                                categories.map(category => {
                                    const {id, title, alias} = category;

                                    return <li key={id}><Link
                                        to={location => {
                                            let lastIndex = location.pathname.length - 1;

                                            if (location.pathname[lastIndex] === '/') {
                                                return location.pathname + alias;
                                            }

                                            return location.pathname + '/' + alias;
                                        }}>{title}</Link></li>;
                                })
                            }
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    );
};


const RenderPriceFilterCard = ({priceFilterSelected}) => {
    return (
        <div className="card">
            <div className="card-heading">
                <a data-toggle="collapse" data-target="#collapseThree">Фільтр за ціною</a>
            </div>
            <div id="collapseThree" className="collapse show"
                 data-parent="#accordionExample">
                <div className="card-body">
                    <div className="shop__sidebar__price">
                        <ul onClick={priceFilterSelected}>
                            <li><a href="#" data-from={0} data-to={3000}>₴0.00 - ₴3000.00</a></li>
                            <li><a href="#" data-from={3000} data-to={5000}>₴3000.00 - ₴5000.00</a></li>
                            <li><a href="#" data-from={5000} data-to={10000}>₴5000.00 - ₴10000.00</a></li>

                            <li><a href="#" data-from={10000} data-to={999999}>₴10000.00+</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    );
};

const mapDispatchToProps = (state) => {
    return {
        selectedCategory: state.selectedCategory,
        categories: state.categories,
        loading: state.loading,
    };
};

export default WithRequestManager()(connect(mapDispatchToProps, {
    categoryRequested,
    categoriesLoaded,
    filterPriceSelected,
    catalogUpdateItems,
    catalogMenuRequested
})(CatalogSitebar));