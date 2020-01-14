import React, { Component } from 'react';

const Input = (props) => {
    return (  
  <div className="form-group">
    <label htmlFor={props.name} className="form-label">{props.title}</label>
    <input
      className="form-input"
      id={props.name}
      name={props.name}
      required
      type={props.type}
      value={props.value}
      onChange={props.doChange}
      placeholder={props.placeholder} 
    />
  </div>
)
}

export default Input;