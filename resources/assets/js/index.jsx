import ReactDOM from 'react-dom';

import App from './components/app';
import RequestManager from './components/requestManager/requestManager';
import RequestManagerContext from './components/requestManagerContext';

const requestManager = new RequestManager();

ReactDOM.render(
    <RequestManagerContext.Provider value={ requestManager }>
        <App />
    </RequestManagerContext.Provider>,
    document.getElementById('root')
);
