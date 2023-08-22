import React from 'react';

const Breadcrumbs = ({pageName, links}) => {
    let id = 0;

    return (

        <section className="breadcrumb-option">
            <div className="container">
                <div className="row">
                    <div className="col-lg-12">
                        <div className="breadcrumb__text">
                            <h4>{pageName}</h4>
                            <div className="breadcrumb__links">
                                {
                                    links.map(link =>
                                        <a key={++id} href={link.href}>{link.title}</a>
                                    )
                                }
                                <span>{pageName}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    );
};

export default Breadcrumbs;