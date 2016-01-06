/*
 * File: app/view/EarningsGrid.js
 * Date: Sun Mar 08 2015 15:46:52 GMT+0300 (E. Africa Standard Time)
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

Ext.define('PayrollApp.view.EarningsGrid', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.earningsgrid',

    requires: [
        'Ext.grid.View',
        'Ext.toolbar.Paging',
        'Ext.form.field.ComboBox',
        'Ext.toolbar.Fill',
        'Ext.button.Button',
        'Ext.grid.column.Column'
    ],

    height: 650,
    animCollapse: true,
    closable: true,
    collapsible: true,
    title: 'Earnings Report',
    store: 'EarningStore',

    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            dockedItems: [
                {
                    xtype: 'pagingtoolbar',
                    dock: 'bottom',
                    width: 360,
                    displayInfo: true,
                    store: 'PayrollPostingStore'
                },
                {
                    xtype: 'toolbar',
                    dock: 'top',
                    height: 31,
                    items: [
                        {
                            xtype: 'combobox',
                            itemId: 'PaymentType',
                            width: 324,
                            fieldLabel: 'Pay Type',
                            labelAlign: 'right',
                            displayField: 'PayType',
                            minChars: 2,
                            queryMode: 'local',
                            store: 'PayTypeStore',
                            typeAhead: true,
                            valueField: 'ID'
                        },
                        {
                            xtype: 'tbfill'
                        },
                        {
                            xtype: 'button',
                            height: 23,
                            width: 117,
                            text: '<b>Print</b>'
                        },
                        {
                            xtype: 'button',
                            height: 23,
                            itemId: 'cmdExportEarnings',
                            width: 129,
                            text: '<b>Export to Excel</b>'
                        }
                    ]
                }
            ],
            columns: [
                {
                    xtype: 'gridcolumn',
                    width: 53,
                    dataIndex: 'PID',
                    text: 'Pid'
                },
                {
                    xtype: 'gridcolumn',
                    width: 224,
                    dataIndex: 'EmpNames',
                    text: 'EmpNames'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'Category',
                    text: 'CatID'
                },
                {
                    xtype: 'gridcolumn',
                    width: 171,
                    dataIndex: 'PayType',
                    text: 'PayType'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'Amount',
                    text: 'Amount'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'Balance',
                    text: 'Balance'
                }
            ]
        });

        me.callParent(arguments);
    }

});