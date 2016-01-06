/*
 * File: app/store/EmployeesBatchListStore.js
 * Date: Sun Mar 08 2015 15:46:55 GMT+0300 (E. Africa Standard Time)
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

Ext.define('PayrollApp.store.EmployeesBatchListStore', {
    extend: 'Ext.data.Store',
    alias: 'store.employeesbatchliststore',

    requires: [
        'PayrollApp.model.EmployeesBatchList',
        'Ext.data.proxy.Ajax',
        'Ext.data.reader.Json'
    ],

    constructor: function(cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
            autoLoad: false,
            model: 'PayrollApp.model.EmployeesBatchList',
            storeId: 'EmployeesBatchListStore',
            proxy: {
                type: 'ajax',
                url: 'data/getDataFunctions.php?task=getEmployeesBatchlist',
                reader: {
                    type: 'json',
                    root: 'BatchEmployeesList'
                }
            }
        }, cfg)]);
    }
});