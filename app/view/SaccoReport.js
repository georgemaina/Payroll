/*
 * File: app/view/SaccoReport.js
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

Ext.define('PayrollApp.view.SaccoReport', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.saccoreport',

    requires: [
        'Ext.grid.View',
        'Ext.grid.column.Column',
        'Ext.toolbar.Paging'
    ],

    height: 650,
    closable: true,
    collapsible: true,
    title: 'Sacco Reports',
    columnLines: true,
    store: 'SaccoContributionStore',

    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            columns: [
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'Pid',
                    text: 'Pid'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'Names',
                    text: 'Names'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'MemberNo',
                    text: 'Member No'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'MonthlyContribution',
                    text: 'Monthly Contribution'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'Insurance',
                    text: 'Insurance'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'Repayment',
                    text: 'Repayment'
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
                    store: 'SaccoContributionStore'
                }
            ]
        });

        me.callParent(arguments);
    }

});