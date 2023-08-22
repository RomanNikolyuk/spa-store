import RequestManagerContext from "../requestManagerContext";

function WithRequestManager() {
    return (Component) => {
        return (props) => {
            return (
                <RequestManagerContext.Consumer>
                    {
                        (RequestManager) => {
                            return <Component Request={RequestManager} {...props}/>
                        }
                    }
                </RequestManagerContext.Consumer>
            );
        }

    }
}


export default WithRequestManager;