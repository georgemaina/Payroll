/*
 * File: app/model/UserRoles.js
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

Ext.define('PayrollApp.model.UserRoles', {
    extend: 'Ext.data.Model',
    alias: 'model.userroles',

    requires: [
        'Ext.data.Field'
    ],

    fields: [
        {
            name: 'Role'
        },
        {
            name: 'View'
        },
        {
            name: 'Edit'
        },
        {
            name: 'Delete'
        }
    ]
});