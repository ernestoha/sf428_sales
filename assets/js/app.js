
import React, { Component } from 'react';
import ReactDom from 'react-dom';
import Board from "./components/Sale";

class App extends Component {
    
    render() {
        console.log("App - Rendered");
        return (
            <Board />
        )
    }
}

ReactDom.render(<App />, document.getElementById('root'));