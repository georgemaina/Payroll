/*
 * File: app/model/PayRates.js
 * Date: Sun Mar 08 2015 15:46:56 GMT+0300 (E. Africa Standard Time)
 *
 * This file was generated by Sencha Architect version 3.2.0.
 * http://www.sencha.com/products/architect/
 *
 * This file requires use of the Ext JS 4.2.x library, under independent license.
 * License of Sencha Architect does not include license for Ext JS 4.2.x. For more
 * details see http://www.sencha.com/license or contact license@sencha.com.
 *
 * This file will be auto-generated each and everytime you save your project.
 *
 * Do NOT hand edit this file.
 */

Ext.define('PayrollApp.model.PayRates', {
    extend: 'Ext.data.Model',
    alias: 'model.payrates',

    requires: [
        'Ext.data.Field'
    ],

    fields: [
        {
            name: 'ID'
        },
        {
            name: 'RateName'
        },
        {
            name: 'Value'
        },
        {
            name: 'Lower_Limit'
        },
        {
            name: 'Upper_Limit'
        },
        {
            name: 'Rate'
        }
    ]
});