/*
 * File: app/view/WelfareSavings.js
 * Date: Thu Aug 27 2015 13:42:07 GMT+0300 (E. Africa Standard Time)
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

Ext.define('PayrollApp.view.WelfareSavings', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.welfaresavings',

    requires: [
        'Ext.grid.View',
        'Ext.grid.column.Column',
        'Ext.toolbar.Paging'
    ],

    height: 650,
    closable: true,
    collapsible: true,
    title: 'Welfare Report',
    columnLines: true,
    store: 'WelfareStore',

    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            columns: [
                {
                    xtype: 'gridcolumn',
                    width: 66,
                    dataIndex: 'Pid',
                    text: 'Pid'
                },
                {
                    xtype: 'gridcolumn',
                    width: 214,
                    dataIndex: 'Names',
                    text: 'Names'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'Designation',
                    text: 'Designation'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'MonthlyContrib',
                    text: 'Monthly Contrib'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'Charges',
                    text: 'Charges'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'LoanRepayment',
                    text: 'Loan Repayment'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'Total',
                    text: 'Total'
                }
            ],
            dockedItems: [
                {
                    xtype: 'pagingtoolbar',
                    dock: 'bottom',
                    width: 360,
                    displayInfo: true,
                    store: 'WelfareStore'
                }
            ]
        });

        me.callParent(arguments);
    }

});