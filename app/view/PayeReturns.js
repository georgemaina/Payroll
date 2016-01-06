/*
 * File: app/view/PayeReturns.js
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

Ext.define('PayrollApp.view.PayeReturns', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.payereturns',

    requires: [
        'Ext.grid.View',
        'Ext.toolbar.Paging',
        'Ext.form.field.ComboBox',
        'Ext.toolbar.Fill',
        'Ext.button.Button',
        'Ext.grid.column.Column'
    ],

    height: 577,
    width: 885,
    store: 'PayeReturnsStore',

    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            dockedItems: [
                {
                    xtype: 'pagingtoolbar',
                    dock: 'bottom',
                    width: 360,
                    displayInfo: true,
                    store: 'NhifReturnsStore'
                },
                {
                    xtype: 'toolbar',
                    dock: 'top',
                    height: 34,
                    items: [
                        {
                            xtype: 'combobox',
                            itemId: 'payeeMonth',
                            width: 294,
                            fieldLabel: 'Payroll Month',
                            labelAlign: 'right',
                            displayField: 'month',
                            queryMode: 'local',
                            store: 'PayMonthStore',
                            typeAhead: true,
                            valueField: 'ID'
                        },
                        {
                            xtype: 'tbfill'
                        },
                        {
                            xtype: 'button',
                            height: 31,
                            width: 164,
                            text: '<b>Print</b>'
                        },
                        {
                            xtype: 'button',
                            height: 23,
                            itemId: 'cmdExportPaye',
                            width: 118,
                            text: '<b>Export</b>'
                        }
                    ]
                }
            ],
            columns: [
                {
                    xtype: 'gridcolumn',
                    width: 61,
                    dataIndex: 'pid',
                    text: 'Pid'
                },
                {
                    xtype: 'gridcolumn',
                    width: 182,
                    dataIndex: 'empNames',
                    text: 'EmpNames'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'pay_type',
                    text: 'Pay_type'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'Amount',
                    text: 'Amount'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'ID_No',
                    text: 'ID_No'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'PinNo',
                    text: 'PinNo'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'payMonth',
                    text: 'PayMonth'
                }
            ]
        });

        me.callParent(arguments);
    }

});