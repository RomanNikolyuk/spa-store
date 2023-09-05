import { Helmet } from 'react-helmet';

import MainPageCategories from '../mainPageCategories';
import MainPageProducts from '../mainPageProducts';
import Slider from '../slider';

const MainPage = () => {
    return (
        <>
            <Helmet>
                <title>Магазин церковних товарів в Україні Дзвін</title>
                <meta
                    name="description"
                    content="Магазин Дзвін із офісом у Луцьку, доставкою по Україні та з великим досвідом роботи запрошує Вас"
                />
                <meta
                    name="keywords"
                    content="Луцьк церковні товари, церковна крамниця Луцьк, церковна крамниця Україна, купити знаряддя для церкви, Луцк церковные товары, церковная лавка Луцк, церковная лавка Украина, купить орудия для церкви, магазин Дзвін"
                />
                <meta
                    name="viewport"
                    content="width=device-width, initial-scale=1.0"
                />

            </Helmet>

            <Slider />

            <MainPageProducts />

            <MainPageCategories />
        </>
    );
};

export default MainPage;
