/*
 * File: app/view/PayrollBatchUpdate.js
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

Ext.define('PayrollApp.view.PayrollBatchUpdate', {
    extend: 'Ext.form.Panel',
    alias: 'widget.payrollbatchupdate',

    requires: [
        'Ext.grid.Panel',
        'Ext.grid.View',
        'Ext.toolbar.Paging',
        'Ext.form.field.Text',
        'Ext.button.Button',
        'Ext.grid.column.CheckColumn',
        'Ext.form.field.Checkbox',
        'Ext.form.field.Display'
    ],

    frame: true,
    height: 693,
    layout: 'absolute',
    animCollapse: true,
    closable: true,
    collapsible: true,
    title: 'Payroll Batch Processing',

    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            items: [
                {
                    xtype: 'gridpanel',
                    x: 0,
                    y: 0,
                    height: 655,
                    itemId: 'empBatchpaytypes',
                    width: 425,
                    title: 'Payment Types',
                    store: 'PayTypeStore',
                    dockedItems: [
                        {
                            xtype: 'pagingtoolbar',
                            dock: 'bottom',
                            width: 360,
                            displayInfo: true,
                            store: 'PayTypeStore'
                        },
                        {
                            xtype: 'toolbar',
                            dock: 'top',
                            items: [
                                {
                                    xtype: 'textfield',
                                    itemId: 'txtSearchParams',
                                    width: 202,
                                    emptyText: 'Search by CatID or Pay Type'
                                },
                                {
                                    xtype: 'button',
                                    text: '<b>Search</b>'
                                }
                            ]
                        }
                    ],
                    columns: [
                        {
                            xtype: 'gridcolumn',
                            width: 49,
                            dataIndex: 'ID',
                            text: 'ID'
                        },
                        {
                            xtype: 'gridcolumn',
                            width: 48,
                            dataIndex: 'CatID',
                            text: 'CatID'
                        },
                        {
                            xtype: 'gridcolumn',
                            width: 282,
                            dataIndex: 'PayType',
                            text: 'PayType'
                        },
                        {
                            xtype: 'gridcolumn',
                            dataIndex: 'Fixed',
                            text: 'Fixed'
                        },
                        {
                            xtype: 'gridcolumn',
                            dataIndex: 'Contribution',
                            text: 'Contribution'
                        },
                        {
                            xtype: 'gridcolumn',
                            dataIndex: 'gl_acc',
                            text: 'Gl_acc'
                        },
                        {
                            xtype: 'gridcolumn',
                            dataIndex: 'gl_desc',
                            text: 'Gl_desc'
                        },
                        {
                            xtype: 'gridcolumn',
                            dataIndex: 'Posted',
                            text: 'Posted'
                        },
                        {
                            xtype: 'gridcolumn',
                            dataIndex: 'Interest',
                            text: 'Interest'
                        },
                        {
                            xtype: 'gridcolumn',
                            dataIndex: 'InterestCode',
                            text: 'InterestCode'
                        },
                        {
                            xtype: 'gridcolumn',
                            dataIndex: 'InterestName',
                            text: 'InterestName'
                        },
                        {
                            xtype: 'gridcolumn',
                            dataIndex: 'Recurrent',
                            text: 'Recurrent'
                        }
                    ]
                },
                {
                    xtype: 'gridpanel',
                    x: 430,
                    y: 90,
                    height: 565,
                    itemId: 'empPayGridDetail',
                    collapsible: true,
                    title: 'Employee Payments',
                    columnLines: true,
                    store: 'EmployeesBatchListStore',
                    dockedItems: [
                        {
                            xtype: 'pagingtoolbar',
                            dock: 'bottom',
                            width: 360,
                            displayInfo: true,
                            store: 'EmployeesBatchListStore'
                        },
                        {
                            xtype: 'toolbar',
                            dock: 'top',
                            items: [
                                {
                                    xtype: 'textfield',
                                    width: 277,
                                    blankText: 'Search by pid, empnames'
                                }
                            ]
                        }
                    ],
                    columns: [
                        {
                            xtype: 'checkcolumn',
                            width: 37,
                            text: ''
                        },
                        {
                            xtype: 'gridcolumn',
                            width: 54,
                            dataIndex: 'pid',
                            text: 'Pid'
                        },
                        {
                            xtype: 'gridcolumn',
                            width: 227,
                            dataIndex: 'empNames',
                            text: 'EmpNames'
                        },
                        {
                            xtype: 'gridcolumn',
                            dataIndex: 'payType',
                            text: 'PayType'
                        },
                        {
                            xtype: 'gridcolumn',
                            dataIndex: 'payName',
                            text: 'PayName'
                        },
                        {
                            xtype: 'gridcolumn',
                            align: 'right',
                            dataIndex: 'Amount',
                            text: 'Amount'
                        }
                    ]
                },
                {
                    xtype: 'checkboxfield',
                    x: 435,
                    y: 60,
                    boxLabel: 'Show All including with Empties'
                },
                {
                    xtype: 'displayfield',
                    x: 450,
                    y: 5,
                    itemId: 'selectedPayType',
                    width: 360,
                    name: 'selectedPayType',
                    fieldStyle: 'font-size: large;font-weight: bold;color: maroon;'
                },
                {
                    xtype: 'button',
                    x: 905,
                    y: 20,
                    height: 40,
                    itemId: 'cmdBatchPost',
                    width: 135,
                    text: '<b>Post Values</b>'
                },
                {
                    xtype: 'button',
                    x: 1045,
                    y: 20,
                    height: 40,
                    itemId: 'cmdBatchDelete',
                    width: 135,
                    text: '<b>Delete</b>'
                },
                {
                    xtype: 'textfield',
                    x: 655,
                    y: 60,
                    hidden: true,
                    itemId: 'txtSelectedPaytype',
                    name: 'txtSelectedPaytype'
                }
            ]
        });

        me.callParent(arguments);
    }

});