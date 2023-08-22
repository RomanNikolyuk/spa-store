import React from 'react';
import ReactDOM from 'react-dom';

import App from "./components/app";
import RequestManagerContext from "./components/requestManagerContext";

import RequestManager from "./components/requestManager";

const requestManager = new RequestManager();


ReactDOM.render(
    <RequestManagerContext.Provider value={requestManager}>
        <App/>
    </RequestManagerContext.Provider>,
  document.getElementById('root')
);

console.log(`%cApplication Loaded Successfully. All components working correctly.`, `color: green;`);
console.log(`%cFrontend && Backend was developed by Roman Nikolyuk`, `font-size: 25px; background: yellow; color: black`)