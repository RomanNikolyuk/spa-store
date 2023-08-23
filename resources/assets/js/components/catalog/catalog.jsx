import React, {Component} from 'react';
import Breadcrumbs from "../breadcrumbs";
import CatalogSitebar from "../catalogSitebar";
import CatalogRenderProducts from "../catalogRenderProducts";

import {categorySelected, categoryChanged} from "../../actions/actions";

import {connect} from 'react-redux';

import {Helmet} from "react-helmet";

class Catalog extends Component {

    getLastCategoryAlias() {
        const {categories} = this.props;
        let lastCategoryAlias = '';

        for (let key in categories) {
            if (categories[key]) {
                lastCategoryAlias = categories[key];
            }
        }

        return lastCategoryAlias;
    }


    componentDidUpdate(prevProps, prevState) {

        if (this.props.categories !== prevProps.categories) {
            this.props.categoryChanged(this.getLastCategoryAlias());
        }

    }

    componentDidMount() {
        this.props.categorySelected(this.getLastCategoryAlias());
    }


    render() {

        return (
            <>
                <Helmet>
                    <title>Каталог товарів | Магазин церковних товарів в Україні Дзвін</title>

                    <meta name='description' content='Каталог товарів у <strong>найстарішому магазині церковних</strong> товарів в Україні. Оберіть все, що бажає Ваша душа'/>
                    <meta name='keywords' content={`купити товари для церкви, купить товары для цервки, церковне знаряддя, церковні товари`}/>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                </Helmet>

                <Breadcrumbs pageName='Каталог' links={[{href: '/', title: 'Домашня'}]}/>

                <section className="shop spad">
                    <div className="container">
                        <div className="row">

                            <CatalogSitebar/>

                            <CatalogRenderProducts/>

                        </div>
                    </div>
                </section>
            </>
        );
    }
}

const mapStateToProps = (state) => {
    return {
        loading: state.loading,
        selectedCategory: state.selectedCategory
    }
};

export default connect(mapStateToProps, {categorySelected, categoryChanged})(Catalog);