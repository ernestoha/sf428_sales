import React, { Component } from 'react';
import Input from '../components/Input';
import Select from '../components/Select';

class Sale extends React.Component {
    constructor(props) {
        super(props);
        console.log("App - Constructor Sale -> PROPS -> ", this.props);
    }
    render() {
        const { stylesLcl, sale, onSaleDel } = this.props;
        return (
            <div>
                <div style={stylesLcl.styles}>{sale.date}</div>
                <div style={stylesLcl.styles}>{sale.product}</div>
                <div style={stylesLcl.styles}>{sale.amount}</div>
                <button style={stylesLcl.btnStyles} onClick={() => onSaleDel(sale.id)} className="btn btn-secondary btn-sm">
                    {'Del'}
                </button>
            </div>
        )
    }
}

class Sales extends React.Component {
    styles = {
        //for test purpouses
        width: "150px",
        fontSize: "14px",
        display: "inline-block"
    };
    btnStyles = {
        //for test purpouses
        marginTop: "2px"
    };
    render() {
        const { sales, onSaleDel } = this.props;
        const stylesLcl = { //for test purpouses
            styles: this.styles,
            btnStyles: this.btnStyles
        }
        const salesTitle = [
            'Date',
            'Product',
            'Mount',
            'Acc',
        ];
        return (
            <div id="salesGroup">
                <div>{('-').repeat(70)}</div>
                <div id="title">
                    <div>
                        {salesTitle.map((title, index) => (
                            <div key={index} style={this.styles}><b>{title}</b></div>
                        ))}
                    </div>
                </div>
                
                <div>{('-').repeat(70)}</div>
                <div id="rows">
                    {sales.map(sale => (
                        <Sale
                            stylesLcl = {stylesLcl}
                            key={sale.id}
                            sale={sale}
                            onSaleDel={onSaleDel}
                        />
                    ))}
                </div>
                <div>{('-').repeat(70)}</div>
            </div>
        )
    }
}

class SalesNew extends React.Component {
    constructor(props) {
        super(props);
        console.log("App - Constructor SalesNew -> PROPS -> ", this.props);
    }

    render() {
        const { sale, productList, doChange, doSubmit } = this.props;
        return (
            <form onSubmit={doSubmit}>

                <Select title={'Product'}
                    name={'product'}
                    options={productList}
                    value={sale.product}
                    placeholder={'--Select--'}
                    doChange={() => doChange(event)}
                />

                <Input name={'amount'} title="Amount" value={sale.amount} doChange={() => doChange(event)}
                    placeholder="Search..." defaultValue="Search..."
                />

                <div className="form-group">
                    <button type="submit" className="btn btn-secondary btn-sm" >Make Sale</button>
                </div>

            </form>
        );
    }
}

class Board extends React.Component {

    constructor(props) {
        super(props);
        console.log("App - Constructor -> PROPS -> ", this.props);
        this.state = {
            sale: {
                id: null,
                date: '',
                product: '',
                amount: ''
            },
            sales: [
                { id: 1, date:'2019-01-01 21:23:01', product: 'Router', amount: 123 },
                { id: 2, date:'2019-01-01 21:23:03', product: 'SIM Card', amount: 12 },
                { id: 3, date:'2019-01-01 21:23:04', product: 'Router', amount: 43 },
                { id: 4, date:'2019-01-01 21:23:05', product: 'Server', amount: 1 }
            ]
        };
        this.handleChange = this.handleChange.bind(this);//Sale: New & Update 
        this.handleNewSubmit = this.handleNewSubmit.bind(this); //Sales: New Submit
        //this.handleSaleDel = this.handleSaleDel.bind(this); //Sale: Del
    }

    //setSale = sale => this.setState({ sale });

    handleSaleDel = saleId => {
        // console.log(saleId);
        // alert('delete sale');
        const sales = this.state.sales.filter(c => c.id !== saleId);
        this.setState({ sales }); //Save value and render in DOM (refresh)
    }

    handleChange(event) {
        let value = event.target.value;
        let name = event.target.name;
        this.setState(prevState => {
            return {
                sale: {
                    ...prevState.sale, [name]: value
                }
            }
        }, () => console.log({ 'val': this.state.sale })
        )
    }

    handleNewSubmit(event) {
        console.log('submit');
        const sale =  this.state.sale;
        const sales = [...this.state.sales]; // to clone obj
        // const index = this.state.sales.length;//sales.indexOf(sale);
        const index = this.state.sales.length;//sales.indexOf(sale);
        while(!(typeof sales[index] === 'undefined')) {
            // does exist index in sales
            index++;
        }

        console.log({index : index});
        //sale.key = index;
//        sale.id = this.state.sales[index].id+1;
        sale.id = index+1;
        while (!(sales.find(o => o.id === sale.id ) === undefined)){
            // does exist sale.id in sales
            sale.id++;
        }
        sale.date = "2020-02-02 20:20:0"+index.toString().substr(-1);
        sales[index] = { ...sale };
        //sales[index].value++;
        console.log(sale);
        console.log(sales);

        this.setState({ sale });
        this.setState({ sales }); //Save value and render in DOM (refresh)

        event.preventDefault();
    }

    render() {
        const title = 'Sales React';

        return (
            <div>
                <div>
                    <h3 className="title">{title}</h3>
                </div>

                <div>{('*').repeat(100)}</div>

                <SalesNew
                    sale={this.state.sales}
                    productList={['Router', 'Mobile Phone', 'SIM Card', 'Server']}
                    doChange={this.handleChange}
                    doSubmit={this.handleNewSubmit}
                />

                <div>{('*').repeat(100)}</div>

                <Sales
                    sales={this.state.sales}
                    onSaleDel={this.handleSaleDel}
                />

            </div>
        )
    }

    componentDidMount() {
        //after render to the dom
        console.log("App Board - Mounted");
        //Ajax Call and then get data from server this.setStates({movies})
    }
}

export default Board;