{
    "xdsVersion": "2.2.3",
    "frameworkVersion": "ext42",
    "internals": {
        "type": "Ext.app.Controller",
        "reference": {
            "name": "items",
            "type": "array"
        },
        "codeClass": null,
        "userConfig": {
            "models": [
                "Users"
            ],
            "views": [
                "loginform"
            ],
            "designer|userClassName": "Security",
            "designer|userAlias": "security"
        },
        "cn": [
            {
                "type": "fixedfunction",
                "reference": {
                    "name": "items",
                    "type": "array"
                },
                "codeClass": null,
                "userConfig": {
                    "fn": "init",
                    "designer|params": [
                        "application"
                    ],
                    "implHandler": [
                        "this.control({\r",
                        "    '#cmdLogin':{\r",
                        "        click:this.getLoginDetails\r",
                        "    },\r",
                        "    '#cmdCancelLogin':{\r",
                        "        click:this.closLogin\r",
                        "    }\r",
                        "});\r",
                        "\r",
                        "\r",
                        "this.listen({\r",
                        "\tglobal: {\r",
                        "        beforeloginwindowrender: this.processLoggedIn\r",
                        "     }\r",
                        "});"
                    ]
                }
            },
            {
                "type": "basicfunction",
                "reference": {
                    "name": "items",
                    "type": "array"
                },
                "codeClass": null,
                "userConfig": {
                    "fn": "doLogin",
                    "designer|params": [
                        "button",
                        "e",
                        "eOpts"
                    ],
                    "implHandler": [
                        "Ext.Msg.alert('test');"
                    ]
                }
            },
            {
                "type": "controllerref",
                "reference": {
                    "name": "items",
                    "type": "array"
                },
                "codeClass": null,
                "userConfig": {
                    "ref": "loginform",
                    "selector": "loginform",
                    "xtype": "loginform"
                }
            },
            {
                "type": "basicfunction",
                "reference": {
                    "name": "items",
                    "type": "array"
                },
                "codeClass": null,
                "userConfig": {
                    "fn": "dologout",
                    "designer|params": [
                        "button",
                        "e",
                        "eOpts"
                    ],
                    "implHandler": [
                        "Ext.Msg.alert('test');"
                    ]
                }
            },
            {
                "type": "basicfunction",
                "reference": {
                    "name": "items",
                    "type": "array"
                },
                "codeClass": null,
                "userConfig": {
                    "fn": "processLoggedIn",
                    "implHandler": [
                        "var me = this;\r",
                        "// make remote request to check session\r",
                        "\r",
                        "loginform= Ext.create('PayrollApp.view.LoginForm', {});\r",
                        "var loginWindow=Ext.create('Ext.window.Window', {\r",
                        "    title: 'Login window',\r",
                        "    animCollapse: true,\r",
                        "    collapsible: true,\r",
                        "    tools: [\r",
                        "    {\r",
                        "        xtype: 'tool',\r",
                        "        type: 'minimize'\r",
                        "    },\r",
                        "    {\r",
                        "        xtype: 'tool',\r",
                        "        type: 'maximize'\r",
                        "    }\r",
                        "    ]\r",
                        "});\r",
                        "\r",
                        "\r",
                        "Ext.Ajax.request({\r",
                        "    url: 'data/getDataFunctions.php?task=checkLogin',\r",
                        "    success: function( response, options ) {\r",
                        "        var result = Ext.decode( response.responseText );\r",
                        "        if( result.success ) {\r",
                        "            // has session...add to application stack\r",
                        "            LoggedInUser = Ext.create( 'PayrollApp.model.Users', result.data );\r",
                        "            // fire global event aftervalidateloggedin\r",
                        "            //Ext.globalEvents.fireEvent( 'aftervalidateloggedin' );\r",
                        "            loginform.close();\r",
                        "            Ext.create( 'PayrollApp.view.PayrollMain' );\r",
                        "            \r",
                        "        } \r",
                        "        // couldn't login...show error\r",
                        "        else {\r",
                        "            Ext.Msg.alert('Loging Error','Error trying to Login,Check our username and Password');\r",
                        "            loginWindow.add(loginform);\r",
                        "\t\t\tloginWindow.show();\r",
                        "        }\r",
                        "    },\r",
                        "    failure: function( response, options ) {\r",
                        "        Ext.Msg.alert( 'Attention', 'Sorry, an error occurred during your request. Please try again.' );\r",
                        "    }\r",
                        "});"
                    ]
                }
            },
            {
                "type": "basicfunction",
                "reference": {
                    "name": "items",
                    "type": "array"
                },
                "codeClass": null,
                "userConfig": {
                    "fn": "setupApplication",
                    "implHandler": [
                        "Ext.create( 'PayrollApp.view.PayrollMain' );\r",
                        "        "
                    ]
                }
            }
        ]
    },
    "linkedNodes": {},
    "boundStores": {},
    "boundModels": {}
}