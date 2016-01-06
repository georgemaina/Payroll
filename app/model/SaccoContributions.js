/*
 * File: app/model/SaccoContributions.js
 * Date: Thu Aug 27 2015 10:06:40 GMT+0300 (E. Africa Standard Time)
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

Ext.define('PayrollApp.model.SaccoContributions', {
    extend: 'Ext.data.Model',
    alias: 'model.saccocontributions',

    requires: [
        'Ext.data.Field'
    ],

    fields: [
        {
            name: 'Pid'
        },
        {
            name: 'Names'
        },
        {
            name: 'MemberNo'
        },
        {
            name: 'MonthlyContribution'
        },
        {
            name: 'Insurance'
        },
        {
            name: 'Repayment'
        },
        {
            name: 'Total'
        }
    ]
});